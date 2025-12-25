# Database Setup Guide

## Quick Setup - Import All Schemas

To set up the complete Trench City database, import these SQL files in order:

### 1. Core Schema (Users, Sessions, Basic Tables)
```bash
mysql -u trench -p -h 10.7.222.14 trench_city < core/init_schema_v0.sql
```

### 2. Game System Schemas
Import these in any order (they're independent):

```bash
# Crimes system
mysql -u trench -p -h 10.7.222.14 trench_city < core/crimes_schema.sql
mysql -u trench -p -h 10.7.222.14 trench_city < core/crimes_data.sql

# Gym system
mysql -u trench -p -h 10.7.222.14 trench_city < core/gym_schema.sql

# Combat system
mysql -u trench -p -h 10.7.222.14 trench_city < core/combat_schema.sql

# Bank system
mysql -u trench -p -h 10.7.222.14 trench_city < core/bank_schema.sql

# Mail system
mysql -u trench -p -h 10.7.222.14 trench_city < core/mail_schema.sql

# Email verification
mysql -u trench -p -h 10.7.222.14 trench_city < core/email_verification_schema.sql
```

### 3. All-in-One Script
Or run them all at once:

```bash
cd /var/www/trench_city

for schema in core/init_schema_v0.sql core/crimes_schema.sql core/crimes_data.sql core/gym_schema.sql core/combat_schema.sql core/bank_schema.sql core/mail_schema.sql core/email_verification_schema.sql; do
    echo "Importing $schema..."
    mysql -u trench -pRianna2602! -h 10.7.222.14 trench_city < "$schema"
done

echo "✅ All schemas imported successfully!"
```

## Production Credentials

From your `.env` file:
- **Host:** 10.7.222.14
- **Port:** 3306
- **Database:** trench_city
- **User:** trench
- **Password:** Rianna2602!

## Verify Installation

Check that all tables exist:

```bash
mysql -u trench -pRianna2602! -h 10.7.222.14 trench_city -e "SHOW TABLES;"
```

Expected tables:
- users
- user_stats
- user_bars
- crimes
- gym_stats
- combat_stats
- bank_accounts
- bank_transactions
- mail_messages
- email_config
- email_verification_tokens

## Troubleshooting

### "Table doesn't exist" errors
If you see errors like "Table 'trench_city.crimes' doesn't exist":
1. Import the corresponding schema file (e.g., `crimes_schema.sql`)
2. If it has a data file, import that too (e.g., `crimes_data.sql`)
3. Restart PHP-FPM: `sudo systemctl restart php8.3-fpm`

### Connection errors
1. Verify database server is accessible: `ping 10.7.222.14`
2. Test MySQL connection: `mysql -u trench -pRianna2602! -h 10.7.222.14`
3. Check firewall allows port 3306 from game nodes
4. Verify credentials in `.env` match database

### Permission errors
Grant proper permissions to the `trench` user:

```sql
GRANT ALL PRIVILEGES ON trench_city.* TO 'trench'@'%' IDENTIFIED BY 'Rianna2602!';
FLUSH PRIVILEGES;
```

## Schema Files Reference

| File | Purpose | Dependencies |
|------|---------|--------------|
| `init_schema_v0.sql` | Core users and system tables | None - import first |
| `crimes_schema.sql` | Crimes game system tables | init_schema_v0.sql |
| `crimes_data.sql` | Pre-populated crime definitions | crimes_schema.sql |
| `gym_schema.sql` | Gym training system | init_schema_v0.sql |
| `combat_schema.sql` | Combat/PvP system | init_schema_v0.sql |
| `bank_schema.sql` | Banking system | init_schema_v0.sql |
| `mail_schema.sql` | In-game mail system | init_schema_v0.sql |
| `email_verification_schema.sql` | Email verification tokens | init_schema_v0.sql |

## Next Steps

After importing schemas:
1. Create a test user account via `/register.php`
2. Verify login works
3. Test each game system (crimes, gym, combat, bank, mail)
4. Check error logs: `tail -f storage/logs/error_trace.log`
