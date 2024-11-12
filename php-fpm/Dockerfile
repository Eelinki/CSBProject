FROM php:8.3-fpm
RUN apt-get update && apt-get install -y libpq-dev \
  && pecl install xdebug \
	&& docker-php-ext-install -j$(nproc) pdo pdo_pgsql \
	&& docker-php-ext-enable xdebug