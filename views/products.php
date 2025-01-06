<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - MONOMICHI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-50 font-serif">
    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center mx-24 lg:pl-10">
                    <img src="../images/logo.png" alt="MONOMICHI Logo" class="h-16 w-16 mr-2">
                    MONOMICHI
                </h1>
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex items-center justify-center w-full max-w-lg">
                <form action="../views/search-results.php" method="GET" class="w-full flex items-center bg-gray-200 rounded-full">
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
            <aside id="sidebar" class="fixed top-0 left-0 h-full bg-gray-50 shadow-lg flex flex-col items-center py-6 px-2 transition-all duration-300 w-16 hover:w-64 overflow-hidden">
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
                        <span class="hidden sidebar-text">Home</span>
                    </a>
                    <a href="../views/products.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8m16 0H4" /></svg></span>
                        <span class="hidden sidebar-text">Products</span>
                    </a>
                    <a href="../views/services.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                        <span class="hidden sidebar-text">Services</span>
                    </a>
                    <a href="../views/faqs.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9l-6 6-6-6" /></svg></span>
                        <span class="hidden sidebar-text">FAQs</span>
                    </a>
                    <a href="../views/contactus.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h14M3 10h14m-7 5h7" /></svg></span>
                        <span class="hidden sidebar-text">Contact Us</span>
                    </a>
                    <a href="../views/aboutus.php" class="flex items-center space-x-2 px-4 py-2 text-gray-800 hover:text-pink-600 w-full">
                        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19a4 4 0 108 0m-2 2h.01M8 13a4 4 0 108 0m-6 2h.01M11 11a4 4 0 108 0m-6 2h.01" /></svg></span>
                        <span class="hidden sidebar-text">About Us</span>
                    </a>
                </nav>
            </aside>

            <!-- Profile Section -->
            <div class="relative">
                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                    <!-- Conditional Rendering of User Avatar or Profile Icon -->
                    <img src="<?php echo $userIsLoggedIn ? $userProfileImage : 'https://w7.pngwing.com/pngs/423/634/png-transparent-find-user-profile-person-avatar-people-account-search-general-pack-icon.png'; ?>" alt="User Profile" class="w-14 h-14 rounded-full border border-gray-300 transition-transform transform hover:scale-110 hover:shadow-lg">
                </button>

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
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
                            <a href="../views/wishlist.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">Wishlist</a>
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

    <!-- Hero Section -->
    <section class="bg-red-100 py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Explore Our Products</h2>
            <p class="text-gray-600">Discover authentic Japanese items, from traditional decor to modern collectibles.</p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-6 bg-gray-100">
        <div class="container mx-auto px-6">
            <!-- Filters Section -->
            <div class="flex justify-between items-center mb-6">
                <select id="category-filter" class="border rounded-lg py-2 px-4">
                    <option value="all">All Categories</option>
                    <option value="traditional">Traditional</option>
                    <option value="beverages">Beverages</option>
                    <option value="home-decor">Home Decor</option>
                    <option value="stationery">Stationery</option>
                </select>

                <input id="search-bar" type="text" placeholder="Search Products" class="border rounded-lg py-2 px-4">
            </div>

            <!-- Products Grid -->
            <div id="product-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Product Card: Example -->
                <div class="product-card" data-category="traditional" data-tags="fan,decor">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        <img src="https://img.icons8.com/doodle/200/fan.png" alt="Traditional Japanese Fan" class="rounded-t-lg w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800 mb-2">Traditional Japanese Fan</h4>
                            <p class="text-gray-600 mb-4">Beautifully crafted hand fans with traditional designs.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold">Rs. 3,000</span>
                                <button class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Repeat for Other Products -->
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryFilter = document.getElementById("category-filter");
            const searchBar = document.getElementById("search-bar");
            const productGrid = document.getElementById("product-grid");
            const productCards = document.querySelectorAll(".product-card");

            function filterProducts() {
                const selectedCategory = categoryFilter.value.toLowerCase();
                const searchTerm = searchBar.value.toLowerCase();

                productCards.forEach((card) => {
                    const category = card.getAttribute("data-category");
                    const tags = card.getAttribute("data-tags");

                    const matchesCategory = selectedCategory === "all" || category === selectedCategory;
                    const matchesSearch = tags.toLowerCase().includes(searchTerm);

                    if (matchesCategory && matchesSearch) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            }

            categoryFilter.addEventListener("change", filterProducts);
            searchBar.addEventListener("input", filterProducts);
        });
    </script>
</body>
</html>
