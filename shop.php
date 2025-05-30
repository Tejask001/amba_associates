<?php
include 'get_products.php';
$products_data = $products;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop - Mehak Enterprises</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* --- Custom Styles --- */
        :root {
            --primary-color: #0284c7;
            /* Define primary color as a CSS variable */
        }

        a.item {
            text-decoration: none;
            color: inherit;
        }

        .btn-primary {
            /* Use Bootstrap's btn-primary class */
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #026cc7;
            /* Darker shade on hover */
            border-color: #026cc7;
        }

        .btn-outline-primary {
            /* Outline variant */
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: #0284c7;
        }

        .disabled-btn {
            background-color: #0284c796;
            color: white;
            cursor: not-allowed;
            border-color: #0284c796;
            /* Add border color for consistency */
        }

        .disabled-btn:hover {
            /* Consistent hover, even if disabled */
            background-color: #0284c796;
            border-color: #0284c796;
            color: white;
            cursor: not-allowed;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            /* Subtle shadow */
            transition: transform 0.2s ease-in-out;
            /* Smooth transform on hover */
            border: none;
            /* Remove default border */
            overflow: hidden;
            /* Hide overflowing content */
        }

        .card:hover {
            transform: translateY(-5px);
            /* Lift card slightly on hover */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            /* Stronger shadow on hover */
        }

        .card-img-top {
            transition: transform 0.3s ease-in-out;
            width: 100%;
            height: 150px;
            object-fit: contain;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
            /* Slightly zoom image on hover */
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            /* Larger title */
            font-weight: bold;
            /* Bold title */
            margin-bottom: 0.5rem;
            /* Space below title */
            overflow: hidden;
            /* Hide overflowing text */
            text-overflow: ellipsis;
            /* Add ellipsis for long titles */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Limit to 2 lines */
            -webkit-box-orient: vertical;
        }

        .card-text {
            margin-bottom: 1rem;
            font-size: 1rem;
        }


        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            /* Very light background */
            border-top: 1px solid rgba(0, 0, 0, 0.125);
            /* Subtle border */
        }

        .view-details-link {
            margin-top: auto;
            /* Push to the bottom */
            text-align: center;
            /* Center the link */
        }
    </style>
</head>

<body>
    <!-- Navigation (Same as before) -->
    <nav class="navbar navbar-expand-lg navbar-light nav-custom-color">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="./index.html">Mehak Enterprises</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="./index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link active " href="./shop.php">Shop</a></li>
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

    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($products_data as $product): ?>
                    <?php $out_of_stock = ($product['stock_quantity'] == 0); ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Image -->
                            <img class="card-img-top" src="CRM/assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['general_name']; ?>" />

                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- Product Name -->
                                    <h5 class="card-title"><?php echo $product['general_name']; ?></h5>
                                    <p class="card-text">₹ <?php echo $product['sp']; ?></p>
                                    <!-- View Details Link -->
                                    <div class="view-details-link">
                                        <a href="item.php?batch_code=<?php echo $product['batch_code']; ?>" class="btn btn-outline-primary">View Details</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer">
                                <div class="text-center">
                                    <?php if ($out_of_stock): ?>
                                        <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem;">Out of Stock</div>
                                        <a class="btn disabled-btn" href="#">Out of Stock</a>
                                    <?php else: ?>
                                        <button class="btn btn-primary" onclick="addToCart('<?php echo $product['batch_code']; ?>'); return false;">Add to Cart</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer (Same as before) -->
    <footer class="py-5 nav-custom-color" style="
    position: absolute;
    width: 100%;
    bottom: 0;
">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © Your Website 2023</p>
        </div>

        <!-- Bootstrap core JS and your custom script (Same as before) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                updateCartBadge();
            });
        </script>
</body>

</html>