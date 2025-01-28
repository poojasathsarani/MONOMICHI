<?php
// Include database connection
include('db_connection.php');

// Function to send verification email
function sendVerificationEmail($email, $token) {
    $verificationLink = "https://yourdomain.com/verify-email.php?token=$token";
    $subject = "Email Verification for Password Reset";
    $message = "Please click the link below to verify your email and reset your password:\n\n$verificationLink";
    $headers = "From: no-reply@yourdomain.com";
    
    return mail($email, $subject, $message, $headers);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate if the email exists in the database
    $user = getUserByEmail($email); // Replace with your actual database query function
    
    if ($user) {
        // Generate a unique token for email verification
        $token = bin2hex(random_bytes(50));
        
        // Store the token in the database with an expiration time (e.g., 1 hour)
        savePasswordResetToken($email, $token); // Replace with your actual function to save the token
        
        // Send email with verification link
        if (sendVerificationEmail($email, $token)) {
            echo "A verification email has been sent to your email address. Please check your inbox.";
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
            <p class="text-center text-gray-600 mb-6">Enter your email address, and we will send you a link to verify your email and reset your password.</p>

            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-lg text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>

                <button type="submit" class="w-full py-3 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300 ease-in-out">Send Verification Link</button>
            </form>
        </div>
    </section>

</body>
</html>
