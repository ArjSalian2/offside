<!DOCTYPE html>
<html>

<head>
    <title>Return</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    </link>

</head>

<body>

    <?php


    include_once "./Database/connection.php";
    ?>
    <div class="allOrders">
        <header>

            <div class="logo"> <!--Hadeeqa-The logo for top of page-->
                <img src="homepage-img/logo.png" alt="Offside Logo">
            </div>

            <div class="top-right-nav">
                <div id="nav1">
                    <a href="about.html">About Us</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Sign In</a>
                    <a href="#">Account details</a>
                </div>

        </header>

        <!-- nav2-dima -->
        <div id="nav2">
            <div class="nav2-center">
                <a href="products.php?gender%5B%5D=womens">Women</a>
                <a href="products.php?gender%5B%5D=mens">Men</a>
                <a href="#">Accessories</a>
            </div>

            <div class="nav2-right">
                <div id="search">
                    <form>
                        <input type="text" name="search" placeholder="Search">
                        <input type="submit" value="Enter">
                    </form>
                </div>
                <div id="basket-icon">
                    <a href="cart.php"><img src="homepage-img/basket-icon.png" alt="Basket"></a>
                </div>
            </div>
        </div>
        <main>

            <div class="title">Return</div>
            <div class="info-data">
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>User</th>
                                <th>Order Date</th>
                                <th>Address</th>
                                <th>Order Status</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <?php
                        include_once "./Database/connection.php";
                        $sql = "SELECT orders.OrderID, CONCAT(users.`First Name`, ' ', users.`Last Name`) AS FullName, orders.OrderDate, 
                        CONCAT(address.AddressLine,', ', address.Postcode) AS 'Address', orders.OrderStatus, orders.TotalAmount
                        FROM orders JOIN users ON orders.UserID = users.UserID
                        JOIN address ON orders.AddressID = address.AddressID";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $row["OrderID"] ?>
                                    </td>
                                    <td>
                                        <?= $row["FullName"] ?>
                                    </td>
                                    <td>
                                        <?= $row["OrderDate"] ?>
                                    </td>
                                    <td>
                                        <?= $row["Address"] ?>
                                    </td>
                                    <?php
                                    if ($row["OrderStatus"] == 1) {
                                        ?>

                                        <td>
                                            <div class="statusBlue">Pending</div>
                                        </td>

                                        <?php
                                    } else {
                                        ?>
                                        <td>
                                            <div class="statusGreen">Delivered</div>
                                        </td>

                                        <?php
                                    }
                                    ?>
                                    <td>
                                        <?= $row["TotalAmount"] ?>
                                    </td>

                                    <td><a class="view" data-href="./productsForOrders.php?orderID=<?= $row['OrderID'] ?>"
                                            href="javascript:void(0);">View</a></td>
                                </tr>
                                <?php

                            }
                        }
                        ?>

                    </table>



                    <h4 class="heading">Order Details</h4>
                    <div class="card">
                        <div class="view-products">
                        </div>
                        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                        <script>
                            $(document).ready(function () {
                                $('.view').on('click', function () {
                                    var dataURL = $(this).attr('data-href');

                                    $('.view-products').load(dataURL, function () {
                                        $('#viewModal').dialog({
                                            autoOpen: true,
                                            modal: true,
                                            width: 'auto',
                                            height: 'auto'
                                        });
                                    });
                                });
                            });
                        </script>
                    </div>

                </div>
            </div>


        </main>
    </div>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">
    </script>
    <script type="text/javascript" src="./returnFunctions.js"></script>

</body>

</html>