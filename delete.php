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
    $qu = "DELETE FROM brand WHERE id ='$id'";
    $res1 = mysqli_query($conn, $qu);
    if($res1){
        $uploadFile = "Brand/" . $id;
        deleteFolder($uploadFile);
        header('location:./brandInsert.php?from=deleteBrand');
    }
}
?>