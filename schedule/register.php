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

if(isset($_POST['register'])){
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    
    if(strlen($_POST['name'])<8){
        header("Location:register.php?err=" . urlencode("Ime i prezime mora sadržavati najmanje 8 znakova"));
        exit();
    }
   else if($_POST['password'] != $_POST['confirm_password']){
        header("Location:register.php?err=" . urlencode("Potvrda lozinke se ne podudara sa lozinkom"));
        exit();
   }
    else if(strlen($_POST['password']) < 5){
         header("Location:register.php?err=" . urlencode("Lozinka mora imati najmanje 5 znakova"));
        exit();
    }
  
    else if(!isUnique($_POST['email'])){
        header("Location:register.php?err=" . urlencode("Email je već zauzet."));
        exit();
    }
   
    else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        
        $query = "insert into users (username,email,oauth_uid,password,token) values('$name','$email','$email','$password','$token')";
        
        $db->query($query);
        $message = "Dobrodošli $name! Molimo vas aktivirajte svoj Email: https://barbershopfade.com.hr/schedule/activate.php?token=$token";
        
        mail($email , 'Aktivacija Profila' , $message , 'From: noreply@barbershopfade.com.hr');
        header("Location:index.php?success=" . urlencode("Poslana aktivacija na Email"));
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
 <form  action="register.php" method="post" style="margin-top:35px;">
         <h2>Registracija</h2>
         
         <?php if(isset($_GET['err'])) { ?>
         
         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>
         
         <?php } ?>
         <hr>
         <div class="form-group">
    <input type="text" name="name" class="form-control" placeholder="Ime i Prezime" value="<?php echo @$_SESSION['name']; ?>" required>
  </div>
     
  <div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="Email adresa" value="<?php echo @$_SESSION['email']; ?>" required>
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control" placeholder="Lozinka" value="<?php echo @$_SESSION['password']; ?>" required>
  </div>
 
 <div class="form-group">
    <input type="password" name="confirm_password" class="form-control" placeholder="Potvrdi lozinku" value="<?php echo @$_SESSION['confirm_password']; ?>" required>
  </div>
 
  <button type="submit" name="register" class="btn btn-primary">Registriraj se</button>
</form>
</main>
</body>