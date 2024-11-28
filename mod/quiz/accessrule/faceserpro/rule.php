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
 * Implementaton for the quizaccess_faceserpro plugin.
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
// In moodle 4.2 or higher there is an update for access rule base class.
if (class_exists('\mod_quiz\local\access_rule_base')) {
    // If the moodle version is 4.2 or higher.
    class_alias('\mod_quiz\local\access_rule_base', '\quizaccess_faceserpro_parent_class_alias');
    class_alias('\mod_quiz\form\preflight_check_form', '\quizaccess_faceserpro_preflight_form_alias');
} else {
    require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');
    class_alias('\quiz_access_rule_base', '\quizaccess_faceserpro_parent_class_alias');
    class_alias('\mod_quiz_preflight_check_form', '\quizaccess_faceserpro_preflight_form_alias');
}
/**
 * quizaccess_faceserpro.
 */
class quizaccess_faceserpro extends quizaccess_faceserpro_parent_class_alias {
    /**
     * Check is preflight check is required.
     *
     * @param mixed $attemptid
     *
     * @return bool
     */
    public function is_preflight_check_required($attemptid) {
        $script = $this->get_topmost_script();
        $base = basename($script);
        return $base == 'view.php';
    }
    /**
     * Get topmost script path.
     *
     * @return string
     *
     * @throws coding_exception
     */
    public function get_topmost_script() {
        $backtrace = debug_backtrace(
            defined('DEBUG_BACKTRACE_IGNORE_ARGS')
                ? DEBUG_BACKTRACE_IGNORE_ARGS
                : false);
        $topframe = array_pop($backtrace);
        return $topframe['file'];
    }
    /**
     * Get_courseid_cmid_from_preflight_form.
     *
     * @param quizaccess_faceserpro_preflight_form_alias $quizform
     * @return array
     *
     * @throws coding_exception
     */
    public function get_courseid_cmid_from_preflight_form(quizaccess_faceserpro_preflight_form_alias $quizform) {
        $response = [];
        $response['courseid'] = $this->quiz->course;
        $response['quizid'] = $this->quiz->id;
        $response['cmid'] = $this->quiz->cmid;
        return $response;
    }
    /**
     * Makes the modal content
     *
     * @param $quizform
     * @param $faceidcheck
     * @return string
     *
     * @throws coding_exception
     */
    public function make_modal_content($quizform, $faceidcheck) {
        global $USER, $OUTPUT;
        $headercontent = get_string('openwebcam', 'quizaccess_faceserpro');
        $header = "$headercontent";
        $camhtml = get_string('camhtml', 'quizaccess_faceserpro');
        $faceserprostatement = get_string('faceserprostatement', 'quizaccess_faceserpro');
        if ($faceidcheck == '1') {
            $html = "<div class='container'>
                        <div class='row'>
                            <div class='col font-weight-bold'>* $header</div>
                        </div>
                        <div class='row'>
                            <div class='col font-weight-bold'>( $faceserprostatement</div>
                        </div>
                        <div class='row'>
                            <div class='col'>
                                <div class='container-fluid'>
                                    <div class='row justify-content-center align-items-center'>
                                        <div class='col-12' style='
                                            background-color: #000;
                                            border: 1px solid #ccc;
                                            border-radius: 10px;
                                            overflow: hidden;
                                            padding: 5px;
                                        '>
                                            <video class='img-fluid' id='video' style='background-color: black;'>Video stream not available.</video>
                                        </div>
                                    </div>
                                </div>
                                <canvas style='display: none;' id='canvas'></canvas>
                                <img style='display: none; max-width: 100%; height: auto; margin-top: 20px;' id='photo' alt='The screen capture will appear in this box.' />
                            </div>
                        </div>
                    </div>";
        } else {
            $html = "<div class='container'>
                        <div class='row'>
                            <div class='col font-weight-bold'>* $header</div>
                        </div>
                        <div class='row'>
                            <div class='col font-weight-bold'>* $faceserprostatement</div>
                        </div>
                        <div class='row'>
                            <div class='col'>
                            <div class='container-fluid'>
                            <div class='row justify-content-center align-items-center'>
                                <div class='col-12' style='
                                    background-color: #00f0;
                                    border: 1px solid #ccc;
                                    border-radius: 4px;
                                    overflow: hidden;
                                    padding: 5px;
                                '>
                                        <video class='img-fluid' id='video' style='background-color: black; max-width: 100%; height: auto;'>Video stream not available.</video>
                                        </div>
                                    </div>
                                </div>
                            <canvas style='display: none;' id='canvas'></canvas>
                            <img style='display: none; max-width: 100%; height: auto; margin-top: 20px;' id='photo' alt='The screen capture will appear in this box.' />
                            </div>
                        </div>
                    </div>";
        }
        return $html;
    }
    /**
     * add_preflight_check_form_fields.
     *
     * @param quizaccess_faceserpro_preflight_form_alias $quizform
     * @param mixed $mform
     * @param mixed $attemptid
     *
     * @return void
     *
     * @throws coding_exception
     */
    public function add_preflight_check_form_fields(quizaccess_faceserpro_preflight_form_alias $quizform,
                                                        MoodleQuickForm $mform, $attemptid) {
        global $PAGE, $DB, $USER, $CFG;
        $actionbtns = "";
        $coursedata = $this->get_courseid_cmid_from_preflight_form($quizform);
        // Get Screenshot Delay and Image Width.
        $imagedelaysql = "SELECT * FROM {config_plugins}
                        WHERE plugin = 'quizaccess_faceserpro'
                        AND name = 'autoreconfigurecamshotdelay'";
        $delaydata = $DB->get_record_sql($imagedelaysql);
        $camshotdelay = (int)$delaydata->value * 1000;
        if ($camshotdelay == 0) {
            $camshotdelay = 30 * 1000;
        }
        $faceidquery = "SELECT * FROM {config_plugins}
                        WHERE plugin = 'quizaccess_faceserpro'
                        AND name = 'fcheckstartchk'";
        $faceidrow = $DB->get_record_sql($faceidquery);
        $faceidcheck = $faceidrow->value;
        $imagewidth = get_config('quizaccess_faceserpro', 'autoreconfigureimagewidth');
        $examurl = new moodle_url('/mod/quiz/startattempt.php');
        $record = [];
        $record['id'] = 0;
        $record['courseid'] = (int)$coursedata['courseid'];
        $record['cmid'] = (int)$coursedata['cmid'];
        $record['attemptid'] = $attemptid;
        $record['imagewidth'] = $imagewidth;
        $record['screenshotinterval'] = $camshotdelay;
        $record['examurl'] = $examurl->__toString();
        $fcmethod = get_config('quizaccess_faceserpro', 'fcmethod');
        $modelurl = null;
        if ($fcmethod == "BS") {
            $modelurl = $CFG->wwwroot . '/mod/quiz/accessrule/faceserpro/thirdpartylibs/models';
            $PAGE->requires->js("/mod/quiz/accessrule/faceserpro/amd/build/face-api.min.js", true);
        }
        $PAGE->requires->js_call_amd('quizaccess_faceserpro/startAttempt', 'setup', [$record, $modelurl]);
        $mform->addElement('html', "<div class='quiz-check-form'>");
        $profileimageurl = '';
        if ($USER->picture) {
            $profileimageurl = new moodle_url('/user/pix.php/' . $USER->id . '/f1.jpg');
        }
        $coursedata = $this->get_courseid_cmid_from_preflight_form($quizform);
        $hiddenvalue = '<input type="hidden" id="courseidval" value="' . $coursedata['courseid'] . '"/>
                        <input type="hidden" id="cmidval" value="' . $coursedata['cmid'] . '"/>
                        <input type="hidden" id="profileimage" value="' . $profileimageurl . '"/>';
        $modalcontent = $this->make_modal_content($quizform, $faceidcheck);
        $facevalidationlabel = get_string('modal:facevalidation', 'quizaccess_faceserpro');
        $pending = get_string('modal:pending', 'quizaccess_faceserpro');
        $validateface = get_string('modal:validateface', 'quizaccess_faceserpro');
        if ($faceidcheck == '1') {
            $actionbtns = "$facevalidationlabel&nbsp<span id='face_validation_result'>$pending</span>"
                . "<button id='fcvalidate' class='btn btn-primary mt-3' style='"
                . " display: flex; justify-content: center;align-items: center;'>
                                <div class='loadingspinner' id='loading_spinner'></div>
                                $validateface
                           </button>";
        }
        $actionbtnhtml = "<div class='container'><div class='row'><div class='col'>$actionbtns</div></div></div>";
        $mform->addElement('html', $modalcontent);
        $mform->addElement('static', 'actionbtns', '', $actionbtnhtml);
        if ($faceidcheck == '1') {
            $mform->addElement('html', '<div id="form_activate" style="visibility: hidden">');
        }
        $mform->addElement('checkbox', 'faceserpro', '', get_string('faceserprolabel', 'quizaccess_faceserpro'));
        if ($faceidcheck == '1') {
            $mform->addElement('html', '</div>');
        }
        $mform->addElement('html', $hiddenvalue);
        $mform->addElement('html', '</div>');
    }
    /**
     * Validate the preflight check.
     *
     * @param mixed $data
     * @param mixed $files
     * @param mixed $errors
     * @param mixed $attemptid
     *
     * @return mixed $errors
     *
     * @throws coding_exception
     */
    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        if (empty($data['faceserpro'])) {
            $errors['faceserpro'] = get_string('youmustagree', 'quizaccess_faceserpro');
        }
        return $errors;
    }
    /**
     * * Information, such as might be shown on the quiz view page, relating to this restriction.
     * There is no obligation to return anything. If it is not appropriate to tell students
     * about this rule, then just return ''.
     *
     * @param mixed $quizobj
     * @param int $timenow
     * @param bool $canignoretimelimits
     *
     * @return quiz_access_rule_base|quizaccess_faceserpro|null
     */
    public static function make($quizobj, $timenow, $canignoretimelimits) {
        if (empty($quizobj->get_quiz()->faceserprorequired)) {
            return null;
        }
        return new self($quizobj, $timenow);
    }
    /**
     * Add any fields that this rule requires to the quiz settings form. This
     * method is called from mod_quiz_mod_form::definition(), while the
     * security section is being built.
     *
     * @param mod_quiz_mod_form $quizform the quiz settings form that is being built
     * @param MoodleQuickForm $mform the wrapped MoodleQuickForm
     *
     * @throws coding_exception
     */
    public static function add_settings_form_fields($quizform, MoodleQuickForm $mform) {
        $mform->addElement('select', 'faceserprorequired',
            get_string('faceserprorequired', 'quizaccess_faceserpro'),
            [
                0 => get_string('notrequired', 'quizaccess_faceserpro'),
                1 => get_string('faceserprorequiredoption', 'quizaccess_faceserpro'),
            ]);
        $mform->addHelpButton('faceserprorequired', 'faceserprorequired', 'quizaccess_faceserpro');
    }
    /**
     * Save any submitted settings when the quiz settings form is submitted. This
     * is called from quiz_after_add_or_update() in lib.php.
     *
     * @param object $quiz the data from the quiz form, including $quiz->id
     *                     which is the id of the quiz being saved
     *
     * @throws dml_exception
     */
    public static function save_settings($quiz) {
        global $DB;
        if (empty($quiz->faceserprorequired)) {
            $DB->delete_records('quizaccess_faceserpro', ['quizid' => $quiz->id]);
        } else {
            if (!$DB->record_exists('quizaccess_faceserpro', ['quizid' => $quiz->id])) {
                $record = new stdClass();
                $record->quizid = $quiz->id;
                $record->faceserprorequired = 1;
                $DB->insert_record('quizaccess_faceserpro', $record);
            }
        }
    }
    /**
     * Delete any rule-specific settings when the quiz is deleted. This is called
     * from quiz_delete_instance() in lib.php.
     *
     * @param object $quiz the data from the database, including $quiz->id
     *                     which is the id of the quiz being deleted
     *
     * @throws dml_exception
     */
    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_faceserpro', ['quizid' => $quiz->id]);
    }
    /**
     * Return the bits of SQL needed to load all the settings from all the access
     * plugins in one DB query. The easiest way to understand what you need to do
     * here is probalby to read the code of quiz_access_manager::load_settings().
     *
     * If you have some settings that cannot be loaded in this way, then you can
     * use the get_extra_settings() method instead, but that has
     * performance implications.
     *
     * @param int $quizid the id of the quiz we are loading settings for. This
     *                    can also be accessed as quiz.id in the SQL. (quiz is a table alisas for {quiz}.)
     *
     * @return array with three elements:
     *               1. fields: any fields to add to the select list. These should be alised
     *               if neccessary so that the field name starts the name of the plugin.
     *               2. joins: any joins (should probably be LEFT JOINS) with other tables that
     *               are needed.
     *               3. params: array of placeholder values that are needed by the SQL. You must
     *               used named placeholders, and the placeholder names should start with the
     *               plugin name, to avoid collisions.
     */
    public static function get_settings_sql($quizid) {
        return [
            'faceserprorequired',
            'LEFT JOIN {quizaccess_faceserpro} faceserpro ON faceserpro.quizid = quiz.id',
            [], ];
    }
    /**
     * Information, such as might be shown on the quiz view page, relating to this restriction.
     * There is no obligation to return anything. If it is not appropriate to tell students
     * about this rule, then just return ''.
     *
     * @return mixed a message, or array of messages, explaining the restriction
     *               (may be '' if no message is appropriate)
     *
     * @throws coding_exception
     */
    public function description() {
        global $PAGE;
        $record = new stdClass();
        $record->allowcamerawarning = get_string('warning:cameraallowwarning', 'quizaccess_faceserpro');
        $PAGE->requires->js_call_amd('quizaccess_faceserpro/faceserpro', 'init', [$record]);
        $messages = [get_string('faceserproheader', 'quizaccess_faceserpro')];
        $messages[] = $this->get_download_config_button();
        return $messages;
    }
    /**
     * Sets up the attempt (review or summary) page with any special extra
     * properties required by this rule.
     *
     * @param moodle_page $page the page object to initialise
     *
     * @throws coding_exception
     * @throws dml_exception
     */
    public function setup_attempt_page($page) {
        $cmid = optional_param('cmid', '', PARAM_INT);
        $attempt = optional_param('attempt', '', PARAM_INT);
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_popup_notification_allowed(false); // Prevent message notifications.
        $page->set_heading($page->title);
        global $CFG, $DB, $COURSE, $USER;
        if ($cmid) {
            $contextquiz = $DB->get_record('course_modules', ['id' => $cmid]);
            $record = new stdClass();
            $record->courseid = $COURSE->id;
            $record->quizid = $contextquiz->id;
            $record->userid = $USER->id;
            $record->webcampicture = '';
            $record->status = $attempt;
            $record->timemodified = time();
            $record->id = $DB->insert_record('quizaccess_faceserpro_logs', $record, true);
            // Get Screenshot Delay and Image Width.
            $imagedelaysql = "SELECT * FROM {config_plugins}
            WHERE plugin = 'quizaccess_faceserpro' AND name = 'autoreconfigurecamshotdelay'";
            $delaydata = $DB->get_records_sql($imagedelaysql);
            $camshotdelay = 30 * 1000;
            if (count($delaydata) > 0) {
                foreach ($delaydata as $row) {
                    $camshotdelay = (int)$row->value * 1000;
                }
            }
            $imagesizesql = "SELECT * FROM {config_plugins}
            WHERE plugin = 'quizaccess_faceserpro' AND name = 'autoreconfigureimagewidth'";
            $imagesizedata = $DB->get_records_sql($imagesizesql);
            $imagewidth = 230;
            if (count($imagesizedata) > 0) {
                foreach ($imagesizedata as $row) {
                    $imagewidth = (int)$row->value;
                }
            }
            $screensharesql = "SELECT * FROM {config_plugins}
                        WHERE plugin = 'quizaccess_faceserpro'
                        AND name = 'screenshareenable'";
            $screensharerow = $DB->get_record_sql($screensharesql);
            $enablescreenshare = $screensharerow->value;
            $quizurl = new moodle_url('/mod/quiz/view.php', ['id' => $cmid]);
            $record->camshotdelay = $camshotdelay;
            $record->image_width = $imagewidth;
            $record->quizurl = $quizurl->__toString();
            $record->enablescreenshare = $enablescreenshare;
            $fcmethod = get_config('quizaccess_faceserpro', 'fcmethod');
            $modelurl = null;
            if ($fcmethod == "BS") {
                $modelurl = $CFG->wwwroot . '/mod/quiz/accessrule/faceserpro/thirdpartylibs/models';
                $page->requires->js("/mod/quiz/accessrule/faceserpro/amd/build/face-api.min.js", true);
            }
            $page->requires->js_call_amd('quizaccess_faceserpro/faceserpro', 'setup', [$record, $modelurl]);
        }
    }
    /**
     * Get a button to view the faceserpro report.
     *
     * @return string A link to view report
     *
     * @throws coding_exception
     */
    private function get_download_config_button(): string {
        global $OUTPUT, $USER;
        $context = context_module::instance($this->quiz->cmid, MUST_EXIST);
        if (has_capability('quizaccess/faceserpro:viewreport', $context, $USER->id)) {
            $httplink = \quizaccess_faceserpro\LinkGenerator::get_link($this->quiz->course, $this->quiz->cmid, false, is_https());
            return $OUTPUT->single_button($httplink, get_string('picturesreport', 'quizaccess_faceserpro'), 'get');
        } else {
            return '';
        }
    }
}
