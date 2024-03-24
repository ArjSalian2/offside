<?php
session_start();

$server = "localhost";
$user = "root";
$password = "";
$db = "sports_ecommerce_database";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
   die("Connection Failed:" . mysqli_connect_error());
}
?>