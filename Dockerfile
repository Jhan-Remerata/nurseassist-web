FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip sqlite3 libsqlite3-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev && \
    docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Create empty SQLite file
RUN mkdir -p database && touch database/database.sqlite

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
