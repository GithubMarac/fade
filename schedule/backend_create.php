<?php
require_once '_db.php';

session_start();

$json = file_get_contents('php://input');
$params = json_decode($json);

$query = "SELECT * FROM users WHERE oauth_uid = '". $_SESSION['oauth_id'] ."' AND block = 1";

$stmt = $db->query($query)->fetchColumn();

if($stmt > 0){
	exit("Account blokiran");
}


$query = "SELECT * FROM events WHERE start = '". $_GET['start'] ."' AND barber_id = '". $_GET['barber'] ."'";
$stmt = $db->query($query)->fetchColumn();

if($stmt > 0){
	exit("Termin postoji");
}

$query = "SELECT * FROM events WHERE start >= CURDATE() AND oauth_id = '". $_SESSION["oauth_id"] ."'" ;
$stmt = $db->query($query)->rowCount();
if($stmt >= 3 && !isset($_SESSION["admin"])){
	exit("Dupli termin");
}


$insert = "INSERT INTO events (name, start, end, resource, oauth_id, barber_id) VALUES (:name, :start, :end, :resource, :oauth_id, :barber_id)";

$stmt = $db->prepare($insert);

$stmt->bindParam(':start', $_GET['start']); 
$stmt->bindParam(':end',  $_GET['end']);
$stmt->bindParam(':name', str_replace('"', '', $_SESSION["username"]));
$stmt->bindParam(':resource',  $_GET["resource"]);
$stmt->bindParam(':barber_id',  $_GET["barber"]);
$stmt->bindParam(':oauth_id',  $_SESSION["oauth_id"]);
$stmt->execute();

exit("Okej");

class Result {}

$response = new Result();
$response->result = "OK";
$response->message = 'Created with id: '.$db->lastInsertId();
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
