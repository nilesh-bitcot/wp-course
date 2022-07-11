<?php
/**
 * Template Name: Search Template (Ajax)
 */

get_header();

?>
<div style="display:flex;width:100%">
    <form name="search__form">
        <input type="text" name="search_value" placeholder="Search...">
        <input type="submit" value="search" name="search">
    </form>
</div>
<div style="display:flex;width:100%;padding-top:20px;padding-bottom:20px">
    <div id="search__results"></div>
    <div styel="display:none;" id="post_list_loader"><svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="100px" y="100px"
  viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
        <path fill="#333" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
        <animateTransform 
            attributeName="transform" 
            attributeType="XML" 
            type="rotate"
            dur="1s" 
            from="0 50 50"
            to="360 50 50" 
            repeatCount="indefinite" />
    </path>
    </svg></div>
</div>
<div style="display:flex;width:100%;padding-top:10px;padding-bottom:30px">
    <div id="search__results__page"></div>
</div>

<script>
    jQuery(document).ready(function($){
        $('form[name="search__form"]').submit(function(e){
            e.preventDefault();
            let s = $(this).find('[name="search_value"]').val();

            if( s.trim() == '') return false;
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data : {
                    search_input:s,
                    action:'search__ajax'
                },
                beforeSend:function(){
                    $('#post_list_loader').show();
                    $('#search__results').html('');
                },
                success:function(res){
                    let response = JSON.parse(res);
                    if( response.html !== '' ){
                        $('#search__results').html(response.html);
                    }
                    
                }
            })
            .done(function(res){
                $('#post_list_loader').hide();
            });
        })
    })
</script>
<?php
get_footer();