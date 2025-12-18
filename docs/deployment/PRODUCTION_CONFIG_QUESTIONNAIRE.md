# 🚀 TRENCH CITY V2 - PRODUCTION CONFIGURATION QUESTIONNAIRE

**Infrastructure:** Multi-Server Setup (IONOS Data Center)
- 2x Game Nodes (Web Servers)
- 1x Load Balancer
- 1x Database Server
- 1x Redis Server

---

## 📋 SECTION 1: DOMAIN & DNS

**1.1 What is your main domain name?**
- Example: `trenchcity.com`
- Your domain: `_________________________________`

**1.2 Do you want www to redirect to non-www (or vice versa)?**
- [ ] Redirect www to non-www (www.trenchcity.com → trenchcity.com)
- [ ] Redirect non-www to www (trenchcity.com → www.trenchcity.com)
- [ ] Support both equally
- Your choice: `_________________________________`

**1.3 What is your load balancer's public IP?**
- This is the IP that your domain points to
- Your load balancer IP: `_________________________________`

---

## 📋 SECTION 2: SERVER INFRASTRUCTURE

### **Load Balancer Server**

**2.1 Load Balancer IP Address**
- Public IP: `_________________________________`
- Private IP (internal network): `_________________________________`

**2.2 Load Balancer Software**
- [ ] Nginx
- [ ] HAProxy
- [ ] Other (specify): `_________________________________`

**2.3 Load Balancer SSH Access**
- SSH Username: `_________________________________`
- SSH Port: `_________________________________` (default: 22)

---

### **Game Node 1 (Web Server)**

**2.4 Game Node 1 IP Addresses**
- Public IP (if any): `_________________________________`
- Private IP (internal): `_________________________________`

**2.5 Game Node 1 SSH Access**
- SSH Username: `_________________________________`
- SSH Port: `_________________________________`

**2.6 Game Node 1 Hostname**
- Example: `game1.trenchcity.internal` or `game-node-1`
- Hostname: `_________________________________`

---

### **Game Node 2 (Web Server)**

**2.7 Game Node 2 IP Addresses**
- Public IP (if any): `_________________________________`
- Private IP (internal): `_________________________________`

**2.8 Game Node 2 SSH Access**
- SSH Username: `_________________________________`
- SSH Port: `_________________________________`

**2.9 Game Node 2 Hostname**
- Example: `game2.trenchcity.internal` or `game-node-2`
- Hostname: `_________________________________`

---

### **Database Server**

**2.10 Database Server IP Addresses**
- Public IP (if any): `_________________________________`
- Private IP (internal): `_________________________________`

**2.11 Database Server SSH Access**
- SSH Username: `_________________________________`
- SSH Port: `_________________________________`

**2.12 Database Server Hostname**
- Example: `db.trenchcity.internal` or `database-server`
- Hostname: `_________________________________`

**2.13 MySQL/MariaDB Version**
- Example: `10.6`, `10.11`, `8.0`
- Version: `_________________________________`

---

### **Redis Server**

**2.14 Redis Server IP Addresses**
- Public IP (if any): `_________________________________`
- Private IP (internal): `_________________________________`

**2.15 Redis Server SSH Access**
- SSH Username: `_________________________________`
- SSH Port: `_________________________________`

**2.16 Redis Server Hostname**
- Example: `redis.trenchcity.internal` or `redis-server`
- Hostname: `_________________________________`

**2.17 Redis Version**
- Example: `6.2`, `7.0`, `7.2`
- Version: `_________________________________`

---

## 📋 SECTION 3: WEB SERVER CONFIGURATION

**3.1 Web Server Software on Game Nodes**
- [ ] Nginx (recommended)
- [ ] Apache
- Your choice: `_________________________________`

**3.2 PHP Version on Game Nodes**
- Example: `8.1`, `8.2`, `8.3`
- PHP Version: `_________________________________`

**3.3 PHP-FPM Socket Path** (if Nginx)
- Default: `/var/run/php/php8.1-fpm.sock`
- Your path: `_________________________________`

**3.4 Project Installation Path**
- Recommended: `/var/www/trench_city`
- Your path: `_________________________________`

