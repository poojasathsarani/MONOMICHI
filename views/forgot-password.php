<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Validate if the email exists in the database (pseudo-code)
    $user = getUserByEmail($email); // Retrieve user from the database
    
    if ($user) {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(50));
        
        // Store the token in the database with an expiration time (e.g., 1 hour)
        savePasswordResetToken($email, $token); 
        
        // Create reset link
        $resetLink = "https://yourdomain.com/reset-password.php?token=$token";
        
        // Send the email
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n$resetLink";
        $headers = "From: no-reply@yourdomain.com";

        // Use PHP's mail function or a library like PHPMailer to send the email
        if (mail($email, $subject, $message, $headers)) {
            echo "An email with a reset link has been sent to your email address.";
        } else {
            echo "There was an error sending the email. Please try again.";
        }
    } else {
        echo "The email address you entered is not registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Forgot Password Form Section -->
    <section class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-lg mx-auto bg-white shadow-lg shadow-pink-600 border-4 border-pink-200 rounded-lg p-8">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Forgot Your Password?</h2>
            <p class="text-center text-gray-600 mb-6">Enter your email address, and we will send you a link to reset your password.</p>

            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-lg text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>

                <button type="submit" class="w-full py-3 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300 ease-in-out">Send Reset Link</button>
            </form>
        </div>
    </section>

</body>
</html>
