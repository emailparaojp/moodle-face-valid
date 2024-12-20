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
 * quiz Moodle -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/quiz/lib.php');
require_once($CFG->libdir.'/adminlib.php');

$resetall = optional_param('resetall', null, PARAM_BOOL);

$header = "$SITE->shortname: ".get_string('quizhome')." (".get_string('quizpage', 'admin').")";

$PAGE->set_blocks_editing_capability('moodle/quiz:configsyspages');
admin_externalpage_setup('quizpage', '', null, '', array('pagelayout' => 'quizdashboard'));

if ($resetall && confirm_sesskey()) {
    quiz_reset_page_for_all_users(quiz_PAGE_PRIVATE, 'quiz-index');
    redirect($PAGE->url, get_string('alldashboardswerereset', 'quiz'));
}

// Override pagetype to show blocks properly.
$PAGE->set_pagetype('quiz-index');

$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->blocks->add_region('content');

// Get the quiz Moodle page info.  Should always return something unless the database is broken.
if (!$currentpage = quiz_get_page(null, quiz_PAGE_PRIVATE)) {
    print_error('quizmoodlesetup');
}
$PAGE->set_subpage($currentpage->id);

// Display a button to reset everyone's dashboard.
$url = new moodle_url($PAGE->url, array('resetall' => 1));
$button = $OUTPUT->single_button($url, get_string('reseteveryonesdashboard', 'quiz'));
$PAGE->set_button($button . $PAGE->button);

echo $OUTPUT->header();

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
