<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Styles for the FAQ Page */
        .accordion-item {
            border: 2px solid #ddd;
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .accordion-item:hover {
            transform: scale(1.05);
            border-color: #ff7b9f;
        }

        .accordion-button {
            background-color: #f8f8f8;
            padding: 16px;
            font-size: 1.125rem;
            font-weight: 600;
            color: #333;
            text-align: left;
            width: 100%;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #ff7b9f;
            color: white;
        }

        .accordion-content {
            padding: 16px;
            background-color: #f1f1f1;
            display: none;
            border-radius: 0 0 10px 10px;
        }

        .accordion-button.active + .accordion-content {
            display: block;
        }

        .icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .accordion-button.active .icon {
            transform: rotate(180deg);
        }
    </style>
    <script>
        // Function to handle the accordion toggle
        function toggleFAQ(event) {
            const button = event.target;
            const content = button.nextElementSibling;
            const allButtons = document.querySelectorAll('.accordion-button');
            const allContents = document.querySelectorAll('.accordion-content');
            
            allButtons.forEach(btn => btn.classList.remove('active'));
            allContents.forEach(content => content.style.display = 'none');
            
            if (button !== event.target) {
                button.classList.add('active');
                content.style.display = 'block';
            } else {
                button.classList.toggle('active');
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            }
        }
    </script>
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

    <!-- FAQ Section -->
    <section id="faq" class="container mx-auto py-16 px-6">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Frequently Asked Questions</h2>

        <div class="max-w-3xl mx-auto">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/faq.png" alt="FAQ Icon" class="icon">
                    What is MONOMICHI?
                </button>
                <div class="accordion-content">
                    <p>MONOMICHI is an online platform where you can explore and purchase authentic Japanese products. We offer everything from traditional items to modern pop-culture collectibles and everything in between.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/order-history.png" alt="Order Icon" class="icon">
                    How do I place an order?
                </button>
                <div class="accordion-content">
                    <p>Simply browse our collection, add your favorite products to the shopping cart, and proceed to checkout. Follow the steps to enter shipping information and securely make your payment.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/globe.png" alt="Shipping Icon" class="icon">
                    Do you ship internationally?
                </button>
                <div class="accordion-content">
                    <p>Yes, we ship worldwide! You can select your country during the checkout process, and we will show you the available shipping options and costs.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/track-order.png" alt="Tracking Icon" class="icon">
                    How can I track my order?
                </button>
                <div class="accordion-content">
                    <p>Once your order has been dispatched, you will receive an email with a tracking number. Use this number on the carrier's website to track the progress of your shipment.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/refund.png" alt="Return Icon" class="icon">
                    What is your return policy?
                </button>
                <div class="accordion-content">
                    <p>We offer a 30-day return policy on most items. Please refer to our return policy page for more information, including any exceptions and how to start the return process.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPBbimt5KS7Qj_m6sgssAx_PRD2swwigYXQQ&s" alt="Security Icon" class="icon">
                    Is my payment information secure?
                </button>
                <div class="accordion-content">
                    <p>Yes, we use industry-standard encryption to protect your payment details. All transactions are securely processed through trusted payment gateways.</p>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://www.pngitem.com/pimgs/m/325-3256269_packaging-white-icon-png-png-download-packaging-black.png" alt="Packaging Icon" class="icon">
                    How are the products packaged?
                </button>
                <div class="accordion-content">
                    <p>We take great care in packaging our products securely to ensure they arrive in perfect condition. Fragile items are packed with extra padding to prevent damage during transit.</p>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://static.vecteezy.com/system/resources/previews/017/314/782/non_2x/an-amazing-icon-of-payment-easy-to-use-and-download-vector.jpg" alt="Payment Icon" class="icon">
                    What payment methods do you accept?
                </button>
                <div class="accordion-content">
                    <p>We accept a variety of payment methods including credit cards (Visa, MasterCard, American Express), PayPal, and local payment options depending on your region.</p>
                </div>
            </div>

            <!-- FAQ Item 9 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/phone.png" alt="Phone Icon" class="icon">
                    Can I contact customer support via phone?
                </button>
                <div class="accordion-content">
                    <p>Yes, you can contact our customer support team by phone. Visit our "Contact Us" page for our customer support phone number and working hours.</p>
                </div>
            </div>

            <!-- FAQ Item 10 -->
            <div class="accordion-item">
                <button class="accordion-button flex items-center" onclick="toggleFAQ(event)">
                    <img src="https://img.icons8.com/ios-filled/50/000000/clock.png" alt="Hours Icon" class="icon">
                    What are your business hours?
                </button>
                <div class="accordion-content">
                    <p>Our online store is open 24/7. Our customer support team is available from Monday to Friday, 9 AM to 5 PM (Local Time).</p>
                </div>
            </div>

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