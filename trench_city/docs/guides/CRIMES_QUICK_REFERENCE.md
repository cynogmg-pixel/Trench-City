# CRIMES SYSTEM - QUICK REFERENCE CARD

## Installation (Choose One Method)

### Method 1: Automated (Linux/Mac)
```bash
chmod +x install_crimes.sh
./install_crimes.sh
```

### Method 2: Automated (Windows)
```batch
install_crimes.bat
```

### Method 3: Manual
```bash
mysql -u username -p trench_city < core/crimes_schema.sql
mysql -u username -p trench_city < core/crimes_data.sql
```

---

## Access Point
**URL:** `http://your-domain.com/crimes.php`
**Auth Required:** Yes (must be logged in)

---

## Success Formula
```
Final Rate = MIN(95%, base_rate + (total_stats / 100) + (level / 2))
```

**Example:** Level 20, 2000 stats, 40% base = 70% success

---

## Crime Categories

| Category   | Level | Nerve | Success | Reward Range      | Example              |
|------------|-------|-------|---------|-------------------|----------------------|
| Petty      | 1-5   | 1-2   | 55-70%  | £20 - £400        | Pickpocket           |
| Theft      | 5-10  | 3-5   | 35-45%  | £500 - £3,500     | Car Theft            |
| Violence   | 10-15 | 5-8   | 28-50%  | £300 - £15,000    | Armed Robbery        |
| Organized  | 15-25 | 8-12  | 32-42%  | £3,000 - £40,000  | Drug Trafficking     |
| Elite      | 25+   | 12-15 | 18-28%  | £25,000 - £200,000| Bank Vault Breach    |

---

## Jail & Hospital

### Jail
- **Trigger:** Random (based on crime's jail_chance)
- **Duration:** 30-60 minutes
- **Effect:** Cannot commit any crimes
- **Column:** `users.jail_until`

### Hospital
- **Trigger:** Random (based on crime's hospital_chance)
- **Duration:** 15-30 minutes
- **Effect:** Cannot commit any crimes
- **Column:** `users.hospital_until`

---

## Rewards & Penalties

### Success
- Cash: Random between min/max
- XP: Full amount
- No penalties

### Failure
- Cash: £0
- XP: 30% of full amount
- Risk: Jail or Hospital

---

## Files Structure

```
core/
├── crimes_schema.sql        (83 lines)
└── crimes_data.sql         (77 lines)

modules/crimes/
└── crimes_shell.php        (902 lines)

public/
└── crimes.php              (21 lines)

Total: 1,083 lines of code
```

---

## Database Tables

### crimes
- Stores 20 predefined crimes
- 5 categories (petty → elite)
- Requirements, rewards, risk factors

### crime_logs
- Tracks all attempts
- Success/failure status
- Cash/XP earned
- Jail/Hospital outcomes
- Timestamp

### users (modified)
- Added: `jail_until` (DATETIME)
- Added: `hospital_until` (DATETIME)

---

## Helper Functions

```php
// Used by crimes system
getUser($userId)           // Fetch user data
getUserStats($userId)      // Fetch stats
getUserBars($userId)       // Fetch bars (nerve)
updateUserBars($userId, $bars)  // Update nerve
awardXP($userId, $xp)      // Award XP
formatCash($amount)        // Format display
requireLogin()             // Check auth
currentUserId()            // Get user ID
```

---

## Testing Checklist

**Basic Functionality:**
- [ ] Can access /crimes.php when logged in
- [ ] All 20 crimes visible
- [ ] Success/failure mechanics work
- [ ] Nerve deduction working
- [ ] XP and cash awarded correctly
- [ ] Jail timer works
- [ ] Hospital timer works
- [ ] Requirements checked properly

**UI/UX:**
- [ ] Dark Luxury theme applied
- [ ] Responsive on mobile
- [ ] Crime cards display properly
- [ ] History table shows logs
- [ ] Timers count down live

---

## Common Queries

```sql
-- View all crimes by category
SELECT category, name, cash_min, cash_max, base_success_rate
FROM crimes
ORDER BY FIELD(category, 'petty','theft','violence','organized','elite'), difficulty;

-- Check player's crime history
SELECT c.name, cl.success, cl.cash_earned, cl.created_at
FROM crime_logs cl
JOIN crimes c ON cl.crime_id = c.id
WHERE cl.user_id = 1
ORDER BY cl.created_at DESC
LIMIT 10;

-- Check success rates by crime
SELECT c.name,
       COUNT(*) as attempts,
       SUM(cl.success) as successes,
       ROUND(AVG(cl.success) * 100, 1) as success_rate
FROM crime_logs cl
JOIN crimes c ON cl.crime_id = c.id
GROUP BY c.id
ORDER BY attempts DESC;

-- Check players in jail/hospital
SELECT username, jail_until, hospital_until
FROM users
WHERE jail_until > NOW() OR hospital_until > NOW();
```

---

## Balance Tweaking

To adjust difficulty, edit `crimes_data.sql`:

**Make crimes easier:**
- Increase `base_success_rate`
- Decrease `jail_chance` and `hospital_chance`
- Increase `cash_min` and `cash_max`

**Make crimes harder:**
- Decrease `base_success_rate`
- Increase `jail_chance` and `hospital_chance`
- Increase `min_level` or `min_stats`

Then re-import:
```bash
mysql -u username -p trench_city < core/crimes_data.sql
```

---

## Integration Points

**With Gym System:**
- Train stats → Better crime success rates

**With Jobs System:**
- Alternative legal income
- Jobs stable, crimes risky

**With Combat System:**
- Shared stat benefits
- Cash for equipment

**Future - Gang System:**
- Group crimes
- Territory bonuses

---

## Support

**Full Documentation:** `CRIMES_SYSTEM_COMPLETE.md`
**Installation Scripts:** `install_crimes.sh` / `install_crimes.bat`
**Module Location:** `modules/crimes/crimes_shell.php`
**Public Access:** `public/crimes.php`

**Status:** Production Ready ✓

---

*Quick reference for Trench City Crimes System v1.0*
