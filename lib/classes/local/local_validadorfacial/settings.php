<?php
$url = 'https://api.serpro.gov.br/token';
$data = [
    'grant_type' => 'client_credentials',
    'client_id' => 'SEU_CLIENT_ID',
    'client_secret' => 'SEU_CLIENT_SECRET',
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response)->access_token;
