# 🚀 TRENCH CITY V2 - DEPLOYMENT WIZARD

**Multi-Server Production Setup for IONOS Infrastructure**

---

## 📌 OVERVIEW

You have 5 blank IONOS servers that need complete setup:
- **2x Game Nodes** (web servers running PHP/Nginx)
- **1x Load Balancer** (Nginx distributing traffic)
- **1x Database Server** (MySQL/MariaDB)
- **1x Redis Server** (session storage & caching)

This wizard will guide you through setup in **3 phases**:

---

## 🎯 PHASE 1: QUICK START (Essential Info Only)

**Time to complete: 5-10 minutes**

Fill this out first, and I'll generate your initial working configs:

### 1.1 Domain Information
```
Domain name: trenchmade.co.uk but i want it to be redirected to https://www.trenchmade.co.uk no matter what combination they type for proffessionalism 
Example: trenchcity.com

Load Balancer Public IP: 82.165.200.104
(Point your domain's A record to this IP)
```

### 1.2 Server Private IPs (Internal Network)
```
Load Balancer Private IP: 10.7.222.226/24
Game Node 1 Private IP:   10.7.222.11
Game Node 2 Private IP:   10.7.222.12
Database Private IP:      10.7.222.14
Redis Private IP:         10.7.222.13
Example: 10.0.0.5, 10.0.0.10, etc.
```

### 1.3 Database Credentials (Choose Strong Passwords)
```
Database Name:     trench_city
Database Username: trench
Database Password: Rianna2602

```

### 1.4 Redis Password
```
Redis Password: Rianna2602
```

### 1.5 Application Secret Key
```
[ ] Generate one for me (recommended)

```

### 1.6 Admin Account (First Login)
```
Admin Username: TrenchMade
Admin Email:    ceo@tmghq.co.uk
Admin Password: Rianna2602!
```

### 1.7 Software Versions on Game Nodes
```
PHP Version:  [x] 8.1  [ ] 8.2  [ ] 8.3  [ ] Not installed yet
Web Server:   [x] Nginx  [ ] Apache  [ ] Not installed yet
OS:           [x] Ubuntu 22.04  [ ] Ubuntu 24.04  [ ] Debian 12  [ ] Other: _______
```

---

## 📧 PHASE 2: EMAIL CONFIGURATION (Required for Verification)

**Time to complete: 5-10 minutes**

Choose ONE email provider for sending verification emails:

### Option A: Google Workspace / Gmail Business (Recommended for Small-Medium)

```
Your Business Gmail: _________________________________
App Password: _________________________________ (get from: myaccount.google.com/apppasswords)

From Email Address: _________________________________ (e.g., noreply@yourdomain.com)
From Name: Trench City
```

**Setup Steps:**
1. Go to https://myaccount.google.com/apppasswords
2. Select "Mail" → "Other (Custom name)" → "Trench City"
3. Copy the 16-character password
4. Paste above

---

### Option B: Mailgun (Recommended for Production)

```
Mailgun SMTP Username: _________________________________
Mailgun SMTP Password: _________________________________
Mailgun Domain: _________________________________

From Email Address: _________________________________ (must match Mailgun domain)
From Name: Trench City
```

**Setup Steps:**
1. Sign up at https://www.mailgun.com/
2. Add and verify your domain
3. Get SMTP credentials from Mailgun dashboard → Sending → Domain Settings

---

### Option C: Microsoft 365 Business Email

```
Microsoft 365 Email: _________________________________
Microsoft 365 Password: _________________________________

From Email Address: _________________________________ (same as above)
From Name: Trench City
```

---

### Option D: SendGrid

```
SendGrid API Key: _________________________________

From Email Address: _________________________________
From Name: Trench City
```

**Setup Steps:**
1. Sign up at https://sendgrid.com/
2. Create API key (Settings → API Keys → Create API Key)
3. Choose "Full Access" permission
4. Copy key and paste above

---

### Option E: IONOS Email (If you have IONOS email hosting)

```
IONOS Email Address: no-reply@trenchmade.co.uk
IONOS Email Password: Rianna2602
IONOS SMTP Host: Not sure (usually smtp.ionos.com or smtp.1and1.com)

From Email Address: _________________________________ (same as IONOS email)
From Name: Trench City
```

---

### Email Settings

```
[x] Require email verification (users must verify email before playing)
```

---

## 🤖 PHASE 3: reCAPTCHA (Bot Protection)

**Time to complete: 3-5 minutes**

### Get reCAPTCHA Keys

1. Go to: https://www.google.com/recaptcha/admin/create
2. Choose **reCAPTCHA v2** → "I'm not a robot" Checkbox
3. Add your domain (e.g., `trenchcity.com`)
4. Accept terms and submit

```
reCAPTCHA Site Key:   6LeY9C4sAAAAAAJjMR_xoB7S6tlCrUATNWFXnx0Q
reCAPTCHA Secret Key: 6LeY9C4sAAAAAD3N-6yuhfzNYZTgNOmFUZB766xL

[x] Enable reCAPTCHA on registration
[ ] Disable reCAPTCHA (for testing only)
```

---

## ⚙️ PHASE 4: ADVANCED SETTINGS (Optional)

**Can be configured later, but recommended now:**

