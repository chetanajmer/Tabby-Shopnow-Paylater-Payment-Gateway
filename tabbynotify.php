<?php



include_once('includes/global.php'); 


$json = file_get_contents("php://input");

$data=json_decode($json, true);




$paymentid=$data['id'];
$paymentstatus=$data['status'];
$basketid=$data['order']['reference_id'];
$amt=$data['amount'];
$transactionid=$data['order']['reference_id'];



if($paymentstatus=="authorized")
{
    
    

    //geting basket details
    $sql = "SELECT * FROM basket where id=".$basketid;
    $results = mysql_query($sql);
    $row_pf = mysql_fetch_assoc($results);
    $_SESSION['tra_id'] = $row_pf['id'];


    //geting user details
    $sql_email = "SELECT * FROM users WHERE id=".$row_pf['userid'];
    $result_email = mysql_query($sql_email);                    
    $row_email = mysql_fetch_assoc($result_email);

    $_SESSION['c_email'] = $row_email['uname'];
    $today = date("d/m/Y");





    //inserting order details


    $orderRef = orderNum(str_pad($_SESSION['tra_id'],4,"0",STR_PAD_LEFT), rand(100,1000000));
    $result3 = mysql_query("SELECT * FROM basket where inv_number<>'' ORDER BY  id DESC ");
    $row_count1 = mysql_fetch_assoc($result3);                      
    $prod_num2  = $row_count1['inv_number'];
    preg_match('/\d+/', $prod_num2, $numMatch); 
    $number2 = $numMatch[0];    
    $i2=$number2+1;                     
    $inv_number= "INV".$i2;
    $ui_fname=$row_email['ui_fname'];
    $ui_lname=$row_email['ui_lname'];
    $ui_contact=$row_email['ui_contact'];
    $email=$row_email['uname'];
    $ui_address1=$row_email['ui_address1'];
    $ui_city=$row_email['ui_city'];
    $order_notes=$row_email['order_notes'];
    $transaction_id=$transactionid;
    $payment_id=$paymentid;

    $query = "UPDATE basket SET ui_fname='$ui_fname',ui_lname='$ui_lname',ui_contact='$ui_contact',ui_address1='$ui_address1',order_notes='$order_notes', userid='$row_pf[userid]' ,ui_city='$ui_city',paypal_Transaction_id = '$payment_id',tabby_transaction_id = '$payment_id', tabby_payment_id='$payment_id',order_reference='$orderRef',inv_number='$inv_number',order_completed=1, status='New Order', payment_method='Tabby' WHERE id =" .$basketid ;       

    $result=mysql_query($query);



            $url = "https://api.tabby.ai/api/v1/payments/".$paymentid."/captures";


            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_URL, $url);

            curl_setopt($curl, CURLOPT_POST, true);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);



            $headers = array(

               "Content-Type: application/json",

               "Authorization: Bearer sk_89b740f5-2c03-4dee-8bb7-592b603724fa",

               

            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

          
            $postdata = '

            {

            "amount": '.$amt.',
             
            "tax_amount": "0.00",

            "shipping_amount": "30.00",

            "discount_amount": "0.00",

            "created_at": "'.$today.'",

            "items": [

            ]

            }

            ';
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);



            $resp = curl_exec($curl);

            curl_close($curl);

            //var_dump($resp);

        $query = "INSERT INTO webhooks (data,transactionid) VALUES ('".$paymentstatus."','".$paymentid."')";

        $result=mysql_query($query);
   
}
