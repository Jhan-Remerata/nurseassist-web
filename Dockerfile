FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip sqlite3 libsqlite3-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev && \
    docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing app
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www

# Ensure database file exists
RUN mkdir -p /var/www/database && touch /var/www/database/database.sqlite

# Run Laravel commands when container starts
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000
