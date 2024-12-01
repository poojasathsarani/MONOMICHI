<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data into variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // For now, just check if both email and password are not empty.
    if (!empty($email) && !empty($password)) {
        // Assuming user is authenticated successfully
        $_SESSION['user'] = [
            'email' => $email,
            'name' => 'User Name'
        ];
        
        // Redirect to the dashboard
        header('Location: userdashboard.php');
        exit();
    } else {
        // Handle authentication failure
        echo "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-serif">

    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <img src="../images/logo.png" alt="MONOMICHI Logo" class="h-16 w-16 mr-2">
                    MONOMICHI
                </h1>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex space-x-10 items-center">
                <a href="../index.php" class="text-gray-600 hover:text-pink-600 text-lg">HOME</a>
                <a href="../views/products.php" class="text-gray-600 hover:text-pink-600 text-lg">PRODUCTS</a>
                <a href="../views/services.php" class="text-gray-600 hover:text-pink-600 text-lg">SERVICES</a>
                <a href="../views/faqs.php" class="text-gray-600 hover:text-pink-600 text-lg">FAQs</a>
                <a href="../views/contactus.php" class="text-gray-600 hover:text-pink-600 text-lg">CONTACT US</a>
                <a href="../views/aboutus.php" class="text-gray-600 hover:text-pink-600 text-lg">ABOUT US</a>
            </nav>

            <!-- Right Navigation -->
            <?php
                // Check if the session has already started to avoid calling session_start() multiple times
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                ?>
                <div class="hidden lg:flex space-x-6">
                    <?php
                    if (isset($_SESSION['user'])) {
                        // If the user is logged in, show the profile icon
                        echo '<a href="profile.php" class="flex items-center text-pink-600 hover:text-pink-700 text-lg">';
                        echo '<img src="../images/profile-icon.png" alt="Profile" class="h-8 w-8 rounded-full mr-2">';
                        echo $_SESSION['user']['name']; // Display the user's name or you can display only the icon
                        echo '</a>';
                    } else {
                        // If the user is not logged in, show login and signup buttons
                        echo '<a href="../views/signup.php" class="bg-pink-600 border-pink-600 text-white hover:bg-white hover:text-pink-600 py-2 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105">Sign Up</a>';
                        echo '<a href="../views/login.php" class="bg-white border-2 border-pink-600 text-pink-600 py-2 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out transform hover:bg-pink-600 hover:text-white hover:scale-105">Log In</a>';
                    }
                    ?>
                </div>
        </div>
    </header>

    <!-- Login Form Section -->
    <section class="min-h-screen flex items-center justify-center bg-gray-100 relative">
        <!-- Background Video -->
        <video autoplay loop muted class="absolute inset-0 w-full h-full object-cover z-0" style="filter: blur(2px);">
            <source src="../images/sakura.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Form Container -->
        <div class="max-w-lg mx-auto bg-white shadow-lg shadow-pink-600 border-4 border-pink-200 rounded-lg p-8 z-10 relative">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Log In</h2>
            <form action="#" method="POST" onsubmit="return saveCredentials()">
                <div class="mb-4">
                    <label for="email" class="block text-lg text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-lg text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
                </div>

                <div class="flex justify-between items-center mb-6 space-x-20">
                    <div>
                        <input type="checkbox" id="remember" name="remember" class="mr-2">
                        <label for="remember" class="text-gray-700">Remember Me</label>
                    </div>
                    <a href="forgot-password.php" class="text-pink-600 hover:text-pink-700">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300 ease-in-out">Log In</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 py-10 text-gray-700">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Here For You Section -->
                <div>
                    <h5 class="font-semibold text-lg mb-4">HERE FOR YOU</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../views/contactus.php" class="hover:text-pink-600">Contact Us</a></li>
                        <li><a href="#" class="hover:text-pink-600">Track your parcel</a></li>
                        <li><a href="#" class="hover:text-pink-600">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Informations Section -->
                <div>
                    <h5 class="font-semibold text-lg mb-4">INFORMATIONS</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../views/blog.php" class="hover:text-pink-600">Blog</a></li>
                        <li><a href="../views/products.php" class="hover:text-pink-600">All Our Products</a></li>
                        <li><a href="../views/aboutus.php" class="hover:text-pink-600">About Us</a></li>
                        <li><a href="#" class="hover:text-pink-600">About Shipping</a></li>
                        <li><a href="#" class="hover:text-pink-600">Terms and Conditions of Sale</a></li>
                    </ul>
                </div>

                <!-- Other Stores Section -->
                <div>
                    <h5 class="font-semibold text-lg mb-4">OTHER STORES</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-pink-600">Tableware Wholesale</a></li>
                        <li><a href="#" class="hover:text-pink-600">Totoro Store</a></li>
                        <li><a href="#" class="hover:text-pink-600">Shaved Ice Machines Store</a></li>
                        <li><a href="#" class="hover:text-pink-600">Japanese Cookware Store</a></li>
                        <li><a href="#" class="hover:text-pink-600">Japanese Socks Store</a></li>
                    </ul>
                </div>

                <!-- Newsletter Section -->
                <div>
                    <h5 class="font-semibold text-lg mb-4">NEWSLETTER</h5>
                    <p class="text-sm mb-4">Is it your first order? Join our newsletter and get 5% OFF! Receive information about new arrivals, future events, and specials.</p>
                    <form action="#" method="POST">
                        <input type="email" placeholder="Enter your email address" class="py-2 px-4 rounded-l-lg border border-gray-300 w-full mb-4" required>
                        <button type="submit" class="bg-pink-600 text-white py-2 px-4 rounded-r-lg hover:bg-pink-700">SUBSCRIBE!</button>
                    </form>
                </div>
            </div>

            <!-- Social Media Links Section -->
            <div class="text-center mt-8">
                <a href="https://www.facebook.com" class="text-gray-700 hover:text-pink-600 mx-4">Facebook</a>
                <a href="https://www.instagram.com" class="text-gray-700 hover:text-pink-600 mx-4">Instagram</a>
                <a href="https://www.twitter.com" class="text-gray-700 hover:text-pink-600 mx-4">Twitter</a>
                <a href="https://www.pinterest.com" class="text-gray-700 hover:text-pink-600 mx-4">Pinterest</a>
                <a href="https://www.youtube.com" class="text-gray-700 hover:text-pink-600 mx-4">YouTube</a>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-8 text-sm">
                <p>&copy; 2024 MONOMICHI online store since 2024. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
    // Check if email and password are saved in cookies
    window.onload = function() {
        if (getCookie("email") && getCookie("password")) {
            document.getElementById("email").value = getCookie("email");
            document.getElementById("password").value = getCookie("password");
            document.getElementById("remember").checked = true;
        }
    };

    // Save email and password to cookies if "Remember Me" is checked
    function saveCredentials() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var remember = document.getElementById("remember").checked;

        if (remember) {
            setCookie("email", email, 7); // Save email for 7 days
            setCookie("password", password, 7); // Save password for 7 days
        } else {
            // Remove cookies if Remember Me is not checked
            setCookie("email", "", -1);
            setCookie("password", "", -1);
        }
        return true; // Continue form submission
    }

    // Helper function to set cookies
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Helper function to get cookies
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
</script>
</body>
</html>
