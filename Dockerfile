FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip sqlite3 libsqlite3-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --optimize-autoloader

RUN chown -R www-data:www-data /var/www

EXPOSE 8000

CMD ["sh", "-c", "cp -n .env.example .env 2>/dev/null; php artisan key:generate --force; touch database/database.sqlite; php artisan migrate --force; php artisan l5-swagger:generate; php artisan serve --host=0.0.0.0 --port=8000"]