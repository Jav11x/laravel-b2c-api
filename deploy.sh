#!/usr/bin/env bash
set -euo pipefail

if ! command -v composer &>/dev/null; then echo "Composer no instalado" >&2; exit 1; fi
composer install --no-dev --prefer-dist --optimize-autoloader

if [ ! -f .env ]; then cp .env.example .env; php artisan key:generate; fi

php artisan migrate --force --seed

php artisan config:cache
php artisan route:cache
php artisan view:cache

chmod -R ug+rwx storage bootstrap/cache || true

nohup php artisan serve --host=127.0.0.1 --port=80 >/dev/null 2>&1 &
echo "Aplicación levantada en :80"
echo "Despliegue completado"