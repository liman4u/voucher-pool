#!/bin/bash

docker-compose down

composer install

docker-compose up -d --force-recreate

>&2 echo "Waiting for MySql to run. Please wait....."
sleep 30
>&2 echo "MySql started :)"
>&2 echo "Running all phpunit tests now...."

docker container exec -it voucherpoolapi_web  php artisan migrate


docker container exec -it voucherpoolapi_web  composer test:all

>&2 echo "Voucher pool api v1 is now ready "