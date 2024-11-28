<?php

// Inclua o arquivo de configuração do Moodle
require_once(__DIR__ . '/config.php');
require_once($CFG->dirroot . '/user/lib.php');

// ID do usuário ou outro critério de busca (como username ou email)
$userid = 2; // Substitua pelo ID do usuário que você deseja atualizar
$newpassword = 'pyoEXOvdf0aKu1C'; // Defina a nova senha

// Carregue os dados do usuário
$user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);

if ($user) {
    // Utilize a função do Moodle para atualizar a senha
    $updated = update_internal_user_password($user, $newpassword);
    
    if ($updated) {
        echo 'Senha atualizada com sucesso!';
    } else {
        echo 'Erro ao atualizar a senha.';
    }
} else {
    echo 'Usuário não encontrado.';
}