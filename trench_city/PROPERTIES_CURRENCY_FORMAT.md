# PROPERTIES SYSTEM — CURRENCY FORMAT

## Currency Convention: Whole Pounds Only

All currency in the Properties System uses **whole pounds (£1234)** not decimals (£1234.56).

### Database Schema

**All currency fields use `INT UNSIGNED`:**

```sql
-- Properties table
base_cost INT UNSIGNED NOT NULL DEFAULT 0,
base_upkeep INT UNSIGNED NOT NULL DEFAULT 0,

-- User properties table
purchase_price INT UNSIGNED NOT NULL DEFAULT 0,
upkeep_debt INT UNSIGNED NOT NULL DEFAULT 0,
vault_balance INT UNSIGNED NOT NULL DEFAULT 0,
cached_daily_upkeep INT UNSIGNED NOT NULL DEFAULT 0,

-- Rental/lease tables
daily_rent INT UNSIGNED NOT NULL,
security_deposit INT UNSIGNED NOT NULL DEFAULT 0,
security_deposit_held INT UNSIGNED NOT NULL DEFAULT 0,
rent_debt INT UNSIGNED NOT NULL DEFAULT 0,

-- Upgrade catalog
cost INT UNSIGNED NOT NULL,
upkeep_delta INT UNSIGNED NOT NULL DEFAULT 0,

-- Staff catalog
daily_wage INT UNSIGNED NOT NULL,
hiring_fee INT UNSIGNED NOT NULL DEFAULT 0,

-- Upkeep ledger
base_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
upgrades_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
staff_wages INT UNSIGNED NOT NULL DEFAULT 0,
total_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
amount_paid INT UNSIGNED NOT NULL DEFAULT 0,

-- Transactions
amount INT UNSIGNED NOT NULL DEFAULT 0,
balance_before INT UNSIGNED NULL,
balance_after INT UNSIGNED NULL,
```

### Examples

**Properties:**
- Battered Bedsit: £5,000 (not £5,000.00)
- Mayfair Townhouse: £1,000,000 (not £1,000,000.00)
- The Trench Manor: £5,000,000 (not £5,000,000.00)

**Daily Upkeep:**
- Tier 1: £10/day (not £10.00/day)
- Tier 6: £2,000/day (not £2,000.00/day)

**Upgrades:**
- New Carpets: £500 + £2/day upkeep
- Panic Room: £200,000 + £100/day upkeep

**Staff:**
- Basic Cleaner: £20/day wage + £50 hiring fee
- Private Michelin Chef: £300/day wage + £2,000 hiring fee

### Display Formatting

**In PHP code:**
```php
// Use formatCash() helper (already exists in your codebase)
echo formatCash(5000); // Outputs: £5,000
echo formatCash(1000000); // Outputs: £1,000,000

// Direct display
echo '£' . number_format($amount); // £5,000
```

**In SQL:**
```sql
-- No formatting needed, store as integers
INSERT INTO properties VALUES (..., 5000, 10, ...);

-- Display with commas in queries if needed
SELECT
    name,
    CONCAT('£', FORMAT(base_cost, 0)) as formatted_cost
FROM properties;
```

### Why Whole Pounds?

1. **Simplicity** - Easier mental math for players
2. **Consistency** - Matches existing game currency (£1234 format)
3. **No rounding errors** - INT arithmetic is exact
4. **Storage efficiency** - INT UNSIGNED uses 4 bytes vs DECIMAL(15,2) uses 7 bytes
5. **Performance** - Integer operations faster than decimal
6. **Game balance** - Whole numbers easier to balance

### Migration Note

If you already have existing properties data with DECIMAL fields, run:

```sql
-- Convert existing DECIMAL columns to INT
ALTER TABLE properties
    MODIFY COLUMN base_cost INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY COLUMN base_upkeep INT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE user_properties
    MODIFY COLUMN purchase_price INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY COLUMN upkeep_debt INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY COLUMN vault_balance INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY COLUMN cached_daily_upkeep INT UNSIGNED NOT NULL DEFAULT 0;

-- Repeat for all other tables...
```

**Better approach:** Drop and recreate tables using the new schema if no production data exists yet.

---

**Version:** 1.1
**Updated:** 2025-12-24
**Schema Version:** properties_schema.sql v1.1
