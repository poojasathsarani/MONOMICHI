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
                    <!-- Card Number -->
                    <div class='mb-4'>
                        <label for='card-number' class='block text-gray-700'>Card Number</label>
                        <input type='text' id='card-number' name='card-number' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg'
                            required 
                            pattern='\\d{16}'
                            title='Card number must be 16 digits'>
                    </div>
                    
                    <!-- Cardholder Name -->
                    <div class='mb-4'>
                        <label for='card-name' class='block text-gray-700'>Cardholder Name</label>
                        <input type='text' id='card-name' name='card-name' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            required 
                            pattern='[A-Z\\s]+|[\\p{Script=Sinhala}\\s]+|[\\p{Script=Tamil}\\s]+' 
                            title='Name must contain only letters and spaces (English, Sinhala, or Tamil allowed)'>
                    </div>
                    
                    <!-- Expiry Date -->
                    <div class='mb-4'>
                        <label for='expiry' class='block text-gray-700'>Expiry Date</label>
                        <input type='text' id='expiry' name='expiry' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            placeholder='MM/YY' 
                            required 
                            pattern='(0[1-9]|1[0-2])/\\d{2}' 
                            title='Expiry date must be in the format MM/YY'>
                    </div>
                    
                    <!-- CVV -->
                    <div class='mb-4'>
                        <label for='cvv' class='block text-gray-700'>CVV</label>
                        <input type='text' id='cvv' name='cvv' 
                            class='w-full px-4 py-2 border border-gray-300 rounded-lg' 
                            required 
                            pattern='\\d{3}' 
                            title='CVV must be a 3-digit number'>
                    </div>
                    
                    <!-- Submit Button -->
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
        // Validate the form before submitting
        function validateForm() {
            // Card Number Validation (16 digits)
            var cardNumber = document.getElementById("card-number").value;
            var cardNumberRegex = /^\d{16}$/;
            if (!cardNumberRegex.test(cardNumber)) {
                alert("Card number must be 16 digits.");
                return false;
            }

            // Cardholder Name Validation (English, Sinhala, or Tamil allowed)
            var cardName = document.getElementById("card-name").value;
            var cardNameRegex = /^[A-Z\s]+$|^[\p{Script=Sinhala}\s]+$|^[\p{Script=Tamil}\s]+$/;
            if (!cardNameRegex.test(cardName)) {
                alert("Cardholder name must contain only letters and spaces (English, Sinhala, or Tamil allowed).");
                return false;
            }

            // Expiry Date Validation (MM/YY format)
            var expiry = document.getElementById("expiry").value;
            var expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryRegex.test(expiry)) {
                alert("Expiry date must be in the format MM/YY.");
                return false;
            }

            // CVV Validation (3 digits)
            var cvv = document.getElementById("cvv").value;
            var cvvRegex = /^\d{3}$/;
            if (!cvvRegex.test(cvv)) {
                alert("CVV must be a 3-digit number.");
                return false;
            }

            // If all validations pass, show success message and redirect
            showSuccessMessage();
            return true;
        }

        // Function to display popup and redirect
        function showSuccessMessage() {
            alert('Payment Success! Redirecting to Checkout...');
            setTimeout(function() {
                // After payment success, redirect back to checkout
                header('Location: checkout.php');
                exit;
            }, 2000); // 2-second delay before redirect
        }
    </script>
</body>
</html>
