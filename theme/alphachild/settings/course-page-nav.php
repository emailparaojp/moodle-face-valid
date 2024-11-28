<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_alphachild
 * @copyright 2022 - 2023 Marcin Czaja (https://rosea.io)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();

$page = new admin_settingpage('theme_alphachild_settingscoursesnav', get_string('settingscoursesnav', 'theme_alphachild'));

$name = 'theme_alphachild/secnavgroupitem';
$title = get_string('secnavgroupitem', 'theme_alphachild');
$description = get_string('secnavgroupitem_desc', 'theme_alphachild', $a);
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/secnavitems';
$title = get_string('secnavitems', 'theme_alphachild');
$description = get_string('secnavitems_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

if (get_config('theme_alphachild', 'secnavitems')) {
    $name = 'theme_alphachild/secnavitemscount';
    $title = get_string('secnavitemscount', 'theme_alphachild');
    $description = get_string('secnavitemscount_desc', 'theme_alphachild');
    $default = 0;
    $options = array();
    for ($i = 1; $i <= 10; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    $navitems = get_config('theme_alphachild', 'secnavitemscount');
    if (!$navitems) {
        $navitems = 1;
    }
    for ($secnavindex = 1; $secnavindex <= $navitems; $secnavindex++) {
        $name = 'theme_alphachild/hsecnavitem' . $secnavindex;
        $heading = get_string('hsecnavitem', 'theme_alphachild');
        $setting = new admin_setting_heading($name, '<span class="rui-admin-no">' .
            $secnavindex .
            '</span>' .
            $heading, format_text(get_string('hsecnavitem_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
        $page->add($setting);

        $name = 'theme_alphachild/secnavcustomnavlabel' . $secnavindex;
        $title = get_string('secnavcustomnavlabel', 'theme_alphachild');
        $description = get_string('secnavcustomnavlabel_desc', 'theme_alphachild');
        $setting = new admin_setting_configtext($name, '<span class="rui-admin-no">' .
            $secnavindex .
            '</span>' .
            $title, $description, '', PARAM_TEXT);
        $page->add($setting);
        $name = 'theme_alphachild/secnavcustomnavurl' . $secnavindex;
        $title = get_string('secnavcustomnavurl', 'theme_alphachild');
        $description = get_string('secnavcustomnavurl_desc', 'theme_alphachild');
        $setting = new admin_setting_configtext($name, '<span class="rui-admin-no">' .
            $secnavindex .
            '</span>' .
            $title, $description, '', PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_alphachild/secnavuserrole' . $secnavindex;
        $title = get_string('secnavuserrole', 'theme_alphachild');
        $description = get_string('secnavuserrole_desc', 'theme_alphachild');
        $options = [];
        $options[0] = get_string('none', 'theme_alphachild');
        $options[1] = get_string('secnavuserrole1', 'theme_alphachild');
        $setting = new admin_setting_configselect($name, '<span class="rui-admin-no">' .
            $secnavindex .
            '</span>' .
            $title, $description, 0, $options);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
    }
}

// Must add the page after definiting all the settings!
$settings->add($page);
