<?php
if ( !defined( 'WPINC' ) ) {
    die;
}

function minimalistflex_add_supports() {
	add_theme_support( 'custom-background', Array(
		'default-position-x' => 'center',
		'default-position-y' => 'center',
		'default-size' => 'cover',
		'default-repeat' => 'no-repeat',
		'default-attachment' => 'fixed'
	) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( "align-wide" );
	add_theme_support( "post-thumbnails" );
	add_theme_support( 'html5', Array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', Array(
		'width' => '80',
		'height' => '80'
	) );

	add_theme_support( 'custom-header', Array(
		'default-text-color' => '#000000',
		'default-image' => get_template_directory_uri() . '/defaults/header.png',
		'flex-width' => true,
		'width' => '1920',
		'flex-height' => true,
		'height' => '300'
	) );
	register_default_headers( Array(
		'abstract' => Array(
			'url' => get_template_directory_uri() . '/defaults/header.png',
			'thumbnail_url' => get_template_directory_uri() . '/defaults/header.png',
			'description' => esc_html__( 'An abstract default header image.', 'minimalistflex' )
		),
		'lines' => Array(
			'url' => get_template_directory_uri() . '/defaults/header2.png',
			'thumbnail_url' => get_template_directory_uri() . '/defaults/header2.png',
			'description' => esc_html__( 'A default header image that contains three lines.', 'minimalistflex' )
		)
	) );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor.css' );

	$content_width = '100%';
}
add_action( 'after_setup_theme', 'minimalistflex_add_supports' );

function minimalistflex_enqueue_files() {
    wp_enqueue_script( 'comment-reply' );
    wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'dashicons' );
    wp_enqueue_script( 'minimalistflex-script', get_template_directory_uri() . '/js/menu.js', array('jquery'), null, true);
	if ( get_theme_mod( 'minimalistflex_interface_autoh2label', 'no' ) == 'yes' ) {
		wp_enqueue_style( 'minimalistflex-autoh2label-style', get_template_directory_uri() . '/css/autoh2label.css' );
	}
}

add_action( 'wp_head', 'minimalistflex_enqueue_files' );

function minimalistflex_widgets_init() {
	register_sidebar( array(
		'name'          => _x( 'Main Sidebar', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'main-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => _x( 'Above Content', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'above-content',
		'description'   => __( 'Widgets in this area will be shown above the main content.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget above-content-widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title above-content-widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => _x( 'Below Content', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'below-content',
		'description'   => __( 'Widgets in this area will be shown below the main content.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget below-content-widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title below-content-widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
		'name'          => _x( 'Footer', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'footer',
		'description'   => __( 'Widgets in this area will be shown in the footer. Always shows.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget footer-widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title footer-widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => _x( 'Footer 2', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'footer-2',
		'description'   => __( 'Widgets in this area will be shown in the footer to construct a multi column footer. Only shows when the footer is set to display it. Also twice as wide as other footer widget areas.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget footer-2-widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title footer-2-widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => _x( 'Footer 3', 'sidebar name' , 'minimalistflex' ),
		'id'            => 'footer-3',
		'description'   => __( 'Widgets in this area will be shown in the footer to construct a multi column footer. Only shows when the footer is set to display it.', 'minimalistflex' ),
		'before_widget' => '<li id="%1$s" class="panel widget footer-3-widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="panel-title widget-title footer-3-widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'minimalistflex_widgets_init' );

function minimalistflex_register_menus() {
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu', 'minimalistflex' ),
        )
    );
}
add_action( 'init', 'minimalistflex_register_menus' );

function minimalistflex_dynamic_css() {
	require_once 'includes/colors.php';
	require_once 'includes/languages.php';
}

add_action( 'wp_footer', 'minimalistflex_dynamic_css' );

load_theme_textdomain( 'minimalistflex', get_template_directory() . '/languages' );

require_once 'includes/customizer.php';

function minimalistflex_custom_excerpt_length() {
	return intval( get_theme_mod( 'minimalistflex_interface_excerpt', '55' ) );
}
add_filter( 'excerpt_length', 'minimalistflex_custom_excerpt_length', 999 );

function minimalistflex_get_seconds() {
	return strtotime( get_the_date( 'Y-m-d H:i:s' ) );
}

function minimalistflex_get_first_image( $size = 'large' ) {
	global $post;
	$allimages = get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
	foreach ( $allimages as $img ) {
		$img_src = wp_get_attachment_image_src( $img->ID, $size );
		return $img_src[0];
	}
	return false;
}