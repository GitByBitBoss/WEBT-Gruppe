FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer --version

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN chmod +x /var/www/html

RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

RUN { \
  echo 'xdebug.mode=coverage'; \
  echo 'xdebug.start_with_request=0'; \
} > /usr/local/etc/php/conf.d/xdebug.ini
