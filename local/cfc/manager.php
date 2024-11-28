<?php
require_once('../../config.php');
global $USER, $DB;
// Verifique se o usuário está logado e tem a capacidade necessária
require_login();
$context = context_system::instance();
require_capability('local/empresa:viewuserpage', $context);
 
$id = "";
$empresas = "";
$mycompany = $DB->get_field_sql('SELECT data from {user_info_data} as uid join {user_info_field} as uif on uif.id = uid.fieldid where uif.shortname = "empresa" and uid.userid = '.$USER->id.'');
if(isset($_GET['id']) && is_siteadmin()){
    $id = $_GET['id'];
    $empresas = $DB->get_records('local_empresa',array('id'=>$id));
}else if(isset($mycompany)){
    $empresas = $DB->get_records('local_empresa',array('nome'=>$mycompany));
    $id = $DB->get_field('local_empresa','id',array('nome'=>$mycompany));
}
// Renderize o cabeçalho da página
$PAGE->set_url(new moodle_url('/local/empresa/manager.php'));
$PAGE->set_context($context);
$PAGE->set_title('Gerenciamento da empresa');
$PAGE->set_heading('Gerenciamento da empresa');
echo $OUTPUT->header();
if(is_siteadmin()){
echo '<a class="btn btn-primary" href="index.php?section=local_empresa">Voltar</a>';
}
// Verifica se existem empresas cadastradas
if (!empty($empresas)) {
    echo '<div class="card"><table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nome</th>';
    echo '<th>Razão Social</th>';
    echo '<th>CNPJ</th>';
    echo '<th>Gestor</th>';
    echo '<th>Produto</th>';
    echo '<th>Página do linkedin</th>'; 
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($empresas as $empresa) {
        $editurl = new moodle_url('/local/empresa/editar_empresa.php', array('id' => $empresa->id));
        $deleteurl = new moodle_url('/local/empresa/excluir_empresa.php', array('id' => $empresa->id));
        $manageurl = new moodle_url('/local/empresa/manager.php', array('id' => $empresa->id));

        echo '<tr>';
        echo '<td>' . $empresa->id . '</td>';
        echo '<td>' . $empresa->nome . '</td>';
        echo '<td>' . $empresa->razaosocial . '</td>';
        echo '<td>' . $empresa->cnpj . '</td>';
        echo '<td>' . $empresa->gestor . '</td>';
        echo '<td>' . $empresa->product . '</td>';
        echo '<td>' . $empresa->linkedin . '</td>'; 
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table></div>';
    
    include('credits.php');
    include('users.php');
} else {
    echo '<p>Nenhuma empresa encontrada.</p>';
}

 

// Renderize o rodapé da página
echo $OUTPUT->footer();