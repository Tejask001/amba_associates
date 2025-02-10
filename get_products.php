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

// Modified SQL query to JOIN products and stock tables
$sql = "SELECT
            p.batch_code,
            p.general_name,
            p.sp,
            p.image,
            COALESCE(s.quantity, 0) AS stock_quantity -- Get stock quantity, default to 0 if no stock record
        FROM
            product p
        LEFT JOIN
            stock s ON p.batch_code = s.batch_code"; // Assuming 'batch_code' is the joining column

$result = $conn->query($sql);

$products = []; // Array to store product data

if ($result->num_rows > 0) {
    // Fetch data and store in the $products array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
