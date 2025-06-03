<?php
require 'auth.php'; // auth check, ensure session_start() is here if not in auth.php
require 'config.php'; // database connection ($conn)

// Fetch logistics details
$sql = "
    SELECT 
        id,
        order_id,
        vehicle_no,
        driver_name,
        driver_phone,
        driver_gst_no,
        estimated_delivery_date,
        is_transferred,
        client_vehicle_no,
        client_driver_name,
        client_driver_phone,
        client_driver_gst_no,
        transfer_date
    FROM 
        logistics
    ORDER BY id DESC; -- Or order by estimated_delivery_date, order_id, etc.
";

$result = $conn->query($sql);

// Check for query errors (optional but good practice)
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Logistics Details</title>
    <style>
        /* General table styling */
        .table {
            border-collapse: collapse;
            background-color: #ffffff;
            /* White background for the table */
        }

        /* Header Styling (lighter color) */
        .table thead {
            background-color: #f1f3f5;
            /* Light grey background */
            color: #495057;
            /* Dark grey text for contrast */
            text-transform: uppercase;
            font-weight: bold;
        }

        .table thead th {
            text-align: center;
            padding: 12px;
            background-color: #0284c7;
            /* Theme color from your example */
            color: white;
            /* White text on dark background */
        }

        /* Table body styling */
        .table tbody td {
            padding: 10px 12px;
            /* Adjusted padding */
            vertical-align: middle;
            text-align: center;
            color: #495057;
            /* Dark grey text */
            font-size: 0.9rem;
            /* Slightly smaller font for more data */
        }

        /* Zebra striping for rows */
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
            /* Light grey for even rows */
        }

        /* Hover effect for rows */
        .table tbody tr:hover {
            background-color: #e2e6ea;
            /* Slightly darker hover color */
        }

        /* Responsive table */
        .table-responsive {
            overflow-x: auto;
        }

        /* Improve scrollbar appearance */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #343a40;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #495057;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Add a subtle shadow for the table */
        .table {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.27);
            /* Soft shadow */
        }

        /* Add professional button styles */
        .btn {
            border-radius: 5px;
            padding: 8px 15px;
        }

        .btn-primary {
            background-color: #0284c7;
            border-color: #0284c7;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #0284c7;
            color: white;
            border-bottom: none;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-footer {
            border-top: none;
        }

        #main {
            padding-top: 1.5rem;
            /* Add some padding at the top of main content */
        }
    </style>

</head>

<body>
    <div class="row">
        <!-- Sidebar -->
        <div class="col-3"> <!-- Bootstrap sidebar classes -->
            <?php include("sidebar.php") // Make sure sidebar.php exists and is styled appropriately 
            ?>
        </div>

        <!-- Main Content -->
        <main id="main" class="col-9"> <!-- Bootstrap main content classes -->
            <h2 class="mb-4 mt-3">Logistics Records</h2>
            <!-- Update this link if you have an addLogistics.php page -->
            <a href="./addForms/logistics/addLogistics.php"><button type="button" class="btn btn-primary mb-4">Add New Logistics Entry</button></a>

            <div class="table-responsive">
                <table class="table table-striped table-hover"> <!-- Added table-hover -->
                    <thead class="table-dark"> <!-- Using table-dark for header consistency with product example -->
                        <tr>
                            <th>Actions</th>
                            <th>Order ID</th>
                            <th>Vehicle No</th>
                            <th>Driver Name</th>
                            <th>Driver Phone</th>
                            <th>Driver GST No</th>
                            <th>Est. Delivery Date</th>
                            <th>Transferred?</th>
                            <th>Client Vehicle No</th>
                            <th>Client Driver Name</th>
                            <th>Client Driver Phone</th>
                            <th>Client Driver GST No</th>
                            <th>Transfer Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='text-nowrap'> <!-- text-nowrap to keep buttons on one line if possible -->
                                            <a href='./updateForms/logistics/updateLogistics.php?order_id=" . urlencode($row['order_id']) . "' class='btn btn-sm btn-primary me-1 mb-1'>Update</a>
                                            <button type='button' class='btn btn-sm btn-danger delete-btn mb-1' data-order-id='" . htmlspecialchars($row['order_id']) . "'>Delete</button>
                                          </td>";
                                echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['vehicle_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['driver_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['driver_phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['driver_gst_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['estimated_delivery_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['is_transferred']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['client_vehicle_no'] ?? 'N/A') . "</td>";
                                echo "<td>" . htmlspecialchars($row['client_driver_name'] ?? 'N/A') . "</td>";
                                echo "<td>" . htmlspecialchars($row['client_driver_phone'] ?? 'N/A') . "</td>";
                                echo "<td>" . htmlspecialchars($row['client_driver_gst_no'] ?? 'N/A') . "</td>";
                                echo "<td>" . htmlspecialchars($row['transfer_date'] ?? 'N/A') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='13' class='text-center'>No Logistics records found.</td></tr>"; // Updated colspan
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this logistics record for Order ID: <strong id="modalOrderIdDisplay"></strong>?</p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter your password for confirmation:</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                    <input type="hidden" id="deleteOrderId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.delete-btn');
                const deleteModalElement = document.getElementById('deleteModal');
                const deleteModal = new bootstrap.Modal(deleteModalElement);
                const confirmDeleteBtn = document.getElementById('confirmDelete');
                const passwordInput = document.getElementById('password');
                const hiddenOrderIdInput = document.getElementById('deleteOrderId');
                const modalOrderIdDisplay = document.getElementById('modalOrderIdDisplay');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.dataset.orderId;
                        hiddenOrderIdInput.value = orderId;
                        modalOrderIdDisplay.textContent = orderId; // Display Order ID in modal
                        passwordInput.value = ''; // Clear password field on modal open
                        deleteModal.show();
                    });
                });

                confirmDeleteBtn.addEventListener('click', function() {
                    const enteredPassword = passwordInput.value;
                    const orderId = hiddenOrderIdInput.value;

                    if (!orderId) {
                        alert('Error: Order ID is missing. Please try again.');
                        return;
                    }
                    if (!enteredPassword) {
                        alert('Password is required for deletion.');
                        passwordInput.focus();
                        return;
                    }

                    const formData = new FormData();
                    formData.append('order_id', orderId);
                    formData.append('password', enteredPassword);

                    fetch('deleteLogistics.php', { // Ensure this points to your delete script
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Logistics record deleted successfully.');
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert(data.message || 'Failed to delete logistics record.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while trying to delete the record. Please check the console.');
                        })
                        .finally(() => {
                            deleteModal.hide();
                        });
                });

                // Optional: Clear password field when modal is hidden (if not already handled by opening)
                deleteModalElement.addEventListener('hidden.bs.modal', function() {
                    passwordInput.value = '';
                    hiddenOrderIdInput.value = '';
                    modalOrderIdDisplay.textContent = '';
                });
            });
        </script>

</body>

</html>
<?php
// Close the connection
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>