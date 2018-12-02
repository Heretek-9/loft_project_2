<?php

namespace App\controllers;
use \App\models\User;

class Users extends \App\core\BaseController
{
	protected $defaultAction = 'auth';

	function __construct()
	{
		$this->$model = new User;
	}

	public function profile()
	{
		if (!$_SESSION['userId']) {
			header('Location: /users/auth');
			die;
		}

		if ($_SESSION['admin'] && $_POST['admin_userid']) {
			$userId = $_POST['admin_userid'];
		} else {
			$userId = $_SESSION['userId'];
		}

		$user = $this->$model->where('id', $userId)->first()->toArray();

		if ($_POST['admin_userid']) {
			echo json_encode($user);
		} else {
			if ($_SESSION['update'] == 'done') {
				$user['displayUpdateMsg'] = true;
				unset($_SESSION['update']);
			}
			$this->view('profile', $user);
		}
	}

	public function edit()
	{
		if ($_SESSION['admin'] && $_POST['admin_userid']) {
			$userId = $_POST['admin_userid'];
		} else {
			$userId = $_SESSION['userId'];
		}
		$update = array(
			'name' => $_POST['name'],
			'age' => $_POST['age'],
			'description' => $_POST['description'],
		);

		if ($_FILES['photo']['tmp_name'] && $_FILES['photo']['error'] === 0) {
			$filename = explode('.', $_FILES['photo']['name']);
			$filename[(count($filename)-2)] .= '_'.time();
			$filename = implode('.', $filename);
			if (!is_dir(BASE_DIR.'files')) {
				mkdir(BASE_DIR.'files');
			}
			if (move_uploaded_file($_FILES['photo']['tmp_name'], BASE_DIR.'files'.DS.$filename)) {
				$update['photo'] = $filename;
			}
			$oldPhoto = $this->$model->where('id', $userId)->select('photo')->first()->toArray();
			if ($oldPhoto['photo']) {
				if (is_file(BASE_DIR.'files'.DS.$oldPhoto['photo'])) {
					unlink(BASE_DIR.'files'.DS.$oldPhoto['photo']);
				}
			}
		}

		if ($_POST['admin'] == 'on') {
			$update['admin'] = 1;
		} else {
			$update['admin'] = 0;
		}

		$this->$model->where('id', $userId)->update($update);

		if (!$_POST['admin_userid']) {
			$_SESSION['update'] = 'done';
			header('Location: /users/profile');
		} else {
			echo json_encode('ok');
		}
	}

	public function auth()
	{
		if ($_POST['email'] && $_POST['pass']) {
			$error = 'Неправильная почта или пароль';
			$user = $this->$model->where('email', $_POST['email'])->first()->toArray();
			if ($user['password']) {
				if(password_verify($_POST['pass'], $user['password'])) {
					$_SESSION['userId'] = $user['id'];
					$_SESSION['admin'] = $user['admin'];
					header('Location: /users/profile');
					die;
				}
			}
		}

		$this->view('auth', array('error' => $error));
	}

	public function logout()
	{
		unset($_SESSION);
		header('Location: /users/auth');
	}

	public function create()
	{
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$error = 'Введена некорректная почта';
		}

		if (!$error && $_POST['email'] && $_POST['pass']) {
			
			$users = $this->$model->where('email', $_POST['email'])->get()->toArray();

			if (empty($users)) {
				$data = array(
					'email' => $_POST['email'],
					'password' => password_hash($_POST['pass'], PASSWORD_DEFAULT),
					'name' => $_POST['name'],
					'age' => $_POST['age'],
					'description' => $_POST['description'],
				);

				if ($_FILES['photo']['tmp_name'] && $_FILES['photo']['error'] === 0) {
					$filename = explode('.', $_FILES['photo']['name']);
					$filename[(count($filename)-2)] .= '_'.time();
					$filename = implode('.', $filename);
					if (!is_dir(BASE_DIR.'files')) {
						mkdir(BASE_DIR.'files');
					}
					if (move_uploaded_file($_FILES['photo']['tmp_name'], BASE_DIR.'files'.DS.$filename)) {
						$data['photo'] = $filename;
					}
				}

				if ($_POST['admin'] == 'on') {
					$data['admin'] = 1;
				} else {
					$data['admin'] = 0;
				}

				$id = $this->$model->insertGetId($data);
				if (!$_POST['admin_userCreate']) {
					$_SESSION['userId'] = $id;
					$_SESSION['admin'] = $data['admin'];
					header('Location: /users/profile');
				} else {
					echo json_encode('ok');
					die;
				}
			}
			$error = 'Пользователь с почтой '.$_POST['email'].' уже зарегистрирован';
		}
		if ($_POST['admin_userCreate']) {
			echo json_encode($error);
		} else {
			$this->view('create', array('error' => $error));
		}
	}
}
