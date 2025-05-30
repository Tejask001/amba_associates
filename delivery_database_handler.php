<?php
$_ENV = parse_ini_file('.env');
// Connect to the database
$servername = $_ENV["DB_SERVER_NAME"];
$username = $_ENV["DB_USER_NAME"];
$password = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];


try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Validate and sanitize input data
        $fullName = trim($_POST['fullName'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $addressLine1 = trim($_POST['addressLine1'] ?? '');
        $addressLine2 = trim($_POST['addressLine2'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $pincode = trim($_POST['pincode'] ?? '');
        $deliveryInstructions = trim($_POST['deliveryInstructions'] ?? '');

        // Validation
        $errors = [];

        if (empty($fullName)) {
            $errors[] = "Full name is required";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email address is required";
        }

        if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
            $errors[] = "Valid 10-digit phone number is required";
        }

        if (empty($addressLine1)) {
            $errors[] = "Address Line 1 is required";
        }

        if (empty($city)) {
            $errors[] = "City is required";
        }

        if (empty($state)) {
            $errors[] = "State is required";
        }

        if (empty($pincode) || !preg_match('/^[0-9]{6}$/', $pincode)) {
            $errors[] = "Valid 6-digit pincode is required";
        }

        // If no errors, insert data into database
        if (empty($errors)) {
            try {
                $sql = "INSERT INTO delivery_details (
                    full_name, 
                    email, 
                    phone, 
                    address_line1, 
                    address_line2, 
                    city, 
                    state, 
                    pincode, 
                    delivery_instructions
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $fullName,
                    $email,
                    $phone,
                    $addressLine1,
                    $addressLine2,
                    $city,
                    $state,
                    $pincode,
                    $deliveryInstructions
                ]);

                // Get the inserted record ID
                $deliveryId = $pdo->lastInsertId();

                // Store delivery ID in session for payment page
                session_start();
                $_SESSION['delivery_id'] = $deliveryId;
                $_SESSION['delivery_data'] = [
                    'full_name' => $fullName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $addressLine1 . ($addressLine2 ? ', ' . $addressLine2 : '') . ', ' . $city . ', ' . $state . ' - ' . $pincode
                ];

                // Redirect to payment page
                header('Location: checkout_summary.php?success=1');
                exit();
            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }

        // If there are errors, store them in session and redirect back
        if (!empty($errors)) {
            session_start();
            $_SESSION['delivery_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: delivery.php?error=1');
            exit();
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
