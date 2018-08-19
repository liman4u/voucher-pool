#!/bin/bash

docker-compose down

composer install

docker-compose up -d --force-recreate

>&2 echo "Waiting for MySql to run. Please wait....."
sleep 30
>&2 echo "MySql started :)"
>&2 echo "Running all phpunit tests now...."

docker run --net="host" --rm -v $(pwd):/opt php:7.1.3-fpm php /opt/vendor/bin/phpunit /opt/tests

>&2 echo "Voucher pool api v1 is now ready "