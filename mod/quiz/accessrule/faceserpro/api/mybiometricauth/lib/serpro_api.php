<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Função para obter o token de autenticação da API SERPRO.
 *
 * @return string O token de autenticação.
 */
function getTokenSerpro() {
    global $CFG;

    // Defina as credenciais da API SERPRO
    $consumerKey = get_config('mybiometricauth', 'consumer_key');
    $consumerSecret = get_config('mybiometricauth', 'consumer_secret');

    // URL do endpoint para obter o token
    $url = 'https://gateway.apiserpro.serpro.gov.br/token';

    // Parâmetros para autenticação
    $dados = "grant_type=client_credentials";

    // Inicia a requisição cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode($consumerKey . ':' . $consumerSecret)
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição e captura a resposta
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    // Verifica se houve erro na requisição
    if ($info['http_code'] != 200) {
        throw new Exception('Erro ao obter o token da API SERPRO. Código de resposta: ' . $info['http_code']);
    }

    // Decodifica a resposta JSON
    $res = json_decode($result);
    return $res->access_token;  // Retorna o token de acesso
}

/**
 * Função para validar a biometria facial usando a API SERPRO.
 *
 * @param string $cpf O CPF do usuário.
 * @param string $base64Image A imagem em base64 da biometria facial.
 * @return object A resposta da API SERPRO.
 */
function getBiometriaSerpro($cpf, $base64Image) {
    // Obtém o token de autenticação
    $auth = getTokenSerpro();

    // URL da API de validação de biometria
    $url = 'https://gateway.apiserpro.serpro.gov.br/datavalid-demonstracao/v2/validate/pf-face';

    // Prepara os dados a serem enviados na requisição
    $dados = array(
        'cpf' => $cpf,
        'validacao' => array(
            'biometria_facial' => array(
                'formato' => 'jpeg',
                'base64' => $base64Image,
                'vivacidade' => true
            )
        )
    );

    // Inicia a requisição cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "Authorization: Bearer $auth"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição e captura a resposta
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    // Verifica se houve erro na requisição
    if ($info['http_code'] != 200) {
        throw new Exception('Erro na validação biométrica. Código de resposta: ' . $info['http_code']);
    }

    // Retorna a resposta da API
    $res = json_decode($result);
    return $res;
}

/**
 * Função para armazenar os dados da validação biométrica no banco de dados.
 *
 * @param string $cpf O CPF do usuário.
 * @param string $foto A foto capturada.
 * @param string $status O status da validação (por exemplo, "validado", "erro").
 * @param string $data Data da captura.
 */
function armazenarResultadoValidacao($cpf, $foto, $status, $data) {
    global $DB;

    // Dados para inserir no banco de dados
    $dados = new stdClass();
    $dados->cpf = $cpf;
    $dados->foto_capturada = $foto;
    $dados->status_validacao = $status;
    $dados->data_imagemcaptura = $data;

    // Insere o resultado na tabela
    $DB->insert_record('tabela_resultvalida_serpro', $dados);
}

/**
 * Função para verificar se o CPF já foi validado pela API SERPRO.
 *
 * @param string $cpf O CPF a ser verificado.
 * @return bool Retorna true se o CPF foi validado, caso contrário, false.
 */
function verificarValidacaoCPF($cpf) {
    global $DB;

    // Consulta se o CPF já foi validado
    $record = $DB->get_record('tabela_resultvalida_serpro', array('cpf' => $cpf));

    return !empty($record);  // Retorna true se encontrar o CPF na tabela
}
