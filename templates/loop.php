<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php
$mf_default_images = explode( ',', get_theme_mod( 'minimalistflex_default_featured_images' ));
$mf_default_image_location = get_theme_mod( 'minimalistflex_default_featured_images_location', 'archive' );
?>

<?php while ( have_posts() ) :
        the_post();
        $mf_id = get_the_author_meta('ID');
        $mf_post_id = get_the_ID();
        $mf_excerpt_mode = get_theme_mod( 'minimalistflex_layout_home_excerpt_mode', 'excerpt' );
    ?>
    <div <?php post_class("panel"); ?>>
        <?php if ( has_post_thumbnail() ): ?>
            <a class="panel-image" href="<?php the_permalink() ?>" aria-label="<?php
            printf(
                /* translators: %s: Post title associated with the thumbnail image. */
                esc_attr__( 'Thumbnail image of %s. Also a link that navigates to it.', 'minimalistflex' ),
                esc_attr( get_the_title() )
            ) ?>">
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        <?php elseif ( ( $mf_default_images[0] <> '' || minimalistflex_get_first_image() ) && $mf_default_image_location <> 'no' && $mf_default_image_location <> 'single' ): ?>
            <?php if ( get_theme_mod( 'minimalistflex_default_featured_images_first_image', 'yes' ) === 'yes' && minimalistflex_get_first_image() ): ?>
                <?php $mf_imgsrc = minimalistflex_get_first_image(); ?>
            <?php else: ?>
                <?php
                    $mf_key = minimalistflex_get_seconds() % count($mf_default_images);
                    $mf_imgsrc = $mf_default_images[$mf_key];
                ?>
            <?php endif; ?>
            <a class="panel-image" href="<?php the_permalink() ?>" aria-label="<?php
            printf(
                /* translators: %s: Post title associated with the thumbnail image. */
                esc_attr__( 'The thhumbnail image link for %s', 'minimalistflex' ),
                esc_attr( get_the_title() )
            ) ?>">
                <img src="<?php echo esc_url( $mf_imgsrc );?>" aria-label="<?php
                    printf(
                        /* translators: %s: Title of the post. */
                        esc_attr__( 'The thumbnail image for %s.', 'minimalistflex' ),
                        esc_attr( get_the_title() )
                    )
                ?>">
            </a>
        <?php endif; ?>
        <div class="panel-content">
            <h2 class="panel-title"><?php the_title(); ?></h2>
            <div class="panel-main">
                <?php if ( $mf_excerpt_mode === 'excerpt' ): ?>
                    <?php the_excerpt(); ?>
                <?php else: ?>
                    <?php the_content(); ?>
                <?php endif; ?>
            </div>
            <?php wp_link_pages( Array(
                'before' => '<div class="panel post-nav-links"><span class="post-nav-links-indicator">' . esc_html__('Pages: ', 'minimalistflex') . '</span>',
                'after' => '</div>'
            ) ); ?>
            <div class="panel-meta">
                <?php if ( get_theme_mod( 'minimalistflex_interface_publisher', 'yes' ) === 'yes' ): ?>
                    <a class="panel-author" href="<?php echo esc_url( get_author_posts_url($mf_id) ) ?>">
                        <span aria-hidden="true"><?php echo get_avatar( $mf_id, 80 ) ?></span>
                        <span><?php the_author() ?></span>
                    </a>
                <?php endif; ?>
                <?php $mf_datemode = get_theme_mod( 'minimalistflex_interface_date', 'modify' ); ?>
                <?php if ( $mf_datemode <> 'no' ): ?>
                    <div class="panel-author">
                        <?php if ( $mf_datemode === 'publish' || get_the_modified_date() <> get_the_date() ): ?>
                            <?php printf(
                                /* translators: %s: Post publish time. */
                                esc_html__( 'Published on %s', 'minimalistflex' ),
                                esc_html( get_the_date() )
                            ) ?>
                        <?php else: ?>
                            <?php printf(
                                /* translators: %s: Post last modified time. */
                                esc_html__( 'Last modified on %s', 'minimalistflex' ),
                                esc_html( get_the_modified_date() )
                            ) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ( get_theme_mod( 'minimalistflex_interface_comment_count', 'yes' ) === 'yes' ): ?>
                <div class="panel-comment-count">
                    <a href="<?php echo esc_url( get_comments_link() ) ?>">
                        <?php
                            printf(
                                /* translators: %d: Number of comments. */
                                esc_html( _nx(
                                    '%d Comment',
                                    '%d Comments',
                                    get_comments_number(),
                                    'comment count',
                                    'minimalistflex'
                                ) ),
                                esc_html( number_format_i18n( get_comments_number() ) )
                            );
                        ?>
                    </a>
                </div>
            <?php endif; ?>
            </div>
            <div class="panel-link-container">
                <a class="panel panel-link" href="<?php the_permalink(); ?>" aria-label="<?php
                        printf(
                            /* translators: %s: Post title. */
                            esc_attr__( 'Read more of %s', 'minimalistflex' ),
                            esc_attr( get_the_title() )
                        )
                    ?>">
                    <?php echo esc_html( get_theme_mod( 'minimalistflex_interface_readlink', __( 'Read More', 'minimalistflex' ) ) ); ?>
                </a>
            </div>
        </div>
    </div>
<?php endwhile; ?>