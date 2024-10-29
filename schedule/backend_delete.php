<?php

require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

session_start();


if(!isset($_SESSION['admin'])){
	exit();
}



$insert = "DELETE FROM events WHERE id = :id";

$stmt = $db->prepare($insert);

$stmt->bindParam(":id", $_GET['id']);

$stmt->execute();



if(isset($_GET['block']) && $_GET['block'] == 'yes'){	
	$insert = "UPDATE users SET block = 1 WHERE oauth_uid = :user_id";
	$stmt = $db->prepare($insert);
	$stmt->bindParam(':user_id',  $_GET['user_id']);

	$stmt->execute();
}

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Delete successful';

header('Content-Type: application/json');
echo json_encode($response);
