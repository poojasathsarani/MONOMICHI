<?php
session_start();
require "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $productId = $data->id;

    if (!isset($_SESSION['id'])) {
        echo json_encode(["message" => "Please log in to remove items."]);
        exit();
    }

    $user_id = $_SESSION['id'];

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND id = ?");
    $stmt->bind_param("ii", $user_id, $productId);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Item removed from your wishlist."]);
    } else {
        echo json_encode(["message" => "Failed to remove item."]);
    }

    $stmt->close();
    $conn->close();
}
?>
