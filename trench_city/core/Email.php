<?php
/**
 * ================================================================
 * EMAIL SERVICE CLASS
 * Trench City V2
 * ================================================================
 *
 * Handles email sending with SMTP or fallback to PHP mail()
 */

class Email {
    private $db;
    private $config = [];
    private $lastError = '';

    public function __construct() {
        $this->db = getDB();
        $this->loadConfig();
    }

    /**
     * Load email configuration from database
     */
    private function loadConfig(): void {
        $configs = $this->db->fetchAll("SELECT config_key, config_value FROM email_config");

        foreach ($configs as $config) {
            $this->config[$config['config_key']] = $config['config_value'];
        }

        // Override/seed from .env so ops can control delivery without DB edits
        $envMap = [
            'smtp_enabled'      => fn() => (getenv('EMAIL_DRIVER') === 'smtp') ? 'true' : null,
            'smtp_host'         => fn() => getenv('SMTP_HOST') ?: null,
            'smtp_port'         => fn() => getenv('SMTP_PORT') ?: null,
            'smtp_username'     => fn() => getenv('SMTP_USER') ?: null,
            'smtp_password'     => fn() => getenv('SMTP_PASS') ?: null,
            'smtp_encryption'   => fn() => getenv('SMTP_ENCRYPTION') ?: null,
            'from_email'        => fn() => getenv('EMAIL_FROM_ADDRESS') ?: null,
            'from_name'         => fn() => getenv('EMAIL_FROM_NAME') ?: null,
        ];

        foreach ($envMap as $key => $getter) {
            $val = $getter();
            if ($val !== null && $val !== '') {
                $this->config[$key] = $val;
            }
        }
    }

    /**
     * Get configuration value
     */
    public function getConfig(string $key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    /**
     * Get last transport error (if any)
     */
    public function getLastError(): string {
        return $this->lastError;
    }

    /**
     * Send email
     */
    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $this->lastError = '';
        $smtpEnabled = ($this->config['smtp_enabled'] ?? 'false') === 'true';

        $sent = $smtpEnabled
            ? $this->sendViaSMTP($to, $subject, $htmlBody, $textBody)
            : $this->sendViaPHPMail($to, $subject, $htmlBody, $textBody);

        if (!$sent && $this->lastError === '') {
            $this->lastError = 'Unknown transport failure';
        }

        return $sent;
    }

    /**
     * Send via SMTP (using PHPMailer or similar)
     */
    private function sendViaSMTP(string $to, string $subject, string $htmlBody, string $textBody): bool {
        // Check if PHPMailer is available
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $this->lastError = 'PHPMailer not available; falling back to mail()';
            tc_log("[EMAIL] {$this->lastError}", 'warn');
            return $this->sendViaPHPMail($to, $subject, $htmlBody, $textBody);
        }

        $primaryEnc  = $this->config['smtp_encryption'] ?? 'tls';
        $primaryPort = (int)($this->config['smtp_port'] ?? 587);

        $attempts = [
            ['enc' => $primaryEnc, 'port' => $primaryPort],
        ];

        // Automatic fallback to SSL:465 if TLS:587 fails
        if ($primaryEnc === 'tls' && $primaryPort === 587) {
            $attempts[] = ['enc' => 'ssl', 'port' => 465];
        }

