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
$page = new admin_settingpage('theme_alphachild_settingssidebar-nav', get_string('settingssidebar-nav', 'theme_alphachild'));

$name = 'theme_alphachild/isitemonsitehome';
$title = get_string('isitemonsitehome', 'theme_alphachild');
$description = get_string('isitemonsitehome_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/possitehome';
$title = get_string('possitehome', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 1;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/isitemondashboard';
$title = get_string('isitemondashboard', 'theme_alphachild');
$description = get_string('isitemondashboard_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/posdashboard';
$title = get_string('posdashboard', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 2;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/isitemoncalendar';
$title = get_string('isitemoncalendar', 'theme_alphachild');
$description = get_string('isitemoncalendar_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscalendar';
$title = get_string('poscalendar', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 3;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/isitemonprivatefiles';
$title = get_string('isitemonprivatefiles', 'theme_alphachild');
$description = get_string('isitemonprivatefiles_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/posprivatefiles';
$title = get_string('posprivatefiles', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 4;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/isitemoncontentbank';
$title = get_string('isitemoncontentbank', 'theme_alphachild');
$description = get_string('isitemoncontentbank_desc', 'theme_alphachild');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscontentbank';
$title = get_string('poscontentbank', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 5;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/isitemonmycourses';
$title = get_string('isitemonmycourses', 'theme_alphachild');
$description = get_string('isitemonmycourses_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/posmycourses';
$title = get_string('posmycourses', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 6;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

// Custom Item #1.
$name = 'theme_alphachild/hcustomitem1';
$heading = get_string('hcustomitem1', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('empty_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/iscustomitem1on';
$title = get_string('iscustomitem1on', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscustomitem1';
$title = get_string('poscustomitem1', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 7;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/labelcustomitem1';
$title = get_string('labelcustomitem1', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/iconcustomitem1';
$title = get_string('iconcustomitem1', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/urlcustomitem1';
$title = get_string('urlcustomitem1', 'theme_alphachild');
$description = get_string('urlcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

// Custom Item #2.
$name = 'theme_alphachild/hcustomitem2';
$heading = get_string('hcustomitem2', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('empty_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/iscustomitem2on';
$title = get_string('iscustomitem2on', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscustomitem2';
$title = get_string('poscustomitem2', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 8;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/labelcustomitem2';
$title = get_string('labelcustomitem2', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/iconcustomitem2';
$title = get_string('iconcustomitem2', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/urlcustomitem2';
$title = get_string('urlcustomitem2', 'theme_alphachild');
$description = get_string('urlcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

// Custom Item #3.
$name = 'theme_alphachild/hcustomitem3';
$heading = get_string('hcustomitem3', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('empty_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/iscustomitem3on';
$title = get_string('iscustomitem3on', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscustomitem3';
$title = get_string('poscustomitem3', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 9;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/labelcustomitem3';
$title = get_string('labelcustomitem3', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/iconcustomitem3';
$title = get_string('iconcustomitem3', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/urlcustomitem3';
$title = get_string('urlcustomitem3', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

// Custom Item #4.
$name = 'theme_alphachild/hcustomitem4';
$heading = get_string('hcustomitem4', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('empty_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/iscustomitem4on';
$title = get_string('iscustomitem4on', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscustomitem4';
$title = get_string('poscustomitem4', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 10;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/labelcustomitem4';
$title = get_string('labelcustomitem4', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/iconcustomitem4';
$title = get_string('iconcustomitem4', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/urlcustomitem4';
$title = get_string('urlcustomitem4', 'theme_alphachild');
$description = get_string('urlcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

// Custom Item #5.
$name = 'theme_alphachild/hcustomitem5';
$heading = get_string('hcustomitem5', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('empty_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/iscustomitem5on';
$title = get_string('iscustomitem5on', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/poscustomitem5';
$title = get_string('poscustomitem5', 'theme_alphachild');
$description = get_string('navposition_desc', 'theme_alphachild');
$default = 11;
$options = array();
for ($i = 1; $i <= 11; $i++) {
    $options[$i] = $i;
}
$setting = new admin_setting_configselect($name, $title, $description, $default, $options);
$page->add($setting);

$name = 'theme_alphachild/labelcustomitem5';
$title = get_string('labelcustomitem5', 'theme_alphachild');
$description = get_string('empty_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/iconcustomitem5';
$title = get_string('iconcustomitem5', 'theme_alphachild');
$description = get_string('iconcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/urlcustomitem5';
$title = get_string('urlcustomitem5', 'theme_alphachild');
$description = get_string('urlcustomitem_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/customnavitems';
$title = get_string('customnavitems', 'theme_alphachild');
$description = get_string('customnavitems_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
