<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - MONOMICHI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .background-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
        }
        .custom-box-shadow {
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .hover-grow:hover {
            transform: scale(1.05);
        }
        .text-shadow-custom {
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center mx-20">
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

    <!-- About Us Content -->
    <section class="py-24 px-8 bg-white background-pattern">
        <div class="max-w-7xl mx-auto">
            <!-- Who We Are -->
            <div class="mb-16 flex flex-col md:flex-row justify-between items-center gap-12">
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Who We Are</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">Welcome to <strong>MONOMICHI</strong> — your online gateway to authentic Japanese items. We bring the beauty of Japan to you, from its ancient traditions to its modern-day culture.</p>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="https://via.placeholder.com/400x400" alt="Cultural Image" class="rounded-lg shadow-2xl transform hover-grow transition-all duration-300">
                </div>
            </div>

            <!-- Our Mission -->
            <div class="mb-16 text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Our Mission</h2>
                <p class="text-lg text-gray-600 leading-relaxed max-w-3xl mx-auto">Our mission is to connect people with the authentic beauty of Japan through a curated selection of items. From traditional tea sets to modern pop culture pieces, we celebrate the multifaceted charm of Japan.</p>
            </div>

            <!-- Our Story -->
            <div class="mb-16 flex flex-col md:flex-row justify-between items-center gap-12">
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Our Story</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">Our journey began with a passion for Japanese culture. What started as a personal project quickly turned into an online platform dedicated to delivering Japan’s unique culture to the world.</p>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="https://via.placeholder.com/400x400" alt="Cultural Item" class="rounded-lg shadow-2xl transform hover-grow transition-all duration-300">
                </div>
            </div>

            <!-- Meet the Team -->
            <div class="mb-16">
                <h2 class="text-4xl font-bold text-gray-800 text-center mb-6">Meet the Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
                    <div class="text-center p-6 bg-white rounded-lg shadow-lg transform hover-grow transition-all duration-300">
                        <img src="https://via.placeholder.com/150" alt="Pooja Sathsarani" class="rounded-full mb-6 w-36 h-36 mx-auto">
                        <h3 class="text-xl font-semibold text-gray-800">Pooja Sathsarani</h3>
                        <p class="text-md text-gray-600">Founder & Curator</p>
                        <p class="text-gray-600">Pooja is passionate about Japanese culture and web development. She ensures that every product resonates with authenticity.</p>
                    </div>
                    <!-- Add more team members as needed -->
                </div>
            </div>

            <!-- What Makes Us Unique -->
            <div class="mb-16 text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">What Makes Us Unique</h2>
                <ul class="list-none space-y-6 text-lg text-gray-600">
                    <li><strong class="text-indigo-600">Cultural Expertise:</strong> Reflecting Japan's traditions and modern culture in our products.</li>
                    <li><strong class="text-indigo-600">Multilingual Support:</strong> Supporting multiple languages for an inclusive experience.</li>
                    <li><strong class="text-indigo-600">Limited-Time Drops:</strong> Exclusive collections during Japanese holidays.</li>
                    <li><strong class="text-indigo-600">Cultural Guidance:</strong> Offering insights to understand and use Japanese items in daily life.</li>
                </ul>
            </div>

            <!-- Join Us -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Join Us on Our Journey</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-6">Explore our curated collection and embark on a cultural journey with MONOMICHI. Discover the essence of Japan through our handpicked items.</p>
                <a href="#shop-now" class="bg-indigo-600 text-white px-12 py-4 rounded-full text-lg shadow-lg transform hover-grow transition-all duration-300">Explore Now</a>
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
</script>
</html>
