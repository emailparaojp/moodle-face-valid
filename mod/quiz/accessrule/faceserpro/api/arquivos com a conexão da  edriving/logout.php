<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Logs the user out and sends them to the home page
 *
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../config.php');
require_once(__DIR__ . '/../quiz/functions_serpro.php');
$PAGE->set_url('/login/logout.php');
$PAGE->set_context(context_system::instance());
$sesskey = optional_param('sesskey', '__notpresent__', PARAM_RAW); // we want not null default to prevent required sesskey warning
$login   = optional_param('loginpage', 0, PARAM_BOOL);
// echo '<pre>';
// print_r($_SESSION);
// exit();
if(isset($_SESSION['USER']->confirmed) && $_SESSION['biometria_ok'] && $_SESSION['USER']->id != 2){
    $biometria_ok = false;
    if($_REQUEST['valida']) {
        if(!isset($_POST['base_img'])){
            die("{\"error\": \" Flopou. Cadê o base_img?\"}");
        }
        $result = array();
        $data = str_replace(" ", "+", $_POST['base_img']); // O envio do dado pelo XMLHttpRequest tende a trocar o + por espaço, por isso a necessidade de substituir.
        $data = explode(',', $data);
        $limpa_string = array('-', '.');
        $cpf = str_replace($limpa_string, "", $_SESSION['USER']->profile["CPF"]);
        $dados["key"]["cpf"] = $cpf;
        $dados["answer"]["biometria_face"] = trim($data[1]);
        $biometria = getBiometriaSerpro($dados);
        $name = $cpf . "-" . date("YmdHis");
        $path = "logs/{$name}.jpg";
        if($biometria->biometria_face) {
            $file_path_log = $name . '_' . $biometria->biometria_face->similaridade . '.jpg';
            file_put_contents(__DIR__ . "/../quiz/logs/" . $file_path_log, base64_decode(trim($data[1])));
            $fp = fopen(__DIR__ . '/../quiz/logs/console_log.txt', 'a+');
            $string_log = $name . ' ; ' . $result . "\n";
            fwrite($fp, $string_log);
            fclose($fp);
            if($biometria->biometria_face->similaridade >= 0.85) {
                $biometria_ok = true;
                $_SESSION["biometria_ok"] = true;
                $nome_usuario = $_SESSION['USER']->firstname . ' ' . $_SESSION['USER']->lastname;
                $fp = fopen(__DIR__ . '/../quiz/serpro_report.csv', 'a+');
                $string = $nome_usuario . ';' . $biometria->biometria_face->similaridade . ';' . $_SESSION['USER']->lastip . ';' . $_SESSION['USER']->currentlogin . ';' . "/../quiz/logs/{$file_path_log}" . ';' . $cpf;
                fwrite($fp, $string . "\n");
                fclose($fp);
            }else{
                echo "<script>
                    alert('BAIXO INDÍCE BIOMÉTRICO. Por favor, tente novamente.');
                </script>";
            }
        } else {
            if(is_array($biometria)) {
                foreach($biometria as $r){
                    $filename_error = $name . '_' . $r->code;
                    $fp = fopen(__DIR__ . '/../quiz/logs/' . $filename_error . '.txt', 'a+');
                    echo "<script>
                        alert('$r->message');
                    </script>";
                    fwrite($fp, $r->message . "\n\n");
                    fclose($fp);
                    file_put_contents(__DIR__ . "/../quiz/logs/" . $filename_error . '.jpg', base64_decode(trim($data[1])));
                }
            }else{
                $filename_error = $name . '_' . $id_aula . '.txt';
                $fp = fopen(__DIR__ . '/../quiz/logs/' . $filename_error, 'a+');
                fwrite($fp, serialize($biometria) . "\n\n");
                fclose($fp);
            }
        }
    }
    if(!$biometria_ok) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
            <head>
                <!--Título-->
                <title>DETRAN - Coleta de Biometria Facial</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="Validacao Biometria (Detran)"/>
                <!--OpenType-->
                <meta property="og:locale" content="pt_BR" />
                <meta property="og:type" content="website" />
                <meta property="og:title" content="Auto Escola E-Driving" />
                <meta property="og:description" content="Validacao Biometria (Detran)" />
                <meta property="og:url" content="" />
                <meta property="og:site_name" content="Auto Escola E-Driving" />
                <!--CSS-->
                <link rel="stylesheet" type="text/css" href="../quiz/css/styles.css" media="screen" />
            </head>
            <body>
                <div class="bloco">
                    <h2>De acordo com o que determina o Detran, você deve se autenticar</h2>
                    <h3> Aproxime o seu rosto e clique no botão validar biometria</h3>
                    <div class="area">
                        <video autoplay="true" id="webCamera">   </video>
                        <form method="POST">
                            <input  type="hidden" id="base_img" name="base_img">
                            <input type="submit" name="valida" value="Validar Biometria" onclick="takeSnapShot()">
                            <div class="mensagem">
                              <?= $mensagem_erro ?><br>
                            </div>
                        </form>
                        <img id="imagemConvertida"/>
                        <p id="caminhoImagem" class="caminho-imagem"><a href="" target="_blank"></a></p>
                        <!--Scripts-->
                        <script src="../quiz/script.js"></script>
                    </div>
                </div>
            </body>
        </html>
        <?php
        exit;
    }
}
// can be overridden by auth plugins
if ($login) {
    $redirect = get_login_url();
} else {
    $redirect = $CFG->wwwroot.'/';
}
if (!isloggedin()) {
    // no confirmation, user has already logged out
    require_logout();
    redirect($redirect);
} else if (!confirm_sesskey($sesskey)) {
    $PAGE->set_title($SITE->fullname);
    $PAGE->set_heading($SITE->fullname);
    echo $OUTPUT->header();
    echo $OUTPUT->confirm(get_string('logoutconfirm'), new moodle_url($PAGE->url, array('sesskey'=>sesskey())), $CFG->wwwroot.'/');
    echo $OUTPUT->footer();
    die;
}
$authsequence = get_enabled_auth_plugins(); // auths, in sequence
foreach($authsequence as $authname) {
    $authplugin = get_auth_plugin($authname);
    $authplugin->logoutpage_hook();
}
require_logout();
redirect($redirect);