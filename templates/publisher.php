<?php
if ( !defined( 'WPINC' ) ) {
    die;
}
?>

<?php $mf_id = get_the_author_meta( 'ID' ); ?>

<div class="publisher">

<a class="publisher-link" href="<?php echo esc_url( get_author_posts_url($mf_id) ) ?>">
    <?php echo get_avatar( $mf_id, 32 ) ?>
    <span><?php the_author() ?></span>
</a>
<div class="publisher-datetime">
    <?php $datemode = get_theme_mod( 'minimalistflex_interface_date', 'modify' ); ?>
    <?php if ( $datemode <> 'no' ): ?>
        <?php if ( $datemode == 'publish' || get_the_modified_date() <> get_the_date() ): ?>
            <?php printf(
                /* translators: %s: Post publish time. */
                esc_html__( 'Published on %s', 'minimalistflex' ),
                esc_html( get_the_date() )
            ) ?>
        <?php else: ?>
            <?php printf(
                /* translators: %s: Post last modified time. */
                esc_html__( 'Last modified on %s', 'minimalistflex' ),
                esc_html( get_the_modified_date() )
            ) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

</div>