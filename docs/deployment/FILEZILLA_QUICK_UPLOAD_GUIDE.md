# 🚀 FILEZILLA QUICK UPLOAD GUIDE

## Ready-to-Upload Directory Created!

I've created a clean `trench_city/` directory with **all application files** ready for direct upload via FileZilla.

---

## 📁 What's Inside `trench_city/`

```
trench_city/
├── .env                  ← Production configuration
├── assets/               ← CSS, JS, images
├── core/                 ← Database, helpers, security
├── includes/             ← Headers, footers, navigation
├── modules/              ← Game features (gym, crimes, combat, etc.)
├── public/               ← Web-accessible files
├── scripts/              ← Utility scripts
├── services/             ← Background services
└── storage/              ← Logs, cache, sessions
```

**Size:** 6.6 MB
**Files:** All PHP, CSS, JS, SQL, and application files
**Excluded:** All *.md documentation files ✅
**Excluded:** production_configs/ ✅
**Excluded:** .git/ ✅
**Excluded:** node_modules/ ✅

---

## 🎯 UPLOAD INSTRUCTIONS

### Game Node 1 (10.7.222.11)

**1. Connect via FileZilla:**
```
Host:     sftp://10.7.222.11
Username: root
Password: [Your root password]
Port:     22
```

**2. Navigate on Server (Right Panel):**
```
/var/www/
```

**3. Upload (Drag & Drop):**
```
Drag entire "trench_city" folder from left panel → /var/www/ on right panel
```

**4. Verify Upload:**
```
Server should now have: /var/www/trench_city/
```

**5. Set Permissions via SSH:**
```bash
ssh root@10.7.222.11
chown -R www-data:www-data /var/www/trench_city
chmod -R 755 /var/www/trench_city
chmod 640 /var/www/trench_city/.env
chmod 750 /var/www/trench_city/storage
chmod 750 /var/www/trench_city/storage/logs
```

**6. Restart PHP-FPM:**
```bash
systemctl restart php8.1-fpm
```

---

### Game Node 2 (10.7.222.12)

**Repeat exact same steps as Game Node 1, but:**

**IMPORTANT:** After uploading, update the `.env` file:

```bash
ssh root@10.7.222.12
nano /var/www/trench_city/.env

# Change this line:
SERVER_NODE=game_node_1

# To:
SERVER_NODE=game_node_2

# Save: Ctrl+X, Y, Enter
```

**Then set permissions and restart:**
```bash
chown -R www-data:www-data /var/www/trench_city
chmod -R 755 /var/www/trench_city
chmod 640 /var/www/trench_city/.env
chmod 750 /var/www/trench_city/storage
chmod 750 /var/www/trench_city/storage/logs
systemctl restart php8.1-fpm
```

---

## ⚡ ALTERNATIVE: Upload Only Changed Files

If you've already uploaded before and only want to update specific files:

**Updated Files in This Session:**
```
core/db.php                  ← Added getDB() function
core/errors.php              ← Enhanced error display
public/login.php             ← Fixed placeholder issue
public/login_new.php         ← Fixed PDO methods + placeholder
.env                         ← Production config
```

**Upload just these 5 files to both nodes, then restart PHP-FPM.**

---

## 📊 VERIFICATION

After upload, verify these paths exist on the server:

```bash
ssh root@10.7.222.11
ls -la /var/www/trench_city/
ls -la /var/www/trench_city/core/db.php
ls -la /var/www/trench_city/public/login.php
ls -la /var/www/trench_city/.env
ls -la /var/www/trench_city/storage/logs/
```

**Expected output:** All files should exist with proper permissions.

---

## 🧪 TEST AFTER UPLOAD

**1. Test Direct Access:**
```
https://www.trenchmade.co.uk/
```
Should load the landing page.

**2. Test Login:**
```
https://www.trenchmade.co.uk/login.php
Username: TrenchMade
Password: Rianna2602!
```
Should login successfully and redirect to dashboard.

**3. Test Error Display:**
If any errors occur, you should see the detailed error page with:
- Error type
- Error message
- File and line number
- Stack trace
- Debugging hints

