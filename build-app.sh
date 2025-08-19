#!/bin/bash
set -e

# Build assets
npm run build

# Clear and cache Laravel components
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# Ensure SQLite exists
mkdir -p database
touch database/database.sqlite

# Run migrations and seed
php artisan migrate --seed --force