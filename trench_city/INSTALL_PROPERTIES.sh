#!/bin/bash
# ================================================================
# TRENCH CITY V2 - PROPERTIES SYSTEM INSTALLATION
# Installs complete properties schema and data
# ================================================================
# Version: 1.0
# Date: 2025-12-24
# ================================================================

echo ""
echo "================================================================"
echo "TRENCH CITY V2 - PROPERTIES SYSTEM INSTALLATION"
echo "================================================================"
echo ""

# Database credentials (update if different)
DB_USER="trench"
DB_PASS="Rianna2602!"
DB_HOST="10.7.222.14"
DB_NAME="trench_city"

# Check if mysql client is available
if ! command -v mysql &> /dev/null; then
    echo "ERROR: mysql client not found"
    echo "Please install mysql-client: sudo apt install mysql-client"
    exit 1
fi

echo "[1/4] Installing Properties Schema..."
mysql -u "$DB_USER" -p"$DB_PASS" -h "$DB_HOST" "$DB_NAME" < core/properties_schema.sql
if [ $? -ne 0 ]; then
    echo "ERROR: Failed to install properties schema"
    exit 1
fi
echo "✓ Properties schema installed"
echo ""

echo "[2/4] Seeding Properties Catalogue (26 properties)..."
mysql -u "$DB_USER" -p"$DB_PASS" -h "$DB_HOST" "$DB_NAME" < core/properties_data.sql
if [ $? -ne 0 ]; then
    echo "ERROR: Failed to seed properties data"
    exit 1
fi
echo "✓ Properties catalogue seeded"
echo ""

echo "[3/4] Seeding Upgrades Catalogue (35 upgrades)..."
mysql -u "$DB_USER" -p"$DB_PASS" -h "$DB_HOST" "$DB_NAME" < core/properties_upgrades_data.sql
if [ $? -ne 0 ]; then
    echo "ERROR: Failed to seed upgrades data"
    exit 1
fi
echo "✓ Upgrades catalogue seeded"
echo ""

echo "[4/4] Seeding Staff Catalogue (15 staff types)..."
mysql -u "$DB_USER" -p"$DB_PASS" -h "$DB_HOST" "$DB_NAME" < core/properties_staff_data.sql
if [ $? -ne 0 ]; then
    echo "ERROR: Failed to seed staff data"
    exit 1
fi
echo "✓ Staff catalogue seeded"
echo ""

echo "================================================================"
echo "INSTALLATION COMPLETE"
echo "================================================================"
echo ""
echo "Database Tables Created:"
echo "  • properties (26 entries)"
echo "  • user_properties"
echo "  • property_listings"
echo "  • property_rental_offers"
echo "  • property_leases"
echo "  • property_occupants"
echo "  • property_upgrade_catalog (35 entries)"
echo "  • property_upgrades"
echo "  • property_staff_catalog (15 entries)"
echo "  • property_staff"
echo "  • property_upkeep_ledger"
echo "  • property_transactions"
echo ""
echo "Next Steps:"
echo "1. Verify tables: mysql -u $DB_USER -p$DB_PASS -h $DB_HOST $DB_NAME -e 'SHOW TABLES LIKE \"%propert%\";'"
echo "2. Check property count: mysql -u $DB_USER -p$DB_PASS -h $DB_HOST $DB_NAME -e 'SELECT COUNT(*) FROM properties;'"
echo "3. Access Properties UI: https://www.trenchmade.co.uk/properties.php"
echo ""
echo "================================================================"
