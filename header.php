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
        <h1 class="blog-title">
            <a href="<?php echo esc_url( home_url() ); ?>" class="blog-title-link"><?php echo wp_kses_data( get_bloginfo( 'name' ) ) ?></a>
        </h1>
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

<?php if ( has_nav_menu( 'secondary-menu' ) ): ?>
    <nav class="minimalistflex-secondary-menu">
        <?php wp_nav_menu( array( 'theme_location' => 'secondary-menu' ) ); ?>
    </nav>
<?php endif; ?>

<main class="minimalistflex-master <?php echo 'minimalistflex-sidebar-layout-' . esc_attr( $mf_sidebar ) . ' minimalistflex-master-' . esc_attr( $mf_type ) ?>">

<article class="minimalistflex-content" id="main-content">

<?php get_sidebar( 'above-content' ); ?>
