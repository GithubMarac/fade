<?php 
require_once '_db.php';

session_start();

$stmt = $db->prepare('DELETE * FROM users WHERE oauth_id =' . $_SESSION["oauth_id"]);

$stmt->execute();

header('Content-Type: application/json');
echo json_encode('Account deleted');
header("Location: index.html");

?>