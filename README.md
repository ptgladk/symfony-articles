Simple symfony API project
==========================

To run project:
```sh
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console server:run
```

To create first admin user:
```sh
php bin/console admin:create
```
