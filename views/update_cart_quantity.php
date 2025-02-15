<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id']) || !isset($_POST['product_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$user_id = $_SESSION['id'];
$product_id = $_POST['product_id'];
$action = $_POST['action'];

// Get current quantity
$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Item not found in cart']);
    exit;
}

$current_quantity = $result->fetch_assoc()['quantity'];
$new_quantity = ($action === 'increase') ? $current_quantity + 1 : $current_quantity - 1;

// Ensure quantity doesn't go below 1
if ($new_quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Quantity cannot be less than 1']);
    exit;
}

// Update quantity
$update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);

if ($update_stmt->execute()) {
    echo json_encode(['success' => true, 'new_quantity' => $new_quantity]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating quantity. Please try again.']);
}

$conn->close();
?>
