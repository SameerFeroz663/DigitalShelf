<?php
include './conn.php';

function deleteEmptyFolders($path, $stopAt = './Brand') {
    while (is_dir($path) && count(scandir($path)) === 2) {
        @rmdir($path);
        $path = dirname($path);
        if ($path === $stopAt) break;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sel = "SELECT * FROM ContentFiles WHERE content_id = '$id'";
    $res = mysqli_query($conn, $sel);

    while ($fetch = mysqli_fetch_assoc($res)) {
        $filePath = $fetch['file']; // e.g., ./Brand/36/Images/file.jpg

        if (file_exists($filePath)) {
            @chmod($filePath, 0777);
            @unlink($filePath);

            // After deleting the file, clean up empty folders (optional)
            $folder = dirname($filePath); // ./Brand/36/Images
            deleteEmptyFolders($folder);
        }
    }

    // Then delete DB rows
    mysqli_query($conn, "DELETE FROM ContentFiles WHERE content_id = '$id'");
    $res1 = mysqli_query($conn, "DELETE FROM metadata WHERE id = '$id'");

    if ($res1) {
        header('Location: ./datalisting.php?from=deleteContent');
        exit;
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
}
?>
