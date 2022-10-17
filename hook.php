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
/**
 * Plugin install process
 *
 * @return boolean
 */
function plugin_gallery_install()
{
    global $DB;

    if (!$DB->tableExists("glpi_plugin_gallery_galleries")) {
        $DB->runFile(Plugin::getPhpDir('gallery')."/install/sql/empty-0.0.1.sql");
    }

    return true;
}

/**
 * Plugin uninstall process
 *
 * @return boolean
 */
function plugin_gallery_uninstall()
{
    global $DB;

    $tables = [
        "glpi_plugin_gallery_galleries",
        "glpi_plugin_gallery_configs"
    ];

    foreach ($tables as $table) {
        $DB->query("DROP TABLE IF EXISTS `$table`;");
    }

    $tables_glpi = ["glpi_logs"];

    foreach ($tables_glpi as $table_glpi) {
        $DB->query("DELETE FROM `$table_glpi`
                WHERE `itemtype` = 'PluginGallery';");
    }

    return true;
}
