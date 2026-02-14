<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php get_header(); ?>

<?php if ( have_posts() ) :
        the_post();
        $mf_id = get_the_ID();
    ?>
    <div <?php post_class( "singular" ) ?>>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="singular-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
        <div class="singular-main">
            <h1 class="panel-title"><?php the_title(); ?></h1>
            <div class="panel-main">
                <?php the_content(); ?>
                <?php wp_link_pages( Array(
                    'before' => '<p class="panel post-nav-links"><span class="post-nav-links-indicator">' . __('Pages: ', 'minimalistflex') . '</span>'
                ) ); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>