FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    curl \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN cp .env.example .env || true

RUN chown -R www-data:www-data storage bootstrap/cache

RUN a2enmod rewrite

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD php artisan config:clear && \
    php artisan migrate --force || true && \
    apache2-foreground
