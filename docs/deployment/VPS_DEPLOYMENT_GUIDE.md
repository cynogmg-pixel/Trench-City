# 🚀 TRENCH CITY V2 - VPS DEPLOYMENT GUIDE

**Environment:** Single VPS (Web + Database)
**Web Root:** `/var/www/trench_city/public`
**Project Root:** `/var/www/trench_city`

---

## 📁 DIRECTORY STRUCTURE ON VPS

```
/var/www/trench_city/
├── core/                    # System core (accessible via require_once)
├── modules/                 # Game modules (accessible via require_once)
├── includes/                # Shared templates (accessible via require_once)
├── storage/                 # Logs and cache
│   └── logs/               # Application logs (needs 777)
├── .env                     # Configuration (needs 644)
└── public/                  # WEB ROOT - /var/www/trench_city/public
    ├── index.php
    ├── dashboard.php
    ├── gym.php
    ├── crimes.php
    ├── combat.php
    ├── bank.php
    ├── mail.php
    ├── leaderboards.php
    ├── profile.php
    └── assets/
        ├── css/
        ├── js/
        └── imgs/
```

---

## 🔧 NGINX CONFIGURATION

Create: `/etc/nginx/sites-available/trenchcity`

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name your-domain.com www.your-domain.com;

    # Document root points to /public
    root /var/www/trench_city/public;
    index index.php index.html;

    # Logging
    access_log /var/log/nginx/trenchcity-access.log;
    error_log /var/log/nginx/trenchcity-error.log;

    # Max upload size
    client_max_body_size 10M;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Main location block
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP handling
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;  # Adjust PHP version
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;

        # Increase timeout for long operations
        fastcgi_read_timeout 300;
        fastcgi_send_timeout 300;
    }

    # Deny access to sensitive files
    location ~ /\.env {
        deny all;
        return 404;
    }

    location ~ /\.git {
        deny all;
        return 404;
    }

    # Deny access to parent directories
    location ~ ^/(core|modules|includes|storage|vendor)/ {
        deny all;
        return 404;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to .php files in uploads
    location ~* /assets/.*\.php$ {
        deny all;
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/trenchcity /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔧 APACHE CONFIGURATION (Alternative)

Create: `/etc/apache2/sites-available/trenchcity.conf`

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com

    # Document root points to /public
    DocumentRoot /var/www/trench_city/public

    <Directory /var/www/trench_city/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Deny access to parent directories
    <DirectoryMatch "^/var/www/trench_city/(core|modules|includes|storage|vendor)">
        Require all denied
    </DirectoryMatch>

    # Deny .env
    <Files .env>
        Require all denied
    </Files>

    # Logging
    ErrorLog ${APACHE_LOG_DIR}/trenchcity-error.log
    CustomLog ${APACHE_LOG_DIR}/trenchcity-access.log combined
</VirtualHost>
```

Create `.htaccess` in `/var/www/trench_city/public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Redirect to HTTPS (after SSL setup)
    # RewriteCond %{HTTPS} off
    # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Handle missing files
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L,QSA]
</IfModule>

# Security
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# PHP settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value max_input_time 300
```

Enable site:
```bash
sudo a2enmod rewrite
sudo a2ensite trenchcity
sudo systemctl reload apache2
```

---

## 🐘 PHP-FPM CONFIGURATION

Edit: `/etc/php/8.1/fpm/pool.d/www.conf`

```ini
[www]
user = www-data
group = www-data

listen = /var/run/php/php8.1-fpm.sock
listen.owner = www-data
listen.group = www-data

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 500

; Increase timeouts for long operations
request_terminate_timeout = 300
```

Edit: `/etc/php/8.1/fpm/php.ini`

```ini
; Memory and execution
memory_limit = 256M
max_execution_time = 300
max_input_time = 300

; Uploads
upload_max_filesize = 10M
post_max_size = 10M

; Sessions
session.save_handler = files
session.save_path = /var/lib/php/sessions
session.gc_maxlifetime = 7200

; Error handling (production)
display_errors = Off
log_errors = On
error_log = /var/log/php-fpm-errors.log

; Security
expose_php = Off
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.1-fpm
```

---

## 🗄️ MYSQL/MARIADB CONFIGURATION

Edit: `/etc/mysql/mariadb.conf.d/50-server.cnf` or `/etc/mysql/mysql.conf.d/mysqld.cnf`

```ini
[mysqld]
# Bind to localhost only (same machine)
bind-address = 127.0.0.1

# Character set
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Performance
max_connections = 200
connect_timeout = 10
wait_timeout = 600
max_allowed_packet = 64M
thread_cache_size = 128
sort_buffer_size = 4M
bulk_insert_buffer_size = 16M
tmp_table_size = 32M
max_heap_table_size = 32M

# Query cache (if available)
query_cache_limit = 2M
query_cache_size = 64M

# Logging
log_error = /var/log/mysql/error.log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow-query.log
long_query_time = 2
```

Restart MySQL:
```bash
sudo systemctl restart mysql
```

---

## 📦 COMPLETE DEPLOYMENT STEPS

### Step 1: Upload Files to VPS

```bash
# On your local machine (if using Git)
git clone <your-repo>
cd trench_city_v2_master_skeleton

# Upload to VPS via SCP
scp -r * user@your-vps:/var/www/trench_city/

# OR via SFTP/FTP client
# OR via Git on VPS
```

### Step 2: Set File Permissions

```bash
# SSH into VPS
ssh user@your-vps

# Navigate to project
cd /var/www/trench_city

# Set ownership
sudo chown -R www-data:www-data /var/www/trench_city

# Set directory permissions
sudo find /var/www/trench_city -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/trench_city -type f -exec chmod 644 {} \;

# Set storage writable
sudo chmod -R 777 /var/www/trench_city/storage/logs

# Protect .env
sudo chmod 600 /var/www/trench_city/.env

# Make installers executable (if needed)
sudo chmod +x /var/www/trench_city/*.sh
```

### Step 3: Configure Environment

```bash
cd /var/www/trench_city

# Copy example env
cp .env.example .env

# Edit .env
sudo nano .env
```

**.env Configuration:**

```env
# Database (localhost since same machine)
DB_HOST=localhost
DB_PORT=3306
DB_NAME=trench_city
DB_USER=trench_user
DB_PASS=your_secure_password_here

# Application
APP_ENV=production
APP_KEY=generate-random-32-character-key-here
APP_URL=https://your-domain.com
APP_DEBUG=false

# Redis (optional - localhost since same machine)
REDIS_ENABLED=true
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=

# Session
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true

# Security
BCRYPT_ROUNDS=12
CSRF_TOKEN_LENGTH=32
```

### Step 4: Create Database User

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE trench_city CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'trench_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';
GRANT ALL PRIVILEGES ON trench_city.* TO 'trench_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Install Database Schema

```bash
cd /var/www/trench_city

# Install core schema
mysql -u trench_user -p trench_city < core/init_schema_v0.sql

# Install gym system
mysql -u trench_user -p trench_city < core/gym_data.sql

# Install crimes system
mysql -u trench_user -p trench_city < core/crimes_schema.sql
mysql -u trench_user -p trench_city < core/crimes_data.sql

# Install alpha systems (NEW)
mysql -u trench_user -p trench_city < core/combat_schema.sql
mysql -u trench_user -p trench_city < core/bank_schema.sql
mysql -u trench_user -p trench_city < core/mail_schema.sql

# Verify tables
mysql -u trench_user -p trench_city -e "SHOW TABLES;"
```

### Step 6: Configure Web Server

```bash
# For Nginx (recommended)
sudo nano /etc/nginx/sites-available/trenchcity
# [Paste configuration from above]

sudo ln -s /etc/nginx/sites-available/trenchcity /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# OR for Apache
sudo nano /etc/apache2/sites-available/trenchcity.conf
# [Paste configuration from above]

sudo a2enmod rewrite
sudo a2ensite trenchcity
sudo systemctl reload apache2
```

### Step 7: Install SSL Certificate (Let's Encrypt)

```bash
# Install certbot
sudo apt update
sudo apt install certbot

# For Nginx
sudo apt install python3-certbot-nginx
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# For Apache
sudo apt install python3-certbot-apache
sudo certbot --apache -d your-domain.com -d www.your-domain.com

# Auto-renewal (already set up by certbot)
sudo certbot renew --dry-run
```

### Step 8: Configure Firewall

```bash
# UFW (Ubuntu)
sudo ufw allow 'Nginx Full'  # or 'Apache Full'
sudo ufw allow 22/tcp         # SSH
sudo ufw enable
sudo ufw status

# iptables (alternative)
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 22 -j ACCEPT
```

### Step 9: Set Up Cron Jobs

```bash
# Edit crontab for www-data
sudo crontab -e -u www-data

# Add these jobs:
# Bar regeneration (every 5 minutes)
*/5 * * * * /usr/bin/php /var/www/trench_city/core/cron/regenerate_bars.php >> /var/www/trench_city/storage/logs/cron.log 2>&1

# Daily cleanup (every day at 3 AM)
0 3 * * * /usr/bin/php /var/www/trench_city/core/cron/daily_cleanup.php >> /var/www/trench_city/storage/logs/cron.log 2>&1

# Database backup (every day at 2 AM)
0 2 * * * /usr/bin/mysqldump -u trench_user -p'password' trench_city | gzip > /var/www/trench_city/storage/backups/db_$(date +\%Y\%m\%d).sql.gz
```

### Step 10: Test Deployment

```bash
# Test PHP
curl http://localhost/index.php

# Test database connection
/usr/bin/php /var/www/trench_city/public/dbtest.php

# Check logs
tail -f /var/log/nginx/trenchcity-error.log
# OR
tail -f /var/log/apache2/trenchcity-error.log

# Check PHP errors
tail -f /var/log/php-fpm-errors.log

# Check application logs
tail -f /var/www/trench_city/storage/logs/app.log
```

---

## 🔒 SECURITY HARDENING

### 1. Secure .env File

```bash
sudo chmod 600 /var/www/trench_city/.env
sudo chown www-data:www-data /var/www/trench_city/.env
```

### 2. Disable Directory Listing

Already handled in Nginx/Apache config with `-Indexes`

### 3. Disable PHP Info Pages

```bash
# Remove any phpinfo() calls
sudo find /var/www/trench_city -name "*.php" -exec grep -l "phpinfo()" {} \;
# Delete or comment out phpinfo() lines
```

### 4. Install Fail2Ban

```bash
sudo apt install fail2ban

# Create jail for Nginx/Apache
sudo nano /etc/fail2ban/jail.local
```

```ini
[nginx-noscript]
enabled = true
port = http,https
filter = nginx-noscript
logpath = /var/log/nginx/trenchcity-access.log
maxretry = 6
bantime = 3600

[nginx-badbots]
enabled = true
port = http,https
filter = nginx-badbots
logpath = /var/log/nginx/trenchcity-access.log
maxretry = 2
bantime = 86400
```

```bash
sudo systemctl restart fail2ban
```

### 5. Set Up Automatic Updates

```bash
sudo apt install unattended-upgrades
sudo dpkg-reconfigure --priority=low unattended-upgrades
```

---

## 📊 MONITORING & MAINTENANCE

### Log Files to Monitor

```bash
# Application logs
/var/www/trench_city/storage/logs/app.log
/var/www/trench_city/storage/logs/cron.log

# Web server logs
/var/log/nginx/trenchcity-access.log
/var/log/nginx/trenchcity-error.log
# OR
/var/log/apache2/trenchcity-access.log
/var/log/apache2/trenchcity-error.log

# PHP logs
/var/log/php-fpm-errors.log

# Database logs
/var/log/mysql/error.log
/var/log/mysql/slow-query.log
```

### Useful Commands

```bash
# Check disk space
df -h

# Check memory usage
free -h

# Check CPU usage
top

# Check running processes
ps aux | grep php
ps aux | grep nginx
ps aux | grep mysql

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
sudo systemctl restart mysql

# View real-time logs
tail -f /var/www/trench_city/storage/logs/app.log

# Database optimization
mysql -u trench_user -p trench_city -e "OPTIMIZE TABLE users, combat_logs, bank_transactions, mail_messages;"
```

---

## 🚀 PERFORMANCE OPTIMIZATION

### 1. Enable OPcache

Edit: `/etc/php/8.1/fpm/php.ini`

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

### 2. Install and Configure Redis

```bash
sudo apt install redis-server

# Configure Redis
sudo nano /etc/redis/redis.conf
```

```conf
bind 127.0.0.1
maxmemory 256mb
maxmemory-policy allkeys-lru
```

```bash
sudo systemctl restart redis
sudo systemctl enable redis
```

Update .env:
```env
REDIS_ENABLED=true
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### 3. MySQL Query Optimization

```sql
-- Add indexes for common queries
USE trench_city;

-- Combat queries
CREATE INDEX idx_hospital_status ON users(hospital_until);
CREATE INDEX idx_jail_status ON users(jail_until);

-- Leaderboard queries
CREATE INDEX idx_level_xp ON users(level DESC, xp DESC);
CREATE INDEX idx_net_worth ON users((cash + bank_balance) DESC);

-- Mail queries
CREATE INDEX idx_unread_mail ON mail_messages(to_user_id, is_read, is_deleted_by_recipient);

-- Analyze tables
ANALYZE TABLE users, player_stats, combat_logs, bank_transactions, mail_messages;
```

---

## 🔄 BACKUP STRATEGY

### Automated Database Backup Script

Create: `/var/www/trench_city/scripts/backup_db.sh`

```bash
#!/bin/bash

BACKUP_DIR="/var/www/trench_city/storage/backups"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="trench_city"
DB_USER="trench_user"
DB_PASS="your_password"

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

# Dump database
/usr/bin/mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Keep only last 7 days of backups
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +7 -delete

echo "Backup completed: db_$DATE.sql.gz"
```

```bash
chmod +x /var/www/trench_city/scripts/backup_db.sh

# Add to crontab
sudo crontab -e
0 2 * * * /var/www/trench_city/scripts/backup_db.sh >> /var/www/trench_city/storage/logs/backup.log 2>&1
```

---

## 🆘 TROUBLESHOOTING

### "500 Internal Server Error"

```bash
# Check error logs
tail -50 /var/log/nginx/trenchcity-error.log
tail -50 /var/log/php-fpm-errors.log

# Check file permissions
ls -la /var/www/trench_city/public

# Test PHP syntax
php -l /var/www/trench_city/public/index.php
```

### "Database Connection Failed"

```bash
# Test MySQL connection
mysql -u trench_user -p -h localhost trench_city

# Check .env configuration
cat /var/www/trench_city/.env

# Check MySQL is running
sudo systemctl status mysql
```

### "Session/Cookie Issues"

```bash
# Check session directory
ls -la /var/lib/php/sessions

# Set proper permissions
sudo chown -R www-data:www-data /var/lib/php/sessions
sudo chmod 1733 /var/lib/php/sessions
```

### "High Memory Usage"

```bash
# Check PHP memory limit
php -i | grep memory_limit

# Check processes
top -o %MEM

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

---

## ✅ POST-DEPLOYMENT CHECKLIST

- [ ] All files uploaded to `/var/www/trench_city`
- [ ] Permissions set correctly (755/644)
- [ ] .env configured with production settings
- [ ] Database created and schemas installed
- [ ] Web server configured and reloaded
- [ ] SSL certificate installed
- [ ] Firewall configured
- [ ] Cron jobs set up
- [ ] Backups configured
- [ ] Monitoring enabled
- [ ] Test user registration
- [ ] Test all game features
- [ ] Check all logs for errors
- [ ] Security audit completed

---

## 📞 QUICK REFERENCE

**Project Root:** `/var/www/trench_city`
**Web Root:** `/var/www/trench_city/public`
**Logs:** `/var/www/trench_city/storage/logs`
**Backups:** `/var/www/trench_city/storage/backups`

**Restart Services:**
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
sudo systemctl restart mysql
sudo systemctl restart redis
```

**View Logs:**
```bash
tail -f /var/log/nginx/trenchcity-error.log
tail -f /var/www/trench_city/storage/logs/app.log
```

**Database Access:**
```bash
mysql -u trench_user -p trench_city
```

---

**Your Trench City V2 game is now ready for production on your VPS!** 🎮

---

*Last Updated: December 17, 2025*
*Version: Alpha 1.0.0*
*Environment: VPS Single Server*
