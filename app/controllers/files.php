<?php 

namespace App\controllers;
use \App\models\File;

class Files extends \App\core\BaseController
{
	protected $defaultAction = 'showAll';

	function __construct()
	{
		if (!$_SESSION['userId']) {
			header('Location: /users/auth');
			die;
		}

		$this->$model = new File;
	}

	public function showAll()
	{
		$files = $this->$model->where('user_id', $_SESSION['userId'])->get()->toArray();
		foreach ($files as $key => $file) {
			$files[$key]['date'] = date('d.m.Y H:i:s', filemtime(BASE_DIR.'files'.DS.$file['name']));
		}
		$this->view('files', $files);
	}
	public function upload()
	{
		if ($_FILES['photo']['tmp_name'] && $_FILES['photo']['error'] === 0) {
			$filename = explode('.', $_FILES['photo']['name']);
			$filename[(count($filename)-2)] .= '_'.time();
			$filename = implode('.', $filename);
			if (!is_dir(BASE_DIR.'files')) {
				mkdir(BASE_DIR.'files');
			}
			if (move_uploaded_file($_FILES['photo']['tmp_name'], BASE_DIR.'files'.DS.$filename)) {
				$update['photo'] = $filename;
				$data = array(
					'user_id' => $_SESSION['userId'],
					'name' => $filename
				);
				$this->$model->insert($data);
			}
		}
		header('Location: /files/showall');
	}
}
