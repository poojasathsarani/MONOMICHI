<?php
include('db_connection.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

// Get all categories
$sqlCategories = "SELECT * FROM Categories";
$resultCategories = $conn->query($sqlCategories);

$categories = [];

while ($category = $resultCategories->fetch_assoc()) {
    $categoryId = $category['categoryid'];

    // Get subcategories for each category
    $sqlSubcategories = "SELECT * FROM Subcategories WHERE categoryid = $categoryId";
    $resultSubcategories = $conn->query($sqlSubcategories);

    $subcategories = [];
    while ($subcategory = $resultSubcategories->fetch_assoc()) {
        $subcategoryId = $subcategory['subcategoryid'];

        // Get products under each subcategory
        $sqlProducts = "SELECT * FROM Products WHERE subcategoryid = $subcategoryId";
        $resultProducts = $conn->query($sqlProducts);

        $products = [];
        while ($product = $resultProducts->fetch_assoc()) {
            $products[] = $product;
        }

        $subcategory['products'] = $products;
        $subcategories[] = $subcategory;
    }

    $category['subcategories'] = $subcategories;
    $categories[] = $category;
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($categories);
?>