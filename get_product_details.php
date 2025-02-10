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

$batch_code = $_GET['batch_code']; // Make sure to sanitize user input in real application

$sql = "SELECT * FROM product WHERE batch_code = '$batch_code'"; // Select all columns including image
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc(); // Fetch single product details
} else {
    $product = null; // Product not found
}

$conn->close();
