FROM php:8.2-apache

# Copia todos tus archivos al servidor
COPY . /var/www/html/

# Expone el puerto 80
EXPOSE 80
