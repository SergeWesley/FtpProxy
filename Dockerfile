# Utilisation de PHP 8.2 avec Apache intégré
FROM php:8.2-apache

# Les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Les extensions PHP nécessaires
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_sqlite \
    && docker-php-ext-install intl \
    && docker-php-ext-install ftp

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /srv/app
COPY /docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY /docker/ports.conf /etc/apache2/ports.conf

WORKDIR /srv/app
RUN chown -R www-data:www-data /srv/app
RUN chmod -R 755 /srv/app

# Active mod_rewrite pour gérer les réécritures d'URL
RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 10000

RUN composer install 

USER www-data

