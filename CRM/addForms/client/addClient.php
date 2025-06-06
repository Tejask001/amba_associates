<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require '../../auth.php'; // auth check

require '../../config.php';

$errors = []; // Array to store validation error messages

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header('Content-Type: application/json'); // Only for POST requests

    // Client variables
    $client_first_name = test_input($_POST['client-first-name']);
    $client_middle_name = isset($_POST['client-middle-name']) ? test_input($_POST['client-middle-name']) : '';
    $client_last_name = test_input($_POST['client-last-name']);
    $client_phone = test_input($_POST['client-phone']);
    $client_email = test_input($_POST['client-email']);
    $client_address = test_input($_POST['client-address']);

    // Company variables
    $comp_name = test_input($_POST['comp-name']);
    // $comp_middle_name = test_input($_POST['comp-middle-name']);
    // $comp_last_name = test_input($_POST['comp-last-name']);
    $comp_type = test_input($_POST['comp-type']);
    $comp_email = test_input($_POST['comp-email']);
    $comp_website = test_input($_POST['comp-url']);
    $comp_address = test_input($_POST['comp-address']);

    // Manager variables
    $manager_name = test_input($_POST['manager-name']);
    $manager_phone = test_input($_POST['manager-phone']);
    $manager_email = test_input($_POST['manager-email']);

    // Company licensing variables
    $comp_chemical_license = test_input($_POST['comp-chemical-license']);
    $comp_trader_id = test_input($_POST['comp-trader-id']);
    $comp_gst_no = test_input($_POST['comp-gst-no']);
    $comp_tan_no = test_input($_POST['comp-tan-no']);
    $comp_pan_no = test_input($_POST['comp-pan-no']);

    $remarks = test_input($_POST['remarks']);

    // Client details validation
    if (empty($client_first_name) || !preg_match("/^[A-Za-z\s]+$/", $client_first_name)) {
        $errors['client-first-name'] = "Please enter a valid first name using alphabets only.";
    }
    if (!empty($client_middle_name) && !preg_match("/^[A-Za-z\s]+$/",  $client_middle_name)) {
        $errors['client-middle-name'] = "Please use alphabets only for middle name.";
    }
    if (empty($client_last_name) || !preg_match("/^[A-Za-z\s]+$/", $client_last_name)) {
        $errors['client-last-name'] = "Please enter a valid last name using alphabets only.";
    }
    if (empty($client_phone) || !preg_match("/^\d{10}$/", $client_phone)) {
        $errors['client-phone'] = "Please enter a valid 10-digit phone number.";
    }
    if (empty($client_email) || !filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
        $errors['client-email'] = "Please enter a valid email.";
    }
    if (empty($client_address)) {
        $errors['client-address'] = "Please enter the client's address.";
    }

    // Company details validation
    if (empty($comp_name) || !preg_match("/^[A-Za-z0-9. ]+$/", $comp_name)) {
        $errors['comp-name'] = "Please enter a valid company first name using alphanumeric characters.";
    }
    // if (!empty($comp_middle_name) && !preg_match("/^[A-Za-z0-9.]+$/", $comp_middle_name)) {
    //     $errors['comp-middle-name'] = "Please use alphanumeric characters only for middle name.";
    // }
    // if (empty($comp_last_name) || !preg_match("/^[A-Za-z0-9.]+$/", $comp_last_name)) {
    //     $errors['comp-last-name'] = "Please enter a valid company last name using alphanumeric characters.";
    // }
    if (empty($comp_email) || !filter_var($comp_email, FILTER_VALIDATE_EMAIL)) {
        $errors['comp-email'] = "Please enter a valid company email.";
    }
    if (empty($comp_website) || !filter_var($comp_website, FILTER_VALIDATE_URL)) {
        $errors['comp-url'] = "Please enter a valid URL.";
    }
    if (empty($comp_address)) {
        $errors['comp-address'] = "Please enter the company's address.";
    }

    // Manager details validation
    if (empty($manager_name) || !preg_match("/^[A-Za-z\s]+$/", $manager_name)) {
        $errors['manager-name'] = "Please enter a valid manager's first name using alphabets only.";
    }

    if (empty($manager_phone) || !preg_match("/^\d{10}$/", $manager_phone)) {
        $errors['manager-phone'] = "Please enter a valid 10-digit manager's phone number.";
    }
    if (empty($manager_email) || !filter_var($manager_email, FILTER_VALIDATE_EMAIL)) {
        $errors['manager-email'] = "Please enter a valid manager's email.";
    }

    // Licensing details validation
    if (empty($comp_chemical_license) || !preg_match("/^[A-Za-z0-9]+$/", $comp_chemical_license)) {
        $errors['comp-chemical-license'] = "Please enter a valid chemical license using alphanumeric characters.";
    }
    if (empty($comp_trader_id)) {
        $errors['comp-trader-id'] = "Please enter the trader ID.";
    }
    if (empty($comp_gst_no) || !preg_match("/^\d{15}$/", $comp_gst_no)) {
        $errors['comp-gst-no'] = "Please enter a valid 15-digit GST number.";
    }
    if (empty($comp_tan_no) || !preg_match("/^[A-Za-z0-9]{10}$/", $comp_tan_no)) {
        $errors['comp-tan-no'] = "Please enter a valid 10-character alphanumeric TAN number.";
    }
    if (empty($comp_pan_no) || !preg_match("/^[A-Za-z0-9]{10}$/", $comp_pan_no)) {
        $errors['comp-pan-no'] = "Please enter a valid 10-character alphanumeric PAN number.";
    }

    // Process form data if no errors
    if (empty($errors)) {
        // Insert or process form data
        $sql = "INSERT INTO `amba_associats`.`client` (
            `first_name`, `middle_name`, `last_name`, `phone`, `email`, `address`, 
            `comp_name`, `comp_type`, `manager_name`, `manager_phone`, `manager_email`, `chemical_license`, `comp_email`, `comp_address`, `trader_id`, `gst_no`, `pan_no`, `tan_no`, `website`, `remarks`
        ) VALUES (
            '$client_first_name', '$client_middle_name', '$client_last_name', 
            '$client_phone', '$client_email', '$client_address', '$comp_name', '$comp_type', '$manager_name', '$manager_phone', '$manager_email', '$comp_chemical_license', '$comp_email', '$comp_address', '$comp_trader_id', '$comp_gst_no', '$comp_pan_no', '$comp_tan_no', '$comp_website', '$remarks'
        )";

        // Execute the query
        if ($conn->query($sql) === true) {
            echo json_encode(['success' => true, 'message' => 'Submission Successful']);
        } else {
            echo  "$conn->error";
        }
        //echo json_encode(['success' => true, 'message' => 'Submission Successful']);
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }

    exit(); // Stop further script execution after JSON response
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Client</title>
    <style>
        :root {
            --bs-primary-rgb: 2, 132, 199;
            /* Define the primary color RGB value */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1100px;
            margin-top: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #0284c7;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }

        label {
            font-weight: 500;
            color: #343a40;
        }

        .btn-primary {
            background-color: #0284c7;
            border-color: #0284c7;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 90%;
        }
    </style>

</head>

<body>
    <div class="container">
        <form action="addClient.php" method="POST" class="form-container needs-validation" id="form" novalidate>

            <!-- client details -->

            <h1 class="mb-4">New Client</h1>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="client-first-name" class="form-label">Client's First Name *</label>
                    <input type="text" class="form-control" id="client-first-name" name="client-first-name"
                        placeholder="First Name" pattern="^[A-Za-z\s]+$" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['client-first-name'] ?? 'Please Use Alphabets Only'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="client-middle-name" class="form-label">Client's Middle Name</label>
                    <input type="text" class="form-control" id="client-middle-name" name="client-middle-name"
                        placeholder="Middle Name" pattern="^[A-Za-z\s]+$">
                    <div class="invalid-feedback">
                        <?php echo $errors['client-middle-name'] ?? 'Please Use Alphabets Only'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="client-last-name" class="form-label">Client's Last Name *</label>
                    <input type="text" class="form-control" id="client-last-name" name="client-last-name"
                        placeholder="Last Name" pattern="^[A-Za-z\s]+$" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['client-last-name'] ?? 'Please Use Alphabets Only'; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="client-phone" class="form-label">Client's Phone *</label>
                    <input type="text" class="form-control" id="client-phone" name="client-phone"
                        placeholder="Phone Number" pattern="^\d{10}$" min="10" max="10" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['client-phone'] ?? 'Please Enter 10 Digit Phone Number'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="client-email" class="form-label">Client's Email *</label>
                    <input type="email" class="form-control" id="client-email" name="client-email" placeholder="Email"
                        required>
                    <div class="invalid-feedback">
                        <?php echo $errors['client-email'] ?? 'Please Enter Valid Email'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="client-address" class="form-label">Client's Address *</label>
                    <input type="text" class="form-control" id="client-address" name="client-address"
                        placeholder="Address" required>
                    <div class="invalid-feedback">
                        Please Enter Address
                    </div>
                </div>
            </div>

            <!-- company details -->

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="comp-name" class="form-label">Company Name *</label>
                    <input type="text" class="form-control" id="comp-name" name="comp-name"
                        placeholder="First Name" pattern="^[A-Za-z0-9. ]+$" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-name'] ?? 'Please Use AlphaNumerics Only'; ?>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="comp-type" class="form-label">Company Type *</label>
                    <select class="form-select" id="comp-type" name="comp-type" aria-label="Default select example">
                        <option selected>Corporation</option>
                        <option value="1">Proprietorship</option>
                        <option value="2">Partnerships</option>
                        <option value="3">Limited Liability Companies (LLC)</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="comp-url" class="form-label">Company Website *</label>
                    <input type="url" class="form-control" id="comp-url" name="comp-url" placeholder="URL" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-url'] ?? 'Please Enter Valid URL'; ?>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="comp-email" class="form-label">Company Email</label>
                    <input type="email" class="form-control" id="comp-email" name="comp-email" placeholder="Email">
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-email'] ?? 'Please Enter Valid Email'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="comp-address" class="form-label">Company Address *</label>
                    <input type="text" class="form-control" id="comp-address" name="comp-address" placeholder="Address"
                        required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-address'] ?? 'Please Enter Address'; ?>
                    </div>
                </div>
            </div>

            <!-- manager details -->

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="manager-name" class="form-label">Manager's Name *</label>
                    <input type="text" class="form-control" id="manager-name" name="manager-name"
                        placeholder="Full Name" pattern="^[A-Za-z\s]+$" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['manager-name'] ?? 'Please Use Alphabets Only'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="manager-phone" class="form-label">Manager's Phone *</label>
                    <input type="text" class="form-control" id="manager-phone" name="manager-phone" pattern="^\d{10}$"
                        min="10" max="10" placeholder="Phone Number" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['manager-phone'] ?? 'Please Enter 10 Digit Phone Number'; ?>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="manager-email" class="form-label">Manager's Email *</label>
                    <input type="email" class="form-control" id="manager-email" name="manager-email" placeholder="Email"
                        required>
                    <div class="invalid-feedback">
                        <?php echo $errors['manager-email'] ?? 'Please Enter Valid Email'; ?>
                    </div>
                </div>
            </div>

            <!-- company licensing deatails -->

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="comp-chemical-license" class="form-label">Client's Chemical License *</label>
                    <input type="text" class="form-control" id="comp-chemical-license" name="comp-chemical-license"
                        placeholder="Chemical License" pattern="^[A-Za-z0-9]+$" maxlength=" 50" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-chemical-license'] ?? 'Please Enter Chemical License'; ?>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="comp-trader-id" class="form-label">Company Trader ID *</label>
                    <input type="text" class="form-control" id="comp-trader-id" name="comp-trader-id"
                        placeholder="Trader ID" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-trader-id'] ?? 'Please Trader ID'; ?>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="comp-gst-no" class="form-label">Company GST No *</label>
                    <input type="int" class="form-control" id="comp-gst-no" name="comp-gst-no" pattern="\d{15}$"
                        min="10" max="10" placeholder="GST No" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-gst-no'] ?? 'Please Enter 15 Digit GST No'; ?>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="comp-tan-no" class="form-label">Company's TAN No *</label>
                    <input type="text" class="form-control" id="comp-tan-no" name="comp-tan-no" placeholder="TAN No"
                        pattern="^[A-Za-z0-9]{10}$" minlength="10" maxlength="10" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-tan-no'] ?? 'Please Enter a Valid 10-Character Alphanumeric TAN No'; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="comp-pan-no" class="form-label">Company PAN No *</label>
                    <input type="text" class="form-control" id="comp-pan-no" name="comp-pan-no" placeholder="PAN No"
                        pattern="^[A-Za-z0-9]{10}$" minlength="10" maxlength="10" required>
                    <div class="invalid-feedback">
                        <?php echo $errors['comp-pan-no'] ?? 'lease Enter a Valid 10-Character Alphanumeric TAN No'; ?>
                    </div>
                </div>

                <!--  Remarks  -->

                <div class="col-md-8 mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                </div>
            </div>

            <!-- Submit Button -->

            <div class="row mt-4">
                <div class="col-md-6 mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-md-6 mb-3 d-grid">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="addClient.js"></script>
</body>

</html>