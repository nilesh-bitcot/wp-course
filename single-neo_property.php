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
    <?php
    if (have_posts()) {
        $Bsb4Design = new \BootstrapBasic4\Bsb4Design();
        while (have_posts()) {
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <?php echo '<span>Area: <strong>' . get_post_meta(get_the_ID(), 'prop_area', true) . '</strong></span>'; ?> 
                        <?php echo '<span>Cost: <strong>' . get_post_meta(get_the_ID(), 'prop_cost', true) . '</strong></span>'; ?> 
                        <?php echo '<span>Loan: <strong>' . get_post_meta(get_the_ID(), 'prop_loan', true) . '</strong></span>'; ?> 
                    </div><!-- .entry-meta -->
                    
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content($Bsb4Design->continueReading(true)); ?> 
                    <div class="clearfix"></div>
                    <?php 
                    /**
                     * This wp_link_pages option adapt to use bootstrap pagination style.
                     */
                    wp_link_pages([
                        'before' => '<div class="page-links">' . __('Pages:', 'bootstrap-basic4') . ' <ul class="pagination">',
                        'after'  => '</ul></div>',
                        'separator' => ''
                    ]);
                    ?> 
                </div><!-- .entry-content -->

                <footer class="entry-meta">
                    <h2>Like this propery contact us by filling this form</h2>
                    <div class="form">
                        <form method="post" name="enquiry_form">
                            <input type="text" name="fname" placeholder="first name">
                            <input type="text" name="lname" placeholder="last name">
                            <input type="text" name="property" placeholder="Title">
                            
                            <textarea name="message" placeholder="message"></textarea>
                            
                            <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('enquiry_form_nonce') ?>">
                            <input type="hidden" name="property_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="action" value="property_enquiry_form">
                            <input type="submit" value="submit" name="submit">
                        </form>
                    </div>
                </footer><!-- .entry-meta -->
            </article><!-- #post-## -->

            <?php
            // $Bsb4Design->pagination();
            // echo "\n\n";

        }// endwhile;

        
        unset($Bsb4Design);
    } else {
        get_template_part('template-parts/section', 'no-results');
    }// endif;
    ?> 
</main>




<?php
get_footer();