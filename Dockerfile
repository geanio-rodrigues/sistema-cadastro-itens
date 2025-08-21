# Dockerfile
FROM php:8.2-fpm

WORKDIR /var/www/html

# Instala dependências do sistema e extenções PHP para o Laravel
RUN apt-get updte && apt-get install -y --no-install-recommends \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    zip unzip git curl liboning-dev libzip-dev mariadb-client \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD [ "php-fpm" ]