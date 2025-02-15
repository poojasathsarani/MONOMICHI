<?php
session_start();
include "db_connection.php"; // Ensure this connects to your database

$user_id = $_SESSION["id"];
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data["product_id"];

$sql = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["exists" => true]);
} else {
    echo json_encode(["exists" => false]);
}
?>
