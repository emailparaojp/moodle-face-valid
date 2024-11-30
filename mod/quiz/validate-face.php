<?php
require_once '../../config.php';
?>
<style>
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
</style>
<div class="container mt-5">
    <form id="validationForm" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" id="cpf" required placeholder="Digite o CPF">
            <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
        </div>

        <div class="form-group">
            <label for="video">Captura de Vídeo:</label>
            <video id="video" autoplay class="w-100 mb-3"></video>
            <canvas id="canvas" style="display: none;"></canvas>
        </div>

        <div class="form-group d-flex justify-content-between">
            <button type="button" class="btn btn-primary" id="capture">Capturar Foto</button>
            <button type="submit" class="btn btn-success">Validar</button>
        </div>
        <p id="status"></p>
    </form>
</div>


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
                const response = await fetch('validate-face-backend.php', {
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
                    await changeCookieValue();
                    setTimeout(() => {
                        url = this.location.href;
                        // se tiver o parametro isValidated, remove
                        url = url.replace(/&isValidated=true/g, '');
                        window.location.href = url;
                    }, 2000);
                } else {
                    const errorCode = extractErrorCode(result.details?.message || "");
                    const errorMessage = errorMessages[errorCode] || "Erro desconhecido. Consulte a documentação da API.";

                    status.textContent = `Erro: ${errorMessage} (Código: ${errorCode})`;
                    status.className = "error";
                    console.error(`Detalhes do erro: ${JSON.stringify(result.details, null, 2)}`);

                    setTimeout(() => {
                        url = this.location.href;
                        url = url.replace(/&isValidated=true/g, '');
                        window.location.href = url;
                    }, 2000);
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


        // Função para gerar o SHA-256 do valor "true"
        async function setCookie(value) {
            // Convertendo o valor para ArrayBuffer
            const encoder = new TextEncoder();
            const data = encoder.encode(value);

            // Gerando o hash SHA-256
            const hashBuffer = await crypto.subtle.digest('SHA-256', data);
            const hashArray = Array.from(new Uint8Array(hashBuffer)); // Converte para array de bytes
            const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join(''); // Convertendo para hex

            // Criando o cookie com validade de 2 minutos
            const expires = new Date();
            expires.setMinutes(expires.getMinutes() + 2); // Expira em 2 minutos

            // Setando ou alterando o cookie
            document.cookie = `isValidated=${hashHex}; expires=${expires.toUTCString()}; path=/`;
        }

        // Função para verificar se o cookie existe e alterar seu valor
        async function changeCookieValue() {
            // Alterando o cookie para "true" (ou outro valor conforme a regra de negócio)
            await setCookie("true");
        }

        $(document).ready(function(){
            // Aplicar a máscara ao campo, mas no valor real (no submit) somente números
            $('#cpf').inputmask('999.999.999-99', {
                oncomplete: function () {
                    // Quando o campo estiver completo, podemos pegar o valor como somente números
                    var cpfValue = $('#cpf').val().replace(/\D/g, ''); // Remove todos os não números
                    $('#cpf').val(cpfValue); // Atualiza o valor para apenas números
                }
            });
        });


    </script>
