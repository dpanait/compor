# Usar una imagen base oficial de PHP con Apache
FROM php:8.1-apache

# Habilitar mod_rewrite (si es necesario para tu proyecto)
RUN a2enmod rewrite

# Copiar los archivos del proyecto al contenedor
COPY src/ /var/www/html/

# Establecer los permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 para acceder al servidor web
EXPOSE 80