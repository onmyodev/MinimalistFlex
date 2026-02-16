<?php
if ( !defined( 'WPINC' ) ) {
    die;
}

function minimalistflex_customizer_enqueue_scripts() {
    require_once 'color-definitions.php';
    wp_enqueue_script( 'minimalistflex_color_palette', get_template_directory_uri() . '/js/color-palette.js', Array( 'jquery' ), null, true );
}

require_once 'sanitize-callbacks.php';

add_action( 'customize_controls_enqueue_scripts', 'minimalistflex_customizer_enqueue_scripts' );

function minimalistflex_social_links_register( $wp_customize ) {
    require_once 'class-description-only.php';

    // Main section.
    $wp_customize -> add_section( 'minimalistflex_social_links', Array(
        'title' => esc_html__( 'Social Links', 'minimalistflex' ),
        'description' => esc_html__( 'Add your social media links here. They will be displayed as icons in the secondary navigation menu.', 'minimalistflex' ),
        'priority' => 80,
        'capability' => 'edit_theme_options'
    ) );

    // Enabled?
    $wp_customize -> add_setting( 'minimalistflex_social_links_enabled', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'no',
        'transport' => 'refresh'
    ) );
    $wp_customize -> add_control( 'minimalistflex_social_links_enabled', Array(
        'type' => 'radio',
        'priority' => 1,
        'section' => 'minimalistflex_social_links',
        'label' => esc_html__( 'Enable Social Links', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );

    require_once 'social-definitions.php';

    foreach ( $social_platforms as $key => $label ) {
        $wp_customize -> add_setting( 'minimalistflex_' . $key . '_link', Array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw'
        ) );
        $wp_customize -> add_control( 'minimalistflex_' . $key . '_link', Array(
            'type' => 'url',
            'priority' => 10,
            'section' => 'minimalistflex_social_links',
            'label' => sprintf( esc_html__( '%s', 'minimalistflex' ), $label ),
        ) );
    }

    foreach ( $social_platforms_special as $key => $label ) {
        $wp_customize -> add_setting( 'minimalistflex_' . $key . '_qr', Array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_key'
        ) );
        $wp_customize -> add_control( new WP_Customize_Media_Control(
            $wp_customize,
            'minimalistflex_' . $key . '_qr',
            Array(
                'type' => 'media',
                'mime_type' => 'image',
                'priority' => 10,
                'section' => 'minimalistflex_social_links',
                'label' => sprintf( esc_html__( '%s', 'minimalistflex' ), $label ),
                // translators: %s: The name of the social media platform.
                'description' => sprintf( esc_html__( 'Upload the QR code image for %s.', 'minimalistflex' ), $label ),
            )
        ) );
     }

    // Custom.
    $wp_customize -> add_setting( 'minimalistflex_custom_social_link', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_custom_social_icon', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ) );
    $wp_customize -> add_control( 'minimalistflex_custom_social_link', Array(
        'type' => 'url',
        'priority' => 70,
        'section' => 'minimalistflex_social_links',
        'label' => esc_html__( 'Custom Link', 'minimalistflex' ),
        'active_callback' => 'minimalistflex_is_beta_feature_enabled'
    ) );
    $wp_customize -> add_control( new WP_Customize_Media_Control(
        $wp_customize,
        'minimalistflex_custom_social_icon',
        Array(
            'type' => 'media',
            'mime_type' => 'image',
            'priority' => 80,
            'section' => 'minimalistflex_social_links',
            'label' => esc_html__( 'Custom Icon', 'minimalistflex' ),
            'description' => esc_html__( 'Upload a custom icon for the custom link. Due to WordPress limitations you must use a plugin if you wish to use SVG.', 'minimalistflex' ),
            'active_callback' => 'minimalistflex_is_beta_feature_enabled'
        )
    ) );
}

add_action( 'customize_register', 'minimalistflex_social_links_register' );

