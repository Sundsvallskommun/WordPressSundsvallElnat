<?php

require_once locate_template( 'lib/sk-outage-messages/class-sk-outage-messages-posttype.php' );

class SK_Outage_Messages {


	public function __construct() {

		// Create instances of used classes
		$post_type = new SK_Outage_Messages_Posttype();

		add_action( 'init', array( $post_type, 'register_posttype' ) );

	}


}