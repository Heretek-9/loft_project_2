<?php

namespace App;

$sections = explode('?', $_SERVER['REQUEST_URI']);
$sections = explode('/', $sections[0]);
$sections = array_filter($sections);
$sections = array_values($sections);

if ($sections[0]) {
	$controller = $sections[0];
} else{
	$controller = 'users';
}

if ($sections[1]) {
	$action = $sections[1];
} else {
	$action = 'default';
}

$controllerFile = APP_DIR.'controllers'.DS.strtolower($controller).".php";

try {
	if (file_exists($controllerFile)) {
		require_once $controllerFile;
	} else {
		throw new \Exception('Контроллер '.$controller.' не найден');
	}

	$className = '\App\\controllers\\'.ucfirst($controller);

	if (class_exists($className)) {
		$controller = new $className();
	} else {
		throw new \Exception('Ошибка при загрузке класса '.$className);
	}

	if (method_exists($controller, $action)) {
		$controller->$action();
	} else {
		throw new \Exception('Ошибка при загрузке метода '.$action.' в классе '.$className);
	}
} catch (\Exception $e) {
	header('HTTP/1.0 404 Not Found');
	echo $e->getMessage();
}
