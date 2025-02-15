<?php
session_start();
require "db_connection.php";

if (!isset($_SESSION['id'])) {
    echo "<p>Please log in to view your wishlist.</p>";
    exit();
}

$user_id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Your wishlist is empty.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='flex justify-between items-center mb-4'>
            <div class='flex items-center'>
                <img src='{$row['product_image']}' width='100' class='mr-4'>
                <div>
                    <h4 class='font-semibold'>{$row['product_name']}</h4>
                    <p class='text-sm text-gray-600'>Rs. {$row['product_price']}</p>
                </div>
            </div>
            <div class='flex space-x-2'>
                <button class='bg-pink-300 text-white py-2 px-4 rounded hover:bg-pink-700 remove-from-wishlist' 
                    data-id='{$row['id']}'>
                    Remove
                </button>
                <button class='bg-blue-300 text-white py-2 px-4 rounded hover:bg-blue-700 add-to-cart-from-wishlist flex items-center space-x-2' 
                    data-id='{$row['id']}'
                    data-name='{$row['product_name']}' 
                    data-price='{$row['product_price']}' 
                    data-img='{$row['product_image']}'>
                    <i class='fas fa-shopping-cart'></i>
                </button>
            </div>
        </div><hr>";
    }
}

$stmt->close();
$conn->close();
?>
