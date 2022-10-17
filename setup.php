<?php
/**
 * -------------------------------------------------------------------------
 * Gallery plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of Gallery.
 *
 * Gallery is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Gallery is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Gallery. If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2022 by Roy Brannath.
 * @license   GPLv3 https://www.gnu.org/licenses/gpl-3.0
 * @link      https://github.com/glpiplugins/gallery
 * -------------------------------------------------------------------------
 */

define('PLUGIN_GALLERY_VERSION', '0.0.1');

// Minimal GLPI version, inclusive
define("PLUGIN_GALLERY_MIN_GLPI_VERSION", "10.0.0");
// Maximum GLPI version, exclusive
define("PLUGIN_GALLERY_MAX_GLPI_VERSION", "10.0.99");

/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_gallery()
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['gallery'] = true;
    $PLUGIN_HOOKS['change_profile']['gallery'] = [PluginGalleryProfile::class, 'initProfile'];

    if (Plugin::isPluginActive('gallery')) {

        //if glpi is loaded
        if (Session::getLoginUserID()) {
  
           Plugin::registerClass(PluginGalleryProfile::class,
                                 ['addtabon' => Profile::class]);

            Plugin::registerClass(PluginGalleryGallery::class, array('addtabon' => array_unique(PluginGalleryConfig::getEntries())));


            $PLUGIN_HOOKS['add_javascript']['gallery'][] = 'assets/lightbox.js';
            $PLUGIN_HOOKS['add_css']['gallery'][]  = 'assets/lightbox.css';

            $PLUGIN_HOOKS['add_javascript']['gallery'][] = 'assets/pannellum.js';
            $PLUGIN_HOOKS['add_css']['gallery'][]  = 'assets/pannellum.css';

            $PLUGIN_HOOKS["menu_toadd"]['gallery'] = ['config' => 'PluginGalleryMenu'];
        }
    }
}


/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_gallery()
{
    return [
        'name'           => 'Gallery',
        'version'        => PLUGIN_GALLERY_VERSION,
        'author'         => '<a href="http://www.github.com/rbrannath">Roy Brannath\'</a>',
        'license'        => 'GPL 3.0',
        'homepage'       => 'https://github.com/glpiplugins/gallery',
        'requirements'   => [
            'glpi' => [
                'min' => PLUGIN_GALLERY_MIN_GLPI_VERSION,
                'max' => PLUGIN_GALLERY_MAX_GLPI_VERSION,
            ]
        ]
    ];
}

/**
 * Check pre-requisites before install
 *
 * @return boolean
 */
function plugin_gallery_check_prerequisites()
{
    return true;
}

/**
 * Check configuration process
 *
 * @param boolean $verbose Whether to display message on failure. Defaults to false
 *
 * @return boolean
 */
function plugin_gallery_check_config($verbose = false)
{
    if (true) { // Your configuration check
        return true;
    }

    if ($verbose) {
        echo __('Installed / not configured', 'gallery');
    }
    return false;
}
