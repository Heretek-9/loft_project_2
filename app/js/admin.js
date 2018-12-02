$('body').on('click','.deleteUser', function() {
	var userid = $(this).closest('tr').data('id');
	if (!confirm('Удалить пользователя с id '+userid)) {return false;}
	$.ajax({
		url: '/admin/deleteUser',
		type: "POST",
		data: {userid: userid },
		dataType: 'json',
		success: function(response){
			window.location.reload(true);
		}
	});
});
$('#userModal form').on('submit', function(e) {
	e.preventDefault();

	var form = $(this);
	form.ajaxSubmit({
		type: 'POST',
		url: form.attr('action'),
		dataType: 'json',
		cache: false,
		success: function(response) {
			if (response && response != 'ok') {
				alert(response);
			} else {
				window.location.reload(true);
			}
		}
	});
});
$('body').on('click','#closeModal', function() {
	$('#userModal').hide();
	$('#screenBlock').hide();
});
$('body').on('click','.editUser', function() {
	var userid = $(this).closest('tr').data('id');
	$.ajax({
		url: '/users/profile',
		type: "POST",
		data: {admin_userid: userid },
		dataType: 'json',
		success: function(response){
			$('#userModal #newUser').hide();
			$('#userModal form').attr('novalidate', 'novalidate');
			$('#userModal [name=admin_userid]').val(userid);
			if (response.photo) {
				$('#userModal img').attr('src', '/files/'+response.photo).show();
			} else {
				$('#userModal img').hide();
			}
			$('#userModal [name=photo]').val('');
			$('#userModal [name=name]').val(response.name);
			$('#userModal [name=age]').val(response.age);
			$('#userModal [name=description]').val(response.description);
			if (response.admin) {
				$('#userModal [name=admin]').prop('checked', true);
			} else {
				$('#userModal [name=admin]').prop('checked', false);
			}
			$('#userModal form').attr('action', '/users/edit');
			$('#modalTitle').text('Редактирование пользователя '+response.email);
			$('#userModal [type=submit]').val('Обновить пользователя');
			$('#userModal').show();
			$('#screenBlock').show();
		}
	});
});
$('body').on('click','#addNewUser', function() {
	$('#userModal #newUser').show();
	$('#userModal form').removeAttr('novalidate');

	$('#userModal [name=email]').val('');
	$('#userModal [name=pass]').val('');
	$('#userModal [name=admin_userid]').val('');
	$('#userModal img').hide();
	$('#userModal [name=photo]').val('');
	$('#userModal [name=admin_userid]').val('');
	$('#userModal [name=name]').val('');
	$('#userModal [name=age]').val('');
	$('#userModal [name=description]').val('');
	$('#userModal [name=admin]').prop('checked', false);

	$('#userModal form').attr('action', '/users/create');
	$('#modalTitle').text('Добавление нового пользователя');
	$('#userModal [type=submit]').val('Добавить пользователя');
	$('#userModal').show();
	$('#screenBlock').show();
});