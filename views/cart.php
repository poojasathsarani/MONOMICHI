<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart if "add_to_cart" parameter is set
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    $product_name = $_GET['product_name'];
    $product_price = $_GET['product_price'];
    $product_image = $_GET['product_image'];

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['product_id'] == $product_id) {
            $_SESSION['cart'][$index]['quantity']++;
            $found = true;
            break;
        }
    }

    // If product is not in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        ];
    }
}

// Calculate total cart items
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - CART</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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


        body { font-family: Arial, sans-serif; }
        .cart-icon { position: fixed; top: 10px; right: 20px; }
        .cart-icon span { background: red; color: white; border-radius: 50%; padding: 5px 10px; font-size: 14px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border: 1px solid #ddd; }
        img { width: 50px; height: 50px; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
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
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">1</span>
                </a>

                <!-- Profile Icon (Trigger) -->
                <button id="profile-button" class="flex items-center space-x-2 p-0 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                    <!-- Conditional Rendering of User Avatar or Profile Icon -->
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

    <!-- Cart Icon -->
    <div class="fixed top-4 right-4 bg-white shadow-lg rounded-full p-2 flex items-center justify-center">
        <a href="cart.php" class="relative">
            <img src="cart_icon.png" alt="Cart Icon" class="w-10 h-10">
            <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs px-2 py-1"> <?php echo $cart_count; ?> </span>
        </a>
    </div>

    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-center">Your Cart</h1>

        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Item Name</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            echo '<tr class="border-t">';
                            echo '<td class="px-4 py-2"><img src="' . htmlspecialchars($item['product_image']) . '" alt="Product Image" class="w-16 h-16 rounded"></td>';
                            echo '<td class="px-4 py-2">' . htmlspecialchars($item['product_name']) . '</td>';
                            echo '<td class="px-4 py-2">$' . number_format($item['product_price'], 2) . '</td>';
                            echo '<td class="px-4 py-2">' . $item['quantity'] . '</td>';
                            echo '<td class="px-4 py-2">$' . number_format($item['product_price'] * $item['quantity'], 2) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center px-4 py-4">Your cart is empty.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-6">
            <h3 class="text-xl font-semibold">Total: 
                <?php 
                $total = 0;
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $total += $item['product_price'] * $item['quantity'];
                    }
                }
                echo '$' . number_format($total, 2);
                ?>
            </h3>
            <a href="checkout.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Proceed to Checkout</a>
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
    //Side bar
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


    //Profile Button
    const profileButton = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');

    profileButton.addEventListener('click', () => {
        profileMenu.classList.toggle('hidden');
        profileMenu.classList.toggle('opacity-0');
        profileMenu.classList.toggle('transform');
        profileMenu.classList.toggle('-translate-y-2');
    });


    //Search bar
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



    //Dropdown
    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
            profileMenu.classList.add('hidden');
            profileMenu.classList.add('opacity-0');
            profileMenu.classList.add('transform');
            profileMenu.classList.add('-translate-y-2');
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
</script>
</html>
