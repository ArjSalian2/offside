<?php 
include './config.php';
session_start();
$recievedTotalPrice = $_POST['totalPrice'];
$recievedUserID = $_POST["userID"];
$recievedBasketID = $_POST["basketID"];


$stmt = $db->prepare("SELECT * FROM address WHERE userID=?");
$stmt->execute([$recievedUserID]);
$userAddressRecord = $stmt->fetch();

$date = date("Y-m-d");

$stmt = $db->prepare("INSERT INTO orders (UserID, OrderDate, OrderStatus, AddressID, TotalAmount) VALUES (?,?,?,?,?)");
$stmt->execute([$recievedUserID,$date,1,$userAddressRecord["AddressID"],$recievedTotalPrice]);

$stmt = $db->prepare("SELECT * FROM orders WHERE UserID =? ORDER BY OrderID DESC LIMIT 0,1");
$stmt->execute([$recievedUserID]);
$orderRecord = $stmt->fetch();

$stmt = $db->prepare("SELECT * FROM shopping_basket_items WHERE BasketID=?");
$stmt->execute([$recievedBasketID]);
$basketItems = $stmt->fetchAll();

foreach ($basketItems as $basketItem) {
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->execute([$basketItem["ProductID"]]);
    $productRecord = $stmt->fetch();
    
    // Calculate the new stock level
    $newStockLevel = $productRecord["StockLevel"] - $basketItem["Quantity"];
    
    // Update the stock level in the products table
    $stmt = $db->prepare("UPDATE products SET StockLevel=? WHERE product_id=?");
    $stmt->execute([$newStockLevel, $basketItem["ProductID"]]);
    
    // Calculate the total price for the quantity
    $fullQuantityPrice = ($productRecord["product_price"] * $basketItem["Quantity"]);
    
    // Insert the item into the order_items table
    $stmt = $db->prepare("INSERT INTO order_items (ProductID, OrderID, Quantity, Price, ReturnStatusID) VALUES (?,?,?,?,?)");
    $stmt->execute([$basketItem["ProductID"], $orderRecord["OrderID"], $basketItem["Quantity"], $fullQuantityPrice, 1]);
    }

$stmt = $db->prepare("DELETE FROM shopping_basket_items WHERE BasketID=?");
$stmt->execute([$recievedBasketID]);

echo $recievedTotalPrice;
?>