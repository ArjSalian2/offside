<?php
$db = new PDO("mysql:host=localhost;dbname=sports_ecommerce_database", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Fetch product details from the database
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
