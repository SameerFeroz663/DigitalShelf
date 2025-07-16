<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
include './conn.php';

// Get the brand info (you can make this dynamic if needed)
$brandId = $_GET['brand_id'] ?? '';
if (!$brandId) {
    echo "❌ Missing brand_id parameter.";
    exit;
}

$stmt = $conn->prepare("SELECT name FROM brand WHERE id = ?");
$stmt->bind_param("i", $brandId);
$stmt->execute();
$result = $stmt->get_result();
$brand = $result->fetch_assoc();

if (!$brand) {
    echo "❌ Brand not found.";
    exit;
}

// META App credentials
$appId = '1372407170500942';
$redirectUri = urlencode('https://digitalshelf.sausinternationalinc.com/meta_callback.php'); // Update to your callback script
$scope = 'ads_management,business_management,pages_show_list,pages_read_engagement'; // Adjust as needed
$state = $brandId; // Used to remember which brand initiated the request

// Construct the Meta OAuth URL
$metaOauthUrl = "https://www.facebook.com/v19.0/dialog/oauth?" . http_build_query([
    'client_id' => $appId,
    'redirect_uri' => $redirectUri,
    'scope' => $scope,
    'response_type' => 'code',
    'state' => $state
]);

// Redirect to Meta
header("Location: $metaOauthUrl");
exit;
