<?php 
/**
 * Template Name: Use Nonce
 */

 get_header();

/*
Created by                      checked by

wp_nonce_field()                check_admin_referer()

wp_create_nonce()               wp_verify_nonce();
*/
?>
<style>
    div.form {
    width: 100%;
    float: left;
}
</style>
<div class="info">
<pre>
Created by                      checked by

wp_nonce_field()                check_admin_referer()

wp_create_nonce()               wp_verify_nonce();
</pre>
</div>
<hr />
<div class="form">
<h2>nonce field example</h2>
<br>
<form method="post" name="search__postform_1">
    <input type="text" name="search_value" placeholder="Search...">
    
    <?php wp_nonce_field( 'search_form_nonce' ); ?>
    
    <input type="hidden" name="action" value="learn_nonce_1">
    <input type="submit" value="search" name="search">
</form>
</div>
<br>
<div class="form">
<h2>nonce hidden example wp_create_nonce</h2>
<br>
<form method="post" name="search__postform_2">
    <input type="text" name="search_value" placeholder="Search...">
    
    <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('search_form_nonce_2') ?>">
    <input type="hidden" name="action" value="learn_nonce_2">
    <input type="submit" value="search" name="search">
</form>
</div>
<br>
<div class="form">
<h2>nonce ajax example</h2>
<br>
<form method="post" name="search__postform_3">
    <input type="text" name="search_value" placeholder="Search...">
    
    <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('search_form_nonce_3') ?>">
    <input type="submit" value="search" name="search">
</form>
</div>
<script>
    jQuery(document).ready(function($){
        var ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';

        $('form[name="search__postform_3"]').submit(function(e){
            e.preventDefault();
            // alert('form submitted');
            var data = {action:'learn_nonce_ajax', nonce: $(this).find('[name="_nonce"]').val()};
            console.log(data);
            $.post(ajax_url, data, function(res){
                alert('form submitted');
            })
            .fail(function(xhr, status, error) {
                alert('fail');
            });
        })
    })
</script>
<?php
 get_footer();