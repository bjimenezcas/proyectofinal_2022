FROM php:8.0.9-apache

ARG PHP_ENABLE_XDEBUG

#copy files
COPY . /var/www/html/proyect
RUN chmod 777  /var/www/html/proyect/backend/web/assets
COPY ./docker/apache/php.ini /usr/local/etc/php/php.ini
COPY ./docker/apache/vhost /etc/apache2/sites-enabled
RUN rm -rf /etc/apache2/sites-enabled/000-default.conf

RUN mkdir -p  /var/www/html/proyect/backend/runtime
RUN chmod 777  /var/www/html/proyect/backend/runtime

RUN apt-get update

RUN apt-get install -y \
    git \
    zip \
    libzip-dev \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libpq-dev \
    g++

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd  && docker-php-ext-install zip

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath

RUN docker-php-ext-install pdo pdo_mysql #mysql

RUN a2enmod rewrite
RUN a2enmod headers

#Install xdebug
RUN if [ "${PHP_ENABLE_XDEBUG}" = "true" ] ; then pecl install xdebug-3.0.4 && docker-php-ext-enable xdebug; fi

#for warning in docker container, disabled for aws
#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "ok" >> /var/www/html/index.html

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install --working-dir=/var/www/html/proyect



#USER root
