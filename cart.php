<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shopping Cart - Mehak Enterprises</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .cart-item-image {
            max-width: 80px;
            height: 80px;
            object-fit: scale-down;
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light nav-custom-color">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="./index.html">Mehak Enterprises</a>
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
                <form class="d-flex" action="cart.php"> <!-- Link Cart button to cart.php -->
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill cart-count">0</span> <!-- Cart count badge -->
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Cart section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h1>Shopping Cart</h1>
            <div class="cart-items">
                <!-- Cart items will be dynamically added here by JavaScript -->
                <p id="empty-cart-message">Your cart is empty.</p>
                <table class="table" id="cart-table" style="display:none;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Tax Percent</th>
                            <th>Quantity</th>
                            <th>Tax Amount</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </th>
                    <tbody id="cart-body">
                        <!-- Cart items will be appended here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td id="cart-total">₹0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 nav-custom-color" style="position: absolute;
    bottom: 0;
    width: 100%;">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script> <!-- Make sure your scripts.js is linked -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadCart(); // Load cart items when the page loads
            updateCartBadge(); // Update cart badge on page load
        });
    </script>
</body>

</html>