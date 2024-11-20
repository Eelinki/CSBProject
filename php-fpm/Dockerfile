FROM php:8.3-fpm

COPY composer.lock composer.json /var/www/html/
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpq-dev \
  && pecl install xdebug \
	&& docker-php-ext-install -j$(nproc) pdo pdo_pgsql \
	&& docker-php-ext-enable xdebug

COPY . /var/www/html
COPY --chown=www-data:www-data . /var/www/html
USER www-data
EXPOSE 9000
CMD ["php-fpm"]
