<h2>Авторизация пользователя</h2>
<form action="/users/auth" method="post">
	Почта: <input type="text" name="email" required><br>
	Пароль: <input type="text" name="pass" required><br>
	<input type="submit">
</form><br>
<?php echo $data['error'] ?>