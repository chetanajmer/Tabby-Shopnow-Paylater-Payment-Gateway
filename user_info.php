<?php

include_once('includes/global.php'); 

?>

<?php

if(isset($_POST['submit1']) && isset($_SESSION['bg_basket']) && is_numeric($_SESSION['bg_basket'])) { 				 



	if($userid =="")



	{



	$uname=$_POST['uname'];



	$password=$_POST['pass'];



	$qry="insert into users(uname,password,created_on,active)values('$uname','$password',now(),'y')";



	mysql_query($qry)	or die("Err #:".mysql_errno().' Error:'.mysql_error());

	



	$qry="select * from users where uname='". $uname ."' and password='". $password ."' and active='y'";



	$result=mysql_query($qry);



	$row = mysql_fetch_array($result);



	$nume=mysql_num_rows($result);

	$coupon_id=$_SESSION['coupon_id'];		

	

	if($coupon_id !=''){

	$Query = "UPDATE coupon SET uses_total = uses_total - 1,uses_count = uses_count + 1 WHERE coupon_id =".$_SESSION['coupon_id'] ;		

	mysql_query($Query);

	}

	



	$updateSQL = sprintf("UPDATE basket SET userid=%s,ui_fname=%s, ui_lname=%s, ui_contact=%s, ui_company=%s, ui_address1=%s, ui_address2=%s, ui_city=%s, ui_emirates=%s,order_notes=%s,coupon_id=%s WHERE id=".GetSQLValueString(trim($_SESSION['bg_basket']),'int'),



		  GetSQLValueString(trim($row['id']), "text"),



		  GetSQLValueString(trim($_POST['ui_fname']), "text"),



		  GetSQLValueString(trim($_POST['ui_lname']), "text"),



		  GetSQLValueString(trim($_POST['ui_contact']), "text"),			  



		  GetSQLValueString(trim($_POST['ui_company']), "text"),



		  GetSQLValueString(trim($_POST['ui_address1']), "text"),



		  GetSQLValueString(trim($_POST['ui_address2']), "text"),



		  GetSQLValueString(trim($_POST['ui_city']), "text"),



		  GetSQLValueString(trim($_POST['ui_emirates']), "text"),			  

		  

		  GetSQLValueString(trim($_POST['order_notes']), "text"),

		  

		  GetSQLValueString($coupon_id, "text"));



		  



	$updateSQL1 = sprintf("UPDATE users SET ui_fname=%s, ui_lname=%s, ui_contact=%s, ui_company=%s, ui_address1=%s, ui_address2=%s, ui_city=%s, ui_emirates=%s,order_notes=%s WHERE id=".$row['id'],



		 



		  GetSQLValueString(trim($_POST['ui_fname']), "text"),



		  GetSQLValueString(trim($_POST['ui_lname']), "text"),



		  GetSQLValueString(trim($_POST['ui_contact']), "text"),			  



		  GetSQLValueString(trim($_POST['ui_company']), "text"),



		  GetSQLValueString(trim($_POST['ui_address1']), "text"),



		  GetSQLValueString(trim($_POST['ui_address2']), "text"),



		  GetSQLValueString(trim($_POST['ui_city']), "text"),



		  GetSQLValueString(trim($_POST['ui_emirates']), "text"),

		  

		  GetSQLValueString(trim($_POST['order_notes']), "text"));



		  $Result1 = mysql_query($updateSQL1) or die("(".mysql_errno().", ".mysql_error().")");



		  



		  



	}else{



	$coupon_id=$_SESSION['coupon_id'];	



	



	if($coupon_id !=''){

	$Query = "UPDATE coupon SET uses_total = uses_total - 1,uses_count = uses_count + 1 WHERE coupon_id =".$_SESSION['coupon_id'] ;		

	mysql_query($Query);

	}



	$updateSQL = sprintf("UPDATE basket SET userid=%s, ui_fname=%s, ui_lname=%s, ui_contact=%s, ui_company=%s, ui_address1=%s, ui_address2=%s, ui_city=%s, ui_emirates=%s,order_notes=%s,coupon_id=%s WHERE id=".GetSQLValueString(trim($_SESSION['bg_basket']),'int'),



		 



		  GetSQLValueString(trim($userid), "text"),



		  GetSQLValueString(trim($_POST['ui_fname']), "text"),



		  GetSQLValueString(trim($_POST['ui_lname']), "text"),



		  GetSQLValueString(trim($_POST['ui_contact']), "text"),			  



		  GetSQLValueString(trim($_POST['ui_company']), "text"),



		  GetSQLValueString(trim($_POST['ui_address1']), "text"),



		  GetSQLValueString(trim($_POST['ui_address2']), "text"),



		  GetSQLValueString(trim($_POST['ui_city']), "text"),



		  GetSQLValueString(trim($_POST['ui_emirates']), "text"),			  

		  

		  GetSQLValueString(trim($_POST['order_notes']), "text"),

		  

		  GetSQLValueString($coupon_id, "text"));



		  



		  $updateSQL1 = sprintf("UPDATE users SET ui_fname=%s, ui_lname=%s, ui_contact=%s, ui_company=%s, ui_address1=%s, ui_address2=%s, ui_city=%s, ui_emirates=%s, order_notes=%s WHERE id=".$userid,



		 



		  GetSQLValueString(trim($_POST['ui_fname']), "text"),



		  GetSQLValueString(trim($_POST['ui_lname']), "text"),



		  GetSQLValueString(trim($_POST['ui_contact']), "text"),			  



		  GetSQLValueString(trim($_POST['ui_company']), "text"),



		  GetSQLValueString(trim($_POST['ui_address1']), "text"),



		  GetSQLValueString(trim($_POST['ui_address2']), "text"),



		  GetSQLValueString(trim($_POST['ui_city']), "text"),



		  GetSQLValueString(trim($_POST['ui_emirates']), "text"),

		  

		  GetSQLValueString(trim($_POST['order_notes']), "text"));



		  $Result1 = mysql_query($updateSQL1) or die("(".mysql_errno().", ".mysql_error().")");



	}



	$Result1 = mysql_query($updateSQL) or die("(".mysql_errno().", ".mysql_error().")");



	//$_SESSION['c_email'] = $email;

	//$_SESSION['payment']='paypal';

 if($_POST['submit1'] == 'abcd'){
 $_SESSION['payment']='paypal';
 }else{
 $_SESSION['payment']='payFort';
 }

	if($_SESSION['payment'] == 'paypal')



	{
       // echo "test";die;


		redirect('tabbyinitiate.php'); 



	}
	
	if($_SESSION['payment'] == 'payFort')



	{



		redirect('payFort_checkout.php'); 



	}



	if($_SESSION['payment'] == 'cod')



	{



		redirect('cod.php'); 



	}



	if($_SESSION['payment'] == 'cac')



	{



		redirect('pick-from-store.php'); 



	}



	//echo $_SESSION['bg_basket'];


 echo "fsfsdf". $_POST['submit1'];




}



