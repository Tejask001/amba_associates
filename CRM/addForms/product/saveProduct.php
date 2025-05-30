<?php

require '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_id = $_POST['supplier_id'];

    $product_ids = $_POST['product_id'];
    $batch_codes = $_POST['batch_code'];
    $general_names = $_POST['general_name'];
    $chemical_names = $_POST['chemical_name'];
    $sizes = $_POST['size'];
    $purchase_prices = $_POST['purchase_price'];
    $selling_prices = $_POST['selling_price'];
    $margins = $_POST['margin'];
    $tax_percents = $_POST['tax_percent'];
    $product_lifes = $_POST['product_life'];
    $stocks = $_POST['stock'];

    // Create the directory if it doesn't exist
    $uploadDir = '../../assets/images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory with full permissions (adjust as needed)
    }

    $conn->begin_transaction();

    try {
        for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            $batch_code = $batch_codes[$i];
            $general_name = $general_names[$i];
            $chemical_name = $chemical_names[$i];
            $size = $sizes[$i];
            $purchase_price = $purchase_prices[$i];
            $selling_price = $selling_prices[$i];
            $margin = $margins[$i];
            $product_life = $product_lifes[$i];
            $tax_percent = $tax_percents[$i];
            $stock = $stocks[$i];
            $imageFileName = null;  // Initialize to null

            // Check if a file was uploaded for this product
            if (isset($_FILES['image']['name'][$i]) && $_FILES['image']['error'][$i] == UPLOAD_ERR_OK) {
                $imageTmpName = $_FILES['image']['tmp_name'][$i];
                $imageFileType = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($imageFileType, $allowedTypes)) {
                    $imageFileName = uniqid() . '.' . $imageFileType;
                    $imageUploadPath = $uploadDir . $imageFileName;

                    if (!move_uploaded_file($imageTmpName, $imageUploadPath)) {
                        throw new Exception("Failed to move uploaded file.");
                    }
                } else {
                    throw new Exception("Invalid file type. Allowed types: " . implode(', ', $allowedTypes));
                }
            }


            $sql = "INSERT INTO product (product_code, general_name, chemical_name, chemical_size, pp, sp, mrgp, tax_percent, product_life, batch_code, supplier_id, image)
                    VALUES ('$product_id', '$general_name', '$chemical_name', '$size', '$purchase_price', '$selling_price', '$margin', '$tax_percent', '$product_life', '$batch_code', '$supplier_id', '$imageFileName')";

            if (!$conn->query($sql)) {
                throw new Exception("Error inserting product: " . $conn->error);
            }


            $sql_stock = "INSERT INTO stock (batch_code, quantity, mas)
                          VALUES ('$batch_code', '$stock', 10)
                          ON DUPLICATE KEY UPDATE quantity = quantity + '$stock'";

            if (!$conn->query($sql_stock)) {
                throw new Exception("Error updating stock: " . $conn->error);
            }
        }

        $conn->commit();
        echo "<script>alert('Product(s) added successfully!'); location.replace('../../product.php');</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        // Consider logging the error to a file for debugging:
        error_log("Error adding product: " . $e->getMessage());
    }
}

$conn->close();