### 4.1 SSL Certificate
```
[ ] Let's Encrypt (free, recommended)
    Email for SSL notifications: admin@trenchmade.co.uk

[ ] Custom SSL Certificate (I have my own)
    - Will need .crt and .key files

[ ] Cloudflare (using Cloudflare SSL)
```

### 4.2 SSH Access (for deployment scripts)
```
Load Balancer SSH:
  Username: root Port: 22 (default: 22)

Game Node 1 SSH:
  Username: root Port: 22

Game Node 2 SSH:
  Username: root Port: 22

Database Server SSH:
  Username: root Port: 22

Redis Server SSH:
  Username: root Port: 22
```

### 4.3 Load Balancer Algorithm
```
not setup but i want 
[x] Round Robin (equal distribution - recommended)
[ ] Least Connections (send to least busy server)
[ ] IP Hash (same user always goes to same server)
```

### 4.4 Backup Configuration
```
Daily backup time (server time): 2:00AM (default: 2:00 AM)
Backup retention days: 7 days (default: 7 days)
Backup location: /var/backups/trench_city

[ ] Database only
[x] Database + uploaded files
```

### 4.5 Monitoring Email
```
Alert email for system issues: admin@trenchmade.co.uk
```

### 4.6 Game Settings
```
Starting cash for new players: 10000 (default: 5000)
Starting stats (each): 10 (default: 10)
Energy regen per 5 min: 5 (default: 5)
Nerve regen per 5 min: 1 (default: 1)

Server timezone: London (e.g., UTC, America/New_York, Europe/London)
```

---

## 📋 WHAT YOU'LL GET

Once you provide the information above, I will generate:

### Immediate Deliverables:

1. **Configuration Files** (copy-paste ready):
   - `.env` for Game Node 1
   - `.env` for Game Node 2
   - Nginx config for Load Balancer
   - Nginx config for Game Nodes
   - MySQL configuration
   - Redis configuration
   - PHP-FPM pool config

2. **Installation Scripts**:
   - `setup_load_balancer.sh` - One command LB setup
   - `setup_game_node.sh` - One command game node setup
   - `setup_database.sh` - One command DB setup
   - `setup_redis.sh` - One command Redis setup
   - `deploy_code.sh` - Deploy game code to both nodes
   - `master_install.sh` - Run all setups in sequence

3. **Database Setup**:
   - Complete SQL schema import
   - User creation with proper permissions
   - Remote access configuration
   - Initial data seeding

4. **Documentation**:
   - Step-by-step deployment guide
   - Testing & verification checklist
   - Troubleshooting guide
   - Architecture diagram

5. **Security Configurations**:
   - Firewall rules (UFW) for each server
   - Fail2Ban configuration
   - SSH hardening
   - Rate limiting rules

6. **Monitoring & Maintenance**:
   - Health check endpoint
   - Cron jobs for all servers
   - Backup scripts
   - Log rotation configs

---

## 🚀 DEPLOYMENT TIME ESTIMATE

**With all configs generated:**
- Load Balancer setup: 15 minutes
- Database Server setup: 15 minutes
- Redis Server setup: 10 minutes
- Game Node 1 setup: 20 minutes
- Game Node 2 setup: 15 minutes
- Code deployment: 10 minutes
- Testing & verification: 15 minutes

**Total: ~2 hours** (vs 8-12 hours manual setup)

---

## ✅ QUICK START CHECKLIST

**Before we begin, ensure you have:**

- [ ] SSH access to all 5 servers (root or sudo user)
- [ ] Your domain's DNS management access
- [ ] Chosen email provider credentials ready
- [ ] reCAPTCHA account (or willing to create one)
- [ ] Decided on strong passwords for database/Redis

**Optional but helpful:**
- [ ] Git repository URL (if using Git deployment)
- [ ] SSL certificate files (if not using Let's Encrypt)

---

## 📝 HOW TO PROCEED

**Option 1: Fill Everything Now (Recommended)**
Complete all sections above and send back. I'll generate everything in one go.

**Option 2: Minimal Start (Faster)**
Fill only PHASE 1 + PHASE 2 (Email). I'll generate basic working configs, then we can add reCAPTCHA and advanced features later.

**Option 3: Interactive Wizard**
Answer questions one section at a time as I guide you through.

---

## 🎯 SAMPLE FILLED EXAMPLE

Here's what a completed Phase 1 might look like:

```
Domain name: example-trenchcity.com
Load Balancer Public IP: 185.123.45.67

Load Balancer Private IP: 10.0.0.5
Game Node 1 Private IP:   10.0.0.10
Game Node 2 Private IP:   10.0.0.11
Database Private IP:      10.0.0.20
Redis Private IP:         10.0.0.30

Database Name:     trench_city
Database Username: trench_user
Database Password: Xk9$mP2#vL8@wN4&qR7!zT1^

Redis Password: bN3!vC6@mK9#pL2$wX5&

Application Secret Key: [X] Generate one for me

Admin Username: shadowadmin
Admin Email:    admin@example-trenchcity.com
Admin Password: MySecure2024Pass!

PHP Version:  [X] 8.2
Web Server:   [X] Nginx
OS:           [X] Ubuntu 22.04
```

---

**Ready when you are! Send back the completed form and I'll generate your complete production infrastructure.** 🚀
