<?php

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
class Wp_Sendgrid_Api_Admin {

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
	private $menu_slug = 'wp_sendgrid_api';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', [$this, 'addSettingsPage']);
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
	  include_once plugin_dir_path(__FILE__) . 'templates/settings_page.php';
	}



}
