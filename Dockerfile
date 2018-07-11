FROM php:7.2-apache
COPY . /var/www/html
RUN chown www-data.www-data -R /var/www/html
EXPOSE 80
