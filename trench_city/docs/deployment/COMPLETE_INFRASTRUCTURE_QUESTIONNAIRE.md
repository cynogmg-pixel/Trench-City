# 🏗️ TRENCH CITY V2 - COMPLETE INFRASTRUCTURE SETUP
## From Blank Canvas to Production-Ready

**Setup Type:** Fresh IONOS Multi-Server Infrastructure
- 2x Game Nodes (Web Servers) - BLANK
- 1x Load Balancer - BLANK
- 1x Database Server - BLANK
- 1x Redis Server - BLANK

**This guide will configure EVERYTHING from scratch!**

---

# 📋 PART 1: SERVER ACCESS INFORMATION

## 1.1 LOAD BALANCER SERVER

**Public IP Address:**
```
___________________________________
```

**Private IP Address (internal network):**
```
___________________________________
```

**SSH Access:**
- Username: `___________________________________`
- Password: `___________________________________`
- SSH Port: `___________________________________` (default: 22)
- Root password: `___________________________________`

**Operating System:**
- [ ] Ubuntu 22.04
- [ ] Ubuntu 20.04
- [ ] Debian 11
- [ ] Debian 12
- [ ] CentOS/Rocky Linux
- Other: `___________________________________`

---

## 1.2 GAME NODE 1 (Web Server)

**Public IP Address (if has one):**
```
___________________________________
```

**Private IP Address (internal network):**
```
___________________________________
```

**SSH Access:**
- Username: `___________________________________`
- Password: `___________________________________`
- SSH Port: `___________________________________` (default: 22)
- Root password: `___________________________________`

**Operating System:**
- [ ] Ubuntu 22.04
- [ ] Ubuntu 20.04
- [ ] Debian 11
- [ ] Debian 12
- Other: `___________________________________`

**Server Specs (optional but helpful):**
- CPU Cores: `___________________________________`
- RAM: `___________________________________`
- Disk Space: `___________________________________`

---

## 1.3 GAME NODE 2 (Web Server)

**Public IP Address (if has one):**
```
___________________________________
```

**Private IP Address (internal network):**
```
___________________________________
```

**SSH Access:**
- Username: `___________________________________`
- Password: `___________________________________`
- SSH Port: `___________________________________` (default: 22)
- Root password: `___________________________________`

**Operating System:**
- [ ] Ubuntu 22.04
- [ ] Ubuntu 20.04
- [ ] Debian 11
- [ ] Debian 12
- Other: `___________________________________`

**Server Specs (optional but helpful):**
- CPU Cores: `___________________________________`
- RAM: `___________________________________`
- Disk Space: `___________________________________`

---

## 1.4 DATABASE SERVER

**Public IP Address (if has one):**
```
___________________________________
```

**Private IP Address (internal network):**
```
___________________________________
```

**SSH Access:**
- Username: `___________________________________`
- Password: `___________________________________`
- SSH Port: `___________________________________` (default: 22)
- Root password: `___________________________________`

**Operating System:**
- [ ] Ubuntu 22.04
- [ ] Ubuntu 20.04
- [ ] Debian 11
- [ ] Debian 12
- Other: `___________________________________`

**Server Specs:**
- CPU Cores: `___________________________________`
- RAM: `___________________________________`
- Disk Space: `___________________________________`

---

## 1.5 REDIS SERVER

**Public IP Address (if has one):**
```
___________________________________
```

**Private IP Address (internal network):**
```
___________________________________
```

**SSH Access:**
- Username: `___________________________________`
- Password: `___________________________________`
- SSH Port: `___________________________________` (default: 22)
- Root password: `___________________________________`

**Operating System:**
- [ ] Ubuntu 22.04
- [ ] Ubuntu 20.04
- [ ] Debian 11
- [ ] Debian 12
- Other: `___________________________________`

**Server Specs:**
- CPU Cores: `___________________________________`
- RAM: `___________________________________`

---

## 1.6 IONOS NETWORK INFORMATION

**IONOS Data Center Location:**
- [ ] USA
- [ ] Germany
- [ ] UK
- [ ] Spain
- Other: `___________________________________`