function minimalistflex_default_featured_image_register( $wp_customize ) {
    require_once 'class-multi-image-control.php';

    $wp_customize -> add_section( 'minimalistflex_default_featured_image', Array(
        'title' => esc_html__( 'Default Featured Images', 'minimalistflex' ),
        'description' => esc_html__( 'The theme can provide the following images as a fallback when there\'s no featured image set for a post. You can also select where to display those images.', 'minimalistflex' ),
        'priority' => 50,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_default_featured_images', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_default_featured_images_location', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'archive',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_default_featured_images_first_image', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_control( new MinimalistFlex_Multi_Image_Custom_Control( $wp_customize, 'minimalistflex_default_featured_images', Array(
        'label' => esc_html__( 'Default Images', 'minimalistflex' ),
        'description' => esc_html__( 'Click on "Add Image" to add an image. Click on the image to remove it. There\'s no limit on how many images you can add.', 'minimalistflex' ),
        'priority' => 20,
        'section' => 'minimalistflex_default_featured_image',
        'suggest_label' => esc_html__( 'Suggested Images', 'minimalistflex' ),
        'suggest_description' => esc_html__( 'We have prepared some pre-built, generic purpose images for you to choose from. Click on an image will add it into the selection.', 'minimalistflex' ),
        'suggest_images' => Array( '/defaults/1.png', '/defaults/2.png', '/defaults/3.png', '/defaults/4.png', '/defaults/5.png', '/defaults/6.png' )
    ) ) );
    $wp_customize -> add_control( 'minimalistflex_default_featured_images_location', Array(
        'label' => esc_html__( 'Location', 'minimalistflex' ),
        'description' => esc_html__( 'You may decide if and where should the default image show.', 'minimalistflex' ),
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_default_featured_image',
        'choices' => Array(
            'both' => esc_html__( 'Always', 'minimalistflex' ),
            'archive' => esc_html__( 'Archive Page Only', 'minimalistflex' ),
            'single' => esc_html__( 'Single Page Only', 'minimalistflex' ),
            'no' => esc_html__( 'Never', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_default_featured_images_first_image', Array(
        'label' => esc_html__( 'Display First Image', 'minimalistflex' ),
        'description' => esc_html__( 'The theme can also retrieve the first image in a post if possible. When no image was found, the theme can fallback to the default images set below.', 'minimalistflex' ),
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_default_featured_image',
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' ),
        )
    ) );
}
add_action( 'customize_register', 'minimalistflex_default_featured_image_register' );

