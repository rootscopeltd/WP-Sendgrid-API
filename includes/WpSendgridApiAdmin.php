<?php

namespace RSWpSendgrid;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       rootscope.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/admin
 * @author     Rootscope <contact@rootscope.co.uk>
 */
class WpSendgridApiAdmin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The capability required for this menu to be displayed to the user.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $capability    The current capability of this plugin.
	 */
	private $capability = 'manage_options';

		/**
	 * The slug name for this menu.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $menu_slug    The current menu_slug of this plugin.
	 */
	private $menu_slug = 'wpsendgridapi';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function registerAdmin() {
		add_action('admin_menu', [$this, 'addSettingsPage']);
		add_action('admin_init', [$this, 'registerSettings']);
	}

	public function addSettingsPage() {
		add_options_page(
	      'SendGrid API',
	      'SendGrid API',
	      $this->capability,
	      $this->menu_slug,
	      [$this, 'mainSettingsPage'],
	    );
	}

	public function mainSettingsPage() {
	  include_once plugin_dir_path(__FILE__) . '../admin/templates/settings_page.php';
	}

	public function registerSettings() {
		register_setting('wpsendgridapi', 'SENDGRID_API_KEY');

		add_settings_section(
			'wpsendgridapi_section',
			__('Sendgrid API KEY', 'wpsendgridapi' ),
			[$this, 'sectionCallback'],
			'wpsendgridapi'
		);

		add_settings_field(
			'SENDGRID_API_KEY',
			'SENDGRID API KEY: ',
			[$this, 'fieldCalback'],
			'wpsendgridapi',
			'wpsendgridapi_section'
		);
	}

	public function fieldCalback() {
		$sendgrid_api_key = get_option('SENDGRID_API_KEY');

		printf('<input type="text" id="SENDGRID_API_KEY" name="SENDGRID_API_KEY" value="%s" />', esc_attr($sendgrid_api_key));
	}

	function sectionCallback() {
		echo __('Enter API KEY from Sendgrid', 'wpsendgridapi');
	}

	public static function whitelistIP($ip) {
		$sendgrid_api_key = get_option('SENDGRID_API_KEY');
		$sg = new \SendGrid($sendgrid_api_key);
		$response = $sg->client->access_settings()->whitelist()->get();
		print $response->statusCode() . "\n";
		print $response->body() . "\n";
		print_r($response->headers());
	}

}
