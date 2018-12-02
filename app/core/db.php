<?php

namespace App;
use Symfony\Component\Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as DB;

$dotenv = new Dotenv();
$dotenv->load(BASE_DIR.'.env');

$DB = new DB;

$DB->addConnection([
	'driver'    => 'mysql',
	'host'      => $_ENV['DB_HOST'],
	'username'  => $_ENV['DB_USER'],
	'password'  => $_ENV['DB_PASSWORD'],
	'database'  => $_ENV['DB_NAME'],
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
]);
$DB->setAsGlobal();
$DB->bootEloquent();
