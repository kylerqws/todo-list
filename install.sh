#!/bin/sh

set -o nounset -o errexit

BASE_DIR="$(realpath --canonicalize-existing "$(dirname "$0")")"

GROUP_ID="$(id --group)"
USER_ID="$(id --user)"

ENV_FILE="${BASE_DIR}/.env"
COMPOSER_FILE="${BASE_DIR}/composer.json"
VENDOR_DIR="${BASE_DIR}/vendor"

PHP_VERSION="php84" # Part of the PHP Composer image name in Laravel Sail
PHP_SERVICE="laravel.test" # Default PHP service name (don't change, affects initial installation)

SAIL_DOCKER_IMAGE="laravelsail/${PHP_VERSION}-composer:latest"
SAIL_WITH="mariadb" # Docker services separated by commas

if ! [ -f "$COMPOSER_FILE" ] && ! [ -d "$VENDOR_DIR" ]; then
    docker run --rm \
        --user "${USER_ID}:${GROUP_ID}" \
        --volume "${BASE_DIR}:/var/www/html" \
        --volume "${HOME}/.composer:/.composer:cached" \
        --env "COMPOSER_HOME=/.composer" \
        --workdir "/var/www/html" \
            "$SAIL_DOCKER_IMAGE" bash -c "
                composer create-project laravel/laravel;
                cd laravel && mv ./* ../ && mv ./.* ../ && cd - && rm -rf laravel;

                composer require laravel/sail --dev;
                php /var/www/html/artisan sail:install --with=${SAIL_WITH};
            "

    printf "\n%s\n%s\n" "WWWUSER=${USER_ID}" "WWWGROUP=${GROUP_ID}" >> "$ENV_FILE"

    # shellcheck source=./install.sh
    . "${BASE_DIR}/$(basename "$0")"
else
    if [ -f "$COMPOSER_FILE" ] && ! [ -d "$VENDOR_DIR" ]; then
        docker run --rm --interactive --tty \
            --user "${USER_ID}:${GROUP_ID}" \
            --volume "${BASE_DIR}:/app" \
            --volume "${HOME}/.composer:/tmp:cached" composer install
    fi

    cd "$BASE_DIR" # Go to the directory where the project files are located

        docker-compose stop
        docker-compose up --build --detach
        sleep 15

        docker-compose exec --user "$USER_ID" \
            "$PHP_SERVICE" bash -c "
                composer install;
                php artisan migrate;
                npm install && npm run dev;
            "

    cd - # We return to the directory from which the script was called
fi
