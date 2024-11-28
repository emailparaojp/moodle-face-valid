<?php
require_once('../../config.php');
require_login();

// Verifique se o usuário tem permissões
$context = context_system::instance();
require_capability('moodle/site:config', $context);

// Recebe o ID da empresa a ser excluída
$id = required_param('id', PARAM_INT);

// Verifica se a empresa existe
if (!$empresa = $DB->get_record('local_empresa', array('id' => $id))) {
    print_error('Empresa inválida');
}

// Exclui a empresa
$DB->delete_records('local_empresa', array('id' => $id));

// Redireciona de volta à página principal com uma mensagem de sucesso
redirect(new moodle_url('/local/empresa/index.php'), 'Empresa excluída com sucesso');