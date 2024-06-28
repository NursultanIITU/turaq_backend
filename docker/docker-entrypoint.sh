#!/bin/sh
set -e

# Run the artisan commands
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan admin-kit:install
php artisan jwt:secret
php artisan elastic:hot_refresh_search_indexes

# Ensure the correct permissions
chown -R www-data:www-data /var/www/html/storage/app/public

# Start Supervisor
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf