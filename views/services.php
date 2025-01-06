<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Additional custom styles */
        .accordion-content {
            display: none;
        }
        .accordion-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
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

    <!-- Services Section -->
    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Services</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow hover:scale-105">
                    <img src="https://cdn-icons-png.flaticon.com/512/1066/1066631.png" alt="Product Customization" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 text-center">Product Customization</h3>
                    <p class="text-gray-600 text-center mt-2">We offer personalized customization of traditional Japanese products to meet your unique preferences and needs.</p>
                    
                    <!-- Accordion -->
                    <div class="accordion mt-4">
                        <button class="w-full text-left px-4 py-2 bg-gray-100 text-gray-800 rounded-md focus:outline-none hover:bg-gray-200" onclick="toggleAccordion(this)">
                            Learn More
                        </button>
                        <div class="accordion-content px-4 py-2 text-gray-600">
                            <p>Our customization services include embroidery, engraving, and color choices. Whether you're looking for a personalized gift or unique decoration for your home, we ensure each product reflects your personality and style.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow hover:scale-105">
                    <img src="https://cdn-icons-png.flaticon.com/512/1066/1066632.png" alt="Gift Wrapping" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 text-center">Gift Wrapping</h3>
                    <p class="text-gray-600 text-center mt-2">We offer elegant gift wrapping for a perfect presentation of your gifts, making them extra special for your loved ones.</p>
                    
                    <!-- Accordion -->
                    <div class="accordion mt-4">
                        <button class="w-full text-left px-4 py-2 bg-gray-100 text-gray-800 rounded-md focus:outline-none hover:bg-gray-200" onclick="toggleAccordion(this)">
                            Learn More
                        </button>
                        <div class="accordion-content px-4 py-2 text-gray-600">
                            <p>Our premium wrapping service includes unique designs, ribbons, and cards for different occasions like birthdays, holidays, and celebrations.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Service Card 3 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow hover:scale-105">
                    <img src="https://cdn-icons-png.flaticon.com/512/1066/1066633.png" alt="Cultural Guidance" class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 text-center">Cultural Guidance</h3>
                    <p class="text-gray-600 text-center mt-2">We provide cultural insights and personalized guidance about Japan's history, customs, and traditions to enhance your experience.</p>
                    
                    <!-- Accordion -->
                    <div class="accordion mt-4">
                        <button class="w-full text-left px-4 py-2 bg-gray-100 text-gray-800 rounded-md focus:outline-none hover:bg-gray-200" onclick="toggleAccordion(this)">
                            Learn More
                        </button>
                        <div class="accordion-content px-4 py-2 text-gray-600">
                            <p>Our guidance services are available for individuals or groups, including tailored experiences based on your interests, such as tea ceremonies, traditional arts, or exploring historical sites.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Rating -->
    <section id="rating" class="py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Rate our Service</h2>
            <div class="flex justify-center items-center space-x-1">
                <div id="service-rating" class="flex">
                    <span class="text-gray-400 cursor-pointer" onclick="rateService(1)">★</span>
                    <span class="text-gray-400 cursor-pointer" onclick="rateService(2)">★</span>
                    <span class="text-gray-400 cursor-pointer" onclick="rateService(3)">★</span>
                    <span class="text-gray-400 cursor-pointer" onclick="rateService(4)">★</span>
                    <span class="text-gray-400 cursor-pointer" onclick="rateService(5)">★</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">What Our Customers Say</h2>
            <div class="flex overflow-x-auto space-x-6">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 w-80">
                    <p class="text-gray-600">"I ordered a custom kimono, and the service was excellent! It was exactly what I wanted, and the quality was amazing!"</p>
                    <div class="mt-4 flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Customer 1" class="h-12 w-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold text-gray-800">John Doe</p>
                            <p class="text-sm text-gray-500">New York, USA</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 w-80">
                    <p class="text-gray-600">"The gift wrapping service for my friend's birthday was beautiful. Highly recommend!"</p>
                    <div class="mt-4 flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Customer 2" class="h-12 w-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold text-gray-800">Jane Smith</p>
                            <p class="text-sm text-gray-500">Tokyo, Japan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Inquiry Form -->
    <section id="inquiry-form" class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Inquire About Our Services</h2>
            <form action="#" method="POST" class="bg-white p-8 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-gray-600">Your Name</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-600">Your Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-600">Your Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full p-3 border border-gray-300 rounded-md" required></textarea>
                </div>
                <button type="submit" class="bg-pink-600 text-white py-2 px-6 rounded-full hover:bg-pink-700">Send Inquiry</button>
            </form>
        </div>
    </section>

    <!-- Map Section -->
    <section id="map" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Explore Japanese Culture Locations</h2>
            <div class="relative h-96">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12644.774426435132!2d139.6917!3d35.6895!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1652321510983!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

        // Accordion toggle function
        function toggleAccordion(button) {
            // Get the accordion content
            const accordionContent = button.nextElementSibling;

            // Toggle the 'active' class to show or hide the content
            accordionContent.classList.toggle('active');
        }

        // Sidebar toggle for mobile menu
        document.getElementById('menu-btn').addEventListener('click', () => {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Sidebar expand/collapse
        document.getElementById('toggle-sidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const expandIcon = document.getElementById('expand-icon');
            const collapseIcon = document.getElementById('collapse-icon');

            sidebar.classList.toggle('w-64');
            expandIcon.classList.toggle('hidden');
            collapseIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>
