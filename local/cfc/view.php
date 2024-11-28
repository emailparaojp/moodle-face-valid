<?php
require_once('../../config.php');
require_login();

// Verifica se o usuário tem a capacidade de visualizar a página específica de usuários
$context = context_system::instance();
$PAGE->set_url(new moodle_url('/local/cfc/view.php'));
$PAGE->set_context($context);
$PAGE->set_title('Gestão de CFC');
$PAGE->set_heading('Painel do Gestor');

// Renderiza o cabeçalho da página
echo $OUTPUT->header();

// Verifique se o usuário tem a capacidade de ver a página de usuários específicos
if (has_capability('local/cfc:viewuserpage', $context)) {
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
    // Exibe mensagem de erro se o usuário não tiver permissões
    echo '<p>Você não tem permissão para acessar esta área.</p>';
}

// Renderiza o rodapé da página
echo $OUTPUT->footer();