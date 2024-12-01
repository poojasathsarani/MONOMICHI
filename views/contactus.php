<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-serif">
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

            <!-- Hamburger Menu Button -->
            <button id="menu-btn" class="lg:hidden block text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Navigation Links -->
            <nav id="menu" class="hidden lg:flex space-x-10 items-center">
                <a href="../index.php" class="text-gray-600 hover:text-pink-600 text-lg">HOME</a>
                <a href="../views/products.php" class="text-gray-600 hover:text-pink-600 text-lg">PRODUCTS</a>
                <a href="../views/services.php" class="text-gray-600 hover:text-pink-600 text-lg">SERVICES</a>
                <a href="../views/faqs.php" class="text-gray-600 hover:text-pink-600 text-lg">FAQs</a>
                <a href="../views/contactus.php" class="text-gray-600 hover:text-pink-600 text-lg">CONTACT US</a>
                <a href="../views/aboutus.php" class="text-gray-600 hover:text-pink-600 text-lg">ABOUT US</a>
            </nav>

            <!-- Right Navigation -->
            <div class="hidden lg:flex space-x-6">
                <a href="../views/signup.php" class="bg-pink-600 border-pink-600 text-white hover:bg-white hover:text-pink-600 py-2 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105">Sign Up</a>
                <a href="../views/login.php" class="bg-white border-2 border-pink-600 text-pink-600 py-2 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out transform hover:bg-pink-600 hover:text-white hover:scale-105">Log In</a>
            </div>
        </div>

        <!-- Dropdown for Mobile -->
        <div id="mobile-menu" class="hidden bg-red-50 lg:hidden">
            <a href="../index.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">HOME</a>
            <a href="../views/products.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">PRODUCTS</a>
            <a href="../views/services.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">SERVICES</a>
            <a href="../views/faqs.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">FAQs</a>
            <a href="../views/contactus.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">CONTACT US</a>
            <a href="../views/aboutus.php" class="block px-4 py-2 text-gray-600 hover:text-pink-600">ABOUT US</a>
            <div class="mt-4 px-4">
                <a href="../views/register.php" class="block bg-pink-600 text-white text-center py-2 rounded-full mb-2">Sign Up</a>
                <a href="../views/login.php" class="block bg-white border-2 border-pink-600 text-pink-600 text-center py-2 rounded-full">Log In</a>
            </div>
        </div>
    </header>

    <!-- Contact Section -->
    <section class="container mx-auto py-16 px-6">
        <h2 class="text-4xl font-bold text-center text-gray-800">Contact Us</h2>
        <p class="text-lg text-center text-gray-600 mt-4 max-w-3xl mx-auto">
            We'd love to hear from you! Whether you have a question about our products, services, or anything else, feel free to reach out.
        </p>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-lg shadow-xl">
                <h3 class="text-2xl font-semibold text-gray-800">Send Us a Message</h3>
                <form action="#" method="POST" class="mt-6">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Your Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your name here" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Your Email</label>
                        <input type="email" id="email" name="email" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your email here" required>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="block text-gray-700">Your Message</label>
                        <textarea id="message" name="message" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" rows="6" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="bg-pink-600 text-white py-2 px-6 rounded-full hover:bg-pink-700 transition duration-300">Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="bg-white p-8 rounded-lg shadow-xl">
                <h3 class="text-2xl font-semibold text-gray-800">Our Contact Information</h3>
                <p class="text-gray-600 mt-4">
                    If you'd like to get in touch with us, here are some ways you can contact our team.
                </p>

                <div class="mt-6">
                    <p class="text-gray-700"><strong>Address:</strong>Colombo, Sri Lanka</p>
                    <p class="text-gray-700 mt-4"><strong>Email:</strong> <a href="mailto:contact@monomichi.com" class="text-pink-600 hover:underline">contact@monomichi.com</a></p>
                    <p class="text-gray-700 mt-4"><strong>Phone:</strong> +94 764 730521</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <section class="container mx-auto py-16 px-6">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Our Location</h3>
        <div class="mt-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12812.276726140686!2d139.69825!3d35.69849!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d2c5f0153df%3A0x65bcf8d01a35413e!2sShibuya%20Station!5e0!3m2!1sen!2sjp!4v1662099789172!5m2!1sen!2sjp" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
</body>
</html>
