<?php
include 'get_products.php';
$products_data = $products;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Shop premium chemical products at Mehak Enterprises - Your trusted chemical trading partner" />
    <meta name="author" content="Mehak Enterprises" />
    <title>Shop - Mehak Enterprises</title>
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
                url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 6rem 0;
            margin-bottom: 3rem;
            color: white;
            text-align: center;
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .card-img-wrapper {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--secondary-color);
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .stock-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-shop {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .btn-shop.btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-shop.btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-shop.disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            opacity: 0.7;
            cursor: not-allowed;
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

        .card-footer {
            background-color: transparent;
            border-top: none;
            padding: 1rem 1.5rem;
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
                        <span class="badge bg-primary ms-2 cart-count">0</span>
                    </button>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Our Products</h1>
            <p class="lead mb-0">Discover our premium range of chemical products</p>
        </div>
    </header>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <?php foreach ($products_data as $product): ?>
                    <?php $out_of_stock = ($product['stock_quantity'] == 0); ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card">
                            <?php if ($out_of_stock): ?>
                                <div class="stock-badge bg-danger">Out of Stock</div>
                            <?php endif; ?>
                            <div class="card-img-wrapper">
                                <img class="card-img-top"
                                    src="CRM/assets/images/<?php echo $product['image']; ?>"
                                    alt="<?php echo $product['general_name']; ?>" />
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $product['general_name']; ?></h5>
                                <div class="price">₹<?php echo number_format($product['sp'], 2); ?></div>
                                <a href="item.php?batch_code=<?php echo $product['batch_code']; ?>"
                                    class="btn btn-shop btn-outline-primary mb-3">View Details</a>
                            </div>
                            <div class="card-footer text-center">
                                <?php if ($out_of_stock): ?>
                                    <button class="btn btn-shop disabled w-100" disabled>Out of Stock</button>
                                <?php else: ?>
                                    <button class="btn btn-shop btn-primary w-100"
                                        onclick="addToCart('<?php echo $product['batch_code']; ?>')">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
        });
    </script>
</body>

</html>