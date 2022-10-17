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

use Glpi\Application\View\TemplateRenderer;
use Glpi\Features\AssetImage;
use Glpi\Plugin\Hooks;

class PluginGalleryGallery extends CommonDBTM 
{

    use AssetImage;

    static $rightname = "plugin_gallery";

    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {   
        return self::createTabEntry('Gallery');
    }
 
    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0)
    {
        global $DB;

        $options = [
            'target' => '/plugins/gallery/front/gallery.form.php'
        ];
        $gallery = new PluginGalleryGallery();
        $iterator = $DB->request([
                'SELECT' => '*',
                'FROM'   => PluginGalleryGallery::getTable(),
                'WHERE'  => [
                    'items_id' => $item->getID(),
                    'itemtype' => $item->getType(),
                ],
                'LIMIT' => 1
            ]);

        if (count($iterator)) {
            $gallery = $iterator->current();
            $pictures = json_decode($gallery['pictures']);
            $picturesStatic = [];
            $pictures360 = [];
            foreach($pictures as $key=>$pic) {
                $picUrl = Toolbox::getPictureUrl($pic);
                list($width, $height) = getimagesize('../files/_pictures/' . $pic);
                if($width/2 === $height) {
                    $pictures360[$key] = $picUrl;
                } else {
                    $picturesStatic[$key] = $picUrl;
                }
            }

            $gallery['picturesStatic'] = $picturesStatic;
            $gallery['pictures360'] = $pictures360;
        }

        TemplateRenderer::getInstance()->display('@gallery\gallery.html.twig', [
            'item'   => $item,
            'gallery' => $gallery,
            'params' => $options,
        ]);
        return true;

    }

    public function prepareInputForAdd($input)
    {
        $input = parent::prepareInputForAdd($input);
        return $this->managePictures($input);
    }

    public function prepareInputForUpdate($input)
    {
        $input = parent::prepareInputForUpdate($input);
        return $this->managePictures($input);
    }

}