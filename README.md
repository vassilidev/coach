## Coach

```sh
git clone git@github.com:vassilidev/coach.git
```

```sh
cd coach
```

```sh
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```

```sh
cp .env.example .env
```

```sh
sail up
```

```sh
sail artisan key:generate
```

```sh
sail artisan migrate:fresh --seed
```