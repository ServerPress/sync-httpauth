<?php

class SyncHTTPAuthAdmin
{
	public function __construct()
	{
		add_action('spectrom_sync_register_settings', array($this, 'add_settings_fields'));
	}

	/**
	 * Registers the settings fields for the HTTP Authentication options
	 */
	public function add_settings_fields()
	{
		$settings = SyncSettings::get_instance();
		$section_id = 'sync_section';

		$user = SyncOptions::get(WPSiteSync_HTTPAuth::OPTION_USER, '');
		$pass = SyncOptions::get(WPSiteSync_HTTPAuth::OPTION_PASS, '');

		add_settings_field(
			'httpauth_user',									// field id
			__('HTTP Authentication Username:', 'wpsitesyn-httpauth'),	// title
			array($settings, 'render_input_field'),			// callback
			SyncSettings::SETTINGS_PAGE,					// page
			$section_id,									// section
			array(											// args
				'name' => 'httpauth_user',
				'value' => $user,
				'size' => '50',
				'description' => __('Optional Username for HTTP Authentication. ', 'wpsitesync-httpauth'),
			)
		);

		add_settings_field(
			'httpauth_pass',									// field id
			__('HTTP Authentication Password:', 'wpsitesyn-httpauth'),	// title
			array($settings, 'render_password_field'),		// callback
			SyncSettings::SETTINGS_PAGE,					// page
			$section_id,									// section
			array(											// args
				'name' => 'httpauth_pass',
				'value' => $pass,
				'size' => '50',
				'auth' => 2, // no icon
				'description' => __('Optional Password for HTTP Authentication. ', 'wpsitesync-httpauth'),
			)
		);
	}
}
