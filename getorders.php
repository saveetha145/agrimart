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

// Get email from GET request
$email = $_GET['email'] ?? '';

if (empty($email)) {
    http_response_code(400);
    echo json_encode(["message" => "Email is required"]);
    exit();
}

// Prepare and execute SELECT query
$stmt = $conn->prepare("SELECT id, productname, quantity, date, address, image, orderid, `total amount`, email FROM payment WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Collect results
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Respond
echo json_encode([
    "message" => "Orders fetched successfully",
    "orders" => $orders
]);

$stmt->close();
$conn->close();
?>
