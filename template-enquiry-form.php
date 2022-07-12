<?php
/**
 * Template Name: Custom Enquriy form
 */

get_header();
?>
<div class="form">
    <form method="post" name="enquiry_form">
        <input type="text" name="fname" placeholder="first name">
        <input type="text" name="lname" placeholder="last name">
        <input type="text" name="property" placeholder="propery">
        <textarea name="message" placeholder="message"></textarea>
        
        <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('enquiry_form_nonce') ?>">
        <input type="hidden" name="action" value="enquiry_form">
        <input type="submit" value="submit" name="submit">
    </form>
</div>

<?php
get_footer();