<?php
// insert_product.php - Insert product into the database

include('db_connection.php'); // Include the database connection file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve JSON data from the POST request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Get the product details from the request
    $productname = $data['productname'];
    $category = $data['category'];
    $price = $data['price'];
    $image = $data['image'];
    $stock = $data['stock'];
    $description = $data['description'];
    $brand = $data['brand'];
    $weight = $data['weight'];
    $sku = $data['sku'];
    $status = $data['status'];

    // Prepare the SQL query to insert data into the products table
    $stmt = $conn->prepare("INSERT INTO products (productname, category, price, image, stock, description, brand, weight, sku, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("ssdsssssds", $productname, $category, $price, $image, $stock, $description, $brand, $weight, $sku, $status);

    // Execute the query
    if ($stmt->execute()) {
        // Send a response with the success message
        echo json_encode(["message" => "Product added successfully"]);
    } else {
        // Send a response with an error message
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
} else {
    // If the method is not POST, send an error response
    echo json_encode(["message" => "Invalid request method"]);
}
?>
