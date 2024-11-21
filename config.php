<?php
$env_mode = "TEST"; // TEST or PROD
$api_url = '';
$api_key = '';
if($env_mode === 'TEST'){
    $api_url = "https://api.uat.payglocal.in";
    $api_key = 'your test apikey here';
}else{
    $api_url = "https://api.prod.payglocal.in";
    $api_key = 'your prod apikey here';
}

$callback_url = $_SERVER['HTTP_HOST'].'/payment_gateway_payglocal/callback_url.php';
?>
