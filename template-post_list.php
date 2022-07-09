<?php
/**
 *  Template Name:Post List
 */

get_header();
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

    /**
     * Pagination with page numbers with WP_Query
     */

    // next_posts_link( '&larr; Older posts', $posts->max_num_pages);
    // previous_posts_link( 'Newer posts &rarr;' );

    /**
     * Pagination with page numbers with query_posts()
     */

    $GLOBALS['wp_query']->max_num_pages = $posts->max_num_pages;
    
    the_posts_pagination( array( 'mid_size'  => 2 ) );
    echo '</div>';

get_footer();