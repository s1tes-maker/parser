#!/bin/bash
readonly path="../var/www/domains/ovz1.wallc.gmzem.vps.myjino.ru/"
pwd
cp -r ../../forcopy/ $path
cd $path
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan config:cache
chmod -R 777 storage/logs storage/framework



