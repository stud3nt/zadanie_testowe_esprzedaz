FROM php:8.3-fpm

RUN apt update

RUN apt install -y libxml2-dev \
    libzip-dev \
    libpng-dev \
    acl \
    unzip

RUN docker-php-ext-install soap zip pcntl sockets gd mysqli pdo pdo_mysql dom xml

COPY php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer self-update --2

ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=1001

RUN usermod  --uid $UID $UNAME

RUN groupmod --gid $GID $UGROUP

USER www-data
