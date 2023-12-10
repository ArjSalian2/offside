<?php

$server = "localhost";
$user = "root";
$password = "";
$dbname = "sports_ecommerce_database";

$db = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);

//if (!$conn) {
   //die("Connection Failed:" . mysqli_connect_error());
//} else {
   //echo "Connected successfully";
//}
?>