<?php
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

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a token
        $token = bin2hex(random_bytes(50));

        // Save token to the database with a 1-hour expiration
        $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $stmt = $conn->prepare("REPLACE INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expiresAt);
        $stmt->execute();

        // Send verification email
        if (sendVerificationEmail($email, $token)) {
            echo "A verification email has been sent to your email address.";
        } else {
            echo "Error sending the email. Please try again.";
        }
    } else {
        echo "The email address is not registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function validateEmail() {
            const email = document.getElementById("email").value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="bg-gray-100 relative">
    <!-- Forgot Password Form Section -->
    <section class="min-h-screen flex items-center justify-center relative">
        <!-- Background Video -->
        <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover z-0" style="filter: blur(2px);">
            <source src="../images/bg4.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Form Container -->
        <div class="relative max-w-lg mx-auto bg-white shadow-lg shadow-pink-600 border-4 border-pink-200 rounded-lg p-8 z-10">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Forgot Your Password?</h2>
            <p class="text-center text-gray-600 mb-6">Enter your email address, and we will send you a link to verify your email and reset your password.</p>

            <form method="POST" action="forgot-password.php">
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
