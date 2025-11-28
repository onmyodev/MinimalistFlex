<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php if ( is_active_sidebar( 'footer-2' ) ): ?>
    <ul class="footer-2-widgets">
        <?php dynamic_sidebar( 'footer-2' ); ?>
    </ul>
<?php elseif ( user_can( get_current_user_id(), 'edit_theme_options' ) && get_theme_mod( 'minimalistflex_admin_warning', 'no' ) === 'yes' ): ?>
    <ul class="footer-2-widgets">
        <li class="panel widget footer-2-widget warning">
            <?php esc_html_e( 'Sorry, but no widgets were found in this area.', 'minimalistflex' ); ?>
            <?php esc_html_e( 'This message is displayed to administrators only.', 'minimalistflex' ); ?>
        </li>
    </ul>
<?php endif; ?>