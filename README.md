[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fab6535fc-c531-43c9-b174-0f759dfc0000%3Fdate%3D1%26label%3D1%26commit%3D1&style=plastic)](https://forge.laravel.com/servers/882659/sites/2604937)

Caso não possua pasta vendor, usar:
docker run -v /c/xampp/htdocs/boilerplate:/var/www/html -w /var/www/html composer install --ignore-platform-reqs
docker run -v ./:/var/www/html -w /var/www/html composer install --ignore-platform-reqs

docker run --rm \
 -u "$(id -u):$(id -g)" \
 -v $(pwd):/var/www/html \
 -w /var/www/html \
 laravelsail/php81-composer:latest \
 composer install --ignore-platform-reqs

docker run --rm \
 -u "$(id -u):$(id -g)" \
 -v $(pwd):/var/www/html \
 -w /var/www/html \
 composer install --ignore-platform-reqs
