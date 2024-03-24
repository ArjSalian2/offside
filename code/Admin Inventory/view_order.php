<?php
include_once "./Database/connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorMessage = "";

    $order_status = trim($_POST["type"]);
    if (empty($order_status)) {
        $errorMessage .= "Please enter order status.</Br>";
    }
    $orderId = trim($_POST["orderid"]);

    if (empty($errorMessage)) {
        $sql = "UPDATE orders SET `OrderStatus`=? WHERE OrderID=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $order_status, $orderId);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order Status Updated Successfully!";
            header("location: orders.php");
            exit();
        } else {
            $errorMessage = "Something went wrong. Please try again later." . $stmt->error;
        }
    }
    if (isset($errorMessage)) {
        $_SESSION['error'] = $errorMessage;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/style.css" />
    <title>Admin Inventory Management</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";

    $orderId = $_GET['id'];
    $sql = "SELECT orders.*, CONCAT(address.AddressLine, ', ', address.Postcode) AS address,
                                orderstatus.StatusName AS orderstatus
                                FROM orders 
                                INNER JOIN address ON orders.AddressID = address.AddressID
                                INNER JOIN orderstatus ON orders.OrderStatus = orderstatus.StatusID WHERE OrderID = ?";


    $sqlTwo =
        "SELECT p.ImageURL, p.product_id
        FROM orders o
        JOIN order_items oi ON o.OrderID = oi.OrderID
        JOIN products p ON oi.ProductID = p.product_id
        WHERE o.OrderID = ?";





    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $order = $row['OrderID'];
            $user = $row['UserID'];
            $orderdate = $row['OrderDate'];
            $order_status = $row['orderstatus'];
            $address = $row['address'];
            $amount = $row['TotalAmount'];




        }
    }

    $stmt = $conn->prepare($sqlTwo);
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = [
                    'ImageURL' => $row['ImageURL'],
                    'product_id' => $row['product_id']
                ];
            }
        } else {
            echo 'No products found for this order.';
        }
    } else {
        echo 'Error executing query: ' . $conn->error;
    }


    ?>
    <main>
        <div class="content">
            <h1 class="title">View Order</h1>

            <div class="col-left">
                <a href="orders.php" class="adminbutton"><i class='bx bx-arrow-back'></i> Back</a>
            </div>

            <div class="info-data">
                <div class="card">
                    <div class="table-scrollable">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-25">
                                    <label for="first_name">OrderID:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $order ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="last_name">UserID:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $user ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="email">Order Date:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $orderdate ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="phone">Order Status:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $order_status ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="type">Address:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= $address ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="type">Total Amount:</label>
                                </div>
                                <div class="col-75">
                                    <p>
                                        <?= '£' . $amount ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="images">Product Images:</label>
                                </div>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <a href="view_product.php?id=<?= htmlspecialchars($product['product_id'])
                                            ?>&ref=view_order&orderId=<?= htmlspecialchars($order) ?>">
                                            <img class='productthumb'
                                                src='/offside/code/product_img/<?= htmlspecialchars($product['ImageURL']) ?>'
                                                alt='Product Image'>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No images to display.</p>
                                <?php endif; ?>
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