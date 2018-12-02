<?php

namespace App\core;

abstract class BaseController
{
	protected $model;
	protected $defaultAction;

	public function view($file, $data = array())
	{
		include VIEW.$file.'.php';
	}

	public function default()
	{
		$class = get_class($this);
		$class = explode('\\', $class);
		$class = end($class);

		header('Location: /'.strtolower($class).'/'.strtolower($this->defaultAction));
		die;
	}
}
