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
    <style>

        body {
            font-family: 'Noto Serif JP', serif;
        }
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
                <a href="../views/wishlist.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a4 4 0 016-3.92A4 4 0 0121 8c0 4-6 8-9 8s-9-4-9-8z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">5</span>
                </a>

                <!-- Shopping Cart Icon -->
                <a href="../views/cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.879 1.514M7 16a2 2 0 104 0M13 16a2 2 0 104 0M5.058 6H20.86l-2.35 7H7.609m2.788 5H6M21 21H6"></path>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">3</span>
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
            <!-- Gadgets & Toys Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('gadgetsToys')">
                    Gadgets & Toys
                    <span class="ml-2 transform transition duration-300" id="arrow-gadgetsToys">▼</span>
                </button>
                <div id="gadgetsToysDropdown" class="subcategory-dropdown hidden absolute left-0 mt-60">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Gadgets</a></li>
                            <li><a href="#" class="block px-4 py-2">Toys</a></li>
                            <li><a href="#" class="block px-4 py-2">Games</a></li>
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
                <div id="homeInteriorDropdown" class="subcategory-dropdown hidden absolute left-0 mt-80">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Living Room</a></li>
                            <li><a href="#" class="block px-4 py-2">Bathroom</a></li>
                            <li><a href="#" class="block px-4 py-2">Kitchen Trends</a></li>
                            <li><a href="#" class="block px-4 py-2">Workspace & Stationery</a></li>
                            <li><a href="#" class="block px-4 py-2">Tokyo Olympics</a></li>
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
                <div id="healthBeautyDropdown" class="subcategory-dropdown hidden absolute left-0 mt-80">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Beauty Gadgets</a></li>
                            <li><a href="#" class="block px-4 py-2">Massage Goods</a></li>
                            <li><a href="#" class="block px-4 py-2">Cosmetics</a></li>
                            <li><a href="#" class="block px-4 py-2">Face Packs</a></li>
                            <li><a href="#" class="block px-4 py-2">Hair Care</a></li>
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
                            <li><a href="#" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Men</a></li>
                            <li><a href="#" class="block px-4 py-2">Women</a></li>
                            <li><a href="#" class="block px-4 py-2">Kids</a></li>
                            <li><a href="#" class="block px-4 py-2">Pets</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Price Guide Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('priceGuide')">
                    Price Guide
                    <span class="ml-2 transform transition duration-300" id="arrow-priceGuide">▼</span>
                </button>
                <div id="priceGuideDropdown" class="subcategory-dropdown hidden absolute left-0 mt-80">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2">On Sale</a></li>
                            <li><a href="#" class="block px-4 py-2">Under Rs. 5000</a></li>
                            <li><a href="#" class="block px-4 py-2">Rs. 5000 – Rs. 7 000</a></li>
                            <li><a href="#" class="block px-4 py-2">Rs. 7 000 – Rs. 9 000</a></li>
                            <li><a href="#" class="block px-4 py-2">Rs. 9 000 – Rs. 10 000</a></li>
                            <li><a href="#" class="block px-4 py-2">Over Rs. 10 000</a></li>
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
                            <li><a href="#" class="block px-4 py-2">All Products</a></li>
                            <li><a href="#" class="block px-4 py-2">Japanese Snacks</a></li>
                            <li><a href="#" class="block px-4 py-2">Premium Food</a></li>
                            <li><a href="#" class="block px-4 py-2">Drinks</a></li>
                            <li><a href="#" class="block px-4 py-2">Healthy Nutrition</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gift Guide Dropdown -->
            <div class="category-item flex items-center relative">
                <button class="flex items-center text-sm text-gray-700" onclick="toggleDropdown('giftGuide')">
                    Gift Guide
                    <span class="ml-2 transform transition duration-300" id="arrow-giftGuide">▼</span>
                </button>
                <div id="giftGuideDropdown" class="subcategory-dropdown hidden absolute left-0 mt-72">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md w-48">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2">Gifts for Women</a></li>
                            <li><a href="#" class="block px-4 py-2">Gifts for Men</a></li>
                            <li><a href="#" class="block px-4 py-2">Gifts for Kids</a></li>
                            <li><a href="#" class="block px-4 py-2">Gifts for Teachers</a></li>
                            <li><a href="#" class="block px-4 py-2">Gifts for Students</a></li>
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
                            <li><a href="#" class="block px-4 py-2">Japanese Calligraphy Sets</a></li>
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
                            <li><a href="#" class="block px-4 py-2">Japanese Language Learning Books</a></li>
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
                <h1 class="text-xl font-semibold">Our Collection</h1>
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
            <!-- Stationery -->
            <div class="category-section">
                <h2 class="text-xl font-semibold mb-4">Stationery</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="stationery_item_image_url.jpg" alt="Stationery Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Stationery Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 500</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Educational Books -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Educational Books</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="books_item_image_url.jpg" alt="Book Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Book Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 800</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tea & Snacks -->
            <div class="category-section mt-8">
                <h2 class="text-xl font-semibold mb-4">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg shadow hover:scale-105 transform transition-transform">
                        <img src="tea_snack_item_image_url.jpg" alt="Tea & Snack Item 1" class="w-full h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-medium">Tea & Snack Item 1</h3>
                            <p class="text-gray-600 mt-2">Price: Rs. 1,200</p>
                            <button class="bg-red-300 text-white mt-3 py-2 px-4 rounded hover:bg-red-400">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

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
</script>
</html>
