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
    <title>MONOMICHI - Cultural Insights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
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
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"></span>
                </a>

                <!-- Shopping Cart Icon -->
                <a href="../views/cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 hover:text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.879 1.514M7 16a2 2 0 104 0M13 16a2 2 0 104 0M5.058 6H20.86l-2.35 7H7.609m2.788 5H6M21 21H6"></path>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"></span>
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

    <!-- Cultural Insights Section -->
    <section id="cultural-insights" class="container mx-auto px-60 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Learn About Japanese Culture</h3>

        <!-- First Insight Row -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://www.sugimotousa.com/asset/5f1208aa97626" alt="Culture 1" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Tea Ceremony</h4>
                <p class="mt-2 text-gray-600">The Japanese Tea Ceremony (Sadō) is a traditional ritual where powdered green tea (matcha) is prepared and served to guests in a calm, methodical way. Rooted in Zen Buddhism, it emphasizes harmony, respect, purity, and tranquility.</p>

                <p class="mt-2 text-gray-600"><b>Key elements include:</b>

                The Setting: A minimalistic tea room or garden, fostering a peaceful atmosphere.
                The Process: The host carefully prepares the tea, and guests drink it with respect and mindfulness.
                Utensils: Essential items like the tea bowl (chawan), whisk (chasen), and scoop (chashaku).
                Philosophy: Focuses on mindfulness, with each gesture reflecting Zen principles.
                It is a practice that fosters connections, mindfulness, and appreciation for simplicity.</p>
            </div>
        </div>

        <!-- Second Insight Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Sakura Viewing</h4>
                <p class="mt-2 text-gray-600">Sakura is more than just a flower in Japanese culture. It represents the fleeting nature of life. The blossoms bloom in full glory, often in late March to early April, but only for a short period — typically about one to two weeks. This brevity is what gives the sakura its poignant significance. It serves as a reminder of life’s transience, the impermanence of beauty, and the inevitability of change. It aligns with the Buddhist concept of mono no aware (物の哀れ), which refers to the awareness of the impermanence of things, and the beauty that is found in this fleeting nature.</p>
            </div>
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://sakura.hirosakipark.jp/wp-content/themes/tebura/en/images/IMG_1730.jpg" alt="Culture 2" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
        </div> <!-- End of Second Insight Row -->

        <!-- Third Insight Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://blog.janbox.com/wp-content/uploads/2022/10/what-is-matsuri.jpg" alt="Culture 3" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Festivals (Matsuri)</h4>
                <p class="mt-2 text-gray-600">The word matsuri (祭り) refers to a festival or celebration, and these events are typically tied to local shrines, temples, and community traditions. Many matsuri have religious roots, with the purpose of appeasing or honoring deities, spirits, or ancestors. The belief is that these festivals will bring blessings, good harvests, health, and prosperity.</p>
                <p class="mt-2 text-gray-600">Traditionally, matsuri were a way to honor the kami (gods or spirits) in Shinto beliefs, as well as spirits in Buddhist practices. Over time, they evolved to incorporate seasonal celebrations and local traditions, and now they serve as an important way for communities to bond and celebrate their shared cultural identity.</p>
            </div>
        </div>

        <!-- Fourth Insight Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Kimonos</h4>
                <p class="mt-2 text-gray-600">The kimono's history dates back over a thousand years, with its roots in the Heian period (794-1185). Originally, people wore simpler garments, but over time, the kimono evolved into the elaborate and highly structured form we recognize today. The word "kimono" literally means "thing to wear" (着物), and its design and construction became increasingly intricate as Japanese society became more formal and stratified.</p>
                <p class="mt-2 text-gray-600">Historically, the kimono was worn by both men and women, but its designs, colors, and styles have evolved, with women’s kimonos being more elaborate and colorful. Over time, Western-style clothing became more popular in Japan, and the kimono transitioned from everyday wear to a garment reserved for special occasions. Despite this, the kimono remains a symbol of cultural pride and is still worn on important events and ceremonies.</p>
            </div>
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://www.dhresource.com/webp/m/0x0/f2/albu/g9/M00/65/18/rBVaWF0LQSOASWxGAABhwA7T7w8291.jpg" alt="Culture 4" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
        </div>

        <!-- Fifth Insight Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://img.freepik.com/free-photo/freshness-variety-plate-sushi-culture-japan-generated-by-artificial-intelligence_25030-67081.jpg" alt="Culture 5" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Sushi Culture</h4>
                <p class="mt-2 text-gray-600">Sushi has a long history that can be traced back to ancient Japan. Its origins are believed to date back to the 8th century, where it was initially used as a preservation method for fish. The fish was fermented with rice, and over time, the rice would ferment and become sour. The rice was eventually discarded, and only the fish was consumed. This early form of sushi, known as narezushi, was quite different from the sushi we know today.</p>
                <p class="mt-2 text-gray-600">It wasn’t until the Edo period (1603-1868) that the modern style of sushi, nigiri sushi (hand-pressed sushi), emerged. This form of sushi used fresh fish placed on top of vinegared rice, which made it a much quicker and more accessible dish. The introduction of soy sauce and wasabi further refined the sushi experience, making it a delicacy that people of all classes could enjoy.</p>
            </div>
        </div>

        <!-- Sixth Insight Row -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Ikebana (Flower Arranging)</h4>
                <p class="mt-2 text-gray-600">The practice of Ikebana dates back to the 6th century when Buddhist monks brought flowers to Japan as offerings to the Buddha. Initially, flowers were used purely for religious and ceremonial purposes. Over time, Ikebana evolved into a highly developed art form. By the 15th century, during the Muromachi period (1336-1573), Ikebana became popular in the homes of samurai and aristocrats, and it began to be formalized into various schools of thought and styles.</p>
            </div>
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://t3.ftcdn.net/jpg/04/99/86/88/360_F_499868875_MUdVb0Eg1JD1VNaGfRBcmV4btdgaCbMM.jpg" alt="Culture 6" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
        </div>

        <!-- Seventh Insight Row -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Image in the 1st Column -->
            <div class="w-full">
                <img src="https://willowalexandergardens.co.uk/wp-content/uploads/2024/10/Japanese-1.jpg" alt="Japanese Garden" class="w-full h-48 object-cover rounded-lg shadow-lg">
            </div>
            <!-- Description in the 2nd Column -->
            <div class="col-span-2">
                <h4 class="text-xl font-semibold">Japanese Gardens</h4>
                <p class="mt-2 text-gray-600">Japanese gardens are designed to reflect the beauty of nature through a harmonious layout of plants, water, rocks, and pathways. They often aim to create a sense of tranquility and a connection with the natural world.</p>

                <p class="mt-2 text-gray-600"><b>Key elements include:</b>

                Water Features: Ponds, streams, or waterfalls are common, representing life and the flow of time.
                Rocks and Sand: Rocks symbolize mountains, while raked sand represents water or waves.
                Plants: Carefully selected plants that change with the seasons, creating a sense of impermanence.
                Paths: Winding paths invite contemplation and slow movement through the garden, emphasizing mindfulness.
                Japanese gardens embody Zen principles, with a focus on balance, simplicity, and the passage of time.</p>
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

    // Get all the star rating elements
    const ratings = document.querySelectorAll('.star');

    ratings.forEach(star => {
        // Hover effect
        star.addEventListener('mouseenter', function () {
            const index = parseInt(this.getAttribute('data-index'));
            const stars = this.parentElement.querySelectorAll('.star');
            stars.forEach((s, i) => {
                if (i < index) {
                    s.classList.add('text-yellow-500');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-300');
                }
            });
            this.style.cursor = "pointer"; // Change the cursor to pointer on hover
        });

        // Reset the color on mouse leave
        star.addEventListener('mouseleave', function () {
            const stars = this.parentElement.querySelectorAll('.star');
            stars.forEach(s => {
                s.classList.remove('text-yellow-500');
                s.classList.add('text-gray-300');
            });
        });

        // Click event to select the rating
        star.addEventListener('click', function () {
            const index = parseInt(this.getAttribute('data-index'));
            const stars = this.parentElement.querySelectorAll('.star');
            stars.forEach((s, i) => {
                if (i <= index) {  // Color all stars to the left of and including the clicked star yellow
                    s.classList.add('text-yellow-500');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
</script>
</html>