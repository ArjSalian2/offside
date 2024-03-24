<?php
session_start();


$recievedOrderItemID = $_POST['orderItemID'];

$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

$stmt = $db->prepare("UPDATE order_items SET ReturnStatusID = 2 WHERE OrderItemsID = ?");
$stmt->execute([$recievedOrderItemID]);

?>