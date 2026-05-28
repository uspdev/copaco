FROM uspdev/uspdev-php-apache:latest

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libcurl4-openssl-dev \
        libgmp-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libldap2-dev \
        libpng-dev \
        libxml2-dev \
        libtidy-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        curl \
        gd \
        gmp \
        intl \
        ldap \
        pdo_mysql \
        tidy \
        xml \
        zip \
    && a2enmod rewrite \
    && sed -ri \
        -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --prefer-dist \
        --no-progress \
    && php artisan key:generate --force --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache public

EXPOSE 80

CMD ["apache2-foreground"]