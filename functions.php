<?php
/*
 * This is the child theme for Bootstrap Basic4 theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'bootstrap_basic4_child_enqueue_styles' );
function bootstrap_basic4_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
/*
 * Your code goes below
 */


// wdt_login_form
add_shortcode( 'wdt_login_form', 'wdt_login_form_shortcode_func' );
function wdt_login_form_shortcode_func( $atts ) {
    // $attributes = shortcode_atts( array(
    //     'title' => false,
    //     'limit' => 4,
    // ), $atts );
     
    ob_start();
    ?>
    <h2>Login form</h2>
    <form method="post" name="wdt-login_form">
        <input type="text" name="user_login" placeholder="Email/username">
        <input type="password" name="user_pass" placeholder="password">
        <input type="hidden" name="action" value="wdt_custom_login_action">
        <input type="submit" name="login" value="Login">
    </form>
 
    <?php
    return ob_get_clean();
}

// add_action('init', function(){
//     if( isset($_POST['action']) && $_POST['action'] == 'wdt_custom_login_action' ){
//         $userdata = array(
//             'user_login'    => $_POST['user_login'],
//             'user_password' => $_POST['user_pass'],
//             'remember'      => false
//         );

//         // if(filter_var($userdata['user_login'], FILTER_VALIDATE_EMAIL)) {}
     
//         $user = wp_signon( $userdata, false );
     
//         if ( is_wp_error( $user ) ) {
//             echo $user->get_error_message();
//         }
//         else{
//             wp_redirect( home_url() ); exit;
//         }
//     }
// });

/*************************************/

// wdt_registration_form
add_shortcode( 'wdt_registration_form', 'wdt_registration_form_shortcode_func' );
function wdt_registration_form_shortcode_func( $atts ) {
    ob_start();
    ?>
    <h2>Register form</h2>
    <form method="post" name="wdt-register_form">
        <input type="text" name="first_name" placeholder="first_name">
        <input type="text" name="last_name" placeholder="last_name">
        <input type="email" name="user_login" placeholder="Email">
        <input type="password" name="user_pass" placeholder="password">
        <input type="password" name="user_pass_confirm" placeholder="confirm password">
        <input type="hidden" name="action" value="wdt_custom_register_action">
        <input type="submit" name="signup" value="Register">
    </form>
 
    <?php
    return ob_get_clean();
}


// add_action('init', function(){
//     if( isset($_POST['action']) && $_POST['action'] == 'wdt_custom_register_action' ){
//         if( filter_var($_POST['user_login'], FILTER_VALIDATE_EMAIL) === false ) {
//             echo 'Not a valid email id'; return;
//         }
//         if( $_POST['user_pass'] !== $_POST['user_pass_confirm'] ){
//             echo 'password not matched'; return;
//         }
//         $userdata = array(
//             'first_name' => sanitize_text_field($_POST['first_name']),
//             'last_name' => sanitize_text_field($_POST['last_name']),
//             'user_login'    => $_POST['user_login'],
//             'user_email'  => $_POST['user_login'],
//             'user_pass' => $_POST['user_pass']
//         );

//         $user_id = wp_insert_user( $userdata );
     
//         if ( is_wp_error( $user_id ) ) {
//             echo $user_id->get_error_message();
//         }
//         else{
//             wp_redirect( home_url() ); exit;
//         }
//     }
// });

/*************** Login register using ajax *************/

add_action( 'wp_enqueue_scripts', 'wdt_ajax_enqueue_scripts' );
function wdt_ajax_enqueue_scripts() {
    wp_enqueue_script( 'ajax-js', get_stylesheet_directory_uri() . '/js/ajax.js', array('jquery'), time(), true );
    wp_localize_script( 'ajax-js', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );    
}


//add_action( 'wp_ajax_my_frontend_action', 'wdt_login_ajax_action' );
add_action( 'wp_ajax_nopriv_wdt_custom_login_action', 'wdt_login_ajax_action' );
function wdt_login_ajax_action(){
    $userdata = array(
        'user_login'    => $_POST['user_login'],
        'user_password' => $_POST['user_pass'],
        'remember'      => false
    );
 
    $user = wp_signon( $userdata, false );
 
    if ( is_wp_error( $user ) ) {        
        $err = $user->get_error_message();
        echo json_encode( array('status' => 'fail', 'msg' => $err ) );
        die();
    }
    else{
        echo json_encode( array('status' => 'success') );
        die();
    }
}