function minimalistflex_customize_color_register( $wp_customize ) {
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    require_once 'color-definitions.php';
    require_once 'class-color-palette-control.php';

    $wp_customize -> add_setting( 'minimalistflex_color_placeholder', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_control( new MinimalistFlex_Color_Palette_Custom_Control( $wp_customize, 'minimalistflex_color_placeholder', Array(
        'priority' => 1,
        'label' => esc_html__( 'Color Palettes', 'minimalistflex' ),
        'description' => esc_html__( 'We had prepared some fine tuned color palettes for you. Select an option and it will automatically apply the palette to your site.', 'minimalistflex' ),
        'section' => 'colors'
    ) ) );

    $color_keys = array_keys( $colors );
    foreach( $color_keys as $color_key ) {
        $wp_customize -> add_setting( 'minimalistflex_color_' . $color_key, Array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'default' => $colors[$color_key],
            'sanitize_callback' => 'minimalistflex_sanitize_color_cb'
        ) );
        $wp_customize -> add_control( new WP_Customize_Color_Control( $wp_customize, 'minimalistflex_color_' . $color_key, Array(
            'label' => $labels[$color_key],
            'description' => $desciprtions[$color_key],
            'section' => 'colors'
        ) ) );
    };
    $wp_customize -> add_setting( 'minimalistflex_color_disable_shadow', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'no',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_control( 'minimalistflex_color_disable_shadow', Array(
        'type' => 'radio',
        'label' => esc_html__( 'Disable Shadows', 'minimalistflex' ),
        'description' => esc_html__( 'This option lets you disable the shadow on the site. It should only affect the shadow created by the theme.', 'minimalistflex' ),
        'priority' => 2,
        'section' => 'colors',
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> get_control( 'background_color' ) -> description = esc_html__( 'The default background setting from the WordPress core. If set, it will blend with the content &amp; sidebar background colors set below.', 'minimalistflex' );
    $wp_customize -> get_control( 'header_textcolor' ) -> description = esc_html__( 'The default header text setting from the WordPress core. Used on the header and the toggle button.', 'minimalistflex' );

    $wp_customize->add_setting( 'minimalistflex_content_background_blend', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 50,
        'sanitize_callback' => 'minimalistflex_sanitize_percentage_cb'
    ) );
    $wp_customize->add_control( 'minimalistflex_content_background_blend', Array(
        'type' => 'number',
        'label' => esc_html__( 'Content Background Blend', 'minimalistflex' ),
        'description' => esc_html__( 'The theme will blend the background color with the background image when present. Choose how hard should the blend be.', 'minimalistflex' ),
        'priority' => 30,
        'section' => 'background_image',
        'input_attrs' => Array(
            'min' => 0,
            'max' => 100
        ),
        'active_callback' => 'minimalistflex_is_background_image_present'
    ) );
    $wp_customize->add_setting( 'minimalistflex_sidebar_background_blend', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 25,
        'sanitize_callback' => 'minimalistflex_sanitize_percentage_cb'
    ) );
    $wp_customize->add_control( 'minimalistflex_sidebar_background_blend', Array(
        'type' => 'number',
        'label' => esc_html__( 'Sidebar Background Blend', 'minimalistflex' ),
        'description' => esc_html__( 'The theme will blend the sidebar background color with the background image when present. Choose how hard should the blend be.', 'minimalistflex' ),
        'priority' => 40,
        'section' => 'background_image',
        'input_attrs' => Array(
            'min' => 0,
            'max' => 100
        ),
        'active_callback' => 'minimalistflex_is_background_image_present'
    ) );
}

function minimalistflex_customize_author_elements_register( $wp_customize ) {
    $metadatas = Array(
        'description' => esc_html__( 'Description', 'minimalistflex' ),
        'user_registered' => esc_html__( 'Registration time', 'minimalistflex' ),
        'user_url' => esc_html__( 'Website', 'minimalistflex' ),
        'user_email' => esc_html__( 'Email address', 'minimalistflex' )
    );

    $metadata_keys = array_keys( $metadatas );
    foreach( $metadata_keys as $metadata_key ) {
        $wp_customize -> add_setting( 'minimalistflex_layout_author_elements_' . $metadata_key, Array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
            'default' => 'yes',
            'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
        ) );
        if ( $metadata_key == 'description' ) {
            $wp_customize -> add_control( 'minimalistflex_layout_author_elements_' . $metadata_key, Array(
                'type' => 'radio',
                'priority' => 45,
                'capability' => 'edit_theme_options',
                'label' => $metadatas[$metadata_key],
                'section' => 'minimalistflex_layout_author',
                'choices' => Array(
                    'yes' => esc_html__( 'Display', 'minimalistflex' ),
                    'no' => esc_html__( 'Don\'t Display', 'minimalistflex' )
                )
            ) );   
        } else {
            $wp_customize -> add_control( 'minimalistflex_layout_author_elements_' . $metadata_key, Array(
                'type' => 'radio',
                'priority' => 50,
                'capability' => 'edit_theme_options',
                'label' => $metadatas[$metadata_key],
                'section' => 'minimalistflex_layout_author',
                'choices' => Array(
                    'yes' => esc_html__( 'Display', 'minimalistflex' ),
                    'no' => esc_html__( 'Don\'t Display', 'minimalistflex' )
                )
            ) );
        }
    }
}

