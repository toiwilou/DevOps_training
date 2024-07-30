FROM composer:2.7.2 AS composer

FROM php:8.2-fpm

# Use the default production configuration
RUN apt-get update && apt-get install -y \
	acl \
	libaio-dev \
    libcurl4-openssl-dev \
	libfcgi-bin \
	libicu-dev \
	libonig-dev \
	libpng-dev \
	libpq-dev \
	libssh-dev \
	libxml2-dev \
	unzip \
	uuid-dev \
	iputils-ping \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-install mbstring sockets intl ctype iconv curl opcache  bcmath soap mysqli pdo_mysql \
	&& pecl install -o -f uuid apcu && docker-php-ext-enable uuid apcu && pear clear-cache

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
# RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli -y
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
CMD ["php-fpm"]