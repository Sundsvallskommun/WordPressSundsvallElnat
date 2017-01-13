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