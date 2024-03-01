<?php
session_start();

$recievedItemID = $_POST['itemID'];
$recievedCartAction = $_POST['cartAction'];

$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

if ($recievedCartAction == "increase") {
    $stmt = $db->prepare("UPDATE shopping_basket_items SET Quantity = Quantity + 1 WHERE ShoppingBasketItemID = ?");
    $stmt->execute([$recievedItemID]);

} else if ($recievedCartAction == "decrease") {
    $stmt = $db->prepare("UPDATE shopping_basket_items SET Quantity = Quantity - 1 WHERE ShoppingBasketItemID = ?");
    $stmt->execute([$recievedItemID]);

} else if ($recievedCartAction == "remove"){
    $stmt = $db->prepare("DELETE FROM shopping_basket_items WHERE ShoppingBasketItemID = ?");
    $stmt->execute([$recievedItemID]);

}

?>