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

        h1 {
            color: #0284c7;
            font-size: 4rem;
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
                    <li class="nav-item"><a class="nav-link" href="./shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link active" href="./feedback.php">Feedback</a></li>
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

    <section class="py-5">
        <div class="container px-4 px-lg-5" style="
        max-width: 600px;
    ">
            <div class="row justify-content-center">
                <h1 class="text-center mb-4">Feedback Form</h1>
                <form action="feedback.php" method="POST">
                    <div class="row">
                        <div class=" col-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" request>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" id="age" placeholder="Enter your age" request>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" request>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" request>
                        </div>

                    </div>

                    <div class="mb-4">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3"
                            placeholder="Enter your remarks" request></textarea>
                    </div>

                    <div class="mb-3" style="display: flex; justify-content: center;">
                        <button type="submit" class="btn"
                            style="width: 100%; height: 40px; background-color: #0284c7; color: white;">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </section>


    <!-- Footer-->
    <footer class="py-5 nav-custom-color">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
</body>

</html>