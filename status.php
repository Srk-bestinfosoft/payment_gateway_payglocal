<?php
require_once "config.php";
$gid = $_GET['gid']; // payment gateway transaction id 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $api_url.'/gl/v1/payments/'.$gid.'/status',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'GET /gl/v1/payments/'.$gid.'/status HTTP/1.1
Accept: application/json
X-Gl-Auth: '.$api_key.'
Host: '.$api_url.'

',
  CURLOPT_HTTPHEADER => array(
    'x-gl-auth: '.$api_key.'',
    'Content-Type: text/plain',
   
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);

// Function to generate table rows dynamically
function generateTableRows($array, $prefix = '') {
    $rows = '';
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            // Recursively generate rows for nested arrays
            $rows .= generateTableRows($value, $prefix . $key . '.');
        } else {
            // Add a row for non-array values
            $rows .= '<tr>';
            $rows .= '<td>' . htmlspecialchars($prefix . $key) . '</td>';
            $rows .= '<td>' . htmlspecialchars($value) . '</td>';
            $rows .= '</tr>';
        }
    }
    return $rows;
}

// Generate table rows dynamically
$tableRows = generateTableRows($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Response</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Transaction Status Details</h2>
    <table>
        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?= $tableRows; ?>
        </tbody>
    </table>
</body>
</html>
