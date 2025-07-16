<?php
session_start();
$id = $_SESSION['id'];
$rowew = mysqli_connect("localhost","u125659184_user","pMVxpkIx/v~0","u125659184_digital_shelf");
if(!$rowew) {
    die("Connection failed: " . mysqli_connect_error());
}
$roleChecking = "SELECT * FROM userroles WHERE user_id = '$id'";
$res = mysqli_query($rowew,$roleChecking);
$fec = mysqli_fetch_assoc($res);
if($fec['role_id'] == 1){
    echo "<script>
        alert('Only Admin Can Access');
        window.history.back();
    </script>";
}
?>