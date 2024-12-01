<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Japanese-inspired pattern backgrounds */
        .pattern-bg {
            background: url('https://i.imgur.com/LJDqFJw.png');
            background-size: cover;
            background-attachment: fixed;
        }

        /* Calligraphy-style heading */
        .calligraphy {
            font-family: 'Dancing Script', cursive;
        }

        /* Scroll-container styling */
        .scroll-container {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #d97706;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Button animation */
        .btn-animate:hover {
            transform: scale(1.1);
            background-color: #fbbf24;
        }
    </style>
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

    <!-- About Us Section -->
    <section id="about" class="py-16 px-6 bg-gradient-to-br from-yellow-50 to-red-100">
        <div class="container mx-auto scroll-container">
            <h2 class="text-4xl font-bold text-center text-gray-800 calligraphy">About Us</h2>
            <p class="text-lg text-center text-gray-600 mt-4 max-w-3xl mx-auto">
                At MONOMICHI, we bring Japan to your doorstep, celebrating its culture, creativity, and craftsmanship. From traditional items to modern pop culture, our carefully curated collections connect you to the spirit of Japan.
            </p>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="py-16 px-6 bg-white">
        <div class="container mx-auto text-center">
            <h3 class="text-3xl font-semibold text-gray-800 calligraphy">Our Journey</h3>
            <div class="mt-8 space-y-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center">
                        2022
                    </div>
                    <p class="text-lg text-gray-600">Founded MONOMICHI to share Japanese traditions worldwide.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center">
                        2023
                    </div>
                    <p class="text-lg text-gray-600">Launched our first exclusive collection for cherry blossom season.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center">
                        2024
                    </div>
                    <p class="text-lg text-gray-600">Expanded to include unique artisanal items from across Japan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="container mx-auto py-16 px-6 bg-gray-50">
        <h2 class="text-3xl font-semibold text-center text-gray-800 calligraphy">Meet Our Team</h2>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105">
                <div class="overflow-hidden rounded-full mx-auto w-32 h-32">
                    <img src="../images/maami.jpeg" alt="Team Member 1" class="object-cover w-full h-full">
                </div>
                <h4 class="mt-4 font-semibold text-gray-800">Chandima Kusumthilaka</h4>
                <p class="text-gray-600">Founder & CEO</p>
            </div>
            <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105">
                <div class="overflow-hidden rounded-full mx-auto w-32 h-32">
                    <img src="../images/my.jpg" alt="Team Member 2" class="object-cover w-full h-full">
                </div>
                <h4 class="mt-4 font-semibold text-gray-800">Pooja Sathsarani</h4>
                <p class="text-gray-600">Creative Director</p>
            </div>
            <div class="text-center bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105">
                <div class="overflow-hidden rounded-full mx-auto w-32 h-32">
                    <img src="../images/nendi.jpg" alt="Team Member 3" class="object-cover w-full h-full">
                </div>
                <h4 class="mt-4 font-semibold text-gray-800">Thanuja Maduwanthi</h4>
                <p class="text-gray-600">Product Manager</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-gradient-to-bl from-pink-500 to-red-200 text-white py-16 px-6">
        <div class="container mx-auto text-center">
            <h3 class="text-3xl font-semibold calligraphy">Get in Touch</h3>
            <p class="text-lg mt-4 max-w-2xl mx-auto">
                Have questions? Let us know how we can help!
            </p>
            <a href="mailto:contact@monomichi.com" class="mt-8 inline-block bg-white text-black font-bold py-3 px-8 rounded-full transition-transform transform hover:scale-110">
                Contact Us
            </a>
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
