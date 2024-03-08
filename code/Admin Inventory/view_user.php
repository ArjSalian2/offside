<?php
include_once "./Database/connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorMessage = "";
    $first_name = trim($_POST["first_name"]);
    if (empty($first_name)) {
        $errorMessage .= "Please enter first name.</Br>";
    }
    $last_name = trim($_POST["last_name"]);
    if (empty($last_name)) {
        $errorMessage .= "Please enter last name.</Br>";
    }
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $errorMessage .= "Please enter email address.</Br>";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage .= "Please enter a valid email address.</Br>";
        }
    }
    $phone = trim($_POST["phone"]);
    if (empty($phone)) {
        $errorMessage .= "Please enter phone number.</Br>";
    }
    $type = trim($_POST["type"]);
    if (empty($type)) {
        $errorMessage .= "Please enter user type.</Br>";
    }
    $userId = trim($_POST["userid"]);

    if (empty($errorMessage)) {
        $sql = "UPDATE users SET `First Name`=?, `Last Name`=?, Email=?, `Phone Number`=?, user_type=? WHERE userID=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $first_name, $last_name, $email, $phone, $type, $userId);
        if ($stmt->execute()) {
            header("location: view_customer.php");
            exit();
        } else {
            $errorMessage = "Something went wrong. Please try again later." . $stmt->error;
        }
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

    $userId = $_GET['id'];
    $sql = "SELECT users.*, user_type.Type AS usertype FROM users INNER JOIN user_type ON users.user_type = user_type.UserTypeID WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $first_name = $row['First Name'];
            $last_name = $row['Last Name'];
            $email = $row['Email'];
            $phone = $row['Phone Number'];
            $type = $row['usertype'];
            $created = $row['Created'];


        }
    }
    ?>
    <main>
        <div class="content">
            <h1 class="title">View User</h1>

            <div class="col-left">
                <a href="view_customer.php" class="adminbutton"><i class='bx bx-arrow-back'></i> Back</a>
            </div>

            <div class="info-data">
                <div class="card">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-25">
                                <label for="first_name">First Name:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $first_name ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="last_name">Last Name:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $last_name ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="email">Email Address:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $email ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="phone">Phone Number:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $phone ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="type">User Type:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $type ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="type">Created:</label>
                            </div>
                            <div class="col-75">
                                <p>
                                    <?= $created ?>
                                </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>