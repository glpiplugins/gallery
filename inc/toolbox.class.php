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

class PluginGalleryToolbox {

    /**
    * Return a list of GLPI itemtypes.
    *
    * @return array
    */
    public static function getGlpiItemtypes(): array
    {
        global $CFG_GLPI, $PLUGIN_HOOKS;

        $assets_itemtypes = [
            Computer::class,
            Monitor::class,
            Software::class,
            NetworkEquipment::class,
            Peripheral::class,
            Printer::class,
            CartridgeItem::class,
            ConsumableItem::class,
            Phone::class,
            Rack::class,
            Enclosure::class,
            PDU::class,
            PassiveDCEquipment::class,
            Cable::class,
        ];

        $assistance_itemtypes = [
            Ticket::class,
            Problem::class,
            Change::class,
            TicketRecurrent::class,
            RecurrentChange::class,
            PlanningExternalEvent::class,
        ];

        $management_itemtypes = [
            SoftwareLicense::class,
            SoftwareVersion::class,
            Budget::class,
            Supplier::class,
            Contact::class,
            Contract::class,
            Document::class,
            Line::class,
            Certificate::class,
            Datacenter::class,
            Cluster::class,
            Domain::class,
            Appliance::class,
            Database::class,
            DatabaseInstance::class,
        ];

        $tools_itemtypes = [
            Project::class,
            ProjectTask::class,
            Reminder::class,
            RSSFeed::class,
        ];

        $administration_itemtypes = [
            User::class,
            Group::class,
            Entity::class,
            Profile::class,
        ];

        $components_itemtypes = [];
        foreach ($CFG_GLPI['device_types'] as $device_itemtype) {
            $components_itemtypes[] = $device_itemtype;
        }
        sort($components_itemtypes, SORT_NATURAL);

        $component_items_itemtypes = [];
        foreach ($CFG_GLPI['itemdevices'] as $deviceitem_itemtype) {
            $component_items_itemtypes[] = $deviceitem_itemtype;
        }
        sort($component_items_itemtypes, SORT_NATURAL);

        $dropdowns_sections  = [];
        foreach (Dropdown::getStandardDropdownItemTypes() as $section => $itemtypes) {
            $section_name = sprintf(
                __('%s: %s'),
                _n('Dropdown', 'Dropdowns', Session::getPluralNumber()),
                $section
            );
            $dropdowns_sections[$section_name] = array_keys($itemtypes);
        }

        $other_itemtypes = [
            NetworkPort::class,
            Notification::class,
            NotificationTemplate::class,
        ];

        $all_itemtypes = [
            _n('Asset', 'Assets', Session::getPluralNumber())         => $assets_itemtypes,
            __('Assistance')                                          => $assistance_itemtypes,
            __('Management')                                          => $management_itemtypes,
            __('Tools')                                               => $tools_itemtypes,
            __('Administration')                                      => $administration_itemtypes,
            _n('Plugin', 'Plugins', Session::getPluralNumber())       => $plugins_itemtypes,
            _n('Component', 'Components', Session::getPluralNumber()) => $components_itemtypes,
            __('Component items', 'fields')                           => $component_items_itemtypes,
        ] + $dropdowns_sections + [
            __('Other')                                               => $other_itemtypes,
        ];

        $plugin = new Plugin();
        if ($plugin->isActivated('genericobject') && method_exists('PluginGenericobjectType', 'getTypes')) {
            $go_itemtypes = [];
            foreach (array_keys(PluginGenericobjectType::getTypes()) as $go_itemtype) {
                if (!class_exists($go_itemtype)) {
                    continue;
                }
                $go_itemtypes[] = $go_itemtype;
            }
            if (count($go_itemtypes) > 0) {
                $all_itemtypes[$plugin->getInfo('genericobject', 'name')] = $go_itemtypes;
            }
        }

        $plugins_names = [];
        foreach ($all_itemtypes as $section => $itemtypes) {
            $named_itemtypes = [];
            foreach ($itemtypes as $itemtype) {
                $prefix = '';
                if ($itemtype_specs = isPluginItemType($itemtype)) {
                    $plugin_key = $itemtype_specs['plugin'];
                    if (!array_key_exists($plugin_key, $plugins_names)) {
                        $plugins_names[$plugin_key] = Plugin::getInfo($plugin_key, 'name');
                    }
                    $prefix = $plugins_names[$plugin_key] . ' - ';
                }

                $named_itemtypes[$itemtype] = $prefix . $itemtype::getTypeName(Session::getPluralNumber());
            }
            $all_itemtypes[$section] = $named_itemtypes;
        }

       // Remove empty lists (e.g. Plugin list).
        $all_itemtypes = array_filter($all_itemtypes);

        return $all_itemtypes;
    }
}
