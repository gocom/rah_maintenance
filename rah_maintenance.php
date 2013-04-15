<?php

/**
 * Handles maintenance mode.
 */

class rah_maintenance
{
	/**
	 * Constructor.
	 */

	public function __construct()
	{
		register_callback(array($this, 'install'), 'plugin_lifecycle.rah_maintenance');
		register_callback(array($this, 'error_page'), 'pretext');
	}

	/**
	 * Installer.
	 */

	public function install()
	{
		if (get_pref('rah_maintenance_active', false) === false)
		{
			set_pref('rah_maintenance_active', 0, 'site', PREF_PLUGIN, 'yesnoradio', 81);
		}
	}

	/**
	 * Display error page when maintenance mode is active.
	 */

	public function error_page()
	{
		if (get_pref('rah_maintenance_active') && !is_logged_in())
		{
			txp_die(gTxt('rah_maintenance_in_progress'), 503);
		}
	}
}

new rah_maintenance();