FROM php:7.2-apache
RUN apt-get update && apt-get install -y libpng-dev libc-client2007e-dev libkrb5-dev libldap2-dev libmagickwand-dev
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install gd pdo_mysql pdo imap zip ldap mysqli mbstring opcache
RUN pecl install imagick-3.4.3
RUN docker-php-ext-enable imagick
COPY --chown=www-data:www-data . /var/www/html
USER www-data
RUN mkdir /var/www/html/upload/themes/survey
RUN mkdir /var/www/html/upload/surveys
USER root
RUN echo "upload_max_filesize = 4096M" > /usr/local/etc/php/php.ini
RUN echo "post_max_size = 4096M" >> /usr/local/etc/php/php.ini
EXPOSE 80
