#!/bin/bash

# Copy .env.docker to .env if .env doesn't exist
if [ ! -f .env ]; then
    cp .env.docker .env
fi

# Fix git safe directory issue
git config --global --add safe.directory /var/www

# Check if vendor directory exists, if not run composer install
if [ ! -d /var/www/vendor ] || [ ! -f /var/www/vendor/autoload.php ]; then
    echo "Vendor directory missing, running composer install..."
    cd /var/www
    
    # Create vendor directory with proper permissions
    mkdir -p /var/www/vendor
    chown -R www-data:www-data /var/www/vendor
    chmod -R 775 /var/www/vendor
    
    # Run composer install as www-data
    su www-data -c "git config --global --add safe.directory /var/www && composer install --no-interaction --optimize-autoloader"
    if [ $? -ne 0 ]; then
        echo "ERROR: Composer install failed!"
        exit 1
    fi
fi

# Wait for dependencies
sleep 5

# Fix permissions for directories that need to be writable by www-data
echo "Fixing directory permissions..."
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/database
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
chmod -R 775 /var/www/database

# Ensure database file exists and has correct permissions
touch /var/www/database/database.sqlite
chown www-data:www-data /var/www/database/database.sqlite
chmod 664 /var/www/database/database.sqlite

# Run Laravel commands as www-data user
su www-data -c "php artisan migrate --force"
su www-data -c "php artisan db:seed --force"

# Clear and cache config as www-data user
su www-data -c "php artisan config:clear"
su www-data -c "php artisan cache:clear"
su www-data -c "php artisan route:clear"
su www-data -c "php artisan view:clear"

su www-data -c "php artisan config:cache"
su www-data -c "php artisan route:cache"

# Start PHP-FPM as root (it will drop privileges automatically)
exec php-fpm -F