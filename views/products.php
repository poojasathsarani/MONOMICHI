<?php
require "db_connection.php";
    session_start();
    $userIsLoggedIn = isset($_SESSION['user']);
    $userProfileImage = $userIsLoggedIn ? $_SESSION['user']['profile_image'] : null;

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        
        // Query to get the count of products in the user's wishlist
        $stmt = $conn->prepare("SELECT COUNT(*) AS wishlist_count FROM wishlist WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        // Get the count of wishlist items
        $wishlist_count = $data['wishlist_count'];
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        $wishlist_count = 0; // If not logged in, show 0 count
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - PRODUCTS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
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
<body class="bg-pink-50 md:font-serif">
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
                <!-- Wishlist Icon -->
                <a href="javascript:void(0);" class="relative" id="wishlist-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a4 4 0 016-3.92A4 4 0 0121 8c0 4-6 8-9 8s-9-4-9-8z" />
                    </svg>
                    <!-- Display the wishlist count dynamically -->
                    <span id="wishlist-count" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        <?php echo $wishlist_count; ?>
                    </span>
                </a>

                <!-- Modal for Wishlist -->
                <div id="wishlist-modal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center">
                    <div class="bg-white w-1/3 p-4 overflow-y-auto rounded-lg shadow-lg" id="wishlist-content" style="max-height: 80%;">
                        <!-- Heading and Close button in the same line -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Your Wishlist</h2>
                            <button id="close-modal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                X
                            </button>
                        </div>
                        <div id="wishlist-items">
                            <!-- Wishlist items will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Shopping Cart Icon -->
                <a href="javascript:void(0);" id="cart-icon" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.879 1.514M7 16a2 2 0 104 0M13 16a2 2 0 104 0M5.058 6H20.86l-2.35 7H7.609m2.788 5H6M21 21H6"></path>
                    </svg>
                    <span id="cart-item-count-icon" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"></span>
                </a>

                <!-- Cart Modal -->
                <div id="cart-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-[600px] max-h-[600px] overflow-hidden">
                        <h3 class="text-xl font-bold text-gray-700 mb-4">Your Shopping Cart</h3>
                        <div id="cart-items" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                            <!-- Cart items will be displayed here -->
                        </div>
                        <button id="close-cart" class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Close</button>
                    </div>
                </div>

                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                    <!-- Conditional Rendering of User Avatar or Profile Icon -->
                    <img src="<?php echo $userIsLoggedIn ? $userProfileImage : 'https://w7.pngwing.com/pngs/423/634/png-transparent-find-user-profile-person-avatar-people-account-search-general-pack-icon.png'; ?>" alt="User Profile" class="w-14 h-14 rounded-full border border-gray-300 transition-transform transform hover:scale-110 hover:shadow-lg">
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

    <!-- Categories Bar -->
    <div class="relative">
        <div class="flex space-x-6 px-56 py-2 bg-gray-100 shadow-md">
            <!-- New Arrivals Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('newArrivals')">
                    New Arrivals
                    <span class="ml-2 transform transition duration-300" id="arrow-newArrivals">▼</span>
                </button>
                <div id="newArrivalsDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#new-arrivals-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Bento Set</a></li>
                            <li><a href="#" class="block px-4 py-2">Tea Set</a></li>
                            <li><a href="#" class="block px-4 py-2">Kimono</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Lantern</a></li>
                            <li><a href="#" class="block px-4 py-2">Folding Fan</a></li>
                            <li><a href="#" class="block px-4 py-2">Calligraphy Set</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Limited Time Offers Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('limitedTimeOffers')">
                    Limited Time Summer Offers
                    <span class="ml-2 transform transition duration-300" id="arrow-limitedTimeOffers">▼</span>
                </button>
                <div id="limitedTimeOffersDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#limited-time-offers-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Stylish Summer Sunglasses</a></li>
                            <li><a href="#" class="block px-4 py-2">Cool Summer Hats</a></li>
                            <li><a href="#" class="block px-4 py-2">Spacious Beach Bag</a></li>
                            <li><a href="#" class="block px-4 py-2">Trendy Swimwear</a></li>
                            <li><a href="#" class="block px-4 py-2">Comfy Flip Flops</a></li>
                            <li><a href="#" class="block px-4 py-2">Light Summer Dress</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Home & Interior Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('homeInterior')">
                    Home & Interior
                    <span class="ml-2 transform transition duration-300" id="arrow-homeInterior">▼</span>
                </button>
                <div id="homeInteriorDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#home-interior-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Vase</a></li>
                            <li><a href="#" class="block px-4 py-2">Table</a></li>
                            <li><a href="#" class="block px-4 py-2">Lamp</a></li>
                            <li><a href="#" class="block px-4 py-2">Wall Art</a></li>
                            <li><a href="#" class="block px-4 py-2">Plant Pot</a></li>
                            <li><a href="#" class="block px-4 py-2">Blanket</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Health & Beauty Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('healthBeauty')">
                    Health & Beauty
                    <span class="ml-2 transform transition duration-300" id="arrow-healthBeauty">▼</span>
                </button>
                <div id="healthBeautyDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#health-beauty-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Face Masks</a></li>
                            <li><a href="#" class="block px-4 py-2">Shampoo</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Bathing items</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Skincare Set</a></li>
                            <li><a href="#" class="block px-4 py-2">Hair Treatment Oil</a></li>
                            <li><a href="#" class="block px-4 py-2">Cream</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fashion & Lifestyle Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('fashionLifestyle')">
                    Fashion & Lifestyle
                    <span class="ml-2 transform transition duration-300" id="arrow-fashionLifestyle">▼</span>
                </button>
                <div id="fashionLifestyleDropdown" class="subcategory-dropdown hidden absolute left-0 mt-72">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#fashion-lifestyle-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Men</a></li>
                            <li><a href="#" class="block px-4 py-2">Women</a></li>
                            <li><a href="#" class="block px-4 py-2">Kids</a></li>
                            <li><a href="#" class="block px-4 py-2">Pets</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Traditional Decorations Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('decorations')">
                    Traditional Decorations
                    <span class="ml-2 transform transition duration-300" id="arrow-decorations">▼</span>
                </button>
                <div id="decorationsDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#japanese-traditional-decorations-section" class="block px-4 py-2">January</a></li>
                            <li><a href="#" class="block px-4 py-2">February</a></li>
                            <li><a href="#" class="block px-4 py-2">March</a></li>
                            <li><a href="#" class="block px-4 py-2">April</a></li>
                            <li><a href="#" class="block px-4 py-2">May</a></li>
                            <li><a href="#" class="block px-4 py-2">June</a></li>
                            <li><a href="#" class="block px-4 py-2">July</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Food & Drinks Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('foodDrinks')">
                    Food & Drinks
                    <span class="ml-2 transform transition duration-300" id="arrow-foodDrinks">▼</span>
                </button>
                <div id="foodDrinksDropdown" class="subcategory-dropdown hidden absolute left-0 mt-72">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#tea-snacks-section" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Snacks</a></li>
                            <li><a href="#" class="block px-4 py-2">Premium Food</a></li>
                            <li><a href="#" class="block px-4 py-2">Drinks</a></li>
                            <li><a href="#" class="block px-4 py-2">Healthy Nutrition</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Stationeries Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('stationeries')">
                    Stationeries & Collectibles
                    <span class="ml-2 transform transition duration-300" id="arrow-stationeries">▼</span>
                </button>
                <div id="stationeriesDropdown" class="subcategory-dropdown hidden absolute left-0 mt-80">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#stationery-section" class="block px-4 py-2">Japanese Calligraphy Sets</a></li>
                            <li><a href="#" class="block px-4 py-2">Traditional Stationery Sets</a></li>
                            <li><a href="#" class="block px-4 py-2">Paper Lanterns</a></li>
                            <li><a href="#" class="block px-4 py-2">Stationery Accessories</a></li>
                            <li><a href="#" class="block px-4 py-2">Origami Paper</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Books Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('books')">
                    Books & Movies
                    <span class="ml-2 transform transition duration-300" id="arrow-books">▼</span>
                </button>
                <div id="booksDropdown" class="subcategory-dropdown hidden absolute left-0 mt-96">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#japanese-language-learning-section" class="block px-4 py-2">Japanese Language Learning Books</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Culture and History</a></li>
                            <li><a href="#" class="block px-4 py-2">Manga and Graphic Novels</a></li>
                            <li><a href="#" class="block px-4 py-2">Books on Japanese Cuisine</a></li>
                            <li><a href="#" class="block px-4 py-2">Books for Japanese Calligraphy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Area -->
    <div id="content" class="ml-40 flex-1 transition-all duration-300">
        <div id="productsContainer" class="container mx-auto p-4 transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-center">Our Collection</h1>
                <div class="flex gap-4">
                    <select id="sortSelect" class="p-2 border border-gray-300 rounded">
                        <option value="">Sort by</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                    <select id="filterSelect" class="p-2 border border-gray-300 rounded">
                        <option value="">All Categories</option>
                        <option value="New Arrivals">New Arrivals</option>
                        <option value="Limited Time Offers">Limited Time Offers</option>
                        <option value="Home & Interior">Home & Interior</option>
                        <option value="Health & Beauty">Health & Beauty</option>
                        <option value="Fashion & Lifestyle">Fashion & Lifestyle</option>
                        <option value="Traditional Decorations">Traditional Decorations</option>
                        <option value="Food & Drinks">Food & Drinks</option>
                        <option value="Stationeries">Stationeries & Collectibles</option>
                        <option value="Books">Books & Movies</option>
                    </select>
                </div>
            </div>

            <!-- Product Card -->
            <!-- New Arrivals -->
            <section id="new-arrivals-section">
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">New Arrivals</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Limited Time Summer Offers --> 
            <section id="limited-time-summer-offers-section"> 
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">Limited Time Summer Offers</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Home & Interior --> 
            <section id="home-&-interior-section"> 
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">Home & Interior</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Health & Beauty --> 
            <section id="health-beauty-section"> 
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">Health & Beauty</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Fashion & Lifestyle --> 
            <section id="fashion-lifestyle-section"> 
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">Fashion & Lifestyle</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Traditional Decorations --> 
            <section id="traditional-decorations-section"> 
                <h2 class="text-2xl font-bold text-center mb-6 text-pink-700">Traditional Decorations</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Product Modal -->
            <div id="product-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div class="relative bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                    <!-- Close Button -->
                    <button id="close-product-modal" class="absolute top-3 right-3 bg-gray-500 text-white px-2 py-1 rounded-full hover:bg-gray-700">X</button>
                    
                    <!-- Product Image -->
                    <div class="w-full h-64 bg-gray-200 flex justify-center items-center">
                        <img id="modal-img" class="max-w-full max-h-64 object-contain rounded-md" alt="Product Image">
                    </div>

                    <!-- Product Details -->
                    <h2 id="modal-title" class="text-2xl font-bold mt-4"></h2>
                    <p id="modal-description" class="text-gray-700 mt-2"></p>
                    <p id="modal-price" class="text-red-500 font-bold mt-2"></p>
                </div>
            </div>
        </div>
    </div>

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
    // Show the header after the page loads
    document.addEventListener("DOMContentLoaded", function(){
        const header = document.querySelector("header");
        if (header) {
            header.classList.remove("hidden");
        }
        header.classList.add("opacity-100");
    });

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

    let lastExpanded = null;
    let originalMarginTop = null; // To store the initial margin of the products container

    function toggleDropdown(category) {
        const dropdown = document.getElementById(`${category}Dropdown`);
        const arrow = document.getElementById(`arrow-${category}`);
        const productsContainer = document.getElementById("productsContainer");

        // Save the original margin of the products container if not already saved
        if (originalMarginTop === null) {
            originalMarginTop = window.getComputedStyle(productsContainer).marginTop;
        }

        // Check if the dropdown to be expanded is already visible
        if (dropdown === lastExpanded) {
            // Collapse the currently expanded dropdown
            dropdown.classList.add("hidden");
            dropdown.classList.remove("block");
            arrow.textContent = "▼";
            productsContainer.style.marginTop = originalMarginTop; // Restore original margin
            lastExpanded = null; // Reset lastExpanded
            return;
        }

        // Collapse the previously expanded dropdown if there is one
        if (lastExpanded) {
            const previousArrow = document.querySelector(
                `#${lastExpanded.id.replace("Dropdown", "arrow")}`
            );
            lastExpanded.classList.add("hidden");
            lastExpanded.classList.remove("block");
            if (previousArrow) previousArrow.textContent = "▼";
        }

        // Expand the clicked dropdown
        dropdown.classList.remove("hidden");
        dropdown.classList.add("block");
        arrow.textContent = "▲";

        // Adjust margin dynamically
        const dropdownHeight = dropdown.offsetHeight;
        productsContainer.style.marginTop = `${dropdownHeight + 20}px`;

        // Update lastExpanded to the currently expanded dropdown
        lastExpanded = dropdown;
    }

    // Event listener to detect clicks outside the dropdown
    document.addEventListener("click", (event) => {
        // Check if the click is outside any dropdown or toggle button
        const dropdowns = document.querySelectorAll("[id$='Dropdown']");
        let isInsideDropdown = false;

        dropdowns.forEach((dropdown) => {
            if (
                dropdown.contains(event.target) ||
                dropdown.previousElementSibling.contains(event.target)
            ) {
                isInsideDropdown = true;
            }
        });

        if (!isInsideDropdown) {
            dropdowns.forEach((dropdown) => {
                const arrow = document.querySelector(
                    `#${dropdown.id.replace("Dropdown", "arrow")}`
                );

                dropdown.classList.add("hidden");
                dropdown.classList.remove("block");
                if (arrow) arrow.textContent = "▼";
            });

            // Reset the lastExpanded variable
            lastExpanded = null;

            // Restore the original margin of the products container
            const productsContainer = document.getElementById("productsContainer");
            if (productsContainer) {
                productsContainer.style.marginTop = originalMarginTop;
            }
        }
    });









    document.addEventListener("DOMContentLoaded", function () {
        // Fetch and display products
        fetch("get_products.php")
            .then(response => response.json())
            .then(categories => {
                console.log(categories);
                categories.forEach(category => {
                    let sectionId = category.categoryname.toLowerCase().replace(/\s*&\s*/g, '-').replace(/\s+/g, '-') + "-section";
                    let categorySection = document.getElementById(sectionId);
                    if (categorySection) {
                        category.subcategories.forEach(subcategory => {
                            let subcategoryContainer = document.createElement("div");
                            subcategoryContainer.innerHTML = `
                                <h3 class="text-xl font-semibold text-center mt-6">${subcategory.subcategoryname}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                                    ${subcategory.products.map(product => `
                                        <div class="border rounded-lg p-4 shadow-lg">
                                            <img src="${product.image}" alt="${product.productname}" class="w-full h-48 object-cover rounded-md" onError="this.onerror=null; this.src='path/to/placeholder-image.jpg';">
                                            <h4 class="text-lg font-bold mt-2 product-name cursor-pointer text-blue-500"
                                                data-id="${product.productid}"
                                                data-name="${product.productname}"
                                                data-description="${product.description}"
                                                data-price="${product.price}"
                                                data-img="${product.image}">
                                                ${product.productname}
                                            </h4>
                                            <p class="text-gray-600 text-sm">${product.description}</p>
                                            <p class="text-red-500 font-bold mt-2">Rs. ${product.price}</p>
                                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart"
                                                    data-id="${product.productid}"
                                                    data-name="${product.productname}"
                                                    data-price="${product.price}"
                                                    data-img="${product.image}">
                                                Add to Cart
                                            </button>
                                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" 
                                                data-id="${product.productid}"
                                                data-name="${product.productname}" 
                                                data-price="${product.price}" 
                                                data-img="${product.image}">
                                                Add to Wishlist
                                            </button>
                                        </div>
                                    `).join('')}
                                </div>
                            `;
                            categorySection.appendChild(subcategoryContainer);
                        });
                    }
                });

                // Attach event listener for product names dynamically
                document.querySelectorAll(".product-name").forEach(item => {
                    item.addEventListener("click", function () {
                        const modal = document.getElementById("product-modal");
                        document.getElementById("modal-img").src = this.dataset.img;
                        document.getElementById("modal-title").textContent = this.dataset.name;
                        document.getElementById("modal-description").textContent = this.dataset.description;
                        document.getElementById("modal-price").textContent = "Rs. " + this.dataset.price;
                        modal.classList.remove("hidden");
                    });
                });
            })
            .catch(error => console.error("Error fetching data:", error));

        // Make sure the click listener for the product modal works
        document.addEventListener('click', function(e) {
            // If the close button was clicked
            if (e.target && e.target.id === 'close-modal') {
                document.getElementById("product-modal").classList.add("hidden");
            }
            
            // You can also close by clicking outside the modal content
            if (e.target && e.target.id === 'product-modal') {
                document.getElementById("product-modal").classList.add("hidden");
            }
        });

        // Add product to wishlist
        document.body.addEventListener("click", function (event) {
            if (event.target.classList.contains("add-to-wishlist")) {
                let button = event.target;
                let product = {
                    product_id: button.getAttribute("data-id"),
                    name: button.getAttribute("data-name"),
                    price: button.getAttribute("data-price"),
                    img: button.getAttribute("data-img"),
                };

                fetch("wishlist.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(product),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessPopup(data.message);
                        fetchWishlistCount();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
            }

            // Remove from Wishlist
            if (event.target.classList.contains("remove-from-wishlist")) {
                const productId = event.target.getAttribute("data-id");

                fetch("remove_from_wishlist.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: productId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessPopup("Item removed from wishlist");
                        refreshWishlist();
                        fetchWishlistCount();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
            }

            // Add to cart from wishlist
            if (event.target.classList.contains("add-to-cart-from-wishlist")) {
                const button = event.target;
                const product = {
                    product_id: button.getAttribute("data-id"),
                    name: button.getAttribute("data-name"),
                    price: button.getAttribute("data-price"),
                    img: button.getAttribute("data-img")
                };

                // First check if the product is already in the cart
                fetch("check_cart.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ product_id: product.product_id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // If product exists in cart, update quantity
                        return fetch("update_cart_quantity.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: `product_id=${product.product_id}&action=increase`
                        });
                    } else {
                        // If product does not exist, add it to cart
                        return fetch("add_to_cart.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify(product)
                        });
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove from wishlist after successfully adding to cart
                        return fetch("remove_from_wishlist.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ id: product.product_id }),
                        });
                    } else {
                        throw new Error(data.message || "Failed to update/add to cart");
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessPopup("Item moved from wishlist to cart!");
                        refreshWishlist();
                        fetchWishlistCount();
                        updateCartItemCount();
                        refreshCartContents();
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert(error.message || "Error moving item to cart");
                });
            }
        });

        // Wishlist Modal Controls
        document.getElementById("wishlist-icon").addEventListener("click", function () {
            document.getElementById("wishlist-modal").classList.remove("hidden");
            refreshWishlist();
        });

        document.getElementById("close-modal").addEventListener("click", function () {
            document.getElementById("wishlist-modal").classList.add("hidden");
        });

        // Helper Functions
        function showSuccessPopup(message) {
            const popupHTML = `
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" id="success-popup">
                    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-pink-600 mb-2">Success!</h3>
                        <p class="text-gray-700 mb-4">${message}</p>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', popupHTML);

            const popup = document.getElementById('success-popup');
            
            popup.addEventListener('click', function(event) {
                if (event.target === this) {
                    popup.remove();
                }
            });

            setTimeout(() => {
                if (popup) {
                    popup.remove();
                }
            }, 3000);
        }

        function refreshWishlist() {
            fetch("view_wishlist.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("wishlist-items").innerHTML = data;
                })
                .catch(error => console.error("Error refreshing wishlist:", error));
        }

        function updateWishlistCount(count) {
            document.getElementById('wishlist-count').textContent = count;
        }

        function fetchWishlistCount() {
            fetch('get_wishlist_count.php')
                .then(response => response.json())
                .then(data => {
                    updateWishlistCount(data.count);
                })
                .catch(error => console.error("Error fetching wishlist count:", error));
        }
    });








    document.addEventListener('DOMContentLoaded', function() {
        const cartIcon = document.getElementById("cart-icon");
        const cartModal = document.getElementById("cart-modal");
        const closeCart = document.getElementById("close-cart");
        const cartCountIcon = document.getElementById("cart-item-count-icon");

        // Initialize cart count
        updateCartItemCount();

        // Cart Modal Toggle
        if (cartIcon) {
            cartIcon.addEventListener("click", function() {
                if (cartModal) {
                    cartModal.classList.remove("hidden");
                    refreshCartContents();
                }
            });
        }

        if (closeCart) {
            closeCart.addEventListener("click", function() {
                if (cartModal) {
                    cartModal.classList.add("hidden");
                }
            });
        }

        // Add to cart functionality
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("add-to-cart")) {
                event.preventDefault();
                
                const button = event.target;
                const productId = button.getAttribute("data-id");
                console.log("Product ID:", productId);

                const product = {
                    product_id: productId,
                    name: button.getAttribute("data-name"),
                    price: button.getAttribute("data-price"),
                    img: button.getAttribute("data-img")
                };

                console.log("Sending product data:", product);

                fetch("add_to_cart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(product),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Server response:", data);
                    if (data.success) {
                        updateCartItemCount();
                        if (cartModal && cartModal.classList.contains("hidden")) {
                            cartModal.classList.remove("hidden");
                        }
                        refreshCartContents();
                    } else {
                        alert(data.message || "Failed to add to cart");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Error adding to cart. Please try again.");
                });
            }

            // Quantity Update Handler
            if (event.target.classList.contains("update-quantity")) {
                const button = event.target;
                const productId = button.getAttribute("data-id");
                const action = button.getAttribute("data-action");
                const quantitySpan = button.parentElement.querySelector("span");
                const currentQuantity = parseInt(quantitySpan.textContent);

                if (action === "decrease" && currentQuantity <= 1) {
                    return;
                }

                fetch("update_cart_quantity.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `product_id=${productId}&action=${action}`,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        refreshCartContents();
                        updateCartItemCount();
                    } else {
                        alert(data.message || "Failed to update quantity");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Error updating quantity. Please try again.");
                });
            }

            // Remove Item Handler
            if (event.target.classList.contains("remove-item")) {
                const productId = event.target.getAttribute("data-id");
                
                fetch("remove_from_cart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "product_id=" + productId,
                })
                .then(response => response.text())
                .then(data => {
                    refreshCartContents();
                    updateCartItemCount();
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Error removing item. Please try again.");
                });
            }
        });

        // Clear Cart Handler
        document.addEventListener("click", function(event) {
            if (event.target.id === "clear-cart") {
                if (confirm("Are you sure you want to clear your entire cart?")) {
                    fetch("clear_cart.php", { method: "POST" })
                    .then(response => response.text())
                    .then(data => {
                        refreshCartContents();
                        updateCartItemCount();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error clearing cart. Please try again.");
                    });
                }
            }
        });

        function refreshCartContents() {
            fetch("view_cart.php")
                .then(response => response.text())
                .then(data => {
                    const cartItems = document.getElementById("cart-items");
                    if (cartItems) {
                        cartItems.innerHTML = data;
                    }
                })
                .catch(error => console.error("Error fetching cart data:", error));
        }

        function updateCartItemCount() {
            fetch("cart_count.php")
                .then(response => response.text())
                .then(count => {
                    if (cartCountIcon) {
                        cartCountIcon.textContent = count;
                    }
                })
                .catch(error => console.error("Error updating cart count:", error));
        }
    });
</script>
</html>
