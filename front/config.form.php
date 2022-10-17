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

include('../../../inc/includes.php');

Session::checkLoginUser();

$config = new PluginGalleryConfig();
if (isset($_POST["add"])) {
   $config->check(-1, CREATE, $_POST);

   $config->add($_POST);

   Html::back();

}
 else if (isset($_POST["update"])) {
   $config->update($_POST);
   Html::back();

} else {
   Html::header(
      __("Gallery", "gallery"),
      $_SERVER['PHP_SELF'],
      "config",
      "plugingallerymenu",
      "galleryconfig"
   );
   $config->showForm(1);
   Html::footer();
}