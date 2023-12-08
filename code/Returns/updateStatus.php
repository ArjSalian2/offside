<?php

include_once "./Database/connection.php";

$order_id = $_POST['record'];
$sql = "SELECT ReturnStatusID from order_items where OrderItemsID='$order_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row["ReturnStatusID"] == 1) {
     $update = mysqli_query($conn, "UPDATE order_items SET ReturnStatusID=2 where OrderItemsID='$order_id'");
}


?>