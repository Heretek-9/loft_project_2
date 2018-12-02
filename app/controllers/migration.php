<?php

namespace App\controllers;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as DB;
use Faker\Factory as faker;
use \App\models\User;

class Migration
{
	public function tables()
	{
		DB::schema()->dropIfExists('users');

		DB::schema()->create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->integer('age');
			$table->text('description');
			$table->string('photo');
			$table->integer('admin');
			$table->timestamps();
		});

		DB::schema()->dropIfExists('files');

		DB::schema()->create('files', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('name');
		});
		echo 'Таблицы в базе данных созданы';
	}

	public function users()
	{
		$faker = faker::create();
		require_once APP_DIR.'models'.DS.'user.php';

		for($i = 0; $i < 50; $i ++)
		{
			$user = new User();
			$user->name = $faker->name;
			$user->password = password_hash($faker->password, PASSWORD_DEFAULT);
			$user->email = $faker->email;
			$user->description = $faker->text;
			$user->age = mt_rand(1, 100);
			$user->created_at = $faker->dateTime;
			$user->admin = 0;
			$user->save();
		}
		echo 'В базу данных добавлено 50 пользователей';
	}
}
