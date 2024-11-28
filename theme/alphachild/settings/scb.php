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

// Content Builder.
$page = new admin_settingpage('theme_alphachild_scb', get_string('scbsettings', 'theme_alphachild'));

$slotsarray = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6",
    "7" => "7",
    "8" => "8",
    "9" => "9",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22"
);
$name = 'theme_alphachild/block0';
$title = get_string('block0', 'theme_alphachild');
$description = get_string('block0_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '2', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block1';
$title = get_string('block1', 'theme_alphachild');
$description = get_string('block1_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '1', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block2';
$title = get_string('block2', 'theme_alphachild');
$description = get_string('block2_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '2', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block3';
$title = get_string('block3', 'theme_alphachild');
$description = get_string('block3_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '3', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block4';
$title = get_string('block4', 'theme_alphachild');
$description = get_string('block4_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '4', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block5';
$title = get_string('block5', 'theme_alphachild');
$description = get_string('block5_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '5', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block6';
$title = get_string('block6', 'theme_alphachild');
$description = get_string('block6_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '6', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block7';
$title = get_string('block7', 'theme_alphachild');
$description = get_string('block7_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '7', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block8';
$title = get_string('block8', 'theme_alphachild');
$description = get_string('block8_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '8', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block9';
$title = get_string('block9', 'theme_alphachild');
$description = get_string('block9_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '9', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block10';
$title = get_string('block10', 'theme_alphachild');
$description = get_string('block10_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '10', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block11';
$title = get_string('block11', 'theme_alphachild');
$description = get_string('block11_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '11', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block12';
$title = get_string('block12', 'theme_alphachild');
$description = get_string('block12_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '12', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block13';
$title = get_string('block13', 'theme_alphachild');
$description = get_string('block13_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '13', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block14';
$title = get_string('block14', 'theme_alphachild');
$description = get_string('block14_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '14', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block15';
$title = get_string('block15', 'theme_alphachild');
$description = get_string('block15_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '15', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block16';
$title = get_string('block16', 'theme_alphachild');
$description = get_string('block16_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '16', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block17';
$title = get_string('block17', 'theme_alphachild');
$description = get_string('block17_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '17', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block18';
$title = get_string('block18', 'theme_alphachild');
$description = get_string('block18_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '18', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block19';
$title = get_string('block19', 'theme_alphachild');
$description = get_string('block19_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '19', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block20';
$title = get_string('block20', 'theme_alphachild');
$description = get_string('block20_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '1', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block21';
$title = get_string('block21', 'theme_alphachild');
$description = get_string('block21_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '2', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block22';
$title = get_string('block22', 'theme_alphachild');
$description = get_string('block22_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '3', $slotsarray);
$page->add($setting);

$name = 'theme_alphachild/block23';
$title = get_string('block23', 'theme_alphachild');
$description = get_string('block23_desc', 'theme_alphachild');
$setting = new admin_setting_configselect($name, $title, $description, '4', $slotsarray);
$page->add($setting);

$settings->add($page);
