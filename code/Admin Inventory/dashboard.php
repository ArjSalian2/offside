<?php
// Start the session
include_once "./Database/connection.php";

$totalRevenue = 0;
$productRevenue = [];

// Function to fetch monthly revenue from the database
function fetchMonthlyRevenue()
{
    global $conn; // Assuming $conn is your database connection object

    // Initialize an array to store revenue for each month
    $revenue = array_fill(0, 12, 0); // Initialize with 0 for each month (January to December)

    // Query to fetch orders data for the past year
    $sql = "SELECT * FROM orders WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Loop through each order
        while ($order = $result->fetch_assoc()) {
            // Extract month from order date
            $orderDate = date_create($order['OrderDate']);
            $month = intval(date_format($orderDate, 'm')) - 1; // Subtract 1 to match array index

            // Retrieve order total
            $orderId = $order['OrderID'];
            $sqlItems = "SELECT SUM(Price) AS orderTotal FROM order_items WHERE OrderID = $orderId";
            $resultItems = $conn->query($sqlItems);
            $orderTotal = $resultItems->fetch_assoc()['orderTotal'];

            // Add order total to revenue for the corresponding month
            $revenue[$month] += $orderTotal;
        }
    }

    return $revenue;
}

// Fetch monthly revenue data
$revenue = fetchMonthlyRevenue();

// Retrieve total number of pending orders
$sqlPendingOrders = "SELECT COUNT(*) AS TotalPendingOrders FROM orders WHERE OrderStatus = 1"; // Assuming 1 represents "Pending"
$resultPendingOrders = $conn->query($sqlPendingOrders);
$totalPendingOrders = $resultPendingOrders->fetch_assoc()['TotalPendingOrders'];

// Query to get the count of new users created in the last 30 days
$thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
$sqlNewUsers = "SELECT COUNT(*) AS new_users FROM users WHERE Created >= '$thirtyDaysAgo'";
$resultNewUsers = $conn->query($sqlNewUsers);
$newUsersCount = 0;

if ($resultNewUsers && $resultNewUsers->num_rows > 0) {
    $newUsersRow = $resultNewUsers->fetch_assoc();
    $newUsersCount = $newUsersRow['new_users'];
}

// Fetch product data from the database
$sqlProducts = "SELECT * FROM products";
$resultProducts = $conn->query($sqlProducts);

// Initialize an empty array to store products
$products = [];

// Check if there are any products returned from the query
if ($resultProducts->num_rows > 0) {
    // Loop through each row to fetch product details
    while ($row = $resultProducts->fetch_assoc()) {
        // Store product details in an array
        $product = [
          'name' => htmlspecialchars($row['product_name']), 
          'image' => $row['ImageURL'],
          'category' => htmlspecialchars($row['product_category']), 
          'stock' => intval($row['StockLevel']), 
        ];
        // Add the product to the products array
        $products[] = $product;
    }

}

foreach ($products as $product) {
  $totalRevenue += $product['stock']; // Add each product's stock to the total
}

$sqlOrders = "SELECT o.OrderID, GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products, SUM(oi.price) AS total_price, o.OrderStatus
              FROM orders o
              INNER JOIN order_items oi ON o.OrderID = oi.OrderID
              INNER JOIN products p ON oi.productID = p.product_id
              GROUP BY o.OrderID, o.OrderStatus";

$resultOrders = $conn->query($sqlOrders);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/alert.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <title>Admin Inventory Management</title>

  <style>

    .p{
      margin-bottom: 0;
    }

    .logout{
      margin-bottom: 0;
    }

    .title{
      margin-bottom: 30px;
    }

    .row{
      --bs-gutter-x: 1.5rem;
      --bs-gutter-y: 0;
      display: flex;
      flex-wrap: wrap;
      margin-top: calc(-1* var(--bs-gutter-y));
      margin-right: calc(-.5* var(--bs-gutter-x));
      margin-left: calc(-.5* var(--bs-gutter-x));
    }

    .card{
      display: flex;
      align-items: center;
      box-shadow: 0px 12px 24px -4px rgba(145, 158, 171, 0.12), 0px 0px 2px 0px rgba(145, 158, 171, 0.2);
      margin-bottom: 30px;
    }

    .car-title{
      Margin: 10px;
    }

    .card-body{
      align-items: center;
      background: #fff;
      padding: 30px 20px;
      border-radius: 7px;
    }

    .dollar-icon{
      margin-right: 15px;
    }

    .card-title{
      font-weight: 600;
    }

    .card-text{
      font-weight: 700;
    }

    .card-style{
      background: #fff;
      box-sizing: border-box;
      padding: 25px 30px;
      position: relative;
      box-shadow: 0px 12px 24px -4px rgba(145, 158, 171, 0.12), 0px 0px 2px 0px rgba(145, 158, 171, 0.2);
      border-radius: 7px;
    }

    .Chart2{
      width: 869px;
      height: 400px;
      margin-left: -45px;
      display: block;
      box-sizing: border-box;
    }

    .product{
      display: flex;
    }

    .product-details{
      display: flex;
    }

   /* Table styles */
   .top-selling-table {
    width: 5%; /* Adjust the width as needed */
    max-width: 200px; /* Set a maximum width to prevent excessive width */
    border: 1px solid #ddd; /* Add border to the table */
    border-collapse: collapse;
    margin-top: 20px;
    overflow-x: auto; /* Enable horizontal scrolling if content exceeds the width */
    table-layout: fixed;
}

