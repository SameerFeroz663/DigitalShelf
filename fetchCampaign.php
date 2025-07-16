<?php
try {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include './conn.php';

    $stmt = $conn->prepare("SELECT * FROM brand WHERE shopify_url IS NOT NULL AND shopify_token IS NOT NULL LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = $result->fetch_assoc();
    if (!$brand) {
        echo "<tr><td colspan='5'>❌ No brand found.</td></tr>";
        return;
    }

    $shop = $brand['shopify_url'];
    $accessToken = $brand['shopify_token'];
    $url = "https://$shop/admin/api/2024-01/marketing_events.json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-Shopify-Access-Token: $accessToken"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  

    curl_close($ch);

    if ($httpCode !== 200) {
        echo "<tr><td colspan='5'>❌ Shopify API Error: HTTP $httpCode</td></tr>";
        return;
    }

    $data = json_decode($response, true);

    if (empty($data['marketing_events'])) {
        echo "<tr>
                    <td><img src='./shopify.png' alt='Shopify' style='width:auto;height:30px;' class='icon-img me-2'></td>
<td colspan='5'>ℹ️ No marketing events found for this brand.</td></tr>";
        return;
    }

    foreach ($data['marketing_events'] as $event) {
        echo "<tr>
            <td><img src='./shopify.png' alt='Shopify' class='icon-img me-2'></td>
            <td>" . htmlspecialchars($event['name'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($event['marketing_channel'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($event['utm_campaign'] ?? 'N/A') . "</td>
            <td>" . (isset($event['budget']) ? '$' . number_format($event['budget'], 2) : 'N/A') . "</td>
        </tr>";
    }
} catch (Throwable $e) {
    echo "<tr><td colspan='5'>❌ Error: " . $e->getMessage() . "</td></tr>";
}
?>
