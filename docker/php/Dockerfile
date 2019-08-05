FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev git unzip vim

# php-gdに必要なライブラリ
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev

# php extensions
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \    
    docker-php-ext-install pdo pdo_pgsql && \
    docker-php-ext-install gd

# composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer config -g repos.packagist composer https://packagist.jp
RUN composer global require hirak/prestissimo
