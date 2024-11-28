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
 * This file contains common functions for the dashboard and profile pages.
 *
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  */
define('quiz_PAGE_PUBLIC', 0);
define('quiz_PAGE_PRIVATE', 1);
// Inclui o arquivo de configuração do Moodle para definir $CFG
require_once(__DIR__ . '/../config.php');
// Verifica se $CFG está definido antes de tentar usá-lo
if (isset($CFG->libdir)) {
    require_once($CFG->libdir . '/blocklib.php');
}
/**
 * For a given user, this returns the $page information for their quiz Moodle page.
 */
function quiz_get_page($userid, $private = quiz_PAGE_PRIVATE) {
    global $DB, $CFG;
    if (empty($CFG->forcedefaultquizmoodle) && $userid) {
        if ($customised = $DB->get_record('quiz_pages', ['userid' => $userid, 'private' => $private])) {
            return $customised;
        }
    }
    return $DB->get_record('quiz_pages', ['userid' => null, 'name' => '__default', 'private' => $private]);
}
/**
 * This copies a system default page to the current user.
 */
function quiz_copy_page($userid, $private = quiz_PAGE_PRIVATE, $pagetype = 'quiz-index') {
    global $DB;
    if ($customised = $DB->get_record('quiz_pages', ['userid' => $userid, 'private' => $private])) {
        return $customised;
    }
    if (!$systempage = $DB->get_record('quiz_pages', ['userid' => null, 'private' => $private])) {
        return false;
    }
    $page = clone($systempage);
    unset($page->id);
    $page->userid = $userid;
    $page->id = $DB->insert_record('quiz_pages', $page);
    $systemcontext = context_system::instance();
    $usercontext = context_user::instance($userid);
    $blockinstances = $DB->get_records('block_instances', [
        'parentcontextid' => $systemcontext->id,
        'pagetypepattern' => $pagetype,
        'subpagepattern' => $systempage->id
    ]);
    $newblockinstanceids = [];
    foreach ($blockinstances as $instance) {
        $originalid = $instance->id;
        unset($instance->id);
        $instance->parentcontextid = $usercontext->id;
        $instance->subpagepattern = $page->id;
        $instance->timecreated = time();
        $instance->timemodified = $instance->timecreated;
        $instance->id = $DB->insert_record('block_instances', $instance);
        $newblockinstanceids[$originalid] = $instance->id;
        $blockcontext = context_block::instance($instance->id);
        $block = block_instance($instance->blockname, $instance);
        if (!$block->instance_copy($originalid)) {
            debugging("Unable to copy block-specific data for original block instance: $originalid
                to new block instance: $instance->id", DEBUG_DEVELOPER);
        }
    }
    if ($blockpositions = $DB->get_records('block_positions', [
        'subpage' => $systempage->id,
        'pagetype' => $pagetype,
        'contextid' => $systemcontext->id
    ])) {
        foreach ($blockpositions as &$positions) {
            $positions->subpage = $page->id;
            $positions->contextid = $usercontext->id;
            if (array_key_exists($positions->blockinstanceid, $newblockinstanceids)) {
                $positions->blockinstanceid = $newblockinstanceids[$positions->blockinstanceid];
            }
            unset($positions->id);
        }
        $DB->insert_records('block_positions', $blockpositions);
    }
    return $page;
}
/**
 * For a given user, this deletes their quiz Moodle page and returns them to the system default.
 */
function quiz_reset_page($userid, $private = quiz_PAGE_PRIVATE, $pagetype = 'quiz-index') {
    global $DB;
    $page = quiz_get_page($userid, $private);
    if ($page->userid == $userid) {
        $context = context_user::instance($userid);
        if ($blocks = $DB->get_records('block_instances', [
            'parentcontextid' => $context->id,
            'pagetypepattern' => $pagetype
        ])) {
            foreach ($blocks as $block) {
                if (is_null($block->subpagepattern) || $block->subpagepattern == $page->id) {
                    blocks_delete_instance($block);
                }
            }
        }
        $DB->delete_records('block_positions', ['subpage' => $page->id, 'pagetype' => $pagetype, 'contextid' => $context->id]);
        $DB->delete_records('quiz_pages', ['id' => $page->id]);
    }
    if (!$systempage = $DB->get_record('quiz_pages', ['userid' => null, 'private' => $private])) {
        return false;
    }
    $eventparams = [
        'context' => context_user::instance($userid),
        'other' => ['private' => $private, 'pagetype' => $pagetype]
    ];
    $event = \core\event\dashboard_reset::create($eventparams);
    $event->trigger();
    return $systempage;
}
