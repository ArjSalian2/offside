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
            $_SESSION['success'] = "Order updated successfully!";
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
    <link rel="stylesheet" href="./css/style.css" />
    <title>Admin Inventory Management</title>
</head>

<body>
    <?php
    include "./sidebar.php";
    include "./nav.php";

    $orderId = $_GET['id'];
    $sql = "SELECT orders.*, CONCAT(address.AddressLine, ', ', address.City, ', ', address.Postcode) AS address,
    CONCAT(users.`First Name`, ' ', users.`Last Name`) AS fullname
    FROM orders
    INNER JOIN users ON orders.UserID = users.UserID
    INNER JOIN address ON orders.AddressID = address.AddressID 
    WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $order = $row['OrderID'];
            $user = $row['fullname'];
            $orderdate = $row['OrderDate'];
            $order_status = $row['OrderStatus'];
            $address = $row['address'];
            $amount = $row['TotalAmount'];

        }
    }
    ?>
    <main>
        <div class="content">
            <h1 class="title">Update Order Status</h1>
            <div class="col-left">
                <a href="orders.php" class="adminbutton"><i class='bx bx-arrow-back'></i> Back</a>
            </div>
            <div class="info-data">
                <div class="card">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-25">
                                <label for="first_name">OrderID:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="first_name" value="<?= $order ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="last_name">Customer Name:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="last_name" value="<?= $orderdate ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="email">Order Date:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="email" value="<?= $user ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="phone">Address:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="phone" value="<?= $address ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="phone">Total Amount:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="phone" value="<?= '£' . $amount ?>">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="type">Order Status:</label>
                            </div>
                            <div class="col-75">
                                <select name="type" required>
                                    <option value="">Select</option>
                                    <?php
                                    // Fetch and display 
                                    $sqlType = "SELECT * FROM orderstatus";
                                    $resultType = $conn->query($sqlType);

                                    if ($resultType->num_rows > 0) {
                                        while ($rowType = $resultType->fetch_assoc()) {
                                            if ($rowType['StatusID'] == $order_status) {
                                                ?>
                                                <option value="<?= $rowType['StatusID'] ?>" selected>
                                                    <?= $rowType['StatusName'] ?>
                                                </option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $rowType['StatusID'] ?>">
                                                    <?= $rowType['StatusName'] ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">

                            </div>
                            <div class="col-end">
                                <input type="hidden" name="orderid" id="orderid" value="<?= $orderId ?>">
                                <input type="submit" class="savebutton" name="update_order" value="Update Status">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>