function minimalistflex_customize_register( $wp_customize ) {
    // Start adding panels.
    $wp_customize -> add_panel( 'minimalistflex_layout', Array(
        'title' => _x( 'Layout', 'customizer panel' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may configure how different pages on your site looks like.', 'minimalistflex' ),
        'priority' => 70,
        'capability' => 'edit_theme_options'
    ) );

    // Start adding sections.
    $wp_customize -> add_section( 'minimalistflex_layout_home', Array(
        'title' => _x( 'Blog Page', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your blog page.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 10,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_front', Array(
        'title' => _x( 'Front Page', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your front page. Only takes effect when using a static front page.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 12,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_archive', Array(
        'title' => _x( 'Archives', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your archive pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 15,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_search', Array(
        'title' => _x( 'Search Results', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your search result pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 17,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_author', Array(
        'title' => _x( 'Author Pages', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your author pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 20,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_singular', Array(
        'title' => _x( 'Single Posts', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your posts.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 25,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_page', Array(
        'title' => _x( 'Pages', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of your pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 30,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_error', Array(
        'title' => _x( 'Error Pages', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the layout of error pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 35,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_layout_default', Array(
        'title' => _x( 'Default Layout', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Here you may customize the fallback layout of other pages.', 'minimalistflex' ),
        'panel' => 'minimalistflex_layout',
        'priority' => 35,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_interface', Array(
        'title' => _x( 'Interface &amp; Elements', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'You may customize your site\'s interface and the elements displayed here.', 'minimalistflex' ),
        'priority' => 71,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_footer', Array(
        'title' => _x( 'Footer', 'customizer section', 'minimalistflex' ),
        'description' => esc_html__( 'You may customize how your footer looks like here.', 'minimalistflex' ),
        'priority' => 140,
        'capability' => 'edit_theme_options'
    ) );
    $wp_customize -> add_section( 'minimalistflex_advanced', Array(
        'title' => _x( 'Advanced Settings', 'customizer section' , 'minimalistflex' ),
        'description' => esc_html__( 'Advanced settings. Should be kept default unless when developing...', 'minimalistflex' ),
        'priority' => 150,
        'capability' => 'edit_theme_options'
    ) );

    // Start adding settings.
    $wp_customize -> add_setting( 'minimalistflex_header_link', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_header_label', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_home_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_home_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_home_excerpt_mode', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'excerpt',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_home_excerpt_length', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 55,
        'sanitize_callback' => 'minimalistflex_sanitize_int_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_home_waterfall', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'no',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_front_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_front_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_archive_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_archive_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_archive_title', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_search_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_search_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_search_title', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_search_form', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_author_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_author_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_author_title', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_author_admin', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_singular_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_singular_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_page_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_error_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_error_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_error_title', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => '',
        'sanitize_callback' => 'esc_html'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_error_message', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => '',
        'sanitize_callback' => 'esc_html'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_error_form', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_default_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_default_sidebar', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'right',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_layout_page_header', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_scroll_top', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_autoh2label', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'no',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_comment_count', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_publisher', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'yes',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_date', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'modify',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_readlink', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => esc_html__( 'Read More', 'minimalistflex' ),
        'sanitize_callback' => 'esc_html'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_thumbnail_height', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 'auto',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_interface_thumbnail_height_px', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'default' => 300,
        'sanitize_callback' => 'minimalistflex_sanitize_int_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_footer_type', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'both',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_footer_text', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'sanitize_callback' => 'wp_kses_data'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_footer_widget_layout', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'one',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_admin_warning', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'no',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );
    $wp_customize -> add_setting( 'minimalistflex_beta_feature_enabled', Array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => 'no',
        'sanitize_callback' => 'minimalistflex_sanitize_radio_cb'
    ) );

    // Start binding controls (UI).
    $wp_customize -> add_control( 'minimalistflex_header_link', Array(
        'type' => 'url',
        'priority' => 50,
        'section' => 'header_image',
        'label' => esc_html__( 'Header Image Link', 'minimalistflex' ),
        'description' => esc_html__( 'You may link the header image to a URL. Leave blank if you do not want to do so.', 'minimalistflex' )
    ) );
    $wp_customize -> add_control( 'minimalistflex_header_label', Array(
        'type' => 'text',
        'priority' => 40,
        'section' => 'header_image',
        'label' => esc_html__( 'Header Image Label', 'minimalistflex' ),
        'description' => esc_html__( 'You may provide a description of your header image. Also will become the label of the link if set. Should be set for better accessibility.', 'minimalistflex' )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_home_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_home',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_home_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_home',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_home_waterfall', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_home',
        'label' => _x( 'Waterfall Layout', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to use a two-column waterfall layout.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        ),
        'active_callback' => 'minimalistflex_is_beta_feature_enabled'
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_home_excerpt_mode', Array(
        'type' => 'radio',
        'priority' => 20,
        'section' => 'minimalistflex_layout_home',
        'label' => esc_html__( 'Blog Display Mode', 'minimalistflex' ),
        'description' => esc_html__( 'Choose whether to display full posts or excerpts on the blog page.', 'minimalistflex' ),
        'choices' => Array(
            'full' => esc_html__( 'Full Posts', 'minimalistflex' ),
            'excerpt' => esc_html__( 'Excerpts', 'minimalistflex' )
        ),
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_home_excerpt_length', Array(
        'type' => 'number',
        'priority' => 20,
        'section' => 'minimalistflex_layout_home',
        'label' => esc_html__( 'Excerpt Word Count', 'minimalistflex' ),
        'description' => esc_html__( 'The word count of the excerpts on any archive page and the blog page.', 'minimalistflex' ),
        'input_attrs' => Array(
            'min' => 0
        ),
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_front_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_front',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_front_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_front',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_archive_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_archive',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_archive_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_archive',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_archive_title', Array(
        'type' => 'radio',
        'priority' => 20,
        'section' => 'minimalistflex_layout_archive',
        'label' => _x( 'Title', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the archive title.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_search_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_search',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_search_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_search',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_search_title', Array(
        'type' => 'radio',
        'priority' => 20,
        'section' => 'minimalistflex_layout_search',
        'label' => _x( 'Search Query', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the search query.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_search_form', Array(
        'type' => 'radio',
        'priority' => 20,
        'section' => 'minimalistflex_layout_search',
        'label' => _x( 'Search Form', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to also display the search form.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_author_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_author',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_author_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_author',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_author_title', Array(
        'type' => 'radio',
        'priority' => 20,
        'section' => 'minimalistflex_layout_author',
        'label' => _x( 'Author Name', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the author name.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_author_admin', Array(
        'type' => 'radio',
        'priority' => 40,
        'section' => 'minimalistflex_layout_author',
        'label' => _x( 'Admin Status', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Show an indicator in the bottom-right of the avatar if the author is an admin.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_singular_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_singular',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_singular_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_singular',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_page_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_page',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_page_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_page',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
        $wp_customize -> add_control( 'minimalistflex_layout_error_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_error',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_error_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_error',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_error_title', Array(
        'type' => 'text',
        'priority' => 20,
        'section' => 'minimalistflex_layout_error',
        'label' => _x( 'Error Page Title', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Choose what title to display on the error page.', 'minimalistflex' )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_error_message', Array(
        'type' => 'text',
        'priority' => 25,
        'section' => 'minimalistflex_layout_error',
        'label' => _x( 'Error Page Message', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Choose what message to display on the error page. The message will be displayed below the title.', 'minimalistflex' )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_error_form', Array(
        'type' => 'radio',
        'priority' => 30,
        'section' => 'minimalistflex_layout_error',
        'label' => _x( 'Search Form', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to also display the search form on the error page.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_default_sidebar', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_layout_default',
        'label' => _x( 'Sidebar', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the sidebar, and its location.', 'minimalistflex' ),
        'choices' => Array(
            'left' => esc_html__( 'Left sidebar', 'minimalistflex' ),
            'right' => esc_html__( 'Right sidebar', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_layout_default_header', Array(
        'type' => 'radio',
        'priority' => 15,
        'section' => 'minimalistflex_layout_default',
        'label' => _x( 'Header Image', 'layout' , 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to display the header image.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_scroll_top', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Scroll to top button', 'minimalistflex' ),
        'description' => esc_html__( 'Whether to display a "Scroll to top" button in the bottom-right corner.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_autoh2label', Array(
        'type' => 'radio',
        'priority' => 25,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Auto h2 Label', 'minimalistflex' ),
        'description' => esc_html__( 'The theme can automatically theme and label the h2 elements in single posts and pages, providing a better visual. May not work well in all circumstances, use with caution.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_comment_count', Array(
        'type' => 'radio',
        'priority' => 30,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Comment Count', 'minimalistflex' ),
        'description' => esc_html__( 'Whether to display the comment count of the posts listed in an archive page.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_publisher', Array(
        'type' => 'radio',
        'priority' => 35,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Publisher', 'minimalistflex' ),
        'description' => esc_html__( 'Whether to display the publisher.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_date', Array(
        'type' => 'radio',
        'priority' => 40,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Publish Date', 'minimalistflex' ),
        'description' => esc_html__( 'Whether to display the published date.', 'minimalistflex' ),
        'choices' => Array(
            'publish' => esc_html__( 'Yes, publish time only.', 'minimalistflex' ),
            'modify' => esc_html__( 'Yes, and display modified time if possible.', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_readlink', Array(
        'type' => 'text',
        'priority' => 45,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Read More Link', 'minimalistflex' ),
        'description' => esc_html__( 'The text for the "Read More" links.', 'minimalistflex' )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_thumbnail_height', Array(
        'type' => 'radio',
        'priority' => 50,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Thumbnail Images Size', 'minimalistflex' ),
        'description' => esc_html__( 'Select whether to enable flexible height for your thumbnail images, or use a fixed height.', 'minimalistflex' ),
        'choices' => Array(
            'fixed' => esc_html__( 'Fixed', 'minimalistflex' ),
            'auto' => esc_html__( 'Flexible', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_interface_thumbnail_height_px', Array(
        'type' => 'number',
        'priority' => 51,
        'section' => 'minimalistflex_interface',
        'label' => esc_html__( 'Height', 'minimalistflex' ),
        'description' => esc_html__( 'Enter your desired height here. Should be in pixels.', 'minimalistflex' ),
    ) );
    $wp_customize -> add_control( 'minimalistflex_footer_type', Array(
        'type' => 'radio',
        'priority' => 9,
        'section' => 'minimalistflex_footer',
        'label' => esc_html__( 'Footer Options', 'minimalistflex' ),
        'description' => esc_html__( 'Choose what to display in your footer credit section.', 'minimalistflex' ),
        'choices' => Array(
            'both' => esc_html__( 'Both MinimalistFlex credits and custom footer text.', 'minimalistflex' ),
            'minimalistflex' => esc_html__( 'MinimalistFlex credits only.', 'minimalistflex' ),
            'custom' => esc_html__( 'Custom footer text only.', 'minimalistflex' ),
            'none' => esc_html__( 'Neither.', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'minimalistflex_footer_text', Array(
        'code_type' => 'htmlmixed',
        'priority' => 15,
        'section' => 'minimalistflex_footer',
        'label' => esc_html__( 'Custom Footer Text', 'minimalistflex' ),
        'description' => esc_html__( 'Here you may set a custom footer text to be displayed in the footer credits. HTML allowed.', 'minimalistflex' )
    ) ) );
    $wp_customize -> add_control( 'minimalistflex_footer_widget_layout', Array(
        'type' => 'radio',
        'priority' => 10,
        'section' => 'minimalistflex_footer',
        'label' => esc_html__( 'Footer Widget Layout', 'minimalistflex' ),
        'description' => esc_html__( 'Choose the layout of the footer widgets.', 'minimalistflex' ),
        'choices' => Array(
            'one' => esc_html__( 'One column. Only shows the "Footer" widget area.', 'minimalistflex' ),
            'two' => esc_html__( 'Two columns. Also shows the "Footer 2" widget area.', 'minimalistflex' ),
            'three' => esc_html__( 'Three columns. Also shows the "Footer 3" widget area (aka all areas).', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_admin_warning', Array(
        'type' => 'radio',
        'priority' => 100,
        'section' => 'minimalistflex_advanced',
        'label' => esc_html__( 'Admin Warnings', 'minimalistflex' ),
        'description' => esc_html__( 'The theme can display a warning when no widgets are set. Select "No" to disable this feature.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );
    $wp_customize -> add_control( 'minimalistflex_beta_feature_enabled', Array(
        'type' => 'radio',
        'priority' => 101,
        'section' => 'minimalistflex_advanced',
        'label' => esc_html__( 'Enable Beta Features', 'minimalistflex' ),
        'description' => esc_html__( 'Enable the beta features of the theme.', 'minimalistflex' ),
        'choices' => Array(
            'yes' => esc_html__( 'Yes', 'minimalistflex' ),
            'no' => esc_html__( 'No', 'minimalistflex' )
        )
    ) );

}
add_action( 'customize_register', 'minimalistflex_customize_register' );
add_action( 'customize_register', 'minimalistflex_customize_color_register' );
add_action( 'customize_register', 'minimalistflex_customize_author_elements_register' );