<style>
	img{
		max-height: 200px;
		max-width: 200px;
	}
</style>
<?php if (!$_GET['userid']){ ?>
	<h2>Добавление нового файла</h2>

	<form action="/files/upload" method="post" enctype="multipart/form-data">
		<input type="file" name="photo" accept="image/*"><br>
		<input type="submit" value="Загрузить">
	</form>
<?php } ?>

<h2>Загруженные файлы</h2>

<table>
	<thead>
		<tr>
			<th>id</th>
			<th>Картинка</th>
			<th>Дата</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $file){ ?>
			<tr>
				<td><?php echo $file['id'] ?></td>
				<td><img src="<?php echo '/files/'.$file['name'] ?>"></td>
				<td><?php echo $file['date']; ?></td>
			</tr>
		<?php } ?>
		<?php if (empty($data)){ ?>
			<tr><td colspan="3">Файлов пока нет</td></tr>
		<?php } ?>
	</tbody>
</table>