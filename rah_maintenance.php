<?php

/**
 * Rah_maintenance plugin for Textpattern CMS
 *
 * @author  Jukka Svahn
 * @date    2013-
 * @license GNU GPLv2
 * @link    https://github.com/gocom/rah_maintenance
 *
 * Copyright (C) 2013 Jukka Svahn http://rahforum.biz
 * Licensed under GNU Genral Public License version 2
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

class rah_maintenance
{
	/**
	 * Constructor.
	 */

	public function __construct()
	{
		register_callback(array($this, 'install'), 'plugin_lifecycle.rah_maintenance', 'installed');
		register_callback(array($this, 'uninstall'), 'plugin_lifecycle.rah_maintenance', 'deleted');
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
	 * Uninstaller.
	 */

	public function uninstall()
	{
		safe_delete('txp_prefs', "name like 'rah\_maintenance\_%'");
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