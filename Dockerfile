FROM php:8.3.13-apache

# Configurer le nom du serveur Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf