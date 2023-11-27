<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "sports_ecommerce_database";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
   die("Connection Failed:" . mysqli_connect_error());
} else {
   echo "Connected successfully";
}
?>