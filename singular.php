<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php get_header(); ?>

<?php if ( have_posts() ) :
        the_post();
        $mf_id = get_the_author_meta( 'ID' );
    ?>
    <?php $format = get_post_format() ? get_post_format() : 'standard'; ?>
    <?php $template_name = minimalistflex_get_template_name( $format ); ?>
    <?php get_template_part( 'templates/formats/' . $template_name ); ?>
<?php else: ?>
    <?php get_template_part( 'templates/empty' ); ?>
<?php endif; ?>

<?php if ( WP_DEBUG && user_can( get_current_user_id(), 'edit_theme_options' ) && get_theme_mod( 'minimalistflex_admin_warning', 'no' ) === 'yes' ): ?>
    <div class="debug warning"><p>Post Format: <?php echo get_post_format(); ?></p></div>
<?php endif; ?>

<?php get_footer(); ?>