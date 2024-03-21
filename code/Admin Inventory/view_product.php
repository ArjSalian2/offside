<?php
include_once "./Database/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <title>Admin Inventory Management</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";

    $productId = $_GET['id'];
    $sql = "SELECT products.*, category.Name AS categoryname FROM products INNER JOIN category ON products.CategoryID=category.CategoryID WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $name = $row['product_name'];
            $price = $row['product_price'];
            $gender = $row['product_gender'];
            $color = $row['product_colour'];
            $description = $row['Description'];
            $categoryname = $row['categoryname'];
            $stocklevel = $row['StockLevel'];
            $image = $row['ImageURL'];
        }
    }
    ?>
    <main>
        <div class="content">
            <h1 class="title">View Product</h1>
            <?php
            // Default back URL goes to the products page
            $backUrl = "products.php";

            // Check if the referrer is 'view_order' and an order ID is provided
            if (!empty($_GET['ref']) && $_GET['ref'] == 'view_order' && !empty($_GET['orderId'])) {
                // Modify the back URL to include the order ID
                $backUrl = "view_order.php?id=" . htmlspecialchars($_GET['orderId']);
            }
            ?>
            <div class="col-left">
                <a href="<?= $backUrl ?>" class="adminbutton"><i class='bx bx-arrow-back'></i> Back</a>
            </div>



            <div class="info-data">
                <div class="card">
                    <div class="table-scrollable">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-25">
                                    <label for="product_name">Product Name:</label>
                                </div>
                                <div class="col-75">
                                    <?= $name ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="product_price">Product Price:</label>
                                </div>
                                <div class="col-75">
                                    <?= '£' . $price ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="product_colour">Product Color:</label>
                                </div>
                                <div class="col-75">
                                    <?= $color ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="product_category">Product Category:</label>
                                </div>
                                <div class="col-75">
                                    <?= $categoryname ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="product_gender">Product Gender:</label>
                                </div>
                                <div class="col-75">
                                    <?= $gender ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="stocklevel">Stock Level:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <strong>
                                            <?= $stocklevel ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="image">Image:</label>
                                </div>
                                <div class="col-75">
                                    <img class='productthumb'
                                        src='/offside/code/product_img/<?= htmlspecialchars($image) ?>'
                                        alt='Product Image'>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="description">Description:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $description ?>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>