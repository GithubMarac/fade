<?php

require_once '_db.php';
session_start();

$json = file_get_contents('php://input');
$params = json_decode($json);

$token = $_GET['token'];
$username = $_SESSION["oauth_id"];


$update = "UPDATE users SET fcm =?  WHERE oauth_uid=?";

$stmt = $db->prepare($update);
$stmt->execute([$token, $username]);

?>