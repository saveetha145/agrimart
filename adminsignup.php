<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'dp.php'; // Connects to your agrimart1 DB

header('Content-Type: application/json');

// Accept only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

// Detect input format: JSON or form-data
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

if (stripos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');
} else {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
}

// Validate input fields
if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Email already registered']);
    $stmt->close();
    $conn->close();
    exit;
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert admin record into table with 'password_hash' column
$insert = $conn->prepare("INSERT INTO admin (email, password_hash) VALUES (?, ?)");
$insert->bind_param("ss", $email, $hashedPassword);

if ($insert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Admin account created successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error during insert']);
}

// Close resources
$insert->close();
$stmt->close();
$conn->close();
?>
