<?php
require_once '_db.php';

session_start();

$stmt = $db->prepare('SELECT * FROM events WHERE DATE(:start) = DATE(start) AND barber_id = :barber');

$stmt->bindParam(':barber', $_GET['barber']);
$stmt->bindParam(':start', $_GET['start']);

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['id'];
  if($row['name'] == str_replace('"', '', $_SESSION["username"]) || isset($_SESSION["admin"])){
	    $e->text = $row['name'];
		$e->resource = $row['resource'];
		$e->oauth_id = $row['oauth_id'];
  }
  $e->start = $row['start'];
  $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);
