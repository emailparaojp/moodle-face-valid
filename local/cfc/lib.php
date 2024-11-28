<?php
defined('MOODLE_INTERNAL') || die();
 

function local_cfc_create($nome, $descricao) {
    global $DB;
    
    $empresa = new stdClass();
    $empresa->nome = $nome;
    $empresa->descricao = $descricao;
    $empresa->data_criacao = time();
    
    return $DB->insert_record('local_cfc', $empresa);
}

function local_cfc_add_user($empresa_id, $user_id, $role = null) {
    global $DB;
    
    $user_empresa = new stdClass();
    $user_empresa->empresa_id = $empresa_id;
    $user_empresa->user_id = $user_id;
    $user_empresa->role = $role;
    
    return $DB->insert_record('local_cfc_users', $user_empresa);
}
function local_empresa_render_gestor_menu() {
    global $OUTPUT;

    // Verifica se o usuário tem a capacidade de ver o menu do gestor
    if (has_capability('local/cfc:viewuserpage', context_system::instance())) {
        echo '<h3>Menu do Gestor</h3>';
        echo '<ul class="nav nav-pills">';
        
        // Link para visualização de empresas
        echo '<li class="nav-item">';
        echo html_writer::link(new moodle_url('/local/cfc/index.php'), 'Visualizar Empresas', array('class' => 'nav-link'));
        echo '</li>';

        // Link para a página de usuários
        echo '<li class="nav-item">';
        echo html_writer::link(new moodle_url('/local/cfc/usuarios.php'), 'Gerenciar Usuários', array('class' => 'nav-link'));
        echo '</li>';

        echo '</ul>';
    } else {
        echo '<p>Você não tem permissão para acessar esta área.</p>';
    }
}

function local_cfc_extend_navigation(global_navigation $nav) {
    global $PAGE;

    // Obtém o contexto global
    $context = context_system::instance();

    // Verifica se o usuário tem a capacidade de ver o menu do gestor
    if (has_capability('local/cfc:viewuserpage', $context)) {

        // Adiciona um novo nó (seção) ao menu lateral principal
        $node = $nav->add(get_string('gestorsection', 'local_cfc'), null, navigation_node::TYPE_CONTAINER);

        // Adiciona o link para "Visualizar Empresas"
        $node->add(
            get_string('viewcompanies', 'local_cfc'),
            new moodle_url('/local/cfc/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            'viewcompanies',
            new pix_icon('i/course', '') // Ícone padrão do Moodle
        );

        // Adiciona o link para "Gerenciar Usuários"
        $node->add(
            get_string('manageusers', 'local_cfc'),
            new moodle_url('/local/cfc/usuarios.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            'manageusers',
            new pix_icon('i/users', '') // Ícone padrão de usuários
        );
    }
}

function local_cfc_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB, $USER;

    // Verifica se o contexto é o sistema
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    // Verifica se o filearea é o correto
    if ($filearea !== 'logo') {
        return false;
    }

    // Extrai o itemid (ID do registro) e o nome do arquivo dos argumentos
    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = '/' . implode('/', $args) . '/';

    // Obtém o arquivo do sistema de arquivos do Moodle
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_cfc', 'logo', $itemid, $filepath, $filename);

    // Verifica se o arquivo existe
    if (!$file || $file->is_directory()) {
        return false;
    }

    // Serve o arquivo
    send_stored_file($file, 0, 0, $forcedownload, $options);
}