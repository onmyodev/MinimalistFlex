<?php
if ( !defined( 'WPINC' ) ) {
    die;
}

function minimalistflex_load_textdomain() {
	load_theme_textdomain( 'minimalistflex', get_template_directory() . '/languages' );
}

add_action( 'init', 'minimalistflex_load_textdomain' );

require_once 'includes/customizer.php';

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
	if ( !(function_exists( 'classicpress_version' ) && version_compare( classicpress_version(), '2.0.0', '>=' )) ) {
		add_theme_support( 'html5', Array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	}
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
	add_theme_support( 'customize-selective-refresh-widgets' );
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

function minimalistflex_enqueue_preview_files() {
	wp_enqueue_script( 'minimalistflex-preview-script', get_template_directory_uri() . '/js/preview.js', array('jquery', 'customize-preview'), null, true);
}

add_action( 'customize_preview_init', 'minimalistflex_enqueue_preview_files' );

function minimalistflex_enqueue_customizer_files() {
	wp_enqueue_script( 'minimalistflex-customizer-script', get_template_directory_uri() . '/js/customizer.js', array('jquery', 'customize-controls'), null, true);
}

add_action( 'customize_controls_enqueue_scripts', 'minimalistflex_enqueue_customizer_files' );

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
	require_once 'includes/color-definitions.php';
	require_once 'includes/colors.php';
	require_once 'includes/languages.php';
}

add_action( 'wp_footer', 'minimalistflex_dynamic_css' );

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

function minimalistflex_render_color_css($colors) { ?>
	:root {
    --minimalistflex-header: <?php
    $header_textcolor = get_header_textcolor();
    if ( preg_match( '/#/', $header_textcolor ) ) {
        echo esc_html( $header_textcolor );
    } else {
        echo esc_html( '#' . $header_textcolor );
    }
    ?>;
    <?php $color_keys = array_keys( $colors ); ?>
    <?php foreach( $color_keys as $color_key ): ?>
    --minimalistflex-<?php echo esc_html( $color_key ) ?>: <?php echo esc_html( get_theme_mod( 'minimalistflex_color_' . $color_key, $colors[$color_key] ) ); ?>;
    <?php endforeach; ?>
    --minimalistflex-max-height: <?php
        if ( get_theme_mod( 'minimalistflex_interface_thumbnail_height', 'flexible' ) === 'fixed' ) {
            echo esc_html( get_theme_mod( 'minimalistflex_interface_thumbnail_height_px', 300 ) ) . 'px;';
        } else {
            echo esc_html( 'auto;' );
        }
    ?>
    <?php if ( get_theme_mod( 'minimalistflex_color_disable_shadow', 'no' ) === 'yes' ): ?>
    --minimalistflex-shadow: transparent;
    --minimalistflex-shadow-light: transparent;
    <?php else: ?>
    --minimalistflex-shadow: rgba(0, 0, 0, 0.19);
    --minimalistflex-shadow-light: rgba(0, 0, 0, 0.05);
    <?php endif; ?>
	}
<?php }

function minimalistflex_ensure_hashtag_color( $color ) {
	if ( preg_match( '/#/', $color ) ) {
		return esc_html( $color );
	} else {
		return esc_html( '#' . $color );
	}
}

function minimalistflex_render_color_single( $color, $color_key ) {
	?>
<style id="minimalistflex-color-<?php echo esc_attr( $color_key ); ?>">
	:root {
		--minimalistflex-<?php echo esc_attr( $color_key ); ?>: <?php echo esc_html( $color ); ?>;
	}
</style>
	<?php
}

function minimalistflex_is_background_image_present() {
	return !empty( get_background_image() );
}

function minimalistflex_is_thumbnail_fixed() {
	return get_theme_mod( 'minimalistflex_interface_thumbnail_height', 'auto' ) === 'fixed';
}