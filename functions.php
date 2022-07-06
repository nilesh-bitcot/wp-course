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