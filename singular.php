<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php
$mf_default_images = explode( ',', get_theme_mod( 'minimalistflex_default_featured_images' ));
$mf_default_image_location = get_theme_mod( 'minimalistflex_default_featured_images_location', 'archive' );
?>

<?php get_header(); ?>

<?php if ( have_posts() ) :
        the_post();
        $mf_id = get_the_author_meta( 'ID' );
    ?>
    <div <?php post_class( "singular" ) ?>>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="singular-image">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php elseif ( ( $mf_default_images[0] <> '' || minimalistflex_get_first_image() ) && $mf_default_image_location <> 'no' && $mf_default_image_location <> 'archive' ): ?>
            <?php if ( get_theme_mod( 'minimalistflex_default_featured_images_first_image', 'yes' ) === 'yes' && minimalistflex_get_first_image() ): ?>
                <?php $mf_imgsrc = minimalistflex_get_first_image(); ?>
            <?php else: ?>
                <?php
                    $mf_key = minimalistflex_get_seconds() % count($mf_default_images);
                    $mf_imgsrc = $mf_default_images[$mf_key];
                ?>
            <?php endif; ?>
            <div class="singular-image">
                <img src="<?php echo esc_url( $mf_imgsrc ) ?>" aria-label="<?php
                    printf(
                        /* translators: %s: Title of the post. */
                        esc_attr__( 'The thumbnail image for %s.', 'minimalistflex' ),
                        esc_attr( get_the_title() )
                    )
                ?>">
            </div>
        <?php endif; ?>
        <div class="singular-main">
            <div class="singular-post">
                <h1 class="panel-title"><?php the_title(); ?></h1>
                <?php get_template_part( 'templates/publisher' ) ?>
                <div class="panel-main">
                    <?php the_content(); ?>
                    <?php wp_link_pages( Array(
                        'before' => '<p class="panel post-nav-links"><span class="post-nav-links-indicator">' . __( 'Pages: ', 'minimalistflex' ) . '</span>'
                    ) ); ?>
                </div>
            </div>
            <?php get_sidebar( 'below-content' ) ?>
            <div class="singular-card">
                <?php get_template_part( 'templates/author' ) ?>
                <?php get_template_part( 'templates/metadata' ) ?>
            </div>
        </div>
        <?php if ( comments_open() || get_comments_number() ) :
	        comments_template();
        else: ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'minimalistflex' ); ?></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php get_template_part( 'templates/empty' ); ?>
<?php endif; ?>

<?php get_footer(); ?>