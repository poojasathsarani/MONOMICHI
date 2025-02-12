<?php
session_start();
header('Content-Type: application/json');
require "db_connection.php"; // Include your database connection file

if (!isset($_SESSION['id'])) {
    echo json_encode(["message" => "User not logged in."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['productId'])) {
    echo json_encode(["message" => "Invalid data."]);
    exit();
}

$user_id = $_SESSION['id'];
$product_id = $data['productId'];

// Check if the product is already in the cart
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["message" => "Already in Cart!"]);
} else {
    // Insert into cart
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Added to Cart!"]);
    } else {
        echo json_encode(["message" => "Error adding to Cart."]);
    }
}

$stmt->close();
$conn->close();
?>
