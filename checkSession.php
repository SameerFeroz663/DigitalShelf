<?php
if(!isset($_SESSION['id'])){
    header('location:./authenticate/Sign-In.php');
    exit;
}
?>