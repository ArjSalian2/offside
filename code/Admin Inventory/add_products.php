<?php
include_once "./Database/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_colour = $_POST['product_colour'];
    $product_gender = $_POST['product_gender'];
    $CategoryID = $_POST['CategoryID'];
    $StockLevel = $_POST['StockLevel'];

    $target_dir = "../product_img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_image_name = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $new_image_name;

    // Uploading file to  eccomerce sports database
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            
            $sql = "INSERT INTO products (product_name, product_price, product_colour, product_gender, CategoryID, StockLevel, ImageURL) 
                    VALUES ('$product_name', '$product_price', '$product_colour', '$product_gender', '$CategoryID', '$StockLevel', '$new_image_name')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Product added successfully');</script>";
                header("Location: products.php")
            } else {
                echo "<script>alert('Error adding product');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
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
    <title>Add Product</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";
    ?>

    <main>
        <div class="content">
            <h1 class="title">Add Product</h1>
            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
                    <label for="product_name">Product Name:</label><br>
                    <input type="text" id="product_name" name="product_name" required><br><br>

                    <label for="product_price">Price:</label><br>
                    <input type="number" id="product_price" name="product_price" required><br><br>

                    <label for="product_colour">Colour:</label><br>
                    <input type="text" id="product_colour" name="product_colour" required><br><br>

                    <label for="product_gender">Gender:</label><br>
                    <select id="product_gender" name="product_gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unisex">Unisex</option>
                    </select><br><br>

                    <label for="CategoryID">Category:</label><br>
                    <select id="CategoryID" name="CategoryID" required>
                        <option value="1">Hoodies</option>
                        <option value="2">Trousers</option>

                        <option value="3">Shoes</option>
                        <option value="4">T-Shirt</option>
                        <option value="5">Accessories</option>
                    </select><br><br>

                    <label for="StockLevel">Stock Level:</label><br>
                    <input type="number" id="StockLevel" name="StockLevel" required min="1"><br><br>

                    <label for="image">Product Image:</label><br>

                    <input type="file" id="image" name="image" required><br><br>

                    <button type="submit" name="add_product" id = "addbutton" class = "addbutton">Add Product</button>

                </form>
            </div>
        </div>
    </main>

</body>

<script src="script.js"></script>

</html>
