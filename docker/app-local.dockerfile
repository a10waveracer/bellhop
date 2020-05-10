FROM php:7.4-fpm-buster
RUN apt-get update && apt-get install -y libmcrypt-dev openssl zip unzip git procps nano iputils-ping htop \
    default-mysql-client wget libonig-dev \
    screen libzip-dev \
    --no-install-recommends \
    && docker-php-ext-install pdo_mysql bcmath mbstring sockets pcntl zip

RUN pecl install xdebug-2.9.5 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -fLSs https://circle.ci/cli | bash
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www
