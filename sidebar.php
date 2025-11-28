<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php if ( is_active_sidebar( 'main-sidebar' ) ): ?>
    <ul class="sidebar">
	    <?php dynamic_sidebar('main-sidebar'); ?>
    </ul>
<?php else: ?>
    <ul class="sidebar">
        <?php if ( user_can( get_current_user_id(), 'edit_theme_options' ) && get_theme_mod( 'minimalistflex_admin_warning', 'no' ) === 'yes' ): ?>
            <li class="panel widget warning">
                <?php esc_html_e( 'Sorry, but no widgets were found in this area. ', 'minimalistflex' ); ?>
                <?php esc_html_e( 'This message is displayed to administrators only.', 'minimalistflex' ); ?>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>