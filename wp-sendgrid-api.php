<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              rootscope.co.uk
 * @since             1.0.0
 * @package           Wp_Sendgrid_Api
 *
 * @wordpress-plugin
 * Plugin Name:       WP Sendgrid API
 * Plugin URI:        https://github.com/rootscopeltd/WP-Sendgrid-API
 * Description:       A simple WordPress plugin to whitelist IP address in Sendgrid
 * Version:           1.0.0
 * Author:            Rootscope
 * Author URI:        rootscope.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-sendgrid-api
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
define( 'WP_SENDGRID_API_VERSION', '1.0.0' );


require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

$WpSendgridApi = new \RSWpSendgrid\WpSendgridApi();
$WpSendgridApi->registerAdmin();