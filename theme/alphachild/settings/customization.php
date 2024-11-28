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

$page = new admin_settingpage('theme_alphachild_customization', get_string('settingscustomization', 'theme_alphachild'));
$name = 'theme_alphachild/hgooglefont';
$heading = get_string('hgooglefont', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hgooglefont_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

// Google Font.
$name = 'theme_alphachild/googlefonturl';
$title = get_string('googlefonturl', 'theme_alphachild');
$description = get_string('googlefonturl_desc', 'theme_alphachild');
$default = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$page->add($setting);

$name = 'theme_alphachild/fontheadings';
$title = get_string('fontheadings', 'theme_alphachild');
$description = get_string('fontheadings_desc', 'theme_alphachild');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/fontweightheadings';
$title = get_string('fontweightheadings', 'theme_alphachild');
$description = get_string('fontweightheadings_desc', 'theme_alphachild');
$default = '700';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/fontbody';
$title = get_string('fontbody', 'theme_alphachild');
$description = get_string('fontbody_desc', 'theme_alphachild');
$default = "'Inter', sans-serif";
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/fontweightregular';
$title = get_string('fontweightregular', 'theme_alphachild');
$description = get_string('fontweightregular_desc', 'theme_alphachild');
$default = '400';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/fontweightmedium';
$title = get_string('fontweightmedium', 'theme_alphachild');
$description = get_string('fontweightmedium_desc', 'theme_alphachild');
$default = '500';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/fontweightbold';
$title = get_string('fontweightbold', 'theme_alphachild');
$description = get_string('fontweightbold_desc', 'theme_alphachild');
$default = '700';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hgeneral';
$heading = get_string('hgeneral', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hgeneral_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/colorbodybg';
$title = get_string('colorbodybg', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorborder';
$title = get_string('colorborder', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/btnborderradius';
$title = get_string('btnborderradius', 'theme_alphachild');
$description = get_string('btnborderradius_desc', 'theme_alphachild');
$setting = new admin_setting_configtext($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hcolorstxt';
$heading = get_string('hcolorstxt', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hcolorstxt_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/colorbody';
$title = get_string('colorbody', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorbodysecondary';
$title = get_string('colorbodysecondary', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorbodylight';
$title = get_string('colorbodylight', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorheadings';
$title = get_string('colorheadings', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorlink';
$title = get_string('colorlink', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorlinkhover';
$title = get_string('colorlinkhover', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hcolorsprimary';
$heading = get_string('hcolorsprimary', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading,
    format_text(get_string('hcolorsprimary_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/colorprimary600';
$title = get_string('colorprimary600', 'theme_alphachild');
$description = get_string('colorprimary_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary100';
$title = get_string('colorprimary100', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary200';
$title = get_string('colorprimary200', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary300';
$title = get_string('colorprimary300', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary400';
$title = get_string('colorprimary400', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary500';
$title = get_string('colorprimary500', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary700';
$title = get_string('colorprimary700', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary800';
$title = get_string('colorprimary800', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorprimary900';
$title = get_string('colorprimary900', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hcolorsgrays';
$heading = get_string('hcolorsgrays', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hcolorsgrays_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/colorgray100';
$title = get_string('colorgray100', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray200';
$title = get_string('colorgray200', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray300';
$title = get_string('colorgray300', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray400';
$title = get_string('colorgray400', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray500';
$title = get_string('colorgray500', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray600';
$title = get_string('colorgray600', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray700';
$title = get_string('colorgray700', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray800';
$title = get_string('colorgray800', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/colorgray900';
$title = get_string('colorgray900', 'theme_alphachild');
$description = get_string('color_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hdmgeneral';
$heading = get_string('hdmgeneral', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hgeneral_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/dmcolorbodybg';
$title = get_string('dmcolorbodybg', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorborder';
$title = get_string('dmcolorborder', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hdmcolorstxt';
$heading = get_string('hdmcolorstxt', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hdmcolorstxt_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/dmcolorbody';
$title = get_string('dmcolorbody', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorbodysecondary';
$title = get_string('dmcolorbodysecondary', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorbodylight';
$title = get_string('dmcolorbodylight', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorheadings';
$title = get_string('dmcolorheadings', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorlink';
$title = get_string('dmcolorlink', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorlinkhover';
$title = get_string('dmcolorlinkhover', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/hdmcolorsgrays';
$heading = get_string('hdmcolorsgrays', 'theme_alphachild');
$setting = new admin_setting_heading($name, $heading, format_text(get_string('hdmcolorsgrays_desc', 'theme_alphachild'), FORMAT_MARKDOWN));
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray100';
$title = get_string('dmcolorgray100', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray200';
$title = get_string('dmcolorgray200', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray300';
$title = get_string('dmcolorgray300', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray400';
$title = get_string('dmcolorgray400', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray500';
$title = get_string('dmcolorgray500', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray600';
$title = get_string('dmcolorgray600', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray700';
$title = get_string('dmcolorgray700', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray800';
$title = get_string('dmcolorgray800', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_alphachild/dmcolorgray900';
$title = get_string('dmcolorgray900', 'theme_alphachild');
$description = get_string('dmcolor_desc', 'theme_alphachild');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
