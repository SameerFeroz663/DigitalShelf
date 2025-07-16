<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
include './conn.php';

// Initialize Google Client
$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
$client->setAccessType('offline');

// Load and refresh token
$accessToken = json_decode(file_get_contents('token.json'), true);
$client->setAccessToken($accessToken);

if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents('token.json', json_encode($client->getAccessToken()));
}

// Create service
$service = new Google_Service_Webmasters($client);
$sites = $service->sites->listSites()->getSiteEntry();

// URL Normalizer
function normalizeUrl($url) {
    $url = strtolower($url);
    $url = preg_replace('#^https?://#', '', $url);
    $url = preg_replace('#^www\.#', '', $url);
    return rtrim($url, '/');
}

// Load all brands
$allBrands = [];
$brandsRes = mysqli_query($conn, "SELECT * FROM brand");
while ($b = mysqli_fetch_assoc($brandsRes)) {
    $allBrands[] = $b;
}

// Get selected site
$selectedSite = $_GET['site'] ?? $sites[0]->getSiteUrl();
$normalizedSelected = normalizeUrl($selectedSite);

// Match brand
$ogSite = null;
foreach ($allBrands as $brand) {
    if (normalizeUrl($brand['website']) === $normalizedSelected) {
        $ogSite = $brand;
        break;
    }
}

// Site dropdown
echo "<div style='width:100%; display:flex; justify-content:space-between; align-items:center'>";
echo '<form method="get" class="mb-3 d-flex" style="width:100%; align-items:center; justify-content:space-between;">';
echo '<h4>Brands: </h4>';
echo '<select name="site" class="form-select w-auto d-inline-block" onchange="this.form.submit()">';

$finalUrl = null;
foreach ($sites as $site) {
    $siteUrl = $site->getSiteUrl();
    $normalizedSite = normalizeUrl($siteUrl);

    foreach ($allBrands as $brand) {
        if (normalizeUrl($brand['website']) === $normalizedSite) {
            $selected = ($siteUrl === $selectedSite) ? 'selected' : '';
            if ($selected) $finalUrl = $siteUrl;
            echo "<option value=\"$siteUrl\" $selected>$siteUrl</option>";
            break;
        }
    }
}
echo '</select>';
echo '</form>';
echo '</div>';

