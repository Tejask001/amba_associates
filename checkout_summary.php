<?php
session_start();

// Check if delivery details exist
if (!isset($_SESSION['delivery_id']) || !isset($_SESSION['delivery_data'])) {
    header('Location: delivery_details.php'); // Changed from delivery.php to delivery_details.php as per context
    exit();
}

$_ENV = parse_ini_file('.env');
// Connect to the database
$servername = $_ENV["DB_SERVER_NAME"];
$username = $_ENV["DB_USER_NAME"];
$password = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];

$deliveryDetails = null; // Initialize
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get delivery details from database (using $_SESSION['delivery_id'])
    $stmt = $pdo->prepare("SELECT * FROM delivery_details WHERE id = ?");
    $stmt->execute([$_SESSION['delivery_id']]);
    $deliveryDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$deliveryDetails) {
        // Fallback or error if delivery details not found for the ID
        // This could happen if the DB record was deleted after session was set
        // For now, we'll proceed, but delivery section might show errors or be empty
        // Consider redirecting or showing an error message
        // For this example, we'll let it show empty fields for delivery if $deliveryDetails is false
        error_log("Delivery details not found for ID: " . $_SESSION['delivery_id']);
        // To prevent errors later, ensure $deliveryDetails is an array with expected keys, or handle its absence
        $deliveryDetails = $_SESSION['delivery_data']; // Use session data as a fallback if DB fetch fails
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Note: $cartItems and $cartTotal from PHP session are not directly used for display by the JS below.
// The JS reads from localStorage and recalculates totals.
// These PHP variables could be used as an initial estimate or for server-side validation if needed.
// $phpCartItems = $_SESSION['cart_items'] ?? [];
// $phpCartTotal = $_SESSION['cart_total'] ?? 0;

$shippingCost = 250; // Fixed shipping cost
// $phpGrandTotal = $phpCartTotal + $shippingCost; // JS will calculate the accurate grand total
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

        /* Removed .order-item styles as we'll use a table */

        .item-image {
            width: 60px;
            /* Adjusted for table view */
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

        .table th,
        .table td {
            vertical-align: middle;
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

                        <div id="order-items-container">
                            <!-- Order items table will be loaded here by JavaScript -->
                            <div class="text-center py-4" id="order-items-loader">
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
                    <div class="summary-card delivery-info mb-4">
                        <h4 class="mb-3">
                            <i class="bi bi-truck me-2"></i>
                            Delivery Information
                        </h4>
                        <?php if ($deliveryDetails): ?>
                            <div class="mb-3">
                                <strong>Deliver to:</strong><br>
                                <?php echo htmlspecialchars($deliveryDetails['full_name'] ?? 'N/A'); ?><br>
                                <?php echo htmlspecialchars($deliveryDetails['phone'] ?? 'N/A'); ?><br>
                                <?php echo htmlspecialchars($deliveryDetails['email'] ?? 'N/A'); ?>
                            </div>

                            <div class="mb-3">
                                <strong>Address:</strong><br>
                                <?php echo htmlspecialchars($deliveryDetails['address_line1'] ?? 'N/A'); ?><br>
                                <?php if (!empty($deliveryDetails['address_line2'])): ?>
                                    <?php echo htmlspecialchars($deliveryDetails['address_line2']); ?><br>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($deliveryDetails['city'] ?? 'N/A'); ?>,
                                <?php echo htmlspecialchars($deliveryDetails['state'] ?? 'N/A'); ?> -
                                <?php echo htmlspecialchars($deliveryDetails['pincode'] ?? 'N/A'); ?>
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
                        <?php else: ?>
                            <p class="text-danger">Could not load delivery details. Please go back and re-enter.</p>
                            <a href="delivery_details.php" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i>
                                Edit Details
                            </a>
                        <?php endif; ?>
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
                            <strong id="grand-total">₹<?php echo number_format($shippingCost, 2); // Initial display 
                                                        ?></strong>
                        </div>

                        <div class="d-grid gap-2">
                            <button id="proceed-to-payment-btn" class="btn btn-success btn-lg" onclick="proceedToPayment()">
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
            <p class="m-0 text-center text-white">Copyright © Mehak Enterprises 2023</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS (Assuming updateCartBadge is in here) -->
    <script src="js/scripts.js"></script>

    <script>
        const shippingCost = <?php echo $shippingCost; ?>;
        const orderItemsContainer = document.getElementById('order-items-container');
        const orderItemsLoader = document.getElementById('order-items-loader');
        const proceedToPaymentBtn = document.getElementById('proceed-to-payment-btn');


        document.addEventListener('DOMContentLoaded', function() {
            console.log("Checkout Summary DOMContentLoaded. Loading order...");
            loadOrderSummary();
            if (typeof updateCartBadge === 'function') {
                updateCartBadge();
            } else {
                console.warn("updateCartBadge function not found. Ensure js/scripts.js is loaded and contains it.");
            }
        });

        function loadOrderSummary() {
            orderItemsLoader.style.display = 'block'; // Show loader
            orderItemsContainer.innerHTML = ''; // Clear previous content
            orderItemsContainer.appendChild(orderItemsLoader); // Re-add loader
            proceedToPaymentBtn.disabled = true; // Disable payment button until loaded

            let cartItems = []; // This will be the array of {batchCode, quantity} objects
            try {
                const storedCartString = localStorage.getItem('cart');
                console.log("CheckoutSummary: Raw cart string from localStorage:", storedCartString);

                if (storedCartString) {
                    const parsedCartData = JSON.parse(storedCartString);
                    console.log("CheckoutSummary: Parsed cart data from localStorage:", parsedCartData);

                    // Check if the parsed data is an object (like {ABC:1, XYZ:2}) and not an array
                    if (parsedCartData && typeof parsedCartData === 'object' && !Array.isArray(parsedCartData)) {
                        console.log("CheckoutSummary: Cart data is an object. Converting to array format.");
                        for (const batchCode in parsedCartData) {
                            // Ensure it's an own property and not from prototype chain
                            if (Object.prototype.hasOwnProperty.call(parsedCartData, batchCode)) {
                                const quantity = parseInt(parsedCartData[batchCode], 10);
                                if (!isNaN(quantity) && quantity > 0) {
                                    cartItems.push({
                                        batchCode: batchCode,
                                        quantity: quantity
                                    });
                                } else {
                                    console.warn(`CheckoutSummary: Invalid quantity for batchCode ${batchCode}. Skipping.`);
                                }
                            }
                        }
                        console.log("CheckoutSummary: Converted cartItems array:", JSON.parse(JSON.stringify(cartItems))); // Deep copy for logging
                    } else if (Array.isArray(parsedCartData)) {
                        // If it's already an array, use it directly (this is the preferred format)
                        console.log("CheckoutSummary: Cart data is already an array.");
                        cartItems = parsedCartData.filter(item => item && item.batchCode && typeof item.quantity === 'number' && item.quantity > 0);
                        if (cartItems.length !== parsedCartData.length) {
                            console.warn("CheckoutSummary: Some items in the cart array were invalid and have been filtered out.");
                        }
                    } else {
                        console.warn("CheckoutSummary: Cart data from localStorage is not a recognized format (not an object or array). Resetting to empty.", parsedCartData);
                        cartItems = []; // Reset to empty if format is completely unexpected
                    }
                } else {
                    console.log("CheckoutSummary: No cart data found in localStorage.");
                }
            } catch (e) {
                console.error("CheckoutSummary: Error processing cart from localStorage:", e);
                cartItems = []; // Reset to empty on error
            }

            // Now cartItems should be an array of objects, or empty
            console.log("CheckoutSummary: Final cartItems to process:", JSON.parse(JSON.stringify(cartItems)));


            if (cartItems.length === 0) {
                orderItemsLoader.style.display = 'none';
                orderItemsContainer.innerHTML = '<div class="alert alert-info text-center">Your order is empty. Please add items to your cart.</div>';
                updateTotalsDisplay(0, 0); // Update totals to zero
                // No need to enable payment button if cart is empty.
                return;
            }

            const batchCodes = cartItems.map(item => item.batchCode).filter(bc => bc != null && bc.trim() !== "");
            console.log("CheckoutSummary: Batch codes to fetch product details for:", batchCodes);

            if (batchCodes.length === 0) {
                orderItemsLoader.style.display = 'none';
                orderItemsContainer.innerHTML = '<div class="alert alert-warning text-center">Cart items are missing valid batch codes. Cannot load order details.</div>';
                updateTotalsDisplay(0, 0);
                return;
            }

            fetch('get_cart_products.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        batchCodes: batchCodes
                    })
                })
                .then(response => {
                    console.log("CheckoutSummary: Fetch response status:", response.status);
                    if (!response.ok) {
                        return response.text().then(text => { // Get error text from server
                            throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(products => {
                    console.log("CheckoutSummary: Products received from server:", products);
                    orderItemsLoader.style.display = 'none';
                    if (!Array.isArray(products)) {
                        console.error("CheckoutSummary: Products data from server is not an array:", products);
                        orderItemsContainer.innerHTML = '<div class="alert alert-danger">Error: Invalid product data format received from server.</div>';
                        updateTotalsDisplay(0, 0);
                        return;
                    }
                    displayOrderItemsAsTable(cartItems, products); // This function expects cartItems as an array
                    calculateAndStoreTotals(cartItems, products); // This function also expects cartItems as an array
                    proceedToPaymentBtn.disabled = false; // Enable payment button
                })
                .catch(error => {
                    console.error('CheckoutSummary: Error fetching product details:', error);
                    orderItemsLoader.style.display = 'none';
                    orderItemsContainer.innerHTML = `<div class="alert alert-danger">Error loading order details: ${error.message}. Please try refreshing or contact support.</div>`;
                    updateTotalsDisplay(0, 0);
                });
        }

        function displayOrderItemsAsTable(cartItems, serverProducts) {
            let tableHtml = `
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 10%;">Item</th>
                            <th scope="col" style="width: 35%;">Product Details</th>
                            <th scope="col" class="text-center" style="width: 15%;">Unit Price</th>
                            <th scope="col" class="text-center" style="width: 10%;">Qty</th>
                            <th scope="col" class="text-center" style="width: 15%;">Tax</th>
                            <th scope="col" class="text-end" style="width: 15%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            let itemsRendered = 0;

            cartItems.forEach(cartItem => {
                const product = serverProducts.find(p => p.batch_code === cartItem.batchCode);
                if (product) {
                    itemsRendered++;
                    const unitPrice = parseFloat(product.sp);
                    const quantity = parseInt(cartItem.quantity, 10);
                    const taxPercent = parseFloat(product.tax_percent);

                    const itemSubtotal = unitPrice * quantity;
                    const taxAmount = (itemSubtotal * taxPercent) / 100;
                    const totalWithTax = itemSubtotal + taxAmount;

                    tableHtml += `
                        <tr>
                            <td>
                                <img src="./CRM/assets/images/${product.image ? product.image : 'placeholder.png'}" alt="${product.general_name}" class="item-image img-fluid">
                            </td>
                            <td>
                                <h6 class="mb-0">${product.general_name}</h6>
                                <small class="text-muted">Batch: ${product.batch_code}</small><br>
                                <small class="text-muted">Tax Rate: ${taxPercent.toFixed(2)}%</small>
                            </td>
                            <td class="text-center">₹${unitPrice.toFixed(2)}</td>
                            <td class="text-center">${quantity}</td>
                            <td class="text-center">₹${taxAmount.toFixed(2)}</td>
                            <td class="text-end"><strong>₹${totalWithTax.toFixed(2)}</strong></td>
                        </tr>
                    `;
                } else {
                    console.warn(`Product with batchCode ${cartItem.batchCode} (Qty: ${cartItem.quantity}) not found in server response. It might be unavailable.`);
                    tableHtml += `
                        <tr>
                            <td colspan="6" class="text-warning">
                                Item with Batch Code: ${cartItem.batchCode} (Quantity: ${cartItem.quantity}) could not be loaded. It may no longer be available.
                            </td>
                        </tr>
                    `;
                }
            });

            if (itemsRendered === 0 && cartItems.length > 0) { // Items were in cart, but none could be matched/loaded from server
                tableHtml += `<tr><td colspan="6" class="text-center alert alert-warning">Could not load details for any items in your order. Please review your cart or contact support.</td></tr>`;
            }
            if (cartItems.length === 0) { // Should be caught by loadOrderSummary, but defensive.
                orderItemsContainer.innerHTML = '<div class="alert alert-info text-center">Your order is empty.</div>';
                return;
            }

            tableHtml += `</tbody></table>`;
            orderItemsContainer.innerHTML = tableHtml;
        }

        function calculateAndStoreTotals(cartItems, serverProducts) {
            let subtotal = 0;
            let totalTax = 0;

            cartItems.forEach(cartItem => {
                const product = serverProducts.find(p => p.batch_code === cartItem.batchCode);
                if (product) {
                    const unitPrice = parseFloat(product.sp);
                    const quantity = parseInt(cartItem.quantity, 10);
                    const taxPercent = parseFloat(product.tax_percent);

                    if (isNaN(unitPrice) || isNaN(quantity) || isNaN(taxPercent)) {
                        console.warn("Invalid data for calculation:", {
                            product,
                            cartItem
                        });
                        return; // skip this item
                    }

                    const itemTotalWithoutTax = unitPrice * quantity;
                    const taxAmountForItem = (itemTotalWithoutTax * taxPercent) / 100;

                    subtotal += itemTotalWithoutTax;
                    totalTax += taxAmountForItem;
                }
            });
            updateTotalsDisplay(subtotal, totalTax);
        }

        function updateTotalsDisplay(subtotal, totalTax) {
            const grandTotal = subtotal + totalTax + shippingCost;

            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('total-tax').textContent = `₹${totalTax.toFixed(2)}`;
            document.getElementById('grand-total').textContent = `₹${grandTotal.toFixed(2)}`;

            // Store totals in sessionStorage for payment processing page
            sessionStorage.setItem('orderTotals', JSON.stringify({
                subtotal: subtotal,
                tax: totalTax,
                shipping: shippingCost,
                grandTotal: grandTotal
            }));
            console.log("Totals calculated and stored in sessionStorage:", {
                subtotal,
                totalTax,
                shippingCost,
                grandTotal
            });
        }


        function proceedToPayment() {
            const totals = JSON.parse(sessionStorage.getItem('orderTotals'));
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart.length === 0 || !totals || totals.grandTotal <= shippingCost) {
                alert("Your order appears to be empty or invalid. Please add items to your cart or refresh the page.");
                return;
            }
            // You can add more validation here if needed
            window.location.href = 'payment.php';
        }

        // If updateCartBadge is not in js/scripts.js, you might need a local version or ensure it's loaded.
        // Example:
        // function updateCartBadge() {
        //     const cart = JSON.parse(localStorage.getItem('cart')) || [];
        //     let count = 0;
        //     cart.forEach(item => {
        //         count += parseInt(item.quantity) || 0;
        //     });
        //     const cartBadge = document.querySelector('.cart-count');
        //     if (cartBadge) {
        //         cartBadge.textContent = count;
        //     }
        // }
    </script>
</body>

</html>