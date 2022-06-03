<?php

include_once('includes/global.php'); 

	

	//cart and user data 

	

	$sql = "SELECT * FROM basket where id=".$_SESSION['bg_basket'];

	$results = mysql_query($sql);

	$row_pf = mysql_fetch_assoc($results);

	

    	//echo "<pre>";print_r($row_pf);die;

	

	$_SESSION['tra_id'] = $row_pf['id'];

	

	$sql_email = "SELECT * FROM users WHERE id=".$row_pf['userid'];

	$result_email = mysql_query($sql_email);					

	$row_email = mysql_fetch_assoc($result_email);

    

    

    

    //echo "<pre>";print_r($row_email);die;

	$_SESSION['c_email'] = $row_email['uname'];

	

	$useremail=$row_email['uname'];

	$userphone=$row_email['ui_contact'];

	$username=$row_email['ui_fname'];

	$date=date("Y-m-d\TH:i:sP");

	$customerid=$row_email['id'];

    //cart and user data tra_id

	

//echo "test";die;

 $amt_p = $_SESSION['total_amt_for_checkout'] / 3.80; ?>

                <?php $amt_p1 = $_SESSION['total_amt_for_checkout']; ?>

                <?php $shipping_rate=$_SESSION['shipping_rate']; ?>

                <?php $basket_id=$_SESSION['bg_basket'];?>

                <?php 

                $sql = "SELECT id,basket_id,product_id,quantity,amount,weight FROM basket_details where basket_id=".$_SESSION['bg_basket'];

            		$results = mysql_query($sql);







                while($row = mysql_fetch_assoc($results)){

                //$json[] = $row;



                	$product_sql = "SELECT * FROM products where id=".$row['product_id'];;

            			$product_results = mysql_query($product_sql);



            			//print_r(mysql_fetch_assoc($product_results));die;

            			$productname=mysql_fetch_assoc($product_results);



            			//echo $productname['prodname'];



                	$json[]=array( "reference_id" => (string)$productname['sku_num'],

                	"quantity" => (int)$row['quantity'],

                  "unit_price" => (string)$row['amount'],

               		"title" => (string)$productname['prodname'],);







                }



                //die;

                //echo $amt_p1;

               	$array=json_encode($json);

               	$array = trim($array, '[]');

               // echo "<pre>";print_r($array);die;

                

                





?>





<?php



$url = "https://api.tabby.ai/api/v2/checkout";



$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_POST, true);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);



$headers = array(

   "Content-Type: application/json",

   "Authorization: Bearer pk_ff6e5a66-436c-4b6d-8f30-8af9c92db245",

);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);



$data = <<<DATA

{

"payment": {

"amount": $amt_p1,

"currency": "AED",

"description": "my product",

"buyer": {

    "phone": "+$userphone",

    "email": "$useremail",

    "name": "$username",

    "dob": "2006-12-06"

},

"order": {

"tax_amount": "0.00",

"shipping_amount": "$shipping_rate",

"discount_amount": "0.00",

"updated_at": "$date",

"reference_id": "$basket_id",

"items": [

   $array

]

},

"meta": {

    "order_id": "$basket_id;",

    "customer": "$customerid"

}

},

"lang": "en",

"merchant_code": "UAE",

"merchant_urls": {

"success": "https://brewinggadgets.com/tabbyverifypayment.php",

"cancel": "https://brewinggadgets.com/tabby_cancel.php",

"failure": "https://brewinggadgets.com/tabby_failure.php"

}

}

DATA;



curl_setopt($curl, CURLOPT_POSTFIELDS, $data);



//for debug only!

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);



$resp = curl_exec($curl);

curl_close($curl);

//return $resp;



$data=json_decode($resp, true);



//echo"<pre>";print_r($data);die;





$powerdata=$data['configuration']['available_products']['installments'];//die;

$url=$powerdata['0']['web_url'];

header("Location:".$url); 



?>                

           



