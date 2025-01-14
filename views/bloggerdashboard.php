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
    <title>Blogger Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            transition: background-color 0.3s;
            margin: 0;
            padding: 0;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .card-flip {
            perspective: 1000px;
        }
        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.5s;
        }
        .card:hover .card-inner {
            transform: rotateY(180deg);
        }
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
        }
        .card-back {
            transform: rotateY(180deg);
            background-color: #F7FAFC;
        }
        .card-header {
            color: #4C51BF;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .post-excerpt {
            color: #333;
            font-size: 1.125rem;
            line-height: 1.6;
        }
        .btn-primary {
            background-color: #3B82F6;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2563EB;
        }
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .highlight-bg {
            background-color: #FEF2F2;
            border-radius: 10px;
            padding: 5px 15px;
            color: #E11D48;
        }
        .parallax {
            background-image: url('https://via.placeholder.com/1920x600');
            height: 400px;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            transition: background-position 0.3s ease-out;
        }
        .parallax:hover {
            background-position: center top;
        }
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
        .trending-tags {
            background-color: #fef9ed;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tag {
            background-color: #e2e8f0;
            border-radius: 5px;
            padding: 5px 12px;
            margin: 5px;
            display: inline-block;
            color: #3182ce;
        }
        .social-media-btn {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .social-btn {
            background-color: #4267B2;
            border-radius: 50%;
            padding: 12px;
            color: white;
            transition: transform 0.3s;
        }
        .social-btn:hover {
            transform: scale(1.1);
        }
        /* Dark Mode Styles */
        .dark-mode {
            background-color: #1F2937;
            color: #e2e8f0;
        }
        .dark-mode .btn-primary {
            background-color: #2563EB;
        }
        .dark-mode .card {
            background-color: #2D3748;
            color: #F7FAFC;
        }
        .dark-mode .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .dark-mode .post-header {
            color: #4C51BF;
        }
        .dark-mode .post-excerpt {
            color: #E2E8F0;
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 2s forwards;
        }
        @keyframes fadeIn {
            100% {
                opacity: 1;
            }
        }
        /* Image Carousel */
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            overflow: hidden;
        }
        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-images img {
            width: 100%;
            border-radius: 15px;
        }
        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
        .carousel-button.prev {
            left: 10px;
        }
        .carousel-button.next {
            right: 10px;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .max-w-7xl {
                max-width: 100%;
                padding: 0 10px;
            }
            .grid-cols-3 {
                grid-template-columns: 1fr;
            }
            .sticky-sidebar {
                position: relative;
            }
        }
    </style>
</head>
<body>
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

                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                    <!-- Conditional Rendering of User Avatar or Profile Icon -->
                    <img src="<?php echo $userIsLoggedIn ? $userProfileImage : 'https://w7.pngwing.com/pngs/423/634/png-transparent-find-user-profile-person-avatar-people-account-search-general-pack-icon.png'; ?>" alt="User Profile" class="w-14 h-14 rounded-full border border-gray-300 transition-transform transform hover:scale-110 hover:shadow-lg">
                </button>

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-80 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
                    <ul class="py-2 text-sm text-gray-700">
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

    <!-- Parallax Scrolling Banner -->
    <div class="parallax">

    <!-- Main Content Section -->
    <div class="max-w-7xl mx-auto p-8 grid grid-cols-3 gap-8 fade-in px-40">

        <!-- Sidebar (Profile & Navigation) -->
        <div class="col-span-1 bg-white p-6 rounded-xl shadow-xl sticky-sidebar">
            <div class="text-center mb-8">
                <img class="user-avatar mb-4" src="https://via.placeholder.com/150" alt="User Avatar">
                <div class="font-semibold text-xl text-teal-500">Blogger Name 📝</div>
                <div class="text-sm text-gray-500">Passionate about Japanese culture! 🇯🇵</div>
            </div>
            <ul class="space-y-6">
                <li><a href="#create-post" class="text-lg font-semibold text-gray-700 hover:text-teal-500">Create New Post ✍️</a></li>
                <li><a href="#my-posts" class="text-lg font-semibold text-gray-700 hover:text-teal-500">My Posts 📚</a></li>
                <li><a href="#drafts" class="text-lg font-semibold text-gray-700 hover:text-teal-500">Drafts 📝</a></li>
            </ul>
            <!-- Trending Tags -->
            <div class="trending-tags">
                <h3 class="font-semibold text-lg text-teal-500 mb-4">Trending Tags</h3>
                <div class="flex flex-wrap gap-4">
                    <span class="tag">#JapaneseCulture</span>
                    <span class="tag">#Kanji</span>
                    <span class="tag">#Matcha</span>
                    <span class="tag">#Origami</span>
                    <span class="tag">#Kimonos</span>
                </div>
            </div>
        </div>

        <!-- Blog Posts -->
        <div class="col-span-2 space-y-12">
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-xl font-semibold text-gray-800">Exploring the Art of Japanese Calligraphy ✍️</span>
                    <span class="text-sm text-gray-500">Posted 2 days ago</span>
                </div>
                <p class="text-gray-700 mb-4">Explore the beauty and history of Kanji, and how Japanese Calligraphy is more than just writing. 🖋️</p>
                <div class="flex space-x-6 items-center mb-4">
                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200" id="like-count1">👍 Like</button>
                    <button class="text-sm text-teal-600 hover:text-teal-700">💬 Comment</button>
                    <button class="text-sm text-teal-600 hover:text-teal-700">🔗 Share</button>
                </div>
                <div class="card-flip relative">
                    <div class="absolute inset-0 bg-gray-100 p-6 rounded-lg shadow-lg opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <p class="text-gray-600 text-sm">Get deeper into the techniques and tools used in traditional Japanese calligraphy and how it reflects the culture. 🌸</p>
                        <div class="mt-4 text-sm text-teal-600">
                            <a href="#" class="hover:text-teal-700">Read more...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    //Sidebar
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

    //Profile
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

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    darkModeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });

    // Carousel Controls
    const carousel = document.querySelector('.carousel-images');
    const prevButton = document.querySelector('.carousel-button.prev');
    const nextButton = document.querySelector('.carousel-button.next');
    let currentIndex = 0;

    const updateCarousel = () => {
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    };

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : 0;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex < carousel.children.length - 1) ? currentIndex + 1 : carousel.children.length - 1;
        updateCarousel();
    });
</script>
</html>
