<?php

if ( !defined( 'WPINC' ) ) {
    die;
}

if ( !class_exists( 'WP_Customize_Control' ) ) {
    return null;
}

class MinimalistFlex_Description_Only_Custom_Control extends WP_Customize_Control
{
    /**
     * Description only custom "control" class.
     * @var $label The title of the control.
     * @var $description The description of the control.
     */

    public $label;
    public $description;

    public function render_content()
    { ?>
        <span class='customize-control-title'>
            <?php echo esc_html( $this->label ) ?>
        </span>
        <span class='description customize-control-description'>
            <?php echo esc_html( $this->description ) ?>
        </span>
      <?php
    }
}