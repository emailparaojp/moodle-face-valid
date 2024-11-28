<?php
include_once(__DIR__ . '/credenciais_serpro.php');
function getTokenSerpro(){
    global $consumerKey, $consumerSecret;
    $url = 'https://gateway.apiserpro.serpro.gov.br/token'; // API_v2
    $dados = "grant_type=client_credentials";
    $ch = curl_init( $url );
    # Setup request to send json via POST.
    $payload = $dados;
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER,
        array(
            'Authorization: Basic ' . base64_encode($consumerKey . ':' . $consumerSecret)
        )
    );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    // echo $info['http_code'];
    $res = json_decode($result);
    return $auth = $res->access_token;
}
function getBiometriaSerpro($dados){
    $auth = getTokenSerpro();
    $url = "https://gateway.apiserpro.serpro.gov.br/datavalid/v2/validate/pf-face";
    $ch = curl_init( $url );
    # Setup request to send json via POST.
    $payload = json_encode( $dados );
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization: Bearer $auth"));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);
    # Print response.
    // echo "<pre>$result</pre>";
    $res = json_decode($result);
    return $res;
}
/*
$name = $cpf . "-" . date("YmdHis");
$path = "logs/{$name}.jpg";
$data = explode(',', $data);
$url2 = "https://gateway.apiserpro.serpro.gov.br/datavalid/v1/validate/pf-face";
$dados["key"]["cpf"] = $cpf; //$_REQUEST["cpf"]; //"13705299883";
$dados["answer"]["biometria_face"] = trim($data[1]);
// $dados["answer"]["documento"]["tipo"] = "1";
// $dados["answer"]["documento"]["numero"] = "273436661";
// $dados["answer"]["documento"]["orgao_expedidor"] = "SSP";
// $dados["answer"]["documento"]["uf_expedidor"] = "SP";
$ch2 = curl_init( $url2 );
# Setup request to send json via POST.
$payload = json_encode( $dados );
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $ch2, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Authorization: Bearer $auth"));
# Return response instead of printing.
curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch2);
curl_close($ch2);
# Print response.
//echo "<pre>$result</pre>";
$resj = json_decode($result);
//   print_r($resj);
// exit();
*/