?>



<!DOCTYPE html>

<html lang="en">

<head>

<!-- Meta -->

<meta charset="utf-8">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<meta name="robots" content="all">

	<title>Brewing Gadget</title>	

        <!-- Brewing Gadget :: Favicon -->

        <link rel="apple-touch-icon" sizes="57x57" href="assets/images/BG-favicon/apple-icon-57x57.png">

        <link rel="apple-touch-icon" sizes="60x60" href="assets/images/BG-favicon/apple-icon-60x60.png">

        <link rel="apple-touch-icon" sizes="72x72" href="assets/images/BG-favicon/apple-icon-72x72.png">

        <link rel="apple-touch-icon" sizes="76x76" href="assets/images/BG-favicon/apple-icon-76x76.png">

        <link rel="apple-touch-icon" sizes="114x114" href="assets/images/BG-favicon/apple-icon-114x114.png">

        <link rel="apple-touch-icon" sizes="120x120" href="assets/images/BG-favicon/apple-icon-120x120.png">

        <link rel="apple-touch-icon" sizes="144x144" href="assets/images/BG-favicon/apple-icon-144x144.png">

        <link rel="apple-touch-icon" sizes="152x152" href="assets/images/BG-favicon/apple-icon-152x152.png">

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/BG-favicon/apple-icon-180x180.png">

        <link rel="icon" type="image/png" sizes="192x192"  href="assets/images/BG-favicon/android-icon-192x192.png">

        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/BG-favicon/favicon-32x32.png">

        <link rel="icon" type="image/png" sizes="96x96" href="assets/images/BG-favicon/favicon-96x96.png">

        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/BG-favicon/favicon-16x16.png">

        <link rel="manifest" href="assets/images/BG-favicon/manifest.json">

        <meta name="msapplication-TileColor" content="#ffffff">

        <meta name="msapplication-TileImage" content="assets/images/BG-favicon/ms-icon-144x144.png">

        <meta name="theme-color" content="#ffffff">

        <!-- Brewing Gadget :: FaviconEnd -->

