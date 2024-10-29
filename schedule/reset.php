<?php
require_once '_db.php';

session_start();

$token = $_GET['token'];

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

if(isset($_POST['confirm_password'])){
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    
   if($_POST['password'] != $_POST['confirm_password']){
        header("Location:reset.php?err=" . urlencode("Potvrda lozinke se ne podudara sa lozinkom"));
        exit();
   }
    else if(strlen($_POST['password']) < 5){
         header("Location:reset.php?err=" . urlencode("Lozinka mora imati najmanje 5 znakova"));
        exit();
    }
   
    else {
        
        $token = $_POST['token'];
        $password = md5($_POST['password']);
        
        $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = '$token'");

        $stmt->bindParam(':token', $_GET['token']);
        
        $stmt->execute();
        $result = $stmt->fetchColumn();
        
                
                
        $insert = "UPDATE users SET password = '$password' WHERE id = '$result'";

        $stmt = $db->prepare($insert);
        
        $stmt->execute();
        
                header("Location:index.php?success=" . urlencode("Uspješno resetirana lozinka Email"));
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
 <form  action="reset.php" method="post" style="margin-top:35px;">
         <h2>Reset Lozinke</h2>
         
         <?php if(isset($_GET['err'])) { ?>
         
         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>
         
         <?php } ?>
         <hr>
         
         <?php 
         

         
         ?>
         
  <div class="form-group">
    <input type="password" name="password" class="form-control" placeholder="Lozinka" value="<?php echo @$_SESSION['password']; ?>" required>
  </div>
 
 <div class="form-group">
    <input type="password" name="confirm_password" class="form-control" placeholder="Potvrdi lozinku" value="<?php echo @$_SESSION['confirm_password']; ?>" required>
  </div>
  
  <input name="token" hidden value="<?php echo $token; ?>" /> 
 
  <button type="submit" name="register" class="btn btn-primary">Registriraj lozinku</button>
</form>
</main>
</body>