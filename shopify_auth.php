<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$shop = $_GET['shop'] ?? '';
$brandId = $_GET['brand_id'] ?? '';

if (!$shop || !$brandId) {
    echo "❌ Missing required parameters.";
    exit;
}

// Shopify App Credentials
$api_key = '4109dca8e454490c152c11df69dc0c84';

// Add brand_id to redirect_uri so it returns with the callback

// Scopes
$scope = "read_products,read_orders,read_marketing_events";

// Shopify Install URL
$redirect_uri = urlencode("https://digitalshelf.sausinternationalinc.com/shopify_callback.php");

$install_url = "https://$shop/admin/oauth/authorize?" .
    "client_id=$api_key" .
    "&scope=$scope" .
    "&redirect_uri=$redirect_uri" .
    "&state=$brandId";  // pass brand ID via state instead

// Redirect to Shopify OAuth
header("Location: $install_url");
exit;
?>
