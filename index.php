<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Check if the user is logged in and the role is 'customer'
if (isset($_SESSION['id']) && $role === 'customer') {
    // Set a session variable to show the popup message only once
    $_SESSION['popup_shown'] = true;
}

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
    <title>MONOMICHI - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    </style>
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

    <!-- Hero Section -->
    <section id="carousel" class="bg-cover bg-center relative" style="height: 500px;">
        <div class="h-full flex items-center justify-center bg-black bg-opacity-50">
            <div class="text-center text-white w-3/4 transition-all duration-500 ease-in-out transform hover:scale-110 hover:text-pink-400 hover:shadow-2xl rounded-full">
                <h2 class="text-7xl font-bold">Welcome to MONOMICHI</h2>
                <p class="mt-4 text-lg">Explore authentic Japanese items and learn about Japanese culture.</p>
                <div class="mt-6">
                    <!-- Explore Now Button with Smooth Scroll -->
                    <a href="#new-arrivals" class="px-6 py-3 bg-pink-600 rounded-full text-white font-semibold hover:bg-pink-800" id="exploreBtn">
                        Explore Now
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Left and Right Arrows for Carousel -->
        <div class="absolute top-1/2 left-4 transform -translate-y-1/2 text-white cursor-pointer z-10">
            <i class="fas fa-chevron-left text-3xl" id="prevArrow"></i>
        </div>
        <div class="absolute top-1/2 right-4 transform -translate-y-1/2 text-white cursor-pointer z-10">
            <i class="fas fa-chevron-right text-3xl" id="nextArrow"></i>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section id="new-arrivals" class="container mx-auto px-40 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">New Arrivals</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <div class="relative group">
                    <img src="https://miro.medium.com/v2/resize:fit:1400/1*pfbYYn7wUSmNQFqtirn21A.png" alt="Bento Time" 
                        class="w-full h-56 object-cover transition duration-300 ease-in-out group-hover:grayscale">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                        <h2 class="text-white text-2xl font-bold">BENTO TIME</h2>
                        <a href="../views/products.php#bento-set" class="mt-4 bg-white text-black py-2 px-6 rounded-full text-lg hover:bg-gray-200 transition">TAKE A LOOK</a>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <div class="relative group">
                    <img src="https://m.media-amazon.com/images/S/aplus-media-library-service-media/1314a45a-9401-4010-b7ee-3071e10f7aa4.__CR0,0,970,600_PT0_SX970_V1___.jpg" alt="Japanese Tea Set" 
                        class="w-full h-56 object-cover transition duration-300 ease-in-out group-hover:grayscale">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                        <h2 class="text-white text-2xl font-bold">TEA TIME</h2>
                        <a href="../views/products.php#tea-set" class="mt-4 bg-white text-black py-2 px-6 rounded-full text-lg hover:bg-gray-200 transition">TAKE A LOOK</a>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <div class="relative group">
                    <img src="https://zenbird.media/wp-content/uploads/2022/10/kimono_top.jpg" alt="Japanese Kimono" 
                        class="w-full h-56 object-cover transition duration-300 ease-in-out group-hover:grayscale">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                        <h2 class="text-white text-2xl font-bold">WEAR YOU LIKE</h2>
                        <a href="../views/products.php#kimono" class="mt-4 bg-white text-black py-2 px-6 rounded-full text-lg hover:bg-gray-200 transition">TAKE A LOOK</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Arrow Key Bar to Redirect to New Arrival Page -->
    <div class="flex justify-center mt-8">
        <a href="../views/products.php#new-arrivals-section" class="flex items-center text-pink-600 font-semibold hover:text-pink-700 transition duration-300 transform hover:scale-110">
            <span class="mr-2 text-5xl">See All New Arrivals</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-transform duration-300 hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
            </svg>
        </a>
    </div><br><br><br>

    <!-- Limited Time Offers Section -->
    <section id="limited-time-offers" class="bg-red-600 text-white text-center py-8 relative overflow-visible">
        <h3 class="text-4xl font-semibold">Limited Time Offers</h3>
        <p class="mt-4 text-lg">Get up to 80% off on selected Japanese items. Don't miss out!</p>
        <a href="../views/products.php#limited-time-offers-section" class="mt-6 inline-block bg-white text-red-600 py-3 px-8 rounded-full text-lg font-semibold">Shop Now</a>
    </section>

    <!-- Cultural Insights Section -->
    <section id="cultural-insights" class="container mx-auto px-40 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Learn About Japanese Culture</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- First Insight Tile -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="https://www.alonereaders.com/Images/Article/Img_202493_151312_391.png" alt="Culture 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Tea Ceremony</h4>
                    <p class="mt-2 text-gray-600">Discover the traditional Japanese tea ceremony and its significance.</p>
                    <a href="../views/culturalinsights.php#tea-ceremony" class="mt-4 inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg">Learn More</a>
                </div>
            </div>

            <!-- Second Insight Tile -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="https://c02.purpledshub.com/uploads/sites/40/2020/04/GettyImages-1166914367-2788542-scaled.jpg" alt="Culture 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Gardens</h4>
                    <p class="mt-2 text-gray-600">Explore the beauty and tranquility of traditional Japanese gardens.</p>
                    <a href="../views/culturalinsights.php#japanese-gardens" class="mt-4 inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg">Learn More</a>
                </div>
            </div>

            <!-- Third Insight Tile (Arrow for Redirection) -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 transform hover:scale-105 transition duration-300 ease-in-out relative">
                <div class="absolute inset-0 bg-cover bg-center filter blur-sm" style="background-image: url('https://www.japan-experience.com/sites/default/files/styles/scale_crop_760x556/public/legacy/japan_experience/1448623388848.png.webp?itok=PBlLTWkq');"></div>

                <!-- Content (Text and Icon) -->
                <a href="../views/culturalinsights.php" class="flex flex-col items-center text-white hover:text-black transition relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="mt-2 text-lg font-medium">Explore More Insights</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Blog Sharing Section -->
    <section class="mt-16 text-center">
        <h3 class="text-3xl font-semibold text-gray-900">Share Your Japanese Experience!</h3>
        <p class="mt-4 text-gray-700 ml-20">
            Are you passionate about Japanese culture? Whether it’s travel, food, or traditions, 
            share your experiences with our community! Click below to access your Blogger Account.
        </p>
        <a href="../views/blogdashboard.php" 
        class="mt-6 inline-block bg-pink-600 hover:bg-pink-700 text-white py-3 px-8 rounded-full text-lg shadow-md transition">
            Start Blogging
        </a>
    </section>

    <!-- Popup Message -->
    <div id="popupMessage" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50" style="display: none;">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center relative">
            <!-- Close Button -->
            <button id="closePopup" class="absolute top-4 right-4 text-gray-600 text-2xl font-semibold">✕</button>

            <h2 class="text-xl font-semibold text-gray-900">Welcome Back! 🌸</h2>
            <p class="mt-4 text-gray-700">We’re excited to see you! Share your experiences with the world on our Blog. 
            Click below to start your journey!</p>
            <a href="../views/blogdashboard.php" 
            class="mt-6 inline-block bg-pink-600 hover:bg-pink-700 text-white py-3 px-8 rounded-full text-lg shadow-md transition">
                Start Blogging
            </a>
        </div>
    </div>

    <!-- Newsletter Call to Action in Hero Section -->
    <div class="mt-12 bg-gray-100 py-8 rounded-lg shadow-md">
        <p class="text-xl text-center text-gray-800 font-semibold">Stay Updated with Our Latest Offers</p>
        <p class="text-lg text-center text-gray-600 mt-2">Subscribe to our newsletter for exclusive deals and the latest updates on Japanese culture!</p>
        <form action="#" method="POST" class="mt-6 flex justify-center" onsubmit="showMessage(event)">
            <input type="email" id="emailInput" placeholder="Enter your email" class="py-3 px-6 rounded-l-lg border border-gray-300 w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            <button type="submit" class="bg-pink-600 text-white py-3 px-6 rounded-r-lg font-semibold hover:bg-pink-700 transition ease-in-out duration-300">Subscribe</button>
        </form>
    </div>

    <!-- Success Modal -->
    <div id="popupMessage" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-sm mx-auto transform transition-all duration-300 scale-0">
            <p id="popupText" class="text-xl text-gray-800 font-semibold mb-4"></p>
            <button onclick="closePopup()" class="mt-4 bg-pink-600 text-white py-2 px-6 rounded-full hover:bg-pink-700 transition duration-300 focus:outline-none">Close</button>
        </div>
    </div>

    <!-- Event Promo Banner -->
    <section class="bg-pink-500 text-white text-center py-8">
        <h3 class="text-3xl font-semibold">Looking for something unique?</h3>
        <p class="mt-4">Request items that are not available in our catalog.</p>
        <a href="../views/specialrequest.php" class="mt-6 inline-block bg-white text-pink-600 py-3 px-8 rounded-full text-lg font-semibold hover:bg-pink-600 hover:text-white hover:scale-105">Request Now</a>
    </section>

    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" class="fixed bottom-4 right-4 bg-pink-500 text-white py-2 px-4 rounded-full text-lg hidden hover:bg-red-600 transition duration-300 ease-in-out">
        ↑
    </button>

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
    
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Scale and rotate
            card.style.transform = 'scale(1.05) rotate(2deg)';
            card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';

            // Activate overlay
            const overlay = card.querySelector('.hover-overlay');
            overlay.style.opacity = '0.4';
        });

        card.addEventListener('mouseleave', () => {
            // Reset scale and rotation
            card.style.transform = 'scale(1) rotate(0deg)';
            card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';

            // Deactivate overlay
            const overlay = card.querySelector('.hover-overlay');
            overlay.style.opacity = '0';
        });
    });

    // Smooth Scroll to Categories Section
    document.getElementById('exploreBtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('#new-arrivals').scrollIntoView({
            behavior: 'smooth'
        });
    });
    
    const images = [
        'https://i.pinimg.com/736x/31/21/b4/3121b48d9b633e8222efff5584929902.jpg',
        'https://i.pinimg.com/736x/b4/49/a7/b449a7ffb3274ec71ddbb0be550e33b3.jpg',
        'https://i.pinimg.com/736x/ef/f9/f5/eff9f536184c5b2ec92370e12a021d6f.jpg',
        'https://i.pinimg.com/736x/80/94/f6/8094f6a439a837092e71f845d69892d7.jpg',
        'https://i.pinimg.com/736x/cd/35/7d/cd357d4357befb94fe555a9113f9316b.jpg'
    ];

    let currentIndex = 0;

    function changeBackground() {
        const carousel = document.getElementById('carousel');
        carousel.style.backgroundImage = `url('${images[currentIndex]}')`;
        currentIndex = (currentIndex + 1) % images.length;
    }

    setInterval(changeBackground, 3000);
    changeBackground();

    // Function to update the carousel image
    function updateCarouselImage() {
        carousel.style.backgroundImage = `url('${images[currentIndex]}')`;
    }

    // Event listener for previous arrow
    document.getElementById("prevArrow").addEventListener("click", function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Move to previous image
        updateCarouselImage();
    });

    // Event listener for next arrow
    document.getElementById("nextArrow").addEventListener("click", function() {
        currentIndex = (currentIndex + 1) % images.length; // Move to next image
        updateCarouselImage();
    });

    // Initialize the carousel with the first image
    updateCarouselImage();

    // Function to launch confetti inside the "Limited Time Offers" section
    function launchConfettiInSection() {
        // Get the "Limited Time Offers" section
        const section = document.querySelector('#limited-time-offers');
        if (section) {
            const rect = section.getBoundingClientRect(); // Get section dimensions and position
            confetti({
                particleCount: 100, // Number of confetti pieces
                spread: 70,         // Spread angle
                origin: {
                    x: (rect.left + rect.width / 2) / window.innerWidth, // Center the X position within the section
                    y: (rect.top + rect.height / 2) / window.innerHeight // Center the Y position within the section
                },
                colors: ['#FF0000', '#FFC0CB', '#BEBEBE', '#FFFF00'],
            });
        }
    }

    // Loop the confetti effect only for the red section
    setInterval(launchConfettiInSection, 1500); // Trigger confetti every 1.5 seconds

    function showMessage(event) {
        event.preventDefault();  // Prevent form from submitting

        // Get the email input value
        const email = document.getElementById('emailInput').value;

        // Display the success message with the email
        const popupText = document.getElementById('popupText');
        popupText.innerHTML = `We sent an email to <strong>${email}</strong>. Please check your inbox.`;

        // Show the popup with animation
        const popup = document.getElementById('popupMessage');
        const popupContent = popup.querySelector('div');
        popup.classList.remove('hidden');
        popupContent.classList.remove('scale-0');
        popupContent.classList.add('scale-100');
    }

    function closePopup() {
        // Close the popup with animation
        const popup = document.getElementById('popupMessage');
        const popupContent = popup.querySelector('div');
        popupContent.classList.remove('scale-100');
        popupContent.classList.add('scale-0');

        // Hide the popup after animation ends
        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);
    }

    // Get the button
    let scrollToTopBtn = document.getElementById("scrollToTopBtn");

    // When the user scrolls down 100px from the top, show the button
    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            scrollToTopBtn.classList.remove("hidden");
        } else {
            scrollToTopBtn.classList.add("hidden");
        }
    };

    // When the button is clicked, scroll to the top smoothly
    scrollToTopBtn.onclick = function() {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth" // Scroll smoothly
        });
    };

    // Check if the popup has already been shown for this session
    <?php if (isset($_SESSION['popup_shown']) && $_SESSION['popup_shown'] === true) { ?>
        // Display the popup message
        document.getElementById('popupMessage').style.display = 'flex';
        // Reset the session variable after displaying the popup
        <?php unset($_SESSION['popup_shown']); ?>
    <?php } ?>

    // Close popup when the "X" button is clicked
    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('popupMessage').style.display = 'none';
    });

    // Close popup when clicking outside the popup
    window.addEventListener('click', function(event) {
        const popup = document.getElementById('popupMessage');
        // Check if the clicked target is outside the popup
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
</script>
</html>