<?php

namespace App\controllers;
use \App\models\File;
use \App\models\User;

class Admin extends \App\controllers\BaseController
{
	protected $defaultAction = 'showAll';

	function __construct()
	{
		if (!$_SESSION['userId'] || !$_SESSION['admin']) {
			unset($_SESSION);
			header('Location: /users/auth');
			die;
		}
		$this->$userModel = new User;
		$this->$fileModel = new File;
	}

	public function showAll()
	{
		if ($_GET['sort'] == 'desc') {
			$sort = 'sortByDesc';
		} else {
			$sort = 'sortBy';
		}
		$model = new User;
		$users = $model->all()->{$sort}('age')->toArray();

		foreach ($users as $key => $user) {
			if ($user['age'] >= 18) {
				$users[$key]['ageComment'] = 'Совершеннолетний';
			} else {
				$users[$key]['ageComment'] = 'Несовершеннолетний';
			}

			$users[$key]['name'] = htmlspecialchars($user['name']);
			$users[$key]['email'] = htmlspecialchars($user['email']);
			if (mb_strlen($user['description']) > 75) {
				$users[$key]['description'] = mb_substr(htmlspecialchars($user['description']), 0, 75, 'utf-8').'...';
			} else {
				$users[$key]['description'] = htmlspecialchars($user['description']);
			}

			$users[$key]['created_at'] = date('d.m.Y H:i:s', strtotime($user['created_at']));
			$users[$key]['updated_at'] = date('d.m.Y H:i:s', strtotime($user['updated_at']));
		}
		$this->view('admin', $users);
	}

	public function viewFiles()
	{
		if ($_GET['userid']) {
			$model = new File;
			$files = $model->where('user_id', $_GET['userid'])->get()->toArray();
			foreach ($files as $key => $file) {
				$files[$key]['date'] = date('d.m.Y H:i:s', filemtime(BASE_DIR.'files'.DS.$file['name']));
			}
			$this->view('files', $files);
		}
	}

	public function deleteUser()
	{
		$fileModel = new File;
		$files = $fileModel->where('user_id', $_POST['userid'])->get()->toArray();
		foreach ($files as $file) {
			if (is_file(BASE_DIR.'files'.DS.$file['name'])) {
				unlink(BASE_DIR.'files'.DS.$file['name']);
			}
		}

		$userModel = new User;
		$oldPhoto = $userModel->where('id', $_POST['userid'])->select('photo')->first()->toArray();
		if ($oldPhoto['photo']) {
			if (is_file(BASE_DIR.'files'.DS.$oldPhoto['photo'])) {
				unlink(BASE_DIR.'files'.DS.$oldPhoto['photo']);
			}
		}
		$userModel->where('id', $_POST['userid'])->delete();
		echo json_encode('ok');
	}
}
