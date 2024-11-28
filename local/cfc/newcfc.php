<?php
require_once('../../config.php');
require_once('cfcform.php');

// Verifica se o usuário tem permissão para acessar a página
require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$PAGE->set_url(new moodle_url('/local/cfc/newcfc.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('companyregister', 'local_cfc'));
$PAGE->set_heading(get_string('companyregister', 'local_cfc'));

$mform = new cfc_form();

// Processa o formulário
if ($mform->is_cancelled()) {
    // Se o usuário cancelou, redireciona
    redirect(new moodle_url('/local/cfc/'));
} else if ($data = $mform->get_data()) {
    global $DB, $USER;
 
    // Monta os dados para inserir ou atualizar na tabela
    $record = new stdClass();
    $record->id = isset($data->id) ? $data->id : 0;
    $record->nome = $data->nome;
    $record->razaosocial = $data->razaosocial;
    $record->cnpj = $data->cnpj;
    $record->gestor = $data->gestor;
    $record->fundo = $data->fundo;  
    $record->timecreated = time(); // Timestamp atual

    if ($record->id) {
        // Atualizar registro existente
        $DB->update_record('local_cfc', $record);
    } else {
        // Inserir novo registro
        $record->id = $DB->insert_record('local_cfc', $record);
    }

    // Define o contexto para o arquivo de logo (ajuste conforme necessário)
    $context = context_system::instance();
    $draftitemid = $data->logo; // Este é o item ID do arquivo temporário

    // Salva o arquivo de logo no sistema de arquivos do Moodle
    $fs = get_file_storage();
    file_save_draft_area_files(
        $draftitemid,
        $context->id,
        'local_cfc', // Componente do plugin
        'logo',      // Área de arquivos
        $record->id, // ID de referência do registro salvo
        array('subdirs' => false, 'maxfiles' => 1)
    );

    // Recupera o arquivo salvo para obter o nome do arquivo
    $files = $fs->get_area_files($context->id, 'local_cfc', 'logo', $record->id, 'itemid', false);
    foreach ($files as $file) {
        if (!$file->is_directory()) {
            $record->logo = $file->get_filename(); // Salva o nome do arquivo no campo 'logo'
            break;
        }
    }

    // Atualiza o registro com o nome do arquivo de logo
    $DB->update_record('local_cfc', $record);
    // Exibe mensagem de sucesso
    redirect(new moodle_url('/local/cfc/'), get_string('created', 'local_cfc'));
}

// Renderiza o formulário na página
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();