<!-- Bootstrap Core CSS -->

<link rel="stylesheet" href="assets/css/bootstrap.min.css">

<!-- Customizable CSS -->

<link rel="stylesheet" href="assets/css/main.css">

<link rel="stylesheet" href="assets/css/blue.css">

<link rel="stylesheet" href="assets/css/owl.carousel.css">

<link rel="stylesheet" href="assets/css/owl.transitions.css">

<link rel="stylesheet" href="assets/css/animate.min.css">

<link rel="stylesheet" href="assets/css/rateit.css">

<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

<link href="assets/vendor/indexmobile/dash.css" rel="stylesheet">

<!-- Icons/Glyphs -->

<link rel="stylesheet" href="assets/css/font-awesome.css">

<!-- Fonts --> 

<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<script src="assets/js/jquery-1.11.1.min.js"></script>

<!--<script language="javascript" type="text/javascript" src="js/jquery.js"></script>

<script language="javascript" type="text/javascript" src="js/common.js"></script>-->



<script type="text/javascript">

	$(document).ready(function(){

	

	 $('#username').blur(function(){ // Keyup function for check the user action in input

		

	

	  var Username = $(this).val(); // Get the username textbox using $(this) or you can use directly $('#username')

	

	  var UsernameAvailResult = $('#username_avail_result'); // Get the ID of the result where we gonna display the results

	

	  if(Username.length > 2) { // check if greater than 2 (minimum 3)

	

		  UsernameAvailResult.html('Loading..'); // Preloader, use can use loading animation here

	

		  var UrlToPass = 'action=username_availability&username='+Username;

	

		  $.ajax({ // Send the username val to another checker.php using Ajax in POST menthod

	

		  type : 'POST',

	

		  data : UrlToPass,

	

		  url  : 'checker.php',

	

		  success: function(responseText){ // Get the result and asign to each cases

	

			  if(responseText == 0){

	

				  UsernameAvailResult.html('<span class="success">Email Address Available</span>');

	

			  }

	

			  else if(responseText > 0){

	

				  UsernameAvailResult.html('<span class="error">Email Address Already Register</span>');

	

			  }

	

			  else{

	

				  alert('Problem with sql query');

	

			  }

	

		  }

	

		  });

	

	  }else{

	

		  UsernameAvailResult.html('Enter atleast 3 characters');

	

	  }

	

	  if(Username.length == 0) {

	

		  UsernameAvailResult.html('');

	

	  }

	

	 }); 

	  

	

	 $('#password, #username').keydown(function(e) { // Dont allow users to enter spaces for their username and passwords

	

	  if (e.which == 32) {

	

		  return false;

	

	  }

	

	 }); 

	 

	

	});

	

</script>

<script type="text/javascript" language="javascript">

	function checkPasswordMatch() {

	

	 var password = $("#txtNewPassword").val();

	

	 var confirmPassword = $("#txtConfirmPassword").val();

	

	

	

	 if (password != confirmPassword)

	

	  $("#divCheckPasswordMatch").html('<span class="error">Passwords not match.</span>');

	

	 else

	

	  $("#divCheckPasswordMatch").html('<span class="success">Passwords match.</span>');

	

	}

	

	

	

	$(document).ready(function () {

	

	$("#txtConfirmPassword").keyup(checkPasswordMatch);

	

	});

	

