<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// JSON response header
header('Content-Type: application/json');

// Include DB connection
include_once 'dp.php';

// Check DB connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get email from GET or POST
$email = $_POST['email'] ?? $_GET['email'] ?? '';

if (empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email is required']);
    exit;
}

// Query the add_cart table
$stmt = $conn->prepare("SELECT product_name, quantity, price FROM add_cart WHERE email = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

// Return JSON result
echo json_encode([
    'success' => true,
    'data' => $cart_items,
    'message' => empty($cart_items) ? 'No products found' : 'Cart items retrieved successfully'
]);

$stmt->close();
$conn->close();
?>
