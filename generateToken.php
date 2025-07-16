<?php
// generateToken.php for Google, Meta (Facebook/Instagram), Shopify, and Klaviyo

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

//------------------------------------//
// GOOGLE OAUTH FLOW (Already working)
//------------------------------------//

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->setRedirectUri('https://digitalshelf.sausinternationalinc.com/generateToken.php');
$client->addScope([Google_Service_Webmasters::WEBMASTERS_READONLY]);
$client->setAccessType('offline');
$client->setPrompt('select_account consent');

if (!isset($_GET['code']) && !isset($_GET['platform'])) {
    $authUrl = $client->createAuthUrl();
    echo "<a href='?platform=google'>Login with Google</a><br>";
    echo "<a href='meta_auth.php'>Login with Meta</a><br><br>";
    echo "<form method='get' action='shopify_auth.php'>
            <label for='shop'>Shopify Store:</label>
            <input type='text' name='shop' placeholder='yourstore.myshopify.com' required>
            <button type='submit'>Connect Shopify Store</button>
          </form><br>";
    echo "<a href='klaviyo_auth.php'>Connect Klaviyo</a>";
    exit;
}

if (isset($_GET['code']) && $_GET['platform'] === 'google') {
    $authCode = $_GET['code'];
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    if (isset($accessToken['error'])) {
        echo "❌ Failed to fetch Google token: ";
        print_r($accessToken);
        exit;
    }

    file_put_contents(__DIR__ . '/token_google.json', json_encode($accessToken));
    echo "✅ Google token saved!<br><pre>";
    print_r($accessToken);
    echo "</pre>";
}

//------------------------------------//
// PLACEHOLDERS FOR META, SHOPIFY, KLAVIYO
//------------------------------------//

// 1. META (Facebook/Instagram Ads)
// File: meta_auth.php
// Redirect URI: https://yourdomain.com/meta_callback.php
// Required Scopes: ads_read, business_management, pages_read_engagement

// 2. SHOPIFY
// File: shopify_auth.php
// Redirect URI: https://yourdomain.com/shopify_callback.php
// Scopes: read_orders, read_products, read_marketing_events

// 3. KLAVIYO
// Klaviyo uses API Keys (no OAuth for now)
// Go to https://www.klaviyo.com/account#api-keys and create a Private API Key
// Save the key manually in a JSON or .env file for requests

?>
