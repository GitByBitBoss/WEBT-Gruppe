# Verwende das PHP 8.2 FPM Image als Basis
FROM php:8.2-fpm

# Installiere Abhängigkeiten für Composer (curl, unzip, git)
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Installiere Composer global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Stelle sicher, dass Composer korrekt installiert wurde
RUN composer --version

# Setze das Arbeitsverzeichnis
WORKDIR /var/www/html

# Kopiere die Projektdateien ins Container-Verzeichnis
COPY . /var/www/html

# Setze die Datei- und Verzeichnisberechtigungen
RUN chown -R www-data:www-data /var/www/html

# Stelle sicher, dass die richtigen Berechtigungen für die Composer-Dateien gesetzt sind
RUN chmod +x /var/www/html

# Startbefehl (wird nicht benötigt, weil der Nginx-Container den Webserver verwaltet)
