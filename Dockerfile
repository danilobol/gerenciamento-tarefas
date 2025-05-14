FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libssl-dev \
    libsasl2-dev \
    pkg-config \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    graphviz \
  && docker-php-ext-configure gd \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install  pdo_mysql \
  && docker-php-ext-install  mysqli \
  && docker-php-ext-install  zip \
  && docker-php-ext-install  sockets \
  && docker-php-source delete \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb \
  && a2enmod rewrite \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer require jenssegers/mongodb --ignore-platform-reqs

WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=80
EXPOSE 8000
