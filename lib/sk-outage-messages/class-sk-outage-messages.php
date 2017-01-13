<?php

require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-posttype.php' );
require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-updater.php' );

class SK_Outage_Messages {


	public function __construct() {

		// Create instances of used classes
		$post_type = new SK_Outage_Messages_Posttype();

		add_action( 'init', array( $post_type, 'register_posttype' ) );

		SK_Outage_Messages_Updater::import();

	}


	public static function messages() {

		return get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'outage_message'
			)
		);

	}


}