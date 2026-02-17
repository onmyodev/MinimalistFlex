<?php
$mf_default_images = explode( ',', get_theme_mod( 'minimalistflex_default_featured_images' ));
$mf_default_image_location = get_theme_mod( 'minimalistflex_default_featured_images_location', 'archive' );
$mf_id = get_the_author_meta( 'ID' );
?>

<div <?php post_class( "quote" ) ?>>
    <div class="singular-main quote-main">
        <div class="quote-content">
            <h1 class="quote-title"><?php the_title(); ?></h1>
            <p class="quote-datetime"><?php get_template_part( 'templates/datetime' ) ?></p>
            <?php the_content(); ?>
            <?php wp_link_pages( Array(
                'before' => '<p class="panel post-nav-links"><span class="post-nav-links-indicator">' . __( 'Pages: ', 'minimalistflex' ) . '</span>'
            ) ); ?>
        </div>
        <?php get_sidebar( 'below-content' ) ?>
        <div class="quote-adjacent-posts singular-adjacent-posts">
            <div class="singular-adjacent-post singular-previous-post panel">
                <h3><?php esc_html_e( 'Previous Post', 'minimalistflex' ) ?></h3>
                <?php $mf_previous_post = get_previous_post(); ?>
                    <?php if ( $mf_previous_post ): ?>
                        <a class="singular-adjacent-post-link" href="<?php echo esc_url( get_permalink( $mf_previous_post ) ); ?>"><?php echo wp_kses_post( get_the_title( $mf_previous_post ) ); ?>&nbsp;</a>
                    <?php else: ?>
                        <span class="singular-adjacent-post-link"><?php esc_html_e( 'No previous posts', 'minimalistflex' ); ?></span>
                <?php endif; ?>
            </div>
            <div class="singular-adjacent-post singular-next-post panel">
                <h3><?php esc_html_e( 'Next Post', 'minimalistflex' ) ?></h3>
                <?php $mf_next_post = get_next_post(); ?>
                    <?php if ( $mf_next_post ): ?>
                        <a class="singular-adjacent-post-link" href="<?php echo esc_url( get_permalink( $mf_next_post ) ); ?>"><?php echo wp_kses_post( get_the_title( $mf_next_post ) ); ?>&nbsp;</a>
                    <?php else: ?>
                        <span class="singular-adjacent-post-link"><?php esc_html_e( 'No newer posts', 'minimalistflex' ); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="quote-comments">
        <?php if ( comments_open() || get_comments_number() ) :
            comments_template();
        else: ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'minimalistflex' ); ?></p>
        <?php endif; ?>
    </div>
</div>