</script>

<script type="text/javascript" language="javascript">

	$(document).ready(function(){

	 jQuery('form#directSubmitForm').submit(function(event) {

	 event.preventDefault();	 	

	 var self = this;

			var Username = $('#username').val(); // Get the username textbox using $(this) or you can use directly $('#username')

			

			var UsernameAvailResult = $('#username_avail_result'); // Get the ID of the result where we gonna display the results

		   

				UsernameAvailResult.html('Loading..'); // Preloader, use can use loading animation here

				var UrlToPass = 'action=username_availability&username='+Username;

				$.ajax({ // Send the username val to another checker.php using Ajax in POST menthod

				type : 'POST',

				data : UrlToPass,

				url  : 'checker.php',

				success: function(responseText){ // Get the result and asign to each cases

					if(responseText == 0){

					

						UsernameAvailResult.html('<span class="success">Email Address Available</span>');

						var password = $("#txtNewPassword").val();

						var confirmPassword = $("#txtConfirmPassword").val();				

						if (password != confirmPassword){

							$("#divCheckPasswordMatch").html('<span class="error">Passwords not match.</span>');

							event.preventDefault();						

							return  false;

						}

						else{

							$("#divCheckPasswordMatch").html('<span class="success">Passwords match.</span>');	

							

							{	

								var ui_contact = $('#ui_contact').val();

								

								$('[name=ui_contact]').val(ui_contact);							

								

								var result = ValidateCaptcha();

							  if( $("#UserCaptchaCode").val() == "" || $("#UserCaptchaCode").val() == null || $("#UserCaptchaCode").val() == "undefined") {

								$('#WrongCaptchaError').text('Please enter code given below in a picture.').show();

								$('#UserCaptchaCode').focus();

							  } else {

								if(result == false) { 

								  $('#WrongCaptchaError').text('Invalid Captcha! Please try again.').show();

								  CreateCaptcha();

								  $('#UserCaptchaCode').focus().select();

								}

								else { 

										$('#WrongCaptchaError').hide();

										var qaws= document.activeElement.getAttribute('name');
										$('#submit1').val(qaws);
										
										self.submit();

								

									 }

							  }  

								

								

							}																				    						

						}					

						

					}

					else if(responseText > 0){

						UsernameAvailResult.html('<span class="error">Email Address Already Register</span>');

						event.preventDefault();						

						return  false;					

					}

					else{

						alert('Problem with sql query');

					}

				}

				});

			});	

	});

</script> 

<script>

$(function(){

  CreateCaptcha();

});



// Create Captcha

function CreateCaptcha() {

  //$('#InvalidCapthcaError').hide();

  var alpha = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

                    

  var i;

  for (i = 0; i < 6; i++) {

    var a = alpha[Math.floor(Math.random() * alpha.length)];

    var b = alpha[Math.floor(Math.random() * alpha.length)];

    var c = alpha[Math.floor(Math.random() * alpha.length)];

    var d = alpha[Math.floor(Math.random() * alpha.length)];

    var e = alpha[Math.floor(Math.random() * alpha.length)];

    /*var f = alpha[Math.floor(Math.random() * alpha.length)];

    var g = alpha[Math.floor(Math.random() * alpha.length)];

    var h = alpha[Math.floor(Math.random() * alpha.length)];*/

  }

  //var code = a + ' ' + b + ' ' + ' ' + c + ' ' + d + ' ' + e + ' ' + f + ' ' + g;

  var code = a + b + c + d + e;



  $("#CaptchaImageCode").html("<span class='capcode'>" + code + "</span>"); 

}



// Validate Captcha

function ValidateCaptcha() {

  var string1 = removeSpaces($('#CaptchaImageCode .capcode').text());

  var string2 = removeSpaces($('#UserCaptchaCode').val());



  if (string1 == string2) {

    return true;

  }

  else {

    return false;

  }

}



// Remove Spaces

function removeSpaces(string) {

  return string.split(' ').join('');

}



// Check Captcha

function CheckCaptcha() {

  

}

</script>

</head>

<body class="cnt-home">

<!-- ============================================== HEADER ============================================== -->

