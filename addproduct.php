<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$password = "";
$dbname = "agrimart1"; // change if needed

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit();
}

// Handle POST data
$title = $_POST['title'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$imagePath = '';

if (isset($_FILES['image'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $imageName = basename($_FILES['image']['name']);
    $targetFile = $targetDir . uniqid() . "_" . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        echo json_encode(["success" => false, "message" => "Image upload failed"]);
        exit();
    }
}

$stmt = $conn->prepare("INSERT INTO products (title, quantity, price, description, image) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $quantity, $price, $description, $imagePath);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to add product"]);
}

$stmt->close();
$conn->close();
?>
