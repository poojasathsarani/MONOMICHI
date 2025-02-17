<?php
// Include database connection
require_once 'db_connection.php'; // Ensure this includes a proper DB connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user_id from session (assuming user is logged in)
    session_start();
    if (!isset($_SESSION['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in.'
        ]);
        exit;
    }

    $user_id = $_SESSION['id'];

    // Validate required fields
    $required_fields = ['full-name', 'address', 'city', 'postal-code', 'country', 'payment-method'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('-', ' ', $field)) . " is required";
        }
    }

    if (empty($errors)) {
        // Sanitize inputs
        $full_name = $conn->real_escape_string($_POST['full-name']);
        $address = $conn->real_escape_string($_POST['address']);
        $city = $conn->real_escape_string($_POST['city']);
        $postal_code = $conn->real_escape_string($_POST['postal-code']);
        $country = $conn->real_escape_string($_POST['country']);
        $payment_method = $conn->real_escape_string($_POST['payment-method']);

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert order into orders table
            $query = "INSERT INTO orders (user_id, full_name, address, city, postal_code, country, payment_method) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issssss", $user_id, $full_name, $address, $city, $postal_code, $country, $payment_method);

            if (!$stmt->execute()) {
                throw new Exception("Failed to insert order.");
            }

            $order_id = $conn->insert_id;

            // Fetch cart items for the user
            $cart_query = "SELECT cart.cart_id, cart.product_id, cart.quantity, cart.price, products.stock 
                        FROM cart 
                        JOIN products ON cart.product_id = products.productid
                        WHERE cart.user_id = ?";

            $stmt = $conn->prepare($cart_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $cart_items = $stmt->get_result();

            // Insert each product into order_details and update stock
            while ($item = $cart_items->fetch_assoc()) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                // Insert order details
                $order_details_query = "INSERT INTO order_details (id, product_id, quantity, price) 
                                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($order_details_query);
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);

                if (!$stmt->execute()) {
                    throw new Exception("Failed to insert order details.");
                }

                // Update product stock
                $new_stock = $item['stock'] - $quantity;
                if ($new_stock < 0) {
                    throw new Exception("Not enough stock for product: " . $product_id);
                }

                $update_product_query = "UPDATE products SET stock = ? WHERE productid = ?";
                $stmt = $conn->prepare($update_product_query);
                $stmt->bind_param("ii", $new_stock, $product_id);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update product stock.");
                }
            }

            // Remove items from the cart
            $delete_cart_query = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($delete_cart_query);
            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to clear cart.");
            }

            // Commit the transaction
            $conn->commit();

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order_id
            ]);
            exit;

        } catch (Exception $e) {
            // Rollback the transaction in case of any error
            $conn->rollback();

            // Return error message
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Validation errors.',
            'errors' => $errors
        ]);
        exit;
    }
}
?>