---

## 🔧 TROUBLESHOOTING

### Issue: "Permission denied" during upload

**Solution:**
```bash
# On server, ensure /var/www/ is writable
ssh root@10.7.222.11
chmod 755 /var/www
```

### Issue: Files uploaded but site shows errors

**Solution:**
```bash
# Fix permissions
chown -R www-data:www-data /var/www/trench_city
chmod -R 755 /var/www/trench_city
systemctl restart nginx php8.1-fpm
```

### Issue: .env file not found

**Solution:**
```bash
# Check if .env was uploaded
ls -la /var/www/trench_city/.env

# If missing, upload again (FileZilla sometimes skips hidden files)
# Or create manually:
cp /root/game_node_1.env /var/www/trench_city/.env
chown www-data:www-data /var/www/trench_city/.env
chmod 640 /var/www/trench_city/.env
```

### Issue: Storage logs not writable

**Solution:**
```bash
mkdir -p /var/www/trench_city/storage/logs
chown -R www-data:www-data /var/www/trench_city/storage
chmod -R 750 /var/www/trench_city/storage
```

---

## 📝 DIRECTORY STRUCTURE REFERENCE

```
/var/www/trench_city/
│
├── .env                              ← Configuration (MUST be chmod 640)
│
├── public/                           ← Web root (Nginx points here)
│   ├── index.php                     ← Landing page
│   ├── login.php                     ← Login (fixed)
│   ├── login_new.php                 ← Login with email verification (fixed)
│   ├── register.php                  ← Registration
│   ├── register_new.php              ← Registration with reCAPTCHA
│   ├── dashboard.php                 ← Player dashboard
│   ├── profile.php                   ← Player profiles
│   ├── leaderboards.php              ← Rankings
│   └── ...
│
├── core/                             ← Core system (UPDATED)
│   ├── bootstrap.php                 ← Application loader
│   ├── db.php                        ← Database (UPDATED - has getDB())
│   ├── errors.php                    ← Error handler (UPDATED - detailed display)
│   ├── security.php                  ← CSRF, session security
│   ├── helpers.php                   ← Helper functions
│   └── ...
│
├── modules/                          ← Game features
│   ├── gym/gym_shell.php            ← Gym training
│   ├── crimes/crimes_shell.php      ← Crimes
│   ├── combat/combat_shell.php      ← PvP combat
│   ├── bank/bank_shell.php          ← Banking
│   ├── mail/mail_shell.php          ← Messaging
│   └── ...
│
├── includes/                         ← Shared components
│   ├── prelogin-header.php          ← Header for login/register
│   ├── postlogin-header.php         ← Header for authenticated pages
│   ├── postlogin-sidebar.php        ← Navigation sidebar
│   └── ...
│
├── assets/                           ← Static files
│   ├── css/                          ← Stylesheets
│   ├── js/                           ← JavaScript
│   └── imgs/                         ← Images
│
├── storage/                          ← Data storage (MUST be writable)
│   ├── logs/                         ← Application logs
│   ├── cache/                        ← Cache files
│   └── sessions/                     ← File-based sessions (if used)
│
├── scripts/                          ← Utility scripts
└── services/                         ← Background services
```

---

## ✅ POST-UPLOAD CHECKLIST

- [ ] trench_city/ folder uploaded to /var/www/
- [ ] .env file exists and has correct permissions (640)
- [ ] storage/logs/ is writable by www-data
- [ ] Game Node 2 has SERVER_NODE=game_node_2 in .env
- [ ] PHP-FPM restarted on both nodes
- [ ] Website loads at https://www.trenchmade.co.uk/
- [ ] Login works with admin account
- [ ] Error display shows detailed information (if any errors)

---

## 🎉 YOU'RE DONE!

**The `trench_city/` directory is ready to upload!**

**Simply:**
1. Open FileZilla
2. Connect to 10.7.222.11
3. Drag `trench_city` folder to `/var/www/`
4. Set permissions via SSH
5. Restart PHP-FPM
6. Repeat for 10.7.222.12 (remember to change SERVER_NODE)

**Your game is ready to play!** 🚀
