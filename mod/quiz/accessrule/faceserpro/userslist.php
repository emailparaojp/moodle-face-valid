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
 * User list for uploading image in quizaccess_faceserpro plugin.
  * Implementaton of the quizaccess_faceserpro plugin.
 * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../../config.php');
require_once(__DIR__ . '/lib.php');
global $CFG, $PAGE, $OUTPUT, $DB;
require_login();
if (!is_siteadmin()) {
    redirect($CFG->wwwroot, get_string('no_permission', 'quizaccess_faceserpro'), null, \core\output\notification::NOTIFY_ERROR);
}
$PAGE->set_url('/mod/quiz/accessrule/faceserpro/userslist.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('users_list', 'quizaccess_faceserpro'));
$PAGE->set_heading(get_string('users_list', 'quizaccess_faceserpro'));
echo $OUTPUT->header();
$faceserpropro = new moodle_url('/mod/quiz/accessrule/faceserpro/analyzeimage.php');
//faceserpro pro banner
$faceserproprogif = $OUTPUT->image_url('faceserpro_pro_users_list', 'quizaccess_faceserpro');
        echo "<div class='text-center'>";
        echo "<div class='text-center mt-4 mb-4 faceserpro_report_overlay_container   rounded' >";
        echo "<img src='" . $faceserproprogif . "' style='width: 75%;height:auto;'></img>";
        /*echo "<div class='faceserpro_report_overlay rounded'><a href='". $faceserpropro . "' target='_blank' class='btn btn-lg btn-primary'>
        " . get_string('buyfaceserpropro', 'quizaccess_faceserpro') . " &#x1F389; </a></div>";*/
        echo "</div>";
        echo "</div>";
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 5, PARAM_INT);
$sql = "SELECT * FROM {user}";
$users = $DB->get_records_sql($sql, [], $perpage * $page, $perpage);
foreach ($users as $user) {
    $user->image_url = quizaccess_faceserpro_get_image_url($user->id);
    if (strlen($user->image_url)) {
        $user->delete_image_url =
            $CFG->wwwroot . "/mod/quiz/accessrule/faceserpro/delete_user_image.php?userid=$user->id&perpage=$perpage&page=$page";
        $user->edit_image_url = $CFG->wwwroot . "/mod/quiz/accessrule/faceserpro/upload_image.php?id=$user->id";
    }
}
$totaluser = $DB->count_records('user');
$baseurl = new moodle_url('/mod/quiz/accessrule/faceserpro/userslist.php', array('perpage' => $perpage));
$templatecontext = (object)[
    'users' => array_values($users),
    'redirecturl' => new moodle_url('/mod/quiz/accessrule/faceserpro/upload_image.php'),
    'settingsurl' => new moodle_url('/admin/settings.php?section=modsettingsquizcatfaceserpro')
];
echo $OUTPUT->render_from_template('quizaccess_faceserpro/users_list', $templatecontext);
echo $OUTPUT->paging_bar($totaluser, $page, $perpage, $baseurl);
echo $OUTPUT->footer();
