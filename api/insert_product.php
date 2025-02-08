<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Allow requests from all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // Allow certain methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers

if (!file_exists('../views/db_connection.php')) {
    echo json_encode(["error" => "Database connection file is missing"]);
    exit;
}

require '../views/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->productname) && !empty($data->category) && !empty($data->price) && !empty($data->stock) && !empty($data->image)) {
        $sql = "INSERT INTO products (productname, category, price, image, stock, description, weight, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsdsss", 
            $data->productname, 
            $data->category, 
            $data->price, 
            $data->image, 
            $data->stock, 
            $data->description, 
            $data->weight, 
            $data->status
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product added successfully"]);
        } else {
            echo json_encode(["error" => "Failed to add product"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "All fields are required"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
