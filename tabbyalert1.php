<?php

header('Content-Type: application/json');
$varname = file_get_contents('php://input');


$query = "INSERT INTO webhooks (data) VALUES ('".$varname."')";

$result=mysql_query($query);

?>