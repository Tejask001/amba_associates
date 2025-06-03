<?php
require '../../config.php';

if (isset($_GET['order_id'])) {
    $order_id = $conn->real_escape_string($_GET['order_id']);

    // Fetch order details, including client and supplier names
    $orderDetails = $conn->query("
        SELECT 
            orders.date AS order_date,
            client.comp_name AS client_name,
            supplier.comp_name AS supplier_name,
            orders.client_id,
            orders.supplier_id
        FROM orders
        LEFT JOIN client ON orders.client_id = client.id
        LEFT JOIN supplier ON orders.supplier_id = supplier.id
        WHERE orders.order_id = '$order_id'
    ")->fetch_assoc();

    // Fetch products grouped by order ID
    $products = $conn->query("
        SELECT 
            product.general_name,
            order_items.batch_code,
            order_items.quantity
        FROM order_items
        JOIN product ON order_items.batch_code = product.batch_code
        WHERE order_items.order_id = '$order_id'
    ");

    $productList = [];
    while ($row = $products->fetch_assoc()) {
        $productList[] = $row;
    }


    // Determine which name to use
    $partyName = '';
    $orderType = '';
    if (!empty($orderDetails['client_id'])) {
        $partyName = $orderDetails['client_name'];
        $orderType = 'Sale';
    } elseif (!empty($orderDetails['supplier_id'])) {
        $partyName = $orderDetails['supplier_name'];
        $orderType = 'Purchase';
    } else {
        $partyName = 'N/A'; // Default if neither client nor supplier is found
    }


    // Response
    echo json_encode([
        'order_date' => $orderDetails['order_date'] ?? 'N/A',
        'party_name' => $partyName,
        'order_type' => $orderType,
        'products' => $productList
    ]);
}
