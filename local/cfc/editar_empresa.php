<?php
require_once('../../config.php');
require_once('empresa_form.php');
require_login();

// Verifique se o usuário tem permissões
$context = context_system::instance();
require_capability('moodle/site:config', $context);

// Recebe o ID da empresa a ser editada
$id = required_param('id', PARAM_INT);
 
 
// Busca a empresa pelo ID
if (!$empresa = $DB->get_record('local_empresa', array('id' => $id))) {
    print_error('Empresa inválida');
}

// Cria o formulário de edição
$mform = new empresa_form(null, array('edit' => true));

// Preenche o formulário com os dados da empresa
$mform->set_data($empresa);

// Processa o formulário após submissão
if ($mform->is_cancelled()) {
    // Se o usuário cancelar, redireciona para a página principal
    redirect(new moodle_url('/local/empresa/index.php'));
} else if ($data = $mform->get_data()) {
    // Atualiza os dados da empresa no banco de dados
    $data->id = $id; // Garante que o ID não seja alterado
    $DB->update_record('local_empresa', $data);

    // Redireciona para a página principal com uma mensagem de sucesso
    redirect(new moodle_url('/local/empresa/index.php'), 'Empresa atualizada com sucesso');
}

// Renderiza o formulário de edição
$PAGE->set_url(new moodle_url('/local/empresa/editar_empresa.php', array('id' => $id)));
$PAGE->set_context($context);
$PAGE->set_title('Editar Empresa');
$PAGE->set_heading('Editar Empresa');
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();