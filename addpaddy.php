<?php
// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Include DB connection
include_once 'dp.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Only POST method is allowed']);
        exit;
    }

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // ✅ Get POST fields
    $tittle = $_POST['tittle'] ?? '';
    $subtitle = $_POST['subtitle'] ?? '';
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // ✅ Validate required fields
    if (empty($tittle) || empty($subtitle) || !isset($_FILES['image']) || $price === '' || $quantity === '') {
        http_response_code(400);
        echo json_encode(['error' => 'tittle, subtitle, image, price, and quantity are required']);
        exit;
    }

    if (!is_numeric($price) || !is_numeric($quantity)) {
        http_response_code(400);
        echo json_encode(['error' => 'price and quantity must be numeric']);
        exit;
    }

    // ✅ Ensure upload directory exists
    $uploadDir = __DIR__ . "/uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalName = basename($_FILES['image']['name']);
    $uniqueName = time() . "_" . $originalName;
    $fullPath = $uploadDir . $uniqueName;
    $dbPath = "uploads/" . $uniqueName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $fullPath)) {
        // ✅ Insert into DB including price and quantity
        $stmt = $conn->prepare("INSERT INTO AddPaddy (tittle, subtitle, image, price, quantity) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("sssii", $tittle, $subtitle, $dbPath, $price, $quantity);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Added successfully',
                'image_path' => $dbPath
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Insert failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload image']);
    }

    $conn->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    exit;
}
?>
