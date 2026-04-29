FROM php:8.2-apache

# Instalar extensiones necesarias para conectar PHP con PostgreSQL (Supabase)
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copia tus archivos al servidor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
