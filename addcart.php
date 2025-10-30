<?php
// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response type to JSON
header('Content-Type: application/json');

// Include database connection
include_once 'dp.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST allowed']);
    exit;
}

// Get form-data values
$email = $_POST['email'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$quantity = $_POST['quantity'] ?? 1;
$price = $_POST['price'] ?? '';

// Validate required fields
if (!$email || !$product_name || !$price) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Insert or update in add_cart table
$stmt = $conn->prepare("INSERT INTO add_cart (email, product_name, quantity, price)
                        VALUES (?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssis", $email, $product_name, $quantity, $price);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Item added to cart']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
