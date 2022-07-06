// Login form using Ajax

jQuery(document).ready(function($){
	$('form[name="wdt-login_form"]').submit(function(event){
		event.preventDefault();
		var data = {
			action: $(this).find('[name="action"]').val(),
			user_login: $(this).find('[name="user_login"]').val(),
			user_pass: $(this).find('[name="user_pass"]').val(),
		}

		$.post( ajax_object.ajax_url, data, function(res){
			let response = JSON.parse(res);
			if( response.status == 'success'){
				alert('successfully logged in');
			}else{
				alert(response.msg);
			}
		});
	});

	$('form[name="wdt-register_form"]').submit(function(event){
		event.preventDefault();
		// user_pass_confirm
		if( $(this).find('[name="user_pass"]').val() !== $(this).find('[name="user_pass_confirm"]').val() ){
			alert('password not matched');
			return false;
		}

		var data = {
			action: $(this).find('[name="action"]').val(),
			first_name: $(this).find('[name="first_name"]').val(),
			last_name: $(this).find('[name="last_name"]').val(),
			user_login: $(this).find('[name="user_login"]').val(),
			user_pass: $(this).find('[name="user_pass"]').val(),
		};

		$.post( ajax_object.ajax_url, data, function(res){
			let response = JSON.parse(res);
			if( response.status == 'success'){
				alert('successfully created');
			}else{
				alert(response.msg);
			}
		});
	});

});