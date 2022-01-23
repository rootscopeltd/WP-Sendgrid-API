<?php

namespace RSWpSendgrid;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       rootscope.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Sendgrid_Api
 * @subpackage Wp_Sendgrid_Api/includes
 * @author     Rootscope <contact@rootscope.co.uk>
 */
class WpSendgridApi {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	private $sendgridClient;
	private $whitelistedIps = [];

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_SENDGRID_API_VERSION' ) ) {
			$this->version = WP_SENDGRID_API_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-sendgrid-api';
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function registerAdmin() {
		$admin = new WpSendgridApiAdmin($this->getPluginName(), $this->getVersion());
		return $admin->register();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function getPluginName() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function getVersion() {
		return $this->version;
	}

	private function setSendgridClient() {
		$sendgrid_api_key = get_option('SENDGRID_API_KEY');
		$sg = new \SendGrid($sendgrid_api_key);
		$this->sendgridClient = $sg->client;
	}

	public function whitelistIP($ip) {
		if (is_null($this->sendgridClient)) {
			$this->setSendgridClient();
		}

		if (!$this->isIpWhitelisted($ip)) {
			$requestBody = (object)[
				'ips' => [
					(object)['ip' => $ip],
				],
			];

		  $request = $this->sendgridClient->access_settings()->whitelist()->post($requestBody);
		  $response = json_decode($request->body());
			if (empty($response->errors)) {
				if ($response->result[0]->id) {
					return [
						'type' => 'success',
						'message' => "Your IP ($ip) has been whitelisted successfully",
					];
				}
			} else {
				error_log('RSWpSendgrid [error]: whitelistIP: ' . json_encode($response->errors));
			}
		} else {
			return [
				'type' => 'success',
				'message' => "IP address ($ip) is already whitelisted",
			];
		}

		return $this->errorMessage();
	}

	private function errorMessage() {
		return [
			'type' => 'error',
			'message' => 'There has been a problem with your request. Please try again shortly.',
		];
	}

	public function isIpWhitelisted($ip) {
		if (empty($this->whitelistedIps)) {
			$this->getWhitelistedIps();
		}

		if(empty($this->whitelistedIps)) {
			return false;
		}

		return in_array($ip, $this->whitelistedIps);
	}

	private function getWhitelistedIps() {
		try {
			$request = $this->sendgridClient->access_settings()->whitelist()->get();
			$response = json_decode($request->body());
		} catch (\Exception $e) {
			error_log('RSWpSendgrid [error]: getWhitelistedIps: ' . $e->getMessage());
			return false;
		}

		if (empty($response->errors)) {
			$whitelistedIps = array_column($response->result, 'ip');
			$this->whitelistedIps = array_map([$this, 'formatIp'], $whitelistedIps);
		} else {
			error_log('RSWpSendgrid [error]: ' . json_encode($response->errors));
		}

		return false;
	}

	public function formatIp($item) {
		list($ip, $range) = explode('/', $item, 2);
		return $ip;
	}
}
