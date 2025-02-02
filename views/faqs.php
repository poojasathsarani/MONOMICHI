<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Ensure profile image is always a valid string
$userProfileImage = isset($_SESSION['profile_image']) && $_SESSION['profile_image'] !== null 
    ? $_SESSION['profile_image'] 
    : 'https://w7.pngwing.com/pngs/423/634/png-transparent-find-user-profile-person-avatar-people-account-search-general-pack-icon.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* cannot add the ::placeholder selector directly in the inline CSS because inline styles only apply to elements directly and do not support pseudo-elements like ::placeholder, ::before, ::after, or any other pseudo-selectors. */
        #search-bar::placeholder {
            color: #6B7280;
            font-weight: bold;
        }   

        /* Tailwind itself doesn’t support @keyframes or dynamic animations out-of-the-box for things like content changes, so you'll need to rely on regular CSS for that. */
        @keyframes typing {
            0% { opacity: 1; }
            25% { content: "Search products or categories..."; }
            50% { content: "Discover the best of Japan!"; }
            75% { content: "Find your favorite items!"; }
            100% { opacity: 1; }
        }

        @keyframes erasing {
            0% { opacity: 1; }
            50% { content: " "; }
            100% { opacity: 0; }
        }

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
<body class="bg-pink-50 font-serif">
    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-2 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                    <img src="../images/logoo.png" alt="MONOMICHI Logo" class="h-16 w-24 mr-2 mx-44">
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex items-center justify-center w-full max-w-xl ml-52">
                <form action="../views/searchresults.php" method="GET" class="w-full flex items-center bg-gray-200 rounded-full">
                    <input type="text" name="query" placeholder="Search products or categories..." class="w-full px-4 py-2 bg-white-200 text-gray-800 rounded-l-full focus:outline-none placeholder-gray-500" id="search-bar"/>
                    <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-r-full hover:bg-pink-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5 5m-5-5a7 7 0 10-7-7 7 7 0 007 7z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Sidebar -->
            <aside id="sidebar" class="fixed top-0 left-0 h-full bg-gray-50 shadow-lg flex flex-col items-center py-6 px-2 transition-all duration-300 w-16 hover:w-48 overflow-hidden">
                <!-- Expand/Collapse Button -->
                <button id="toggle-sidebar" class="text-gray-800 focus:outline-none mb-6">
                    <svg id="expand-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 transition-transform duration-300 transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16m-8-8l8 8-8 8" />
                    </svg>
                    <svg id="collapse-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 hidden transition-transform duration-300 transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8 8l-8-8 8-8" />
                    </svg>
                </button>

                <!-- Navigation Links -->
                <nav class="flex flex-col space-y-4 items-start w-full">
                    <a href="../index.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0a1 1 0 001 1h6a1 1 0 001-1v-5a1 1 0 011-1h2m-6 5a1 1 0 001-1v-5a1 1 0 011-1h2" /></svg></span>
                        <span class="sidebar-text text-sm">Home</span>
                    </a>
                    <a href="../views/products.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8m16 0H4" /></svg></span>
                        <span class="sidebar-text text-sm">Products</span>
                    </a>
                    <a href="../views/services.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                        <span class="sidebar-text text-sm">Services</span>
                    </a>
                    <a href="../views/faqs.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9l-6 6-6-6" /></svg></span>
                        <span class="sidebar-text text-sm">FAQs</span>
                    </a>
                    <a href="../views/contactus.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h14M3 10h14m-7 5h7" /></svg></span>
                        <span class="sidebar-text text-sm">Contact Us</span>
                    </a>
                    <a href="../views/aboutus.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19a4 4 0 108 0m-2 2h.01M8 13a4 4 0 108 0m-6 2h.01M11 11a4 4 0 108 0m-6 2h.01" /></svg></span>
                        <span class="sidebar-text text-sm">About Us</span>
                    </a>
                </nav>
            </aside>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-6 pr-4 ml-auto">
                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                <img src="<?php echo htmlspecialchars($userProfileImage, ENT_QUOTES, 'UTF-8'); ?>" alt="User Profile" class="w-14 h-14 rounded-full border border-gray-300 transition-transform transform hover:scale-110 hover:shadow-lg">
                </button>

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-40 w-40 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
                    <ul class="py-2 text-sm text-gray-700">
                        <?php if (isset($_SESSION['id'])): ?>
                            <li>
                                <a href="../views/myaccount.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">My Account</a>
                            </li>

                            <!-- Hide Order History for Admins & Managers -->
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>
                                <li>
                                    <a href="../views/order-history.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Order History</a>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a href="../views/logout.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Logout</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="../views/signup.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Sign Up</a>
                            </li>
                            <li>
                                <a href="../views/login.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Log In</a>
                            </li>
                        <?php endif; ?>
                    </ul>
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
    <footer class="bg-gray-50 px-40 py-10 text-gray-700">
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
<script>
    //Sidebar
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    const expandIcon = document.getElementById('expand-icon');
    const collapseIcon = document.getElementById('collapse-icon');

    // Ensure the sidebar is expanded by default when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        // Expand sidebar on page load
        sidebar.style.width = '160px';
        sidebar.classList.remove('w-16');
        sidebar.classList.add('w-auto');
        expandIcon.classList.add('hidden');
        collapseIcon.classList.remove('hidden');
    });

    // Toggle Sidebar when button is clicked
    toggleBtn.addEventListener('click', () => {
        const isCollapsed = sidebar.classList.contains('w-16');

        if (isCollapsed) {
            // Expand sidebar when collapsed
            sidebar.style.width = 'auto';
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-auto');
            expandIcon.classList.add('hidden');
            collapseIcon.classList.remove('hidden');
        } else {
            // Collapse sidebar
            sidebar.style.width = '3.5rem';
            sidebar.classList.remove('w-auto');
            sidebar.classList.add('w-16');
            collapseIcon.classList.add('hidden');
            expandIcon.classList.remove('hidden');
        }
    });

    //Profile
    const profileButton = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');

    profileButton.addEventListener('click', () => {
        profileMenu.classList.toggle('hidden');
        profileMenu.classList.toggle('opacity-0');
        profileMenu.classList.toggle('transform');
        profileMenu.classList.toggle('-translate-y-2');
    });

    const placeholderTexts = [
        "Search products or categories...",
        "Discover the best of Japan!",
        "Find your favorite items!"
    ];

    let currentTextIndex = 0;
    let isErasing = false;
    let textIndex = 0;
    const typingSpeed = 100; // Typing speed in ms
    const erasingSpeed = 50; // Erasing speed in ms
    const searchInput = document.getElementById("search-bar");

    function typeText() {
        if (textIndex < placeholderTexts[currentTextIndex].length) {
            searchInput.setAttribute("placeholder", placeholderTexts[currentTextIndex].substring(0, textIndex + 1));
            textIndex++;
            setTimeout(typeText, typingSpeed);
        } else {
            setTimeout(eraseText, 1500); // Wait before starting to erase
        }
    }

    function eraseText() {
        if (textIndex > 0) {
            searchInput.setAttribute("placeholder", placeholderTexts[currentTextIndex].substring(0, textIndex - 1));
            textIndex--;
            setTimeout(eraseText, erasingSpeed);
        } else {
            currentTextIndex = (currentTextIndex + 1) % placeholderTexts.length; // Loop through texts
            setTimeout(typeText, 500); // Wait before starting to type
        }
    }

    window.onload = function() {
        typeText(); // Start typing when the page loads
    };

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add('hidden');
            profileMenu.classList.add('opacity-0');
            profileMenu.classList.add('transform');
            profileMenu.classList.add('-translate-y-2');
        }
    });
</script>
</html>