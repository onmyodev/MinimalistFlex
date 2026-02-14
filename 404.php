<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php get_header() ?>

<div class="singular">
    <div class="singular-main">
        <div class="minimalistflex-404-message">
            <?php if ( get_theme_mod( 'minimalistflex_layout_error_title' ) ) :?>
                <h1 class="404-title"><?php echo esc_html( get_theme_mod( 'minimalistflex_layout_error_title' ) ); ?></h1>
            <?php else : ?>
                <h1 class="404-title"><?php esc_html_e( 'You&apos;ve reached the edge of the world.', 'minimalistflex' ) ?></h1>
            <?php endif; ?>
            <?php if ( get_theme_mod( 'minimalistflex_layout_error_message' ) ) :?>
                <p><?php echo esc_html( get_theme_mod( 'minimalistflex_layout_error_message' ) ); ?></p>
            <?php else : ?>
                <p><?php esc_html_e( 'It looks like the page you are looking for doesn&apos;t exist.', 'minimalistflex' ) ?></p>
            <?php endif; ?>
        </div>
        <?php if ( get_theme_mod( 'minimalistflex_layout_error_form', 'yes' ) === 'yes' ) : ?>
            <p><?php esc_html_e( 'What about a search?', 'minimalistflex' ) ?></p>
            <?php get_search_form() ?>
        <?php endif; ?>

        <p><a href="javascript:history.go(-1)"><?php esc_html_e( '&larr; Go back', 'minimalistflex' ) ?></a></p>
    </div>
</div>

<?php get_footer() ?>