        foreach ($attempts as $attempt) {
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = $this->config['smtp_host'] ?? 'smtp.gmail.com';
                $mail->Username = $this->config['smtp_username'] ?? '';
                $mail->Password = $this->config['smtp_password'] ?? '';
                $mail->Port = (int)$attempt['port'];
                $mail->SMTPAutoTLS = true;

                if ($attempt['enc'] === 'ssl') {
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                } elseif ($attempt['enc'] === 'tls') {
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                }

                $mail->setFrom(
                    $this->config['from_email'] ?? 'noreply@trenchcity.com',
                    $this->config['from_name'] ?? 'Trench City'
                );
                $mail->addAddress($to);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $htmlBody;
                $mail->AltBody = $textBody ?: strip_tags($htmlBody);

                $mail->send();
                return true;
            } catch (Exception $e) {
                $this->lastError = $e->getMessage();
                tc_log("[EMAIL] SMTP send failed ({$attempt['enc']}:{$attempt['port']}) to={$to}: {$e->getMessage()}", 'error');
            }
        }

        return false;
    }

    /**
     * Send via PHP mail() function (fallback)
     */
    private function sendViaPHPMail(string $to, string $subject, string $htmlBody, string $textBody): bool {
        $fromEmail = $this->config['from_email'] ?? 'noreply@trenchcity.com';
        $fromName = $this->config['from_name'] ?? 'Trench City';

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            "From: {$fromName} <{$fromEmail}>",
            "Reply-To: {$fromEmail}",
            'X-Mailer: PHP/' . phpversion()
        ];

        $success = mail($to, $subject, $htmlBody, implode("\r\n", $headers));

        if (!$success) {
            $this->lastError = "PHP mail() failed to send email to {$to}";
            tc_log("[EMAIL] {$this->lastError}", 'error');
        } else {
            tc_log("[EMAIL] mail() sent to {$to}", 'info');
        }

        return $success;
    }

    /**
     * Send verification email
     */
    public function sendVerificationEmail(int $userId, string $email, string $token, string $username = 'Player'): bool {
        $appUrl = getenv('APP_URL') ?: (defined('APP_URL') ? APP_URL : 'http://localhost');
        $verificationUrl = rtrim($appUrl, '/') . '/verify-email.php?token=' . urlencode($token);
        $logoUrl = rtrim($appUrl, '/') . '/assets/imgs/logo_light.png';
        $cynoImageUrl = rtrim($appUrl, '/') . '/assets/imgs/cyno_npc.png';

        $htmlBody = $this->getVerificationEmailHTML($verificationUrl, $username, $logoUrl, $cynoImageUrl);
        $textBody = $this->getVerificationEmailText($verificationUrl, $username);

        $sent = $this->send($email, 'Verify Your Trench City Account', $htmlBody, $textBody);

        if ($sent) {
            // Log the send (best-effort; don't block on missing table)
            try {
                $this->db->execute(
                    "
                    INSERT INTO email_verification_logs (user_id, email, token, ip_address, user_agent)
                    VALUES (:user_id, :email, :token, :ip, :agent)
                ",
                    [
                        'user_id' => $userId,
                        'email' => $email,
                        'token' => $token,
                        'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                        'agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
                    ]
                );
            } catch (Throwable $e) {
                error_log("[EMAIL] Log write skipped: " . $e->getMessage());
            }
        } else {
            $err = $this->lastError ?: 'unknown transport failure';
            tc_log("[EMAIL] Verification email send failed user_id={$userId} email={$email}: {$err}", 'error');
        }

        return $sent;
    }

    /**
     * Get verification email HTML template
     */
    private function getVerificationEmailHTML(string $verificationUrl, string $username, string $logoUrl, string $cynoImageUrl): string {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Trench City</title>
</head>
<body style="margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#1a1a1a;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#1a1a1a;">
        <tr>
            <td align="center" style="padding:30px 15px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#2b2b2b;border:1px solid #3a3a3a;border-radius:4px;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:25px 30px;background:#1f1f1f;border-bottom:2px solid #D4AF37;">
                            <img src="{$logoUrl}" alt="Trench City" style="height:50px;display:block;margin:0 auto;" />
                            <p style="margin:8px 0 0 0;color:#888;font-size:12px;letter-spacing:0.5px;">THE STREETS ARE CALLING</p>
                        </td>
                    </tr>

                    <!-- Cyno Image -->
                    <tr>
                        <td align="center" style="padding:30px 30px 0 30px;background:#2b2b2b;">
                            <img src="{$cynoImageUrl}" alt="Cyno" style="width:120px;height:120px;border-radius:50%;border:3px solid #D4AF37;display:block;margin:0 auto;" />
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding:20px 40px 30px 40px;background:#2b2b2b;">
                            <p style="margin:0 0 20px 0;color:#D4AF37;font-size:16px;font-weight:600;">
                                Alright {$username},
                            </p>

                            <p style="margin:0 0 16px 0;color:#d1d1d1;font-size:14px;line-height:1.7;">
                                Welcome to Trench City.<br>
                                Before you're fully in, you need to verify your email and activate your account using the button below.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:25px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{$verificationUrl}" style="display:inline-block;padding:14px 40px;background:#D4AF37;color:#000;text-decoration:none;font-weight:700;font-size:14px;border-radius:3px;text-transform:uppercase;letter-spacing:0.5px;">
                                            Verify Email Address
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:25px 0 16px 0;color:#d1d1d1;font-size:14px;line-height:1.7;">
                                I'm <strong style="color:#D4AF37;">Cyno</strong>. I've been around these ends since Trench City was quieter - before the flash, before the noise, before everyone started acting like they run the place. Back then it was simpler... but simple don't get you far out here.
                            </p>

                            <p style="margin:0 0 16px 0;color:#d1d1d1;font-size:14px;line-height:1.7;">
                                Now the city's live. Fast money, quick problems, and everyone's watching. Move wrong once and it follows you. Move smart and you start building a name.
                            </p>

                            <p style="margin:0 0 16px 0;color:#d1d1d1;font-size:14px;line-height:1.7;">
                                Over the next few days I'll send you the proper starter tips - the stuff you actually need:<br>
                                how to move safe, stack up early, pick your lanes, and not get caught slipping.
                            </p>

                            <p style="margin:0 0 25px 0;color:#d1d1d1;font-size:14px;line-height:1.7;">
                                I'll check in tomorrow to see how you're settling in.
                            </p>

                            <p style="margin:0;color:#D4AF37;font-size:14px;font-style:italic;">
                                - Cyno
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 40px;background:#1f1f1f;border-top:1px solid #3a3a3a;">
                            <p style="margin:0 0 10px 0;color:#888;font-size:12px;line-height:1.5;">
                                This verification link expires in 30 minutes. If you didn't create an account, you can safely ignore this email.
                            </p>
                            <p style="margin:0;color:#666;font-size:11px;">
                                Having trouble? Copy and paste this link into your browser:<br>
                                <span style="color:#555;word-break:break-all;">{$verificationUrl}</span>
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Legal Footer -->
                <table width="600" cellpadding="0" cellspacing="0" style="margin-top:15px;">
                    <tr>
                        <td align="center" style="padding:10px;">
                            <p style="margin:0;color:#666;font-size:11px;">
                                © 2025 Trench City. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }

    /**
     * Get verification email plain text template
     */
    private function getVerificationEmailText(string $verificationUrl, string $username): string {
        return <<<TEXT
═══════════════════════════════════════
TRENCH CITY - EMAIL VERIFICATION
═══════════════════════════════════════

Alright {$username},

Welcome to Trench City.
Before you're fully in, you need to verify your email and activate your account using the link below.

VERIFY YOUR EMAIL:
{$verificationUrl}

I'm Cyno. I've been around these ends since Trench City was quieter - before the flash, before the noise, before everyone started acting like they run the place. Back then it was simpler... but simple don't get you far out here.

Now the city's live. Fast money, quick problems, and everyone's watching. Move wrong once and it follows you. Move smart and you start building a name.

Over the next few days I'll send you the proper starter tips - the stuff you actually need:
how to move safe, stack up early, pick your lanes, and not get caught slipping.

I'll check in tomorrow to see how you're settling in.

- Cyno

═══════════════════════════════════════
This link expires in 30 minutes.
If you didn't create this account, ignore this email.

© 2025 Trench City. All rights reserved.
═══════════════════════════════════════
TEXT;
    }
}
