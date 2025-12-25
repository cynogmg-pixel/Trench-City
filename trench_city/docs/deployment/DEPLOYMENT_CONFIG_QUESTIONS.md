# 🔧 TRENCH CITY V2 - DEPLOYMENT CONFIGURATION

Please answer all questions below. I'll use these to create ready-to-use configuration files for your VPS.

---

## 📋 SECTION 1: DOMAIN & SERVER INFORMATION

**1.1 What is your domain name?**
- Example: `trenchcity.com`
- Your domain: `_______________________________`

**1.2 Do you want to use www subdomain?**
- Example: `www.trenchcity.com`
- Answer (yes/no): `_______________________________`

**1.3 What is your VPS IP address?**
- Example: `123.45.67.89`
- Your IP: `_______________________________`

**1.4 What is your server hostname?**
- Example: `vps.trenchcity.com` or just use IP
- Your hostname: `_______________________________`

---

## 📋 SECTION 2: WEB SERVER

**2.1 Which web server are you using?**
- [ ] Nginx (recommended)
- [ ] Apache
- Your choice: `_______________________________`

**2.2 What PHP version is installed?**
- Example: `8.1`, `8.2`, `8.3`
- Your PHP version: `_______________________________`

**2.3 PHP-FPM socket path (if Nginx)**
- Default: `/var/run/php/php8.1-fpm.sock`
- Your path (or leave blank for default): `_______________________________`

---

## 📋 SECTION 3: DATABASE CONFIGURATION

**3.1 Database Name**
- Recommended: `trench_city`
- Your database name: `_______________________________`

**3.2 Database Username**
- Recommended: `trench_user`
- Your database username: `_______________________________`

**3.3 Database Password**
- **IMPORTANT:** Use a strong password!
- Your database password: `_______________________________`

**3.4 Database Host**
- For same-server setup: `localhost` or `127.0.0.1`
- Your database host: `_______________________________`

**3.5 Database Port**
- Default: `3306`
- Your database port (or leave blank for default): `_______________________________`

**3.6 MySQL Root Password** (for installation)
- Your MySQL root password: `_______________________________`

---

## 📋 SECTION 4: REDIS (OPTIONAL)

**4.1 Do you want to use Redis for caching/sessions?**
- [ ] Yes (recommended for performance)
- [ ] No (use file-based sessions)
- Your choice: `_______________________________`

**4.2 Redis Host** (if yes above)
- Default: `127.0.0.1`
- Your Redis host: `_______________________________`

**4.3 Redis Port** (if yes above)
- Default: `6379`
- Your Redis port: `_______________________________`

**4.4 Redis Password** (if yes above)
- Leave blank if no password
- Your Redis password: `_______________________________`

---

## 📋 SECTION 5: APPLICATION SETTINGS

**5.1 Application Environment**
- [ ] production (recommended)
- [ ] development
- [ ] alpha
- Your choice: `_______________________________`

**5.2 Application URL**
- Example: `https://trenchcity.com`
- Your app URL: `_______________________________`

**5.3 Enable Debug Mode?**
- [ ] false (recommended for production)
- [ ] true (only for testing)
- Your choice: `_______________________________`

**5.4 Application Secret Key**
- **IMPORTANT:** Generate random 32-character string
- Use this command: `openssl rand -base64 32`
- Or generate random string
- Your app key: `_______________________________`

---

## 📋 SECTION 6: EMAIL CONFIGURATION (FUTURE)

**6.1 Email provider** (for password resets, notifications)
- [ ] SMTP
- [ ] Sendgrid
- [ ] Mailgun
- [ ] Not needed yet
- Your choice: `_______________________________`

**6.2 From Email Address** (if applicable)
- Example: `noreply@trenchcity.com`
- Your from email: `_______________________________`

---

## 📋 SECTION 7: SSL/HTTPS

**7.1 Do you have SSL certificate?**
- [ ] No, I'll use Let's Encrypt (free, recommended)
- [ ] Yes, I have my own certificate
- [ ] Not using SSL (not recommended)
- Your choice: `_______________________________`

**7.2 Email for Let's Encrypt** (if using Let's Encrypt)
- Example: `admin@trenchcity.com`
- Your email: `_______________________________`

---

## 📋 SECTION 8: SECURITY & ACCESS

**8.1 SSH Username for VPS**
- Example: `root` or `ubuntu`
- Your SSH user: `_______________________________`

**8.2 SSH Port**
- Default: `22`
- Your SSH port: `_______________________________`

**8.3 Server Timezone**
- Example: `UTC`, `America/New_York`, `Europe/London`
- Your timezone: `_______________________________`

---

## 📋 SECTION 9: BACKUPS

**9.1 Where should database backups be stored?**
- Default: `/var/www/trench_city/storage/backups`
- Your backup path: `_______________________________`

**9.2 How many days of backups to keep?**
- Default: `7` days
- Your preference: `_______________________________`

**9.3 Backup time (daily)**
- Default: `2:00 AM`
- Your preferred time: `_______________________________`

---

## 📋 SECTION 10: MONITORING & LOGGING

**10.1 Email for system alerts** (optional)
- Your email: `_______________________________`

**10.2 Enable access logs?**
- [ ] Yes (recommended)
- [ ] No
- Your choice: `_______________________________`

**10.3 Enable error logs?**
- [ ] Yes (recommended)
- [ ] No
- Your choice: `_______________________________`

---

## 📋 SECTION 11: GAME SETTINGS (OPTIONAL CUSTOMIZATION)

**11.1 Starting Cash for New Players**
- Default: `5000`
- Your value: `_______________________________`

**11.2 Starting Stats (Strength/Speed/Defense/Dexterity)**
- Default: `10` each
- Your value: `_______________________________`

**11.3 Energy Regeneration Rate (per 5 minutes)**
- Default: `5`
- Your value: `_______________________________`

**11.4 Nerve Regeneration Rate (per 5 minutes)**
- Default: `1`
- Your value: `_______________________________`

---

## 📋 SECTION 12: ADMIN ACCESS

**12.1 Initial Admin Username**
- Your admin username: `_______________________________`

**12.2 Initial Admin Email**
- Your admin email: `_______________________________`

**12.3 Initial Admin Password**
- Your admin password: `_______________________________`

---

## ✅ SUMMARY CHECKLIST

Please verify you've filled in:

- [ ] Domain name
- [ ] VPS IP address
- [ ] Web server choice (Nginx/Apache)
- [ ] PHP version
- [ ] Database name
- [ ] Database username
- [ ] Database password (STRONG!)
- [ ] MySQL root password
- [ ] Application secret key (32 chars)
- [ ] SSL/HTTPS choice
- [ ] Email for Let's Encrypt
- [ ] SSH username
- [ ] Server timezone

---

## 📤 NEXT STEPS

Once you've answered all questions above:

1. **Send me your answers**
2. I'll generate ready-to-use configuration files:
   - `.env` file with your exact settings
   - Nginx/Apache config with your domain
   - Database creation script with your credentials
   - Automated deployment script
   - All configs ready to copy-paste

3. You'll just need to:
   - Copy files to VPS
   - Paste configs
   - Run installation
   - Done!

---

**Ready to make Trench City production-ready? Fill in the form above!** 🚀
