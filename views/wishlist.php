<?php
session_start();
header('Content-Type: application/json');

require "db_connection.php"; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["message" => "Invalid data."]);
    exit();
}

$product_name = $data['name'];
$product_price = $data['price'];
$product_image = $data['img'];

// Check if the product is already in the wishlist
$stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_name = ?");
$stmt->bind_param("is", $user_id, $product_name);
$stmt->execute();
$result = $stmt->get_result();

$response = []; // Initialize the response array

if ($result->num_rows > 0) {
    $response["message"] = "Already in Wishlist!";
    $response["success"] = false; // Adding failure flag for the popup
} else {
    // Insert into wishlist
    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_name, product_price, product_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $user_id, $product_name, $product_price, $product_image);

    if ($stmt->execute()) {
        $response["message"] = "Added to Wishlist!";
        $response["success"] = true; // Adding success flag for the popup
    } else {
        $response["message"] = "Error adding to Wishlist.";
        $response["success"] = false;
    }
}

$stmt->close();
$conn->close();

// Return response as JSON
echo json_encode($response);
?>
