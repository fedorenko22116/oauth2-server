#!/usr/bin/env sh

until nc -z -v -w30 db 3306
do
    echo "Waiting for database connection..."
    sleep 5
done

php bin/console doctrine:database:create -n --if-not-exists
#php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:schema:create -n || true

php-fpm
