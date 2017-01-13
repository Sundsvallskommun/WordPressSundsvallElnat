<?php

/**
 * Wrapper class for the Outage Messages post type
 *
 * @package    SK_Outage_Messages
 * @author     Andreas Färnstrand <andreas.farnstrand@cybercom.com>
 */
class SK_Outage_Messages_Posttype {

	/**
	 * Register the post type
	 *
	 * @since    1.0.0
	 * @access   public
	 *
	 */
	public function register_posttype() {

		register_post_type( 'outage_message', $this->posttype_arguments() );

	}


	/**
	 * The posttype arguments
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @return array    the arguments
	 */
	private function posttype_arguments() {

		return array(
			'labels'             => $this->posttype_labels(),
			'description'        => __( 'Description.', 'sundsvallelnat' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'driftavbrott' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

	}


	/**
	 * The labels for the custom post type
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @return array    the labels
	 *
	 */
	private function posttype_labels() {

		return array(
			'name'               => _x( 'Driftavbrott', 'post type general name', 'sundsvallelnat' ),
			'singular_name'      => _x( 'Driftavbrott', 'post type singular name', 'sundsvallelnat' ),
			'menu_name'          => _x( 'Driftavbrott', 'admin menu', 'sundsvallelnat' ),
			'name_admin_bar'     => _x( 'Driftavbrott', 'add new on admin bar', 'sundsvallelnat' ),
			'add_new'            => _x( 'Nytt avbrott', 'operation_message', 'sundsvallelnat' ),
			'add_new_item'       => __( 'Lägg till nytt Driftavbrott', 'sundsvallelnat' ),
			'new_item'           => __( 'Nytt avbrott', 'sundsvallelnat' ),
			'edit_item'          => __( 'Ändra Driftavbrott', 'sundsvallelnat' ),
			'view_item'          => __( 'Visa Driftavbrott', 'sundsvallelnat' ),
			'all_items'          => __( 'Alla avbrott', 'sundsvallelnat' ),
			'search_items'       => __( 'Sök Driftavbrott', 'sundsvallelnat' ),
			'parent_item_colon'  => __( 'Nuvarande Driftavbrott:', 'sundsvallelnat' ),
			'not_found'          => __( 'Inga Driftavbrott funna.', 'sundsvallelnat' ),
			'not_found_in_trash' => __( 'Inga Driftavbrott funna i papperskorgen.', 'sundsvallelnat' )
		);


	}

}