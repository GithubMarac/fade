<?php
require_once 'config.php'; 
require_once '_db.php';

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $query = "update users set status='1' where token='$token'";
    if($db->query($query)){
        header("Location:index.php?success=Account Activated!!");
        exit();
    }
    
}

?>