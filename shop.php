<?php
include 'get_products.php'; // Include the PHP file to fetch products
// $products_data = json_decode(json_encode($products), true); // Remove or comment out this line!
$products_data = $products; // Simply assign the $products array directly
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        a.item {
            text-decoration: none;
            color: inherit;
            /* Optional: Ensures link inherits the text color */
        }

        .add-to-cart-btn {
            border: 1px solid #0284c7;
            background-color: #0284c7;
            color: white;
        }

        .add-to-cart-btn:hover {
            border: 1px solid #026cc7;
            background-color: #026cc7;
            color: white;
        }

        .disabled-btn {
            background-color: #0284c796;
            color: white;
            cursor: not-allowed;
        }

        .disabled-btn:hover {
            background-color: #0284c796;
            color: white;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light nav-custom-color">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="./index.html">Amba Associates</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="./index.html">Home</a>
                    </li>
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

    <!-- Header-->
    <header>
        <div style="width: 100%; height: 400px; background-image: url('./assets/Mystery-Chemical.jpg');">
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($products_data as $product) {
                    // Assuming you have 'stock_quantity' column in your products table
                    $out_of_stock = ($product['stock_quantity'] == 0);
                ?>
                    <div class="col mb-5">
                        <a class="item" href="item.php?batch_code=<?php echo $product['batch_code']; ?>">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="assets/img/<?php echo $product['image']; ?>"
                                    alt="<?php echo $product['general_name']; ?>" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">
                                            <?php echo $product['general_name']; ?>
                                        </h5>
                                        <!-- Product price-->
                                        ₹
                                        <?php echo $product['sp']; ?>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <?php if ($out_of_stock): ?>
                                            <div class="badge bg-danger text-white position-absolute"
                                                style="top: 0.5rem; right: 0.5rem">Out of Stock</div>
                                            <a class="btn mt-auto disabled-btn" href="#">Out of Stock</a>
                                        <?php else: ?>
                                            <button class="btn add-to-cart-btn mt-auto" onclick="addToCart('<?php echo $product['batch_code']; ?>')">Add to Cart</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 nav-custom-color">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>