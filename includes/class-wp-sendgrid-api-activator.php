<?php

/**
 * Fired during plugin activation
 *
 * @link       rootscope.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 * @author     Rootscope <contact@rootscope.co.uk>
 */
class Wp_Sendgrid_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		register_setting('wp_sendgrid_api_options', 'SENDGRID_API_KEY');

		return true;
	}

}
