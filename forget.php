<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database credentials
include_once 'dp.php'; 

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get POST data
$email = $_POST['email'] ?? '';
$new_password = $_POST['new_password'] ?? '';

// Basic validation
if (!$email || !$new_password) {
    http_response_code(400);
    echo json_encode(['error' => 'Email and new password are required']);
    exit;
}

// Hash the new password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Prepare and execute update
$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ss", $new_password_hash, $email);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'No user found with this email']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Update failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
