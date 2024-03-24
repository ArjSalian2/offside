<?php
session_start();


$recievedProductId = $_POST['prodID'];
$recievedUserId = $_POST['userID'];

$_SESSION["userIdSession"] = $recievedUserId;
//echo $recievedProductId;
//echo $recievedUserId;

$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

//Check stock level
$outOfStock = False;

$stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
$stmt->execute([$recievedProductId]);
$productRecord = $stmt->fetch();

if ($productRecord["StockLevel"] <= 0) {
    $outOfStock = True;
    exit();
}

$stmt = $db->prepare("SELECT * FROM shopping_basket WHERE UserID=?");
$stmt->execute([$recievedUserId]);
$allBaskets = $stmt->fetch();

if ($allBaskets) {
    echo "User has basket";
} else {
    echo "User has no basket";
    $stmt = $db->prepare("INSERT INTO shopping_basket (UserID) VALUES (?)");
    $stmt->execute([$recievedUserId]); 
}

$stmt = $db->prepare("SELECT * FROM shopping_basket WHERE UserID=?");
$stmt->execute([$recievedUserId]);
$basket = $stmt->fetch(PDO::FETCH_ASSOC);
$basketID = $basket["BasketID"];

$stmt = $db->prepare("SELECT * FROM shopping_basket_items WHERE BasketID=? AND ProductID=?");
$stmt->execute([$basketID, $recievedProductId]);
$productRow = $stmt->fetch(PDO::FETCH_ASSOC);


if ($productRow) {
    $ShoppingBasketItemID = $productRow["ShoppingBasketItemID"];

    $productQuantity = $productRow["Quantity"];
    $productQuantityToAdd = $productQuantity + 1;
    
    $stmt = $db->prepare("UPDATE shopping_basket_items SET Quantity = ? WHERE ShoppingBasketItemID = ?");
    $stmt->execute([$productQuantityToAdd, $ShoppingBasketItemID]);
    echo "product quantitiy increased";

} else {
    $stmt = $db->prepare("INSERT INTO shopping_basket_items (BasketID, ProductID, Quantity) VALUES (?, ?, ?)");
    $stmt->execute([$basketID, $recievedProductId, 1]);
    echo "product added to basket";
}


?>