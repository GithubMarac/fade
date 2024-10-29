<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'schedule/_db.php';


use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

session_start();

$auth = [
    'VAPID' => [
        'subject' => 'mailto:me@website.com', // can be a mailto: or your website address
        'publicKey' => 'BC1oVqzxamKaEjLciec8nc7pMbKGcLNz8PO-eXcaylepUCyWz-pZ9u6XdlCeSVvIGLBrdlQS2YYPQNiN1caJsfg', // (recommended) uncompressed public key P-256 encoded in Base64-URL
        'privateKey' => 'AZzwR3QPimEEg7ixFowRZn6cSxbUxpqRK35V8S7M2Zo', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL 
    ],
];

$stmt = $db->prepare('SELECT * FROM events WHERE DATE(:start) = DATE(start)');

$stmt->bindParam(':start', date("Y-n-j", strtotime("+1 day")));

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

$repeatedFcm = [];

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['id'];
  $e->name = $row['name'];
  $e->start = $row['start'];
  
  $stmt = $db->prepare('SELECT * FROM users WHERE username = :user');

  $stmt->bindParam(':user', $e->name);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $hours = explode(" ", $e->start);

    foreach($result as $row) {
          $users = new Event();
          $users->fcm = $row['fcm'];
          $users->name = $row['username'];
          
          $webPush = new WebPush($auth);
          
          echo $users->fcm;
          
          if(isset($users->fcm) && !in_array($users->fcm, $repeatedFcm) && $users->name != "Roko marinovic"){
                      
            $report = $webPush->sendOneNotification(
                Subscription::create(json_decode($users->fcm,true))
                , '{"title":"BarberShop Fade" , "body":"Podsjećamo vas da imate sutra termin u '. substr($hours[1], 0, -3) .' sati" }', ['TTL' => 5000]);
            
            array_push($repeatedFcm, $users->fcm);
        
            print_r($report);

              
          }

    }


  $events[] = $e;
}






    
