FROM php:7.4

RUN apt-get update -y && apt-get install -y openssl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0

CMD php artisan passport:install

EXPOSE 8000

