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
    <?php $supported_formats = get_theme_support( 'post-formats' ); ?>
    <?php $format = get_post_format() ? get_post_format() : 'standard'; ?>
    <?php if ( minimalistflex_is_beta_feature_enabled() && in_array( $format, $supported_formats[0] ) ): ?>
        <?php get_template_part( 'templates/formats/' . $format ); ?>
    <?php else: ?>
        <?php get_template_part( 'templates/formats/standard' ); ?>
    <?php endif; ?>
<?php else: ?>
    <?php get_template_part( 'templates/empty' ); ?>
<?php endif; ?>

<?php if ( user_can( get_current_user_id(), 'edit_theme_options' ) && get_theme_mod( 'minimalistflex_admin_warning', 'no' ) === 'yes' ): ?>
    <div class="debug warning"><p>Post Format: <?php echo get_post_format(); ?></p></div>
<?php endif; ?>

<?php get_footer(); ?>