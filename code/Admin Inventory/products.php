<?php
include_once "./Database/connection.php";
$search = " WHERE product_id > 0 ";
$category = $gender = $minprice = $maxprice = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchterm = trim($_POST["searchterm"]);
    $search .= " AND product_name LIKE '%" . $searchterm . "%' OR product_colour LIKE '%" . $searchterm . "%' OR Description LIKE '%" . $searchterm . "%' OR product_id LIKE '%" . $searchterm . "%'";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filter"])) {
    $category = $_POST["category"];
    if ($category != "") {
        $search .= " AND products.CategoryID='" . $category . "' ";
    }
    $gender = $_POST["gender"];
    if ($gender != "") {
        $search .= " AND product_gender='" . $gender . "' ";
    }
    $minprice = $_POST["minprice"];
    $maxprice = $_POST["maxprice"];
    if ($minprice != "" && $maxprice != "" && is_numeric($minprice) && is_numeric($maxprice)) {
        $search .= " AND product_price BETWEEN '" . $minprice . "' AND '" . $maxprice . "' ";
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
    <title>Admin Inventory Management</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";
    ?>
    <main>
        <div class="content">
            <h1 class="title">Product Management</h1>
            <div class="aboutHeading">View, Add, Update and Delete Products</div>
            <form action="" method="POST" class="">
                <div class="row">
                    <div class="col-right">
                        <input type="searchInput" class="searchterm" name="searchterm" placeholder="Search"
                            value="<?= (isset($_POST["searchterm"]) ? $_POST["searchterm"] : '') ?>">
                        <button type="submit" name="search" class="searchbutton">
                            <i class='bx bx-search-alt'></i>
                        </button>

                        <div class="col-right">
                            <a href="add_user.php" class="addbutton"><i class='bx bx-plus-circle'></i> Add Product</a>
                        </div>
                    </div>
                </div>
            </form>
            <form action="" method="POST" class="">
                <div class="row">
                    <div class="col-75">
                        <!--category-->
                        <select name="category" class="searchterm">
                            <option value="">Select Category</option>
                            <?php
                            // Fetch and display products
                            $sqlCategory = "SELECT * FROM category ORDER BY Name ASC";
                            $resultCategory = $conn->query($sqlCategory);

                            if ($resultCategory->num_rows > 0) {
                                while ($rowCategory = $resultCategory->fetch_assoc()) {
                                    if ($category == $rowCategory['CategoryID']) {
                                        ?>
                                        <option value="<?= $rowCategory['CategoryID'] ?>" selected>
                                            <?= $rowCategory['Name'] ?>
                                        </option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?= $rowCategory['CategoryID'] ?>">
                                            <?= $rowCategory['Name'] ?>
                                        </option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <!--gender-->
                        <select name="gender" class="filtergender">
                            <option value="">Select Gender</option>
                            <option value="unisex" <?= ($gender == 'unisex' ? 'selected' : '') ?>>Unisex</option>
                            <option value="womens" <?= ($gender == 'womens' ? 'selected' : '') ?>>Womens</option>
                            <option value="mens" <?= ($gender == 'mens' ? 'selected' : '') ?>>Mens</option>
                        </select>
                        <!--min/max price-->
                        <input type="number" name="minprice" class="filter" placeholder="Min Price"
                            value="<?= (isset($_POST["minprice"]) ? $_POST["minprice"] : '') ?>">
                        <input type="number" name="maxprice" class="filter" placeholder="Max Price"
                            value="<?= (isset($_POST["maxprice"]) ? $_POST["maxprice"] : '') ?>">
                        <!--filter button-->


                        <button name="filter" value="Filter" class="filterbutton" title="Filter"><i
                                class='bx bx-filter'></i>
                        </button>
                        <button href="view_customer.php" class="filterbutton" title="reset"><i class='bx bx-reset'></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="info-data">
                <div class="productcard-container">
                    <?php
                    // Fetch and display products
                    $sql = "SELECT products.*, category.Name AS categoryname FROM products INNER JOIN category ON products.CategoryID=category.CategoryID " . $search . " ORDER BY product_id ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="productcard">
                                <img class='thumb' src='/offside/code/product_img/<?= $row['ImageURL'] ?>'>
                                <div class="productcard-details">
                                    <p>ProductId:
                                        <strong>
                                            <?= $row['product_id'] ?>
                                        </strong>
                                    </p>
                                    <p class="productname">

                                        <?= $row['product_name'] ?>

                                    </p>

                                    <div class="item-price">
                                        <?= '<sup>£</sup>' . $row['product_price'] ?>
                                    </div>
                                    <!-- <div class="description">
                                        <p>Description:
                                            <?= $row['Description'] ?>
                                        </p>
                                    </div> -->

                                    <p>Category:
                                        <?= $row['categoryname'] ?>
                                    </p>
                                    <p>Stock Level:
                                        <strong>
                                            <?= $row['StockLevel'] ?>
                                        </strong>
                                    </p>
                                    <div class="productcard-buttons">
                                        <a href='view_product.php?id=<?= $row['product_id'] ?>' class='infobutton'><i
                                                class='bx bxs-user-detail'></i></a>
                                        <a href='edit_product.php?id=<?= $row['product_id'] ?>' class='editbutton'><i
                                                class='bx bx-edit'></i></a>
                                        <a href='delete_product.php?id=<?= $row['product_id'] ?>' class='deletebutton'><i
                                                class='bx bx-user-x'></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <p>No records found</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>