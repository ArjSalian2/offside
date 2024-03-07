<?php
include_once "./Database/connection.php";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $userId = $_GET["id"];
    $sql = "DELETE FROM users WHERE userID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        ;

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "User deleted successfully!";
            header("location: view_customer.php");
            exit();
        } else {
            $_SESSION['error'] = "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_close($conn);
} else {
    if (empty(trim($_GET["id"]))) {
        header("location: view_customer.php");
        exit();
    }
}
?>