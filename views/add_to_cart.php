<?php
session_start();
header('Content-Type: application/json');
include('db_connection.php');

try {
    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        throw new Exception("Please log in to add items to cart");
    }

    $user_id = $_SESSION['id'];
    
    // Get JSON data
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if (!isset($data['product_id'])) {
        throw new Exception("Product ID is required");
    }

    $product_id = (int)$data['product_id'];

    // Verify product exists in Products table
    $check_product = "SELECT productid, price, stock FROM Products WHERE productid = ?";
    $stmt = $conn->prepare($check_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows === 0) {
        throw new Exception("Product not found");
    }

    $product_data = $product_result->fetch_assoc();
    $price = $product_data['price'];
    $stock = $product_data['stock'];  // Ensure stock column exists in Products table

    // Check if product already exists in cart
    $check_cart = "SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_cart);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    if ($cart_result->num_rows > 0) {
        // Update quantity if product exists
        $cart_item = $cart_result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + 1;

        // Ensure the new quantity does not exceed available stock
        if ($new_quantity > $stock) {
            throw new Exception("Not enough stock available");
        }

        $update_query = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $new_quantity, $cart_item['cart_id']);
    } else {
        // Insert new item if product doesn't exist in cart
        if ($stock < 1) {
            throw new Exception("This product is out of stock");
        }

        $insert_query = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iid", $user_id, $product_id, $price);
    }

    if (!$stmt->execute()) {
        throw new Exception("Failed to update cart: " . $stmt->error);
    }

    echo json_encode([
        "success" => true,
        "message" => "Product added to cart successfully"
    ]);

} catch (Exception $e) {
    error_log("Cart error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
