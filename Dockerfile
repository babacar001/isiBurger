# Utiliser une image officielle PHP avec FPM et Composer intégré
FROM php:8.2-fpm

# Installer les dépendances système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers Laravel dans l'image
COPY . .

# Installer les dépendances de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copier et configurer le fichier .env
COPY .env.example .env
RUN php artisan key:generate

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
