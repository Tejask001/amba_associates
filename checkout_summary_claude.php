<?php
session_start();

// Check if delivery details exist
if (!isset($_SESSION['delivery_id']) || !isset($_SESSION['delivery_data'])) {
    header('Location: delivery.php');
    exit();
}

$_ENV = parse_ini_file('.env');
// Connect to the database
$servername = $_ENV["DB_SERVER_NAME"];
$username = $_ENV["DB_USER_NAME"];
$password = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get delivery details from database
    $stmt = $pdo->prepare("SELECT * FROM delivery_details WHERE id = ?");
    $stmt->execute([$_SESSION['delivery_id']]);
    $deliveryDetails = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get cart items from session (assuming they're stored in localStorage and need to be retrieved)
$cartItems = $_SESSION['cart_items'] ?? [];
$cartTotal = $_SESSION['cart_total'] ?? 0;
$shippingCost = 250; // Fixed shipping cost
$grandTotal = $cartTotal + $shippingCost;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Checkout Summary - Mehak Enterprises</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .summary-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .order-item {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: scale-down;
            border-radius: 5px;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 0 1rem;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #6c757d;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-weight: bold;
        }

        .step.active .step-number {
            background-color: #0d6efd;
        }

        .step.completed .step-number {
            background-color: #198754;
        }

        .step-line {
            width: 50px;
            height: 2px;
            background-color: #dee2e6;
            margin: 0 1rem;
        }

        .total-section {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            border-left: 4px solid #198754;
        }

        .delivery-info {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            border-left: 4px solid #0d6efd;
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
                    <li class="nav-item"><a class="nav-link" href="./index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="./shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="./feedback.php">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="./CRM/index.php">CRM</a></li>
                </ul>
                <form class="d-flex" action="cart.php">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill cart-count">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Checkout Summary Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <!-- Progress Steps -->
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">1</div>
                    <span>Cart</span>
                </div>
                <div class="step-line"></div>
                <div class="step completed">
                    <div class="step-number">2</div>
                    <span>Delivery Details</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <span>Order Summary</span>
                </div>
            </div>

            <div class="row">
                <!-- Order Items Section -->
                <div class="col-lg-8">
                    <div class="summary-card">
                        <h3 class="mb-4">
                            <i class="bi bi-bag-check me-2"></i>
                            Order Summary
                        </h3>

                        <div id="order-items">
                            <!-- Order items will be loaded here by JavaScript -->
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading your order...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary and Delivery Details -->
                <div class="col-lg-4">
                    <!-- Delivery Information -->
                    <div class="summary-card delivery-info">
                        <h4 class="mb-3">
                            <i class="bi bi-truck me-2"></i>
                            Delivery Information
                        </h4>

                        <div class="mb-3">
                            <strong>Deliver to:</strong><br>
                            <?php echo htmlspecialchars($deliveryDetails['full_name']); ?><br>
                            <?php echo htmlspecialchars($deliveryDetails['phone']); ?><br>
                            <?php echo htmlspecialchars($deliveryDetails['email']); ?>
                        </div>

                        <div class="mb-3">
                            <strong>Address:</strong><br>
                            <?php echo htmlspecialchars($deliveryDetails['address_line1']); ?><br>
                            <?php if (!empty($deliveryDetails['address_line2'])): ?>
                                <?php echo htmlspecialchars($deliveryDetails['address_line2']); ?><br>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($deliveryDetails['city']); ?>,
                            <?php echo htmlspecialchars($deliveryDetails['state']); ?> -
                            <?php echo htmlspecialchars($deliveryDetails['pincode']); ?>
                        </div>

                        <?php if (!empty($deliveryDetails['delivery_instructions'])): ?>
                            <div class="mb-3">
                                <strong>Special Instructions:</strong><br>
                                <small class="text-muted"><?php echo htmlspecialchars($deliveryDetails['delivery_instructions']); ?></small>
                            </div>
                        <?php endif; ?>

                        <div class="text-end">
                            <a href="delivery_details.php" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i>
                                Edit Details
                            </a>
                        </div>
                    </div>

                    <!-- Order Total -->
                    <div class="summary-card total-section">
                        <h4 class="mb-3">
                            <i class="bi bi-calculator me-2"></i>
                            Order Total
                        </h4>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">₹0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span id="total-tax">₹0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>₹<?php echo number_format($shippingCost, 2); ?></span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <strong>Grand Total:</strong>
                            <strong id="grand-total">₹0.00</strong>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-lg" onclick="proceedToPayment()">
                                <i class="bi bi-credit-card me-2"></i>
                                Proceed to Payment
                            </button>
                            <a href="delivery_details.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Delivery Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 nav-custom-color mt-5">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © Your Website 2023</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script>
        const shippingCost = <?php echo $shippingCost; ?>;

        document.addEventListener('DOMContentLoaded', function() {
            loadOrderSummary();
            updateCartBadge();
        });

        function loadOrderSummary() {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            if (cartItems.length === 0) {
                document.getElementById('order-items').innerHTML =
                    '<div class="text-center py-4"><p>No items in cart</p></div>';
                return;
            }

            // Get batch codes for API call
            const batchCodes = cartItems.map(item => item.batchCode);

            // Fetch product details
            fetch('get_cart_products.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        batchCodes: batchCodes
                    })
                })
                .then(response => response.json())
                .then(products => {
                    displayOrderItems(cartItems, products);
                    calculateTotals(cartItems, products);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('order-items').innerHTML =
                        '<div class="alert alert-danger">Error loading order details</div>';
                });
        }

        function displayOrderItems(cartItems, products) {
            const orderItemsContainer = document.getElementById('order-items');
            let html = '';

            cartItems.forEach(cartItem => {
                const product = products.find(p => p.batch_code === cartItem.batchCode);
                if (product) {
                    const itemTotal = (parseFloat(product.sp) * cartItem.quantity);
                    const taxAmount = (itemTotal * parseFloat(product.tax_percent)) / 100;
                    const totalWithTax = itemTotal + taxAmount;

                    html += `
                        <div class="order-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="./CRM/assets/images/${product.image}" alt="${product.general_name}" class="item-image">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">${product.general_name}</h6>
                                    <small class="text-muted">Batch: ${product.batch_code}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span>₹${parseFloat(product.sp).toFixed(2)}</span>
                                </div>
                                <div class="col-md-1 text-center">
                                    <span>×${cartItem.quantity}</span>
                                </div>
                                <div class="col-md-2 text-center">
                                    <small class="text-muted">Tax: ₹${taxAmount.toFixed(2)}</small>
                                </div>
                                <div class="col-md-1 text-end">
                                    <strong>₹${totalWithTax.toFixed(2)}</strong>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            orderItemsContainer.innerHTML = html;
        }

        function calculateTotals(cartItems, products) {
            let subtotal = 0;
            let totalTax = 0;

            cartItems.forEach(cartItem => {
                const product = products.find(p => p.batch_code === cartItem.batchCode);
                if (product) {
                    const itemTotal = parseFloat(product.sp) * cartItem.quantity;
                    const taxAmount = (itemTotal * parseFloat(product.tax_percent)) / 100;

                    subtotal += itemTotal;
                    totalTax += taxAmount;
                }
            });

            const grandTotal = subtotal + totalTax + shippingCost;

            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('total-tax').textContent = `₹${totalTax.toFixed(2)}`;
            document.getElementById('grand-total').textContent = `₹${grandTotal.toFixed(2)}`;

            // Store totals in session for payment processing
            sessionStorage.setItem('orderTotals', JSON.stringify({
                subtotal: subtotal,
                tax: totalTax,
                shipping: shippingCost,
                grandTotal: grandTotal
            }));
        }

        function proceedToPayment() {
            // You can redirect to payment page or show payment modal
            window.location.href = 'payment.php';
        }
    </script>
</body>

</html>