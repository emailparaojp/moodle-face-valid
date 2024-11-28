<?php
// Este arquivo faz parte do Moodle - http://moodle.org/
//
// O Moodle é um software livre: você pode redistribuí-lo e/ou modificá-lo
// sob os termos da Licença Pública Geral GNU conforme publicada pela
// Free Software Foundation, tanto a versão 3 da Licença, como (a seu critério)
// qualquer versão posterior.
//
// O Moodle é distribuído na esperança de que seja útil,
// mas SEM QUALQUER GARANTIA; sem mesmo a garantia implícita de
// COMERCIALIZAÇÃO ou ADEQUAÇÃO A UM DETERMINADO FIM. Consulte a
// Licença Pública Geral GNU para mais detalhes.
//
// Você deve ter recebido uma cópia da Licença Pública Geral GNU
// junto com o Moodle. Se não, veja <http://www.gnu.org/licenses/>.
/**
 * Strings Portugues pt_br para o plugin quizaccess_faceserpro.
/**
  * @package    quizaccess_faceserpro
 * @subpackage Quiz_moodle
 * @copyright  RCN 2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
$string['faceserprorequired_help'] = 'Se você habilitar esta opção, os alunos não poderão iniciar uma tentativa até que marquem uma caixa de seleção confirmando que estão cientes da política sobre o uso da webcam.';
$string['faceserprorequiredoption'] = 'deve ser reconhecido antes de iniciar uma tentativa';
$string['notrequired'] = 'não é necessário';
$string['privacy:metadata'] = 'Não compartilhamos nenhum dado pessoal com terceiros.';
$string['faceserproheader'] = '<strong>Para continuar com esta tentativa de quiz, você deve abrir sua webcam, que tirará algumas fotos suas aleatoriamente durante o teste.</strong>';
$string['faceserprolabel'] = 'Eu concordo com o processo de validação.';
$string['screensharemsg'] = '';
$string['screenhtml'] = '<span><video style="display: none" width="100" id="video-screen" autoplay></video></span><canvas id="canvas-screen" style="display:none;"></canvas><img id="photo-screen" alt="A imagem aparecerá nesta caixa." style="display:none;"/><span class="output-screen" style="display:none;"></span><span id="log-screen" style="display:none;"></span>';
$string['faceserprostatement'] = 'Este exame requer acesso à webcam.<br />(Por favor, permita o acesso à webcam).';
$string['camhtml'] = '<div class="camera"> <video width="100" id="video">Fluxo de vídeo não disponível.</video></div> <canvas id="canvas" style="display:none;"></canvas> <img style="display:none;" id="photo" alt="A captura de tela aparecerá nesta caixa."/>';
$string['pluginname'] = 'faceserpro';
$string['quizaccess_faceserpro'] = 'faceserpro para Quiz';
$string['youmustagree'] = 'Você deve concordar em validar sua identidade antes de continuar.';
$string['faceserprorequired'] = 'Validação de identidade via webcam';
$string['notpermissionreport'] = 'Relatórios de faceserpro estão desativados para você.';
$string['eprotroringreports'] = 'Relatório de faceserpro para: ';
$string['eprotroringreportsdesc'] = 'Neste relatório, você encontrará todas as imagens dos alunos capturadas durante o exame. Agora você pode validar suas identidades comparando com suas fotos de perfil e fotos da webcam.';
$string['summarypagedesc'] = 'Neste relatório, você encontrará um resumo do relatório de faceserpro para o curso e quizzes. Você pode excluir todos os dados relacionados ao quiz e ao curso. Isso excluirá arquivos de imagens e logs.';
$string['status'] = 'Status da validação';
$string['dateverified'] = 'Data e hora';
$string['warninglabel'] = 'Avisos';
$string['actions'] = 'Ações';
$string['picturesreport'] = 'Ver relatório de faceserpro';
$string['screenshots'] = 'Capturas de tela';
$string['picturesusedreport'] = 'Estas são as imagens capturadas durante o quiz.';
$string['faceserproproavailable'] = 'faceserpro Pro agora disponível!';
$string['buyfaceserpropro'] = 'Adquirir faceserpro Pro';
$string['togglereportimage'] = 'Alternar visualização de imagem';
$string['setting:faceserproreconfigurefaceserpro'] = 'Reconfigurar automaticamente o faceserpro';
$string['setting:faceserproreconfigurefaceserpro_desc'] = 'Se habilitado, usuários que acessarem o quiz terão fotos tiradas automaticamente via webcam';
$string['event:takescreenshot'] = 'Tirou uma captura de tela';
$string['event:screenshotcreated'] = 'Uma nova captura de tela foi criada';
$string['event:screenshotupdated'] = 'Captura de tela foi atualizada';
$string['privacy:metadata:courseid'] = 'O ID do curso que usa faceserpro.';
$string['privacy:metadata:quizid'] = 'O ID do quiz que usa faceserpro.';
$string['privacy:metadata:webcampicture'] = 'O nome da imagem tirada pelo faceserpro.';
$string['privacy:metadata:status'] = 'O status do faceserpro.';
$string['timemodified'] = 'Última modificação';
$string['privacy:metadata:quizaccess_faceserpro_logs'] = 'Tabela de logs do faceserpro do Moodle que armazena as fotos dos usuários.';
$string['faceserpro:sendcamshot'] = 'faceserpro envia foto da webcam';
$string['faceserpro:getcamshots'] = 'faceserpro obtém fotos da webcam';
$string['faceserpro:viewreport'] = 'faceserpro visualiza relatório';
$string['name'] = 'Nome do Aluno';
$string['webcampicture'] = 'Fotos Capturadas';
$string['openwebcam'] = 'Permita o uso da sua webcam para continuar';
$string['privacy:quizaccess_faceserpro_logs'] = 'Logs de faceserpro para QuizAccess';
$string['privacy:core_files'] = 'Imagens de webcam do QuizAccess faceserpro';
$string['privacy:metadata:core_files'] = 'O Quiz Access armazena fotos dos usuários capturadas pela webcam durante a tentativa de quiz.';
$string['setting:camshotdelay'] = 'Intervalo entre fotos da webcam (segundos)';
$string['setting:camshotdelay_desc'] = 'O valor dado será o intervalo em segundos entre cada foto da webcam.';
$string['settings:enablescreenshot'] = 'Habilitar capturas de tela para quizzes.';
$string['settings:enablescreenshot_desc'] = 'Habilitar capturas de tela para quizzes.';
$string['reportidheader'] = 'ID do Log';
$string['coursenameheader'] = 'Nome do Curso';
$string['quiznameheader'] = 'Nome do Quiz';
$string['mainsettingspagebtn'] = 'Configurações de faceserpro';
$string['additionalsettingspagetitle'] = 'Todos os logs de faceserpro';
$string['execute_facematch_task'] = 'Executar tarefa de reconhecimento facial';
$string['initiate_facematch_task'] = 'Iniciar tarefa de reconhecimento facial';
$string['users_list'] = 'Lista de Usuários';
$string['no_permission'] = 'Você não tem permissão para visualizar esta página';
$string['upload_image_title'] = 'Carregar imagem';
$string['cancel_image_upload'] = 'Upload de imagem cancelado';
$string['image_updated'] = 'Imagem atualizada';
$string['provide_image'] = 'Você deve fornecer uma imagem do aluno selecionado';
$string['upload_first_image'] = 'Por favor, carregue a imagem do usuário.';
$string['settings:deleteuserimagesuccess'] = 'Imagem do usuário excluída com sucesso.';
