<?php

/*
 * rah_maintenance - Textpattern CMS maintenance mode
 * https://github.com/gocom/rah_maintenance
 *
 * Copyright (C) 2019 Jukka Svahn
 *
 * This file is part of rah_maintenance.
 *
 * rah_maintenance is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2.
 *
 * rah_maintenance is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with rah_maintenance. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The plugin class.
 *
 * @internal
 */
final class Rah_Maintenance
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        register_callback([$this, 'install'], 'plugin_lifecycle.rah_maintenance', 'installed');
        register_callback([$this, 'uninstall'], 'plugin_lifecycle.rah_maintenance', 'deleted');
        register_callback([$this, 'errorPage'], 'pretext');
    }

    /**
     * Installer.
     */
    public function install()
    {
        create_pref('rah_maintenance_active', 0, 'site', PREF_PLUGIN, 'yesnoradio', 81);
    }

    /**
     * Uninstaller.
     */
    public function uninstall()
    {
        remove_pref('rah_maintenance_active');
    }

    /**
     * Invokes error page when maintenance mode is active.
     */
    public function errorPage()
    {
        if (get_pref('rah_maintenance_active') && !is_logged_in()) {
            txp_die(gTxt('rah_maintenance_in_progress'), 503);
        }
    }
}
