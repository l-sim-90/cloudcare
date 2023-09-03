FROM php:8.1-fpm

# Installa le dipendenze
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip

# Installa estensioni PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . /app

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]
