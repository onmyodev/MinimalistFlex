<?php

function minimalistflex_sanitize_radio_cb( $value, $setting ) {
	$value = sanitize_key( $value );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	} else {
		return $setting->default;
	}
}

function minimalistflex_sanitize_color_cb( $value, $setting ) {
	$value = sanitize_hex_color( $value );
	if ( isset( $value ) ) {
		return $value;
	} else {
		return $setting->default;
	}
}

function minimalistflex_sanitize_int_cb( $number, $setting ) {
	$number = absint( $number );
	if ( $number ) {
		return $number;
	} else {
		return $setting->default;
	}
}

function minimalistflex_sanitize_checkbox_cb( $value ) {
	if ( $value === 'yes' ) {
		return 'yes';
	} else {
		return 'no';
	}
}

function minimalistflex_sanitize_percentage_cb( $value, $setting ) {
	$value = absint( $value );
	if ( $value >= 0 && $value <= 100 ) {
		return $value;
	} else {
		return $setting->default;
	}
}