<?php include('header.php'); ?>

<!-- ============================================== HEADER : END ============================================== -->

<!-- /.breadcrumb -->

<div class="body-content outer-top-xs">

    <div class="container">

        <div class="sign-in-page">

            <div class="row">

                <!-- Sign-in -->	

                <div class="col-md-12 col-sm-12 sign-in">

                    <h4 class="">User Information</h4>

                </div>

                

                <?php

	if($userid !=""){

	

	$sql = "SELECT * FROM users where id=$userid";

	

	$results = mysql_query($sql);

	

	$row = mysql_fetch_assoc($results);

	

	

	

	$ui_fname = $row['ui_fname'];

	

	$ui_lname = $row['ui_lname'];

	

	$ui_contact = $row['ui_contact'];

	

	$ui_uname = $row['uname'];

	

	

	

	$ui_company = $row['ui_company'];

	

	$ui_address1 = $row['ui_address1'];

	

	$ui_city = $row['ui_city'];

	

	$ui_emirates = $row['ui_emirates'];

	

	$ui_address2 = $row['ui_address2'];

	

	$order_notes = $row['order_notes'];

	

	}else{

	

	$ui_fname = '';

	

	$ui_lname = '';

	

	$ui_contact = '';

	

	

	

	$ui_company = '';

	

	$ui_address1 = '';

	

	$ui_city = '';

	

	$ui_emirates = '';

	

	$ui_address2 = '';

	

	$order_notes = '';

	

	}

	

	 ?>

     

     

     

     <? if($userid ==""){?>

				<div class="userpagelogin">

					<div class="col-xs-12 col-sm-12 col-md-12 already">

						<div class="">

							<h5>Already a Member? Sign In:</h5>

						</div>

						<form name="form1" method="post" action="checklogin.php" class="login-form dis_none ws-validate">

                        <div class="row">

							<div class="col-md-5 form-group formpart">

								<label class="info-title" for="input-email">E-Mail<span>*</span></label>

								<input type="text" name="txtlogin" id="txtlogin" value="" placeholder="E-Mail Address" class="form-control unicase-form-control text-input" required>

								<div class="username_avail_result" id="username_avail_result1"></div>

							</div>

							<div class="col-md-5 ">

								<div class="form-group">

									<label class="info-title" for="input-password">Password<span>*</span></label>

									<input type="password" name="txtpwd" id="log-password2" value="" placeholder="Password" class="form-control unicase-form-control text-input topfgtmargin" required>

								</div>

							</div>

                            <input type="hidden" name="reg_page" value="0">

							<div class="col-md-2">

                            <div class="login-div-btn">

								<input type="submit" value="Sign In" id="login_submit" name="submit" data-loading-text="Loading..." class="btn btn-primary">

                                </div>

							</div>

                            </div>

                            <div class="row"><div class="forgetpass col-md-12">

									<a href="forget_pass.php"><u>Forgot Password?</u></a>

								</div></div>

						</form>

					</div>

				</div>

                <?php } ?>

     

                

                <div class="clearfix"></div>

                <form name="directSubmitForm" action="user_info.php" method="post" id="directSubmitForm" class="registr-form dis_none ws-validate" >

			<div class="userpagesignup">

				<div id="content" class="col-xs-12 col-sm-12 col-md-12 usersignuppart1">

					<? if($userid ==""){?>

                    <h4 class="signup-user standardh4">Don't have a Login? Sign up now:</h4>

                    <?php }else{ ?>

                    

                    <?php } ?>

				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 usersignupborder usersignupmob">

					<h5> Your Profile & Contact Details </h5>					

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd ">

								<label class="control-label" >First Name<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd form-group ">            

								<input type="text" class="form-control unicase-form-control text-input" id="co-first-name" name="ui_fname" value="<?=$ui_fname?>" placeholder="First name" required>

							</div>

						</div>

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Last Name<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd form-group">

								<input type="text" class="form-control unicase-form-control text-input" id="co-last-name" name="ui_lname" value="<?=$ui_lname?>" placeholder="Last name" required>

							</div>

						</div>

                        

                        <div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd form-group">

								<label class="control-label">Mobile<span class="hotimp">*</span>:</label>

							</div>

                           <div class="col-xs-12 col-sm-12 col-md-8 pd  form-group">

								<input type="number" class="form-control unicase-form-control text-input" id="ui_contact" name="ui_contact" value="<?=$ui_contact?>" required >

							</div>                            

						</div>

						 <? if($userid ==""){?>

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">E-Mail<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd  form-group">

								<input type="email" class="form-control unicase-form-control text-input" id="username" name="uname" value=""  placeholder="E-mail Address" required>

								<div class="username_avail_result" id="username_avail_result"></div>

							</div>

						</div>

                       						

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Password<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd  form-group">

								<input type="password" class="form-control unicase-form-control text-input" id="txtNewPassword" name="pass" value="" placeholder="Set Your Password" required>

							</div>

						</div>

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Repeat Password<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd  form-group">

								<input type="password" class="form-control unicase-form-control text-input" id="txtConfirmPassword" name="cpass" value="" placeholder="Confirm Password" onChange="checkPasswordMatch();" required>

                      			<div class="registrationFormAlert" id="divCheckPasswordMatch"></div>

							</div>

						</div>

						<?php } ?>           				

					

				</div>

				<div class="col-xs-12 col-sm-12 col-md-6">

					

					

                    

                    

                 <div id="cod">

					<h5>Your Delivery Details  </h5>					

						

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Address<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd">

                            	<textarea class="form-control unicase-form-control text-input" name="ui_address1" id="ui_address1" rows="3" cols="5"  style="height:auto;" placeholder="Address" required><?=$ui_address1?></textarea>

							</div>

						</div>

						<!--<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Address 2:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd">

								<input id="ui_address2" class="form-control unicase-form-control text-input" type="text" placeholder="Apartment " value="<?=$ui_address2?>" name="ui_address2" >

							</div>

						</div>-->

                        <input id="ui_address2" type="hidden" value=" " name="ui_address2" >

						<div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">City<span class="hotimp">*</span>:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd">

								<!--<input type="text" class="form-control unicase-form-control text-input" id="ui_city" name="ui_city" value="<?=$ui_city?>" placeholder="Town/ city" required>-->
								
								<select id="ui_city" name="ui_city" class="form-control" required>
		
                            		<option value="Abu Dhabi">Abu Dhabi</option>			
                            		<option value="Dubai">Dubai</option>		
                            		<option value="Sharjah">Sharjah</option>		
                            		<option value="Ajman">Ajman</option>
                            		<option value="Ras al Khaimah">Ras al Khaimah</option>
                            		<option value="Umm al-Quwain">Umm al-Quwain</option>
                            		<option value="Fujairah">Fujairah</option>
                            		<option value="Al Ain">Al Ain</option>
                            		<option value="Kalba">Kalba</option>
                            		
                            		</select>

							</div>

						</div>	

                        <div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd">

								<label class="control-label">Note:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd">

								<textarea class="form-control unicase-form-control text-input" name="order_notes" id="order-notes" rows="5" cols="5"  style="height:auto;" placeholder="Please let us know when you would like to collect the goods, preferred day of the week and time. Any specific date?" ><?=$order_notes?></textarea>

							</div>

						</div>

                        

				</div>

                <div class="userinforegister">

							<div class="col-xs-12 col-sm-12 col-md-4 pd captchadiv">

								<label class="control-label">Enter Captcha*:</label>

							</div>

							<div class="col-xs-12 col-sm-12 col-md-8 pd ">

								<input type="text" id="UserCaptchaCode" class="CaptchaTxtField form-control unicase-form-control text-input" placeholder='Enter Captcha - Case Sensitive'>

                                

                      			<div class='CaptchaWrap'>

                                  <div id="CaptchaImageCode" class="CaptchaTxtField"></div>

                                  <input type="button" class="ReloadBtn" onclick='CreateCaptcha();'>

                                </div>

                                 <p id="WrongCaptchaError" class="error"></p>

							</div>

                           

						</div>

                	

			</div>

            

           <!--<div class="pull-right btnusercheck showafter660" style="padding-bottom:15px; ">

           		

                <?php if(isset($_SESSION['bg_basket'])){ ?>                	

    	          <input type="hidden" name="submit1" value="0">

				  <input type="submit" value="<?= $userid == '' ? 'Sign Up & Checkout' : 'Checkout' ?>" name="formSubmit" id="formSubmit"  class="btn btn-primary">

                  <?php }else{ ?>

                  <a href="index.php" class="btn btn-default">Continue Shopping</a>

                  <?php } ?>

           

			</div>-->

            <div class="col-xs-12 col-sm-12 col-md-12 showbfr660">

            <div class="pull-right btnusercheck" style="padding-bottom:15px;">

           		<?php $amt_p = $_SESSION['total_amt_for_checkout'] / 3.80; ?>
                <?php $amt_p1 = $_SESSION['total_amt_for_checkout']; ?>

                <?php if(isset($_SESSION['bg_basket'])){ ?>                	

    	          <input type="hidden" id="submit1" name="submit1" value="0">

                  <input type="submit" value="<?= $userid == '' ? 'Pay with Tabby - AED '.round($amt_p1) : 'Pay with Tabby - AED '.round($amt_p1)  ?>" name="abcd" id="abcd"  class="btn btn-primary userinfobtn" style="margin-bottom:3%;">
                    
                  <input type="submit" value="<?= $userid == '' ? 'Pay with PayFort - AED '.round($amt_p1) : 'Pay with PayFort - AED '.round($amt_p1)  ?>" name="qwert" id="qwert"  class="btn btn-primary userinfobtn" style="margin-bottom:3%;">

                  <?php }else{ ?>

                  <a href="index.php" class="btn btn-default">Continue Shopping</a>

                  <?php } ?>

           </div>

			</div>

            

			<!-- /.row -->

			<!-- ============================================== BRANDS CAROUSEL ============================================== -->

			<!-- /.logo-slider -->

			<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	

		</div>

        </form>

                

                

                

                

                 <div class="clearfix"></div>

                

                <!-- Sign-in -->

                <!-- create a new account -->

                <!-- create a new account -->			

            </div>

            <!-- /.row -->

        </div>

        <!-- /.sigin-in-->

        <!-- ============================================== BRANDS CAROUSEL ============================================== -->

        <!-- /.logo-slider -->

        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	

    </div>

    <!-- /.container -->

