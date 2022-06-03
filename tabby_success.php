<?php require("includes/global.php");  ?>
<?php

if(isset($_SESSION['bg_basket']) && is_numeric($_SESSION['bg_basket'])) { 

   $sql = "SELECT * FROM basket where id=".$_SESSION['bg_basket'];
	$results = mysql_query($sql);
	$row_pf = mysql_fetch_assoc($results);
	
// 	echo "<pre>";
// 	print_r($row_pf);
// 	die;
	$_SESSION['tra_id'] = $row_pf['id'];
	
	$sql_email = "SELECT * FROM users WHERE id=".$_SESSION['userid'];
	$result_email = mysql_query($sql_email);					
	$row_email = mysql_fetch_assoc($result_email);
	$_SESSION['c_email'] = $row_email['uname'];

	$amt = $_SESSION['total_amt_for_checkout']*100;
	$today = date("d/m/Y");
	
	$success_message = "
		<p>Dear ".ucwords($row_pf['ui_fname']).",</p>
		<p>
			Thank you for the payment on your account with Brewing Gadgets. <br/>
			This is to acknowledge that we have received payment of AED ".number_format(round($_SESSION['total_amt_for_checkout']),2)." 
			which has been processed.
		</p>
		<p>If you would prefer not to receive notification of payments please let us know.</p>
		<p>If you have any questions regarding your account please send 
		your questions to our email info@brewinggadgets.com.</p>
		<p>
		Best Regards, <br />
		Brewing Gadgets General Trading LLC
		</p>
	";
	
	
	$client_message = "<table cellpadding='0' cellspacing='0' border='0' width='800' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px'>
		<tr><td colspan='2'><p>Dear ".ucwords($row_pf['ui_fname']).",</p>
		
		Thanks for paying through Tabby. Your invoice details are as follows:<br><br>
		</td></tr>
		
	";
	
	
	$invoice_msg="";
	

  	$admin_message = "<table cellpadding='0' cellspacing='0' border='0' width='800' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px'>
		<tr><td colspan='2'>
		<p>Dear Admin,</p>
		
		".ucwords($row_pf['ui_fname'])." has bought products and successfully paid via PayFort. Invoice details are as follows:<br><br>
		<a href='https://www.brewinggadgets.com/invoice_print.php?bg_basket=".$row_pf['basket_number']."'>Print Invoice</a><br><br>
		</td></tr>";
		$invoice_msg =$invoice_msg . "
		

			<tr>

      <td width='320' align='left' ><img src='http://brewinggadgets.com/images/brewing-logo.png' border='0' /></td>

      <td width='480' align='right' ><span style='font-size:40px; color:#b2b2b2'>TAX INVOICE</span></td>

	  </tr>

	  <tr><td height='30' colspan='2' style='color:#b2b2b2' ><hr ></td></tr>

	  

	  <tr>

      <td  align='left' valign='top' width='320' >

		Brewing Gadgets General Trading LLC<br>
		  
Shop No.1 Building EMR 25<br>  

Emarati Cluster, International City<br>  

Dubai. UAE<br />
TRN : 100203540800003
		

      </td>

       <td  align='right' valign='top' width='480' >

	   	<table>

			<tr>

				<td><strong>Date Added:</strong></td>

				<td>".$today."</td>

			</tr>			

			<tr>

				<td><strong>Order No.:</strong></td>

				<td>".$row_pf['order_reference']."</td>

			</tr>
<tr>

				<td><strong>Invoice No.:</strong></td>

				<td>".$row_pf['inv_number']."</td>

			</tr>
			<tr>

				<td><strong>Transaction ID:</strong></td>

				<td>".$row_pf['tabby_transaction_id']."</td>

			</tr>
			
				<tr>

				<td><strong>Payment ID:</strong></td>

				<td>".$row_pf['tabby_payment_id']."</td>

			</tr>

			<tr>

				<td><strong>Payment Method:</strong></td>

				<td>Tabby</td>

			</tr>

			

		</table>

	    

     </td>

     

  	</tr>
	  
	  
	 <tr><td height='30'></td></tr>

	<tr>

		<td colspan='2'>

			<table width='100%'  cellpadding='5' cellspacing='0' bgcolor='#FFFFFF' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#000000;border:1px #cccccc solid;'>

				<tr bgcolor='#CCCCCC'>

					<td>To</td>

				</tr>

				<tr>

		<td >

			<strong>Name: &nbsp;&nbsp;&nbsp;".$row_pf['ui_fname']." </strong><br>
		

        Contact Number: &nbsp;&nbsp; ".$row_pf['ui_contact']."<br>

   		

    

       Email:&nbsp;&nbsp;&nbsp;&nbsp; ".$row_email['uname']."<br> 

       Shipping Address: ".$row_pf['ui_address1']." ".$row_pf['ui_city']."  <br> 
       Order Notes: ".$row_pf['order_notes']."

		</td>

	</tr>

			</table>

		</td>

		
	 
	 
    <tr><td height='30'></td></tr><tr><td colspan='2'>
        	<div style='border:1px #000000 solid;'> <table border='0'  cellpadding='5' cellspacing='0' bordercolor='#000000' bgcolor='#FFFFFF' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#000000;border:0px #000000 solid;'>
	<tr bgcolor='#CCCCCC'>
               	  <th width='420' align='left' height='30' valign='middle' style='border-right:1px #000000 solid;border-bottom:1px #000000 solid;'>&nbsp;PRODUCT</th>
                  <th width='120' align='center' height='30' valign='middle' style='border-right:1px #000000 solid;border-bottom:1px #000000 solid;' >AMOUNT(AED)</th>
				  <th width='100' align='center' height='30' valign='middle' style='border-right:1px #000000 solid;border-bottom:1px #000000 solid;' >QUANTITY</th>
				  <th width='160' align='center' height='30' valign='middle' style='border-bottom:1px #000000 solid;border-right:1px #000000 solid;' >TOTAL AMOUNT(AED)</th>
              </tr>";
          $shipment_amount=$row_pf['shipment_amount'];
                    	$sql = "SELECT basket_details.* FROM basket, basket_details where basket.id=basket_details.basket_id  and basket.id=".$_SESSION['bg_basket'];
						$results = mysql_query($sql);
						$tot = 0;
						$cnt = 1;  $htot=300-(mysql_num_rows($results)*25);
						while($row = mysql_fetch_assoc($results)) { 
                     	$invoice_msg =$invoice_msg . "   <tr>
                          <td style='border-right:1px #000000 solid;'>";
                          	 if($row['product_id'] != 0) {
						  		
                                	$id=$row['product_id'];
									$sql1 = "SELECT * FROM products where id=$id";
									$results1 = mysql_query($sql1);
									$row_pname = mysql_fetch_assoc($results1);
								
                                	//$invoice_msg =$invoice_msg . " 	<strong>".$row_pname['prodname']."</strong>";
									
									$invoice_msg =$invoice_msg . " 	<strong>".$row_pname['prodname']."</strong>"."<br>";
									$invoice_msg =$invoice_msg . " 	<p>"."SKU Number : ".$row_pname['sku_num']."</p>";
                                     
                                    
                            } 
                          	$invoice_msg =$invoice_msg . "<div id='info'>";
                                 if($row['product_id'] != 0) { 
                                   
                                 	//$invoice_msg =$invoice_msg ."   Category: ".$row['category']."<br />";
                                   
                                 }
                           	$invoice_msg =$invoice_msg . " </div>
                          </td>
                          <td align='right' style='border-right:1px #000000 solid;'>".number_format($row['amount'],2)."</td>
                          <td align='center' style='border-right:1px #000000 solid;'>".$row['quantity']."
                          </td>
                          <td align='right' style='border-right:1px #000000 solid;'>";
                          	
                            	$p_tot = $row['amount'] * $row['quantity'];
								$invoice_msg =$invoice_msg .  number_format($p_tot,2);
								$tot = $tot + $p_tot;
						
                         $invoice_msg =$invoice_msg ." </td>
                        </tr>";
                     }  
					// $amt = $tot / 3.50;
					 if($htot==0){
					$htot=100;}	
                    $invoice_msg =$invoice_msg ."<tr><td style='border-right:1px #000000 solid;'>Shipping Amount</td>
					<td style='border-right:1px #000000 solid;'>&nbsp;</td><td style='border-right:1px #000000 solid;'>&nbsp;</td>
					<td style='border-right:1px #000000 solid;' align='right'>". $shipment_amount ."</td>
					</tr> 
                    
                  
                  <tr><td width='416' style='border-right:1px #000000 solid;' height='".$htot."'>&nbsp;</td><td width='119' style='border-right:1px #000000 solid;'>&nbsp;</td><td width='100' style='border-right:1px #000000 solid;'>&nbsp;</td><td>&nbsp;</td></tr> 
               
               <tr>
               	  <th align='left' height='30' colspan='3' style='border-right:1px #000000 solid;border-top:1px #000000 solid;border-bottom:1px #000000 solid;'>&nbsp;TOTAL</th>
                    <td align='right' height='30' style='border-top:1px #000000 solid;border-bottom:1px #000000 solid;border-right:1px #000000 solid;'>AED ".number_format($_SESSION['total_amt_for_checkout'],2)."</td>
              </tr>
			 
                <tr>
               	  <td  colspan='4' align='left' height='30' colspan='2' style='border-right:1px #000000 solid;'><strong>&nbsp;In Words :</strong>  ".convert_number(round($_SESSION['total_amt_for_checkout']))." Dirhams Only</td>
                   
              </tr>
            </table></div><br><br>
    	</td>
    </tr>
     

	";
// 	echo $client_message ;
// 	echo $invoice_msg;
	
	$_SESSION['client_message'] = $client_message. $invoice_msg . "<tr><td height='30' colspan='4'><p>Thanks again for choosing Brewing Gadgets Company!</p>Regards, <br /> Brewing Gadgets Administrator</td></tr></table>";
	$_SESSION['admin_message'] = $admin_message . $invoice_msg . "<tr><td height='30'>Regards, <br /> Brewing Gadgets</td></tr></table>";
	//echo  $_SESSION['admin_message'];	echo  $_SESSION['client_message'];exit;
	$_SESSION['success_message'] = $success_message;

    #client message

	$to = $_SESSION['c_email'];

	$subject = "Brewing Gadgets Invoice# ".$inv_number;

	$message = str_replace('@TokenNumber@', $_POST['fort_id'], $_SESSION['client_message']);

	$message = str_replace('@OrderNumber@', $orderRef, $message);
	
	$message = str_replace('@InvoiceNumber@', $inv_number, $message);

	$headers = "MIME-Version: 1.0" . "\n";

	$headers .= "Content-type:text/html;charset=utf-8" . "\n";

	$headers .= 'From: noreply@brewinggadgets.com';

	mail($to,$subject,$message,$headers);

	

	#admin message

// 	$to = "info@brewinggadgets.com,accounts@brewinggadgets.com,ajay@brewinggadgets.com,franklin@brewinggadgets.com,sales@brewinggadgets.com,digital@brewinggadgets.com,sonu@brewinggadgets.com,store@brewinggadgets.com";

	

// 	$subject = "Brewing Gadgets Invoice# ".$inv_number;

// 	$message = str_replace('@TokenNumber@', $_POST['fort_id'], $_SESSION['admin_message']);

// 	$message = str_replace('@OrderNumber@', $orderRef, $message);
	
// 	$message = str_replace('@InvoiceNumber@', $inv_number, $message);

// 	$headers = "MIME-Version: 1.0" . "\n";

// 	$headers .= "Content-type:text/html;charset=utf-8" . "\n";

// 	$headers .= 'From:'.$_SESSION['c_email']."\n";

// 	$headers .= 'Cc:murtaza.sanwala@yahoo.com';

// 	mail($to,$subject,$message,$headers);

}
?>
<!DOCTYPE html>

