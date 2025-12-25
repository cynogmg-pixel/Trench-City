# EXACT COMMANDS TO UPDATE YOUR DATABASE

## OPTION 1: Windows (Easiest)

Double-click this file:
```
RUN_THIS_TO_UPDATE_DATABASE.bat
```

**OR** if you need to update the MySQL path first, edit the `.bat` file and change line 12:
```batch
set MYSQL_PATH=C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe
```

Common MySQL paths:
- `C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe`
- `C:\xampp\mysql\bin\mysql.exe`
- `C:\wamp64\bin\mysql\mysql8.0.x\bin\mysql.exe`

---

## OPTION 2: Linux/Mac/WSL

Run this command in your terminal:
```bash
cd /mnt/c/Users/Shadow/Desktop/trench_city_v2_master_skeleton/trench_city
bash RUN_THIS_TO_UPDATE_DATABASE.sh
```

---

## OPTION 3: Manual Command (Any System)

If you have `mysql` in your PATH:

```bash
mysql -u trench -p'Rianna2602!' -h 10.7.222.14 trench_city < UPDATE_DATABASE_TO_CURRENT.sql
```

**Windows PowerShell**:
```powershell
& "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u trench -p'Rianna2602!' -h 10.7.222.14 trench_city < UPDATE_DATABASE_TO_CURRENT.sql
```

---

## OPTION 4: Using MySQL Workbench

1. Open MySQL Workbench
2. Connect to server: `10.7.222.14`
3. Database: `trench_city`
4. User: `trench` / Password: `Rianna2602!`
5. File → Run SQL Script
6. Select: `UPDATE_DATABASE_TO_CURRENT.sql`
7. Click "Run"

---

## OPTION 5: Using phpMyAdmin

1. Login to phpMyAdmin
2. Select database: `trench_city`
3. Click "SQL" tab
4. Click "Import files" or paste contents of `UPDATE_DATABASE_TO_CURRENT.sql`
5. Click "Go"

---

## What This Does

The update script will:

✅ **Fix currency fields** - Convert any DECIMAL to INT UNSIGNED (whole pounds)
✅ **Add Torn-faithful columns to users table**:
   - `true_level` - Actual level from XP
   - `level_holding_enabled` - Can hold level upgrades
   - `player_state` - Hospital/jail/travel status
   - `email_verified` - Email verification flag
   - Anti-abuse tracking fields

✅ **Add Torn-faithful columns to player_bars table**:
   - `nerve_natural_max` (NNB) - Natural nerve from CE
   - `nerve_bonus_merits/faction/job` - Nerve bonus layers
   - `crime_experience` - Hidden CE for NNB calculation
   - Individual regen timestamps per bar

✅ **Create 4 new tables**:
   - `player_state_log` - Track state changes
   - `xp_awards_log` - Anti-abuse XP tracking
   - `level_gates` - 12 Torn-faithful unlocks (auto-seeded)
   - `action_cooldowns` - Cooldown system

✅ **Safe to run multiple times** - Uses IF NOT EXISTS checks

---

## Verification

After running, you should see output like:

```
Checking users table columns...
+----------------------+-----------+----------------+
| COLUMN_NAME          | DATA_TYPE | COLUMN_DEFAULT |
+----------------------+-----------+----------------+
| true_level           | int       | 1              |
| level_holding_enabled| tinyint   | 0              |
| player_state         | enum      | normal         |
| cash                 | int       | 0              |
| bank_balance         | int       | 0              |
+----------------------+-----------+----------------+

Checking player_bars table columns...
+---------------------+-----------+----------------+
| COLUMN_NAME         | DATA_TYPE | COLUMN_DEFAULT |
+---------------------+-----------+----------------+
| nerve_natural_max   | int       | 15             |
| crime_experience    | bigint    | 0              |
| nerve_bonus_merits  | int       | 0              |
| energy_last_regen   | datetime  | NULL           |
| nerve_last_regen    | datetime  | NULL           |
+---------------------+-----------+----------------+

Checking new tables...
+--------------------+
| TABLE_NAME         |
+--------------------+
| player_state_log   |
| xp_awards_log      |
| level_gates        |
| action_cooldowns   |
+--------------------+

Checking level gates...
+----------------------+----------------+
| gate_name            | required_level |
+----------------------+----------------+
| bookies              | 2              |
| company              | 3              |
| lottery              | 3              |
| blackjack            | 4              |
| auction              | 5              |
| post_george_missions | 5              |
| poker                | 5              |
| russian_roulette     | 6              |
| spin_wheel           | 7              |
| company_director     | 10             |
| global_chat          | 13             |
| travel_agency        | 15             |
+----------------------+----------------+

ALL UPDATES APPLIED SUCCESSFULLY
Database is now Torn-faithful ready!
```

---

## Troubleshooting

### "Access denied for user"
- Check username: `trench`
- Check password: `Rianna2602!`
- Check host: `10.7.222.14`

### "Unknown database 'trench_city'"
- Create database first:
  ```sql
  CREATE DATABASE trench_city CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```

### "mysql: command not found"
- Install MySQL client or use full path to mysql.exe
- Windows: Update `MYSQL_PATH` in the `.bat` file
- Linux: `sudo apt install mysql-client`
- Mac: `brew install mysql-client`

### "Cannot add foreign key constraint"
- Make sure `users` table exists first
- Run `core/init_schema_v0.sql` first if fresh database

---

## After Database Update

### 1. Update bootstrap.php

Add to `core/bootstrap.php` after `require_once __DIR__ . '/helpers.php';`:

```php
require_once __DIR__ . '/player_core.php';
```

### 2. Update nerve regeneration rate (Torn-faithful)

In `core/helpers.php` around line 1055-1060, change:

```php
// OLD (4 minutes):
$nerveTicks = floor($nerveElapsed / 240);

// NEW (5 minutes - Torn rate):
$nerveTicks = floor($nerveElapsed / 300);
```

### 3. Update combat module

Replace old XP awards:
```php
// OLD:
awardXP($attackerId, 10);

// NEW (Torn-faithful):
awardXPFromAttack($attackerId, 'leave', $victimLevel, $combatLogId);
// Use 'mug' or 'hospitalize' depending on attack type
```

### 4. Update crime module

Add after successful crime:
```php
awardCrimeExperience($userId, 10, 'crime_success');
```

Add after critical fail:
```php
awardCrimeExperience($userId, -50, 'critical_fail_jail');
setPlayerState($userId, 'jail', date('Y-m-d H:i:s', time() + 3600), 'Critical fail');
```

---

## Files Reference

All these files are in the `trench_city/` directory:

- `UPDATE_DATABASE_TO_CURRENT.sql` - The SQL update script
- `RUN_THIS_TO_UPDATE_DATABASE.bat` - Windows runner
- `RUN_THIS_TO_UPDATE_DATABASE.sh` - Linux/Mac runner
- `core/player_core.php` - Torn-faithful functions (800+ lines)
- `PLAYER_CORE_IMPLEMENTATION_SUMMARY.md` - Full integration guide
- `PLAYER_CORE_TORN_FAITHFUL_SPEC.md` - Complete specification

---

## Need Help?

Check these documents:
1. `PLAYER_CORE_IMPLEMENTATION_SUMMARY.md` - Installation & integration
2. `PLAYER_CORE_TORN_FAITHFUL_SPEC.md` - Technical specification
3. `PLAYER_MODULE_AUDIT.md` - What was already there

---

**Ready? Pick an option above and run the update!**
