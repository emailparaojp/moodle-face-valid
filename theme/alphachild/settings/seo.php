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

$page = new admin_settingpage('theme_alphachild_seo', get_string('seosettings', 'theme_alphachild'));

// Favicon setting.
$name = 'theme_alphachild/favicon';
$title = get_string('favicon', 'theme_alphachild');
$description = get_string('favicon_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.ico'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/favicon16';
$title = get_string('favicon16', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon16', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/favicon32';
$title = get_string('favicon32', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon32', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/faviconsafaritab';
$title = get_string('faviconsafaritab', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.svg'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'faviconsafaritab', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/faviconsafaritabcolor';
$title = get_string('faviconsafaritabcolor', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '#000000';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);


// Apple Touch Icon.
$name = 'theme_alphachild/seoappletouchicon';
$title = get_string('seoappletouchicon', 'theme_alphachild');
$description = get_string('seoappletouchicon_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'seoappletouchicon');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/seometadesc';
$title = get_string('seometadesc', 'theme_alphachild');
$description = get_string('seometadesc_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/seothemecolor';
$title = get_string('seothemecolor', 'theme_alphachild');
$description = get_string('seothemecolor_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

$settings->add($page);
