FROM php:8.2-cli

RUN apt-get update && apt-get install -y git unzip libpq-dev zip && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:clear

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
