<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php
    require 'color-definitions.php';
?>

<style id="minimalistflex-color-css">

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
    --minimalistflex-content-blend: <?php echo esc_html( 100 - get_theme_mod( 'minimalistflex_content_background_blend', 50 ) ) . '%'; ?>;
    --minimalistflex-sidebar-blend: <?php echo esc_html( 100 - get_theme_mod( 'minimalistflex_sidebar_background_blend', 25 ) ) . '%'; ?>;
}

</style>