FROM composer:1.9.0 as build
WORKDIR /app
COPY . /app
RUN composer global require hirak/prestissimo && composer install

FROM php:7.3-cli-alpine
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 8080
COPY --from=build /app /var/www/
WORKDIR /var/www/
COPY .env.prod /var/www/.env
RUN chmod 777 -R /var/www/storage/
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8080"]
