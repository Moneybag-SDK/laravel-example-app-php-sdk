#!/bin/bash

# Copy .env.docker to .env if .env doesn't exist
if [ ! -f .env ]; then
    cp .env.docker .env
fi

# Wait for dependencies
sleep 5

# Run migrations and seed
php artisan migrate --force
php artisan db:seed --force

# Clear and cache config
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM
php-fpm