# Gebruik een officiële PHP runtime als basisimage
FROM php:8.0-apache

# Stel de werkdirectory in
WORKDIR /var/www/html

# Kopieer de huidige directory inhoud naar de werkdirectory
COPY . /var/www/html

# Installeer eventuele benodigde PHP-extensies
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Open poort 80 voor het HTTP-verkeer
EXPOSE 80

# Stel het commando in om de Apache-server te starten wanneer de container start
CMD ["apache2-foreground"]
