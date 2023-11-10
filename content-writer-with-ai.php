<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://erkadam.dev
 * @since             1.0.0
 * @package           Content_Writer_With_Ai
 *
 * @wordpress-plugin
 * Plugin Name:       Content Writer with AI
 * Plugin URI:        https://https://wordpress.org/plugins/content-writer-with-ai/
 * Description:       Thanks to the content creator, create your content easily by taking advantage of all the features of artificial intelligence.
 * Version:           1.0.0
 * Author:            Münker Erkadam
 * Author URI:        https://erkadam.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content-writer-with-ai
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONTENT_WRITER_WITH_AI_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-writer-with-ai-activator.php
 */
function activate_content_writer_with_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-writer-with-ai-activator.php';
	Content_Writer_With_Ai_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-content-writer-with-ai-deactivator.php
 */
function deactivate_content_writer_with_ai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-writer-with-ai-deactivator.php';
	Content_Writer_With_Ai_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_content_writer_with_ai' );
register_deactivation_hook( __FILE__, 'deactivate_content_writer_with_ai' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-content-writer-with-ai.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-content-writer-with-ai-custom-metabox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_content_writer_with_ai() {

	$plugin = new Content_Writer_With_Ai();
	$plugin->run();

}
run_content_writer_with_ai();
