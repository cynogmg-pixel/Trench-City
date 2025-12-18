#!/bin/bash
# Trench City V2 - Database Schema Installation Script
# Run this from /var/www/trench_city/

DB_HOST="10.7.222.14"
DB_USER="trench"
DB_PASS="Rianna2602!"
DB_NAME="trench_city"

echo "================================================"
echo "  Trench City V2 - Schema Installation"
echo "================================================"
echo ""

# Function to import schema
import_schema() {
    local file=$1
    local description=$2

    if [ -f "$file" ]; then
        echo "Installing $description..."
        mysql -u $DB_USER -p$DB_PASS -h $DB_HOST $DB_NAME < "$file"
        if [ $? -eq 0 ]; then
            echo "✓ $description installed successfully"
        else
            echo "✗ Error installing $description"
        fi
        echo ""
    else
        echo "⚠ Skipping $description (file not found: $file)"
        echo ""
    fi
}

# Import core schemas in order
import_schema "core/init_schema_v0.sql" "Core Schema (Users & Sessions)"
import_schema "core/crimes_schema.sql" "Crimes System"
import_schema "core/crimes_data.sql" "Crimes Data"
import_schema "core/gym_schema.sql" "Gym System"
import_schema "core/combat_schema.sql" "Combat System"
import_schema "core/bank_schema.sql" "Bank System"
import_schema "core/mail_schema.sql" "Mail System"
import_schema "core/email_verification_schema.sql" "Email Verification"
import_schema "core/market_schema.sql" "Market System"
import_schema "core/jobs_schema.sql" "Jobs System"

echo "================================================"
echo "  Installation Complete!"
echo "================================================"
echo ""
echo "Verify installation:"
echo "mysql -u $DB_USER -p$DB_PASS -h $DB_HOST $DB_NAME -e 'SHOW TABLES;'"
echo ""
