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


  <main>
    <div class="content">
      <h1 class="title">User Management</h1>
      <div class="info-data">
        <div class="card">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Created</th>
              </tr>
            </thead>
            <?php
            include_once "./Database/connection.php";
            $sql = "SELECT * from users where user_type=1";
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
                </tr>
                <?php
              }
            } else {
              echo "No records found";
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </main>

</body>

<script src="script.js"></script>

</html>