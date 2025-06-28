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

# Install NPM dependencies and build assets (if you have them)
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

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
\n\
# Check if .env file exists, if not create from example\n\
if [ ! -f .env ]; then\n\
    echo "Creating .env file from .env.example"\n\
    cp .env.example .env\n\
fi\n\
\n\
# Set proper permissions\n\
chown -R www-data:www-data /var/www/html\n\
chmod -R 755 /var/www/html/storage\n\
chmod -R 755 /var/www/html/bootstrap/cache\n\
\n\
# Clear any existing cache\n\
echo "Clearing Laravel cache..."\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
php artisan route:clear || true\n\
\n\
# Test Laravel installation\n\
echo "Testing Laravel..."\n\
php artisan --version || echo "Laravel artisan not working"\n\
\n\
# Create a simple test file\n\
echo "<?php echo '\''Laravel Test: '\'' . (class_exists('\''Illuminate\\Foundation\\Application'\'') ? '\''OK'\'' : '\''FAILED'\''); ?>" > /var/www/html/public/test.php\n\
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