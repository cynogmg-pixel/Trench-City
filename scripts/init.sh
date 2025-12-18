#!/bin/bash
echo "🔧 Resetting Trench City environment..."
chown -R www-data:www-data /var/www/trench_city
find /var/www/trench_city -type d -exec chmod 755 {} \;
find /var/www/trench_city -type f -exec chmod 644 {} \;
systemctl reload php8.1-fpm
systemctl reload nginx
echo "✅ Permissions fixed and services reloaded."
