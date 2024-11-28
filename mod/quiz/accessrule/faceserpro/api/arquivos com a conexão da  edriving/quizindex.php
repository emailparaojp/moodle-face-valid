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
 * quiz Moodle -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/quiz/lib.php');
require_once(__DIR__ . '/functions_serpro.php');
redirect_if_major_upgrade_required();
// TODO Add sesskey check to edit
$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);
require_login();
$hassiteconfig = has_capability('moodle/site:config', context_system::instance());
if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect(new moodle_url('/admin/index.php'));
}
$strquizmoodle = get_string('quizhome');
if (isguestuser()) {  // Force them to see system default, no editing allowed
    // If guests are not allowed quiz moodle, send them to front page.
    if (empty($CFG->allowguestquizmoodle)) {
        redirect(new moodle_url('/', array('redirect' => 0)));
    }
    $userid = null;
    $USER->editing = $edit = 0;  // Just in case
    $context = context_system::instance();
    $PAGE->set_blocks_editing_capability('moodle/quiz:configsyspages');  // unlikely :)
    $strguest = get_string('guest');
    $header = "$SITE->shortname: $strquizmoodle ($strguest)";
    $pagetitle = $header;
} else {        // We are trying to view or edit our own quiz Moodle page
    $userid = $USER->id;  // Owner of the page
    $context = context_user::instance($USER->id);
    $PAGE->set_blocks_editing_capability('moodle/quiz:manageblocks');
    $header = "$SITE->shortname: $strquizmoodle";
    $pagetitle = $strquizmoodle;
}
// Get the quiz Moodle page info.  Should always return something unless the database is broken.
if (!$currentpage = quiz_get_page($userid, quiz_PAGE_PRIVATE)) {
    print_error('quizmoodlesetup');
}
// echo '<pre>';
// print_r($_SESSION);
// exit();
if(isset($_SESSION['USER']->confirmed) && !$_SESSION['biometria_ok'] && $_SESSION['USER']->id != 2){
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
            file_put_contents("logs/" . $file_path_log, base64_decode(trim($data[1])));
            $fp = fopen('logs/console_log.txt', 'a+');
            $string_log = $name . ' ; ' . $result . "\n";
            fwrite($fp, $string_log);
            fclose($fp);
            if($biometria->biometria_face->similaridade >= 0.85) {
                $biometria_ok = true;
                $_SESSION["biometria_ok"] = true;
                $nome_usuario = $_SESSION['USER']->firstname . ' ' . $_SESSION['USER']->lastname;
                $fp = fopen(__DIR__ . '/serpro_report.csv', 'a+');
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
                    $fp = fopen('logs/' . $filename_error . '.txt', 'a+');
                    echo "<script>
                        alert('$r->message');
                    </script>";
                    fwrite($fp, $r->message . "\n\n");
                    fclose($fp);
                    file_put_contents("logs/" . $filename_error . '.jpg', base64_decode(trim($data[1])));
                }
            }else{
                $filename_error = $name . '_' . $id_aula . '.txt';
                $fp = fopen('logs/' . $filename_error, 'a+');
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
                <link rel="stylesheet" type="text/css" href="./css/styles.css" media="screen" />
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
                        <script src="script.js"></script>
                    </div>
                </div>
            </body>
        </html>
        <?php
        exit;
    }
}
// Start setting up the page
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/quiz/index.php', $params);
$PAGE->set_pagelayout('quizdashboard');
$PAGE->set_pagetype('quiz-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($header);
if (!isguestuser()) {   // Skip default home page for guests
    if (get_home_page() != HOMEPAGE_quiz) {
        if (optional_param('setdefaulthome', false, PARAM_BOOL)) {
            set_user_preference('user_home_page_preference', HOMEPAGE_quiz);
        } else if (!empty($CFG->defaulthomepage) && $CFG->defaulthomepage == HOMEPAGE_USER) {
            $frontpagenode = $PAGE->settingsnav->add(get_string('frontpagesettings'), null, navigation_node::TYPE_SETTING, null);
            $frontpagenode->force_open();
            $frontpagenode->add(get_string('makethisquizhome'), new moodle_url('/quiz/', array('setdefaulthome' => true)),
                    navigation_node::TYPE_SETTING);
        }
    }
}
// Toggle the editing state and switches
if (empty($CFG->forcedefaultquizmoodle) && $PAGE->user_allowed_editing()) {
    if ($reset !== null) {
        if (!is_null($userid)) {
            require_sesskey();
            if (!$currentpage = quiz_reset_page($userid, quiz_PAGE_PRIVATE)) {
                print_error('reseterror', 'quiz');
            }
            redirect(new moodle_url('/quiz'));
        }
    } else if ($edit !== null) {             // Editing state was specified
        $USER->editing = $edit;       // Change editing state
    } else {                          // Editing state is in session
        if ($currentpage->userid) {   // It's a page we can edit, so load from session
            if (!empty($USER->editing)) {
                $edit = 1;
            } else {
                $edit = 0;
            }
        } else {
            // For the page to display properly with the user context header the page blocks need to
            // be copied over to the user context.
            if (!$currentpage = quiz_copy_page($USER->id, quiz_PAGE_PRIVATE)) {
                print_error('quizmoodlesetup');
            }
            $context = context_user::instance($USER->id);
            $PAGE->set_context($context);
            $PAGE->set_subpage($currentpage->id);
            // It's a system page and they are not allowed to edit system pages
            $USER->editing = $edit = 0;          // Disable editing completely, just to be safe
        }
    }
    // Add button for editing page
    $params = array('edit' => !$edit);
    $resetbutton = '';
    $resetstring = get_string('resetpage', 'quiz');
    $reseturl = new moodle_url("$CFG->wwwroot/quiz/index.php", array('edit' => 1, 'reset' => 1));
    if (!$currentpage->userid) {
        // viewing a system page -- let the user customise it
        $editstring = get_string('updatequizmoodleon');
        $params['edit'] = 1;
    } else if (empty($edit)) {
        $editstring = get_string('updatequizmoodleon');
    } else {
        $editstring = get_string('updatequizmoodleoff');
        $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
    }
    $url = new moodle_url("$CFG->wwwroot/quiz/index.php", $params);
    $button = $OUTPUT->single_button($url, $editstring);
    $PAGE->set_button($resetbutton . $button);
} else {
    $USER->editing = $edit = 0;
}
echo $OUTPUT->header();
if (core_userfeedback::should_display_reminder()) {
    core_userfeedback::print_reminder_block();
}
echo $OUTPUT->custom_block_region('content');
echo $OUTPUT->footer();
// Trigger dashboard has been viewed event.
$eventparams = array('context' => $context);
$event = \core\event\dashboard_viewed::create($eventparams);
$event->trigger();
