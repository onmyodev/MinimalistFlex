<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'loading' ) ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>

<?php

if( is_home() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_home_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_home_header', 'yes' );
    $mf_type = 'home';
} elseif ( is_front_page() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_front_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_front_header', 'yes' );
    $mf_type = 'front';
} elseif ( is_author() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_author_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_author_header', 'yes' );
    $mf_type = 'author';
} elseif ( is_archive() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_archive_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_archive_header', 'yes' );
    $mf_type = 'archive';
} elseif ( is_single() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_singular_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_singular_header', 'yes' );
    $mf_type = 'singular';
} elseif ( is_page() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_page_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_page_header', 'yes' );
    $mf_type = 'page';
} elseif ( is_search() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_search_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_search_header', 'yes' );
    $mf_type = 'search';
} elseif ( is_404() ) {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_error_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_error_header', 'yes' );
    $mf_type = 'error';
} else {
    $mf_sidebar = get_theme_mod( 'minimalistflex_layout_default_sidebar', 'right' );
    $mf_header = get_theme_mod( 'minimalistflex_layout_default_header', 'yes' );
    $mf_type = 'default';
}

$mf_link = get_theme_mod( 'minimalistflex_header_link' );
$mf_label = get_theme_mod( 'minimalistflex_header_label' );

?>

<a class="screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to main content', 'minimalistflex' ) ?></a>

<?php if( get_header_image() && $mf_header === 'yes' ): ?>
    <header class="minimalistflex-header-image">
        <?php if ( strlen( $mf_link ) ): ?>
            <a href="<?php echo esc_url( $mf_link ) ?>" aria-label="<?php
                    if ( strlen( $mf_label ) ) {
                        echo esc_attr( $mf_label );
                    } else {
                        esc_attr_e( 'The header image link.', 'minimalistflex' );
                    }
                ?>">
        <?php endif; ?>
            <img src="<?php header_image(); ?>" aria-label="<?php
                if ( strlen( $mf_label ) ) {
                    printf(
                        /* translators: %s: The label of the header image link. */
                        esc_attr__( 'The image of the header image link to "%s".', 'minimalistflex' ),
                        esc_attr( $mf_label )
                    );
                } else {
                    esc_attr_e( 'The header image.', 'minimalistflex' );
                }
            ?>">
        <?php if ( strlen( $mf_link ) ): ?>
            </a>
        <?php endif; ?>
    </header>
<?php endif; ?>

<header class="minimalistflex-header">
    <?php if ( has_custom_logo() ): ?>
        <?php echo wp_kses_post( get_custom_logo() ) ?>
    <?php endif; ?>
    <?php if ( display_header_text() ): ?>
        <div class="blog-title">
            <a href="<?php echo esc_url( home_url() ); ?>" class="blog-title-link"><?php echo wp_kses_data( get_bloginfo( 'name' ) ) ?></a>
        </div>
    <?php endif; ?>
    <div class="spacer"></div>
    <a id="minimalistflex-menu-focus-hack-2" href="#minimalistflex-menu-focus-hack-2" aria-label="<?php esc_attr_e( 'This element sends you to the last menu item.', 'minimalistflex' ) ?>"></a>
    <?php if ( has_nav_menu( 'main-menu' ) ): ?>
        <button id="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation dropdown', 'minimalistflex' ) ?>">
            <i id="menu-toggle-icon"></i>
        </button>
        <nav class="minimalistflex-menu">
            <?php if ( has_nav_menu( 'main-menu' ) ): ?>
                <div id="minimalistflex-menu-nav-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
                    <a id="minimalistflex-menu-focus-hack" href="#minimalistflex-menu-focus-hack" aria-label="<?php esc_attr_e( 'This element sends you back to the close menu button.', 'minimalistflex' ) ?>"></a>
                </div>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</header>