add_action( 'wp_ajax_nopriv_wdt_custom_register_action', 'wdt_custom_register_ajax_action' );
function wdt_custom_register_ajax_action(){

    if( filter_var($_POST['user_login'], FILTER_VALIDATE_EMAIL) === false ) {
       echo json_encode( array('status' => 'fail', 'msg' => 'email not valid' ) );
        die();
    }
    
    $userdata = array(
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'user_login'    => $_POST['user_login'],
        'user_email'  => $_POST['user_login'],
        'user_pass' => $_POST['user_pass']
    );

    $user_id = wp_insert_user( $userdata );
 
    if ( is_wp_error( $user_id ) ) {        
        $err = $user_id->get_error_message();
        echo json_encode( array('status' => 'fail', 'msg' => $err ) );
        die();
    }
    else{
        echo json_encode( array('status' => 'success') );
        die();
    }
}


/********* Restrict page for logged in users only ************/
add_action( 'template_redirect', 'wdt_restrict_template_redirect' );
function wdt_restrict_template_redirect() {
    if ( is_page( 'sample-page' ) && ! is_user_logged_in() ) {
        wp_redirect( home_url(), 307 );
        exit();
    }
}



/********* custom user fields/data ********/
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { 
    ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="hometown"><?php _e("Home Town"); ?></label></th>
        <td>
            <input type="text" name="hometown" id="hometown" value="<?php echo esc_attr( get_the_author_meta( 'hometown', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your hometown."); ?></span>
        </td>
    </tr>
    </table>
    <?php 
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'hometown', $_POST['hometown'] );
}


/***** Show that meta field in rest api also *****/

add_action( 'rest_api_init', 'register_experience_meta_fields');
function register_experience_meta_fields(){

    register_meta( 'user', 'hometown', array(
        'type' => 'string',
        'description' => 'hometown',
        'single' => true,
        'show_in_rest' => true
    ));
}

/**
 * Ajax handler for posts list with paginations
 */

add_action('wp_ajax_get_posts_ajax','get_posts_ajax_callback');
add_action('wp_ajax_nopriv_get_posts_ajax','get_posts_ajax_callback');
function get_posts_ajax_callback(){
    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 3;
    $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged
    );
    $html = '';
    $posts = new WP_Query($args);
    if( $posts->have_posts() ):
        while($posts->have_posts()):$posts->the_post();
            $html .= '<h3>'.get_the_title().'</h3>';
        endwhile;
    endif;
    $total_pages = $posts->max_num_pages;
    // echo $html;
    echo json_encode( array('html' => $html, 'totol_page'=> $total_pages) );
    die;

}

/**
 * Ajax search post
 */

add_action('wp_ajax_search__ajax','search__ajax_callback');
add_action('wp_ajax_nopriv_search__ajax','search__ajax_callback');
function search__ajax_callback(){
    
    $search_input = isset($_GET['search_input']) ? trim($_GET['search_input']) : '';
    // $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 3;
    // $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

    if( empty($search_input) ){
        echo json_encode( array('html' => '<p>Please enter any text to search</p>', 'totol_page'=> 0) );
        die;
    }

    $args = array(
        'post_type' => 'post',
        's' => $search_input,
        // 'posts_per_page' => $posts_per_page,
        // 'paged' => $paged
    );
    $html = '';
    $posts = new WP_Query($args);
    if( $posts->have_posts() ):
        while($posts->have_posts()):$posts->the_post();
            $html .= '<h3>'.get_the_title().'</h3>';
        endwhile;
    else:
        $html = '<p>No result found</p>';
    endif;
    $total_pages = $posts->max_num_pages;
    // echo $html;
    echo json_encode( array('html' => $html, 'totol_page'=> $total_pages) );
    die;

}