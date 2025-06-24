FROM php:8.2-cli

# Установить зависимости PHP и Node.js
RUN apt-get update && apt-get install -y git unzip libpq-dev zip \
    && docker-php-ext-install pdo pdo_pgsql

# Установить npm (если alpine — заменить на apk!)
RUN apt-get install -y nodejs npm

# Копировать composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Установить зависимости PHP
RUN composer install --optimize-autoloader

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

WORKDIR /app

COPY . .
RUN composer install
RUN npm ci
RUN npm run build

# Очистить кэш
RUN php artisan config:clear

EXPOSE 8000

# Выполнить миграции и запустить сервер
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000
