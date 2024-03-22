<?php 
session_start();
$recievedProductID = $_POST["prodID"];
$recievedUserID  = $_POST["userID"];
$recievedReview = $_POST["review"];


$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

$stmt = $db->prepare("INSERT INTO reviews (UserID, product_id, Comment) VALUES (?,?,?)");
$stmt->execute([$recievedUserID, $recievedProductID, $recievedReview]);

?>