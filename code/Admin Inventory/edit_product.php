<?php
include_once "./Database/connection.php";

// Check if product ID is provided

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
  
    $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        // Product not found, redirect or show error message
      
        header("Location: products.php"); // Redirect to product management page
        exit();
    }
} else {
    // Product ID not provided, redirect or show error message
    header("Location: products.php"); // Redirect to product management page
    exit();
}

// Check if form is submitted for updating product details

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
  
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_colour = $_POST['product_colour'];
    $product_gender = $_POST['product_gender'];
    $CategoryID = $_POST['CategoryID'];
    $StockLevel = $_POST['StockLevel'];

    // Update product details in the database
    $sql = "UPDATE products SET product_name = '$product_name', product_price = '$product_price', 
            product_colour = '$product_colour', product_gender = '$product_gender', 
            CategoryID = '$CategoryID', StockLevel = '$StockLevel' WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // successful update
        echo "<script>alert('Product updated successfully');</script>";
        header("Location: products.php");
        
        exit();
    } else {
                #error mesage
        echo "<script>alert('Error updating product');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <title>Edit Product</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";
    ?>

    <main>
        <div class="content">
            <h1 class="title">Edit Product</h1>
            <div class="form-container">
                <form method="post">
                    <label for="product_name">Product Name:</label><br>
                    <input type="text" id="product_name" name="product_name" value="<?= $product['product_name'] ?>" required><br><br>

                    <label for="product_price">Price:</label><br>
                    <input type="number" id="product_price" name="product_price" value="<?= $product['product_price'] ?>" required><br><br>

                    <label for="product_colour">Colour:</label><br>
                    <input type="text" id="product_colour" name="product_colour" value="<?= $product['product_colour'] ?>" required><br><br>

                    <label for="product_gender">Gender:</label><br>
                    <select id="product_gender" name="product_gender" required>
                        <option value="Male" <?= ($product['product_gender'] == 'Male' ? 'selected' : '') ?>>Male</option>
                        <option value="Female" <?= ($product['product_gender'] == 'Female' ? 'selected' : '') ?>>Female</option>
                        <option value="Unisex" <?= ($product['product_gender'] == 'Unisex' ? 'selected' : '') ?>>Unisex</option>
                    </select><br><br>

                    <label for="CategoryID">Category:</label><br>
                    <select id="CategoryID" name="CategoryID" required>
                        <option value="1" <?= ($product['CategoryID'] == 1 ? 'selected' : '') ?>>Hoodies</option>
                        <option value="2" <?= ($product['CategoryID'] == 2 ? 'selected' : '') ?>>Trousers</option>
                        <option value="3" <?= ($product['CategoryID'] == 3 ? 'selected' : '') ?>>Shoes</option>
                        <option value="4" <?= ($product['CategoryID'] == 4 ? 'selected' : '') ?>>T-Shirt</option>
                        <option value="5" <?= ($product['CategoryID'] == 5 ? 'selected' : '') ?>>Accessories</option>
                    </select><br><br>

                    <label for="StockLevel">Stock Level:</label><br>
                    <input type="number" id="StockLevel" name="StockLevel" value="<?= $product['StockLevel'] ?>" required><br><br>

                    <button type="submit" name="update_product" id = "addbutton" class = "addbutton">Update Product</button>

                </form>
            </div>
        </div>
    </main>

</body>

<script src="script.js"></script>

</html>
