FROM php:7.2-apache
RUN apt-get update && apt-get install -y libpng-dev libc-client2007e-dev libkrb5-dev libldap2-dev libmagickwand-dev
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install gd pdo_mysql pdo imap zip ldap mysqli mbstring
RUN pecl install imagick-3.4.3
RUN docker-php-ext-enable imagick
COPY . /var/www/html
RUN mkdir /var/www/html/upload/themes/survey
RUN chown www-data.www-data -R /var/www/html
EXPOSE 80
