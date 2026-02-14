<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="minimalistflex-home">
        <?php get_template_part( 'templates/loop' ); ?>
    </div>
    <?php the_posts_pagination(); ?>
<?php endif; ?>

<?php get_footer(); ?>
