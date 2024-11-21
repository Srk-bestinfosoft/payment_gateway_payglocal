<?php
$curl = curl_init();
$api ="repace_with_your_api";
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.uat.payglocal.in/gl/v1/payments/initiate/paycollect',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "merchantTxnId": "23AEE8CB6B62EE2AF06",
    "paymentData": {
        "totalAmount": "150",
        "txnCurrency": "INR",
        "billingData": {
            "emailId": "test@test.com",
            "callingCode": "+91",
            "phoneNumber": "9999999998"
        }
    },
    "merchantCallbackURL": "http://localhost/payglocal/callback_url.php"
}',
  CURLOPT_HTTPHEADER => array(
    'x-gl-auth: '.$api.'',
    'Content-Type: application/json',
      ),
));

$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response, true);
// Check if the 'redirectUrl' exists in the 'data' array
if (isset($data['data']['redirectUrl'])) {
    // Output the redirectUrl

    header('Location: '.$data['data']['redirectUrl']);
   // echo $data['data']['redirectUrl'];
} else {
    echo "redirectUrl not found.";
}
