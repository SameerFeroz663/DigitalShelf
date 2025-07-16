<?php

include './authenticate/conn.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qu = "DELETE FROM users WHERE id ='$id'";
    $res1 = mysqli_query($conn, $qu);
    if($res1){
        header('location:./users.php');
    }
}
?>