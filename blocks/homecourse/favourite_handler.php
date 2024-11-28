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

 
require_once('../../config.php');

global $CFG, $DB, $USER;
 
$courseid = $_POST['id'];
$coursestatus = $_POST['action'];
$usercontext = \context_user::instance($USER->id);
$ufservice = \core_favourites\service_factory::get_service_for_user_context($usercontext);
 
if($courseid && $coursestatus == 'add-favourite'){
    $coursecontext = \context_course::instance($courseid);
    $favourite = $ufservice->create_favourite('core_course', 'courses', $courseid, $coursecontext);
    //echo $favourite;
}
elseif($courseid && $coursestatus == 'remove-favourite') {
    $coursecontext = \context_course::instance($courseid);
    $favourite = $ufservice->delete_favourite('core_course', 'courses', $courseid, $coursecontext);
    //echo $favourite;
}
else{
    echo false;
}
 header("Location: ".$CFG->wwwroot."/my");
