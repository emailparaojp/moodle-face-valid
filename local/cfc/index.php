<?php
require_once('../../config.php');

// Verifique se o usuário está logado e tem a capacidade necessária
require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

// Defina o URL da página de cadastro de empresa
$cadastro_empresa_url = new moodle_url('/local/cfc/newcfc.php');

// Renderize o cabeçalho da página
$PAGE->set_url(new moodle_url('/local/cfc/view.php'));
$PAGE->set_context($context);
$PAGE->set_title('Gerenciamento de CFCs');
$PAGE->set_heading('Gerenciamento de CFCs');
echo $OUTPUT->header();

$empresas = $DB->get_records('local_cfc');

// Verifica se existem empresas cadastradas
if ($empresas) {
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nome</th>';
    echo '<th>Razão Social</th>';
    echo '<th>CNPJ</th>';
    echo '<th>Gestor</th>';
    echo '<th>Cor</th>';
    echo '<th>Logo</th>';
    echo '<th>Ações</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($empresas as $empresa) {
        $editurl = new moodle_url('/local/cfc/editar_empresa.php', array('id' => $empresa->id));
        $deleteurl = new moodle_url('/local/cfc/excluir_empresa.php', array('id' => $empresa->id)); 
        // Recupera o arquivo de logo da empresa
        $fs = get_file_storage();
        $files = $fs->get_area_files(context_system::instance()->id, 'local_cfc', 'logo', $empresa->id, 'itemid', false);

        $logo_url = ''; // Inicializa a URL da logo

        // Verifica se há arquivos e define o primeiro arquivo encontrado como a logo
        foreach ($files as $file) {
            if (!$file->is_directory()) {
                $logo_url = moodle_url::make_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    $file->get_itemid(),
                    $file->get_filepath(),
                    $file->get_filename()
                );
                break; // Pega o primeiro arquivo, se houver mais de um
            }
        }

     
        

        echo '<tr>';
        echo '<td>' . $empresa->id . '</td>';
        echo '<td>' . $empresa->nome . '</td>';
        echo '<td>' . $empresa->razaosocial . '</td>';
        echo '<td>' . $empresa->cnpj . '</td>';
        echo '<td>' . $empresa->gestor . '</td>'; 
        echo '<td>' . $empresa->fundo . '</td>';
         // Exibir a logo se disponível
        if ($logo_url) {
            echo '<td><img src="' . $logo_url . '" alt="Logo" style="max-width: 50px; max-height: 50px;"></td>';
        } else {
            echo '<td>Sem logo</td>';
        }
        echo '<td>';
        echo html_writer::link($editurl, 'Editar', array('class' => 'btn btn-warning btn-sm')) . ' '; 
        echo html_writer::link($deleteurl, 'Excluir', array('class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Tem certeza que deseja excluir este CFC?");'));
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>Nenhum CFC cadastrado.</p>';
}


// Exibe o botão que redireciona para a página de cadastro
echo html_writer::link($cadastro_empresa_url, 'Cadastrar novo', array('class' => 'btn btn-primary'));

// Renderize o rodapé da página
echo $OUTPUT->footer();