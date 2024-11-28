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
 * Helper for the quizaccess_faceserpro plugin.
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_faceserpro;

use CFPropertyList\CFPropertyList;
use ErrorException;
use pix_icon;
use quizaccess_seb\quiz_settings;


/**
 * Helper class.
 *
 * @package    quizaccess_faceserpro
 * @Copyright 2024 RCN
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helper {
    /**
     * Get a filler icon for display in the actions column of a table.
     *
     * @param string $url           the URL for the icon
     * @param string $icon          the icon identifier
     * @param string $alt           the alt text for the icon
     * @param string $iconcomponent the icon component
     * @param array  $options       display options
     *
     * @return string
     */
    public static function format_icon_link($url, $icon, $alt, $iconcomponent = 'moodle', $options = []) {
        global $OUTPUT;

        return $OUTPUT->action_icon(
            $url,
            new pix_icon($icon, $alt, $iconcomponent, [
                'title' => $alt,
            ]),
            null,
            $options
        );
    }

    /**
     * Validate faceserpro config string.
     *
     * @param string $faceserproconfig
     * @return bool
     */
    public static function is_valid_faceserpro_config(string $faceserproconfig): bool {
        $result = true;

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline); // NOSONAR.
        });

        $plist = new CFPropertyList();
        try {
            $plist->parse($faceserproconfig);
        } catch (\Exception $e) {
            $result = false;
        }

        restore_error_handler();

        return $result;
    }

    /**
     * A helper function to get a list of faceserpro config file headers.
     *
     * @param int|null $expiretime Unix timestamp
     */
    public static function get_faceserpro_file_headers(int $expiretime = null): array {
        if (is_null($expiretime)) {
            $expiretime = time();
        }
        $headers = [];
        $headers[] = 'Cache-Control: private, max-age=1, no-transform';
        $headers[] = 'Expires: '.gmdate('D, d M Y H:i:s', $expiretime).' GMT';
        $headers[] = 'Pragma: no-cache';
        $headers[] = 'Content-Disposition: attachment; filename=config.faceserpro';
        $headers[] = 'Content-Type: application/faceserpro';

        return $headers;
    }

    /**
     * Get faceserpro config content for a particular quiz. This method checks caps.
     *
     * @param string $cmid the course module ID for a quiz with config
     *
     * @return string SEB config string
     */
    public static function get_faceserpro_config_content(string $cmid): string {
        // Try and get the course module.
        $cm = get_coursemodule_from_id('quiz', $cmid, 0, false, MUST_EXIST);

        // Make sure the user is logged in and has access to the module.
        require_login($cm->course, false, $cm);

        // Retrieve the config for quiz.
        $config = quiz_settings::get_config_by_quiz_id($cm->instance);
        if (empty($config)) {
            throw new \moodle_exception('noconfigfound', 'quizaccess_faceserpro', '', $cm->id);
        }

        return $config;
    }

    /**
     * Serve a file to browser for download.
     *
     * @param string $contents contents of file
     */
    public static function send_faceserpro_config_file(string $contents) {
        // We can now send the file back to the browser.
        foreach (self::get_faceserpro_file_headers() as $header) {
            header($header);
        }

        echo $contents;
    }
}
