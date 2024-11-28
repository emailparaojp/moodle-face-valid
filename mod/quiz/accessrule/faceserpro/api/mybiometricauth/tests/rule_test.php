<?php
defined('MOODLE_INTERNAL') || die();

use quizaccess_mybiometricauth\rule;

class quizaccess_mybiometricauth_rule_testcase extends advanced_testcase {

    public function test_user_has_validated() {
        global $DB;

        $this->resetAfterTest(true);

        // Simula a criação de um registro.
        $DB->insert_record('quizaccess_mybiometricauth', [
            'userid' => 2,
            'status' => 1
        ]);

        $rule = new rule(null, time());
        $this->assertTrue($rule->user_has_validated());
    }
}
