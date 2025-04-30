#!/bin/sh

case "${1-}" in
  up) CMD="
        ./vendor/bin/sail up;
    " ;;
  *)  CMD="
        composer create-project laravel/laravel;
        cd laravel && mv ./* ../ && mv ./.* ../ && cd - && rm -rf laravel;

        composer require laravel/sail --dev && composer install;
        php artisan sail:install --with=mariadb;
    " ;;
esac

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html laravelsail/php84-composer:latest \
    bash -c "$CMD"
