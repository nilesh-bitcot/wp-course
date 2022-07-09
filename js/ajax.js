// Login form using Ajax

jQuery(document).ready(function($){
	var current_page = 1;
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

	/**
	 * Get page with Ajax and custom pagination
	 */

	if( $('#post_list_wrapper').length > 0 ){
		
		call_get_post_ajax(current_page);

		$(document).on('click', '.anchor', function(e){
			e.preventDefault();
			let page = $(this).attr('data-page');
			if( parseInt(page) == current_page ) return false;

			current_page = parseInt(page);

			call_get_post_ajax(current_page);			
		});
	}

});


/**
 * 
 * @param {integer} current_page 
 */
function call_get_post_ajax(current_page){
	var $ = jQuery;
	// $('#list_pagination').html('');
	$.ajax({
		url:ajax_object.ajax_url,
		data:{
			action:'get_posts_ajax',
			posts_per_page:3,
			paged:current_page
		},
		beforeSend:function(){
			$('#post_list_loader').show();
			$('#post_list_wrapper').html('');
		},
		success:function(res){
			let response = JSON.parse(res);
			let total = parseInt(response.totol_page);
			let pagination = '';
			$('#post_list_wrapper').html(response.html);

			for(let i = 1; i <= total; i++){
				let active_page = '';
				if(current_page == i){
					active_page = 'active';
				}
				pagination += `<a class="anchor ${active_page}" data-page="${i}">${i}</a>`;
			}

			$('#list_pagination').html(pagination);
		}
	})
	.done(function(res){
		$('#post_list_loader').hide();
	});
}