<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <header class="bg-red-100 shadow">
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
            <div class="bg-gradient-to-r from-pink-300 via-gray-200 to-pink-300 shadow-lg rounded-lg flex items-center justify-center py-6 transition-transform duration-300 transform hover:scale-105">
                <a href="../views/products.php" class="flex flex-col items-center text-gray-800 transition-colors duration-300 hover:text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 transition-transform duration-300 transform group-hover:scale-125" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="mt-2 text-xl font-medium">View All Products</span>
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
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://m.media-amazon.com/images/I/81J4pyKvIaL._AC_UL480_FMwebp_QL65_.jpg" alt="Product 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Tea Set</h4>
                    <p class="mt-2 text-gray-600">Experience traditional Japanese tea ceremonies with this beautiful tea set.</p>
                    <p class="mt-2 text-lg font-semibold text-pink-600">Rs. 11599.66</p>
                </div>
            </div>

            <!-- Product 2 (Popular One) -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://lh5.googleusercontent.com/proxy/9HZjyXtQYIRMv7cWRSWA3PQf-25MKF0kLOelp8OlkS2liexKIb0fpxAwsVYm4C8VSaWOHcNFO8E5YVQPyuGgsPXm07RmRecRzWdGe4Pig8OfjJ7q" alt="Product 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Calligraphy Set</h4>
                    <p class="mt-2 text-gray-600">Perfect for artists and enthusiasts to explore the art of Japanese calligraphy.</p>
                    <p class="mt-2 text-lg font-semibold text-pink-600">Rs. 8699.02</p>
                    <span class="text-sm text-red-500 bg-gray-100 px-2 py-1 rounded-full">Popular</span>
                </div>
            </div>

            <!-- View All Products Button -->
            <div class="bg-gradient-to-r from-pink-300 via-gray-200 to-pink-300 shadow-lg rounded-lg flex items-center justify-center py-6">
                <a href="../views/products.php" class="flex flex-col items-center text-gray-800 hover:text-pink-500 transition">
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
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://example.com/culture1.jpg" alt="Culture 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Tea Ceremony</h4>
                    <p class="mt-2 text-gray-600">Discover the traditional Japanese tea ceremony and its significance.</p>
                    <a href="../views/culture.php#tea-ceremony" class="mt-4 inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg">Learn More</a>
                </div>
            </div>
            <!-- Add more insights here -->
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section id="new-arrivals" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">New Arrivals</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://example.com/new-product1.jpg" alt="New Product 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Japanese Bento Box</h4>
                    <p class="mt-2 text-gray-600">A sleek and modern bento box for your lunch, inspired by Japanese design.</p>
                    <p class="mt-2 text-gray-800 font-semibold">$25.00</p>
                    <a href="../views/product-detail.php?id=3" class="mt-4 inline-block bg-pink-600 text-white py-2 px-6 rounded-full text-lg">View Details</a>
                </div>
            </div>
            <!-- Add more new arrivals here -->
        </div>
    </section>

    <!-- Newsletter Call to Action in Hero Section -->
    <div class="mt-6">
        <p class="text-lg">Subscribe to our newsletter for exclusive deals and the latest updates on Japanese culture!</p>
        <form action="#" method="POST" class="mt-4 flex justify-center">
            <input type="email" placeholder="Enter your email" class="py-2 px-4 rounded-l-lg border border-gray-300 w-1/3" required>
            <button type="submit" class="bg-pink-600 text-white py-2 px-4 rounded-r-lg">Subscribe</button>
        </form>
    </div>

    <!-- Event Promo Banner -->
    <section class="bg-blue-500 text-white text-center py-8">
        <h3 class="text-3xl font-semibold">Join Us for the Cherry Blossom Festival!</h3>
        <p class="mt-4">Celebrate Japan’s culture with us and explore exclusive seasonal items.</p>
        <a href="../views/events.php" class="mt-6 inline-block bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold">Learn More</a>
    </section>

    <!-- Press Mentions Section -->
    <section id="press" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">As Seen In</h3>
        <div class="mt-8 flex justify-center space-x-6">
            <img src="https://example.com/press-logo1.png" alt="Press 1" class="h-12">
            <img src="https://example.com/press-logo2.png" alt="Press 2" class="h-12">
            <img src="https://example.com/press-logo3.png" alt="Press 3" class="h-12">
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
<script>
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

    // Function to trigger confetti effect
    function triggerConfetti() {
        confetti({
            particleCount: 100,  // Number of confetti particles
            spread: 70,  // Spread angle of confetti
            origin: { y: 0.6 },  // Y-axis origin (from the bottom of the screen)
        });
    }

    // Trigger the confetti effect when the Explore Now button is clicked
    document.getElementById('exploreBtn').addEventListener('click', function() {
        triggerConfetti();
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
</script>
</html>