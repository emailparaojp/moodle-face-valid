<?php
defined('MOODLE_INTERNAL') || die();

function local_aws_integration_validar_face($firstImageBase64, $secondImageBase64) {
    $url = 'http://34.203.73.5:7000/aws/face/compares';
    $token = 'seu_token_aqui'; // Substitua pelo seu token real

    $data = array(
        'firstImage' => $firstImageBase64,
        'secondImage' => $secondImageBase64,
    );

    $response = local_aws_integration_make_request($url, $data, $token);

    return $response;
}

function local_aws_integration_recuperar_imagem($key) {
    $url = 'http://34.203.73.5:7000/aws/recupera/imagem';
    $token = 'seu_token_aqui'; // Substitua pelo seu token real

    $data = array(
        'key' => $key
    );

    $response = local_aws_integration_make_request($url, $data, $token, 'GET');

    return $response;
}

function local_aws_integration_upload_imagem($imageData) {
    $url = 'http://34.203.73.5:7000/aws/upload/imagem';
    $token = 'seu_token_aqui'; // Substitua pelo seu token real

    $data = array(
        'image' => $imageData
    );

    $response = local_aws_integration_make_request($url, $data, $token);

    return $response;
}

// Função para fazer a requisição HTTP
function local_aws_integration_make_request($url, $data, $token, $method = 'POST') {
    $options = array(
        'CURLOPT_RETURNTRANSFER' => true,
        'CURLOPT_HTTPHEADER' => array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ),
        'CURLOPT_POSTFIELDS' => json_encode($data),
    );

    if ($method === 'GET') {
        unset($options['CURLOPT_POSTFIELDS']);
        $url = $url . '?' . http_build_query($data);
    }

    $response = local_aws_integration_curl_request($url, $options);

    return json_decode($response, true);
}

// Função curl para enviar a requisição
function local_aws_integration_curl_request($url, $options) {
    $ch = curl_init($url);

    foreach ($options as $opt => $value) {
        curl_setopt($ch, constant($opt), $value);
    }

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    return $response;
}
