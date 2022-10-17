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

class PluginGalleryMenu extends CommonGLPI

{
    public static $rightname = 'entity';

    public static function getMenuName()
    {
        return __("Gallery", "gallery");
    }

    public static function getIcon()
    {
        return "fas fa-image";
    }

    public static function getMenuContent()
    {
        if (!Session::haveRight('entity', READ)) {
            return;
        }

        $menu = [
            'title' => self::getMenuName(),
            'page'  =>  "/plugins/gallery/front/config.form.php",
            'icon'  => self::getIcon(),
            'content' => true
        ];

        $itemtypes = ['PluginGalleryGallery' => 'gallery'];

        foreach ($itemtypes as $itemtype => $option) {
            $menu['options'][$option] = [
                'title' => $itemtype::getTypeName(2),
                'page'  => $itemtype::getSearchURL(false),
                'links' => [
                    'search' => $itemtype::getSearchURL(false)
                ]
            ];

            if ($itemtype::canCreate()) {
                $menu['options'][$option]['links']['add'] = $itemtype::getFormURL(false);
            }
        }
        return $menu;
    }
}

