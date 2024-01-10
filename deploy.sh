# Turn on maintenance mode
php artisan down || true

# Pull the latest changes from the git repository
git reset --hard
git clean -df
git pull origin dev

# Install/update composer dependencies
../composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# Turn off maintenance mode
php artisan up