<?php

/**
 * REQUIRE NAME
 * ============
 *
 * DESC
 */

/* SK ACF */
require_once locate_template( 'lib/class-sk-acf.php' );
$sk_acf = new SK_ACF();

/* SK Outage Messages */
require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages.php' );
$outage_messages = new SK_Outage_Messages();


/**
 * CSS setup for SK Child Theme.
 *
 * @author Daniel Pihlström
 *
 * @since  1.0.0
 *
 */
function sk_childtheme_enqueue_styles() {

	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/assets/css/style.css',
		array( 'main' ),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script( 'main-child', get_stylesheet_directory_uri() . '/assets/js/app.js', [
		'jquery',
		'handlebars',
		'typeahead'
	] );

	wp_localize_script( 'main-child', 'ajax_object', array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'ajax_nonce' )
		)
	);
}

add_action( 'wp_enqueue_scripts', 'sk_childtheme_enqueue_styles' );