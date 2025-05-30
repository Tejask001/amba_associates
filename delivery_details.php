<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Delivery Details - Mehak Enterprises</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .delivery-form {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-floating {
            margin-bottom: 1rem;
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

        .required-field {
            color: #dc3545;
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
        }

        .section-title {
            color: #0d6efd;
            margin-bottom: 1rem;
            font-weight: 600;
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

    <!-- Delivery Details Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <!-- Progress Steps -->
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">1</div>
                    <span>Cart</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <span>Delivery Details</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <span>Order Summary</span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="delivery-form">
                        <h2 class="text-center mb-4">
                            <i class="bi bi-truck me-2"></i>
                            Delivery Details
                        </h2>

                        <form id="delivery-form" action="delivery_database_handler.php" method="POST">
                            <!-- Personal Information Section -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="bi bi-person-fill me-2"></i>
                                    Personal Information
                                </h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="fullName" name="fullName"
                                                placeholder="Full Name" required>
                                            <label for="fullName">Full Name <span class="required-field">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" required>
                                            <label for="email">Email Address <span class="required-field">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="Phone Number" pattern="[0-9]{10}" required>
                                    <label for="phone">Phone Number <span class="required-field">*</span></label>
                                    <div class="form-text">Enter 10-digit mobile number</div>
                                </div>
                            </div>

                            <!-- Delivery Address Section -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="bi bi-geo-alt-fill me-2"></i>
                                    Delivery Address
                                </h4>

                                <div class="form-floating">
                                    <input type="text" class="form-control" id="addressLine1" name="addressLine1"
                                        placeholder="Address Line 1" required>
                                    <label for="addressLine1">Address Line 1 <span class="required-field">*</span></label>
                                </div>

                                <div class="form-floating">
                                    <input type="text" class="form-control" id="addressLine2" name="addressLine2"
                                        placeholder="Address Line 2 (Optional)">
                                    <label for="addressLine2">Address Line 2 (Optional)</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="City" required>
                                            <label for="city">City <span class="required-field">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="state" name="state" required>
                                                <option value="">Select State</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Sikkim">Sikkim</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Tripura">Tripura</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="Uttarakhand">Uttarakhand</option>
                                                <option value="West Bengal">West Bengal</option>
                                            </select>
                                            <label for="state">State <span class="required-field">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <input type="text" class="form-control" id="pincode" name="pincode"
                                        placeholder="Pincode" pattern="[0-9]{6}" required>
                                    <label for="pincode">Pincode <span class="required-field">*</span></label>
                                    <div class="form-text">Enter 6-digit pincode</div>
                                </div>
                            </div>

                            <!-- Delivery Instructions Section -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Delivery Instructions (Optional)
                                </h4>

                                <div class="form-floating">
                                    <textarea class="form-control" id="deliveryInstructions" name="deliveryInstructions"
                                        style="height: 100px" placeholder="Special delivery instructions"></textarea>
                                    <label for="deliveryInstructions">Special delivery instructions</label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="cart.php" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Back to Cart
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Continue to Payment
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge(); // Update cart badge on page load

            // Form validation
            const form = document.getElementById('delivery-form');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.slice(0, 10);
                }
                e.target.value = value;
            });

            // Pincode formatting
            const pincodeInput = document.getElementById('pincode');
            pincodeInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 6) {
                    value = value.slice(0, 6);
                }
                e.target.value = value;
            });
        });
    </script>
</body>

</html>