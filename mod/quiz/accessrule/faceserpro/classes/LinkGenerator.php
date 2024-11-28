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
 * Link Generator for the quizaccess_faceserpro plugin.
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_faceserpro;

use moodle_url;

/**
 * link_generator class.
 *
 * @Copyright 2024 RCN
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class LinkGenerator {

    /**
     * Get a link to force the download of the file over https or faceserpros protocols.
     *
     * @param string $courseid Course ID.
     * @param string $cmid Course module ID.
     * @param bool $faceserpro Whether to use a faceserpro:// scheme or fall back to http:// scheme.
     * @param bool $secure Whether to use HTTPS or HTTP protocol.
     * @return string A URL.
     */
    public static function get_link(string $courseid, string $cmid, $faceserpro = false, $secure = true) : string {
        // Check if course module exists.
        get_coursemodule_from_id('quiz', $cmid, 0, false, MUST_EXIST);

        $url = new moodle_url('/mod/quiz/accessrule/faceserpro/report.php?courseid=' . $courseid.'&cmid=' . $cmid);
        if ($faceserpro) {
            $secure ? $url->set_scheme('faceserpros') : $url->set_scheme('faceserpro');
        } else {
            $secure ? $url->set_scheme('https') : $url->set_scheme('http');
        }
        return $url->out();
    }
}