**3.5 Web Root Path**
- Should be: `{project_path}/public`
- Example: `/var/www/trench_city/public`
- Your web root: `_________________________________`

---

## 📋 SECTION 4: DATABASE CONFIGURATION

**4.1 Database Name**
- Recommended: `trench_city`
- Your database name: `_________________________________`

**4.2 Database Username**
- Recommended: `trench_user`
- Your database username: `_________________________________`

**4.3 Database Password**
- **IMPORTANT:** Strong password with symbols, numbers, uppercase/lowercase
- Your database password: `_________________________________`

**4.4 Database Host** (from Game Nodes' perspective)
- Use private IP of database server
- Example: `10.0.0.10` or `db.trenchcity.internal`
- Your database host: `_________________________________`

**4.5 Database Port**
- Default: `3306`
- Your database port: `_________________________________`

**4.6 Allow Remote Connections?**
- Should be YES for game nodes to connect
- Allowed IPs: Game Node 1 & 2 private IPs
- Confirm: `_________________________________`

---

## 📋 SECTION 5: REDIS CONFIGURATION

**5.1 Redis Host** (from Game Nodes' perspective)
- Use private IP of Redis server
- Example: `10.0.0.20` or `redis.trenchcity.internal`
- Your Redis host: `_________________________________`

**5.2 Redis Port**
- Default: `6379`
- Your Redis port: `_________________________________`

**5.3 Redis Password** (if configured)
- Leave blank if no password
- Your Redis password: `_________________________________`

**5.4 Redis Max Memory**
- Example: `256mb`, `512mb`, `1gb`
- Your Redis max memory: `_________________________________`

**5.5 Redis Eviction Policy**
- Recommended: `allkeys-lru`
- Your policy: `_________________________________`

---

## 📋 SECTION 6: SSL/HTTPS CONFIGURATION

**6.1 SSL Certificate Source**
- [ ] Let's Encrypt (free, auto-renewal)
- [ ] Custom SSL certificate (I have my own)
- [ ] Cloudflare (using Cloudflare SSL)
- Your choice: `_________________________________`

**6.2 Email for Let's Encrypt** (if using)
- Example: `admin@trenchcity.com`
- Your email: `_________________________________`

**6.3 Where to install SSL?**
- [ ] On Load Balancer (recommended - SSL termination)
- [ ] On Game Nodes (end-to-end encryption)
- [ ] Both
- Your choice: `_________________________________`

---

## 📋 SECTION 7: LOAD BALANCER CONFIGURATION

**7.1 Load Balancing Algorithm**
- [ ] Round Robin (equal distribution)
- [ ] Least Connections (send to least busy)
- [ ] IP Hash (same user → same server)
- Your choice: `_________________________________`

**7.2 Health Check Endpoint**
- Recommended: `/health.php`
- Your endpoint: `_________________________________`

**7.3 Session Persistence**
- [ ] Sticky Sessions (same user → same server)
- [ ] Redis-based Sessions (user can hit any server)
- Your choice: `_________________________________`

**7.4 Load Balancer Ports**
- HTTP Port: `_________________________________` (default: 80)
- HTTPS Port: `_________________________________` (default: 443)

---

## 📋 SECTION 8: APPLICATION CONFIGURATION

**8.1 Application Environment**
- [ ] production
- [ ] staging
- [ ] alpha
- Your choice: `_________________________________`

**8.2 Application Debug Mode**
- [ ] false (recommended for production)
- [ ] true (only for testing)
- Your choice: `_________________________________`

**8.3 Application Secret Key**
- **IMPORTANT:** Generate with: `openssl rand -base64 32`
- Or I can generate one for you
- Your app key: `_________________________________`
- [ ] Generate one for me

**8.4 Application URL**
- Example: `https://trenchcity.com`
- Your app URL: `_________________________________`

**8.5 Enable Application Logging?**
- [ ] Yes (recommended)
- [ ] No
- Your choice: `_________________________________`

**8.6 Log Level**
- [ ] error (only errors)
- [ ] warning (errors + warnings)
- [ ] info (errors + warnings + info)
- [ ] debug (everything)
- Your choice: `_________________________________`

---

## 📋 SECTION 9: EMAIL CONFIGURATION

**9.1 Email Provider**
- [ ] Gmail SMTP
- [ ] Mailgun (recommended for production)
- [ ] SendGrid
- [ ] Amazon SES
- [ ] Other SMTP
- [ ] PHP mail() (not recommended)
- Your choice: `_________________________________`

**9.2 SMTP Settings** (if using SMTP)
- SMTP Host: `_________________________________`
- SMTP Port: `_________________________________` (587 for TLS, 465 for SSL)
- SMTP Username: `_________________________________`
- SMTP Password: `_________________________________`
- SMTP Encryption: `_________________________________` (tls/ssl/none)

**9.3 From Email Address**
- Example: `noreply@trenchcity.com`
- Your from email: `_________________________________`

**9.4 From Name**
- Example: `Trench City`
- Your from name: `_________________________________`

---

## 📋 SECTION 10: EMAIL VERIFICATION & RECAPTCHA

**10.1 Require Email Verification?**
- [ ] Yes (users must verify email before playing)
- [ ] No (users can play immediately)
- Your choice: `_________________________________`

**10.2 reCAPTCHA Site Key**
- Get from: https://www.google.com/recaptcha/admin
- Your site key: `_________________________________`

**10.3 reCAPTCHA Secret Key**
- From same reCAPTCHA admin page
- Your secret key: `_________________________________`

**10.4 Enable reCAPTCHA?**
- [ ] Yes (recommended for production)
- [ ] No (for testing)
- Your choice: `_________________________________`

---

## 📋 SECTION 11: BACKUP CONFIGURATION

**11.1 Backup Storage Location**
- [ ] Local server (`/var/backups/trench_city`)
- [ ] Network storage (NAS/NFS)
- [ ] Cloud storage (S3, Backblaze, etc.)
- Your choice: `_________________________________`

**11.2 Backup Path** (if local)
- Default: `/var/backups/trench_city`
- Your path: `_________________________________`

**11.3 Backup Retention**
- How many days to keep backups?
- Default: `7` days
- Your preference: `_________________________________` days

**11.4 Backup Schedule**
- Daily at what time? (server time)
- Default: `2:00 AM`
- Your time: `_________________________________`

**11.5 What to Backup?**
- [ ] Database only
- [ ] Database + Files
- [ ] Database + Files + Logs
- Your choice: `_________________________________`

---

## 📋 SECTION 12: MONITORING & ALERTS

**12.1 Monitoring Email**
- Email for system alerts (downtime, errors, etc.)
- Your email: `_________________________________`

**12.2 Enable Email Alerts?**
- [ ] Yes (get notified of critical issues)
- [ ] No
- Your choice: `_________________________________`

**12.3 Alert Thresholds**
- CPU usage alert at: `_________________________________`% (default: 80%)
- Memory usage alert at: `_________________________________`% (default: 85%)
- Disk usage alert at: `_________________________________`% (default: 90%)

---

## 📋 SECTION 13: GAME SETTINGS

**13.1 Starting Cash for New Players**
- Default: `5000`
- Your value: `_________________________________`

**13.2 Starting Stats (Each Stat)**
- Default: `10` (Strength, Speed, Defense, Dexterity)
- Your value: `_________________________________`

**13.3 Energy Regeneration Rate (per 5 min)**
- Default: `5`
- Your value: `_________________________________`

**13.4 Nerve Regeneration Rate (per 5 min)**
- Default: `1`
- Your value: `_________________________________`

**13.5 Server Timezone**
- Example: `UTC`, `America/New_York`, `Europe/London`
- Your timezone: `_________________________________`

---

## 📋 SECTION 14: ADMIN ACCESS

**14.1 Initial Admin Username**
- Your admin username: `_________________________________`

**14.2 Initial Admin Email**
- Your admin email: `_________________________________`

**14.3 Initial Admin Password**
- Strong password for admin account
- Your admin password: `_________________________________`

---

## 📋 SECTION 15: SECURITY

**15.1 Firewall Configuration**
- [ ] UFW (Ubuntu)
- [ ] iptables
- [ ] Cloud firewall (IONOS firewall)
- [ ] All of the above
- Your choice: `_________________________________`

**15.2 SSH Key Authentication**
- [ ] Yes (password login disabled)
- [ ] No (using passwords)
- Your choice: `_________________________________`

**15.3 Fail2Ban Installation**
- [ ] Yes (recommended - blocks brute force)
- [ ] No
- Your choice: `_________________________________`

**15.4 Rate Limiting**
- Enable Redis-based rate limiting?
- [ ] Yes (recommended)
- [ ] No
- Your choice: `_________________________________`

---

## 📋 SECTION 16: FILE SYNC (MULTI-SERVER)

**16.1 How to Sync Files Between Game Nodes?**
- [ ] Rsync (manual or cron)
- [ ] NFS (network file share)
- [ ] GlusterFS (distributed filesystem)
- [ ] Deploy separately to each (Git pull on each)
- Your choice: `_________________________________`

**16.2 Shared Storage for Uploads?**
- [ ] Yes (need shared storage for user uploads)
- [ ] No (no user uploads yet)
- Your choice: `_________________________________`

---

## 📋 SECTION 17: DEPLOYMENT METHOD

**17.1 How Do You Want to Deploy?**
- [ ] Manual (I'll SSH and copy files)
- [ ] Git (pull from repository on each server)
- [ ] Automated script (you provide deployment script)
- Your choice: `_________________________________`

**17.2 Git Repository** (if using Git)
- Repository URL: `_________________________________`
- Branch: `_________________________________` (default: `main`)

**17.3 Who Can Deploy?**
- [ ] Root user
- [ ] Specific user: `_________________________________`
- [ ] CI/CD system (GitHub Actions, GitLab CI, etc.)
- Your choice: `_________________________________`

---

## 📋 SECTION 18: IONOS-SPECIFIC

**18.1 IONOS Data Center Location**
- Example: `US`, `EU`, `UK`
- Your location: `_________________________________`

**18.2 Internal Network Subnet**
- Example: `10.0.0.0/24`
- Your subnet: `_________________________________`

**18.3 IONOS Load Balancer Type**
- [ ] IONOS managed load balancer
- [ ] Custom VM running Nginx/HAProxy
- Your type: `_________________________________`

---

## ✅ SUMMARY CHECKLIST

Before submitting, verify you've provided:

### Critical Info:
- [ ] Domain name
- [ ] All server IP addresses (public & private)
- [ ] Database credentials (name, user, password)
- [ ] Redis host and password
- [ ] Web server choice (Nginx/Apache)
- [ ] PHP version
- [ ] SSL choice (Let's Encrypt/Custom)
- [ ] Application secret key

### Important Info:
- [ ] Email provider & credentials
- [ ] reCAPTCHA keys
- [ ] Load balancing method
- [ ] Session storage method
- [ ] Backup configuration
- [ ] Monitoring email

### Optional Info:
- [ ] Game settings (cash, stats, regen rates)
- [ ] Admin account details
- [ ] Deployment method
- [ ] File sync method

---

## 📤 WHAT YOU'LL GET BACK

Once you provide all this info, I'll generate:

1. **`.env` files** - One for each game node with exact settings
2. **Nginx/Apache configs** - Load balancer + both game nodes
3. **MySQL config** - Database server setup with remote access
4. **Redis config** - Redis server optimized settings
5. **Load balancer config** - HAProxy or Nginx upstream config
6. **Automated deployment script** - One command deployment
7. **Firewall rules** - For all servers
8. **Health check endpoint** - `/health.php` for load balancer
9. **Backup scripts** - Automated database backups
10. **Monitoring setup** - System monitoring scripts
11. **Cron jobs** - For all servers
12. **Session sharing config** - Redis-based sessions
13. **SSL certificate commands** - Let's Encrypt for all domains
14. **Complete deployment guide** - Step-by-step for your exact setup

**Everything will be copy-paste ready with YOUR exact values!** 🚀

---

**Fill this out and send it back, and I'll generate your complete production infrastructure!**
