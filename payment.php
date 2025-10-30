<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Include DB connection
include_once 'dp.php'; // make sure this file contains $conn = new mysqli(...);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed"]);
    exit();
}

// Get POST data
$productname = $_POST['productname'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$totalAmount = $_POST['total_amount'] ?? 0;
$email = $_POST['email'] ?? '';
$orderid = $_POST['orderid'] ?? '';
$date = $_POST['date'] ?? '';
$address = $_POST['address'] ?? '';
$image = $_POST['image'] ?? ''; // ✅ Get image filename or URL

// Validate required fields
if (empty($productname) || empty($email) || empty($orderid)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// ✅ Insert into table with image
$stmt = $conn->prepare("INSERT INTO payment (productname, quantity, orderid, `total amount`, email, date, address, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisdssss", $productname, $quantity, $orderid, $totalAmount, $email, $date, $address, $image);

if ($stmt->execute()) {
    echo json_encode([
        "message" => "Order added successfully",
        "orderid" => $orderid
    ]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Insert failed"]);
}

// Close everything
$stmt->close();
$conn->close();
?>
