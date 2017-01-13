<?php


class SK_Outage_Messages_Updater {

	public static function import() {

		// Import data
		$imported_messages = array(
			array(
				'id' => 4056,
				'area' => 'Stenstaden',
				'outagedescription' => 'Omskarvning',
				'starttime' => '30-Sep-15',
				'plannedstarttime' => '30-Sep-15',
				'statusinfo' => 'Planerat',
				'statusinfo2' => 'Meddelas',
				'endtime' => '27-Aug-16',
				'estendtime' => '',
				'classid' => 5200,
				'status' => 2
			),
			array(
				'id' => 4575,
				'area' => 'Icke definierad',
				'outagedescription' => 'Träd på Hsp',
				'starttime' => '27-Aug-16',
				'plannedstarttime' => '',
				'statusinfo' => 'Ej definierad',
				'statusinfo2' => 'Meddelas',
				'endtime' => '27-Aug-16',
				'estendtime' => '',
				'classid' => 1211,
				'status' => 3
			)
		);

		if ( count( $imported_messages ) > 0 ) {

			foreach ( $imported_messages as $message ) {

				self::update_or_create_message( $message );

			}

		}

	}


	private static function update_or_create_message( $message ) {

		$posts = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'outage_message',
				'post_status' => array( 'publish' ),
				'meta_key' => 'external_id',
				'meta_value' => $message['id']
			)
		);

		$post_id = null;


		if ( isset( $posts ) && is_array( $posts ) && count( $posts ) == 1 ) {

			$post = array_pop( $posts );
			$post_id = wp_update_post( array(
				'ID' => $post->ID,
				'post_title' => $message['id'],
				'post_content' => $message['outagedescription'],
				'post_status' => 'publish'
			), true );

		} else { // No old post found, create a new message post

			$post_id = wp_insert_post( array(
				'post_title' => $message['id'],
				'post_content' => $message['outagedescription'],
				'post_type' => 'outage_message',
				'post_status' => 'publish'
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
			update_post_meta( $post_id, 'endtime',  self::transform_date( $message['endtime'] ) );
			update_post_meta( $post_id, 'estendtime',  self::transform_date( $message['estendtime'] ) );
			update_post_meta( $post_id, 'classid', $message['classid'] );
			update_post_meta( $post_id, 'status', $message['status'] );

		}

	}


	private function transform_date( $date ) {

		if ( empty( $date ) ) return null;

		return date('Y-m-d', strtotime( $date ) );

	}


}