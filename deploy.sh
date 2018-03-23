#!/bin/bash

if [ $1 = 'docker' ];
then
    docker-compose build
    docker-compose up -d
    docker-compose exec app composer install
    docker-compose exec app php bin/console doctrine:database:create --if-not-exists --no-interaction
    docker-compose exec app php bin/console doctrine:schema:update --force
    docker-compose exec app php bin/console admin:create
else
    composer install
    php bin/console doctrine:database:create --if-not-exists --no-interaction
    php bin/console doctrine:schema:update --force
    php bin/console admin:create
fi
