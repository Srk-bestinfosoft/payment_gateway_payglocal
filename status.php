<?php
$gid = $_GET['gid'];
$curl = curl_init();
$api ="repace_with_your_api";
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.uat.payglocal.in/gl/v1/payments/'.$gid.'/status',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'GET /gl/v1/payments/'.$gid.'/status HTTP/1.1
Accept: application/json
X-Gl-Auth: '.$api.'
Host: api.uat.payglocal.in

',
  CURLOPT_HTTPHEADER => array(
    'x-gl-auth: '.$api.'',
    'Content-Type: text/plain',
   
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
