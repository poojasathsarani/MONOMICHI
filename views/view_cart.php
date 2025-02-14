<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id'])) {
    echo "<p class='text-gray-500 text-center'>Please log in to view your cart.</p>";
    exit;
}

$user_id = $_SESSION['id'];

$query = "SELECT c.*, p.image, p.productname, p.price 
          FROM cart c 
          LEFT JOIN Products p ON c.product_id = p.productid 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-gray-500 text-center'>Your cart is empty.</p>";
    exit;
}

$total = 0;

echo "<div class='p-4 bg-white shadow-md rounded-lg'>";

while ($item = $result->fetch_assoc()) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    
    echo "
    <div class='flex items-center justify-between border-b pb-2 mb-2'>
        <img src='{$item['image']}' class='w-16 h-16 rounded object-cover' alt='{$item['productname']}'>
        <div class='flex-1 mx-4'>
            <p class='font-semibold text-gray-800'>{$item['productname']}</p>
            <p class='text-gray-600 text-sm'>Rs. {$item['price']} × {$item['quantity']} = Rs. " . number_format($subtotal, 2) . "</p>
        </div>
        <div class='flex items-center space-x-2'>
            <button class='update-quantity bg-gray-300 text-gray-700 px-3 py-1 rounded-full' data-id='{$item['product_id']}' data-action='decrease'>−</button>
            <span class='font-medium text-gray-800'>{$item['quantity']}</span>
            <button class='update-quantity bg-gray-300 text-gray-700 px-3 py-1 rounded-full' data-id='{$item['product_id']}' data-action='increase'>+</button>
            <button class='remove-item bg-red-500 text-white px-3 py-1 rounded-full' data-id='{$item['product_id']}'>🗑️</button>
        </div>
    </div>";
}

echo "
<div class='mt-4 border-t pt-4 text-right'>
    <p class='text-lg font-bold text-gray-800'>Total: Rs. " . number_format($total, 2) . "</p>
    <a href='checkout.php' class='mt-4 inline-block bg-green-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-green-300 transition'>
        Proceed to Checkout
    </a>
    <button id='clear-cart' class='mt-2 bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-red-300 transition'>
        Clear Cart
    </button>
</div>";

echo "</div>";
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Remove Single Item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');

            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + productId
            })
            .then(response => response.text())
            .then(data => {
                location.reload(); // Reload cart
            });
        });
    });

    // Clear Cart
    document.getElementById('clear-cart').addEventListener('click', function () {
        fetch('clear_cart.php', { method: 'POST' })
        .then(response => response.text())
        .then(data => {
            location.reload(); // Reload cart
        });
    });
});
</script>
