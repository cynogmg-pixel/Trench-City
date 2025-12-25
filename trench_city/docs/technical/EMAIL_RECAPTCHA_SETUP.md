# 📧 EMAIL VERIFICATION & reCAPTCHA SETUP GUIDE

**Trench City V2 - Security Features**

---

## ✅ WHAT WAS ADDED

### 1. **Email Verification System**
- Users must verify email before playing (optional setting)
- Beautiful HTML email template
- Verification token system (24-hour expiry)
- Email verification tracking logs
- Resend verification option

### 2. **reCAPTCHA v2 Integration**
- Google reCAPTCHA on registration
- Bot protection
- Easy enable/disable via database

### 3. **New Files Created**
- `core/email_verification_schema.sql` - Database schema
- `core/Email.php` - Email service class
- `public/register_new.php` - Updated registration with both features
- `public/login_new.php` - Login with email verification check
- `public/verify-email.php` - Email verification handler
- `EMAIL_RECAPTCHA_SETUP.md` - This guide

---

## 📋 SETUP STEPS

### STEP 1: Install Database Schema

```bash
# SSH into your VPS
mysql -u trench_user -p trench_city < /var/www/trench_city/core/email_verification_schema.sql
```

This creates:
- Email verification columns in `users` table
- `email_verification_logs` table
- `email_config` table with settings

---

### STEP 2: Configure Email Sending

You have **3 options** for sending emails:

#### **Option A: PHP mail() Function (Easiest, works out of the box)**

No configuration needed! PHP's built-in `mail()` function will be used.

**Pros:** Zero setup
**Cons:** May go to spam, limited features

**To use:** Just leave `smtp_enabled` as `false` in database (default)

---

#### **Option B: Gmail SMTP (Recommended for small-medium games)**

1. **Enable 2-Step Verification** on your Gmail account
2. **Generate App Password:**
   - Go to https://myaccount.google.com/apppasswords
   - Select "Mail" and "Other (Custom name)"
   - Name it "Trench City"
   - Copy the 16-character password

3. **Configure in database:**

```sql
USE trench_city;

UPDATE email_config SET config_value = 'true' WHERE config_key = 'smtp_enabled';
UPDATE email_config SET config_value = 'smtp.gmail.com' WHERE config_key = 'smtp_host';
UPDATE email_config SET config_value = '587' WHERE config_key = 'smtp_port';
UPDATE email_config SET config_value = 'your-email@gmail.com' WHERE config_key = 'smtp_username';
UPDATE email_config SET config_value = 'your-16-char-app-password' WHERE config_key = 'smtp_password';
UPDATE email_config SET config_value = 'tls' WHERE config_key = 'smtp_encryption';
UPDATE email_config SET config_value = 'noreply@yourdomain.com' WHERE config_key = 'from_email';
UPDATE email_config SET config_value = 'Trench City' WHERE config_key = 'from_name';
```

4. **Install PHPMailer (required for SMTP):**

```bash
cd /var/www/trench_city
composer require phpmailer/phpmailer
```

---

#### **Option C: Professional Email Service (Recommended for production)**

Use **Mailgun**, **SendGrid**, **Amazon SES**, or **Postmark**

**Example with Mailgun:**

1. Sign up at https://www.mailgun.com/
2. Verify your domain
3. Get your SMTP credentials from Mailgun dashboard

```sql
UPDATE email_config SET config_value = 'true' WHERE config_key = 'smtp_enabled';
UPDATE email_config SET config_value = 'smtp.mailgun.org' WHERE config_key = 'smtp_host';
UPDATE email_config SET config_value = '587' WHERE config_key = 'smtp_port';
UPDATE email_config SET config_value = 'postmaster@yourdomain.com' WHERE config_key = 'smtp_username';
UPDATE email_config SET config_value = 'your-mailgun-password' WHERE config_key = 'smtp_password';
UPDATE email_config SET config_value = 'tls' WHERE config_key = 'smtp_encryption';
UPDATE email_config SET config_value = 'noreply@yourdomain.com' WHERE config_key = 'from_email';
```

4. Install PHPMailer:

```bash
cd /var/www/trench_city
composer require phpmailer/phpmailer
```

---

### STEP 3: Enable/Disable Email Verification

**To REQUIRE email verification (users must verify before playing):**

