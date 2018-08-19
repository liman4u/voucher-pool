#!/bin/bash

docker-compose down

composer install

docker-compose up -d --force-recreate

>&2 echo "Waiting for MySql to run. Please wait....."
sleep 30
>&2 echo "MySql started :)"
>&2 echo "Running all phpunit tests now...."

docker container exec -it voucherpool-app php artisan migrate
>&2 echo "Database migrations done..."


docker container exec -it voucherpool-app composer test
>&2 echo "All tests done..."


>&2 echo "Voucher pool api v1 is now ready "