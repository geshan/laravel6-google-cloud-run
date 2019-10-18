FROM composer:1.9.0 as build
WORKDIR /app
COPY . /app
RUN composer global require hirak/prestissimo && composer install

FROM trafex/alpine-nginx-php7:latest

EXPOSE 8080
COPY --from=build /app /var/www/
#COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/
COPY .env.prod /var/www/.env
COPY public/* /var/www/html/
