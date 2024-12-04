<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-gray-100 font-serif">
    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center mx-60">
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

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-screen" id="carousel">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="w-3/4 text-center text-white transition-all duration-500 ease-in-out transform hover:scale-110 hover:text-pink-400 hover:shadow-2xl rounded-full">
                <h2 class="text-7xl font-bold">Welcome to MONOMICHI</h2>
                <p class="mt-4 text-lg">Explore authentic Japanese items and learn about Japanese culture.</p>
                <div class="mt-6">
                    <!-- Explore Now Button with JavaScript for Smooth Scroll -->
                    <a href="#categories" class="px-6 py-3 bg-pink-600 hover:bg-pink-800 rounded-full text-white font-semibold" id="exploreBtn">Explore Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Shop by Categories</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Stationery Category -->
            <div class="category-card bg-white shadow-lg rounded-lg overflow-hidden relative transform transition duration-300">
                <img src="https://m.media-amazon.com/images/I/71yV-gx2KiL.jpg" alt="Stationery" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Stationery</h4>
                    <p class="mt-2 text-gray-600">Explore a collection of authentic Japanese stationery items.</p>
                </div>
                <div class="hover-overlay absolute inset-0 bg-pink-300 opacity-0 transition-opacity duration-300"></div>
            </div>
            
            <!-- Educational Books Category -->
            <div class="category-card bg-white shadow-lg rounded-lg overflow-hidden relative transform transition duration-300">
                <img src="https://miro.medium.com/v2/resize:fit:1080/1*v5fYCtaEIlF_v-Pe8szVbg.png" alt="Educational Books" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Educational Books</h4>
                    <p class="mt-2 text-gray-600">Dive into Japanese language and culture with our books.</p>
                </div>
                <div class="hover-overlay absolute inset-0 bg-blue-300 opacity-0 transition-opacity duration-300"></div>
            </div>
            
            <!-- Redirect Arrow to Products Page -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 transform hover:scale-105 transition duration-300 ease-in-out relative">
                <div class="absolute inset-0 bg-cover bg-center filter blur-sm" style="background-image: url('https://m.media-amazon.com/images/I/61iF8RXU1lL._AC_UF1000,1000_QL80_.jpg');"></div>

                <!-- Content (Text and Icon) -->
                <a href="culturalinsights.php" class="flex flex-col items-center text-gray-800 hover:text-white transition relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="mt-2 text-lg font-medium">View All Products</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">What Our Customers Say</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <p class="text-lg text-gray-600">"I love the Japanese tea set I bought from MONOMICHI. It's so authentic, and I use it every day!"</p>
                <div class="mt-4 text-right">
                    <p class="font-semibold text-gray-800">Tharushi Perera</p>
                    <p class="text-sm text-gray-600">Jayawardhanapura, Sri Lanka</p>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <p class="text-lg text-gray-600">"The bento box I purchased is perfect for my lunch breaks. It's so cute and practical!"</p>
                <div class="mt-4 text-right">
                    <p class="font-semibold text-gray-800">Nethmi Fernando</p>
                    <p class="text-sm text-gray-600">Kottawa, Sri Lanka</p>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <p class="text-lg text-gray-600">"MONOMICHI has an amazing selection of authentic Japanese products. I can't wait to shop more!"</p>
                <div class="mt-4 text-right">
                    <p class="font-semibold text-gray-800">Ayomi Withanage</p>
                    <p class="text-sm text-gray-600">Anuradhapura, Sri Lanka</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Featured Products</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
                <img src="https://m.media-amazon.com/images/I/81J4pyKvIaL._AC_UL480_FMwebp_QL65_.jpg" alt="Product 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Tea Set</h4>
                    <p class="mt-2 text-gray-600">Experience traditional Japanese tea ceremonies with this beautiful tea set.</p>
                    <p class="mt-2 text-lg font-semibold text-pink-600">Rs. 11 999.99</p>
                </div>
            </div>

            <!-- Product 2 (Popular One) -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
                <img src="https://lh5.googleusercontent.com/proxy/9HZjyXtQYIRMv7cWRSWA3PQf-25MKF0kLOelp8OlkS2liexKIb0fpxAwsVYm4C8VSaWOHcNFO8E5YVQPyuGgsPXm07RmRecRzWdGe4Pig8OfjJ7q" alt="Product 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Calligraphy Set</h4>
                    <p class="mt-2 text-gray-600">Perfect for artists and enthusiasts to explore the art of Japanese calligraphy.</p>
                    <p class="mt-2 text-lg font-semibold text-pink-600">Rs. 8 999.99</p>
                    <span class="text-sm text-red-500 bg-gray-100 px-2 py-1 rounded-full">Popular</span>
                </div>
            </div>

            <!-- View All Products Button -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 transform hover:scale-105 transition duration-300 ease-in-out relative">
                <div class="absolute inset-0 bg-cover bg-center filter blur-sm" style="background-image: url('https://blog.janbox.com/wp-content/uploads/2021/09/sake-best-things-to-buy-in-japan.png');"></div>

                <!-- Content (Text and Icon) -->
                <a href="culturalinsights.php" class="flex flex-col items-center text-gray-800 hover:text-white transition relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="mt-2 text-lg font-medium">View All Products</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Limited Time Offers Section -->
    <section id="limited-time-offers" class="bg-red-600 text-white text-center py-8 relative overflow-visible">
        <h3 class="text-4xl font-semibold">Limited Time Offers</h3>
        <p class="mt-4 text-lg">Get up to 30% off on selected Japanese items. Don't miss out!</p>
        <a href="../views/limitedtimeoffers.php" class="mt-6 inline-block bg-white text-red-600 py-3 px-8 rounded-full text-lg font-semibold">Shop Now</a>
    </section>

    <!-- Cultural Insights Section -->
    <section id="cultural-insights" class="container mx-auto px-6 py-16">
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
                <div class="absolute inset-0 bg-cover bg-center filter blur-sm" style="background-image: url('https://blog.janbox.com/wp-content/uploads/2021/09/sake-best-things-to-buy-in-japan.png');"></div>

                <!-- Content (Text and Icon) -->
                <a href="culturalinsights.php" class="flex flex-col items-center text-gray-800 hover:text-white transition relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="mt-2 text-lg font-medium">Explore More Insights</span>
                </a>
            </div>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section id="new-arrivals" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">New Arrivals</h3>
        <div class="mt-8 flex space-x-8">
            <!-- New Product 1 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="https://miro.medium.com/v2/resize:fit:1400/1*pfbYYn7wUSmNQFqtirn21A.png" alt="New Product 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Bento Box</h4>
                    <p class="mt-2 text-gray-600">A sleek and modern bento box for your lunch, inspired by Japanese design.</p>
                    <p class="mt-2 text-gray-800 font-semibold">Rs. 7999.99</p>
                    <!-- Rating -->
                    <div class="flex items-center mt-2">
                        <!-- Star ratings -->
                    </div>
                    <!-- Buttons: View Details & Add to Cart -->
                    <div class="mt-4 flex justify-between">
                        <a href="../views/product-detail.php?id=3" class="inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg hover:bg-pink-700 transition">View Details</a>
                        <a href="#" class="inline-block bg-green-600 text-white py-2 px-6 rounded-full text-lg hover:bg-green-700 transition">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- New Product 2 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="https://m.media-amazon.com/images/S/aplus-media-library-service-media/1314a45a-9401-4010-b7ee-3071e10f7aa4.__CR0,0,970,600_PT0_SX970_V1___.jpg" alt="New Product 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Tea Set</h4>
                    <p class="mt-2 text-gray-600">A beautiful tea set for the perfect Japanese tea ceremony experience.</p>
                    <p class="mt-2 text-gray-800 font-semibold">Rs. 13 999.99</p>
                    <!-- Rating -->
                    <div class="flex items-center mt-2">
                        <!-- Star ratings -->
                    </div>
                    <!-- Buttons: View Details & Add to Cart -->
                    <div class="mt-4 flex justify-between">
                        <a href="../views/product-detail.php?id=4" class="inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg hover:bg-pink-700 transition">View Details</a>
                        <a href="#" class="inline-block bg-green-600 text-white py-2 px-6 rounded-full text-lg hover:bg-green-700 transition">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- New Product 3 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="https://zenbird.media/wp-content/uploads/2022/10/kimono_top.jpg" alt="New Product 3" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Kimono</h4>
                    <p class="mt-2 text-gray-600">A traditional Japanese kimono made from high-quality silk.</p>
                    <p class="mt-2 text-gray-800 font-semibold">Rs. 34 999.99</p>
                    <!-- Rating -->
                    <div class="flex items-center mt-2">
                        <!-- Star ratings -->
                    </div>
                    <!-- Buttons: View Details & Add to Cart -->
                    <div class="mt-4 flex justify-between">
                        <a href="../views/product-detail.php?id=5" class="inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg hover:bg-pink-700 transition">View Details</a>
                        <a href="#" class="inline-block bg-green-600 text-white py-2 px-6 rounded-full text-lg hover:bg-green-700 transition">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Arrow Key Bar to Redirect to New Arrival Page -->
    <div class="flex justify-center mt-8">
        <a href="../views/newarrivals.php" class="flex items-center text-pink-600 font-semibold hover:text-pink-700 transition duration-300 transform hover:scale-110">
            <span class="mr-2 text-5xl">See All New Arrivals</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-transform duration-300 hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
            </svg>
        </a>
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
        <h3 class="text-3xl font-semibold">Join Us for the Cherry Blossom Festival!</h3>
        <p class="mt-4">Celebrate Japan’s culture with us and explore exclusive seasonal items.</p>
        <a href="../views/events.php" class="mt-6 inline-block bg-white text-pink-600 py-3 px-8 rounded-full text-lg font-semibold hover:bg-pink-600 hover:text-white hover:scale-105">Learn More</a>
    </section>

    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" class="fixed bottom-4 right-4 bg-pink-500 text-white py-2 px-4 rounded-full text-lg hidden hover:bg-red-600 transition duration-300 ease-in-out">
        ↑ Scroll to Top
    </button>

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
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    const expandIcon = document.getElementById('expand-icon');
    const collapseIcon = document.getElementById('collapse-icon');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');

    toggleBtn.addEventListener('click', () => {
        const isCollapsed = sidebar.classList.contains('w-16');
        
        if (isCollapsed) {
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-64');
            expandIcon.classList.add('hidden');
            collapseIcon.classList.remove('hidden');
            sidebarTexts.forEach(text => text.classList.remove('hidden'));
        } else {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');
            expandIcon.classList.remove('hidden');
            collapseIcon.classList.add('hidden');
            sidebarTexts.forEach(text => text.classList.add('hidden'));
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
        document.querySelector('#categories').scrollIntoView({
            behavior: 'smooth'
        });
    });

    const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    
    const images = [
        'https://t3.ftcdn.net/jpg/06/75/94/90/360_F_675949019_5piKZ1ScELyshhXbg24tFFUt0BwHuSWY.jpg',
        'https://images.rawpixel.com/image_800/czNmcy1wcml2YXRlL3Jhd3BpeGVsX2ltYWdlcy93ZWJzaXRlX2NvbnRlbnQvdjExNTUtYi0wMTFjLXguanBn.jpg',
        'https://t4.ftcdn.net/jpg/06/03/60/43/360_F_603604300_a64EoKEw3rM1P0c9ik9QjSB0shYRGewB.jpg',
        'https://img.freepik.com/free-vector/pink-trees-sky-banner-vector_53876-127811.jpg?semt=ais_hybrid',
        'https://static.vecteezy.com/system/resources/thumbnails/005/447/389/small_2x/spring-cherry-blossom-mountain-landscape-free-vector.jpg'
    ];

    let currentIndex = 0;

    function changeBackground() {
        const carousel = document.getElementById('carousel');
        carousel.style.backgroundImage = `url('${images[currentIndex]}')`;
        currentIndex = (currentIndex + 1) % images.length;
    }

    setInterval(changeBackground, 5000);
    changeBackground();

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
</script>
</html>