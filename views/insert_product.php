<?php
include('db_connection.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

// Get posted data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$required_fields = ['productname', 'category', 'price', 'stock', 'imagePath'];
$missing_fields = [];

foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo json_encode([
        'success' => false,
        'error' => 'Missing required fields: ' . implode(', ', $missing_fields)
    ]);
    exit;
}

try {
    // Fetch category_id based on category name
    $categoryQuery = "SELECT category_id FROM categories WHERE category_name = ?";
    $stmt = $conn->prepare($categoryQuery);
    $stmt->bind_param("s", $data['category']);
    $stmt->execute();
    $categoryResult = $stmt->get_result();
    
    if ($categoryResult->num_rows === 0) {
        throw new Exception("Invalid category: " . $data['category']);
    }
    
    $categoryRow = $categoryResult->fetch_assoc();
    $category_id = $categoryRow['category_id'];

    // Insert product
    $sql = "INSERT INTO products (product_name, category_id, price, stock, image, description, weight, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $description = isset($data['description']) ? $data['description'] : '';
    $weight = isset($data['weight']) ? $data['weight'] : 0;
    $status = isset($data['status']) ? $data['status'] : 'available';
    
    $stmt->bind_param("siddssds", 
        $data['productname'],
        $category_id,
        $data['price'],
        $data['stock'],
        $data['imagePath'],  
        $description,
        $weight,
        $status
    );
    
    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Product added successfully',
        'productId' => $conn->insert_id
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

// Close the statement and connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>