**Internal Network Subnet:**
- Example: `10.0.0.0/24` or `192.168.1.0/24`
- Your subnet: `___________________________________`

**Can servers ping each other?**
- [ ] Yes, already tested
- [ ] Don't know yet
- [ ] No, need to configure

**IONOS Firewall/Security Group:**
- [ ] Using IONOS firewall
- [ ] Will configure iptables/ufw on each server
- [ ] Both

---

# 📋 PART 2: DOMAIN & DNS

## 2.1 DOMAIN CONFIGURATION

**Your Domain Name:**
```
___________________________________
```
Example: `trenchcity.com`

**Domain Registrar:**
- [ ] IONOS (same as hosting)
- [ ] Cloudflare
- [ ] GoDaddy
- [ ] Namecheap
- Other: `___________________________________`

**DNS Management:**
- [ ] IONOS DNS
- [ ] Cloudflare DNS (recommended)
- [ ] Domain registrar DNS
- Other: `___________________________________`

**WWW Preference:**
- [ ] Redirect www to non-www (www.trenchcity.com → trenchcity.com)
- [ ] Redirect non-www to www (trenchcity.com → www.trenchcity.com)
- Your choice: `___________________________________`

**Subdomain for Admin Panel (optional):**
- Example: `admin.trenchcity.com`
- Your admin subdomain: `___________________________________`

---

# 📋 PART 3: EMAIL CONFIGURATION

## 3.1 BUSINESS EMAIL SETUP

**Your Business Email Address:**
```
___________________________________
```
Example: `noreply@yourbusiness.com`

**Business Email Provider:**
- [ ] Google Workspace (Gmail for Business)
- [ ] Microsoft 365
- [ ] IONOS Email
- [ ] Custom SMTP Server
- [ ] Mailgun (transactional email service - RECOMMENDED)
- [ ] SendGrid (transactional email service)
- [ ] Amazon SES
- Other: `___________________________________`

---

## 3.2 GOOGLE WORKSPACE / GMAIL BUSINESS

**If using Google Workspace:**

**Email Address:** `___________________________________`
**Password:** (Don't share - we'll use App Password)

