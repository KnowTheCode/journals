<?php
/**
 * Journals Plugin
 *
 * @package     KnowTheCode\Journals
 * @author      hellofromTonya
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Journals Plugin
 * Plugin URI:  https://github.com/KnowTheCode/journals
 * Description: Adds journals to the website
 * Version:     1.0.0
 * Author:      hellofromTonya
 * Author URI:  https://KnowTheCode.io
 * Text Domain: journals
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace KnowTheCode\Journals;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'JOURNALS_URL', $plugin_url );
	define( 'JOURNALS_DIR', plugin_dir_path( __DIR__ ) );
}

/**
 * Initialize the plugin hooks
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_hooks() {
	register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_plugin' );
	register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_plugin' );
	register_uninstall_hook( __FILE__, __NAMESPACE__ . '\uninstall_plugin' );
}

/**
 * Plugin activation handler
 *
 * @since 1.0.0
 *
 * @return void
 */
function activate_plugin() {
	init_autoloader();

	Custom\register_custom_post_type();
//	Custom\register_custom_taxonomy();

	flush_rewrite_rules();
}

/**
 * The plugin is deactivating.  Delete out the rewrite rules option.
 *
 * @since 1.0.1
 *
 * @return void
 */
function deactivate_plugin() {
	delete_option( 'rewrite_rules' );
}

/**
 * Uninstall plugin handler
 *
 * @since 1.0.1
 *
 * @return void
 */
function uninstall_plugin() {
	delete_option( 'rewrite_rules' );
}

/**
 * Kick off the plugin by initializing the plugin files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_autoloader() {
	require_once( 'src/support/autoloader.php' );

	Support\autoload_files( __DIR__ . '/src/' );
}

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	init_autoloader();
}

init_constants();
init_hooks();
launch();
