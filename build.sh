#!/usr/bin/env bash
# exit on error
set -o errexit

# Installe les dépendances PHP
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Installe les dépendances JavaScript et compile les assets
npm install
npm run build

# Lance les migrations de la base de données
php artisan migrate --force

# Vide les caches pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
