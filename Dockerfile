FROM php:8.3-apache

# Update and upgrade packages, install git and dependencies for PDO MySQL
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    git \
    libmariadb-dev-compat \
    libmariadb-dev

# Install the PHP PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache rewrite module
RUN /usr/sbin/a2enmod rewrite

# Copy the Apache configuration file
COPY default.conf /etc/apache2/sites-available/000-default.conf
