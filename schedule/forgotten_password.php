<?php
require_once '_db.php';

session_start();

function loggedIn(){
    if(isset($_SESSION['username'])){
        return true;
    }else return false;
}

if(loggedIn()){
    header("Location:index.php");
    exit();
}

function isUnique($email){
	global $db;
    $query = "SELECT * from users where email='$email'";
    
    $result = $db->query($query);
    
    if($result->fetchColumn() > 0){
        return false;
    }
    else return true;
    
}

if(isset($_POST['email'])){
	if(isUnique($_POST['email'])){
        header("Location:forgotten_password.php?err=" . urlencode("Email ne postoji u bazi podataka."));
        exit();
    }
   
    else {
        $email = $_POST['email'];
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        
        $query = "update users set reset_token = '$token' where email = '$email'";
        
        $db->query($query);
        $message = "Resetiraj lozinku https://barbershopfade.com.hr/schedule/reset.php?token=$token";
        
        mail($email , 'Resetiraj Lozinku' , $message , 'From: noreply@barbershopfade.com.hr');
        header("Location:index.php?success=" . urlencode("Poslan link za reset lozinke na Email"));
        exit();
    }
   
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>BarberShop Fade</title>



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="custom.css">
	<style>
	* {
		margin: 5px;
	}
	</style>



</head>
<body style="background-color: #1d2124">
<main style="color:white; text-align: left;">
 <form  action="forgotten_password.php" method="post" style="margin-top:35px;">
         <h2>Zaboravljena lozinka</h2>
         
         <?php if(isset($_GET['err'])) { ?>
         
         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>
         
         <?php } ?>
         <hr>
         <div class="form-group">
    <input type="text" name="email" class="form-control" placeholder="Email" value="" required>
  </div>
 
  <button type="submit" name="register" class="btn btn-primary">Resetiraj lozinku</button>
</form>
</main>
</body>