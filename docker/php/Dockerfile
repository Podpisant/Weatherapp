FROM php:7.4-apache

COPY opcache.ini /usr/local/etc/php/conf.d/

# Install apt-transport-https
RUN apt-get update && apt-get install -y apt-utils && apt-get install -y apt-transport-https

# Install mc
RUN apt-get update && apt-get install -y mc

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    zip \
    unzip

RUN apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg-dev \
        libwebp-dev \
        libpng-dev \
        libmagickwand-dev \
        libpng-dev \
        libicu-dev \
        libmemcached-dev \
        zlib1g-dev \
        libpng-dev \
        libmcrypt-dev \
        libzip-dev \
        libonig-dev

RUN pecl install xdebug-2.9.0 && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update --2

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo pdo_mysql zip sockets tokenizer

RUN apt-get update && apt-get install -y \
        && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y \
        && docker-php-ext-install intl \
        && docker-php-ext-enable mysqli

# Install memcached php extension
RUN pecl install memcached-3.1.5 && docker-php-ext-enable memcached

# Install imagick php extension
RUN pecl install imagick && docker-php-ext-enable imagick

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
  docker-php-ext-install gd

RUN docker-php-ext-install -j$(nproc) bcmath exif opcache

# Install ClamAV
RUN apt-get update && apt-get install -y clamav clamav-freshclam clamav-daemon

# Install nodejs
RUN apt-get update && apt-get install -y software-properties-common
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# Install php pcntl
RUN docker-php-ext-install pcntl
RUN docker-php-ext-enable pcntl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /root/.ssh/
RUN ["chmod", "+r", "/root/.ssh/"]

WORKDIR "/var/www/html"
