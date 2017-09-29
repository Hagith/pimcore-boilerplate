FROM php:7.1.9-apache

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        libbz2-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd exif zip bz2 mysqli pdo_mysql \
    && a2enmod rewrite

# install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN set -ex \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

# install dependencies as separate layer
COPY composer.* ./
RUN composer install --no-autoloader --no-scripts

COPY . .

RUN chmod -R 0777 website/var \
    && composer dump-autoload -o \
    && composer run-script post-install-cmd

VOLUME ["/var/www/html"]
