FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    icu-dev \
    libzip-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    zip

# xdebug
RUN apk add --no-cache $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del $PHPIZE_DEPS

COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
