FROM node:18 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources/ resources/
COPY vite.config.js ./
COPY public/ public/
RUN npm run build


FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

COPY . .

COPY --from=frontend /app/public/build /app/public/build

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD php artisan config:cache \
 && php artisan migrate --force \
 && php artisan db:seed --force \
 && php artisan serve --host=0.0.0.0 --port=8000
