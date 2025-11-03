FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js & npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working dir
WORKDIR /var/www/html

# Apache config for Laravel
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf