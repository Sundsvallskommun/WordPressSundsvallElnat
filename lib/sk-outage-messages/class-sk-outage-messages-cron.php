<?php

/**
 * WP Cron job for the import of outage messages
 *
 * @package    SK_Outage_Messages
 * @author     Andreas Färnstrand <andreas.farnstrand@cybercom.com>
 */

class SK_Outage_Messages_Cron {

	/**
	 * Class constructor. Setup actions and filters
	 * and schedule the import of the messages.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_filter( 'cron_schedules', [ $this, 'update_cron_schedules' ] );
		add_action( 'update_outage_messages', [ $this, 'callback' ] );

		$this->schedule();

	}


	/**
	 * Schedule an import event if not already scheduled.
	 */
	private function schedule() {

		if ( ! wp_next_scheduled( 'update_outage_messages' ) ) {

			wp_schedule_event( time(), '5min', 'update_outage_messages' );

		}

	}


	/**
	 * The callback function for importing
	 * outage messages.
	 */
	function callback() {

		SK_Outage_Messages_Updater::import();

	}


	/**
	 * Update the cron schedules available
	 * for Wordpress.
	 *
	 * @param array     $schedules
	 *
	 * @return array
	 */
	public function update_cron_schedules( $schedules ) {

		if ( ! isset( $schedules["5min"] ) ) {
			$schedules["5min"] = array(
				'interval' => 5 * 60,
				'display'  => __( 'Once every 5 minutes' )
			);
		}

		return $schedules;
	}


}