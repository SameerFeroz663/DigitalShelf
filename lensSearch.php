<?php
//coded by samfer
ini_set('display_errors',1); error_reporting(E_ALL);
include './conn.php';              // your DB connection
require './hashFunctions.php';     // put loadImage(), imageHash(), hamming() here

if(!isset($_FILES['image']['tmp_name'])){
    http_response_code(400); exit('No file');
}

$tmpFile = $_FILES['image']['tmp_name'];

// ---- 1. generate perceptual hash of uploaded image ----
$hash = imageHash($tmpFile);
if($hash === false){
    http_response_code(415); exit('Unsupported image');
}
if(!$_GET['subfolder']){
    http_response_code(400); exit('No file');
}
$folders = $_GET['subfolder'];
$folder = urldecode($folders);
// ---- 2. pull ALL stored hashes (hash column must be NOT NULL) ----
$sql = "SELECT content_id, file, fileHash FROM ContentFiles
        WHERE fileHash IS NOT NULL AND file LIKE '%$folder%'";
$res = mysqli_query($conn, $sql);

$results = [];
while($row = mysqli_fetch_assoc($res)){
    $dist = hammingDistance($hash, $row['fileHash']);
    $results[] = [
        'file'     => $row['file'],
        'distance' => $dist
    ];
}

// ---- 3. sort by best match (lowest distance) ----
usort($results, fn($a,$b)=>$a['distance'] <=> $b['distance']);

// ---- 4. keep top N (e.g. 10) ----
$results = array_slice($results, 0, 3);

// ---- 5. return JSON ----
header('Content-Type: application/json');
echo json_encode($results);
exit;


// ---------- helper ----------
function hammingDistance(string $a, string $b): int{
    $len = min(strlen($a), strlen($b));
    $dist = 0;
    for($i=0;$i<$len;$i++){
        if($a[$i] !== $b[$i]) $dist++;
    }
    return $dist + abs(strlen($a)-strlen($b));
}
?>
