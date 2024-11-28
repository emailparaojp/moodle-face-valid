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

$page = new admin_settingpage('theme_alphachild_settingstopbar', get_string('settingstopbar', 'theme_alphachild'));

$name = 'theme_alphachild/turnoffdashboardlink';
$title = get_string('turnoffdashboardlink', 'theme_alphachild');
$description = get_string('turnoffdashboardlink_desc', 'theme_alphachild', $a);
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/topbaradminbtnon';
$title = get_string('topbaradminbtnon', 'theme_alphachild');
$description = get_string('topbaradminbtnon_desc', 'theme_alphachild', $a);
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/topbareditmode';
$title = get_string('topbareditmode', 'theme_alphachild');
$description = get_string('topbareditmode_desc', 'theme_alphachild', $a);
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/topbarlogoareaon';
$title = get_string('topbarlogoareaon', 'theme_alphachild');
$description = get_string('topbarlogoareaon_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/customlogo';
$title = get_string('customlogo', 'theme_alphachild');
$description = get_string('customlogo_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png', '.jpg', '.svg', 'gif'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'customlogo', 0, $opts);
$page->add($setting);

$name = 'theme_alphachild/customdmlogo';
$title = get_string('customdmlogo', 'theme_alphachild');
$description = get_string('customdmlogo_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png', '.jpg', '.svg', 'gif'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'customdmlogo', 0, $opts);
$page->add($setting);

$name = 'theme_alphachild/logoandname';
$title = get_string('logoandname', 'theme_alphachild');
$description = get_string('logoandname_desc', 'theme_alphachild', $a);
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/customlogotxt';
$title = get_string('customlogotxt', 'theme_alphachild');
$description = get_string('customlogotxt_desc', 'theme_alphachild');
$default = 'alpha';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/topbarcustomhtml';
$title = get_string('topbarcustomhtml', 'theme_alphachild');
$description = get_string('topbarcustomhtml_desc', 'theme_alphachild', $a);
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$page->add($setting);

// Colors.
$name = 'theme_alphachild/htopbarcolors';
$heading = get_string('htopbarcolors', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading,
    format_text(get_string('htopbarcolors_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/colortopbarbg';
$title = get_string('colortopbarbg', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colortopbartext';
$title = get_string('colortopbartext', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colortopbarbtn';
$title = get_string('colortopbarbtn', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colortopbarbtntext';
$title = get_string('colortopbarbtntext', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colortopbarbtnhover';
$title = get_string('colortopbarbtnhover', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colortopbarbtnhovertext';
$title = get_string('colortopbarbtnhovertext', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
