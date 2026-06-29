#!/usr/bin/env bash
# Referentie-deployscript voor ploi.io.
# ploi genereert zelf een vergelijkbaar script in de Repository-tab; pas onderstaande
# regels daar zo nodig op aan. {SITE_DIRECTORY} wordt door ploi ingevuld; pas anders
# het pad en de PHP-FPM-versie aan je server aan.

cd /home/ploi/{SITE_DIRECTORY}

git pull origin main

composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "" | sudo -S service php8.4-fpm reload

php artisan queue:restart

echo "🚀 Deploy klaar!"
