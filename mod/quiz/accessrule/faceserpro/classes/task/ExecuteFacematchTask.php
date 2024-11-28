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
// * @package    quizaccess_faceserpro
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace quizaccess_faceserpro\task;

use core\task\scheduled_task;
use Exception;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/quiz/accessrule/faceserpro/lib.php');

/**
 * Scheduled task to sychronize users data.
 * @package    quizaccess_faceserpro
 * @author     Brain station 23 ltd <brainstation-23.com>
 * @copyright  2021 Brain station 23 ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Scheduled task to sychronize users data.
 * @package    quizaccess_faceserpro
 * @author     Brain station 23 ltd <brainstation-23.com>
 * @copyright  2021 Brain station 23 ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ExecuteFacematchTask extends scheduled_task {
    /**
     * Returns name of task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('execute_facematch_task', 'quizaccess_faceserpro');
    }

    /**
     * Updates meetings that are not expired.
     *
     * @return boolean
     */
    public function execute() {
        global $DB, $CFG;
        mtrace('Initiate execute facematch task');
        try {
            execute_fm_task();
        } catch (Exception $exception) {
            mtrace('error in faceserpro execute facematch: '.$exception->getMessage());
        }
        return true;
    }
}
