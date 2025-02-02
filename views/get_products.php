<?php
// get_products.php - Retrieve products from the database

include('db_connection.php'); // Include the database connection file

// Prepare the SQL query to select all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if any products were found
if ($result->num_rows > 0) {
    // Fetch all products into an array
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    // Send the products as a JSON response
    echo json_encode($products);
} else {
    // If no products found, send a message
    echo json_encode(["message" => "No products found"]);
}

// Close the connection
$conn->close();
?>