</div>

<!-- /.body-content -->

<!-- ============================================================= FOOTER ============================================================= -->

<?php include('footer.php'); ?>

<!-- ============================================================= FOOTER : END============================================================= -->

<!-- For demo purposes – can be removed on production -->

<!-- For demo purposes – can be removed on production : End -->

<!-- JavaScripts placed at the end of the document so the pages load faster -->

<script src="assets/js/jquery-1.11.1.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>

<script src="assets/js/owl.carousel.min.js"></script>

<script src="assets/js/echo.min.js"></script>

<script src="assets/js/jquery.easing-1.3.min.js"></script>

<script src="assets/js/bootstrap-slider.min.js"></script>

<script src="assets/js/jquery.rateit.min.js"></script>

<script type="text/javascript" src="assets/js/lightbox.min.js"></script>

<script src="assets/js/bootstrap-select.min.js"></script>

<script src="assets/js/wow.min.js"></script>

<script src="assets/js/scripts.js"></script>

<script type="text/javascript" src="assets/vendor/index_file/js/custom.js"></script>

<script src="assets/vendor/indexmobile/jquery.touchSwipe.min.js"></script>

<script src="assets/vendor/indexmobile/dash.js"></script>

<script src="assets/vendor/indexmobile/demo.js"></script>

<!-- For demo purposes – can be removed on production -->

<script src="switchstylesheet/switchstylesheet.html"></script>

<script>

    $(document).ready(function(){ 

        $(".changecolor").switchstylesheet( { seperator:"color"} );

        $('.show-theme-options').click(function(){

            $(this).parent().toggleClass('open');

            return false;

        });

    });

    

    $(window).bind("load", function() {

       $('.show-theme-options').delay(2000).trigger('click');

    });

</script>

<!-- For demo purposes – can be removed on production : End -->

</body>

</html>