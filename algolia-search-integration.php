<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Mehul-algo
 * @since             1.0.0
 * @package           Algolia_Search_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Algolia Custom Integration
 * Plugin URI:        https://github.com/mehul1802/algolia-search-integration.git
 * Description:       This plugin will allow you to integrate Algolia Search on your site by Algolia Standard APIs
 * Version:           1.0.0
 * Author:            Mehul Patel
 * Author URI:        http://github.com/mehul1802
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       algolia-custom-integration
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
define( 'ALGOLIA_SEARCH_INTEGRATION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-algolia-search-integration-activator.php
 */
function activate_algolia_search_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-algolia-search-integration-activator.php';
	Algolia_Search_Integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-algolia-search-integration-deactivator.php
 */
function deactivate_algolia_search_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-algolia-search-integration-deactivator.php';
	Algolia_Search_Integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_algolia_search_integration' );
register_deactivation_hook( __FILE__, 'deactivate_algolia_search_integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-algolia-search-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_algolia_search_integration() {

	$plugin = new Algolia_Search_Integration();
	$plugin->run();

}
run_algolia_search_integration();
