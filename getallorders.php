<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Include DB connection
include_once 'dp.php';

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed"]);
    exit();
}

// Prepare and execute SELECT query (no email filter)
$sql = "SELECT id, productname, quantity, date, address, image, orderid, `total amount`, email FROM payment";
$result = $conn->query($sql);

// Collect results
$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Respond
echo json_encode([
    "message" => "Orders fetched successfully",
    "orders" => $orders
]);

$conn->close();
?>