```sql
UPDATE email_config SET config_value = 'true' WHERE config_key = 'verification_required';
```

**To make it OPTIONAL (users can play immediately):**

```sql
UPDATE email_config SET config_value = 'false' WHERE config_key = 'verification_required';
```

---

### STEP 4: Configure reCAPTCHA

1. **Get reCAPTCHA Keys:**
   - Go to https://www.google.com/recaptcha/admin/create
   - Select **reCAPTCHA v2** → "I'm not a robot" Checkbox
   - Add your domain (e.g., `trenchcity.com`)
   - Accept terms
   - Copy **Site Key** and **Secret Key**

2. **Add keys to database:**

```sql
UPDATE email_config SET config_value = 'true' WHERE config_key = 'recaptcha_enabled';
UPDATE email_config SET config_value = 'YOUR_SITE_KEY_HERE' WHERE config_key = 'recaptcha_site_key';
UPDATE email_config SET config_value = 'YOUR_SECRET_KEY_HERE' WHERE config_key = 'recaptcha_secret_key';
```

**To disable reCAPTCHA:**

```sql
UPDATE email_config SET config_value = 'false' WHERE config_key = 'recaptcha_enabled';
```

---

### STEP 5: Update Registration & Login Links

**Replace old registration/login with new versions:**

```bash
cd /var/www/trench_city/public

# Backup old files
mv register.php register_old.php
mv login.php login_old.php

# Activate new files
mv register_new.php register.php
mv login_new.php login.php
```

**Or update navigation links to use new files:**
- `/register_new.php` instead of `/register.php`
- `/login_new.php` instead of `/login.php`

---

### STEP 6: Update .env File

Add these to your `.env` file:

```env
# Email Configuration
SMTP_ENABLED=true
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=your-email@gmail.com
SMTP_PASSWORD=your-app-password
SMTP_ENCRYPTION=tls
FROM_EMAIL=noreply@trenchcity.com
FROM_NAME=Trench City

# Application URL (for verification links)
APP_URL=https://trenchcity.com
```

---

## 🧪 TESTING

### Test Email Verification:

1. **Register new account** at `/register_new.php`
2. **Check email inbox** for verification email
3. **Click verification link**
4. **See success message** and login option
5. **Login** at `/login_new.php`
6. **Access dashboard**

### Test reCAPTCHA:

1. Go to `/register_new.php`
2. Fill out form
3. **reCAPTCHA checkbox should appear**
4. Check "I'm not a robot"
5. Submit form
6. Should work if checked, fail if not

### Test Without Verification:

```sql
-- Temporarily disable for testing
UPDATE email_config SET config_value = 'false' WHERE config_key = 'verification_required';
```

Register → Should auto-login immediately

---

## 🎨 EMAIL TEMPLATE CUSTOMIZATION

The email template is in `core/Email.php` in the `getVerificationEmailHTML()` method.

