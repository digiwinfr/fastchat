FROM php:7.3-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');" && \
mv composer.phar /usr/local/bin/composer

RUN a2enmod rewrite


RUN apt-get update && apt-get install -y --no-install-recommends git-core mysql-client && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

RUN composer install

COPY .docker/services/app/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./dump.sql /tmp/dump.sql
COPY .docker/services/app/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

#ENTRYPOINT /entrypoint.sh