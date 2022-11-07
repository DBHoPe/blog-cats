FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - &&\
apt-get --yes install -y nodejs

RUN npm install -D tailwindcss postcss-loader purgecss-webpack-plugin glob-all path

RUN npx tailwindcss init -p
RUN npm install autoprefixer

# run manually: npx tailwindcss -i ./assets/styles/app.css -o ./public/build/app.css