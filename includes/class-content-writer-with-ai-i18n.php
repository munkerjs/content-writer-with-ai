<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://erkadam.dev
 * @since      1.0.0
 *
 * @package    Content_Writer_With_Ai
 * @subpackage Content_Writer_With_Ai/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Content_Writer_With_Ai
 * @subpackage Content_Writer_With_Ai/includes
 * @author     Münker Erkadam <info@erkadam.dev>
 */
class Content_Writer_With_Ai_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'content-writer-with-ai',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
