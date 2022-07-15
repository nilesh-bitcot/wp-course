<?php
/**
 * The single Property post.<br>
 * This file works as display full post content page and its comments.
 * 
 * @package bootstrap-basic4
 */
get_header();

?>

<main id="main" class="col-md-12 site-main" role="main">
    <div style="display:flex;padding:20px;text-align:center;background:#d3d3d3">
        <h1>Properties</h1>
    </div>
    <div  style="display:flex">
    <?php
    if (have_posts()) {
        $Bsb4Design = new \BootstrapBasic4\Bsb4Design();
        while (have_posts()) {
            the_post();
            ?>
            <card id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="width:33%;">
                <div class="entry-thumbnail">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <h1 class="entry-title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h1>

                <div class="entry-meta">
                    <?php echo '<span>Area: <strong>' . get_post_meta(get_the_ID(), 'prop_area', true) . '</strong></span>'; ?> 
                    <?php echo '<span>Cost: <strong>' . get_post_meta(get_the_ID(), 'prop_cost', true) . '</strong></span>'; ?> 
                    <?php echo '<span>Loan: <strong>' . get_post_meta(get_the_ID(), 'prop_loan', true) . '</strong></span>'; ?> 
                </div><!-- .entry-meta -->                    
            </card><!-- #post-## -->

            <?php
            // $Bsb4Design->pagination();
            // echo "\n\n";

        }// endwhile;

        echo strlen('east or west nilesh is the best');
        unset($Bsb4Design);
    } else {
        get_template_part('template-parts/section', 'no-results');
    }// endif;
    ?> 
    </div>
</main>




<?php
get_footer();