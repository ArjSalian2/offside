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
            <h1 class="title">Admin Management</h1>
            <div class="aboutHeading">Add, Update and Delete Customers and Admin</div>
            <div class="row">
                <div class="col-right">
                    <a href="view_customer.php" class="adminbutton"><i class='bx bxs-user-account'></i> View
                        Customers</a>
                    <a href="add_user.php" class="addbutton"><i class='bx bx-plus-circle'></i> Add User</a>
                </div>

            </div>
            <div class="info-data">
                <div class="card">
                    <div class="table-scrollable">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php
                            $sql = "SELECT * from users where user_type=0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $row["userID"] ?>
                                        </td>
                                        <td>
                                            <?= $row["First Name"] ?>
                                        </td>
                                        <td>
                                            <?= $row["Last Name"] ?>
                                        </td>
                                        <td>
                                            <?= $row["Email"] ?>
                                        </td>
                                        <td>
                                            <?= $row["Phone Number"] ?>
                                        </td>
                                        <td>
                                            <?= $row["Created"] ?>
                                        </td>
                                        <td>
                                            <a href='view_user.php?id=<?= $row['userID'] ?>' class='infobutton'><i
                                                    class='bx bxs-user-detail'></i></a>
                                            <a href='edit_user.php?id=<?= $row['userID'] ?>' class='editbutton'><i
                                                    class='bx bx-edit'></i></a>
                                            <a href='delete_user.php?id=<?= $row['userID'] ?>' class='deletebutton'><i
                                                    class='bx bx-user-x'></i></a>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

<script src="scripts.js"></script>

</html>