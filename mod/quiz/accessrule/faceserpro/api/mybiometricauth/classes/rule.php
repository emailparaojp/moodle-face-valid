<?php
namespace quizaccess_mybiometricauth;

defined('MOODLE_INTERNAL') || die();

class rule extends \quiz_access_rule {

    public static function make(\quiz $quizobj, $timenow, $canpreview) {
        // Verifica se a regra está ativa para o quiz.
        $enabled = (bool) $quizobj->get_quiz()->mybiometricauth_enabled;
        if ($enabled) {
            return new self($quizobj, $timenow);
        }
        return null;
    }

    public function description() {
        // Retorna uma descrição da regra de acesso.
        return get_string('pluginname', 'quizaccess_mybiometricauth');
    }

    public function prevent_access() {
        // Verifica se a autenticação foi concluída.
        if (!$this->user_has_validated()) {
            return get_string('accessdenied', 'quizaccess_mybiometricauth');
        }
        return false;
    }

    private function user_has_validated() {
        global $DB, $USER;

        // Verifica na tabela se o usuário validou a biometria.
        $record = $DB->get_record('quizaccess_mybiometricauth', ['userid' => $USER->id]);
        return $record && $record->status == 1;
    }
}
