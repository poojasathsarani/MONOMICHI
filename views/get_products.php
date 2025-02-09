<?php
include('../views/db_connection.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

try {
    $query = "SELECT * FROM products WHERE status = 'available' ORDER BY category, created_at DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }

    $groupedProducts = [];
    while ($product = mysqli_fetch_assoc($result)) {
        $category = $product['category'];
        if (!isset($groupedProducts[$category])) {
            $groupedProducts[$category] = [];
        }
        $groupedProducts[$category][] = $product;
    }

    echo json_encode(['success' => true, 'data' => $groupedProducts]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>