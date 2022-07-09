<?php
/**
 *  Template Name:Post List
 */

get_header();
    /*
    $paged = get_query_var('paged')? get_query_var('paged') : 1;

    echo '<h1>';the_title();echo '</h1>';
    echo '<div style="clear:both;">';

    $args = array(
        'post_status' => 'publish',
        'post_type' => 'post',
        'posts_per_page' => 3,
        'paged' => $paged
    );

    $posts = new WP_Query( $args );

    if($posts->post_count > 0){
        foreach($posts->posts as $post){
            echo '<h4>'.get_the_title($post->ID).'</h4>';
            echo '<br>';
        }
    }
    */

    /**
     * Pagination with page numbers with WP_Query
     */

    // next_posts_link( '&larr; Older posts', $posts->max_num_pages);
    // previous_posts_link( 'Newer posts &rarr;' );

    /**
     * Pagination with page numbers with query_posts()
     */

    /*
    $GLOBALS['wp_query']->max_num_pages = $posts->max_num_pages;
    
    the_posts_pagination( array( 'mid_size'  => 2 ) );
    echo '</div>';
    */

    ?>
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
    <div style="display:block;width:100%;float:left;" id="post_list_wrapper"></div>
    <div style="display:block;width:100%;float:left;" id="list_pagination"></div>
    <?php

get_footer();