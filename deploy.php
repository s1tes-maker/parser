<?php

$path = "../var/www/domains/ovz1.wallc.gmzem.vps.myjino.ru/";

//artisan
$output = shell_exec('php ' .$path. 'artisan migrate');
echo $output;

$output = shell_exec('php ' .$path. 'artisan storage:link');
echo $output;

$output = shell_exec('php ' .$path. 'artisan cache:clear');
echo $output;

$output = shell_exec('php ' .$path. 'artisan config:cache');
echo $output;

//копировать из .gitignore секретные файлы
$output = shell_exec('cp -r forcopy/* ' . $path);
echo $output;

//права на папки
$output = shell_exec('chmod -R 777 ' . $path . 'storage/logs');
echo $output;

$output = shell_exec('chmod -R 777 ' . $path . 'storage/framework');
echo $output;



