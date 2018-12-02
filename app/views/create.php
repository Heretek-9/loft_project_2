<h2>Регистрация нового пользователя</h2>

<form action="/users/create" method="post" enctype="multipart/form-data">
	Почта: <input type="text" name="email" required><br>
	Пароль: <input type="text" name="pass" required><br>
	Имя: <input type="text" name="name" value="<?php echo $data['name'] ?>"><br>
	Возраст: <input type="number" name="age" value="<?php echo $data['age'] ?>"><br>
	Описание: <textarea name="description" cols="30" rows="10"><?php echo $data['description'] ?></textarea><br>
	Фото: 
		<?php if ($data['photo']){ ?>
			<img src="/files/<?php echo $data['photo'] ?>"><br>
		<?php } ?>
		<input type="file" name="photo" accept="image/*"><br>
	Администратор: <input type="checkbox" name="admin" <?php echo ($data['admin']?'checked':'')?>><br>
	<input type="submit" value="Зарегистрироваться">
</form>