**Customize:**
- Colors (change #D4AF37 to your brand color)
- Logo (add image URL to header)
- Text content
- Footer links

---

## ⚙️ CONFIGURATION OPTIONS

All settings in `email_config` table:

| Setting | Default | Description |
|---------|---------|-------------|
| `smtp_enabled` | false | Use SMTP or PHP mail() |
| `smtp_host` | smtp.gmail.com | SMTP server |
| `smtp_port` | 587 | SMTP port (587=TLS, 465=SSL) |
| `smtp_username` | - | SMTP login username |
| `smtp_password` | - | SMTP password |
| `smtp_encryption` | tls | tls, ssl, or none |
| `from_email` | noreply@trenchcity.com | Sender email |
| `from_name` | Trench City | Sender name |
| `verification_required` | true | Require email verification? |
| `verification_token_expiry` | 24 | Hours until token expires |
| `recaptcha_enabled` | false | Enable reCAPTCHA? |
| `recaptcha_site_key` | - | Google reCAPTCHA site key |
| `recaptcha_secret_key` | - | Google reCAPTCHA secret key |

**Update any setting:**

```sql
UPDATE email_config SET config_value = 'YOUR_VALUE' WHERE config_key = 'SETTING_NAME';
```

---

## 🔧 TROUBLESHOOTING

### "Email not sending"

1. Check SMTP credentials are correct
2. Check Gmail app password (not regular password)
3. Check firewall allows port 587
4. Check PHP error logs: `tail -f /var/log/php-fpm-errors.log`
5. Test with PHP mail() first (disable SMTP)

### "reCAPTCHA not showing"

1. Verify site key is correct
2. Check domain is whitelisted in reCAPTCHA admin
3. Check browser console for JavaScript errors
4. Verify `recaptcha_enabled` is 'true'

### "Verification link expired"

1. Check `verification_token_expiry` setting (default 24 hours)
2. User can register again to get new link
3. Or create "resend verification" feature

### "Emails going to spam"

1. Set up SPF records for your domain
2. Set up DKIM records
3. Use professional email service (Mailgun, SendGrid)
4. Send from your domain, not Gmail

---

## 📧 SPF & DKIM SETUP (Prevent Spam)

### For Gmail SMTP:

Add to your domain's DNS:

```
Type: TXT
Name: @
Value: v=spf1 include:_spf.google.com ~all
```

### For Mailgun:

Mailgun provides exact DNS records in their dashboard. Add them to your domain DNS.

---

## 🚀 PRODUCTION CHECKLIST

- [ ] Email sending configured (SMTP or mail())
- [ ] Test email received successfully
- [ ] reCAPTCHA keys added (site & secret)
- [ ] reCAPTCHA working on registration
- [ ] Email verification enabled (if desired)
- [ ] Verification email template customized
- [ ] APP_URL set correctly in .env
- [ ] SPF/DKIM records added to DNS
- [ ] Test complete registration flow
- [ ] Check emails not going to spam
- [ ] Old register.php & login.php replaced

---

## 📊 MONITORING

### Check verification stats:

```sql
-- Total unverified users
SELECT COUNT(*) FROM users WHERE email_verified = 0;

-- Recent verifications
SELECT user_id, email, verified_at
FROM email_verification_logs
WHERE verified_at IS NOT NULL
ORDER BY verified_at DESC
LIMIT 10;

-- Pending verifications
SELECT user_id, email, sent_at
FROM email_verification_logs
WHERE verified_at IS NULL
AND sent_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY sent_at DESC;
```

---

## 🎯 QUICK CONFIGURATION COMMANDS

### Enable Everything (Production):

```sql
USE trench_city;

-- Enable email verification
UPDATE email_config SET config_value = 'true' WHERE config_key = 'verification_required';

-- Enable reCAPTCHA
UPDATE email_config SET config_value = 'true' WHERE config_key = 'recaptcha_enabled';
UPDATE email_config SET config_value = 'YOUR_SITE_KEY' WHERE config_key = 'recaptcha_site_key';
UPDATE email_config SET config_value = 'YOUR_SECRET_KEY' WHERE config_key = 'recaptcha_secret_key';

-- Configure email (Gmail example)
UPDATE email_config SET config_value = 'true' WHERE config_key = 'smtp_enabled';
UPDATE email_config SET config_value = 'smtp.gmail.com' WHERE config_key = 'smtp_host';
UPDATE email_config SET config_value = '587' WHERE config_key = 'smtp_port';
UPDATE email_config SET config_value = 'your-email@gmail.com' WHERE config_key = 'smtp_username';
UPDATE email_config SET config_value = 'your-app-password' WHERE config_key = 'smtp_password';
UPDATE email_config SET config_value = 'noreply@yourdomain.com' WHERE config_key = 'from_email';
```

### Disable Everything (Testing):

```sql
USE trench_city;

UPDATE email_config SET config_value = 'false' WHERE config_key = 'verification_required';
UPDATE email_config SET config_value = 'false' WHERE config_key = 'recaptcha_enabled';
UPDATE email_config SET config_value = 'false' WHERE config_key = 'smtp_enabled';
```

---

## 📝 SUMMARY

**You now have:**
- ✅ Email verification system
- ✅ Beautiful HTML email templates
- ✅ reCAPTCHA bot protection
- ✅ Flexible configuration (enable/disable anytime)
- ✅ Professional email sending options
- ✅ Updated registration & login pages

**Files to use:**
- `/register_new.php` - New registration with email verification & reCAPTCHA
- `/login_new.php` - New login with verification check
- `/verify-email.php` - Email verification handler

**Configuration:** All in `email_config` database table - no code changes needed!

---

**Your registration is now secure and professional!** 🔒📧

