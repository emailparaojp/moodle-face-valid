    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        video, canvas {
            display: block;
            margin: 10px auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px;
            height: 300px;
        }
        button, input {
            margin: 10px;
            padding: 10px;
            font-size: 16px;
        }
        #status {
            margin: 20px;
            font-weight: bold;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
<h1>Validação Facial</h1>
<form id="validationForm">
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" required placeholder="Digite o CPF" /><br>
    <video id="video" autoplay></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <button type="button" id="capture">Capturar Foto</button>
    <button type="submit">Validar</button>
</form>
<p id="status"></p>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const form = document.getElementById('validationForm');
    const status = document.getElementById('status');

    let capturedImageBase64 = null;

    // Ativar câmera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => video.srcObject = stream)
        .catch(() => {
            status.textContent = "Erro ao acessar câmera. Verifique as permissões.";
            status.className = "error";
        });

    // Capturar imagem e converter para Base64
    captureButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        capturedImageBase64 = canvas.toDataURL('image/png').split(',')[1]; // Captura como PNG
        status.textContent = "Foto capturada!";
        status.className = "success";
    });

    // Submeter dados
    const errorMessages = {
        DV001: "LGPD: Dados de menor de idade. O Datavalid não valida dados de criança e adolescente.",
        DV002: "Dados encontrados na base não atendem aos requisitos mínimos para validação.",
        DV010: "CPF inválido. Verifique se há algo de errado ou incompleto no CPF enviado para validação.",
        DV040: "Imagem da face não encontrada nas bases. O CPF utilizado na validação não possui cadastro de imagem da face na base de dados biométrica.",
        DV041: "Não foi possível reconhecer a face na imagem enviada. Verifique se o rosto está claro, bem exposto e sem obstruções.",
        DV042: "Tamanho da imagem da face inválido. Verifique os requisitos mínimos de tamanho da imagem (mínimo 250x250 pixels).",
        DV045: "Qualidade baixa da imagem da face. Reenvie uma imagem mais nítida e bem iluminada.",
        DV046: "Foi reconhecido mais de uma face na imagem",
        DV047: "Formato da imagem da face inválido",
        DV061: "Baixa qualidade da imagem da face para checagem de vivacidade (liveness)\n",
        DV062: "Imagem da face não foi reconhecida como real na checagem de vivacidade.",
        // Adicione mais códigos e mensagens conforme necessário...
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const cpf = document.getElementById('cpf').value;

        if (!cpf || !capturedImageBase64) {
            status.textContent = "Preencha o CPF e capture uma foto antes de validar.";
            status.className = "error";
            return;
        }

        status.textContent = "Validando...";
        status.className = "";

        try {
            const response = await fetch('/moodle/local/validate-face.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    cpf,
                    image: capturedImageBase64,
                }),
            });

            const result = await response.json();

            if (result.success) {
                status.textContent = `Validação concluída com sucesso! Similaridade: ${result.data.similarity || "N/A"}%`;
                status.className = "success";
                console.log(result.data);
            } else {
                const errorCode = extractErrorCode(result.details?.message || "");
                const errorMessage = errorMessages[errorCode] || "Erro desconhecido. Consulte a documentação da API.";

                status.textContent = `Erro: ${errorMessage} (Código: ${errorCode})`;
                status.className = "error";
                console.error(`Detalhes do erro: ${JSON.stringify(result.details, null, 2)}`);
            }
        } catch (err) {
            status.textContent = "Erro inesperado ao processar a validação.";
            status.className = "error";
            console.error(err);
        }
    });

    // Função para extrair o código de erro do JSON interno na mensagem
    function extractErrorCode(message) {
        try {
            const parsedMessage = JSON.parse(message);
            return parsedMessage.code || null;
        } catch (e) {
            return null; // Retorna null caso a mensagem não seja um JSON válido
        }
    }

</script>