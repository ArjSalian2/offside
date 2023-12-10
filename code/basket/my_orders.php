<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../homepage-img/logo.png">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="cart-style.css">
    <link rel="stylesheet" href="../nav-styles.css">
    <title>Orders</title>
</head>

<body>


<script>
    searchParam = window.location.search;
    url = '../search.php' + searchParam;
    if (searchParam) {
      window.location.href = url;
    }
    

  </script>

  <header>

    <div class="logo"> <!--Hadeeqah -The logo for top of page-->
      <a href="/offside/index.html">
        <img src="../homepage-img/logo.png" alt="Offside Logo">
      </a>
    </div>

    <div class="top-right-nav">
      <div id="nav1">
        <a href="../about.html">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="../user_files/login.php">Log In</a>
        <a href="../user_files/user_details.php">Account details</a>
        <a href="my_orders.php">My orders</a>
      </div>
    </div>

  </header>

  <!-- nav2-dima -->
  <div id="nav2">
    <div class="nav2-center">
      <a href="../products.php?gender%5B%5D=womens">Women</a>
      <a href="../products.php?gender%5B%5D=mens">Men</a>
      <a href="../products.php?category%5B%5D=accessories">Accessories</a>
    </div>

    <div class="nav2-right">
      <div id="search">
        <form>
          <input  type="text" name="search-term" placeholder="Search">
          <input type="submit" value="Enter">
        </form>
      </div>
      <div id="basket-icon">
        <a href="cart.php"><img src="../homepage-img/basket-icon.png" alt="Basket"></a>
      </div>
    </div>
  </div>

<!--
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse justify-content-end navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav  mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../products.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Current User
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="my_orders.php">My orders</a></li>
                            </ul>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>
    </header>
-->

    <section>
        <div class="container">
            <div class="row">
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
                                        <th scope="col">Shipment Status</th>
                                    </tr>
                                </thead>
                                <tbody id="orderDetailsBody">
                                    <!-- Table rows will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="p-5 text-center bg-dark text-white">
        <h1></h1>
        <p>Copyright &copy; 2022. All rights reserved</p>
    </footer>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script>
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

</html>