<html lang="en">

<head>

		<!-- Meta -->

		<meta charset="utf-8">

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

		<meta name="description" content="">

		<meta name="author" content="">

	    <meta name="keywords" content="MediaCenter, Template, eCommerce">

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

		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>

        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

	</head>

    <body class="cnt-home">

		<!-- ============================================== HEADER ============================================== -->

<?php include('header.php'); ?>



<!-- ============================================== HEADER : END ============================================== -->

<!-- /.breadcrumb -->



<div class="body-content outer-top-xs  outer-bottom-xs">

	<div class="container">

		<div class="terms-conditions-page">

			<div class="row">

				<div class="col-md-12 terms-conditions">

	<h2 class="heading-title">Successfully Checked-Out</h2>

    <p><?=$_SESSION['success_message']?></p>
   
	<div>

<?php



	unset($_SESSION['client_message']);



	unset($_SESSION['admin_message']);



	unset($_SESSION['c_email']);



	unset($_SESSION['tra_id']);



	unset($_SESSION['tot_sess']);



	unset($_SESSION['bg_basket']);



	unset($_SESSION['bg_basket_hash']);

	

	unset($_SESSION['coupon_discount']);

	

	unset($_SESSION['coupon_id']);

	

	unset($_SESSION['shipping_rate']);

	unset($_SESSION['p_tot1']);

	unset($_SESSION['total_amt_for_checkout']);

	

		?>

</div>



</div>



	</div><!-- /.row -->

		</div><!-- /.sigin-in-->

		<!-- ============================================== BRANDS CAROUSEL ============================================== -->

<!-- /.logo-slider -->

<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	</div><!-- /.container -->

</div><!-- /.body-content -->

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