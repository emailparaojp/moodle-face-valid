<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_quizaccess_mybiometricauth_uninstall() {
    global $DB;

    // Remove a tabela personalizada usada pelo plugin.
    $DB->delete_records('quizaccess_mybiometricauth');
    return true;
}
