<?php
require_once "config.php";
//it is user id or crn number it cannot be a unique value.
$merchantTxnId = "199652205010";
//it length should be more than 16 and unique value every transaction.
// 205010 your id 
$merchantUniqueId = "205010"."_".date("dmYhmso"); 
// 100
$totalAmount = "100";
// Currency code like INR,USD,CAD...
$txnCurrency = "INR";
// email id of user.
$emailId = "";
// user country code like +91,+1,+61 
$callingCode = "+91";
// user mobile number 
$phoneNumber = "9652205010";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $api_url.'/gl/v1/payments/initiate/paycollect',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "merchantTxnId": "'.$merchantTxnId.'",
    "merchantUniqueId": "'.$merchantUniqueId.'",
    "paymentData": {
        "totalAmount": "'.$totalAmount.'",
        "txnCurrency": "'.$txnCurrency.'",
        "billingData": {
            "emailId": "'.$emailId.'",
            "callingCode": "'.$callingCode.'",
            "phoneNumber": "'.$phoneNumber.'"
        }
    },
    "merchantCallbackURL": "'.$callback_url.'"
}',
  CURLOPT_HTTPHEADER => array(
    'x-gl-auth: '.$api_key.'',
    'Content-Type: application/json',
      ),
));

$response = curl_exec($curl);
//echo $response;
curl_close($curl);
$data = json_decode($response, true);
// Check if the 'redirectUrl' exists in the 'data' array
if (isset($data['data']['redirectUrl'])) {
    // Output the redirectUrl
    echo $data['data']['redirectUrl'];
header('Location: '.$data['data']['redirectUrl']);
  
} else {
    echo "redirectUrl not found.";
}
