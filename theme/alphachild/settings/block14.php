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

$page = new admin_settingpage('theme_alphachild_block14', get_string('settingsblock14', 'theme_alphachild'));

$name = 'theme_alphachild/displayblock14';
$title = get_string('turnon', 'theme_alphachild');
$description = get_string('displayblock14_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title .
    '<span class="badge badge-sq badge-dark ml-2">Block #14</span>', $description, $default);
$page->add($setting);

$name = 'theme_alphachild/block14class';
$title = get_string('additionalclass', 'theme_alphachild');
$description = get_string('additionalclass_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/block14textalign';
$title = get_string('block14textalign', 'theme_alphachild');
$description = get_string('block14textalign_desc', 'theme_alphachild');
$options = [];
$options['left'] = get_string('left', 'theme_alphachild');
$options['center'] = get_string('center', 'theme_alphachild');
$options['right'] = get_string('right', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, 'center', $options);
$page->add($setting);

$name = 'theme_alphachild/block14titlesize';
$title = get_string('blocktitlesize', 'theme_alphachild');
$description = get_string('blocktitlesize_desc', 'theme_alphachild');
$default = 1;
$choices = array(0 => 'Normal', 1 => 'Large', 2 => 'Extra Large');
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$page->add($setting);

$name = 'theme_alphachild/block14titlecolor';
$title = get_string('blocktitlecolor', 'theme_alphachild');
$description = get_string('blocktitlecolor_desc', 'theme_alphachild');
$default = 1;
$choices = array(0 => 'White', 1 => 'Black', 2 => 'Gradient');
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$page->add($setting);

$name = 'theme_alphachild/block14titleweight';
$title = get_string('blocktitleweight', 'theme_alphachild');
$description = get_string('blocktitleweight_desc', 'theme_alphachild');
$default = 1;
$choices = array(0 => 'Normal', 1 => 'Medium', 2 => 'Bold');
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$page->add($setting);

$name = 'theme_alphachild/displayhrblock14';
$title = get_string('displayblockhr', 'theme_alphachild');
$description = get_string('displayblockhr_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/block14introtitle';
$title = get_string('blockintrotitle', 'theme_alphachild');
$description = get_string('blockintrotitle_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/block14introcontent';
$title = get_string('blockintrocontent', 'theme_alphachild');
$description = get_string('blockintrocontent_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);


$name = 'theme_alphachild/block14htmlcontent';
$title = get_string('blockhtmlcontent', 'theme_alphachild');
$description = get_string('blockhtmlcontent_desc', 'theme_alphachild');
$default = '';
$setting = new alpha_setting_confightmleditor($name, $title, $description, $default);
$page->add($setting);

$fileid = 'block14bg';
$name = 'theme_alphachild/block14bg';
$title = get_string('block14bg', 'theme_alphachild');
$description = get_string('block14bg_desc', 'theme_alphachild');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
$setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/block14customcss';
$title = get_string('block14customcss', 'theme_alphachild');
$description = get_string('block14customcss_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$settings->add($page);
