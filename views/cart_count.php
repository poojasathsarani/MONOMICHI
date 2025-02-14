<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id'])) {
    echo "0";
    exit;
}

$user_id = $_SESSION['id'];

// Get sum of quantities for all items in cart
$query = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['total'] ? $row['total'] : "0";
?>