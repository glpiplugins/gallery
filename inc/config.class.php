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
use Glpi\Plugin\Hooks;

class PluginGalleryConfig extends CommonDBTM 
{

    public static $rightname = 'config';

    public static function getTypeName($nb = 0) {
        return __("Gallery", "gallery");
     }
  
    public function prepareInputForAdd($input)
    {
        $input = parent::prepareInputForAdd($input);
        $input['itemtypes'] = json_encode($input['itemtypes']);
        return $input;
    }

    public function prepareInputForUpdate($input)
    {
        $input = parent::prepareInputForUpdate($input);
        $input['itemtypes'] = json_encode($input['itemtypes']);
        return $input;
    }

    public function showForm($ID, $options = [])
    {
       
        global $CFG_GLPI;

        $this->getFromDB(1);

        $options = [
            'target' => '/plugins/gallery/front/config.form.php'
        ];
        
        TemplateRenderer::getInstance()->display('@gallery\config.html.twig', [
            'item'   => $this,
            'allItemtypes' =>  PluginFieldsToolbox::getGlpiItemtypes(),
            'params' => $options,
        ]);

        return true;

    }

    public static function getEntries()
    {
        $config = new self();
        $found = $config->find(['id' => 1]);

        return json_decode($found[1]['itemtypes']);

    }
}