// SEO Data Display
if ($finalUrl) {
    // --------- PAGE-WISE ---------
    $request = new Google_Service_Webmasters_SearchAnalyticsQueryRequest([
        'startDate' => date('Y-m-d', strtotime('-7 days')),
        'endDate' => date('Y-m-d'),
        'dimensions' => ['page'],
        'rowLimit' => 1000
    ]);
    $response = $service->searchanalytics->query($finalUrl, $request);

    $dates = $clicks = $impressions = [];

    if ($response->getRows()) {
        foreach ($response->getRows() as $row) {
            $page = $row->getKeys()[0];
            $shortPage = preg_replace('#^https?://#', '', $page);
            $shortPage = str_replace('www.', '', $shortPage);
            $shortPage = str_replace($normalizedSelected, '', normalizeUrl($page));
            $dates[] = $shortPage ?: '/';
            $clicks[] = $row->getClicks();
            $impressions[] = $row->getImpressions();
        }

        // Line Chart
        echo "<div style='height:350px; background:#fff; border-radius:12px; padding:20px; box-shadow:0 0 15px rgba(0,0,0,0.1); margin-top: 20px;'>
                <canvas id='seoChart'></canvas>
              </div>";

        echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
        <script>
        const ctxSeo = document.getElementById('seoChart').getContext('2d');
        const gradientClicks = ctxSeo.createLinearGradient(0, 0, 0, 300);
        gradientClicks.addColorStop(0, 'rgba(31, 45, 112, 0.6)');
        gradientClicks.addColorStop(1, 'rgba(31, 45, 112, 0)');

        const gradientImpressions = ctxSeo.createLinearGradient(0, 0, 0, 300);
        gradientImpressions.addColorStop(0, 'rgba(245, 166, 35, 0.6)');
        gradientImpressions.addColorStop(1, 'rgba(245, 166, 35, 0)');

        new Chart(ctxSeo, {
          type: 'line',
          data: {
            labels: " . json_encode($dates) . ",
            datasets: [
              {
                label: 'Clicks',
                data: " . json_encode($clicks) . ",
                fill: true,
                backgroundColor: gradientClicks,
                borderColor: '#1f2d70',
                tension: 0.4,
                pointBackgroundColor: '#1f2d70',
                pointRadius: 4
              },
              {
                label: 'Impressions',
                data: " . json_encode($impressions) . ",
                fill: true,
                backgroundColor: gradientImpressions,
                borderColor: '#f5a623',
                tension: 0.4,
                pointBackgroundColor: '#f5a623',
                pointRadius: 4
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                labels: {
                  color: '#333',
                  font: { size: 14, weight: 'bold' }
                }
              },
              tooltip: {
                backgroundColor: '#fff',
                titleColor: '#333',
                bodyColor: '#333',
                borderColor: '#ddd',
                borderWidth: 1
              }
            },
            scales: {
              x: { ticks: { color: '#666' }, grid: { color: '#eee' } },
              y: { beginAtZero: true, ticks: { color: '#666' }, grid: { color: '#eee' } }
            }
          }
        });
        </script>";

        // Table: Page-wise
        echo "<div class='table-responsive mt-4'>
              <h4>Page-wise SEO Data</h4>
              <table class='table table-bordered table-striped'>
                <thead class='table-dark'>
                    <tr><th>Page URL</th><th>Clicks</th><th>Impressions</th></tr>
                </thead><tbody>";
        foreach ($response->getRows() as $row) {
            echo "<tr>
                    <td>{$row->getKeys()[0]}</td>
                    <td>{$row->getClicks()}</td>
                    <td>{$row->getImpressions()}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>No SEO data available for <code>$finalUrl</code>.</p>";
    }

    // --------- COUNTRY-WISE ---------
    $countryRequest = new Google_Service_Webmasters_SearchAnalyticsQueryRequest([
        'startDate' => date('Y-m-d', strtotime('-7 days')),
        'endDate' => date('Y-m-d'),
        'dimensions' => ['country'],
        'rowLimit' => 100
    ]);
    $countryResponse = $service->searchanalytics->query($finalUrl, $countryRequest);

    if ($countryResponse->getRows()) {
        echo "<h4 class='mt-5'>Top Countries</h4>";
        echo "<div class='table-responsive'>
              <table class='table table-bordered'>
              <thead class='table-info'>
                <tr><th>Country Code</th><th>Clicks</th><th>Impressions</th></tr>
              </thead><tbody>";
        foreach ($countryResponse->getRows() as $row) {
            echo "<tr>
                    <td>{$row->getKeys()[0]}</td>
                    <td>{$row->getClicks()}</td>
                    <td>{$row->getImpressions()}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    }

    // --------- QUERY-WISE ---------
    $queryRequest = new Google_Service_Webmasters_SearchAnalyticsQueryRequest([
        'startDate' => date('Y-m-d', strtotime('-7 days')),
        'endDate' => date('Y-m-d'),
        'dimensions' => ['query'],
        'rowLimit' => 100
    ]);
    $queryResponse = $service->searchanalytics->query($finalUrl, $queryRequest);

    if ($queryResponse->getRows()) {
        echo "<h4 class='mt-5'>Top Search Queries</h4>";
        echo "<div class='table-responsive'>
              <table class='table table-bordered'>
              <thead class='table-success'>
                <tr><th>Query</th><th>Clicks</th><th>Impressions</th></tr>
              </thead><tbody>";
        foreach ($queryResponse->getRows() as $row) {
            $query = htmlspecialchars($row->getKeys()[0]);
            echo "<tr>
                    <td>{$query}</td>
                    <td>{$row->getClicks()}</td>
                    <td>{$row->getImpressions()}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    }

} else {
    echo "<p><strong>No matching brand found for this site.</strong></p>";
}
?>
