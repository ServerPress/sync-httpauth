<?php
/*
Plugin Name: WPSiteSync for HTTP Authentication
Plugin URI: http://wpsitesync.com
Description: Adds support for sites protected with HTTP Authentication via .htaccess rules.
Author: WPSiteSync
Author URI: http://wpsitesync.com
Version: 1.0
Text Domain: wpsitesync-httpauth

The PHP code portions are distributed under the GPL license. If not otherwise stated, all
images, manuals, cascading stylesheets and included JavaScript are NOT GPL.
*/

class WPSiteSync_HTTPAuth
{
	private static $_instance = NULL;

	const OPTION_USER = 'httpauth_user';
	const OPTION_PASS = 'httpauth_pass';

	private function __construct()
	{
		add_action('spectrom_sync_init', array($this, 'init'));
	}

	/**
	 * Returns singleton instance of plugin class
	 * @return WPSiteSync_HTTPAuth plugin instnace
	 */
	public static function get_instance()
	{
		if (NULL === self::$_instance)
			self::$_instance = new self();
		return self::$_instance;
	}

	/**
	 * Callback for the 'spectrom_sync_init' action. Used to initialize this plugin
	 */
	public function init()
	{
		if (is_admin()) {
			$this->_load_class('httpauthadmin');
			new SyncHTTPAuthAdmin();
		}
		add_filter('spectrom_sync_api_arguments', array($this, 'filter_api_args'), 10, 2);
	}

	/**
	 * Utility method to load additional classes
	 */
	private function _load_class($class)
	{
		include_once(dirname(__FILE__) . '/classes/' . $class . '.php');
	}

	/**
	 * Callback for the 'spectrom_aync_api_arguments' filter. Adds the HTTP Authentication data to the Sync API requests.
	 * @param array $remote_args The arguments to be passed to SyncApiRequest's wp_remote_post() function call.
	 * @param string $action The API call bring processed
	 * @return array The modified $remote_args array with HTTP Authentication headers added
	 */
	public function filter_api_args($remote_args, $action)
	{
SyncDebug::log(__METHOD__.'()');
		$user = SyncOptions::get(self::OPTION_USER, '');
		$pass = SyncOptions::get(self::OPTION_PASS, '');

		if (!empty($user) && !empty($pass)) {
SyncDebug::log(__METHOD__.'() adding authentication');
			$remote_args['headers']['Authorization'] = 'Basic ' . base64_encode($user . ':' . $pass);
		}

		return $remote_args;
	}
}

WPSiteSync_HTTPAuth::get_instance();

// EOF