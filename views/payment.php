<?php
session_start();
include 'db_connection.php'; // Ensure you have your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id']; // Ensure user is logged in and session contains user_id
    $full_name = $_POST['full-name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal-code'];
    $country = $_POST['country'];
    $payment_method = $_POST['payment-method'];

    if (empty($user_id) || empty($full_name) || empty($address) || empty($city) || empty($postal_code) || empty($country) || empty($payment_method)) {
        die("All fields are required.");
    }

    $sql = "INSERT INTO orders (user_id, full_name, address, city, postal_code, country, payment_method) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issssss", $user_id, $full_name, $address, $city, $postal_code, $country, $payment_method);
        
        if ($stmt->execute()) {
            echo "<script>alert('Order placed successfully!'); window.location.href='products.php';</script>";
        } else {
            echo "<script>alert('Error placing order. Please try again.'); window.location.href='checkout.php';</script>";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-lg border border-gray-300 rounded-lg p-8">
        <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Payment Details</h1>

        <?php
        $method = $_GET['method'] ?? 'unknown';
        if ($method === 'credit-card') {
            echo "
            <div>
                <h2 class='text-lg font-semibold mb-4'>Pay with Credit Card</h2>
                <form action='checkout.php' method='POST' onsubmit='return validateForm()'>
                    <div class='mb-4'>
                        <label for='card-number' class='block text-gray-700'>Card Number</label>
                        <input type='text' id='card-number' name='card-number' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg'
                            required 
                            pattern='\\d{16}'
                            title='Card number must be 16 digits'>
                    </div>
                    
                    <div class='mb-4'>
                        <label for='card-name' class='block text-gray-700'>Cardholder Name</label>
                        <input type='text' id='card-name' name='card-name' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            required>
                    </div>
                    
                    <div class='mb-4'>
                        <label for='expiry' class='block text-gray-700'>Expiry Date</label>
                        <input type='text' id='expiry' name='expiry' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            placeholder='MM/YY' 
                            required 
                            pattern='(0[1-9]|1[0-2])/\\d{2}' 
                            title='Expiry date must be in the format MM/YY'>
                    </div>
                    
                    <div class='mb-4'>
                        <label for='cvv' class='block text-gray-700'>CVV</label>
                        <input type='text' id='cvv' name='cvv' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            required 
                            pattern='\\d{3}' 
                            title='CVV must be a 3-digit number'>
                    </div>
                    
                    <button type='submit' 
                            class='w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600'>
                        Submit Payment
                    </button>
                </form>
            </div>
            ";
        } elseif ($method === 'paypal') {
            echo "
            <div>
                <h2 class='text-lg font-semibold mb-4'>Pay with PayPal</h2>
                <p class='text-gray-700 mb-6'>You will be redirected to PayPal to complete your payment.</p>
                <form action='checkout.php' method='POST'>
                    <button type='submit' class='w-full py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600'>Proceed to PayPal</button>
                </form>
            </div>
            ";
        } else {
            echo "<p class='text-red-500'>Invalid payment method selected.</p>";
        }
        ?>
    </div>

    <script>
        function validateForm() {
            var cardNumber = document.getElementById("card-number").value;
            var cardNumberRegex = /^\d{16}$/;
            if (!cardNumberRegex.test(cardNumber)) {
                alert("Card number must be 16 digits.");
                return false;
            }

            var cardName = document.getElementById("card-name").value;
            var cardNameRegex = /^[A-Za-z\s\u0D80-\u0DFF\u0B80-\u0BFF]+$/; // Supports Sinhala, Tamil, and English
            if (!cardNameRegex.test(cardName)) {
                alert("Cardholder name must contain only letters and spaces.");
                return false;
            }

            var expiry = document.getElementById("expiry").value;
            var expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryRegex.test(expiry)) {
                alert("Expiry date must be in the format MM/YY.");
                return false;
            }

            var cvv = document.getElementById("cvv").value;
            var cvvRegex = /^\d{3}$/;
            if (!cvvRegex.test(cvv)) {
                alert("CVV must be a 3-digit number.");
                return false;
            }

            alert('Payment Success! Redirecting to Checkout...');
            setTimeout(function() {
                window.location.href = 'checkout.php';
            }, 2000); 
            return false; 
        }
    </script>
</body>
</html>
