FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpq-dev \
  && pecl install xdebug \
	&& docker-php-ext-install -j$(nproc) pdo pdo_pgsql \
	&& docker-php-ext-enable xdebug

RUN mkdir /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html
USER www-data:www-data
EXPOSE 9000
CMD ["php-fpm"]
