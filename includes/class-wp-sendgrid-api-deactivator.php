<?php

/**
 * Fired during plugin deactivation
 *
 * @link       rootscope.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 * @author     Rootscope <contact@rootscope.co.uk>
 */
class Wp_Sendgrid_Api_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		unregister_setting('wp_sendgrid_api_options', 'SENDGRID_API_KEY');
	}

}
