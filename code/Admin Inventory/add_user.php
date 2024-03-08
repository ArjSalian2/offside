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
    $password = trim($_POST["password"]);
    if (empty($password)) {
        $errorMessage .= "Please enter password.</Br>";
    }
    $conpassword = trim($_POST["conpassword"]);
    if (empty($conpassword)) {
        $errorMessage .= "Please enter confirmation password.</Br>";
    }
    if ($password != $conpassword) {
        $errorMessage .= "Please enter same password on confirm password.</Br>";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    $phone = trim($_POST["phone"]);
    if (empty($phone)) {
        $errorMessage .= "Please enter phone number.</Br>";
    }
    $type = isset($_POST["type"]) ? trim($_POST["type"]) : '';
    if ($type === '' || $type === false) {
        $errorMessage .= "Please enter user type.</br>";
    } else {
        if ($type === '0' || is_numeric($type)) {
        } else if (!is_numeric($type)) {
            $errorMessage .= "Invalid user type selected.</br>";
        }
    }

    $created = date('Y-m-d');

    if (empty($errorMessage)) {
        $sql = "INSERT INTO users (`First Name`, `Last Name`, Email, pass, `Phone Number`, user_type, Created) VALUES (?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssis", $first_name, $last_name, $email, $password, $phone, $type, $created);
        if ($stmt->execute()) {
            $_SESSION['success'] = "User added successfully!";
            header("location: view_customer.php");
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
    ?>
    <main>
        <div class="content">
            <h1 class="title">Add User</h1>
            <div class="info-data">
                <div class="card">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-25">
                                <label for="first_name">First Name:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="first_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="last_name">Last Name:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="email">Email Address:</label>
                            </div>
                            <div class="col-75">
                                <input type="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="password">Password:</label>
                            </div>
                            <div class="col-75">
                                <input type="password" name="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="conpassword">Confirmation Password:</label>
                            </div>
                            <div class="col-75">
                                <input type="password" name="conpassword" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="phone">Phone Number:</label>
                            </div>
                            <div class="col-75">
                                <input type="text" name="phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="type">User Type:</label>
                            </div>
                            <div class="col-75">
                                <select name="type" required>
                                    <option value="">Select</option>
                                    <?php
                                    // Fetch and display products
                                    $sqlType = "SELECT * FROM user_type ORDER BY Type ASC";
                                    $resultType = $conn->query($sqlType);

                                    if ($resultType->num_rows > 0) {
                                        while ($rowType = $resultType->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $rowType['UserTypeID'] ?>">
                                                <?= $rowType['Type'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">

                            </div>
                            <div class="col-75">
                                <input type="submit" name="add_product" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>