<?php
session_start();
include('db_connection.php');

// If user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['id'];

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Redirect based on role
if (isset($_SESSION['id'])) {
    if ($role === 'manager') {
        header("Location: managerdashboard.php"); // Redirect to manager dashboard
        exit();
    } elseif ($role === 'admin') {
        header("Location: admindashboard.php"); // Redirect to admin dashboard
        exit();
    }
}

// Fetch user details
$sql = "SELECT email, fullname, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($email, $name, $role);
$stmt->fetch();
$stmt->close();

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && $_POST['password'] === $_POST['confirm_password']) {
        $newName = htmlspecialchars($_POST['name']);
        $newEmail = htmlspecialchars($_POST['email']);
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Update query
        $updateSql = "UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $newName, $newEmail, $hashed_password, $userId);

        if ($updateStmt->execute()) {
            // Update session variables to reflect new changes
            $name = $newName;
            $email = $newEmail;
            $updateMessage = "Profile updated successfully!";
            $updateMessageType = "success";
        } else {
            $updateMessage = "Error updating profile!";
            $updateMessageType = "error";
        }
        $updateStmt->close();
    } else {
        $updateMessage = "All fields are required and passwords must match!";
        $updateMessageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
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
    </style>
</head>
<body class="bg-gray-100 font-serif">
    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../images/logoo.png" alt="MONOMICHI Logo" class="h-16 w-24 mr-2 mx-44">
            </div>

            <!-- Search Bar -->
            <div class="flex-grow flex justify-center">
                <form action="../views/searchresults.php" method="GET" class="w-full max-w-xl flex items-center bg-gray-200 rounded-full">
                    <input type="text" name="query" placeholder="Search products or categories..." class="w-full px-4 py-2 bg-white text-gray-800 rounded-l-full focus:outline-none placeholder-gray-500" id="search-bar"/>
                    <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-r-full hover:bg-pink-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5 5m-5-5a7 7 0 10-7-7 7 7z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Dashboard Button (For Manager & Admin) -->
            <?php if ($role === 'manager' || $role === 'admin'): ?>
                <div class="ml-4">
                    <a href="<?php echo $role === 'manager' ? 'managerdashboard.php' : 'admindashboard.php'; ?>" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-600 to-white-300 
                        text-white font-semibold rounded-xl shadow-md hover:from-pink-700 hover:to-pink-800 
                        transition-all duration-300 ease-in-out transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h13m0 0l-3-3m3 3l-3 3"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            <?php endif; ?>

            <!-- Logout Button -->
            <div class="ml-auto">
                <form action="logout.php" method="POST">
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 
                        text-white font-semibold rounded-xl shadow-md hover:from-red-700 hover:to-red-800 
                        transition-all duration-300 ease-in-out transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3 3m3-3l-3-3"/>
                        </svg>
                        Logout
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

            <!-- Dropdown Menu -->
            <div id="profile-menu" class="absolute right-0 mt-80 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="../views/myaccount.php" class="block px-4 py-2 hover:bg-gray-100 hover:text-pink-600 transform transition-all duration-200 ease-in-out">My Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mx-auto mt-10">
        <!-- Profile Header -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-6 mr-20 ml-44">
            <h2 class="text-3xl font-semibold text-gray-800">Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <p class="text-lg text-gray-600">Email: <?php echo htmlspecialchars($email); ?></p>
            <p class="text-lg text-gray-600"><?php echo htmlspecialchars(ucwords($role)); ?></p>
        </div>

        <!-- Update Profile Form -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-6 mr-20 ml-44">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Update Profile</h3>

            <!-- Display update message -->
            <?php if (isset($updateMessage)): ?>
                <div class="p-4 mb-4 text-white <?php echo ($updateMessageType == 'success') ? 'bg-green-500' : 'bg-red-500'; ?> rounded">
                    <?php echo $updateMessage; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-lg text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" 
                        value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-lg text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" 
                        value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- Password Update Section -->
                <div class="mb-4">
                    <label for="password" class="block text-lg text-gray-700">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 pr-10">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-pink-600">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block text-lg text-gray-700">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600 pr-10">
                        <button type="button" onclick="togglePassword('confirm_password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-pink-600">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300 ease-in-out">
                    Update Profile
                </button>
            </form>
        </div>

        <?php if ($role === 'customer'): ?>
            <!-- Order History Section -->
            <div class="bg-white shadow-lg rounded-lg p-8 mb-6 ml-48 mr-20">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Order History</h3>
                <?php
                // First, get the order totals
                $totalSql = "SELECT o.id, SUM(od.quantity * od.price) as order_total
                            FROM orders o
                            LEFT JOIN order_details od ON o.id = od.order_id
                            WHERE o.user_id = ?
                            GROUP BY o.id";
                
                $totalStmt = $conn->prepare($totalSql);
                $totalStmt->bind_param("i", $userId);
                $totalStmt->execute();
                $totalResult = $totalStmt->get_result();
                
                $orderTotalMap = array();
                while ($row = $totalResult->fetch_assoc()) {
                    $orderTotalMap[$row['id']] = $row['order_total'];
                }
                $totalStmt->close();
                
                // Now fetch the actual order details
                $orderSql = "SELECT o.id, o.order_date, o.status, od.product_id, od.quantity, od.price, p.productname
                            FROM orders o
                            LEFT JOIN order_details od ON o.id = od.order_id
                            LEFT JOIN Products p ON od.product_id = p.productid
                            WHERE o.user_id = ? 
                            ORDER BY o.id DESC, od.id ASC";
                
                $orderStmt = $conn->prepare($orderSql);
                $orderStmt->bind_param("i", $userId);
                $orderStmt->execute();
                $result = $orderStmt->get_result();
                
                // Group orders and their products
                $orders = array();
                while ($row = $result->fetch_assoc()) {
                    if (!isset($orders[$row['id']])) {
                        $orders[$row['id']] = array(
                            'id' => $row['id'],
                            'order_date' => $row['order_date'],
                            'status' => $row['status'],
                            'products' => array(),
                            'total' => isset($orderTotalMap[$row['id']]) ? $orderTotalMap[$row['id']] : 0
                        );
                    }
                    
                    $orders[$row['id']]['products'][] = array(
                        'name' => $row['productname'],
                        'quantity' => $row['quantity'],
                        'price' => $row['price'],
                        'subtotal' => $row['quantity'] * $row['price']
                    );
                }
                $orderStmt->close();
                ?>

                <table class="table-auto w-full mt-4 border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Order ID</th>
                            <th class="px-4 py-2 border border-gray-300">Order Date</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                            <th class="px-4 py-2 border border-gray-300">Product</th>
                            <th class="px-4 py-2 border border-gray-300">Quantity</th>
                            <th class="px-4 py-2 border border-gray-300">Price</th>
                            <th class="px-4 py-2 border border-gray-300">Subtotal</th>
                            <th class="px-4 py-2 border border-gray-300">Order Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($orders) > 0) {
                            foreach ($orders as $order) {
                                $rowspan = count($order['products']);
                                $firstProduct = true;
                                
                                foreach ($order['products'] as $index => $product) {
                                    echo "<tr>";
                                    
                                    // Order details cells (only for the first product in each order)
                                    if ($firstProduct) {
                                        echo "<td class='px-4 py-2 border border-gray-300' rowspan='{$rowspan}'>{$order['id']}</td>";
                                        echo "<td class='px-4 py-2 border border-gray-300' rowspan='{$rowspan}'>{$order['order_date']}</td>";
                                        echo "<td class='px-4 py-2 border border-gray-300' rowspan='{$rowspan}'>{$order['status']}</td>";
                                        $firstProduct = false;
                                    }
                                    
                                    // Product details
                                    echo "<td class='px-4 py-2 border border-gray-300'>{$product['name']}</td>";
                                    echo "<td class='px-4 py-2 border border-gray-300'>{$product['quantity']}</td>";
                                    echo "<td class='px-4 py-2 border border-gray-300'>Rs. " . number_format($product['price'], 2) . "</td>";
                                    echo "<td class='px-4 py-2 border border-gray-300'>Rs. " . number_format($product['subtotal'], 2) . "</td>";
                                    
                                    // Order total (only for the first product in each order)
                                    if ($index === 0) {
                                        echo "<td class='px-4 py-2 border border-gray-300' rowspan='{$rowspan}'>Rs. " . number_format($order['total'], 2) . "</td>";
                                    }
                                    
                                    echo "</tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='8' class='px-4 py-2 border border-gray-300 text-center'>No orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


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

    function togglePassword(id) {
        var input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>
</html>

<?php $conn->close(); ?>