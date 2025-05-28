# Usar imagem oficial do PHP com FPM
FROM php:8.2-fpm

# Instalar dependências do sistema e bibliotecas necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev zip unzip \
    git \
    libpq-dev \ 
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip gd pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*  # Limpar cache do apt

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto para o contêiner
COPY ./brutos  .

# Instalar as dependências do Laravel
RUN composer install

# Definir permissões corretas para os arquivos
RUN chown -R www-data:www-data /var/www

# Expôr porta 9000 para o PHP-FPM
EXPOSE 9000

# Iniciar o PHP-FPM
CMD ["php-fpm"]
