<?php
$_ENV = parse_ini_file('.env');
// Connect to the database
$servername = $_ENV["DB_SERVER_NAME"];
$username = $_ENV["DB_USER_NAME"];
$password = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO feedback_form (name, age, email, phone, remarks) VALUES ('$name', '$age', '$email', '$phone', '$remarks')";

    // Execute the query
    if ($conn->query($sql) === true) {
        echo "<script>alert('Logistics details saved successfully!');
         location.replace('./feedback.php');
         </script>";
    } else {
        echo  "$conn->error";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Share your valuable feedback with Mehak Enterprises" />
    <meta name="author" content="Mehak Enterprises" />
    <title>Feedback - Mehak Enterprises</title>
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
                url('https://images.unsplash.com/photo-1560762484-81b38a19b22b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            padding: 6rem 0;
            margin-bottom: 3rem;
            color: white;
            text-align: center;
        }

        .feedback-form {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
        }

        .form-control {
            border-color: #ced4da;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(2, 132, 199, 0.25);
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
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
                    <li class="nav-item"><a class="nav-link active" href="./feedback.php">Feedback</a></li>
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

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Feedback</h1>
            <p class="lead mb-0">Share your thoughts and help us improve</p>
        </div>
    </header>

    <!-- Feedback Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="feedback-form">
                <h2 class="text-center mb-4">We Value Your Feedback</h2>
                <form action="feedback.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" id="age" placeholder="Enter your age"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" id="phone"
                            placeholder="Enter your phone number" required>
                    </div>
                    <div class="mb-4">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="4"
                            placeholder="Enter your remarks" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-submit">Submit Feedback</button>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
</body>

</html>