.top-selling-table th {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.top-selling-table td {
    padding: 8px;
    text-align: left;
}

/* Adjust the width of the product column */
.top-selling-table th:nth-child(1),
.top-selling-table td:nth-child(1) {
    width: 1%; /* Adjust width as needed */
    max-width: 50px; /* Set max-width to prevent excessive width */
    overflow-x: hidden; /* Hide overflow content */
    text-overflow: ellipsis; /* Display ellipsis for overflow content */
    white-space: nowrap; /* Prevent text wrapping */
}

/* Adjust the width of the category column */
.top-selling-table th:nth-child(2),
.top-selling-table td:nth-child(2) {
    width: 1%; /* Adjust width as needed */
    /* max-width: 50px; Set max-width to prevent excessive width */
    overflow: hidden; /* Hide overflow content */
    text-overflow: ellipsis; /* Display ellipsis for overflow content */
    white-space: nowrap; /* Prevent text wrapping */
}

/* Adjust the width of the stock level column */
.top-selling-table th:nth-child(3),
.top-selling-table td:nth-child(3) {
    width: 1%; 
    max-width: 100px; 
    overflow: hidden; 
    text-overflow: ellipsis;
    white-space: nowrap; 
}




.product {
    display: flex;
    align-items: center;
}

.image {
    margin-right: 10px;
}

.col-lg-8 {
  width: 100%;
  margin-left: 0;
}


  </style>

</head>

<body>

  <?php
include "./sidebar.php";
include "./nav.php";
?>


  <main>
    <div class="content">
      <h1 class="title">Dashboard</h1>
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <!-- Total Revenue Box -->
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <h5 class="card-title">Total Revenue</h5>
                  <h3 class="card-text">£<?=array_sum($revenue)?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <button onclick="showToast('warning', 'Sample Product')">Show Warning Toast</button> -->
        <div id="toast-container"></div>
        <script src="scripts.js"></script>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <!-- Total Revenue Box -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Stock Level</h5>
              <h3 class="card-text"><?=$totalRevenue?></h3>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6">
          <!-- Total Revenue Box -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pending Orders</h5>
              <h3 class="card-text"><?=$totalPendingOrders?></h3>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6">
          <!-- Total Revenue Box -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">New Users</h5>
              <h3 class="card-text"><?=$newUsersCount?></h3>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-lg-5">
          <div class="card-style mb-30">
              <div class="title d-flex flex-wrap align-items-center justify-content-between">
                  <div class="left">
                      <h6 class="text-medium mb-30">Sales/Revenue</h6>
                  </div>
              </div>
              <!-- End Title -->
              <div class="chart" style="width: 100%; max-width: 400px;">
                  <canvas id="Chart2" style="width: 100%; height: 400px;"></canvas>
              </div>
              <!-- End Chart -->
          </div>
          </div>

          <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-30">Product List</h6>
                    </div>
                </div>
                <!-- End Title -->
                <div class="table-responsive" style="max-height: 400px;  overflow-y: auto;" >
                    <table class="table top-selling-table">
                      <thead>
                        <tr>
                          <th>
                              <h6 class="text-sm text-medium">Product</h6>
                          </th>
                          <!-- <th>
                              <h6 class="text-sm text-medium">Category</h6>
                          </th> -->
                          <th>
                              <h6 class="text-sm text-medium">Stock Level</h6>
                          </th>
                          <th>
                              <h6 class="text-sm text-medium">Stock Status</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
$notificationCount = 0;
foreach ($products as $product):
    if ($notificationCount < 5) { // Limit to 5 notifications
?>
        <tr>
            <td class="product-name">
                <div class="product">
                    <div class="image">
                        <img src="../product_img/<?php echo $product['image']; ?>" alt="" style="height: 50px; width: 50px;" />
                    </div>
                    <div class="product-details">
                        <p class="text-sm"><?php echo $product['name']; ?></p>
                    </div>
                </div>
            </td>
            <!-- <td class="product-category">
                <p class="text-sm"> -->
                  <?php 
                  // echo $product['category']; 
                  ?>
                <!-- </p>
            </td> -->
            <td class="stock-level">
                <p class="text-sm"><?php echo $product['stock']; ?></p>
            </td>
            <td class="product-category">
                <p class="text-sm">
                    <?php
                    $stock = $product['stock'];
                    if ($stock > 0) {
                        echo "In Stock";
                        // echo $product['stock'];
                    } else if($stock == 0) {
                        echo "Out of Stock";
                        // echo $product['stock'];
                        // Automatically trigger the warning toast
                        echo "<script>showToast('warning', '" . $product['name'] . "');</script>";
                        $notificationCount++; // Increment notification count
                    }
                    ?>
                </p>
            </td>
        </tr>
        <?php 
            } // End if
        endforeach; 
        ?>


                      </tbody>
                    </table>
                </div>
              </div>
            </div>

            <div class="col-lg-8 offset-lg-2">
                    <div class="cart shadow-lg rounded p-5 my-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1>My orders</h1>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Products</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Order Status</th>
                                    </tr>
                                </thead>
                                <tbody id="orderDetailsBody">
                                    <!-- Table rows will be dynamically added here -->
                                    <?php
// Check if there are any orders returned from the query
if ($resultOrders->num_rows > 0) {
    // Loop through each order
    while ($order = $resultOrders->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . $order['OrderID'] . "</th>";
        echo "<td>" . $order['products'] . "</td>";
        echo "<td>$" . $order['total_price'] . "</td>";
        echo "<td>";
        if ($order['OrderStatus'] == 1) {
          echo "<span class='badge bg-primary'>Processing</span>";
        } else {
          echo "<span class='badge bg-secondary'>Way to Shipping</span>";
        }
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No orders found.</td></tr>";
}
?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>


    </div>
  </main>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    // Function to update the chart based on the selected interval
    function updateChart(interval) {
        // Clear previous chart if it exists
        if(window.chart !== undefined)
            window.chart.destroy();

        // Initialize variables for labels and data
        var labels = [];
        var data = [];

        // Assuming you have $revenue array defined in your PHP code
        var revenue = <?=json_encode($revenue)?>;

        // Labels for months
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ];

        // Check the interval
        if (interval === 'yearly') {
            // Rotate the months array so that the current month is on the far right
            var currentMonthIndex = new Date().getMonth();
            labels = months.slice(currentMonthIndex).concat(months.slice(0, currentMonthIndex)).reverse();

            // Assuming you want to show monthly data
            data = revenue.slice(currentMonthIndex).concat(revenue.slice(0, currentMonthIndex)).reverse();
        }

        // Initialize the chart
        var ctx = document.getElementById('Chart2').getContext('2d');
        window.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    // Call the updateChart function initially with the default interval
    updateChart('yearly');

    // Listen for changes in the interval selection and update the chart accordingly
    document.getElementById('chartInterval').addEventListener('change', function() {
        var selectedInterval = this.value;
        updateChart(selectedInterval);
    });


    document.addEventListener('DOMContentLoaded', () => {
            // Retrieve cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            // Sum of total price for all products
            let totalOrderPrice = 0;

            // Concatenated string of product names
            let productNames = '';

            // Iterate over each cart item and fetch product details
            cartItems.forEach((cartItem, index) => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `get_product_details.php?productId=${cartItem.productId}`, true);
                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const product = JSON.parse(xhr.responseText);

                        // Add product price to the total
                        totalOrderPrice += product.product_price * cartItem.quantity;

                        // Concatenate product names with a comma
                        productNames += product.product_name;

                        // Add a comma if it's not the last product
                        if (index < cartItems.length - 1) {
                            productNames += ', ';
                        }

                        // If it's the last product, update the table
                        if (index === cartItems.length - 1) {
                            displayOrderDetails(productNames, totalOrderPrice);
                        }
                    }
                };
                xhr.send();
            });
        });

        // Function to display order details in the table
        const displayOrderDetails = (productNames, totalOrderPrice) => {
            const orderDetailsBody = document.getElementById('orderDetailsBody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
            <th scope="row">${orderDetailsBody.children.length + 1}</th>
            <td>${productNames}</td>
            <td>$${totalOrderPrice.toFixed(2)}</td>
            <td>
                <span class="badge bg-primary">Processing</span> <br>
            </td>
            <td>
                <span class="badge bg-secondary">Way to Shipping</span> <br>
            </td>
        `;

            orderDetailsBody.appendChild(newRow);
        };


</script>



</body>

<script src="script.js"></script>


</html>