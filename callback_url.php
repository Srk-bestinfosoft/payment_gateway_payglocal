<?php
$params = $_POST; // payment gateway will post response after transaction done.
$ok = $params['x-gl-token'];
//echo $ok;
// Your base64-encoded JWT
$jwt = $ok;
// Step 1: Split the JWT into its parts (header, payload, signature)
$parts = explode('.', $jwt);

// Ensure we have 3 parts: header, payload, and signature
if (count($parts) === 3) {
    // Step 2: Base64-decode the payload (the second part of the JWT)
    $payload = base64_decode($parts[1]);

    // Step 3: Decode the payload into a PHP array
    $decodedPayload = json_decode($payload, true);

    // Step 4: Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        // Step 5: Extract the required values
        $gid = isset($decodedPayload['gid']) ? $decodedPayload['gid'] : 'Not found';
        $statusUrl = isset($decodedPayload['statusUrl']) ? $decodedPayload['statusUrl'] : 'Not found';
        $amount = isset($decodedPayload['Amount']) ? $decodedPayload['Amount'] : 'Not found';
        $merchantTxnId = isset($decodedPayload['merchantTxnId']) ? $decodedPayload['merchantTxnId'] : 'Not found';
        $paymentMethod = isset($decodedPayload['paymentMethod']) ? $decodedPayload['paymentMethod'] : 'Not found';
        $status = isset($decodedPayload['status']) ? $decodedPayload['status'] : 'Not found';

        // Step 6: Output the data in an HTML table
        echo "<center><table border='1' cellpadding='10' cellspacing='0'>";
        echo "<thead><tr><th>Field</th><th>Value</th></tr></thead>";
        echo "<tbody>";
        echo "<tr><td>GID</td><td>" . htmlspecialchars($gid) . "</td></tr>";
       
        echo "<tr><td>Amount</td><td>" . htmlspecialchars($amount) . "</td></tr>";
        echo "<tr><td>Merchant TXN ID</td><td>" . htmlspecialchars($merchantTxnId) . "</td></tr>";
        echo "<tr><td>Payment Method</td><td>" . htmlspecialchars($paymentMethod) . "</td></tr>";
        echo "<tr><td>Status</td><td>" . htmlspecialchars($status) . "</td></tr>";
        echo "</tbody>";
        echo "</table></center>";
    } else {
        echo "Error decoding the payload: " . json_last_error_msg();
    }
} else {
    echo "Invalid JWT structure.";
}

?>
