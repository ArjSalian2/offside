<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "sports_ecommerce_database";

$conn = mysqli_connect($server, $user, $password, $database);

if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}

?>