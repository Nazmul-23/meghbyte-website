#!/bin/sh
set -e
cd /var/www/html

# Render generates APP_SECRET; derive a stable Laravel key from it if APP_KEY is not set.
if [ -z "$APP_KEY" ] && [ -n "$APP_SECRET" ]; then
  APP_KEY=$(php -r 'echo "base64:".base64_encode(hash("sha256", getenv("APP_SECRET"), true));')
  export APP_KEY
fi

# Apache listens on the port Render assigns.
sed -i "s/^Listen .*/Listen ${PORT:-10000}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT:-10000}>/" /etc/apache2/sites-available/000-default.conf

# .dockerignore strips the placeholder files; view:clear/view:cache fail if these dirs are missing.
mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/logs bootstrap/cache

php artisan package:discover --ansi
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
