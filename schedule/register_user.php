<?php
require_once '_db.php';
session_start();

$json = file_get_contents('php://input');
$params = json_decode($json);

$prevQuery = "SELECT * FROM users WHERE oauth_provider = 'facebook' AND oauth_uid = '".$_GET['oauth_id']."'"; 
            $prevResult = $db->query($prevQuery)->fetchColumn();
            if($prevResult > 0){ 
				$_SESSION["username"] = $_GET['username'];
				$_SESSION["oauth_id"] = $_GET['oauth_id'];
            }else{ 
				$insert = "INSERT INTO users (oauth_provider, oauth_uid, username) VALUES ('facebook', :oauth_id, :username)";

				$stmt = $db->prepare($insert);

				$stmt->bindParam(':username', $_GET['username']); 
				$stmt->bindParam(':oauth_id', $_GET['oauth_id']); 
				$stmt->execute();

				$_SESSION["username"] = $_GET['username'];
				$_SESSION["oauth_id"] = $_GET['oauth_id'];
            } 
			
			
$query = "SELECT * FROM users WHERE oauth_uid = '".$_GET['oauth_id']."' AND admin = 1"; 
$result = $db->query($query)->fetchColumn();

if($result > 0){
	$_SESSION["admin"] = 1;
}


class Result {}

$response = new Result();
$response->result = $_SESSION["username"];
$response->message = 'Created with id: ';
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
header("Refresh:0");