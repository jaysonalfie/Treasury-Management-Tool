# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (including pdo_pgsql for PostgreSQL)
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets for production
RUN if [ -f "package.json" ]; then \
    echo "Installing NPM dependencies and building assets..."; \
    npm install && npm run build || echo "NPM build failed. Check package.json scripts."; \
    ls -l public/build || echo "No public/build directory found."; \
    else echo "No package.json found, skipping NPM build."; \
fi

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Create a startup script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "Starting Laravel setup..."\n\
\n\
# Debug: Print environment variables\n\
echo "APP_ENV: $APP_ENV"\n\
echo "APP_DEBUG: $APP_DEBUG"\n\
echo "APP_KEY exists: $(if [ -n "$APP_KEY" ]; then echo "YES"; else echo "NO"; fi)"\n\
echo "DB_CONNECTION: $DB_CONNECTION"\n\
echo "DB_HOST: $DB_HOST"\n\
echo "DB_PORT: $DB_PORT"\n\
echo "DB_DATABASE: $DB_DATABASE"\n\
echo "DB_USERNAME: $DB_USERNAME"\n\
\n\
# Check if .env file exists, if not create from example\n\
if [ ! -f .env ]; then\n\
    echo "Creating .env file from .env.example"\n\
    cp .env.example .env\n\
fi\n\
\n\
# Set proper permissions\n\
APACHE_USER=$(ps -o user= -p 1 | grep -v root || echo "www-data")\n\
chown -R $APACHE_USER:$APACHE_USER /var/www/html\n\
chmod -R 775 /var/www/html/storage\n\
chmod -R 775 /var/www/html/bootstrap/cache\n\
mkdir -p /var/www/html/storage/logs\n\
rm -f /var/www/html/storage/logs/laravel.log\n\
touch /var/www/html/storage/logs/laravel.log\n\
chown $APACHE_USER:$APACHE_USER /var/www/html/storage/logs/laravel.log\n\
chmod 664 /var/www/html/storage/logs/laravel.log\n\
\n\
# Debug permissions\n\
echo "Listing permissions for storage and logs..."\n\
ls -ld /var/www/html/storage /var/www/html/storage/logs /var/www/html/bootstrap/cache /var/www/html/storage/logs/laravel.log\n\
\n\
# Debug: List public/build contents\n\
echo "Listing public/build contents..."\n\
ls -l /var/www/html/public/build || echo "No public/build directory found."\n\
\n\
# Clear any existing cache\n\
echo "Clearing Laravel cache..."\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
php artisan route:clear || true\n\
\n\
# Wait for database to be ready (retry up to 10 times with 5-second delay)\n\
echo "Waiting for database to be ready..."\n\
for i in {1..10}; do\n\
    php artisan db:monitor && break\n\
    echo "Database not ready, retrying in 5 seconds ($i/10)..."\n\
    sleep 5\n\
done\n\
if ! php artisan db:monitor; then\n\
    echo "Database connection failed after retries. Continuing with Apache startup to avoid container crash."\n\
else\n\
    echo "Database connection successful."\n\
fi\n\
\n\
# Run migrations with detailed output\n\
echo "Running database migrations..."\n\
php artisan migrate --force --no-ansi -v || echo "Migration failed. Check logs for details."\n\
\n\
# List database tables to verify migrations\n\
echo "Listing database tables..."\n\
PGPASSWORD="$DB_PASSWORD" psql -h "$DB_HOST" -U "$DB_USERNAME" -d "$DB_DATABASE" -p "$DB_PORT" -c "\\dt" || echo "Failed to list tables."\n\
\n\
# Run seeders\n\
echo "Running database seeders..."\n\
php artisan db:seed --force --no-ansi -v || echo "Seeding failed. Check logs for details."\n\
\n\
# Test Laravel installation\n\
echo "Testing Laravel..."\n\
php artisan --version || echo "Laravel artisan not working"\n\
\n\
# Create a simple test file\n\
echo "<?php echo '\''Laravel Test: '\'' . (class_exists('\''Illuminate\\Foundation\\Application'\'') ? '\''OK'\'' : '\''FAILED'\''); ?>" > /var/www/html/public/test.php\n\
\n\
# Create a debug log route\n\
echo "<?php return response()->file(storage_path('\''logs/laravel.log'\'')); ?>" > /var/www/html/public/debug_logs.php\n\
\n\
echo "Laravel setup completed. Starting Apache..."\n\
\n\
# Start Apache\n\
apache2-foreground' > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# Expose port 80
EXPOSE 80

# Start with our custom script
CMD ["/usr/local/bin/start.sh"]