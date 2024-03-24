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
    ?>


    <main>
        <div class="content">
            <h1 class="title">Order Management</h1>
            <div class="aboutHeading">View and Update Orders</div>
            <div class="info-data">
                <div class="card">
                    <div class="table-scrollable">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Total Amount</th>
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT orders.*, CONCAT(address.AddressLine, ', ', address.Postcode) AS address,
                                orderstatus.StatusName AS orderstatus
                                FROM orders 
                                INNER JOIN address ON orders.AddressID = address.AddressID
                                INNER JOIN orderstatus ON orders.OrderStatus = orderstatus.StatusID ORDER BY OrderID ASC";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row["OrderID"] ?>
                                            </td>

                                            <td>
                                                <?= $row["UserID"] ?>
                                            </td>
                                            <td>
                                                <?= $row["address"] ?>
                                            </td>
                                            <td>
                                                <?= '£' . $row['TotalAmount'] ?>
                                            </td>
                                            <td>
                                                <div
                                                    class="order-status <?= strtolower(htmlspecialchars($row["orderstatus"])) ?>">
                                                    <?= htmlspecialchars($row["orderstatus"]) ?>
                                                </div>
                                            </td>

                                            <td>
                                                <?= $row["OrderDate"] ?>
                                            </td>
                                            <td>
                                                <a href='view_order.php?id=<?= $row['OrderID'] ?>' class='infobutton'><i
                                                        class='bx bxs-user-detail'></i></a>
                                                <a href='edit_order.php?id=<?= $row['OrderID'] ?>' class='editbutton'><i
                                                        class='bx bx-edit'></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">No records found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>