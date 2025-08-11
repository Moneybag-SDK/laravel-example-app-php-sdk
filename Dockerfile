FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd xml dom

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Recreate www-data user with UID 1001 to match host user
RUN userdel -r www-data 2>/dev/null || true \
    && groupdel www-data 2>/dev/null || true \
    && groupadd -g 1001 www-data \
    && useradd -u 1001 -ms /bin/bash -g www-data www-data

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents with proper ownership
COPY --chown=www-data:www-data . /var/www

# Create storage and cache directories with proper permissions
RUN mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www \
    && find /var/www/storage -type d -exec chmod 775 {} \; \
    && find /var/www/storage -type f -exec chmod 664 {} \; \
    && find /var/www/bootstrap/cache -type d -exec chmod 775 {} \; \
    && find /var/www/bootstrap/cache -type f -exec chmod 664 {} \; \
    && chmod -R 775 /var/www/database \
    && chmod 664 /var/www/database/database.sqlite

# Switch to www-data user for composer install
USER www-data

# Install dependencies as www-data user (including dev dependencies for now)
RUN composer install --no-interaction --optimize-autoloader --no-scripts || \
    (echo "Composer install failed, retrying with verbose output..." && \
     composer install --no-interaction --optimize-autoloader --no-scripts -vvv)

# Verify vendor directory exists
RUN test -d /var/www/vendor || (echo "ERROR: Vendor directory not created!" && exit 1)
RUN test -f /var/www/vendor/autoload.php || (echo "ERROR: Autoload file not created!" && exit 1)

# Generate key if .env exists
RUN if [ -f .env ]; then php artisan key:generate; fi

# Copy entrypoint script
USER root
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Don't switch user - let entrypoint script handle user switching

# Expose port 9000 and start php-fpm server
EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]