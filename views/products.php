<?php
    session_start();
    $userIsLoggedIn = isset($_SESSION['user']);
    $userProfileImage = $userIsLoggedIn ? $_SESSION['user']['profile_image'] : null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productname = $_POST['productname'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        $brand = $_POST['brand'];
        $weight = $_POST['weight'];
        $sku = $_POST['sku'];
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $target_dir = "../uploads/";
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = '/uploads/' . $file_name;
            }
        }
        
        $sql = "INSERT INTO products (productname, category, price, image, stock, description, brand, weight, sku) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsissds", $productname, $category, $price, $image, $stock, $description, $brand, $weight, $sku);
        
        if ($stmt->execute()) {
            header("Location: manage_products.php?success=1");
        } else {
            header("Location: manage_products.php?error=1");
        }
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

            <!-- Japanese Culture and History -->
            <section id="japanese-culture-history-section">
                <h2 class="text-2xl font-bold text-center mb-6">Japanese Culture and History</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Manga and Graphic Novels -->
            <section id="manga-graphic-section">
                <h2 class="text-2xl font-bold text-center mb-6">Manga and Graphic Novels</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Books on Japanese Cuisine -->
            <section id="books-japanese-cuisine-section">
                <h2 class="text-2xl font-bold text-center mb-6">Books on Japanese Cuisine</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Books for Japanese Calligraphy -->
            <section id="books-japanese-calligraphy-section">
                <h2 class="text-2xl font-bold text-center mb-6">Books for Japanese Calligraphy</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Tea & Snacks -->
            <section id="tea-snacks-section">
                <h2 class="text-2xl font-bold text-center mb-6">Tea & Snacks</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Home & Interior Items -->
            <section id="home-interior-section">
                <h2 class="text-2xl font-bold text-center mb-6">Home & Interior Items</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>

            <br><br><br><br><br>

            <!-- Health & Beauty Items -->
            <section id="health-beauty-section">
                <h2 class="text-2xl font-bold text-center mb-6">Health & Beauty Items</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>
            
            <br><br><br><br><br>

            <!-- Fashion & Lifestyle -->
            <section id="fashion-lifestyle-section">
                <h2 class="text-2xl font-bold text-center mb-6">Fashion & Lifestyle</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </section>
            
            <br><br><br><br><br>

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
        fetch("../json/products1.json") // Load the JSON data
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
