FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y zip unzip curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

RUN echo "pm.max_children = 20" >> /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]