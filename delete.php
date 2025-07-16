<?php

include './conn.php';
function deleteFolder($folder){
    if(!is_dir($folder))return;
    $subFiles = scanDir($folder);
    foreach($subFiles as $subFile){
        if($subFile == '.' || $subFile == '..')continue;
        $path = $folder . "/" . $subFile;
        if(is_dir($path)){
            deleteFolder($path);
        }
        else {
            unlink($path);
        }
    }
    rmdir($folder);
    
}
    
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $se = "SELECT * FROM metadata WHERE brandId = '$id'";
    $res = mysqli_query($conn,$se);
    $fetch = mysqli_fetch_assoc($res);
    $content_id = $fetch['id'];
    $qu = "DELETE FROM brand WHERE id ='$id'";
    $res1 = mysqli_query($conn, $qu);
    if($res1){
        $uploadFile = "Brand/" . $id;
        deleteFolder($uploadFile);
         $quq = "DELETE FROM ContentFiles WHERE content_id  ='$content_id'";
    $res1 = mysqli_query($conn, $quq);
        $quq = "DELETE FROM metadata WHERE brandId ='$id'";
    $res1 = mysqli_query($conn, $quq);
   
        header('location:./brandInsert.php?from=deleteBrand');
    }
}
?>