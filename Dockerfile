FROM php:8.2-fpm

# Instalar dependências necessárias
RUN apt update && apt install -y curl zip unzip

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer


COPY ./brutos /var/www/html


RUN composer install


CMD ["php", "artisan", "serve", "--host=0.0.0.0" ,"--port=8000"]