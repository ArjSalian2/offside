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
    include_once "./Database/connection.php";
    ?>


    <div class="notMain">
        <div class="notContent">
            <h1 class="title">Add Users</h1>
            <div class="notInfo-data">
                <div class="notCard">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="input-field">
                            <label> First Name<sup>*</sup></label>
                            <input type="text" name="first" maxlength="100" required placeholder="First Name">
                        </div>
                        <div class="input-field">
                            <label> Last Name<sup>*</sup></label>
                            <input type="text" name="last" maxlength="100" required placeholder="Last Name">
                        </div>
                        <div class="input-field">
                            <label> Email<sup>*</sup></label>
                            <input type="text" name="email" maxlength="100" required placeholder="Email">
                        </div>
                        <div class="input-field">
                            <label> Password<sup>*</sup></label>
                            <input type="text" name="password" maxlength="100" required placeholder="Password">
                        </div>
                        <div class="input-field">
                            <label> Phone Number<sup>*</sup></label>
                            <input type="number" name="phone" maxlength="100" required placeholder="Phone Number">
                        </div>
                        <div class="addButton">
                            <button type="submit" id="upload">Add
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="script.js"></script>

</html>