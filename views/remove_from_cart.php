<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id']) || !isset($_POST['product_id'])) {
    exit;
}

$user_id = $_SESSION['id'];
$product_id = $_POST['product_id'];

$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
?>
