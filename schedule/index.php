<?php 
// Include configuration file 
require_once 'config.php'; 
require_once '_db.php';




header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");



function loggedIn(){
    if(isset($_SESSION['username'])){
        echo 'dsadsadsadsadsa';
        return true;
    }else return false;
}


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $query = "select * from users where email='$email' and password='$password'";
    
    $result = $db->query($query);
    
    if($row = $result->fetch()){
        if($row['status'] == 1){
            if($row['admin'] == 1){
               $_SESSION["admin"] = true;
            }
			$_SESSION['username'] = $row['username'];
			$_SESSION["oauth_id"] = $row['email'];
             echo "<script>location.href='index.php';</script>";
              
        }else {
                echo "<script>location.href='index.php?err=Molimo vas potvrdite svoj email!';</script>";
        }
    }else {
                echo "<script>location.href='index.php?err=Krivi Email ili lozinka!';</script>";
    }
}

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin" />
  <title>BarberShop Fade</title>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="custom.css">


  
  
  <script src="https://accounts.google.com/gsi/client"></script>


	<?php
		if(!isset($_SESSION["admin"])){
			echo "
			<script type='text/javascript'>
			    function changeDate(date) {
			    let today, tommorow, yesterday;
		const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
		const options2 = { weekday: 'short', month: 'short', day: 'numeric' };
		if (date == 0){
		    pickedDay = new Date();
			if (new Date().getDay() == 6){
				pickedDay.setDate(pickedDay.getDate() + 2);
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else if(new Date().getDay() == 0){
				pickedDay.setDate(pickedDay.getDate() + 1);
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else{
				pickedDay = new Date();
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}
		}else if(date == 1){
			if((pickedDay.getTime() - (new Date().getTime())) / (1000 * 3600 * 24) > 35){
				return;
			}
			if (pickedDay.getDay() == 5){
				pickedDay.setDate(pickedDay.getDate() + 3)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else if(pickedDay.getDay() == 6){
				pickedDay.setDate(pickedDay.getDate() + 2)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else{
				pickedDay.setDate(pickedDay.getDate() + 1)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}

		}else if(date == -1 && pickedDay > new Date()){
			if (pickedDay.getDay() == 1){
				pickedDay.setDate(pickedDay.getDate() - 3)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else{
				pickedDay.setDate(pickedDay.getDate() - 1)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}

		}
		
		    today = new Date(pickedDay.getDate());
			tommorow = new Date((new Date).setDate((today.getDate() + 1)));
			yesterday = new Date((new Date).setDate((today.getDate() - 1)));
		
			if (pickedDay.getDay() == 5){
				tommorow = new Date((new Date).setDate((pickedDay.getDate() + 3)));
				yesterday = new Date((new Date).setDate((pickedDay.getDate() - 1)));
			}else if(pickedDay.getDay() == 1){
				tommorow = new Date((new Date).setDate((pickedDay.getDate() + 1)));
				yesterday = new Date((new Date).setDate((pickedDay.getDate() - 3)));
			}else{
				tommorow = new Date((new Date).setDate((pickedDay.getDate() + 1)));
				yesterday = new Date((new Date).setDate((pickedDay.getDate() - 1)));
			}
			

			

			
		load_events();
    }
	</script>";
		}else{
			echo "
			<script type='text/javascript'>
			    function changeDate(date) {
			    let tommorow, yesterday;
		const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
		if (date == 0){
				pickedDay = new Date();
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
		}else if(date == 1){
				pickedDay.setDate(pickedDay.getDate() + 1)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
		}else if(date == -1){
			if (pickedDay.getDay() == 1){
				pickedDay.setDate(pickedDay.getDate() - 1)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}else{
				pickedDay.setDate(pickedDay.getDate() - 1)
				current_date = document.getElementById('todaysDate').innerHTML = pickedDay.toLocaleDateString('hr-HR', options);
				mysql_date = getMysqlDate(pickedDay);
			}

		}
		
					console.log(pickedDay);
					
		const options2 = { weekday: 'short', month: 'short', day: 'numeric' };
			tommorow = new Date((new Date).setDate((pickedDay.getDate() + 1)));
			yesterday = new Date((new Date).setDate((pickedDay.getDate() - 1)));


			
		load_events();
		}</script>";
			
		}
	?>
	  


</head>
<body style="background-color: #1d2124">

<div class="main" >

  <div style="display: block" style="background-color: #555555">
<?php
	if(isset($_SESSION["oauth_id"])){
	    
	    echo '<div class="alert alert-success fade show p-2 m-0" role="alert">
    	 <p class="text-center"> Uspješno odabran termin! </p>
    	</div>';
		
		echo '<div style="display: flex; text-align: center; background-color: #1d2124">
		<a onclick="changeDate(-1);" class="btn btn btn-dark" href="#" style="width: 50%;" id="previous"><<<</a>
		<a onclick="changeDate(1);" class="btn btn btn-dark" href="#" style="width: 50%;" id="next">>>></a>
    </div>
	
		<table class="table table-bordered table-dark" style="width: 100%;">
  <thead>
	<tr>
	<th onclick="changeBarber()" id="barber" style="text-align: center;"colspan="2">
		Odaberite Barbera
	</th>
    </tr>
    <tr>
      <th scope="col">#</th>
      <th id="todaysDate" scope="col"></th>
    </tr>
  </thead>
  <tbody>
 <tr id="terminSlot">
	  <th scope="row">10:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">10:30</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">11:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">11:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">12:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">12:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">13:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">13:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">14:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">14:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">15:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">15:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">16:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">16:30</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">17:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">17:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">18:00</th>
	  <td colspan="2">
	  </td>
  <tr>';
  
  if((isset($_SESSION["admin"]))){
      echo '
        <tr id="terminSlot">
	  <th scope="row">18:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">19:00</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">19:30</th>
	  <td colspan="2">
	  </td>
	</tr>
  <tr id="terminSlot">
	  <th scope="row">20:00</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">20:30</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">21:00</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">21:30</th>
	  <td colspan="2">
	  </td>
	</tr>
	  <tr id="terminSlot">
	  <th scope="row">22:00</th>
	  <td colspan="2">
	  </td>
	</tr>';
  }
  
  echo '
	</tbody>
</table>
  
  
  <div style="text-align: center;">
	<a href="https://barbershopfade.com.hr/privacy.html">Privacy Policy URL</a> |
	<a href="logout.php">Logout</a> |
	<a href="delete_account.php">Delete Account</a> |
  </div>
  ';
 }else{
	echo '
	<div style="display: flex; flex-direction: column; align-items:center; padding: 25px; text-align: center; row-gap: 20px;  background-color: #1d2124;">
	<p style="font-weight: bold; color:white; text-align: center;">Kako bi nastavili dalje ulogirajte se putem Email-a ili Google account-a</p>
	
 
    	
<div id="googleDiv"></div>
 
		<fb:login-button size="xlarge"
  scope="public_profile,email"
  onlogin="checkLoginState();" style="display: none;">
	Continue with Facebook</fb:login-button>
	 <form action="index.php" method="post" style="margin-top:35px; width: 100%; margin-bottom: 15px;">';
         
		if(isset($_GET['success'])) { 
			echo '<div class="alert alert-success">'. $_GET['success'] .'</div>';
		 }
         if(isset($_GET['err'])) {
			 echo '<div class="alert alert-danger">'.$_GET['err'].'</div>';
		}
		
	echo '

	  <div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="Email adresa">
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control" placeholder="Lozinka">
  </div>
 
 <div style="display: flex; align-items: center; justify-content: center; justify-content: space-around;">
 <button type="submit" name="login" class="btn btn-outline-danger">Prijava</button>
 <a class="btn btn-outline-danger" href="register.php" role="button">Registriraj se</a>
    </div>

</form>
';
  echo '
	<a href="forgotten_password.php" style="margin-top: 10px;">Zaboravljena lozinka?</a>
	<a href="https://barbershopfade.com.hr/privacy.html">Privacy Policy URL</a></div>';

}

?>


  </div>
</div>

  

    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            	<div class="alert alert-danger fade show" id="dupliTermin" role="alert">
            		Već imate 3 odabrana termina!
            	</div>
            	<div class="alert alert-danger fade show" id="accountBlocked" role="alert">
            		Account je blokiran, kako bih ga odblokirala nazovite BarberShop Fade!
            	</div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ugovori Termin</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Odabrali ste termin: </p>
					<p id="termin"></p>
					<p id="termin2"></p>
					<p>Unesite broj telefona:</p>
					 <input style="margin-bottom: 12px;" type="text" class="form-control" id="phoneNumber" placeholder="Broj telefona">
					<p>Molim vas ispoštujte svoj termin.</p>
					<p style="color: red;">Ukoliko želite otkazati termin nazovite BarberShop Fade.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                    <button type="button" id="accept_button" class="btn btn-primary">Prihvati</button>
                </div>
            </div>
        </div>
	</div>
	
	    <div id="myModal2" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificiraj Termin</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
					<p id="username"></p>
					<a id="brojtelefona" href="tel:123-456-7890">123-456-7890</a>
					<p style="color: red;">Ukoliko želite otkazati termin nazovite BarberShop Fade.</p>
                </div>
                <div class="modal-footer">
				<?php
				if(isset($_SESSION["admin"])){
					echo'
                    <button id="cancelAppoitment" type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
					<button id="blockAppoitment" type="button" class="btn btn-secondary" data-dismiss="modal">Blokiraj</button>
					';
				}
				?>
                </div>
            </div>
        </div>
	</div>
	
			<div id="barberModal" class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Odaberite Barbera</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<h2 style="text-align: center;" onclick="chooseBarber(1);">Roko Marinović</h2>
			<br/>
			<h2 style="text-align: center;" onclick="chooseBarber(2);">David Nagy</h2>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
		  </div>
		</div>
	  </div>
	</div>

	

	
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

<script>
$('.alert-success').hide();
$('#dupliTermin').hide();
$('#accountBlocked').hide();

let barber_id;
let appoitment_id, oauth_id;
let current_date, mysql_date;
let pickedDay = new Date();


function chooseBarber(barber){
	this.barber_id = barber;

	$("#barberModal").modal('hide');
	
	if(barber == 1){
		$("#barber").html("Roko Marinović");
	}else if(barber == 2){
		$("#barber").html("David Nagy");
	}
	
	load_events();
}

  
      function decodeJwtResponse (token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    
        return JSON.parse(jsonPayload);
    }

    function handleAuth(response){
      // decodeJwtResponse() is a custom function defined by you
      // to decode the credential response.
      responsePayload = decodeJwtResponse(response.credential);
      
      if(responsePayload.name){
                checkLoginStateGoogle(responsePayload.name, responsePayload.sub);
      }
    }
    
    
    $( window ).on( "load", 
        function () {
            google.accounts.id.initialize({
              client_id: "1004305002098-e0tvac2dm3p07ou9f9jsgc9akkpqhdrm.apps.googleusercontent.com",
              callback: handleAuth,
            });
            google.accounts.id.renderButton(
              document.getElementById("googleDiv"),
              { theme: "outline", size: "large" }  // customization attributes
            );
            google.accounts.id.prompt(); // also display the One Tap dialog
          }
    
    );



  window.fbAsyncInit = function() {
    FB.init({
      appId      : '519211766763596',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.7'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	changeDate(0);

	$("#cancelAppoitment").click(function(){
				$.ajax({url: "backend_delete.php?id=" + appoitment_id, success: function(result){
				load_events();
	}});
	});
	
    $("#blockAppoitment").confirm({
        

            title:"Blokiraj",
            text:"Da li zelite blokirati?",
            confirm: function(button) {
            				$.ajax({url: "backend_delete.php?block=yes&id=" + appoitment_id + "&user_id=" + oauth_id, success: function(result){
	                    	load_events();
                    }});
            },
            cancel: function(button) {

            },
            confirmButton: "Da",
            cancelButton: "Ne"
    });

	
	function changeBarber(){
		$('#barberModal').modal('show');
	}
	
	

	function load_events(){
		$("td").toArray().forEach(function(item) {
			item.innerHTML = "<p style='padding: 3px;'>Termin slobodan</p>";
		});
		
		if(this.barber_id == undefined){
			$('tr#terminSlot').click(function(e){
				changeBarber();
			}); 
		}else{
			for (var i = 1 ; i < $('th').length; i++) {
				$('tr').off("click");
				$('tr#terminSlot').click(function(e){
				$('#termin').text(current_date);
				$('#termin2').text(e.currentTarget.cells[0].innerHTML);
				$('#myModal').modal("show");
				}); 
			}
		}
		$.ajax({url: "backend_events.php?barber=" +  this.barber_id + "&start=" + mysql_date, success: function(result){
				result.forEach(function(item, index) {
					let timeSchedule = item.start.split(/(\s+)/)[2].slice(0, 5);
					$("th:contains(" + timeSchedule + ")").parent().off("click");
					if(item.text === undefined){ 
					item.text = "Termin Zauzet";
					item.resource = "";
					
					try {
					$("th:contains(" + timeSchedule + ")").next()[0].innerHTML = "<div class='taken'><p>" + item.text + "</p><p>" + item.resource +"</p></div>";
					} catch (error) {
					  console.error(error);
					}
					}else{
    					try {
						$("th:contains(" + timeSchedule + ")").next()[0].innerHTML = "<div class='taken'><p>" + item.text + "</p><p>" + item.resource +"</p></div>";
						$("th:contains(" + timeSchedule + ")").parent().click(function(e){
						oauth_id = item.oauth_id;
						appoitment_id = item.id
						console.log(item.id);
					   $('#username').text(item.text);
					   $('#brojtelefona').text(item.resource);
					   $('#brojtelefona').attr("href", "tel:" + item.resource);
					   $('#myModal2').modal('show');
					});
    					} catch (error) {
					  console.error(error);
					}
					};
				});
				console.log(result);
		}});	
	}
	
	
	load_events();
	
	
	$("#accept_button").click(function(){
	    
	    let barber;
	    if($('#barber')[0].innerText == 'Roko Marinović'){
	        barber = 1;
	    }else if($('#barber')[0].innerText == 'David Nagy'){
	        barber = 2;
	    }
	    


		if ($("#phoneNumber").val().length < 6){
			$("#phoneNumber").addClass("is-invalid");
		}else{
		  $.ajax({url: "backend_create.php?start=" + mysql_date + " " + $("#termin2").html() + "&resource=" + $("#phoneNumber").val() + "&barber=" + barber, success: function(result){

				if(result.includes("Okej")){
					$("#phoneNumber").removeClass("is-invalid");
					$('.alert-success').show().fadeOut(3000);
					$('#myModal').modal('hide');

				}else if(result == "Dupli termin"){
					$('#dupliTermin').show().fadeOut(3000);
				}else if(result == "Account blokiran"){
					$('#accountBlocked').show().fadeOut(3000);
				}
			load_events();
			
			}});
		}
		
		enableNotif();
	});
	
	changeBarber();

	let time = ["10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30"];
	



	function getMysqlDate(date){
	    let year = date.getFullYear();
	    let month = date.getMonth() + 1;
	    let day = date.getDate();
	    
	    return year + "-" + month + "-" + day;
	}


   function checkLoginState() {
	  FB.getLoginStatus(function(response) {
		FB.api('/me', function(response) {
				  $.ajax({url: "register_user.php?username=" + JSON.stringify(response.name).replace(/['"]+/g, '') + "&oauth_id=" + JSON.stringify(response.id).replace(/['"]+/g, ''), success: function(result){
				location.reload();
			  }});	
		});
	  });
}


   function checkLoginStateGoogle(username, oauthid) {
		  $.ajax({url: "register_user.php?username=" + username + "&oauth_id=" + oauthid, success: function(result){
		location.reload();
	  }});	
    }
	
	

</script>

 <script>
        navigator.serviceWorker.register("sw.js");

        function enableNotif() {
            Notification.requestPermission().then((permission)=> {
                if (permission === 'granted') {
                    // get service worker
                    navigator.serviceWorker.ready.then((sw)=> {
                        // subscribe
                        sw.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: "BC1oVqzxamKaEjLciec8nc7pMbKGcLNz8PO-eXcaylepUCyWz-pZ9u6XdlCeSVvIGLBrdlQS2YYPQNiN1caJsfg"
                        }).then((subscription)=> {
                            		  $.ajax({url: "register_fcm.php?token=" + JSON.stringify(subscription), success: function(result){

                                	  }});
                            console.log(JSON.stringify(subscription));
                        });
                    });
                }
            });
        }
    </script>

</body>
</html>

