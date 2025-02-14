<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id'])) {
    exit;
}

$user_id = $_SESSION['id'];

$query = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
?>
