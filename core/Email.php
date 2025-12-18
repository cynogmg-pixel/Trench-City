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
    }

    /**
     * Get configuration value
     */
    public function getConfig(string $key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    /**
     * Send email
     */
    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $smtpEnabled = ($this->config['smtp_enabled'] ?? 'false') === 'true';

        if ($smtpEnabled) {
            return $this->sendViaSMTP($to, $subject, $htmlBody, $textBody);
        } else {
            return $this->sendViaPHPMail($to, $subject, $htmlBody, $textBody);
        }
    }

    /**
     * Send via SMTP (using PHPMailer or similar)
     */
    private function sendViaSMTP(string $to, string $subject, string $htmlBody, string $textBody): bool {
        // Check if PHPMailer is available
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            error_log("PHPMailer not available, falling back to PHP mail()");
            return $this->sendViaPHPMail($to, $subject, $htmlBody, $textBody);
        }

        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = $this->config['smtp_host'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['smtp_username'] ?? '';
            $mail->Password = $this->config['smtp_password'] ?? '';
            $mail->Port = (int)($this->config['smtp_port'] ?? 587);

            $encryption = $this->config['smtp_encryption'] ?? 'tls';
            if ($encryption === 'ssl') {
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls') {
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            }

            // From/To
            $mail->setFrom(
                $this->config['from_email'] ?? 'noreply@trenchcity.com',
                $this->config['from_name'] ?? 'Trench City'
            );
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody ?: strip_tags($htmlBody);

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("SMTP Email failed: " . $e->getMessage());
            return false;
        }
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
            error_log("PHP mail() failed to send email to {$to}");
        }

        return $success;
    }

    /**
     * Send verification email
     */
    public function sendVerificationEmail(int $userId, string $email, string $token): bool {
        $verificationUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/') . '/verify-email.php?token=' . urlencode($token);

        $htmlBody = $this->getVerificationEmailHTML($verificationUrl);
        $textBody = $this->getVerificationEmailText($verificationUrl);

        $sent = $this->send($email, 'Verify Your Trench City Account', $htmlBody, $textBody);

        if ($sent) {
            // Log the send
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
        }

        return $sent;
    }

    /**
     * Get verification email HTML template
     */
    private function getVerificationEmailHTML(string $verificationUrl): string {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #05070B;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #05070B;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #111827; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1F2937 0%, #111827 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #D4AF37; font-size: 32px; font-weight: bold;">TRENCH CITY</h1>
                            <p style="margin: 10px 0 0 0; color: #9CA3AF; font-size: 14px;">THE STREETS ARE CALLING</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #F9FAFB; font-size: 24px;">Verify Your Email Address</h2>

                            <p style="margin: 0 0 20px 0; color: #D1D5DB; font-size: 16px; line-height: 1.6;">
                                Welcome to Trench City! You're one step away from joining the most dangerous streets in the game.
                            </p>

                            <p style="margin: 0 0 30px 0; color: #D1D5DB; font-size: 16px; line-height: 1.6;">
                                Click the button below to verify your email address and activate your account:
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="{$verificationUrl}" style="display: inline-block; padding: 16px 40px; background-color: #D4AF37; color: #000000; text-decoration: none; font-weight: bold; font-size: 16px; border-radius: 4px;">
                                            VERIFY EMAIL ADDRESS
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0 0; color: #9CA3AF; font-size: 14px; line-height: 1.6;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin: 10px 0 0 0; color: #6B7280; font-size: 12px; word-break: break-all;">
                                {$verificationUrl}
                            </p>

                            <p style="margin: 30px 0 0 0; color: #9CA3AF; font-size: 14px; line-height: 1.6;">
                                This verification link will expire in 24 hours.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #0A0E1A; padding: 30px; text-align: center;">
                            <p style="margin: 0 0 10px 0; color: #6B7280; font-size: 12px;">
                                This email was sent because you registered for Trench City.
                            </p>
                            <p style="margin: 0; color: #6B7280; font-size: 12px;">
                                If you didn't register, you can safely ignore this email.
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
    private function getVerificationEmailText(string $verificationUrl): string {
        return <<<TEXT
TRENCH CITY - Verify Your Email Address

Welcome to Trench City! You're one step away from joining the most dangerous streets in the game.

Click the link below to verify your email address and activate your account:

{$verificationUrl}

This verification link will expire in 24 hours.

If you didn't register for Trench City, you can safely ignore this email.

---
Trench City - The Streets Are Calling
TEXT;
    }
}
