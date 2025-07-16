<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
$client->setAccessType('offline');

// Load token
$accessToken = json_decode(file_get_contents('token.json'), true);
$client->setAccessToken($accessToken);

// Refresh token if expired
if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents('token.json', json_encode($client->getAccessToken()));
}

$service = new Google_Service_Webmasters($client);
$sites = $service->sites->listSites();

$shown = false; // Track if a card has been shown

foreach ($sites->getSiteEntry() as $site) {
    if ($shown) break; // Only show one card with data

    $siteUrl = $site->getSiteUrl();

    // Fetch SEO queries for the site
    $request = new Google_Service_Webmasters_SearchAnalyticsQueryRequest([
        'startDate' => date('Y-m-d', strtotime('-7 days')),
        'endDate' => date('Y-m-d'),
        'dimensions' => ['query'],
        'rowLimit' => 5
    ]);

    $response = $service->searchanalytics->query($siteUrl, $request);

    if ($response->getRows()) {
        echo '<div class="card p-3 mb-4 shadow-sm bg-white">';
        echo '<div class="small text-muted mb-3">' . htmlspecialchars($siteUrl) . '</div>';

        foreach ($response->getRows() as $row) {
            $query = htmlspecialchars($row->getKeys()[0]);
            $clicks = $row->getClicks();
            $impressions = $row->getImpressions();

            echo '
            <div class="bg-light rounded p-2 mb-2">
                <div class="d-flex justify-content-between text-muted mb-1 small">
                    <strong>' . $query . '</strong>
                    <a href="#" class="text-decoration-none small">Details</a>
                </div>
                <div class="row small text-dark">
                    <div class="col-6"><strong>Ranking:</strong> —</div>
                    <div class="col-6"><strong>Clicks:</strong> ' . $clicks . '</div>
                    <div class="col-6"><strong>Impressions:</strong> ' . $impressions . '</div>
                    <div class="col-6"><strong>Visitors:</strong> ' . $clicks . '</div>
                </div>
            </div>';
        }

        echo '</div>'; // end card
        $shown = true; // Stop after showing one site
    }
}

// Optional: fallback if no data was found for any site
if (!$shown) {
    echo '<div class="card p-3 mb-4 shadow-sm bg-white">';
    echo '<h6 class="mb-2 fw-bold">SEO Performance 🌟</h6>';
    echo '<div class="text-muted small">No data found for any site.</div>';
    echo '</div>';
}
?>
