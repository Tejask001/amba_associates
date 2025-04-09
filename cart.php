<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="View and manage your shopping cart at Mehak Enterprises" />
    <meta name="author" content="Mehak Enterprises" />
    <title>Shopping Cart - Mehak Enterprises</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #0284c7;
            --secondary-color: #0369a1;
        }

        body {
            background-color: #f8f9fa;
        }

        .nav-custom-color {
            background-color: var(--primary-color);
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .page-header {
            background: linear-gradient(rgba(2, 132, 199, 0.8), rgba(3, 105, 161, 0.9)),
                url('https://images.unsplash.com/photo-1607628194294-2bb10e98cf9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            padding: 6rem 0;
            margin-bottom: 3rem;
            color: white;
            text-align: center;
        }

        .cart-table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .cart-table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            text-align: left;
        }

        .cart-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cart-item-image {
            max-width: 80px;
            max-height: 80px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .cart-total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .cart-total {
            color: var(--primary-color);
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        #empty-cart-message {
            text-align: center;
            padding: 2rem;
            font-style: italic;
            color: #6c757d;
        }

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .cart-btn {
            background-color: white;
            color: var(--primary-color);
            border: none;
            transition: all 0.3s ease;
        }

        .cart-btn:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg nav-custom-color fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="./index.html">
                <i class="bi bi-building fs-3 me-2"></i>
                <strong>MEHAK ENTERPRISES</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="./index.html">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="./shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="./feedback.php">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="./CRM/index.php">CRM</a></li>
                </ul>
                <a href="./cart.php">
                    <button class="cart-btn btn rounded-pill px-4 py-2 d-flex align-items-center">
                        <i class="bi bi-cart3 me-2"></i>
                        Cart
                        <span class="badge bg-primary ms-2 cart-count">0</span>
                    </button>
                </a>
            </div>
        </div>
    </nav>
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Shopping Cart</h1>
            <p class="lead mb-0">Review and manage items in your cart</p>
        </div>
    </header>

    <!-- Cart section-->
    <section class="py-5">
        <div class="container">
            <div class="cart-items">
                <!-- Cart items will be dynamically added here by JavaScript -->
                <p id="empty-cart-message">Your cart is empty.</p>
                <table class="table cart-table" id="cart-table" style="display:none;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <!-- Cart items will be appended here -->
                    </tbody>
                    <tfoot>
                        <tr class="cart-total-row">
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="cart-total">₹0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Contact Us</h5>
                    <p><i class="bi bi-geo-alt me-2"></i>123 Chemical Lane, Industrial Area</p>
                    <p><i class="bi bi-envelope me-2"></i>info@mehakenterprises.com</p>
                    <p><i class="bi bi-telephone me-2"></i>+91 123 456 7890</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="mb-0">© 2024 Mehak Enterprises. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script> <!-- Make sure your scripts.js is linked -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadCart(); // Load cart items when the page loads
            updateCartBadge(); // Update cart badge on page load
        });

        function loadCart() {
            let cart = localStorage.getItem('cart');
            let cartBody = document.getElementById('cart-body');
            let cartTable = document.getElementById('cart-table');
            let emptyCartMessage = document.getElementById('empty-cart-message');
            let cartTotalElement = document.querySelector('.cart-total'); // Corrected selector
            let total = 0;
            if (cart) {
                cart = JSON.parse(cart);
                if (cart.length > 0) {
                    cartTable.style.display = 'table';
                    emptyCartMessage.style.display = 'none';
                    cartBody.innerHTML = ''; // Clear existing cart items
                    cart.forEach(item => {
                        // Fetch product details using AJAX
                        fetchProductDetails(item.batch_code)
                            .then(product => {
                                if (product) {
                                    let itemTotal = product.sp * item.quantity;
                                    total += itemTotal;
                                    let row = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="CRM/assets/images/${product.image}" class="cart-item-image me-3" alt="${product.general_name}">
                                <div>
                                    <h6 class="mb-0">${product.general_name}</h6>
                                </div>
                            </div>
                        </td>
                        <td>₹${product.sp.toFixed(2)}</td>
                        <td>${item.quantity}</td>
                        <td>₹${itemTotal.toFixed(2)}</td>
                        <td>
                            <button class="btn btn-remove" onclick="removeItem('${item.batch_code}')">Remove</button>
                        </td>
                    </tr>
                    `;
                                    cartBody.innerHTML += row;
                                    cartTotalElement.textContent = `₹${total.toFixed(2)}`; // Update cart total

                                } else {
                                    console.error('Product details not found for batch_code:', item.batch_code);
                                }
                            });
                    });
                } else {
                    cartTable.style.display = 'none';
                    emptyCartMessage.style.display = 'block';
                }
            } else {
                cartTable.style.display = 'none';
                emptyCartMessage.style.display = 'block';
            }
        }

        async function fetchProductDetails(batchCode) {
            try {
                const response = await fetch(`get_product_details_ajax.php?batch_code=${batchCode}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const product = await response.json();
                return product;
            } catch (error) {
                console.error('Error fetching product details:', error);
                return null;
            }
        }

        function removeItem(batchCode) {
            let cart = localStorage.getItem('cart');
            if (cart) {
                cart = JSON.parse(cart);
                cart = cart.filter(item => item.batch_code !== batchCode);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart(); // Reload cart items after removing item
                updateCartBadge(); // Update cart badge after removing item
            }
        }
    </script>
</body>

</html>