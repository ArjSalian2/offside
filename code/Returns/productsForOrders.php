<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Return Status</th>
        </tr>
    </thead>
    <?php
    include_once "./Database/connection.php";
    $orderID = mysqli_real_escape_string($conn, $_GET['orderID']);
    $sql = "SELECT p.product_name, od.Quantity, od.Price, rs.ReturnStatusID
                FROM order_items od
                INNER JOIN products p ON od.ProductID = p.product_id
                LEFT JOIN returnstatus rs ON od.ReturnStatusID = rs.ReturnStatusID
                WHERE od.OrderID = $orderID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <?= $row["product_name"] ?>
                </td>
                <td>
                    <?= $row["Quantity"] ?>
                </td>
                <td>
                    <?= $row["Price"] ?>
                </td>
                <?php
                if ($row["ReturnStatusID"] == 1) {

                    ?>
                    <td><a class="statusBlues" onclick="UpdateReturnStatus(' <?= $row['ReturnStatusID'] ?>')">Return
                        </a></td>
                    <?php

                } else {
                    ?>
                    <td><a class="statusGreens" onclick="UpdateReturnStatus('<?= $row['ReturnStatusID'] ?>')">Return
                            Processed</a>
                    </td>

                    <?php
                }
                ?>
            </tr>
            <?php
        }
    } else {
        echo "No data available for this order.";
    }
    ?>
</table>