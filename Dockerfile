
FROM php:8.2-fpm

RUN apt update && apt install -y \
    curl zip unzip libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer


COPY ./brutos /var/www/html

WORKDIR /var/www/html

RUN composer install

# RUN php artisan migrate
