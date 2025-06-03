<?php
// deleteLogistics.php

header('Content-Type: application/json'); // Ensure the output is treated as JSON

require 'auth.php'; // Make sure this includes necessary session checks & session_start()
require 'config.php'; // Ensure this file uses MySQLi for the database connection ($conn)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required POST variables are set
    if (!isset($_POST['order_id']) || !isset($_POST['password'])) {
        echo json_encode(['success' => false, 'message' => 'Order ID and password are required.']);
        exit;
    }

    $order_id = $_POST['order_id'];
    $enteredPassword = $_POST['password'];

    // Determine the username for password check.
    // For this example, we'll stick to 'amba' as per the original.
    // In a real application, this might come from the session: $_SESSION['username']
    // Or, if 'amba' is a specific admin whose password must be entered for this action.
    $username_to_check = 'amba'; // Or dynamically get from session if appropriate

    // Fetch user's hashed password from the database (using MySQLi)
    // Ensure you have a 'user' table with 'username' and 'password_hash' columns.
    $stmt = $conn->prepare("SELECT password_hash FROM user WHERE username = ?");
    if (!$stmt) {
        // Handle prepare error - database issue or SQL syntax error
        // Log the actual error for debugging, but show a generic message to the user
        error_log("Prepare failed (user select): (" . $conn->errno . ") " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error preparing user statement. Please try again later.']);
        exit;
    }

    $stmt->bind_param("s", $username_to_check);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($enteredPassword, $user['password_hash'])) {
        // Password is correct, proceed with deletion from 'logistics' table (using MySQLi)
        $deleteStmt = $conn->prepare("DELETE FROM logistics WHERE order_id = ?");
        if (!$deleteStmt) {
            // Handle prepare error for delete statement
            error_log("Prepare failed (logistics delete): (" . $conn->errno . ") " . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Database error preparing delete statement. Please try again later.']);
            exit;
        }

        $deleteStmt->bind_param("s", $order_id); // 's' because order_id is varchar
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Logistics record deleted successfully.']);
        } else {
            // This could mean the order_id didn't exist, or the delete operation failed for other reasons.
            echo json_encode(['success' => false, 'message' => 'Failed to delete logistics record. No record found with the given Order ID or no changes made.']);
        }
        $deleteStmt->close();
    } else {
        // Invalid password or user not found
        echo json_encode(['success' => false, 'message' => 'Invalid password or user not found.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Only POST is allowed.']);
}

// It's good practice to close the database connection if $conn was established in config.php
// and is not automatically closed elsewhere (e.g., at the end of script execution by PHP's garbage collection).
// If your config.php or framework handles this, you might not need it here.
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
