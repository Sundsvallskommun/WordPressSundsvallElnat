<?php

/**
 * Import and parse the messages
 *
 * @package    SK_Outage_Messages
 * @author     Andreas Färnstrand <andreas.farnstrand@cybercom.com>
 */
class SK_Outage_Messages_Updater {


	/**
	 * Main import function
	 *
	 * @since    1.0.0
	 * @access   public static
	 *
	 */
	public static function import() {

		$imported_messages = self::read_file();

		if ( count( $imported_messages ) > 0 ) {

			foreach ( $imported_messages as $key => $message ) {

				if ( $key == 0 ) {
					continue;
				}

				self::update_or_create_message( $message );

			}

		}

	}


	/**
	 * Read the csv message file
	 *
	 * @since    1.0.0
	 * @access   public static
	 *
	 * @return array
	 */
	private static function read_file() {

		$uploads_dir = wp_upload_dir();
		$file_path   = $uploads_dir['basedir'] . '/' . 'data_example_3.csv';
		$messages    = [];

		if ( ( $handle = fopen( $file_path, "r" ) ) !== false ) {

			while ( ( $data = fgetcsv( $handle, null, "," ) ) !== false ) {

				$num         = count( $data );
				$message = self::get_message( $data, $num );
				if ( is_array( $message ) && ! empty ( $message ) ) {

					$messages []= $message;

				}

			}

			fclose( $handle );

		} else {

			// Log error message?

		}

		return $messages;

	}


	/**
	 * Parse the message and setup as array
	 * with sensible keys.
	 *
	 * @since    1.0.0
	 * @access   public static
	 *
	 * @param $data     the row array
	 * @param $num      the number of row values
	 *
	 * @return array    the message
	 */
	private static function get_message( $data, $num ) {

		$message = [];
		for ( $c = 0; $c < $num; $c ++ ) {

			switch ( $c ) {

				case 0:
					$message['id'] = $data[ $c ];
					break;
				case 1:
					$message['area'] = $data[ $c ];
					break;
				case 2:
					$message['outagedescription'] = $data[ $c ];
					break;
				case 3:
					$message['starttime'] = $data[ $c ];
					break;
				case 4:
					$message['plannedstarttime'] = $data[ $c ];
					break;
				case 5:
					$message['statusinfo'] = $data[ $c ];
					break;
				case 6:
					$message['statusinfo2'] = $data[ $c ];;
					break;
				case 7:
					$message['endtime'] = $data[ $c ];
					break;
				case 8:
					$message['estendtime'] = $data[ $c ];
					break;
				case 9:
					$message['classid'] = $data[ $c ];
					break;
				case 10:
					$message['status'] = $data[ $c ];
					break;
				default:
					break;


			}

		}

		return $message;

	}


	/**
	 * Update an old message or create an new one
	 *
	 * @since    1.0.0
	 * @access   public static
	 *
	 * @param $message  array with the message data
	 */
	private static function update_or_create_message( $message ) {

		$posts = get_posts(
			array(
				'posts_per_page' => - 1,
				'post_type'      => 'outage_message',
				'post_status'    => array( 'publish' ),
				'meta_key'       => 'external_id',
				'meta_value'     => $message['id']
			)
		);

		$post_id = null;


		if ( isset( $posts ) && is_array( $posts ) && count( $posts ) == 1 ) {

			$post = array_pop( $posts );

			$post_id = wp_update_post( array(
				'ID'           => $post->ID,
				'post_title'   => $message['id'],
				'post_content' => $message['outagedescription'],
				'post_status'  => 'publish'
			), true );

		} else { // No old post found, create a new message post

			$post_id = wp_insert_post( array(
				'post_title'   => $message['id'],
				'post_content' => $message['outagedescription'],
				'post_type'    => 'outage_message',
				'post_status'  => 'publish'
			), true );

		}

		if ( is_wp_error( $post_id ) || ! isset( $post_id ) ) {

			// Do some error handling

		} else {

			update_post_meta( $post_id, 'external_id', $message['id'] );
			update_post_meta( $post_id, 'starttime', self::transform_date( $message['starttime'] ) );
			update_post_meta( $post_id, 'plannedstarttime', self::transform_date( $message['plannedstarttime'] ) );
			update_post_meta( $post_id, 'statusinfo', $message['statusinfo'] );
			update_post_meta( $post_id, 'statusinfo2', $message['statusinfo2'] );
			update_post_meta( $post_id, 'endtime', self::transform_date( $message['endtime'] ) );
			update_post_meta( $post_id, 'estendtime', self::transform_date( $message['estendtime'] ) );
			update_post_meta( $post_id, 'classid', $message['classid'] );
			update_post_meta( $post_id, 'status', $message['status'] );

		}

	}


	/**
	 * Convert a date into a correct date format
	 *
	 * @since    1.0.0
	 * @access   public static
	 *
	 * @param $date     the date to transform
	 *
	 * @return a date
	 */
	private static function transform_date( $date ) {

		if ( empty( $date ) ) {
			return null;
		}

		return date( 'Y-m-d', strtotime( $date ) );

	}


}