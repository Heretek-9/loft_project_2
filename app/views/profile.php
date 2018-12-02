<?php if ($data['displayUpdateMsg']){ ?>
	<h2>Данные обновлены</h2>
<?php } else { ?>
	<h2>Данные пользователя <?php echo $data['email'] ?></h2>
<?php } ?>
<a href="/users/logout">Выход</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="/files/showall">Файлы</a><br><br><br>
<form action="/users/edit" method="post" enctype="multipart/form-data">
	Имя: <input type="text" name="name" value="<?php echo $data['name'] ?>"><br>
	Возраст: <input type="number" name="age" value="<?php echo $data['age'] ?>"><br>
	Описание: <textarea name="description" cols="30" rows="10"><?php echo $data['description'] ?></textarea><br>
	Фото: 
		<?php if ($data['photo']){ ?>
			<img src="/files/<?php echo $data['photo'] ?>"><br>
		<?php } ?>
		<input type="file" name="photo" accept="image/*"><br>
	Администратор: <input type="checkbox" name="admin" <?php echo ($data['admin']?'checked':'')?>><br>
	<input type="submit" value="Обновить данные">
</form>
