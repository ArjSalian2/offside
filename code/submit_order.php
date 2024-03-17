<?php 
session_start();
$recievedTotalPrice = $_POST['totalPrice'];
$recievedUserID = $_POST["userID"];
$recievedBasketID = $_POST["basketID"];

$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

//Check stock level
$outOfStock = False;

$stmt = $db->prepare("SELECT * FROM shopping_basket_items WHERE BasketID=?");
$stmt->execute([$recievedBasketID]);
$basketItems = $stmt->fetchAll();

foreach ($basketItems as $basketItem) {
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->execute([$basketItem["ProductID"]]);
    $productRecord = $stmt->fetch();
    if ($productRecord["StockLevel"] < $basketItem["Quantity"]) {
        $outOfStock = True;
        echo "Only " . $productRecord["StockLevel"] . " " . $productRecord["product_name"] . " in stock" ;
        exit();
    }
}

if (!$outOfStock) {
    $stmt = $db->prepare("SELECT * FROM address WHERE userID=?");
    $stmt->execute([$recievedUserID]);
    $userAddressRecord = $stmt->fetch();
    
    $date = date("Y-m-d");
    
    $stmt = $db->prepare("INSERT INTO orders (UserID, OrderDate, OrderStatus, AddressID, TotalAmount) VALUES (?,?,?,?,?)");
    $stmt->execute([$recievedUserID,$date,1,$userAddressRecord["AddressID"],$recievedTotalPrice]);
    
    $stmt = $db->prepare("SELECT * FROM orders WHERE UserID =? ORDER BY OrderID DESC LIMIT 0,1");
    $stmt->execute([$recievedUserID]);
    $orderRecord = $stmt->fetch();
    
    
    foreach ($basketItems as $basketItem) {
        $stmt = $db->prepare("SELECT * FROM products WHERE product_id=?");
        $stmt->execute([$basketItem["ProductID"]]);
        $productRecord = $stmt->fetch();
        $fullQuantityPrice = ($productRecord["product_price"] * $basketItem["Quantity"]);
    
        $stmt = $db->prepare("INSERT INTO order_items (ProductID, OrderID, Quantity, Price, ReturnStatusID) VALUES (?,?,?,?,?)");
        $stmt->execute([$basketItem["ProductID"], $orderRecord["OrderID"], $basketItem["Quantity"], $fullQuantityPrice, 1]);
    }
    
    $stmt = $db->prepare("DELETE FROM shopping_basket_items WHERE BasketID=?");
    $stmt->execute([$recievedBasketID]);
    
}

?>