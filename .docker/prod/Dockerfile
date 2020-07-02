FROM composer as assets

COPY composer.json /usr/assets/
COPY composer.lock /usr/assets/

WORKDIR /usr/assets

RUN composer install --no-scripts

FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache netcat-openbsd composer
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/root

COPY --from=assets /usr/assets/vendor /var/www/root/vendor
COPY . /var/www/root

RUN composer install

COPY .docker/prod/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT docker-entrypoint
