<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       krupal-algo
 * @since      1.0.0
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/includes
 * @author     krupal Patel <krupalpatel92@yahoo.com>
 */
class Algolia_Search_Integration_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'algolia-search-integration',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
