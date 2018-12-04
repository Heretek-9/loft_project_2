<link href="/app/css/admin.css" rel="stylesheet">
<h2>Пользователи</h2>
<a href="/admin/showall<?php echo ($_GET['sort'] == 'desc'?'':'?sort=desc') ?>">По <?php echo ($_GET['sort'] == 'desc'?'убыванию':'возрастанию') ?> возраста</a><br>
<button id="addNewUser">Добавить нового пользователя</button>
<table>
	<thead>
		<tr>
			<th>id</th>
			<th>Имя</th>
			<th>Почта</th>
			<th>Описание</th>
			<th>Возраст</th>
			<th>Фото</th>
			<th>Дата создания</th>
			<th>Дата изменения</th>
			<th style="width: 150px;">Действия</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $user){ ?>
			<tr data-id="<?php echo $user['id'] ?>">
				<td><?php echo $user['id'] ?></td>
				<td><?php echo $user['name'] ?></td>
				<td><?php echo $user['email'] ?></td>
				<td><?php echo $user['description'] ?></td>
				<td><?php echo $user['age'] ?> (<?php echo $user['ageComment'] ?>)</td>
				<td><?php echo ($user['photo']?'<img src="/files/'.$user['photo'].'">':'') ?></td>
				<td><?php echo $user['created_at'] ?></td>
				<td><?php echo $user['updated_at'] ?></td>
				<td>
					<a href="javascript:void(0);" class="editUser">Редактировать</a><br>
					<a href="/admin/viewfiles?userid=<?php echo $user['id'] ?>">Посмотреть Файлы</a><br>
					<?php if ($_SESSION['userId'] != $user['id']){ ?>
						<a href="javascript:void(0);" class="deleteUser">Удалить</a><br>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<div id="userModal">
	<span id="modalTitle"></span>
	<a id="closeModal" href="javascript:void(0);">Закрыть Х</a><br><hr>

	<form action="" method="post" enctype="multipart/form-data">
		<span id="newUser">
			<span class="modalText">Почта:</span> <input type="text" name="email" required><br>
			<span class="modalText">Пароль:</span> <input type="text" name="pass" required><br>
			<input type="hidden" name="admin_userCreate" value="1">
		</span>
		<input type="hidden" name="admin_userid">
		<span class="modalText">Имя:</span> <input type="text" name="name" value="<?php echo $data['name'] ?>"><br>
		<span class="modalText">Возраст:</span> <input type="number" name="age" value="<?php echo $data['age'] ?>"><br>
		<span class="modalText">Описание:</span> <textarea name="description" cols="30" rows="10"><?php echo $data['description'] ?></textarea><br>
		<span class="modalText">Фото:</span> 
			<img src=""><br>
		<span class="modalText"> </span>	<input type="file" name="photo" accept="image/*"><br>
		<span class="modalText">Администратор:</span> <input type="checkbox" name="admin" <?php echo ($data['admin']?'checked':'')?>><br><br>
		<input type="submit" value="Зарегистрировать">
	</form>
</div>
<div id="screenBlock"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="/app/js/admin.js"></script>