document.addEventListener('DOMContentLoaded', function () {
    // Add to cart button click event
    document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            addToCart(btn.getAttribute('data-product-id'));
        });
    });

    // Function to add a product to the cart
    function addToCart(productId) {
        // Retrieve existing cart items from local storage
        var cartItems = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the product is already in the cart
        var existingItem = cartItems.find(item => item.productId === productId);

        if (existingItem) {
            // If the product is already in the cart, increase the quantity
            existingItem.quantity++;
        } else {
            // If the product is not in the cart, add it with quantity 1
            cartItems.push({ productId: productId, quantity: 1 });
        }

        // Save the updated cart back to local storage
        localStorage.setItem('cart', JSON.stringify(cartItems));
    }
});