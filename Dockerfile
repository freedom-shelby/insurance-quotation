FROM php:8.5-fpm-alpine

RUN apk add --no-cache \
    curl \
    git \
    unzip \
    zip

RUN docker-php-ext-install \
    bcmath \
    pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000

CMD ["sh", "-c", "chown -R www-data:www-data storage bootstrap/cache && php-fpm"]
