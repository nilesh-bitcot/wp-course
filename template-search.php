<?php
/**
 * Template Name: Search Template (Ajax)
 */

get_header();
$paged = get_query_var('paged')? get_query_var('paged') : 1;

// echo wp_nonce_url( get_the_permalink(), 'trash-post_' );
?>
<div style="display:flex;width:100%">
    <form name="search__form">
        <input type="text" name="search_value" placeholder="Search...">
        <input type="hidden" name="page" value="<?php echo $paged; ?>">
        <input type="submit" value="search" name="search">
    </form>
</div>
<div style="display:flex;width:100%;padding-top:20px;padding-bottom:20px">
    
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

    <div id="search__results"></div>
</div>
<div style="display:flex;width:100%;padding-top:10px;padding-bottom:30px">
    <div id="search__results__page"></div>
</div>

<script>
    jQuery(document).ready(function($){
        var current_page = 1,
            search_value = '';
        $('form[name="search__form"]').submit(function(e){
            e.preventDefault();
            let s = $(this).find('[name="search_value"]').val();

            if( s.trim() == '') return false;
            search_value = s.trim();
            do_search_ajax(1);
        })

        $(document).on('click', '.anchor', function(e){
            let page = $(this).data('page');
            current_page = parseInt(page);
            do_search_ajax(page);
        })

        function do_search_ajax(page = 1){
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data : {
                    search_input:search_value,
                    action:'search__ajax',
                    posts_per_page:2,
                    paged:page
                },
                beforeSend:function(){
                    $('#post_list_loader').show();
                    $('#search__results').html('');
                },
                success:function(res){
                    let response = JSON.parse(res);
                    let pagination ='';
                    if( response.html !== '' ){
                        $('#search__results').html(response.html);
                        if( response.totol_page > 1 ){
                            for(let i = 1; i <= response.totol_page; i++){
                                let active_page = '';
                                if(current_page == i){
                                    active_page = 'active';
                                }
                                pagination += `<a class="anchor ${active_page}" data-page="${i}">${i}</a>`;
                            }
                        }
                        
                        $('#search__results__page').html(pagination);
                    }
                    
                }
            }).done(function(){
                $('#post_list_loader').hide();
            })
        }
    })
</script>
<?php
get_footer();