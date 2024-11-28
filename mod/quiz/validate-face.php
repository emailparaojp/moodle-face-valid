<?php
require_once('../../config.php');

// Recebe o ID do quiz
$quizid = required_param('quizid', PARAM_INT);

// Configuração inicial do Moodle
require_login();
$PAGE->set_url(new moodle_url('/mod/quiz/validate-face.php', ['quizid' => $quizid]));
$PAGE->set_title('Validação Facial');
$PAGE->set_heading('Validação Facial');

// Renderização do cabeçalho
echo $OUTPUT->header();
?>

<p>Posicione seu rosto na câmera e clique em "Validar".</p>

<!-- Vídeo da câmera -->
<video id="camera" autoplay playsinline width="320" height="240"></video>

<!-- Canvas para capturar a imagem -->
<canvas id="snapshot" style="display: none;"></canvas>

<!-- Botões -->
<button id="capture" class="btn btn-primary">Capturar</button>
<form id="validation-form" method="POST" style="display: none;">
    <input type="hidden" name="face_image" id="face_image">
    <button type="submit" class="btn btn-success">Validar</button>
</form>

<script>
    // Acessar a câmera
    const video = document.getElementById('camera');
    const canvas = document.getElementById('snapshot');
    const faceImageInput = document.getElementById('face_image');
    const validationForm = document.getElementById('validation-form');

    // Iniciar a câmera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Erro ao acessar a câmera:", err);
            alert("Não foi possível acessar a câmera. Verifique as permissões.");
        });

    // Capturar a imagem
    document.getElementById('capture').addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Converte o conteúdo do canvas em uma string base64
        const imageData = canvas.toDataURL('image/png');
        faceImageInput.value = imageData;

        // Exibe o botão de validação
        validationForm.style.display = 'block';
    });
</script>

<?php
// Se o formulário for enviado, processa a imagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['face_image'])) {
    global $DB, $USER;

    // Obtém a imagem base64
    $faceImageBase64 = $_POST['face_image'];

    // Converte o Base64 para um arquivo de imagem real
    $imageData = explode(',', $faceImageBase64)[1];
    $decodedImage = base64_decode($imageData);
    $imagePath = $CFG->dataroot . "/temp/face_image_{$USER->id}.png";

    // Salva a imagem
    file_put_contents($imagePath, $decodedImage);

    // Realiza a validação facial com a API do SERPRO
    $validation_result = validar_com_serpro($faceImageBase64, $USER->cpf);
var_dump($validation_result, $faceImageBase64);
    // Se a validação for bem-sucedida, atualiza o banco de dados
    if ($validation_result['status'] === 'validado') {
        // Registra a validação no banco
        $userid = $USER->id;
        $record = $DB->get_record('user_validation', ['userid' => $userid]);

        if ($record) {
            // Atualiza o registro existente
            $record->validated = 1;
            $record->timevalidated = time();
            $DB->update_record('user_validation', $record);
        } else {
            // Cria um novo registro
            $newrecord = new stdClass();
            $newrecord->userid = $userid;
            $newrecord->validated = 1;
            $newrecord->timevalidated = time();
            $DB->insert_record('user_validation', $newrecord);
        }

        // Redireciona para o quiz após a validação
        redirect(new moodle_url('/mod/quiz/view.php', ['id' => $quizid]));
    } else {
        // Se a validação falhar
        echo $OUTPUT->notification('Falha na validação facial. Tente novamente.', 'notifyproblem');
    }
}

// Função para validação na API do SERPRO
function validar_com_serpro($imagem_base64, $cpf) {
    // Configurações da API
    $login_url = "http://34.203.73.5:7000/login"; // URL de login
    $validation_url = "https://api.serpro.gov.br/biometria/valida"; // URL de validação facial

    $client_id = "cafe_ead"; // Client ID
    $client_secret = "d3s4N8O'08w)"; // Client Secret

    // 1. Obter o token de autenticação
    $login_data = json_encode([
        'usuario' => $client_id,
        'senha' => $client_secret
    ]);

    // Iniciar a requisição de login para obter o token
    $ch = curl_init($login_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $login_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $login_response = curl_exec($ch);
    curl_close($ch);

    // Verificar se houve erro ao obter o token
    if ($login_response === false) {
        return ['status' => 'erro', 'mensagem' => 'Erro de conexão ao tentar autenticar'];
    }

    $login_data = json_decode($login_response, true);

    // Verificar se o login retornou um token válido
    if (!isset($login_data['token'])) {
        return ['status' => 'erro', 'mensagem' => 'Falha na autenticação: ' . $login_data['message'] ?? 'Token não encontrado', 'data' => $login_data];
    }

    // Obter o token de acesso
    $access_token = $login_data['token'];

    // 2. Enviar a imagem facial para validação
    $validation_data = json_encode([
        'imagem' => $imagem_base64,
        'cpf' => $cpf,
    ]);

    // Iniciar a requisição de validação facial
    $ch = curl_init($validation_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $validation_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $validation_response = curl_exec($ch);
    curl_close($ch);

    // Verificar resposta da validação
    if ($validation_response === false) {
        return ['status' => 'erro', 'mensagem' => 'Erro de conexão ao tentar validar a biometria', 'data' => $validation_response];
    }

    // Decodificar a resposta da validação facial
    $validation_data = json_decode($validation_response, true);

    // Retornar a resposta da validação
    return $validation_data;
}


echo $OUTPUT->footer();
?>
