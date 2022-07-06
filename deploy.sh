#!/bin/bash
cp -r ../../cgi-bin/forcopy/. ./
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan config:cache
chmod -R 777 storage/logs storage/framework