<?php if ( has_nav_menu( 'secondary-menu' ) || get_theme_mod( 'minimalistflex_social_links_enabled', 'no' ) === 'yes' ): ?>
    <nav class="minimalistflex-secondary-menu">
        <div class="minimalistflex-secondary-menu-container">
            <?php if ( has_nav_menu( 'secondary-menu' ) ): ?>
                <?php wp_nav_menu( array( 'theme_location' => 'secondary-menu' ) ); ?>
            <?php endif;?>
        </div>
        <div class="spacer"></div>
        <?php if ( get_theme_mod( 'minimalistflex_social_links_enabled', 'no' ) === 'yes' ): ?>
            <div class="minimalistflex-social-links">
                <?php require_once 'includes/social-definitions.php'; ?>
                <?php foreach ( $social_platforms as $key => $label ): ?>
                    <?php $link = get_theme_mod( 'minimalistflex_' . $key . '_link' ); ?>
                    <?php if ( strlen( $link ) ): ?>
                        <a href="<?php echo esc_url( $link ) ?>" class="minimalistflex-social-link minimalistflex-social-link-<?php echo esc_attr( $key ) ?>" aria-label="<?php
                            printf( esc_attr__( 'The link to the %s profile.', 'minimalistflex' ), esc_attr( $label ) );
                        ?>">
                            <?php if ( $key === 'custom' ): ?>
                                <?php $image_id = get_theme_mod( 'minimalistflex_custom_social_icon' ); ?>
                                <?php if ( $image_id ): ?>
                                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                                <?php else: ?>
                                    <i class="ri-fw ri-link" aria-hidden="true"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="ri-fw ri-<?php echo esc_attr( $social_platforms_icon_name[$key] ) ?>"></i>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php foreach ( $social_platforms_special as $key => $label ): ?>
                    <?php $qr = get_theme_mod( 'minimalistflex_' . $key . '_qr' ); ?>
                    <?php if ( $qr ): ?>
                        <a class="minimalistflex-social-link minimalistflex-social-link-hoverable minimalistflex-social-link-<?php echo esc_attr( $key ) ?>" aria-label="<?php
                            printf( esc_attr__( 'The QR code for the %s profile.', 'minimalistflex' ), esc_attr( $label ) );
                        ?>" href="javascript:void(0)" tabindex="0">
                            <i class="ri-fw ri-<?php echo esc_attr( $social_platforms_icon_name[$key] ) ?>"></i>
                            <span class="minimalistflex-social-link-qr">
                                <?php echo wp_get_attachment_image($qr, 'full'); ?>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php $custom_link = get_theme_mod( 'minimalistflex_custom_social_link' ); ?>
                <?php if ( strlen( $custom_link ) ): ?>
                    <a href="<?php echo esc_url( $custom_link ) ?>" class="minimalistflex-social-link minimalistflex-social-link-custom" aria-label="<?php
                        esc_attr_e( 'The link to the custom social profile.', 'minimalistflex' );
                    ?>">
                        <?php $image_id = get_theme_mod( 'minimalistflex_custom_social_icon' ); ?>
                        <?php if ( $image_id ): ?>
                            <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                        <?php else: ?>
                            <i class="ri-fw ri-link" aria-hidden="true"></i>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                <?php $rss_enaled = get_theme_mod( 'minimalistflex_rss_enabled', 'no' ); ?>
                <?php if ( $rss_enaled === 'yes' ): ?>
                    <a href="<?php echo esc_url( get_feed_link() ) ?>" class="minimalistflex-social-link minimalistflex-social-link-rss" aria-label="<?php
                        esc_attr_e( 'The link to the RSS feed.', 'minimalistflex' );
                    ?>">
                        <i class="ri-fw ri-rss-fill" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </nav>
<?php endif; ?>

<main class="minimalistflex-master <?php echo 'minimalistflex-sidebar-layout-' . esc_attr( $mf_sidebar ) . ' minimalistflex-master-' . esc_attr( $mf_type ) ?> <?php if ( get_theme_mod( 'minimalistflex_interface_autoh2label_underline', '' ) === 'yes' ): ?>minimalistflex-autoh2label-underline<?php endif; ?>">

<article class="minimalistflex-content" id="main-content">

<?php get_sidebar( 'above-content' ); ?>
