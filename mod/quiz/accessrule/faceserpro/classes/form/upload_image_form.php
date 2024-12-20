<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.
/**
 * Form for image upload in quizaccess_faceserpro plugin.
 * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/formslib.php");
/**
 * Image upload form class.
 *
 * @package   quizaccess_faceserpro
 * @copyright 2022 Brain Station 23
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class imageupload_form extends moodleform {
    /**
     * Defines the form fields.
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!
        $html = '<div class="row">
        <div class="col-md">
        <strong class="pull-left">' . get_string('upload_image_title', 'quizaccess_faceserpro') . '</strong>
        </div>
        <div class="col-md">
        <a
            class="btn btn-outline-primary pull-right"
            href="'. $CFG->wwwroot . '/mod/quiz/accessrule/faceserpro/userslist.php">
            Back
        </a>
        </div>
        </div>';
        $mform->addElement('html', $html);
        $mform->addElement('header', 'username', 'name');
        $mform->addElement('hidden', 'id', 'User id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'face_image', 'Face Image');
        $mform->setType('face_image', PARAM_RAW);
        $mform->addElement('hidden', 'context_id', 'context id');
        $mform->setType('context_id', PARAM_INT);
        $mform->addElement(
            'filemanager',
            'user_photo',
            'image',
            null,
            array(
                'subdirs' => 0, 'maxfiles' => 1,
                'accepted_types' => array('png', 'jpg', 'jpeg')
            )
        ); // Add elements to your form.
        $mform->addRule('user_photo', get_string('provide_image', 'quizaccess_faceserpro'), 'required');
        $this->add_action_buttons();
    }
    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        // Custom validations can be added here.
        return array();
    }
}
