<?php
include './conn.php';

$sel = "SELECT * FROM brand WHERE klaviyoApi IS NOT NULL LIMIT 1";
$mysql = mysqli_query($conn, $sel);
$f = mysqli_fetch_assoc($mysql);
$apiKey = $f['klaviyoApi'];

$filter = rawurlencode("equals(messages.channel,'email')");
$url = "https://a.klaviyo.com/api/campaigns/?filter=$filter";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Klaviyo-API-Key ' . $apiKey,
        'revision: 2023-10-15',
        'Content-Type: application/json',
        'Accept: application/json'
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (!empty($data['data'])) {
        // Get the most recent campaign
        $campaign = $data['data'][0];

        // Extract metrics (use fallback if null)
        $metrics = $campaign['attributes']['reporting'] ?? [];

        $sent = $metrics['emails_sent'] ?? 0;
        $clickRate = $metrics['click_rate'] ?? 0;
        $conversionRate = $metrics['conversion_rate'] ?? 0;
        $bounceRate = $metrics['bounce_rate'] ?? 0;

        // Format to 2 decimals
        echo '
        <div class="metrics-grid">
          <div class="metrics-box">
            <h3>' . number_format($sent, 2) . '%</h3>
            <small>Sent</small>
          </div>
          <div class="metrics-box">
            <h3>' . number_format($conversionRate, 2) . '%</h3>
            <small>Conversion rate</small>
          </div>
          <div class="metrics-box">
            <h3>' . number_format($clickRate, 2) . '%</h3>
            <small>Click-through rate</small>
          </div>
          <div class="metrics-box">
            <h3>' . number_format($bounceRate, 2) . '%</h3>
            <small>Bounce rate</small>
          </div>
        </div>';
    } else {
        echo "<div class='text-muted'>No recent email campaigns found.</div>";
    }
} else {
    echo "<div class='text-danger'>Failed to fetch Klaviyo campaign metrics. HTTP $httpCode</div>";
}
?>
