FROM php:8.1-fpm

RUN apt update && apt install -y zlib1g-dev g++ git

COPY  --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

WORKDIR /var/www/phplogger

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer