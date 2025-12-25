#!/bin/bash
# ================================================================
# TRENCH CITY V2 - DATABASE UPDATE SCRIPT
# Run this to update your database to Torn-faithful state
# ================================================================

echo ""
echo "========================================"
echo "TRENCH CITY V2 - DATABASE UPDATE"
echo "========================================"
echo ""

# Database credentials
DB_USER="trench"
DB_PASS="Rianna2602!"
DB_HOST="10.7.222.14"
DB_NAME="trench_city"

# Check if mysql client is available
if ! command -v mysql &> /dev/null; then
    echo "ERROR: mysql client not found"
    echo "Please install mysql-client:"
    echo "  Ubuntu/Debian: sudo apt install mysql-client"
    echo "  macOS: brew install mysql-client"
    echo ""
    exit 1
fi

echo "Connecting to database: ${DB_NAME}@${DB_HOST}"
echo "User: ${DB_USER}"
echo ""

# Run the update script
echo "[1/1] Applying database updates..."
mysql -u "${DB_USER}" -p"${DB_PASS}" -h "${DB_HOST}" "${DB_NAME}" < UPDATE_DATABASE_TO_CURRENT.sql

if [ $? -ne 0 ]; then
    echo ""
    echo "ERROR: Database update failed!"
    echo ""
    exit 1
fi

echo ""
echo "========================================"
echo "DATABASE UPDATE COMPLETE!"
echo "========================================"
echo ""
echo "Your database is now Torn-faithful ready."
echo ""
echo "Next steps:"
echo "1. Add 'require_once __DIR__ . '/player_core.php';' to core/bootstrap.php"
echo "2. Update helpers.php nerve regen: 240 -> 300 seconds (line ~1055)"
echo "3. Update combat module to use awardXPFromAttack()"
echo "4. Update crime module to use awardCrimeExperience()"
echo ""
