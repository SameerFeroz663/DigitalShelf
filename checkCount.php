<?php
include './conn.php'; // Your MySQLi connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

$brandId = $_GET['brand_id'] ?? null;

if (!$brandId) {
    echo json_encode(['error' => 'No brand ID provided']);
    exit;
}

$sql = "SELECT file FROM ContentFiles";
$result = $conn->query($sql);

$stats = [
    'images' => 0,
    'videos' => 0,
    'audios' => 0,
    'documents' => 0,
    'marketing' => 0,
    'total' => 0,
];

while ($row = $result->fetch_assoc()) {
    $file = $row['file'];
    $parts = explode('/', trim($file, '/'));

//    if (isset($parts[2]) && $parts[2] == $brandId) {

        $type = strtolower($parts[4] ?? '');

        switch ($type) {
            case 'images':
                $stats['images']++;
                break;
            case 'videos':
                $stats['videos']++;
                break;
            case 'audios':
                $stats['audios']++;
                break;
            case 'documents':
                $stats['documents']++;
                break;
            case 'marketing':
                $stats['marketing']++;
                break;
        }

        $stats['total']++;
//    }
}


echo json_encode($stats);
?>
