<?php
defined('MOODLE_INTERNAL') || die();

function quizaccess_mybiometricauth_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    // Implementa o acesso seguro a arquivos relacionados ao plugin.
    send_file_not_found();
}
