// scripts.js

// Function to add an item to the cart
function addToCart(batchCode, quantity = 1) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    if (cart[batchCode]) {
        cart[batchCode] += parseInt(quantity); // Increment quantity if item already exists
    } else {
        cart[batchCode] = parseInt(quantity);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge(); // Update cart badge on adding an item
    alert('Item added to cart!'); // You could use a more sophisticated notification
}

// Function to remove an item from the cart
function removeFromCart(batchCode) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    if (cart[batchCode]) {
        delete cart[batchCode];
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart(); // Reload cart to reflect changes
        updateCartBadge(); // Update cart badge
    }
}

// Function to update the quantity of an item in the cart
function updateCartItemQuantity(batchCode, newQuantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    newQuantity = parseInt(newQuantity);

    if (cart[batchCode]) {
        if (newQuantity > 0) {
            cart[batchCode] = newQuantity;
        } else {
            // Remove the item if the quantity is 0 or less.
            delete cart[batchCode];
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
        updateCartBadge();
    }
}


// Function to update the cart badge count
function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    let totalQuantity = 0;
    for (let batchCode in cart) {
        totalQuantity += cart[batchCode];
    }
    document.querySelector('.cart-count').textContent = totalQuantity;
}

// Function to load cart items and display them on the cart.php page
function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    let cartBody = document.getElementById('cart-body');
    let cartTotal = document.getElementById('cart-total');
    let emptyCartMessage = document.getElementById('empty-cart-message');
    let cartTable = document.getElementById('cart-table');

    if (!cartBody || !cartTotal) { // Check if elements exist (we are on the cart page)
        return;
    }

    cartBody.innerHTML = ''; // Clear previous cart items
    let total = 0;
    let cartItemCount = 0;

    // If cart is empty
    if (Object.keys(cart).length === 0) {
        emptyCartMessage.style.display = 'block';
        cartTable.style.display = 'none';
        return; // Exit the function early
    } else {
        emptyCartMessage.style.display = 'none'; // Hide empty cart message
        cartTable.style.display = 'table'; // Display table
    }

    // Get product details from server
    fetch('get_cart_products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ batchCodes: Object.keys(cart) }) // Send batch codes
    })
        .then(response => response.json())
        .then(products => {

            products.forEach(product => {
                let quantity = cart[product.batch_code];
                let itemTotal = product.sp * quantity;
                total += itemTotal;

                let row = `
                <tr>
                    <td>
                        <img src="./CRM/assets/images/${product.image}" alt="${product.general_name}" class="cart-item-image">
                        ${product.general_name}
                    </td>
                    <td>₹${product.sp}</td>
                    <td>
                        <input type="number" min="1" value="${quantity}" onchange="updateCartItemQuantity('${product.batch_code}', this.value)" style="width: 50px; text-align: center;">
                    </td>
                    <td>₹${itemTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger" onclick="removeFromCart('${product.batch_code}')">Remove</button>
                    </td>
                </tr>`;
                cartBody.innerHTML += row;
                cartItemCount++;
            });
            cartTotal.textContent = '₹' + total.toFixed(2);

        })
        .catch(error => {
            console.error('Error fetching product details:', error);
            // Handle fetch errors (e.g., display an error message)
            emptyCartMessage.textContent = "Error loading cart. Please try again.";
            emptyCartMessage.style.display = 'block';
            cartTable.style.display = 'none';

        });
}



// Initial cart badge update on page load (for all pages)
document.addEventListener('DOMContentLoaded', updateCartBadge);