<?php
    session_start();
    $userIsLoggedIn = isset($_SESSION['user']);
    $userProfileImage = $userIsLoggedIn ? $_SESSION['user']['profile_image'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - PRODUCTS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../json/products.js"></script>
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

            <!-- Hamburger Menu Button -->
            <button id="menu-btn" class="lg:hidden block text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

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
                    <span id="wishlist-count" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>

                <!-- Shopping Cart Icon -->
                <a href="javascript:void(0);" id="cart-icon" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.879 1.514M7 16a2 2 0 104 0M13 16a2 2 0 104 0M5.058 6H20.86l-2.35 7H7.609m2.788 5H6M21 21H6"></path>
                    </svg>
                    <span id="cart-item-count-icon" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"></span>
                </a>

                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                    <!-- Conditional Rendering of User Avatar or Profile Icon -->
                    <img src="<?php echo $userIsLoggedIn ? $userProfileImage : 'https://w7.pngwing.com/pngs/423/634/png-transparent-find-user-profile-person-avatar-people-account-search-general-pack-icon.png'; ?>" alt="User Profile" class="w-14 h-14 rounded-full border border-gray-300 transition-transform transform hover:scale-110 hover:shadow-lg">
                </button>

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-80 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="../views/signup.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Sign Up</a>
                        </li>
                        <li>
                            <a href="../views/login.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Log In</a>
                        </li>
                        <li>
                            <a href="../views/my-account.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">My Account</a>
                        </li>
                        <li>
                            <a href="../views/order-history.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Order History</a>
                        </li>
                        <li>
                            <a href="../views/settings.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Settings</a>
                        </li>
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
        <!-- Display products -->
        <div id="productsContainer" class="container mx-auto p-4 transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-center">Our Collection</h1>
                <div class="flex gap-4">
                    <select class="p-2 border border-gray-300 rounded">
                        <option value="">Sort by</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popularity">Popularity</option>
                    </select>
                    <select class="p-2 border border-gray-300 rounded">
                        <option value="">Filter by Category</option>
                        <option value="stationery">Stationery</option>
                        <option value="books">Educational Books</option>
                        <option value="tea">Tea & Snacks</option>
                        <option value="decor">Home Decor</option>
                        <option value="pop_culture">Pop Culture Items</option>
                    </select>
                </div>
            </div>

            <!-- Product Card -->
            <!-- New Arrivals -->
            <section id="new-arrivals-section">
                <h2 class="text-2xl font-bold text-center mb-6">New Arrivals</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>
            
            <!-- Stationery -->
            <div class="category-section" id="stationery-section">
                <h2 class="text-xl font-semibold mb-4">Stationeries & Collectibles</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Pens -->
                    <div id="stationery-item-1" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://thejapaneseshop.co.uk/cdn/shop/files/premium-oak-wood-black-japanese-ballpoint-pen-3_a48407f6-9e68-457e-afde-984bd8b04405.jpg?v=1715416660&width=1946" alt="Premium Pen" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Premium Pen</h3>
                            <p class="text-gray-600 mt-2">A sleek, high-quality ballpoint pen made from premium oak wood for a luxurious writing experience.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 250</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Premium Pen" data-price="250" data-img="https://thejapaneseshop.co.uk/cdn/shop/files/premium-oak-wood-black-japanese-ballpoint-pen-3_a48407f6-9e68-457e-afde-984bd8b04405.jpg?v=1715416660&width=1946">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Premium Pen" data-price="250" data-img="https://thejapaneseshop.co.uk/cdn/shop/files/premium-oak-wood-black-japanese-ballpoint-pen-3_a48407f6-9e68-457e-afde-984bd8b04405.jpg?v=1715416660&width=1946">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-2" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://pitchmanpens.com/cdn/shop/products/RainmakerBlueFountainPen1.jpg?v=1651008338" alt="Luxury Blue Pen" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Luxury Blue Pen</h3>
                            <p class="text-gray-600 mt-2">A luxurious ballpoint pen in blue, crafted from high-quality materials for smooth writing.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 350</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Luxury Blue Pen" data-price="350" data-img="https://pitchmanpens.com/cdn/shop/products/RainmakerBlueFountainPen1.jpg?v=1651008338">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Luxury Blue Pen" data-price="350" data-img="https://pitchmanpens.com/cdn/shop/products/RainmakerBlueFountainPen1.jpg?v=1651008338">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-3" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71hmC6Y2s5L._AC_SL1194_.jpg" alt="Black Pen" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Black Pen</h3>
                            <p class="text-gray-600 mt-2">A smooth-writing ballpoint pen in sleek black, made with fine craftsmanship for professionals.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Black Pen" data-price="200" data-img="https://m.media-amazon.com/images/I/71hmC6Y2s5L._AC_SL1194_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Black Pen" data-price="200" data-img="https://m.media-amazon.com/images/I/71hmC6Y2s5L._AC_SL1194_.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- Notebooks -->
                    <div id="stationery-item-2" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.themakerhobart.com.au/cdn/shop/files/vintage_notebook_1.jpg?v=1715317519&width=1200" alt="Classic Notebook" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Classic Notebook</h3>
                            <p class="text-gray-600 mt-2">A vintage-style notebook perfect for journaling, sketching, or taking notes in style.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 600</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Classic Notebook" data-price="600" data-img="https://www.themakerhobart.com.au/cdn/shop/files/vintage_notebook_1.jpg?v=1715317519&width=1200">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Classic Notebook" data-price="600" data-img="https://www.themakerhobart.com.au/cdn/shop/files/vintage_notebook_1.jpg?v=1715317519&width=1200">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-3" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://images.squarespace-cdn.com/content/v1/5eaaf226e41012207079f359/1707219268877-WZGIOQLAGE8SB4EK5KYH/UNADJUSTEDNONRAW_thumb_1cf4.jpg?format=1000w" alt="Linen Notebook" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Linen Notebook</h3>
                            <p class="text-gray-600 mt-2">An elegant linen-bound notebook with a soft cover, perfect for note-taking and sketching.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 750</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Linen Notebook" data-price="750" data-img="https://images.squarespace-cdn.com/content/v1/5eaaf226e41012207079f359/1707219268877-WZGIOQLAGE8SB4EK5KYH/UNADJUSTEDNONRAW_thumb_1cf4.jpg?format=1000w">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Linen Notebook" data-price="750" data-img="https://images.squarespace-cdn.com/content/v1/5eaaf226e41012207079f359/1707219268877-WZGIOQLAGE8SB4EK5KYH/UNADJUSTEDNONRAW_thumb_1cf4.jpg?format=1000w">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-4" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://images-cdn.ubuy.co.in/65048d58f13be73f071646d7-yansanido-spiral-notebook-4-pcs-4-color.jpg" alt="Spiral Notebook" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Spiral Notebook</h3>
                            <p class="text-gray-600 mt-2">A practical spiral-bound notebook, perfect for students and professionals alike.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 450</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Spiral Notebook" data-price="450" data-img="https://images-cdn.ubuy.co.in/65048d58f13be73f071646d7-yansanido-spiral-notebook-4-pcs-4-color.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Spiral Notebook" data-price="450" data-img="https://images-cdn.ubuy.co.in/65048d58f13be73f071646d7-yansanido-spiral-notebook-4-pcs-4-color.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- Markers -->
                    <div id="stationery-item-3" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.fadebomb.com/cdn/shop/products/sld700_e7000bba-23da-4a02-85cc-48c8990b08eb_1200x1200.jpg?v=1545137126" alt="Permanent Marker" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Permanent Marker</h3>
                            <p class="text-gray-600 mt-2">A durable, multi-purpose permanent marker that writes smoothly on most surfaces.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 150</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Permanent Marker" data-price="150" data-img="https://www.fadebomb.com/cdn/shop/products/sld700_e7000bba-23da-4a02-85cc-48c8990b08eb_1200x1200.jpg?v=1545137126">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Permanent Marker" data-price="150" data-img="https://www.fadebomb.com/cdn/shop/products/sld700_e7000bba-23da-4a02-85cc-48c8990b08eb_1200x1200.jpg?v=1545137126">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-4" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://marchante.mx/cdn/shop/files/D_NQ_NP_2X_752204-MLM48121786399_112021-F_1024x.webp?v=1706646142" alt="Chisel Tip Marker" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Chisel Tip Marker</h3>
                            <p class="text-gray-600 mt-2">A versatile chisel-tip marker designed for bold, expressive strokes on a variety of surfaces.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Chisel Tip Marker" data-price="200" data-img="https://marchante.mx/cdn/shop/files/D_NQ_NP_2X_752204-MLM48121786399_112021-F_1024x.webp?v=1706646142">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Chisel Tip Marker" data-price="200" data-img="https://marchante.mx/cdn/shop/files/D_NQ_NP_2X_752204-MLM48121786399_112021-F_1024x.webp?v=1706646142">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-5" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://img.uline.com/is/image/uline/S-19421BL?$Mobile_SI$" alt="Fine Tip Marker" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Fine Tip Marker</h3>
                            <p class="text-gray-600 mt-2">A fine-tip marker for precise, detailed writing and artwork on most surfaces.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 180</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Fine Tip Marker" data-price="180" data-img="https://img.uline.com/is/image/uline/S-19421BL?$Mobile_SI$">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Fine Tip Marker" data-price="180" data-img="https://img.uline.com/is/image/uline/S-19421BL?$Mobile_SI$">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- Erasers -->
                    <div id="stationery-item-4" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.suratsuperstore.in/cdn/shop/files/apsara-non-dust-eraser.jpg?v=1690742785" alt="White Eraser" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">White Eraser</h3>
                            <p class="text-gray-600 mt-2">A soft and effective eraser that removes pencil marks cleanly without damaging paper.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 50</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="White Eraser" data-price="50" data-img="https://www.suratsuperstore.in/cdn/shop/files/apsara-non-dust-eraser.jpg?v=1690742785">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="White Eraser" data-price="50" data-img="https://www.suratsuperstore.in/cdn/shop/files/apsara-non-dust-eraser.jpg?v=1690742785">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-5" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.donbookstore.com/donbook/outerweb/product_images/10106037l.png" alt="Pink Eraser" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Pink Eraser</h3>
                            <p class="text-gray-600 mt-2">A smooth and gentle eraser that provides precise erasing without leaving marks or tearing paper.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 70</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Pink Eraser" data-price="70" data-img="https://www.donbookstore.com/donbook/outerweb/product_images/10106037l.png">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Pink Eraser" data-price="70" data-img="https://www.donbookstore.com/donbook/outerweb/product_images/10106037l.png">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-6" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://down-my.img.susercontent.com/file/my-11134208-7r98u-lyq2myf9iesgf3" alt="Miri Eraser" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Miri Eraser</h3>
                            <p class="text-gray-600 mt-2">A high-quality, dust-free eraser that erases cleanly without leaving residue or smudges.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 80</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Miri Eraser" data-price="80" data-img="https://down-my.img.susercontent.com/file/my-11134208-7r98u-lyq2myf9iesgf3">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Miri Eraser" data-price="80" data-img="https://down-my.img.susercontent.com/file/my-11134208-7r98u-lyq2myf9iesgf3">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- <Highlighters -->
                    <div id="stationery-item-5" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://cutethingsfromjapan.com/cdn/shop/products/100000001004262242_10209_a08e8dc9-0327-4b35-8ecd-0dd710e9f590.jpg?v=1617801303&width=720" alt="Neon Highlighter" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Neon Highlighter</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 120</p>
                            <p class="text-gray-500 mt-2">Bright and vibrant neon highlighters to make your notes stand out.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Neon Highlighter" data-price="120" data-img="https://cutethingsfromjapan.com/cdn/shop/products/100000001004262242_10209_a08e8dc9-0327-4b35-8ecd-0dd710e9f590.jpg?v=1617801303&width=720">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Neon Highlighter" data-price="120" data-img="https://cutethingsfromjapan.com/cdn/shop/products/100000001004262242_10209_a08e8dc9-0327-4b35-8ecd-0dd710e9f590.jpg?v=1617801303&width=720">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-6" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://img.drz.lazcdn.com/static/lk/p/6ef712cbbdefeacd5254785f3a887288.jpg_720x720q80.jpg" alt="Pastel Highlighter" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Pastel Highlighter</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 150</p>
                            <p class="text-gray-500 mt-2">Subtle pastel shades for a softer, more refined highlight on your notes.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Pastel Highlighter" data-price="150" data-img="https://img.drz.lazcdn.com/static/lk/p/6ef712cbbdefeacd5254785f3a887288.jpg_720x720q80.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Pastel Highlighter" data-price="150" data-img="https://img.drz.lazcdn.com/static/lk/p/6ef712cbbdefeacd5254785f3a887288.jpg_720x720q80.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-7" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://img.drz.lazcdn.com/static/lk/p/d49798a634e891e2458e2ef36d58c800.jpg_720x720q80.jpg" alt="Fluorescent Highlighter" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Fluorescent Highlighter</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 130</p>
                            <p class="text-gray-500 mt-2">Intense fluorescent colors that will make any text pop for easy visibility.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Fluorescent Highlighter" data-price="130" data-img="https://img.drz.lazcdn.com/static/lk/p/d49798a634e891e2458e2ef36d58c800.jpg_720x720q80.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Fluorescent Highlighter" data-price="130" data-img="https://img.drz.lazcdn.com/static/lk/p/d49798a634e891e2458e2ef36d58c800.jpg_720x720q80.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- Sticky notes -->
                    <div id="stationery-item-6" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://down-sg.img.susercontent.com/file/sg-11134201-7rdyg-m0en0kbb6q4p29" alt="Colorful Sticky Notes" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Colorful Sticky Notes</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 200</p>
                            <p class="text-gray-500 mt-2">A set of colorful sticky notes perfect for organizing your tasks and reminders.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Colorful Sticky Notes" data-price="200" data-img="https://down-sg.img.susercontent.com/file/sg-11134201-7rdyg-m0en0kbb6q4p29">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Colorful Sticky Notes" data-price="200" data-img="https://down-sg.img.susercontent.com/file/sg-11134201-7rdyg-m0en0kbb6q4p29">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-7" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://images-cdn.ubuy.co.in/6353e4437e944b52c93d044e-early-buy-6-pads-lined-sticky-notes-with.jpg" alt="Pastel Sticky Notes" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Pastel Sticky Notes</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 180</p>
                            <p class="text-gray-500 mt-2">A set of pastel-colored sticky notes, perfect for a soft and elegant organization.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Pastel Sticky Notes" data-price="180" data-img="https://images-cdn.ubuy.co.in/6353e4437e944b52c93d044e-early-buy-6-pads-lined-sticky-notes-with.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Pastel Sticky Notes" data-price="180" data-img="https://images-cdn.ubuy.co.in/6353e4437e944b52c93d044e-early-buy-6-pads-lined-sticky-notes-with.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-8" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71mUHGatCzL.jpg" alt="Square Sticky Notes" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Square Sticky Notes</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 250</p>
                            <p class="text-gray-500 mt-2">A set of square sticky notes, perfect for writing larger notes and reminders.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Square Sticky Notes" data-price="250" data-img="https://m.media-amazon.com/images/I/71mUHGatCzL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Square Sticky Notes" data-price="250" data-img="https://m.media-amazon.com/images/I/71mUHGatCzL.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <!-- Transparent tapes -->
                    <div id="stationery-item-7" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://c.superdelivery.com/ip/n/sa/1200/630/www.superdelivery.com/product_image/012/253/855/12253855_s_1001.jpg" alt="Transparent Tape" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Transparent Tape</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 80</p>
                            <p class="text-gray-500 mt-2">Durable and clear tape, ideal for wrapping, crafting, and general use.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Transparent Tape" data-price="80" data-img="https://c.superdelivery.com/ip/n/sa/1200/630/www.superdelivery.com/product_image/012/253/855/12253855_s_1001.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Transparent Tape" data-price="80" data-img="https://c.superdelivery.com/ip/n/sa/1200/630/www.superdelivery.com/product_image/012/253/855/12253855_s_1001.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-8" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/51dywgoD9zL._SL1500_.jpg" alt="Clear Packing Tape" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Clear Packing Tape</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 120</p>
                            <p class="text-gray-500 mt-2">Strong and adhesive packing tape for secure packaging and sealing.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Clear Packing Tape" data-price="120" data-img="https://m.media-amazon.com/images/I/51dywgoD9zL._SL1500_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Clear Packing Tape" data-price="120" data-img="https://m.media-amazon.com/images/I/51dywgoD9zL._SL1500_.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-9" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://img.drz.lazcdn.com/static/lk/p/6ed9f69fded6dddbecee8fd4d6cc28ec.jpg_720x720q80.jpg" alt="Office Transparent Tape" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Office Transparent Tape</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 90</p>
                            <p class="text-gray-500 mt-2">Versatile office tape for general use, ideal for documents and office projects.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Office Transparent Tape" data-price="90" data-img="https://img.drz.lazcdn.com/static/lk/p/6ed9f69fded6dddbecee8fd4d6cc28ec.jpg_720x720q80.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Office Transparent Tape" data-price="90" data-img="https://img.drz.lazcdn.com/static/lk/p/6ed9f69fded6dddbecee8fd4d6cc28ec.jpg_720x720q80.jpg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-8" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.tyzacktools.com/images/thumbs/0003207_shinwa-japanese-150mm-stainless-steel-rule-13005_625.jpeg" alt="Metal Ruler" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Metal Ruler</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 300</p>
                            <p class="text-gray-500 mt-2">Premium stainless steel ruler for precise measurements and durability.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Metal Ruler" data-price="300" data-img="https://www.tyzacktools.com/images/thumbs/0003207_shinwa-japanese-150mm-stainless-steel-rule-13005_625.jpeg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Metal Ruler" data-price="300" data-img="https://www.tyzacktools.com/images/thumbs/0003207_shinwa-japanese-150mm-stainless-steel-rule-13005_625.jpeg">Add to Wishlist</button>
                        </div>
                    </div>

                    <div id="stationery-item-9" class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://i.ebayimg.com/images/g/~y0AAOSwtT5hXaEV/s-l500.webp" alt="Japanese Samurai Action Figure" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Samurai Action Figure</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 4,500</p>
                            <p class="text-gray-500 mt-2">Intricately designed action figure capturing the elegance of samurai culture.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Samurai Action Figure" data-price="4500" data-img="https://i.ebayimg.com/images/g/~y0AAOSwtT5hXaEV/s-l500.webp">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese Samurai Action Figure" data-price="4500" data-img="https://i.ebayimg.com/images/g/~y0AAOSwtT5hXaEV/s-l500.webp">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br><br><br>

            <!-- Japanese Language Learning Books -->
            <div class="category-section mt-8" id="japanese-language-learning-section">
                <h2 class="text-xl font-semibold mb-4">Japanese Language Learning Books</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/61I7nyAHeLL.jpg" alt="Genki I" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Genki I: An Integrated Course in Elementary Japanese</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1200</p>
                            <p class="text-gray-700 mt-2">A comprehensive textbook for beginners, this book covers essential grammar, vocabulary, and kanji for elementary-level learners of Japanese.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Genki I: An Integrated Course in Elementary Japanese" data-price="1200" data-img="https://m.media-amazon.com/images/I/61I7nyAHeLL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Genki I: An Integrated Course in Elementary Japanese" data-price="1200" data-img="https://m.media-amazon.com/images/I/61I7nyAHeLL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/51R397uXFwL._SL1002_.jpg" alt="Minna no Nihongo I" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Minna no Nihongo I</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1500</p>
                            <p class="text-gray-700 mt-2">An easy-to-follow textbook designed for beginners, featuring a mix of grammar and conversation practice with extensive exercises.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Minna no Nihongo I" data-price="1500" data-img="https://m.media-amazon.com/images/I/51R397uXFwL._SL1002_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Minna no Nihongo I" data-price="1500" data-img="https://m.media-amazon.com/images/I/51R397uXFwL._SL1002_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/61qOcx0TkCL._AC_UF1000,1000_QL80_.jpg" alt="Japanese for Busy People I" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese for Busy People I</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1300</p>
                            <p class="text-gray-700 mt-2">A practical guide designed for busy learners, this book teaches essential Japanese grammar and phrases with easy-to-understand lessons.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese for Busy People I" data-price="1300" data-img="https://m.media-amazon.com/images/I/61qOcx0TkCL._AC_UF1000,1000_QL80_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese for Busy People I" data-price="1300" data-img="https://m.media-amazon.com/images/I/61qOcx0TkCL._AC_UF1000,1000_QL80_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/61JR6St41mL.jpg" alt="Remembering the Kanji I" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Remembering the Kanji I</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2000</p>
                            <p class="text-gray-700 mt-2">A helpful guide for memorizing kanji characters, focusing on visual mnemonics to enhance memory and recall of kanji.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Remembering the Kanji I" data-price="2000" data-img="https://m.media-amazon.com/images/I/61JR6St41mL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Remembering the Kanji I" data-price="2000" data-img="https://m.media-amazon.com/images/I/61JR6St41mL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/612UJcw3HkL._SL1303_.jpg" alt="Japanese from Zero! 1" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese from Zero! 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1400</p>
                            <p class="text-gray-700 mt-2">A fun and engaging textbook for beginners with a clear approach to teaching grammar, kana, and kanji through interactive exercises.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese from Zero! 1" data-price="1400" data-img="https://m.media-amazon.com/images/I/612UJcw3HkL._SL1303_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese from Zero! 1" data-price="1400" data-img="https://m.media-amazon.com/images/I/612UJcw3HkL._SL1303_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://sakurabookstore.com/cdn/shop/products/1bZq_UK6ZcR9atqJL7n5muLmdrOizcmVG_a8a35022-4508-48b5-8736-bea789a5f500_800x.jpg?v=1612753434" alt="A Dictionary of Basic Japanese Grammar" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">A Dictionary of Basic Japanese Grammar</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1800</p>
                            <p class="text-gray-700 mt-2">This comprehensive reference book provides detailed explanations of essential Japanese grammar points with example sentences.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="A Dictionary of Basic Japanese Grammar" data-price="1800" data-img="https://sakurabookstore.com/cdn/shop/products/1bZq_UK6ZcR9atqJL7n5muLmdrOizcmVG_a8a35022-4508-48b5-8736-bea789a5f500_800x.jpg?v=1612753434">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="A Dictionary of Basic Japanese Grammar" data-price="1800" data-img="https://sakurabookstore.com/cdn/shop/products/1bZq_UK6ZcR9atqJL7n5muLmdrOizcmVG_a8a35022-4508-48b5-8736-bea789a5f500_800x.jpg?v=1612753434">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Japanese Culture and History -->
            <div class="category-section mt-8" id="japanese-culture-history-section">
                <h2 class="text-xl font-semibold mb-4">Japanese Culture and History</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/61NKH3YFIcL.jpg" alt="The World of the Shining Prince" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">The World of the Shining Prince</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2500</p>
                            <p class="text-gray-600 mt-2">This book takes you into the world of Heian-era Japan, exploring the life and culture of the aristocracy through the lens of the famous *Genji Monogatari* (The Tale of Genji). A fascinating read for anyone interested in Japanese history and classical literature.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="The World of the Shining Prince" data-price="2500" data-img="https://m.media-amazon.com/images/I/61NKH3YFIcL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="The World of the Shining Prince" data-price="2500" data-img="https://m.media-amazon.com/images/I/61NKH3YFIcL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://img2.activant-inet.com/custom/039096/Image/g9781974727834.jpg" alt="The Tale of the Princess Kaguya" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">The Tale of the Princess Kaguya</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2300</p>
                            <p class="text-gray-600 mt-2">A captivating retelling of the Japanese folktale "The Tale of the Bamboo Cutter," this book delves into themes of love, beauty, and the transient nature of life. It's a visual and poetic masterpiece.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="The Tale of the Princess Kaguya" data-price="2300" data-img="https://img2.activant-inet.com/custom/039096/Image/g9781974727834.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="The Tale of the Princess Kaguya" data-price="2300" data-img="https://img2.activant-inet.com/custom/039096/Image/g9781974727834.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71tU0lzeOGL._AC_UF1000,1000_QL80_.jpg" alt="Japanese Women: An Annotated Bibliography" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Women: An Annotated Bibliography</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2700</p>
                            <p class="text-gray-600 mt-2">A comprehensive resource for those interested in the role of women throughout Japanese history, culture, and literature. This book provides annotated references to help understand the complexities of gender and society in Japan.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Women: An Annotated Bibliography" data-price="2700" data-img="https://m.media-amazon.com/images/I/71tU0lzeOGL._AC_UF1000,1000_QL80_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese Women: An Annotated Bibliography" data-price="2700" data-img="https://m.media-amazon.com/images/I/71tU0lzeOGL._AC_UF1000,1000_QL80_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manga and Graphic Novels -->
            <div class="category-section mt-8" id="manga-graphic-section">
                <h2 class="text-xl font-semibold mb-4">Manga and Graphic Novels</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71WECnGLtIL._SL1200_.jpg" alt="Naruto Vol. 1" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Naruto Vol. 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1200</p>
                            <p class="text-gray-600 mt-2">The first volume of the legendary series, *Naruto*, introduces the journey of Naruto Uzumaki, a young ninja with dreams of becoming the strongest ninja and the leader of his village. A must-read for fans of action, adventure, and unforgettable characters.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Naruto Vol. 1" data-price="1200" data-img="https://m.media-amazon.com/images/I/71WECnGLtIL._SL1200_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Naruto Vol. 1" data-price="1200" data-img="https://m.media-amazon.com/images/I/71WECnGLtIL._SL1200_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71R3vtg1ghL._SY466_.jpg" alt="Naruto Vol. 2" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Naruto Vol. 2</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1200</p>
                            <p class="text-gray-600 mt-2">Continuing the story of Naruto's growth, *Naruto Vol. 2* deepens his struggles and friendships with fellow ninjas. As Naruto faces new challenges, his bonds with others start to take shape, making this volume an exciting continuation of his epic journey.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Naruto Vol. 2" data-price="1200" data-img="https://m.media-amazon.com/images/I/71R3vtg1ghL._SY466_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Naruto Vol. 2" data-price="1200" data-img="https://m.media-amazon.com/images/I/71R3vtg1ghL._SY466_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://sw6.elbenwald.de/media/ba/b6/27/1629839118/E1066435_1.jpg" alt="Demon Slayer: Kimetsu no Yaiba Vol. 1" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Demon Slayer: Kimetsu no Yaiba Vol. 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1400</p>
                            <p class="text-gray-600 mt-2">A compelling story of swords and demons, *Demon Slayer* introduces Tanjiro Kamado, a boy determined to save his demon-turned sister. With breathtaking action and emotional depth, this manga has captured the hearts of readers worldwide.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Demon Slayer: Kimetsu no Yaiba Vol. 1" data-price="1400" data-img="https://sw6.elbenwald.de/media/ba/b6/27/1629839118/E1066435_1.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Demon Slayer: Kimetsu no Yaiba Vol. 1" data-price="1400" data-img="https://sw6.elbenwald.de/media/ba/b6/27/1629839118/E1066435_1.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books on Japanese Cuisine -->
            <div class="category-section mt-8" id="books-japanese-cuisine-section">
                <h2 class="text-xl font-semibold mb-4">Books on Japanese Cuisine</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/817gBv8WfYL.jpg" alt="Japanese Cooking: A Simple Art" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Cooking: A Simple Art</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1800</p>
                            <p class="text-gray-600 mt-2">This book offers easy-to-follow recipes and step-by-step instructions to create authentic Japanese dishes. Perfect for beginners and experienced cooks alike.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Cooking: A Simple Art" data-price="1800" data-img="https://m.media-amazon.com/images/I/817gBv8WfYL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese Cooking: A Simple Art" data-price="1800" data-img="https://m.media-amazon.com/images/I/817gBv8WfYL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/81a0XVzM9TL.jpg" alt="The Japanese Kitchen: 250 Recipes in a Traditional Style" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">The Japanese Kitchen: 250 Recipes in a Traditional Style</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2000</p>
                            <p class="text-gray-600 mt-2">Explore a rich collection of traditional Japanese recipes, including sushi, tempura, ramen, and more. This book is a comprehensive guide to Japanese cooking techniques.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="The Japanese Kitchen: 250 Recipes in a Traditional Style" data-price="2000" data-img="https://m.media-amazon.com/images/I/81a0XVzM9TL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="The Japanese Kitchen: 250 Recipes in a Traditional Style" data-price="2000" data-img="https://m.media-amazon.com/images/I/81a0XVzM9TL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/41SOtH8MFUL._AC_UF1000,1000_QL80_.jpg" alt="Japanese Cooking: A Simple Art 2" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Cooking: A Simple Art 2</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1800</p>
                            <p class="text-gray-600 mt-2">A continuation of the first volume, this book introduces more advanced dishes and cooking techniques, expanding your knowledge of Japanese cuisine.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Cooking: A Simple Art 2" data-price="1800" data-img="https://m.media-amazon.com/images/I/41SOtH8MFUL._AC_UF1000,1000_QL80_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese Cooking: A Simple Art 2" data-price="1800" data-img="https://m.media-amazon.com/images/I/41SOtH8MFUL._AC_UF1000,1000_QL80_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books for Japanese Calligraphy -->
            <div class="category-section mt-8" id="books-japanese-calligraphy-section">
                <h2 class="text-xl font-semibold mb-4">Books for Japanese Calligraphy</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://cdn.shopify.com/s/files/1/0625/6679/3413/files/The_20Simple_20Art_20of_20Japanese_20Calligraphy.jpg?v=1716704007" alt="The Art of Japanese Calligraphy" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">The Art of Japanese Calligraphy</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1500</p>
                            <p class="text-gray-600 mt-2">This book is an introduction to the delicate art of Japanese calligraphy, featuring the basic strokes, kanji characters, and tips for mastering the brush technique.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="The Art of Japanese Calligraphy" data-price="1500" data-img="https://cdn.shopify.com/s/files/1/0625/6679/3413/files/The_20Simple_20Art_20of_20Japanese_20Calligraphy.jpg?v=1716704007">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="The Art of Japanese Calligraphy" data-price="1500" data-img="https://cdn.shopify.com/s/files/1/0625/6679/3413/files/The_20Simple_20Art_20of_20Japanese_20Calligraphy.jpg?v=1716704007">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://i.pinimg.com/originals/98/a0/24/98a0249136a14186b19dc9cf8d7c79da.jpg" alt="Mastering Japanese Calligraphy: A Step-by-Step Guide" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Mastering Japanese Calligraphy: A Step-by-Step Guide</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1800</p>
                            <p class="text-gray-600 mt-2">This detailed step-by-step guide offers in-depth instructions for creating beautiful Japanese calligraphy, making it ideal for both beginners and advanced practitioners.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Mastering Japanese Calligraphy: A Step-by-Step Guide" data-price="1800" data-img="https://i.pinimg.com/originals/98/a0/24/98a0249136a14186b19dc9cf8d7c79da.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Mastering Japanese Calligraphy: A Step-by-Step Guide" data-price="1800" data-img="https://i.pinimg.com/originals/98/a0/24/98a0249136a14186b19dc9cf8d7c79da.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://images.booksense.com/images/450/421/9780990421450.jpg" alt="The Beauty of Japanese Calligraphy" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">The Beauty of Japanese Calligraphy</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1600</p>
                            <p class="text-gray-600 mt-2">Learn the art of brush writing with this book, featuring examples from Japanese calligraphy masters and exercises for you to practice at home.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="The Beauty of Japanese Calligraphy" data-price="1600" data-img="https://images.booksense.com/images/450/421/9780990421450.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="The Beauty of Japanese Calligraphy" data-price="1600" data-img="https://images.booksense.com/images/450/421/9780990421450.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br><br><br>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8" id="tea-snacks-section">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://colombomall.lk/wp-content/uploads/2024/02/51mYq0FawbL.jpg" alt="Matcha Tea" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Matcha Green Tea</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,500</p>
                            <p class="text-gray-500 mt-2">A premium quality green tea powder made from young, finely ground leaves. Perfect for making traditional matcha drinks and desserts.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Matcha Green Tea" data-price="1500" data-img="https://colombomall.lk/wp-content/uploads/2024/02/51mYq0FawbL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Matcha Green Tea" data-price="1500" data-img="https://colombomall.lk/wp-content/uploads/2024/02/51mYq0FawbL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/91HADrr5t+L._SL1500_.jpg" alt="Sencha Tea" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Sencha Green Tea</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <p class="text-gray-500 mt-2">A traditional Japanese green tea with a delicate balance of sweet and grassy flavors, perfect for any time of day.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Sencha Green Tea" data-price="1200" data-img="https://m.media-amazon.com/images/I/91HADrr5t+L._SL1500_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Sencha Green Tea" data-price="1200" data-img="https://m.media-amazon.com/images/I/91HADrr5t+L._SL1500_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71yPq+lYqQL._SL1500_.jpg" alt="Yokan" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Yokan (Red Bean Jelly)</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <p class="text-gray-500 mt-2">A traditional Japanese dessert made from sweet red bean paste, agar, and sugar. It has a smooth texture and is often served chilled.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Yokan (Red Bean Jelly)" data-price="800" data-img="https://m.media-amazon.com/images/I/71yPq+lYqQL._SL1500_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Yokan (Red Bean Jelly)" data-price="800" data-img="https://m.media-amazon.com/images/I/71yPq+lYqQL._SL1500_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/91ZcOBQN+PL.jpg" alt="Mochi" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Mochi (Sweet Rice Cake)</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,000</p>
                            <p class="text-gray-500 mt-2">A chewy, soft rice cake made with glutinous rice flour and filled with sweet fillings such as red bean paste. A popular Japanese snack.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Mochi (Sweet Rice Cake)" data-price="1000" data-img="https://m.media-amazon.com/images/I/91ZcOBQN+PL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Mochi (Sweet Rice Cake)" data-price="1000" data-img="https://m.media-amazon.com/images/I/91ZcOBQN+PL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://i.ebayimg.com/images/g/XvgAAOSwfVFcflUW/s-l400.jpg" alt="Matcha Sweets" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Matcha Sweets Set</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,800</p>
                            <p class="text-gray-500 mt-2">A delightful set of various sweets made with matcha green tea, offering a sweet and earthy taste in every bite.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Matcha Sweets Set" data-price="1800" data-img="https://i.ebayimg.com/images/g/XvgAAOSwfVFcflUW/s-l400.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Matcha Sweets Set" data-price="1800" data-img="https://i.ebayimg.com/images/g/XvgAAOSwfVFcflUW/s-l400.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://i0.wp.com/tokyotreatblog.wpcomstaging.com/wp-content/uploads/2022/11/shutterstock_1883044177-1-1.png?fit=1024%2C683&ssl=1" alt="Japanese Pocky" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Pocky Sticks</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 600</p>
                            <p class="text-gray-500 mt-2">Crunchy biscuit sticks covered in various flavored coatings such as chocolate, strawberry, and matcha. A popular snack among Japanese people.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Pocky Sticks" data-price="600" data-img="https://i0.wp.com/tokyotreatblog.wpcomstaging.com/wp-content/uploads/2022/11/shutterstock_1883044177-1-1.png?fit=1024%2C683&ssl=1">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Japanese Pocky Sticks" data-price="600" data-img="https://i0.wp.com/tokyotreatblog.wpcomstaging.com/wp-content/uploads/2022/11/shutterstock_1883044177-1-1.png?fit=1024%2C683&ssl=1">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br><br><br>

            <!-- Home & Interior Items -->
            <div class="category-section mt-8" id="home-interior-section">
                <h2 class="text-xl font-semibold mb-4">Home & Interior Items</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://cdn.shopify.com/s/files/1/0437/4950/7224/t/14/assets/japanese-vase-matches-interior-1675392224730.webp?v=1675392226" alt="Decorative Vase" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Decorative Vase</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 3,200</p>
                            <p class="text-gray-600 mt-2">A beautifully designed vase, perfect for enhancing any living space with a touch of Japanese elegance. Ideal for flowers or as a standalone decorative piece.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Decorative Vase" data-price="3200" data-img="https://cdn.shopify.com/s/files/1/0437/4950/7224/t/14/assets/japanese-vase-matches-interior-1675392224730.webp?v=1675392226">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Decorative Vase" data-price="3200" data-img="https://cdn.shopify.com/s/files/1/0437/4950/7224/t/14/assets/japanese-vase-matches-interior-1675392224730.webp?v=1675392226">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/51GPM1h48oL._AC_US750_.jpg" alt="Wooden Coffee Table" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Wooden Coffee Table</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 5,500</p>
                            <p class="text-gray-600 mt-2">Crafted from high-quality wood, this coffee table offers a timeless look and a sturdy surface for your drinks, books, or decorations.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Wooden Coffee Table" data-price="5500" data-img="https://m.media-amazon.com/images/I/51GPM1h48oL._AC_US750_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Wooden Coffee Table" data-price="5500" data-img="https://m.media-amazon.com/images/I/51GPM1h48oL._AC_US750_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71dtjB-bOCL._AC_UF350,350_QL80_.jpg" alt="Floor Lamp" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Floor Lamp</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 4,800</p>
                            <p class="text-gray-600 mt-2">An elegant floor lamp that provides ambient lighting, perfect for creating a cozy atmosphere in your home or office.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Floor Lamp" data-price="4800" data-img="https://m.media-amazon.com/images/I/71dtjB-bOCL._AC_UF350,350_QL80_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Floor Lamp" data-price="4800" data-img="https://m.media-amazon.com/images/I/71dtjB-bOCL._AC_UF350,350_QL80_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71UFnEfphiL._AC_UF894,1000_QL80_.jpg" alt="Wall Art" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Wall Art</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 2,200</p>
                            <p class="text-gray-600 mt-2">Bring life to your walls with this exquisite piece of art, designed to evoke the serenity and beauty of traditional Japanese aesthetics.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Wall Art" data-price="2200" data-img="https://m.media-amazon.com/images/I/71UFnEfphiL._AC_UF894,1000_QL80_.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Wall Art" data-price="2200" data-img="https://m.media-amazon.com/images/I/71UFnEfphiL._AC_UF894,1000_QL80_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71Upwa6U8qL.jpg" alt="Indoor Plant Pot" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Indoor Plant Pot</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,800</p>
                            <p class="text-gray-600 mt-2">A stylish indoor plant pot to enhance your home decor. Perfect for plants such as bonsais, orchids, or succulents.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Indoor Plant Pot" data-price="1800" data-img="https://m.media-amazon.com/images/I/71Upwa6U8qL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Indoor Plant Pot" data-price="1800" data-img="https://m.media-amazon.com/images/I/71Upwa6U8qL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71npHdzU3fL.jpg" alt="Throw Blanket" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Throw Blanket</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,500</p>
                            <p class="text-gray-600 mt-2">This soft and cozy throw blanket is perfect for adding warmth and comfort to your couch, bed, or favorite chair.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Throw Blanket" data-price="1500" data-img="https://m.media-amazon.com/images/I/71npHdzU3fL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Throw Blanket" data-price="1500" data-img="https://m.media-amazon.com/images/I/71npHdzU3fL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br><br><br>

            <!-- Health & Beauty Items -->
            <div class="category-section mt-8" id="health-beauty-section">
                <h2 class="text-xl font-semibold mb-4">Health & Beauty Items</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://cdn.shopify.com/s/files/1/0512/5429/6766/files/japanese-facial-mask5_480x480.png?v=1695372576" alt="Japanese Face Mask" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Face Mask</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,500</p>
                            <p class="text-gray-500 mt-2">A nourishing Japanese face mask designed to hydrate and refresh your skin with a blend of traditional ingredients for a glowing complexion.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Face Mask" data-price="1500" data-img="https://cdn.shopify.com/s/files/1/0512/5429/6766/files/japanese-facial-mask5_480x480.png?v=1695372576">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Japanese Face Mask" data-price="1500" data-img="https://cdn.shopify.com/s/files/1/0512/5429/6766/files/japanese-facial-mask5_480x480.png?v=1695372576">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://cdn.shopify.com/s/files/1/1969/5775/files/topics_pic01_sp_480x480.png?v=1707100431" alt="Herbal Shampoo" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Herbal Shampoo</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,800</p>
                            <p class="text-gray-500 mt-2">A gentle herbal shampoo formulated with natural ingredients to cleanse and nourish your hair, leaving it soft and shiny.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Herbal Shampoo" data-price="1800" data-img="https://cdn.shopify.com/s/files/1/1969/5775/files/topics_pic01_sp_480x480.png?v=1707100431">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Herbal Shampoo" data-price="1800" data-img="https://cdn.shopify.com/s/files/1/1969/5775/files/topics_pic01_sp_480x480.png?v=1707100431">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://rimage.gnst.jp/livejapan.com/public/article/detail/a/30/00/a3000177/img/basic/a3000177_main.jpg" alt="Japanese Bath Salts" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Bath Salts</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <p class="text-gray-500 mt-2">A relaxing bath salt enriched with Japanese botanical extracts that soothe the body and mind, ideal for unwinding after a long day.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Bath Salts" data-price="1200" data-img="https://rimage.gnst.jp/livejapan.com/public/article/detail/a/30/00/a3000177/img/basic/a3000177_main.jpg">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Japanese Bath Salts" data-price="1200" data-img="https://rimage.gnst.jp/livejapan.com/public/article/detail/a/30/00/a3000177/img/basic/a3000177_main.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/71As88Uq3ML._SL1500_.jpg" alt="Moisturizing Cream" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Moisturizing Cream</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,000</p>
                            <p class="text-gray-500 mt-2">A rich moisturizing cream that deeply nourishes and hydrates the skin, providing long-lasting softness and protection against dryness.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Moisturizing Cream" data-price="1000" data-img="https://m.media-amazon.com/images/I/71As88Uq3ML._SL1500_.jpg">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Moisturizing Cream" data-price="1000" data-img="https://m.media-amazon.com/images/I/71As88Uq3ML._SL1500_.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://static.wixstatic.com/media/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg/v1/fill/w_980,h_980,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg" alt="Japanese Skincare Set" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Japanese Skincare Set</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 3,500</p>
                            <p class="text-gray-500 mt-2">A luxurious skincare set featuring premium Japanese products that cleanse, hydrate, and rejuvenate the skin for a radiant glow.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Japanese Skincare Set" data-price="3500" data-img="https://static.wixstatic.com/media/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg/v1/fill/w_980,h_980,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Japanese Skincare Set" data-price="3500" data-img="https://static.wixstatic.com/media/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg/v1/fill/w_980,h_980,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/955b86_5fc8f1d4218e4d30b7411d6db8327bca~mv2.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.gosupps.com/media/catalog/product/7/1/71nsO4HKT0L.jpg" alt="Hair Treatment Oil" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Hair Treatment Oil</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,800</p>
                            <p class="text-gray-500 mt-2">An intensive hair treatment oil made from Japanese botanicals that nourishes and repairs damaged hair, leaving it silky smooth and manageable.</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Hair Treatment Oil" data-price="1800" data-img="https://www.gosupps.com/media/catalog/product/7/1/71nsO4HKT0L.jpg">Add to Cart</button>
                            <button class="bg-blue-400 text-white mt-2 py-2 px-4 rounded hover:bg-blue-500 add-to-wishlist" data-name="Hair Treatment Oil" data-price="1800" data-img="https://www.gosupps.com/media/catalog/product/7/1/71nsO4HKT0L.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <br><br><br><br><br>

            <!-- Fashion & Lifestyle -->
            <div class="category-section mt-8" id="fashion-lifestyle-section">
                <h2 class="text-xl font-semibold mb-4">Fashion & Lifestyle</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://samurai-store.com/images2/H012/H012-kabuto-helmet.jpg" alt="Kabuto Helmet" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Kabuto Helmet</h3>
                            <p class="text-gray-600 mt-2">A decorative samurai helmet symbolizing strength and protection.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 3,500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Kabuto Helmet" data-price="3500" data-img="https://samurai-store.com/images2/H012/H012-kabuto-helmet.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Kabuto Helmet" data-price="3500" data-img="https://samurai-store.com/images2/H012/H012-kabuto-helmet.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://m.media-amazon.com/images/I/61kmnssA8RL.jpg" alt="Koinobori (Carp Streamer)" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Koinobori (Carp Streamer)</h3>
                            <p class="text-gray-600 mt-2">Traditional carp-shaped windsocks flown for Children's Day.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Koinobori (Carp Streamer)" data-price="1800" data-img="https://m.media-amazon.com/images/I/61kmnssA8RL.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Koinobori (Carp Streamer)" data-price="1800" data-img="https://m.media-amazon.com/images/I/61kmnssA8RL.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.worthingtongallery.com/wp-content/uploads/2016/03/ikebana-1.jpg" alt="Ikebana Vase" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Ikebana Vase</h3>
                            <p class="text-gray-600 mt-2">Elegant vases designed for traditional Japanese flower arrangements.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 2,400</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Ikebana Vase" data-price="2400" data-img="https://www.worthingtongallery.com/wp-content/uploads/2016/03/ikebana-1.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Ikebana Vase" data-price="2400" data-img="https://www.worthingtongallery.com/wp-content/uploads/2016/03/ikebana-1.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://i.etsystatic.com/9308450/r/il/e8052d/5722865834/il_fullxfull.5722865834_5f59.jpg" alt="Uchiwa Fan" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Uchiwa Fan</h3>
                            <p class="text-gray-600 mt-2">Hand-painted fans used for summer festivals and traditional dances.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 750</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Uchiwa Fan" data-price="750" data-img="https://i.etsystatic.com/9308450/r/il/e8052d/5722865834/il_fullxfull.5722865834_5f59.jpg">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Uchiwa Fan" data-price="750" data-img="https://i.etsystatic.com/9308450/r/il/e8052d/5722865834/il_fullxfull.5722865834_5f59.jpg">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://hackaday.com/wp-content/uploads/2020/06/shojilamp_thumb.jpg?w=600&h=600" alt="Shoji Lantern" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Shoji Lantern</h3>
                            <p class="text-gray-600 mt-2">Traditional paper lanterns to create warm, ambient lighting.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 4,000</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Shoji Lantern" data-price="4000" data-img="https://hackaday.com/wp-content/uploads/2020/06/shojilamp_thumb.jpg?w=600&h=600">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Shoji Lantern" data-price="4000" data-img="https://hackaday.com/wp-content/uploads/2020/06/shojilamp_thumb.jpg?w=600&h=600">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://www.spiritjapan.com/cdn/shop/products/H179a15678c074e73a10c1a3536fc2e55M_1200x1200.jpg?v=1629284950" alt="Daruma Doll" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Daruma Doll</h3>
                            <p class="text-gray-600 mt-2">A symbol of perseverance and good luck, used for goal-setting.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Daruma Doll" data-price="1500" data-img="https://www.spiritjapan.com/cdn/shop/products/H179a15678c074e73a10c1a3536fc2e55M_1200x1200.jpg?v=1629284950">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Daruma Doll" data-price="1500" data-img="https://www.spiritjapan.com/cdn/shop/products/H179a15678c074e73a10c1a3536fc2e55M_1200x1200.jpg?v=1629284950">Add to Wishlist</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="https://youeni.com/cdn/shop/products/lucky-cat-maneki-neko-light-lighting-the-kawaii-shoppu-2.jpg?v=1677165416&width=1445" alt="Maneki-Neko" class="w-full h-64 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Maneki-Neko</h3>
                            <p class="text-gray-600 mt-2">The 'beckoning cat' that brings good fortune and wealth.</p>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" data-name="Maneki-Neko" data-price="1200" data-img="https://youeni.com/cdn/shop/products/lucky-cat-maneki-neko-light-lighting-the-kawaii-shoppu-2.jpg?v=1677165416&width=1445">Add to Cart</button>
                            <button class="bg-blue-300 text-white mt-2 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" data-name="Maneki-Neko" data-price="1200" data-img="https://youeni.com/cdn/shop/products/lucky-cat-maneki-neko-light-lighting-the-kawaii-shoppu-2.jpg?v=1677165416&width=1445">Add to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div id="cart-sidebar" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="absolute top-0 right-0 w-1/3 bg-white h-full shadow-lg p-6 overflow-y-auto">
                    <!-- Cross Icon to Close Sidebar -->
                    <button id="close-cart" class="absolute top-4 right-4 text-2xl text-gray-600 hover:text-gray-900">
                        &times;
                    </button>

                    <h2 class="text-xl font-semibold mb-4">Your Cart</h2>

                    <!-- Cart Summary: Items Count and Total Price -->
                    <div id="cart-summary" class="mb-6">
                        <p id="cart-item-count" class="text-lg">Items: 0</p>
                        <p id="cart-total-price" class="text-lg">Total: Rs. 0.00</p>
                    </div>

                    <!-- Cart Items -->
                    <div id="cart-items">
                        <!-- Cart items will be dynamically inserted here -->
                    </div>

                    <!-- Subtotal and Checkout Button -->
                    <div class="mt-6 flex justify-between items-center">
                        <p id="cart-subtotal" class="font-semibold">Subtotal: Rs. 0.00</p>
                    </div>

                    <!-- Full-width Checkout Button -->
                    <button id="checkout-btn" class="w-full bg-green-500 text-white py-3 mt-4 rounded hover:bg-green-600">
                        Checkout
                    </button>
                </div>
            </div>

            <!-- Wishlist Sidebar -->
            <div id="wishlist-sidebar" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="absolute top-0 right-0 w-1/3 bg-white h-full shadow-lg p-6 overflow-y-auto">
                    <!-- Cross Icon to Close Sidebar -->
                    <button id="close-wishlist" class="absolute top-4 right-4 text-2xl text-gray-600 hover:text-gray-900">
                        &times;
                    </button>

                    <h2 class="text-xl font-semibold mb-4">Your Wishlist</h2>

                    <!-- Wishlist Summary: Items Count -->
                    <div id="wishlist-summary" class="mb-6">
                        <p id="wishlist-item-count" class="text-lg">Items: 0</p>
                    </div>

                    <!-- Wishlist Items -->
                    <div id="wishlist-items">
                        <!-- Wishlist items will be dynamically inserted here -->
                    </div>
                </div>
            </div>

            <!-- Success Message Popup -->
            <div id="success-message" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white py-2 px-4 rounded shadow-lg opacity-0 transition-opacity duration-500">
                Successfully Added to Wishlist
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
    document.addEventListener("DOMContentLoaded", () => {
        const header = document.getElementById("header");
        header.classList.remove("hidden");
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


    //Retrieve from json and Display the Products
    document.addEventListener("DOMContentLoaded", function () {
        fetch("../json/products.json") // Load the JSON data
            .then(response => response.json())
            .then(products => {
                const container = document.getElementById("new-arrivals-section").querySelector(".grid");

                products.forEach(product => {
                    const productHTML = `
                        <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform" id="${product.id}">
                            <img src="${product.image}" alt="${product.name}" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-medium">${product.name}</h3>
                                <p class="text-gray-600 mt-2">${product.description}</p>
                                <p class="text-gray-600 mt-2">Price: Rs. ${product.price}</p>
                                <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400 add-to-cart" 
                                    data-name="${product.name}" data-price="${product.price}" data-img="${product.image}">
                                    Add to Cart
                                </button>
                                <button class="bg-blue-300 text-white mt-3 py-2 px-4 rounded hover:bg-blue-400 add-to-wishlist" 
                                    data-name="${product.name}" data-price="${product.price}" data-img="${product.image}">
                                    Add to Wishlist
                                </button>
                            </div>
                        </div>
                    `;
                    container.innerHTML += productHTML;
                });
            })
            .catch(error => console.error("Error loading products:", error));
    });




    // Cart display
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartItems = document.getElementById('cart-items');
    const cartItemCount = document.getElementById('cart-item-count');
    const cartTotalPrice = document.getElementById('cart-total-price');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const checkoutButton = document.getElementById('checkout-btn');
    const closeCartButton = document.getElementById('close-cart');
    const cartIcon = document.getElementById('cart-icon'); // Cart icon
    const cartItemCountIcon = document.getElementById('cart-item-count-icon'); // Cart item count on icon

    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Function to update the cart display
    function updateCartDisplay() {
        cartItems.innerHTML = ''; // Clear current cart items
        let total = 0;
        let totalQuantity = 0;

        cart.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('mb-4', 'flex', 'items-center', 'justify-between');

            const cartItemDetails = document.createElement('div');
            cartItemDetails.classList.add('flex', 'items-center');
            cartItemDetails.innerHTML = `
                <img src="${item.img}" alt="${item.name}" class="w-16 h-16 mr-4">
                <div>
                    <h3 class="text-lg">${item.name}</h3>
                    <p class="text-gray-600">Rs. ${item.price}</p>
                </div>
            `;

            // Quantity Changer with + and -
            const quantityControls = document.createElement('div');
            quantityControls.classList.add('flex', 'items-center', 'space-x-2');
            quantityControls.innerHTML = `
                <button class="quantity-decrease text-gray-600 hover:text-gray-800">-</button>
                <span class="quantity">${item.quantity}</span>
                <button class="quantity-increase text-gray-600 hover:text-gray-800">+</button>
            `;

            // Handle increase quantity
            quantityControls.querySelector('.quantity-increase').addEventListener('click', () => {
                item.quantity += 1;
                updateCartDisplay();
            });

            // Handle decrease quantity
            quantityControls.querySelector('.quantity-decrease').addEventListener('click', () => {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                    updateCartDisplay();
                } else {
                    // Remove item if quantity is 1 and '-' is clicked
                    cart = cart.filter(cartItem => cartItem.name !== item.name);
                    updateCartDisplay();
                }
            });

            // Remove item button
            const removeButton = document.createElement('button');
            removeButton.classList.add('text-red-500', 'hover:text-red-700');
            removeButton.innerText = 'Remove';
            removeButton.addEventListener('click', () => {
                cart = cart.filter(cartItem => cartItem.name !== item.name);
                updateCartDisplay();
            });

            cartItem.appendChild(cartItemDetails);
            cartItem.appendChild(quantityControls);
            cartItem.appendChild(removeButton);
            cartItems.appendChild(cartItem);

            total += parseFloat(item.price) * item.quantity; // Multiply by quantity
            totalQuantity += item.quantity; // Sum up total quantity
        });

        // Update cart summary
        cartItemCount.innerText = `Items: ${totalQuantity}`; // Display total quantity of items
        cartTotalPrice.innerText = `Total: Rs. ${total.toFixed(2)}`;
        cartSubtotal.innerText = `Subtotal: Rs. ${total.toFixed(2)}`;
        
        // Update item count on the cart icon
        cartItemCountIcon.innerText = totalQuantity; // Show item count on the icon
        
        // Save updated cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Handle Add to Cart button click
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const name = button.getAttribute('data-name');
            const price = parseFloat(button.getAttribute('data-price'));  // Convert price to number
            const img = button.getAttribute('data-img');

            // Check if price is valid before adding it to the cart
            if (!isNaN(price)) {
                // Check if item already exists in the cart
                const existingItem = cart.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity += 1; // Increase quantity if item is already in the cart
                } else {
                    // Add new item to cart
                    cart.push({ name, price, img, quantity: 1 });
                }

                updateCartDisplay();

                // Show the cart sidebar
                cartSidebar.classList.remove('hidden');
            } else {
                console.error('Invalid price');
            }
        });
    });

    // Close sidebar when clicking the cross button
    closeCartButton.addEventListener('click', () => {
        cartSidebar.classList.add('hidden');
    });

    // Close sidebar if the user clicks outside the sidebar
    cartSidebar.addEventListener('click', (e) => {
        if (e.target === cartSidebar) {
            cartSidebar.classList.add('hidden');
        }
    });

    // Show cart sidebar when clicking the cart icon
    cartIcon.addEventListener('click', () => {
        cartSidebar.classList.remove('hidden');
    });

    // Checkout button functionality (for now, it can be a placeholder)
    checkoutButton.addEventListener('click', () => {
        alert('Proceeding to checkout...');
        window.location.href = 'checkout.php';  // Redirect to checkout.php
    });

    // Initialize the cart display on page load
    updateCartDisplay();




    document.addEventListener("DOMContentLoaded", () => {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

        // Handle Add to Wishlist button click
        document.querySelectorAll('.add-to-wishlist').forEach(button => {
            button.addEventListener('click', (event) => {
                const item = {
                    name: event.target.dataset.name,
                    price: event.target.dataset.price,
                    img: event.target.dataset.img,
                    quantity: 1
                };

                // Check if the item is already in the wishlist
                const existingItemIndex = wishlist.findIndex(wishlistItem => wishlistItem.name === item.name);
                if (existingItemIndex !== -1) {
                    // If item exists, increase the quantity
                    wishlist[existingItemIndex].quantity += 1;
                } else {
                    // If item doesn't exist, add it to the wishlist
                    wishlist.push(item);
                }

                // Save updated wishlist to localStorage
                localStorage.setItem('wishlist', JSON.stringify(wishlist));

                // Update wishlist icon count
                updateWishlistCount();

                // Update wishlist sidebar
                updateWishlistSidebar();

                // Show success message
                showSuccessMessage();
            });
        });

        // Function to show success message
        function showSuccessMessage() {
            const successMessage = document.getElementById('success-message');
            successMessage.style.visibility = 'visible';
            successMessage.style.opacity = 1;

            // Hide the message after 3 seconds
            setTimeout(() => {
                successMessage.style.opacity = 0;
                successMessage.style.visibility = 'hidden';
            }, 3000);
        }

        // Function to update wishlist count
        function updateWishlistCount() {
            document.getElementById('wishlist-count').textContent = wishlist.length;
            document.getElementById('wishlist-item-count').textContent = `Items: ${wishlist.length}`;
        }

        // Function to update the wishlist sidebar
        function updateWishlistSidebar() {
            const wishlistItemsContainer = document.getElementById('wishlist-items');
            wishlistItemsContainer.innerHTML = '';

            wishlist.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('mb-4', 'flex', 'items-center', 'justify-between');

                const itemDetails = document.createElement('div');
                itemDetails.classList.add('flex', 'items-center');
                itemDetails.innerHTML = `
                    <img src="${item.img}" alt="${item.name}" class="w-16 h-16 mr-4">
                    <div>
                        <h3 class="text-lg">${item.name}</h3>
                        <p class="text-gray-600">Rs. ${item.price}</p>
                    </div>
                `;

                const removeButton = document.createElement('button');
                removeButton.classList.add('text-red-500', 'hover:text-red-700');
                removeButton.innerText = 'Remove';
                removeButton.addEventListener('click', () => {
                    wishlist = wishlist.filter(wishlistItem => wishlistItem.name !== item.name);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    updateWishlistCount();
                    updateWishlistSidebar();
                });

                itemElement.appendChild(itemDetails);
                itemElement.appendChild(removeButton);
                wishlistItemsContainer.appendChild(itemElement);
            });
        }

        // Function to increase the quantity of an item
        function increaseQuantity(name) {
            const item = wishlist.find(wishlistItem => wishlistItem.name === name);
            if (item) {
                item.quantity += 1;
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                updateWishlistCount();
                updateWishlistSidebar();
            }
        }

        // Function to decrease the quantity of an item
        function decreaseQuantity(name) {
            const item = wishlist.find(wishlistItem => wishlistItem.name === name);
            if (item && item.quantity > 1) {
                item.quantity -= 1;
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                updateWishlistCount();
                updateWishlistSidebar();
            }
        }

        // Function to open wishlist sidebar
        function openWishlist() {
            document.getElementById('wishlist-sidebar').classList.remove('hidden');
        }

        // Function to close wishlist sidebar
        function closeWishlist() {
            document.getElementById('wishlist-sidebar').classList.add('hidden');
        }

        // Open wishlist sidebar when clicking the wishlist icon
        document.getElementById('wishlist-icon').addEventListener('click', () => {
            openWishlist();
        });

        // Close wishlist sidebar when clicking the close button
        document.getElementById('close-wishlist').addEventListener('click', () => {
            closeWishlist();
        });

        // Initialize wishlist count and sidebar on page load
        updateWishlistCount();
        updateWishlistSidebar();
    });




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

    window.addEventListener('DOMContentLoaded', (event) => {
        // Check for the hash in the URL and show the relevant sidebar
        if (window.location.hash === "#wishlist-sidebar") {
            // Open wishlist sidebar
            document.getElementById('wishlist-sidebar').style.display = 'block';
        }
        if (window.location.hash === "#cart-sidebar") {
            // Open cart sidebar
            document.getElementById('cart-sidebar').style.display = 'block';
        }
    });
</script>
</html>
