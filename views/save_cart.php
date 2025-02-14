<?php
// save_cart.php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Content-Type: application/json');

try {
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }
    
    $userId = $_SESSION['user_id'];
    $productName = mysqli_real_escape_string($conn, $data['name']);
    $price = floatval($data['price']);
    $quantity = intval($data['quantity']);
    
    // Check if product already exists in cart
    $query = "SELECT id, quantity FROM cart WHERE user_id = '$userId' AND product_name = '$productName'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Update quantity
        $row = mysqli_fetch_assoc($result);
        $query = "UPDATE cart SET quantity = quantity + 1 WHERE id = '{$row['id']}'";
        mysqli_query($conn, $query);
    } else {
        // Insert new item
        $query = "INSERT INTO cart (user_id, product_name, price, quantity) 
                 VALUES ('$userId', '$productName', '$price', '$quantity')";
        mysqli_query($conn, $query);
    }
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

// Function to load cart items
function loadCartItems($userId) {
    global $conn;
    
    $userId = mysqli_real_escape_string($conn, $userId);
    $query = "SELECT * FROM cart WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);
    
    $items = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    
    return $items;
}

// Function to update cart item
function updateCartItem($userId, $productName, $quantity) {
    global $conn;
    
    $userId = mysqli_real_escape_string($conn, $userId);
    $productName = mysqli_real_escape_string($conn, $productName);
    $quantity = intval($quantity);
    
    $query = "UPDATE cart SET quantity = '$quantity' 
              WHERE user_id = '$userId' AND product_name = '$productName'";
    return mysqli_query($conn, $query);
}

// Function to remove cart item
function removeCartItem($userId, $productName) {
    global $conn;
    
    $userId = mysqli_real_escape_string($conn, $userId);
    $productName = mysqli_real_escape_string($conn, $productName);
    
    $query = "DELETE FROM cart WHERE user_id = '$userId' AND product_name = '$productName'";
    return mysqli_query($conn, $query);
}

// Get cart items endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_cart') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }
    
    $cartItems = loadCartItems($_SESSION['user_id']);
    echo json_encode(['items' => $cartItems]);
    exit;
}

// Update cart item endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['user_id']) || !isset($data['product_name']) || !isset($data['quantity'])) {
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
    
    $success = updateCartItem($_SESSION['user_id'], $data['product_name'], $data['quantity']);
    echo json_encode(['success' => $success]);
    exit;
}

// Remove cart item endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'remove') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['user_id']) || !isset($data['product_name'])) {
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
    
    $success = removeCartItem($_SESSION['user_id'], $data['product_name']);
    echo json_encode(['success' => $success]);
    exit;
}

// Close connection
mysqli_close($conn);
?>