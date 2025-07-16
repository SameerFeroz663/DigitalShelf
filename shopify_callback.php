<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './conn.php';

$shop = $_GET['shop'] ?? '';
$code = $_GET['code'] ?? '';
$hmac = $_GET['hmac'] ?? '';
$brandId = $_GET['state'] ?? '';

if (!$shop || !$code || !$hmac || !$brandId) {
    echo "❌ Missing required parameters.";
    exit;
}

$api_key = '4109dca8e454490c152c11df69dc0c84';
$api_secret = '38af4e8b6ad5295f311b4285b9b52a32';

// Validate HMAC
$params = $_GET;
unset($params['hmac']);
ksort($params);
$query = http_build_query($params);
$calculatedHmac = hash_hmac('sha256', $query, $api_secret);

if (!hash_equals($calculatedHmac, $hmac)) {
    echo "❌ HMAC validation failed. Possible tampering.";
    exit;
}

// Exchange for token
$token_url = "https://$shop/admin/oauth/access_token";
$postData = [
    'client_id' => $api_key,
    'client_secret' => $api_secret,
    'code' => $code
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($http_code !== 200 || !isset($data['access_token'])) {
    echo "❌ Failed to get access token. HTTP Code: $http_code<br>";
    echo "Curl Error: $curl_error<br><pre>";
    print_r($response);
    echo "</pre>";
    exit;
}

$access_token = $data['access_token'];

// Store token in DB
$stmt = $conn->prepare("UPDATE brand SET shopify_token = ? WHERE id = ?");
$stmt->bind_param("si", $access_token, $brandId);
if ($stmt->execute()) {
    echo "✅ Access token stored successfully for brand ID: $brandId";
    header("Location: ./brandInsert.php?from=brandSuccess");
    exit;
} else {
    echo "❌ Failed to update token in database.";
}
?>
