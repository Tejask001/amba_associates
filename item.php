<?php
include 'get_product_details.php';

if ($product === null) {
    header("Location: shop.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?php echo $product['general_name']; ?> - Premium Chemical Products by Mehak Enterprises" />
    <meta name="author" content="Mehak Enterprises" />
    <title><?php echo $product['general_name']; ?> - Mehak Enterprises</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #0284c7;
            --secondary-color: #0369a1;
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

        .product-image {
            width: 100%;
            height: 400px;
            object-fit: contain;
            border-radius: 8px;
            background-color: #f8f9fa;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .product-details {
            padding: 2rem;
        }

        .sku-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .price {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: bold;
            margin: 1rem 0;
        }

        .quantity-input {
            max-width: 100px;
            text-align: center;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            padding: 0.5rem;
            margin-right: 1rem;
        }

        .add-to-cart-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .chemical-details {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
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

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="./index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="./shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="./feedback.php">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="./CRM/index.php">CRM</a></li>
                </ul>
                <a href="./cart.php">
                    <button class="cart-btn btn rounded-pill px-4 py-2 d-flex align-items-center">
                        <i class="bi bi-cart3 me-2"></i>
                        Cart
                        <span class="badge bg-primary ms-2">0</span>
                    </button>
                </a>
            </div>
        </div>
    </nav>

    <!-- Product section-->
    <section class="py-5 mt-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-md-6">
                    <img class="product-image" src="<?php echo 'CRM/assets/images/' . $product['image']; ?>"
                        alt="<?php echo $product['general_name']; ?>" />
                </div>
                <div class="col-md-6 product-details">
                    <div class="sku-badge">
                        <i class="bi bi-upc me-2"></i>SKU: <?php echo $product['product_code']; ?>
                    </div>
                    <h1 class="display-4 fw-bold mb-4"><?php echo $product['general_name']; ?></h1>
                    <div class="price">
                        ₹<?php echo number_format($product['sp'], 2); ?>
                    </div>
                    <div class="chemical-details">
                        <h4 class="mb-3">Chemical Details</h4>
                        <p class="lead mb-4"><?php echo $product['chemical_name']; ?></p>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <input class="quantity-input form-control"
                            id="inputQuantity"
                            type="number"
                            value="1"
                            min="1" />
                        <button class="add-to-cart-btn"
                            type="button"
                            onclick="addToCart('<?php echo $product['batch_code']; ?>', document.getElementById('inputQuantity').value)">
                            <i class="bi bi-cart-plus-fill me-2"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>