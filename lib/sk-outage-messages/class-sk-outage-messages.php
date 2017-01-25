<?php

/**
 * Main class for SK Outage Messages
 *
 * @package    SK_Outage_Messages
 * @author     Andreas Färnstrand <andreas.farnstrand@cybercom.com>
 */

require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-posttype.php' );
require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-updater.php' );
require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-cron.php' );
require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-shortcode.php' );

class SK_Outage_Messages {


	/**
	 * SK_Outage_Messages constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Create instances of used classes
		$post_type = new SK_Outage_Messages_Posttype();
		add_action( 'init', array( $post_type, 'register_posttype' ) );

		// Setup cron job
		new SK_Outage_Messages_Cron();

		// Create shortcode
		new SK_Outage_Messages_Shortcode();

	}


	/**
	 * Get all outage messages matching
	 * query parameters.
	 *
	 * @return array    outage messages posts
	 */
	public static function messages( $with_meta = false ) {

		$messages = get_posts(
			array(
				'posts_per_page' => - 1,
				'post_type'      => 'outage_message'
			)
		);


		if ( $with_meta ) {

			if ( is_array( $messages ) && count( $messages ) > 0 ) {

				foreach ( $messages as $key => $message ) {

					$messages[$key]->meta = get_post_custom( $message->ID );

				}

			}

		}

		return $messages;

	}

}