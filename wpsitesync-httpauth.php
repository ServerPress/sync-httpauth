<?php
/*
Plugin Name: WPSiteSync for HTTP Authentication
Plugin URI: http://wpsitesync.com
Description: Adds support for sites protected with HTTP Authentication via .htaccess rules.
Author: WPSiteSync
Author URI: http://serverpress.com
Version: 1.1
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
		if (is_admin())
			add_action('wp_loaded', array($this, 'wp_loaded'));
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
	 * Called when WP is loaded so we can check if parent plugin is active.
	 */
	public function wp_loaded()
	{
		if (is_admin() && !class_exists('WPSiteSyncContent', FALSE) && current_user_can('activate_plugins')) {
			add_action('admin_notices', array($this, 'notice_requires_wpss'));
			add_action('admin_init', array($this, 'disable_plugin'));
		}
	}

	/**
	 * Displays the warning message stating that WPSiteSync is not present.
	 */
	public function notice_requires_wpss()
	{
		$install = admin_url('plugin-install.php?tab=search&s=wpsitesync');
		$activate = admin_url('plugins.php');
		$msg = sprintf(__('The <em>WPSiteSync for HTTP Authentication</em> plugin requires the main <em>WPSiteSync for Content</em> plugin to be installed and activated. Please %1$sclick here</a> to install or %2$sclick here</a> to activate.', 'wpsitesync-httpauth'),
					'<a href="' . $install . '">',
					'<a href="' . $activate . '">');
		$this->_show_notice($msg, 'notice-warning');
	}

	/**
	 * Helper method to display notices
	 * @param string $msg Message to display within notice
	 * @param string $class The CSS class used on the <div> wrapping the notice
	 * @param boolean $dismissable TRUE if message is to be dismissable; otherwise FALSE.
	 */
	private function _show_notice($msg, $class = 'notice-success', $dismissable = FALSE)
	{
		echo '<div class="notice ', $class, ' ', ($dismissable ? 'is-dismissible' : ''), '">';
		echo '<p>', $msg, '</p>';
		echo '</div>';
	}

	/**
	 * Disables the plugin if WPSiteSync not installed
	 */
	public function disable_plugin()
	{
		deactivate_plugins(plugin_basename(__FILE__));
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