<?php
include './conn.php';

$selectedBrandId = $_GET['brand_id'] ?? '';

// Fetch brands for dropdown
$brands = [];
$brandQuery = mysqli_query($conn, "SELECT id, name FROM brand WHERE klaviyoApi IS NOT NULL");
while ($row = mysqli_fetch_assoc($brandQuery)) {
    $brands[] = $row;
}

// Brand dropdown
echo '<form method="GET" style="margin-bottom:20px;">
    <label>Select Brand: </label>
    <select name="brand_id" onchange="this.form.submit()">
        <option value="">-- Select Brand --</option>';

foreach ($brands as $b) {
    $selected = ($b['id'] == $selectedBrandId) ? 'selected' : '';
    echo "<option value='{$b['id']}' $selected>{$b['name']}</option>";
}

echo '</select></form>';

// If no brand selected, stop here
if (!$selectedBrandId) {
    echo "<p>Please select a brand to view Klaviyo campaigns.</p>";
    exit;
}

// Fetch Klaviyo API key for selected brand
$brandQuery = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$selectedBrandId' AND klaviyoApi IS NOT NULL LIMIT 1");
$brand = mysqli_fetch_assoc($brandQuery);

if (!$brand) {
    echo "<p class='text-danger'>❌ Invalid brand selected or missing API key.</p>";
    exit;
}

$apiKey = $brand['klaviyoApi'];
$brandName = $brand['name'];

// Klaviyo API call
$filter = rawurlencode("equals(messages.channel,'email')");
$url = "https://a.klaviyo.com/api/campaigns/?filter=$filter&sort=-created_at";

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
        echo "<h2>📧 Klaviyo Campaigns - " . htmlspecialchars($brandName) . "</h2>";

        echo '<table id="example">
            <thead>
                <tr>
                    <th>Campaign Name</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Send Time</th>
                    <th>Sent</th>
                    <th>Open Rate</th>
                    <th>Click Rate</th>
                    <th>Bounce Rate</th>
                    <th>Conversion Rate</th>
                </tr>
            </thead><tbody>';

        foreach ($data['data'] as $campaign) {
            $attr = $campaign['attributes'];
            $report = $attr['reporting'] ?? [];

            echo '<tr>
                <td>' . htmlspecialchars($attr['name'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($attr['subject'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($attr['status'] ?? 'N/A') . '</td>
                <td>' . (!empty($attr['send_time']) ? date("Y-m-d H:i", strtotime($attr['send_time'])) : 'N/A') . '</td>
                <td>' . number_format($report['emails_sent'] ?? 0) . '</td>
                <td>' . number_format($report['open_rate'] ?? 0, 2) . '%</td>
                <td>' . number_format($report['click_rate'] ?? 0, 2) . '%</td>
                <td>' . number_format($report['bounce_rate'] ?? 0, 2) . '%</td>
                <td>' . number_format($report['conversion_rate'] ?? 0, 2) . '%</td>
            </tr>';
        }

        echo '</tbody></table><br>';
    } else {
        echo "<div class='text-muted'>ℹ️ No recent email campaigns found.</div>";
    }
} else {
    echo "<div class='text-danger'>❌ Failed to fetch campaigns. HTTP $httpCode</div>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>
