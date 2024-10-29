<?php 
/* 
 * Basic Site Settings and API Configuration 
 */ 
 
// Database configuration 
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'test'); 
define('DB_USER_TBL', 'users'); 
 
// Instagram API configuration 
define('INSTAGRAM_CLIENT_ID', '1173948849996226'); 
define('INSTAGRAM_CLIENT_SECRET', 'ba62b969ef20afcd945874a93d171ab4'); 
define('INSTAGRAM_REDIRECT_URI', 'https://localhost/schedule2/'); 
 
// Start session 
if(!session_id()){ 
    session_start(); 
} 


require_once 'InstagramAuth.class.php'; 
 
// Initiate Instagram Auth class 
$instagram = new InstagramAuth(array( 
    'client_id' => INSTAGRAM_CLIENT_ID, 
    'client_secret' => INSTAGRAM_CLIENT_SECRET, 
    'redirect_url' => INSTAGRAM_REDIRECT_URI 
)); 