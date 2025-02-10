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

// Get batch codes from POST request (JSON)
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
$batch_codes = $data['batchCodes'];

if (!is_array($batch_codes) || empty($batch_codes)) {
    echo json_encode([]); // Return empty array if batch codes are invalid or empty
    exit;
}

// Prepare IN clause for SQL query
$batch_code_placeholders = implode(',', array_fill(0, count($batch_codes), '?')); // Create placeholders for prepared statement
$types = str_repeat('s', count($batch_codes)); // Type string for batch codes

// SQL query to fetch product details for given batch codes
$sql = "SELECT batch_code, general_name, sp, image FROM product WHERE batch_code IN ($batch_code_placeholders)";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$batch_codes); // Bind parameters

$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($products); // Return product details as JSON
