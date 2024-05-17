FROM php:8.3-apache

RUN apt-get update && get upgrade -y && apt-get install -y git
RUN curl -sS https://getcomposer.org/installer | php -- --install=dir=/usr/local/bin --filename=composer

