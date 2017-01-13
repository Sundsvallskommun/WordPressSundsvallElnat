<?php

/**
 * Class SK_ACF wraps ACF save and load functionality
 * in the child theme. It tells where to save and load
 * json files from.
 *
 * @author Andreas Färnstrand <andreas.farnstrand@cybercom.com>
 * @since 1.0.0
 *
 */

class SK_ACF {

	public function __construct() {

		// Add filters for saving and loading acf fields from child theme
		add_filter( 'acf/settings/save_json', array( $this, 'save_json' ) );
		add_filter( 'acf/settings/load_json',  array( $this, 'load_json' ) );

	}


	/**
	 * Returns the path to save the json file to.
	 *
	 * @return string
	 */
	public function save_json() {

		return get_stylesheet_directory() . '/acf-json';

	}


	/**
	 * Add path to child themes ACF Json directory
	 *
	 * @param $paths
	 *
	 * @return array
	 */
	public function load_json( $paths ) {

		$parent_theme_paths = array( get_template_directory() . '/acf-json' );
		$paths = array_merge( $paths, $parent_theme_paths );

		if ( is_child_theme() ) {
			$paths[] = get_stylesheet_directory() . '/acf-json';
		}

		return $paths;

	}

}