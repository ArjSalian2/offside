<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="cart-style.css">
    <title></title>
</head>

<body>

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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="cart shadow-lg rounded p-5 my-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1>Cart</h1>
                            <a href="../products.php"><button class="btn-lg btn-defult">Buy more products</button></a>

                        </div>
                        <div id="cart-container"></div>
                        <hr>
                        <div class="text-end">
                            <h3>Total Price: $<span id="total-price"></span></h3>
                            <a href="checkout.php"><button class="btn-lg btn-defult mt-3">Procced Order</button></a>
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
            let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContainer = document.getElementById('cart-container');
            let totalPrice = 0; // Added variable to keep track of total price

            const fetchProductDetails = (productId, quantity) => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `get_product_details.php?productId=${productId}`, true);
                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const product = JSON.parse(xhr.responseText);
                        displayCartItem(product, quantity);
                        console.log(totalPrice);
                        document.getElementById('total-price').innerText = totalPrice;
                    }
                };
                xhr.send();
            };

            const displayCartItem = (product, quantity) => {
                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                // Calculate the total price for the current item
                const itemTotalPrice = product.product_price * parseInt(quantity);
                totalPrice += itemTotalPrice; // Update the total price
                

                cartItem.innerHTML = `
                <div class=" mt-5 d-flex align-items-center justify-content-between">
                            <h4>${product.product_name}</h4>
                            <h5>Price: $${product.product_price}</h5>
                            <h5>Quantity: ${quantity}</h5>
                            <div>
                                <button class="btn btn-success fw-bold quantity-btn" data-action="increase" data-product-id="${product.product_id}">+</button>
                                <button class="btn btn-warning fw-bold quantity-btn" data-action="decrease" data-product-id="${product.product_id}">-</button>
                                <button class="btn btn-danger fw-bold remove-btn" data-product-id="${product.product_id}">X</button>
                            </div>
                        </div>
                `;

                cartContainer.appendChild(cartItem);

                cartItem.querySelectorAll('.quantity-btn').forEach(btn => {
                    btn.addEventListener('click', () => updateQuantity(product.product_id, btn.getAttribute('data-action')));
                });

                cartItem.querySelector('.remove-btn').addEventListener('click', () => removeFromCart(product.product_id));
            };

            const updateQuantity = (productId, action) => {
                const cartItem = cartItems.find(item => parseInt(item.productId) === productId);

                if (cartItem) {
                    if (action === 'increase') {
                        cartItem.quantity++;
                        console.log(cartItem.quantity);
                    } else if (action === 'decrease' && cartItem.quantity > 1) {
                        cartItem.quantity--;
                    }

                    localStorage.setItem('cart', JSON.stringify(cartItems));
                    location.reload();
                }
            };

            const removeFromCart = productId => {
                cartItems = cartItems.filter(item => parseInt(item.productId) !== productId);
                localStorage.setItem('cart', JSON.stringify(cartItems));
                location.reload();
            };

            cartItems.forEach(cartItem => fetchProductDetails(cartItem.productId, cartItem.quantity));
            
        });
    </script>

</body>

</html>