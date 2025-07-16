<?php
//coded by samfer
function loadImage($file) {
    $type = mime_content_type($file);

    switch ($type) {
        case 'image/jpeg':
            return imagecreatefromjpeg($file);
        case 'image/png':
            return imagecreatefrompng($file);
        case 'image/gif':
            return imagecreatefromgif($file);
        case 'image/webp':
            return imagecreatefromwebp($file);
        case 'image/bmp':
            return imagecreatefrombmp($file);
        default:
            return false;
    }
}

function imageHash($file) {
    $size = 8;
    $img = loadImage($file);
    if (!$img) return false;

    $img = imagescale($img, $size, $size);
    imagefilter($img, IMG_FILTER_GRAYSCALE);

    $pixels = [];
    $total = 0;
    for ($y = 0; $y < $size; $y++) {
        for ($x = 0; $x < $size; $x++) {
            $gray = imagecolorat($img, $x, $y) & 0xFF;
            $pixels[] = $gray;
            $total += $gray;
        }
    }
    $avg = $total / count($pixels);

    $hash = '';
    foreach ($pixels as $pixel) {
        $hash .= ($pixel >= $avg) ? '1' : '0';
    }

    return $hash;
}
?>