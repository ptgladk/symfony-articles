FROM php:7.0-apache

RUN a2enmod rewrite

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
