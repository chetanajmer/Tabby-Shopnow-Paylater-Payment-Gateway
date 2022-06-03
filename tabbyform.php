<?php require("includes/global.php") ?>

<?php 
    
    $orderRef = orderNum(str_pad($_SESSION['tra_id'],4,"0",STR_PAD_LEFT), rand(100,1000000));
    $result3 = mysql_query("SELECT * FROM basket where inv_number<>'' ORDER BY  id DESC ");

	$row_count1 = mysql_fetch_assoc($result3);						

	$prod_num2  = $row_count1['inv_number'];

	preg_match('/\d+/', $prod_num2, $numMatch);	

	$number2 = $numMatch[0];	

	$i2=$number2+1;						

	$inv_number= "INV".$i2;
	
	
	$ui_fname=$_GET['firstname'];
	$ui_lname=$_GET['lastname'];
	$ui_contact=$_GET['contact'];
	$email=$_GET['email'];
	$ui_address1=$_GET['address'];
	$ui_city=$_GET['city'];
	$order_notes=$_GET['order_note'];
    $transaction_id=$_GET['transaction_id'];
    $payment_id=$_GET['payment_id'];
    $password=$_GET['confirm_pass'];
    
    $result=mysql_query("select * from user where uname='$email'");
    $row_count = $result->num_rows;
    if($row_count==1)
    {
        // $_SESSION['email']=$result[uname];
    }
    else
    {
      $qry="insert into users(uname,password,created_on,active,ui_fname,ui_lname,ui_contact,ui_address1,ui_city)values('$email','$password',now(),'y','$ui_fname','$ui_lname','$ui_contact','$ui_address1','$ui_city')";
      mysql_query($qry)	or die("Err #:".mysql_errno().' Error:'.mysql_error());
      
      $lastid=mysql_insert_id();
      $_SESSION['userid']= $lastid;
    //   die;
    }
    

	
    $query = "UPDATE basket SET ui_fname='$ui_fname',ui_lname='$ui_lname',ui_contact='$ui_contact',ui_address1='$ui_address1',order_notes='$order_note', userid='$_SESSION[userid]' ,ui_city='$ui_city',tabby_transaction_id = '$transaction_id', tabby_payment_id='$payment_id',order_reference='$orderRef',inv_number='$inv_number',order_completed=1, status='New Order', payment_method='Tabby' WHERE id =" .$_SESSION['bg_basket'] ;		
	$result=mysql_query($query);
// 	print_r($query);
// 	die;
	if($result)
	{
	   console.log('updated');
	   header('Location: tabby_success.php');
	}
	else
	{
	   console.log('not updated');
	   //die('Error: '. mysql_error());

	}

?>