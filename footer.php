<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

</article>

<?php

if( is_home() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_home_sidebar', 'right' );
} elseif ( is_front_page() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_front_sidebar', 'right' );
} elseif ( is_search() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_search_sidebar', 'right' );
} elseif ( is_archive() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_archive_sidebar', 'right' );
} elseif( is_author() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_author_sidebar', 'right' );
} elseif( is_single() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_singular_sidebar', 'right' );
} elseif( is_page() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_page_sidebar', 'right' );
} else {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_search_sidebar', 'right' );
}

?>

<?php if ( $mf_sidebar <> 'no' ): ?>
    <aside class="minimalistflex-sidebar">
        <?php get_sidebar(); ?>
    </aside>
<?php endif; ?>

</main>

<ul class="minimalistflex-controls">
    <?php if ( get_theme_mod( 'minimalistflex_interface_scroll_top', 'yes' ) === 'yes' ): ?>
        <li><a href="#" aria-label="<?php esc_attr_e( 'Back to top', 'minimalistflex' ) ?>"><i class="dashicons dashicons-arrow-up-alt"></i></a></li>
    <?php endif; ?>
</ul>

<footer class="minimalistflex-footer">
    <div class="minimalistflex-footer-widgets-container">
        <?php $mf_sidebars = get_theme_mod( 'minimalistflex_footer_widget_layout', 'one' ); ?>
        <?php
            get_sidebar( 'footer' );
            if ( $mf_sidebars === 'two' || $mf_sidebars === 'three' ) {
                get_sidebar( 'footer-2' );
            }
            if ( $mf_sidebars === 'three' ) {
                get_sidebar( 'footer-3' );
            }
        ?>
    </div>
    <div class="minimalistflex-footer-credits">
        <?php if ( display_header_text() ): ?>
            <div class="footer-blog-description">
                <div class="footer-blog-title">
                    <a href="<?php echo esc_url( home_url() ); ?>" class="blog-title-link"><?php echo wp_kses_data( get_bloginfo( 'name' ) ) ?></a>
                </div>
                <?php if( get_bloginfo( 'description' ) ): ?>
                    <div class="footer-blog-tagline">
                        <?php echo wp_kses_data( get_bloginfo( 'description' ) ) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="footer-credits">
            <?php $mf_footer_type = get_theme_mod( 'minimalistflex_footer_type', 'both' ); ?>
            <?php if ( $mf_footer_type === 'both' || $mf_footer_type === 'custom' ): ?>
                <?php echo wp_kses_data( get_theme_mod( 'minimalistflex_footer_text' ) ) ?>
            <?php endif; ?>
            <?php if ( $mf_footer_type === 'both' || $mf_footer_type === 'minimalistflex' ): ?>
                <?php
                    printf(
                        /* translators: %s: Link to theme author website. */
                        wp_kses_data( __( 'Theme <a href="%s">MinimalistFlex</a>.', 'minimalistflex' ) ),
                        esc_url( 'https://onmyodev.com/' )
                    )
                ?>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>