<?php
include './conn.php';

function deleteFolder($path,$isroot=true){
    if (!is_dir($path)) return;

    $files = scandir($path);
    foreach ($files as $file) {
        if ($file === '..' || $file === '.') continue;
        if ($file === 'index.php' && $isroot ) {
            continue;
        }

        $full = $path . '/' . $file;

        if (is_dir($full)) {
            deleteFolder($full,false);
        } else {
            @chmod($full, 0777);
            @unlink($full);
        }
    }
    
    @chmod($path, 0777);
    @rmdir($path);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sel = "SELECT * FROM ContentFiles WHERE content_id = '$id' ";
    $res = mysqli_query($conn,$sel);
    $fetch = mysqli_fetch_assoc($res);
    $file = $fetch['file'];
    $parts = explode("/", $file);
    $brandId = $parts[2];
    $dir = "./Brand/$brandId";
    deleteFolder($dir,true);
    $qu = "DELETE FROM metadata WHERE id ='$id'";
    $res1 = mysqli_query($conn, $qu);

    if ($res1) {
        header('location:./datalisting.php?from=deleteContent');
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
}
?>
