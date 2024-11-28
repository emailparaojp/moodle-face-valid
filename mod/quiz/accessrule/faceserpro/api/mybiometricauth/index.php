<?php
// Verifica se o acesso está autorizado
require_once('../../config.php');
require_once('serpro_api.php');  // Inclui o arquivo de integração com a API SERPRO
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

$pluginname = get_string('pluginname', 'mod_quiz');
$PAGE->set_url('/mod/quiz/accessrule_mybiometricauth/index.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($pluginname);
$PAGE->set_title($pluginname);

// Verifica se o usuário tem permissão para acessar
$context = context_system::instance();
require_login();

// Obtém os parâmetros da URL (como o CPF ou a imagem da biometria)
$cpf = optional_param('cpf', '', PARAM_RAW);
$base64Image = optional_param('base64Image', '', PARAM_RAW);

// Se o CPF e a imagem foram enviados, valida a biometria
if ($cpf && $base64Image) {
    try {
        // Valida a biometria facial com a API SERPRO
        $resultado = getBiometriaSerpro($cpf, $base64Image);

        // Armazena o resultado da validação no banco de dados
        $status = $resultado->match ? 'validado' : 'não validado';
        armazenarResultadoValidacao($cpf, $base64Image, $status, date('Y-m-d H:i:s'));

        // Exibe a resposta
        echo $OUTPUT->header();
        echo html_writer::tag('h2', get_string('result', 'mod_quiz'));
        echo html_writer::tag('p', 'CPF: ' . $cpf);
        echo html_writer::tag('p', 'Status da Validação: ' . $status);
        echo html_writer::tag('p', 'Resultado: ' . json_encode($resultado));
        echo $OUTPUT->footer();
    } catch (Exception $e) {
        // Exibe erro se a requisição falhar
        echo $OUTPUT->header();
        echo html_writer::tag('h2', get_string('error', 'mod_quiz'));
        echo html_writer::tag('p', 'Erro ao processar a biometria: ' . $e->getMessage());
        echo $OUTPUT->footer();
    }
} else {
    // Exibe o formulário de captura se o CPF ou imagem não forem fornecidos
    echo $OUTPUT->header();
    echo html_writer::tag('h2', get_string('capturebiometrics', 'mod_quiz'));
    ?>
    <form id="biometric-form" method="POST" action="index.php">
        <label for="cpf"><?php echo get_string('cpf', 'mod_quiz'); ?>:</label>
        <input type="text" name="cpf" id="cpf" required><br><br>

        <button type="button" id="capture-image"><?php echo get_string('captureimage', 'mod_quiz'); ?></button><br><br>

        <canvas id="captureCanvas" width="640" height="480"></canvas><br><br>

        <input type="hidden" name="base64Image" id="base64Image">
        <button type="submit"><?php echo get_string('validateimage', 'mod_quiz'); ?></button>
    </form>

    <script>
        // Configuração do Webcam e captura de imagem
        document.getElementById('capture-image').onclick = function() {
            var video = document.createElement('video');
            var canvas = document.getElementById('captureCanvas');
            var ctx = canvas.getContext('2d');

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(error) {
                    alert('Erro ao acessar a webcam: ' + error.message);
                });

            video.onplay = function() {
                setInterval(function() {
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                }, 100);
            };
        };

        // Envia a imagem em base64 para o formulário
        document.getElementById('biometric-form').onsubmit = function(event) {
            var canvas = document.getElementById('captureCanvas');
            var base64Image = canvas.toDataURL('image/jpeg');
            document.getElementById('base64Image').value = base64Image;
        };
    </script>
    <?php
    echo $OUTPUT->footer();
}
