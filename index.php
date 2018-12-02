<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', __DIR__.DS);
define('APP_DIR', __DIR__.DS.'app'.DS);
define('VIEW', __DIR__.DS.'app'.DS.'views'.DS);

require BASE_DIR.'vendor'.DS.'autoload.php';
require APP_DIR.'core'.DS.'db.php';
require APP_DIR.'core'.DS.'BaseController.php';
require APP_DIR.'core'.DS.'router.php';
