 <?php

 include_once('includes/global.php'); 

/* if($json = json_decode(file_get_contents("php://input"), true)) {
     print_r($json);
     $data = $json;
 } else {
     print_r($_POST);
     $data = $_POST;
 }*/

$raw_data = file_get_contents('php://input');
error_log(print_r($raw_data, true));

//die;




 echo "Saving data ...\n";
 $url = "https://brewinggadgets.com/tabbyalert.php";

 $meta = ["received" => time(),
     "status" => "new",
     "agent" => $_SERVER['HTTP_USER_AGENT']];

 $options = ["http" => [
     "method" => "POST",
     "header" => ["Content-Type: application/json"],
     "content" => json_encode(["data" => $data, "meta" => $meta])]
     ];

 $context = stream_context_create($options);
 $response = file_get_contents($url, false, $context);  

$query = "INSERT INTO webhooks (data,transactionid) VALUES ('".$raw_data."','1')";
$result=mysql_query($query);

$query = "INSERT INTO webhooks (data,transactionid) VALUES ('data1','1')";
$result=mysql_query($query);

 ?>