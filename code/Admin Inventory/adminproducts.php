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
//this is the side bar thingie
   include "./sidebar.php";
   include "./nav.php";
  ?>

<?php
include_once "./Database/connection.php";

///////////DELETING PRODUCTS////////////////

// IF statement for deleting a product from sql database!

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    // Retrieve product ID to be deleted
    $product_id = $_POST['product_id'];

    // Delete product from the database
    $sql = "DELETE FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {

        // product deleted successfully
        echo "<script>alert('Product deleted successfully');</script>";
    } else {

        // Error deleting product
        echo "<script>alert('Error deleting product');</script>";
    }
}
///////////////////////////////////////////
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

<main>
  <div class="content">
    <h1 class="title">Product Management</h1>
    <div class="aboutHeading">Add or Remove Products</div>
    <div class="row">
      <div class="col-right">
        <a href="#.php" class="adminbutton"><i class='bx bxs-user-account'></i> Add Products</a>
        <a href="#.php" class="addbutton"><i class='bx bx-plus-circle'></i> Add User</a>
  
    </div>
    </div>
    <div class="info-data">
      <div class="card">
        <div class="table-scrollable">
          <table>
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Colour</th>
                <th>Gender</th>
                <th>Category ID</th>
                <th>Stock Level</th>
                <th>Image URL</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $sql = "SELECT * FROM products";

              $result = mysqli_query($conn, $sql);

              // Check ing to see if the products are in the datavase



              if (mysqli_num_rows($result) > 0) {
                  // Output data of each row
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row["product_id"] . "</td>";
                      echo "<td>" . $row["product_name"] . "</td>";
                      echo "<td>" . $row["product_price"] . "</td>";
                      echo "<td>" . $row["product_colour"] . "</td>";
                      echo "<td>" . $row["product_gender"] . "</td>";
                      echo "<td>" . $row["CategoryID"] . "</td>";
                      echo "<td>" . $row["StockLevel"] . "</td>";
                      echo "<td><img src='../product_img/" . $row["ImageURL"] . "' alt='Product Image' width='150' height='150'></td>"; // SHOWS IMAGES
                      
                      echo "<td><form method='post' action=''><input type='hidden' name='product_id' value='" . $row["product_id"] . "'><button type='submit' name='delete_product' class='deletebutton'><i class='bx bx-trash'></i></button></form></td>";

                      echo "</tr>";

                      
                  }

                    

              } else {
                  echo "<tr><td colspan='9'>No products found</td></tr>";
              
                  
              
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

<script src="script.js"></script>

</html>