**Google App Password** (generate at https://myaccount.google.com/apppasswords):
```
___________________________________
```

**SMTP Settings (auto-filled for Gmail):**
- Host: `smtp.gmail.com`
- Port: `587`
- Encryption: `TLS`

---

## 3.3 MICROSOFT 365

**If using Microsoft 365:**

**Email Address:** `___________________________________`
**Password:** (Don't share - we'll use App Password if available)

**SMTP Settings (auto-filled for O365):**
- Host: `smtp.office365.com`
- Port: `587`
- Encryption: `TLS`

---

## 3.4 MAILGUN (RECOMMENDED FOR PRODUCTION)

**If using Mailgun:**

**Mailgun Domain:** `___________________________________`
Example: `mg.trenchcity.com`

**Mailgun SMTP Username:**
```
___________________________________
```
Example: `postmaster@mg.trenchcity.com`

**Mailgun SMTP Password:**
```
___________________________________
```

**Mailgun API Key (optional for advanced features):**
```
___________________________________
```

---

## 3.5 SENDGRID

**If using SendGrid:**

**SendGrid API Key:**
```
___________________________________
```

**Or SMTP Password:**
```
___________________________________
```

**SMTP Settings (auto-filled):**
- Host: `smtp.sendgrid.net`
- Port: `587`
- Username: `apikey`

---

## 3.6 IONOS EMAIL

**If using IONOS Email:**

**Email Address:** `___________________________________`
**Password:** `___________________________________`

**SMTP Host:**
```
___________________________________
```
Example: `smtp.ionos.com` or check IONOS docs

**SMTP Port:**
- [ ] 587 (TLS)
- [ ] 465 (SSL)
- Other: `___________________________________`

---

## 3.7 EMAIL FROM SETTINGS

**"From" Email Address (what users see):**
```
___________________________________
```
Example: `noreply@trenchcity.com`

**"From" Name (what users see):**
```
___________________________________
```
Example: `Trench City` or `Trench City Support`

**"Reply-To" Email (if different):**
```
___________________________________
```
Example: `support@trenchcity.com`

---

# 📋 PART 4: DATABASE CONFIGURATION

## 4.1 DATABASE CREDENTIALS (You Choose These)

**Database Name:**
```
___________________________________
```
Recommended: `trench_city`

**Database Username:**
```
___________________________________
```
Recommended: `trench_user` or `tc_admin`

**Database Password (STRONG!):**
```
___________________________________
```
**MUST HAVE:** 16+ chars, uppercase, lowercase, numbers, symbols
Example: `Tr3nch!Cty@2025$DB#Secure`

**MySQL Root Password (for server setup):**
```
___________________________________
```
Generate strong password or I can generate one for you

**Database Character Set:**
- Default: `utf8mb4` ✓ (recommended, leave this)

**Database Collation:**
- Default: `utf8mb4_unicode_ci` ✓ (recommended, leave this)

---

## 4.2 DATABASE ACCESS CONTROL

**Which servers can connect to database?**
- ✓ Game Node 1 (private IP: `_________________`)
- ✓ Game Node 2 (private IP: `_________________`)
- [ ] Load Balancer (usually not needed)
- [ ] Your office IP for remote management: `_________________`
- [ ] phpMyAdmin access (we can set this up)

---

# 📋 PART 5: REDIS CONFIGURATION

## 5.1 REDIS CREDENTIALS (You Choose)

**Redis Password (STRONG!):**
```
___________________________________
```
Example: `R3dis!Cache@2025$Secure`
Or leave blank for no password (less secure)

**Redis Port:**
```
___________________________________
```
Default: `6379` (recommended)

**Redis Max Memory:**
- [ ] 256MB (small game, <1000 users)
- [ ] 512MB (medium game, <5000 users)
- [ ] 1GB (large game, 5000+ users)
- [ ] 2GB (very large game, 10000+ users)
- Custom: `___________________________________`

**Redis Database Number:**
- Default: `0` (leave as is)

---

# 📋 PART 6: SSL/HTTPS CERTIFICATES

## 6.1 SSL CERTIFICATE CHOICE

**SSL Provider:**
- [ ] Let's Encrypt (FREE, auto-renewal) ✓ RECOMMENDED
- [ ] Cloudflare (FREE, if using Cloudflare)
- [ ] Commercial SSL (I already purchased)
- Your choice: `___________________________________`

**Email for Let's Encrypt notifications:**
```
___________________________________
```
Example: `admin@trenchcity.com` or your business email

**SSL Installation Location:**
- [ ] On Load Balancer (SSL termination) ✓ RECOMMENDED
- [ ] On Game Nodes (end-to-end encryption)
- [ ] Both
- Your choice: `___________________________________`

**Auto-renewal setup:**
- [ ] Yes, configure automatic renewal ✓ RECOMMENDED
- [ ] No, I'll renew manually

---

# 📋 PART 7: RECAPTCHA CONFIGURATION

## 7.1 GOOGLE RECAPTCHA

**Get your keys here:** https://www.google.com/recaptcha/admin/create

**Choose reCAPTCHA Type:**
- [ ] reCAPTCHA v2 - "I'm not a robot" Checkbox ✓ RECOMMENDED
- [ ] reCAPTCHA v2 - Invisible
- [ ] reCAPTCHA v3
- Your choice: `___________________________________`

**Add these domains to reCAPTCHA:**
- `trenchcity.com` (your domain)
- `www.trenchcity.com` (if using www)

**reCAPTCHA Site Key:**
```
___________________________________
```

**reCAPTCHA Secret Key:**
```
___________________________________
```

**Enable reCAPTCHA?**
- [ ] Yes (recommended for production)
- [ ] No (for testing only)

---

# 📋 PART 8: APPLICATION SETTINGS

## 8.1 APPLICATION ENVIRONMENT

**Environment Type:**
- [ ] production ✓ (for live game)
- [ ] staging (for testing)
- [ ] development (for dev work)
- Your choice: `___________________________________`

**Debug Mode:**
- [ ] Disabled (recommended for production)
- [ ] Enabled (only for testing)
- Your choice: `___________________________________`

**Error Logging:**
- [ ] Enabled ✓ RECOMMENDED
- [ ] Disabled
- Your choice: `___________________________________`

**Log Level:**
- [ ] error (only errors)
- [ ] warning (errors + warnings) ✓ RECOMMENDED
- [ ] info (errors + warnings + info)
- [ ] debug (everything - verbose)
- Your choice: `___________________________________`

---

## 8.2 APPLICATION SECRET KEY

**App Secret Key (32+ characters):**
- [ ] Generate one for me automatically ✓ RECOMMENDED
- [ ] I'll provide my own: `___________________________________`

**Session Secret (32+ characters):**
- [ ] Generate one for me automatically ✓ RECOMMENDED
- [ ] I'll provide my own: `___________________________________`

**CSRF Token Secret (32+ characters):**
- [ ] Generate one for me automatically ✓ RECOMMENDED
- [ ] I'll provide my own: `___________________________________`

---

# 📋 PART 9: GAME SETTINGS

## 9.1 NEW PLAYER DEFAULTS

**Starting Cash:**
```
___________________________________
```
Default: `5000` (£5,000)

**Starting Stats (each stat: Strength, Speed, Defense, Dexterity):**
```
___________________________________
```
Default: `10`

**Starting Energy:**
```
___________________________________
```
Default: `100`

**Starting Nerve:**
```
___________________________________
```
Default: `15`

**Starting Happy:**
```
___________________________________
```
Default: `100`

**Starting Life:**
```
___________________________________
```
Default: `100`

---

## 9.2 REGENERATION RATES

**Energy Regeneration (every 5 minutes):**
```
___________________________________
```
Default: `5` (100 energy = 100 minutes)

**Nerve Regeneration (every 5 minutes):**
```
___________________________________
```
Default: `1` (15 nerve = 75 minutes)

**Happy Decay (every 5 minutes):**
```
___________________________________
```
Default: `1` (loses 1 happy every 5 min)

**Life Regeneration (if not in combat):**
```
___________________________________
```
Default: `5` per 5 minutes

---

## 9.3 EMAIL VERIFICATION SETTINGS

**Require Email Verification Before Playing?**
- [ ] Yes (users must verify email)
- [ ] No (users can play immediately)
- Your choice: `___________________________________`

**Verification Email Expiry:**
```
___________________________________
```
Default: `24` hours

**Allow Resend Verification Email?**
- [ ] Yes
- [ ] No
- Your choice: `___________________________________`

---

# 📋 PART 10: ADMIN ACCOUNT

## 10.1 INITIAL ADMIN ACCOUNT

**Admin Username:**
```
___________________________________
```
Example: `admin` or `trenchadmin`

**Admin Email:**
```
___________________________________
```
Example: `admin@trenchcity.com` or your business email

**Admin Password (VERY STRONG!):**
```
___________________________________
```
**MUST HAVE:** 20+ chars, uppercase, lowercase, numbers, symbols

---

# 📋 PART 11: BACKUP CONFIGURATION

## 11.1 BACKUP SETTINGS

**Backup Location:**
- [ ] Local server (`/var/backups/trench_city`)
- [ ] Network storage (specify): `___________________________________`
- [ ] IONOS Object Storage
- [ ] Amazon S3
- [ ] Backblaze B2
- Other: `___________________________________`

**Backup Retention (how many days to keep):**
```
___________________________________
```
Default: `7` days (1 week)

**Database Backup Schedule:**
- [ ] Daily at 2:00 AM ✓ RECOMMENDED
- [ ] Twice daily (2 AM and 2 PM)
- [ ] Every 6 hours
- Custom time: `___________________________________`

**What to Backup:**
- [✓] Database (always)
- [ ] User uploaded files
- [ ] Application logs
- [ ] Game logs
- Your choice: `___________________________________`

**Backup Compression:**
- [ ] gzip ✓ RECOMMENDED
- [ ] No compression
- Your choice: `___________________________________`

**Backup Encryption:**
- [ ] Yes (encrypt backups with password)
- [ ] No
- If yes, encryption password: `___________________________________`

---

# 📋 PART 12: MONITORING & ALERTS

## 12.1 SYSTEM MONITORING

**Alert Email Address:**
```
___________________________________
```
Example: `alerts@trenchcity.com` or your business email

**What to Monitor:**
- [✓] CPU Usage
- [✓] Memory Usage
- [✓] Disk Space
- [✓] Server Uptime
- [ ] Database Connections
- [ ] Redis Memory
- [ ] Application Errors
- Your choice: `___________________________________`

**Alert Thresholds:**
- CPU Usage: `___________________________________`% (default: 80%)
- Memory Usage: `___________________________________`% (default: 85%)
- Disk Usage: `___________________________________`% (default: 90%)

**Send Alerts Via:**
- [ ] Email
- [ ] SMS (requires service like Twilio)
- [ ] Slack/Discord webhook
- [ ] All of the above
- Your choice: `___________________________________`

---

## 12.2 APPLICATION MONITORING

**Enable Error Tracking:**
- [ ] Yes (recommended)
- [ ] No
- Your choice: `___________________________________`

**Error Notification Email:**
```
___________________________________
```

**Monitor Failed Logins:**
- [ ] Yes
- [ ] No
- Your choice: `___________________________________`

**Monitor Suspicious Activity:**
- [ ] Yes (rapid attacks, unusual patterns)
- [ ] No
- Your choice: `___________________________________`

---

# 📋 PART 13: LOAD BALANCER CONFIGURATION

## 13.1 LOAD BALANCING METHOD

**Load Balancing Algorithm:**
- [ ] Round Robin (equal distribution) ✓ SIMPLE
- [ ] Least Connections (send to least busy) ✓ RECOMMENDED
- [ ] IP Hash (same user → same server)
- Your choice: `___________________________________`

**Session Handling:**
- [ ] Sticky Sessions (user stays on same server)
- [ ] Redis Sessions (user can hit any server) ✓ RECOMMENDED
- Your choice: `___________________________________`

**Health Check Settings:**
- Check interval: `___________________________________` seconds (default: 5)
- Timeout: `___________________________________` seconds (default: 3)
- Unhealthy threshold: `___________________________________` failures (default: 3)

**Load Balancer Software:**
- [ ] Nginx ✓ RECOMMENDED
- [ ] HAProxy
- [ ] IONOS Managed Load Balancer
- Your choice: `___________________________________`

---

# 📋 PART 14: SECURITY SETTINGS

## 14.1 FIREWALL CONFIGURATION

**Firewall Software:**
- [ ] UFW (Ubuntu/Debian) ✓ RECOMMENDED
- [ ] iptables
- [ ] IONOS Cloud Firewall
- [ ] All of the above
- Your choice: `___________________________________`

**SSH Access:**
- [ ] Password authentication
- [ ] SSH Key only ✓ RECOMMENDED
- [ ] Both (not recommended)
- Your choice: `___________________________________`

**Change Default SSH Port?**
- [ ] Yes (more secure, change from 22 to custom)
- [ ] No (keep port 22)
- If yes, new port: `___________________________________`

**Install Fail2Ban?**
- [ ] Yes ✓ RECOMMENDED (blocks brute force attacks)
- [ ] No
- Your choice: `___________________________________`

**Allowed SSH IPs (optional, leave blank for any):**
```
Your office IP: ___________________________________
Other allowed IP: ___________________________________
```

---

## 14.2 RATE LIMITING

**Enable Rate Limiting:**
- [ ] Yes ✓ RECOMMENDED
- [ ] No
- Your choice: `___________________________________`

**Rate Limit Settings:**
- Login attempts: `___________________________________` per 5 minutes (default: 5)
- Registration: `___________________________________` per hour (default: 3)
- API requests: `___________________________________` per minute (default: 60)

---

# 📋 PART 15: FILE SYNCHRONIZATION

## 15.1 MULTI-SERVER FILE SYNC

**How to Keep Game Nodes in Sync:**
- [ ] Git deployment (pull from repo on each server) ✓ RECOMMENDED
- [ ] Rsync (copy from Node 1 to Node 2)
- [ ] NFS (shared network filesystem)
- [ ] Manual deployment (I'll handle it)
- Your choice: `___________________________________`

**Git Repository (if using Git):**
- Repository URL: `___________________________________`
- Branch: `___________________________________` (default: `main`)
- Deploy SSH Key: [ ] Generate for me [ ] I'll provide

**Shared Storage for User Uploads:**
- [ ] Not needed yet (no file uploads)
- [ ] NFS Share
- [ ] IONOS Object Storage
- [ ] Amazon S3
- Your choice: `___________________________________`

---

# 📋 PART 16: TIMEZONE & LOCALE

## 16.1 SERVER SETTINGS

**Server Timezone:**
```
___________________________________
```
Examples: `UTC`, `America/New_York`, `Europe/London`, `America/Los_Angeles`
Default: `UTC` (recommended for game servers)

**PHP Timezone:**
```
___________________________________
```
Usually same as server timezone

**Game Display Timezone:**
```
___________________________________
```
What timezone to show players in-game

**Locale/Language:**
```
___________________________________
```
Default: `en_US.UTF-8`

---

# 📋 PART 17: SOFTWARE VERSIONS

## 17.1 SOFTWARE TO INSTALL

**Web Server (Game Nodes):**
- [ ] Nginx ✓ RECOMMENDED
- [ ] Apache
- Your choice: `___________________________________`

**PHP Version:**
- [ ] PHP 8.3 (latest)
- [ ] PHP 8.2 ✓ RECOMMENDED
- [ ] PHP 8.1
- Your choice: `___________________________________`

**MySQL/MariaDB:**
- [ ] MariaDB 10.11 ✓ RECOMMENDED
- [ ] MariaDB 10.6
- [ ] MySQL 8.0
- Your choice: `___________________________________`

**Redis Version:**
- [ ] Redis 7.2 (latest)
- [ ] Redis 7.0 ✓ RECOMMENDED
- [ ] Redis 6.2
- Your choice: `___________________________________`

**Composer (PHP dependency manager):**
- [ ] Yes, install ✓ RECOMMENDED
- [ ] No

**Node.js (if needed for build tools):**
- [ ] Yes, install latest LTS
- [ ] No, not needed ✓
- Your choice: `___________________________________`

---

# 📋 PART 18: DEPLOYMENT PREFERENCES

## 18.1 INITIAL DEPLOYMENT

**How to Deploy Code Initially:**
- [ ] I'll send you code via SCP/SFTP
- [ ] Git clone from repository ✓ RECOMMENDED
- [ ] You provide scripts, I'll run them
- Your choice: `___________________________________`

**Who Should Deploy Updates:**
- [ ] I'll SSH in manually
- [ ] Automated via Git webhook
- [ ] CI/CD pipeline (GitHub Actions, etc.)
- Your choice: `___________________________________`

**Deployment User:**
```
___________________________________
```
Example: `deploy` or `trench-deploy`
Or use root (not recommended)

---

# 📋 PART 19: ADDITIONAL SERVICES

## 19.1 OPTIONAL SERVICES

**Install phpMyAdmin?**
- [ ] Yes (database web interface)
- [ ] No ✓ (use command line or local tool)
- Your choice: `___________________________________`

**Install Redis Commander?**
- [ ] Yes (Redis web interface)
- [ ] No ✓ (use redis-cli)
- Your choice: `___________________________________`

**Install Monit/Monitoring Dashboard?**
- [ ] Yes
- [ ] No (I'll use separate monitoring)
- Your choice: `___________________________________`

**Set Up Log Rotation:**
- [ ] Yes ✓ RECOMMENDED
- [ ] No
- Your choice: `___________________________________`

**Install Cron Job Manager:**
- [ ] Yes (for scheduled tasks)
- [ ] No, manual cron setup
- Your choice: `___________________________________`

---

# 📋 PART 20: FINAL CHECKLIST

## Before I Generate Your Configs, Confirm:

### Server Access (CRITICAL):
- [ ] I have root/sudo access to all 5 servers
- [ ] All servers can ping each other on private network
- [ ] I know all server IPs (public + private)
- [ ] I have SSH credentials for all servers

### Domain & DNS (CRITICAL):
- [ ] Domain purchased and active
- [ ] I have access to DNS management
- [ ] I know where to point A records

### Email (CRITICAL):
- [ ] Business email configured
- [ ] SMTP credentials available (or will use Mailgun/SendGrid)
- [ ] I can send test emails from business email

### Security (IMPORTANT):
- [ ] Strong passwords chosen for database
- [ ] Strong password chosen for Redis
- [ ] Strong password chosen for admin account
- [ ] reCAPTCHA keys obtained (or will get them)

### Ready to Deploy:
- [ ] Servers are blank/fresh (or ready to wipe)
- [ ] I'm ready to SSH into all servers
- [ ] I understand I'll get scripts to run
- [ ] I have time to complete setup (2-4 hours)

---

# 📤 WHAT YOU'LL RECEIVE

Once you complete this questionnaire, I will generate:

## 🎯 COMPLETE INSTALLATION PACKAGE:

### Configuration Files (30+):
1. **`.env` files** - For both game nodes (100% ready)
2. **Nginx configs** - Load balancer + game nodes
3. **MySQL config** - Remote access, optimization
4. **Redis config** - Session storage, caching
5. **PHP-FPM config** - Performance tuning
6. **Load balancer upstream** - Both game nodes
7. **SSL certificate scripts** - Let's Encrypt automation
8. **Firewall rules** - All servers (UFW/iptables)
9. **Health check endpoint** - `/health.php`
10. **Email configuration** - SMTP tested and working

### Installation Scripts (10+):
11. **Master installation script** - One command to rule them all
12. **Load balancer setup script** - Complete automation
13. **Game node setup script** - For both nodes (identical)
14. **Database server setup script** - MySQL + user creation
15. **Redis server setup script** - Redis + password config
16. **SSL installation script** - Let's Encrypt for all
17. **Backup automation script** - Daily backups + rotation
18. **Monitoring setup script** - Alerts + health checks
19. **Security hardening script** - Fail2Ban + firewall
20. **Deployment script** - Code deployment to game nodes

### Documentation (5+):
21. **Step-by-step deployment guide** - Complete walkthrough
22. **Server architecture diagram** - Visual infrastructure
23. **Troubleshooting guide** - Common issues + fixes
24. **Maintenance guide** - Daily/weekly tasks
25. **Scaling guide** - How to add more game nodes

### Testing & Verification:
26. **Connection test scripts** - Verify all servers communicate
27. **Load balancer test** - Verify traffic distribution
28. **Database connection test** - From game nodes
29. **Redis connection test** - From game nodes
30. **Email sending test** - Verify SMTP works
31. **SSL verification** - Check certificates
32. **Health check test** - Ensure monitoring works

---

## ⏱️ ESTIMATED SETUP TIME

**With my scripts:** 2-4 hours total
- Server preparation: 30 min
- Software installation: 60 min
- Configuration: 45 min
- Testing: 30 min
- Going live: 15 min

**Manual setup without scripts:** 8-16 hours

---

## 🚀 READY TO START?

Fill out this questionnaire completely and I'll generate:

✅ **Complete working infrastructure**
✅ **Production-ready configs**
✅ **Automated deployment**
✅ **Full monitoring**
✅ **Automatic backups**
✅ **SSL/HTTPS working**
✅ **Load balanced game nodes**
✅ **Redis session sharing**
✅ **Email verification working**
✅ **reCAPTCHA protecting registration**

**Everything copy-paste ready with YOUR exact values!**

---

**Fill this out and send it back - let's build your empire! 🏗️**
