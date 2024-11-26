FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip

ARG PUID=1000
ARG PGID=1000
RUN groupmod -g ${PGID} www-data && \
    usermod -u ${PUID} -g www-data www-data

RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./ /var/www/
WORKDIR /var/www/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/

RUN composer install

CMD ["php-fpm"]

