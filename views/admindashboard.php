<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Main Container -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-teal-600 to-teal-800 text-white p-6 flex flex-col space-y-8">
            <div class="text-3xl font-extrabold mb-8 text-white">Admin Dashboard</div>
            <ul class="space-y-6">
                <li><a href="#overview" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Dashboard Overview</a></li>
                <li><a href="#product-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Product Management</a></li>
                <li><a href="#order-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Order Management</a></li>
                <li><a href="#user-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">User Management</a></li>
                <li><a href="#analytics" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Analytics & Reports</a></li>
                <li><a href="#blog-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Blog Management</a></li>
                <li><a href="#settings" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-8 bg-gray-50">

            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div class="text-2xl font-semibold text-gray-800">Welcome Back, Admin!</div>
                <div class="flex items-center space-x-6">
                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200">Messages</button>
                    <button class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-200">Logout</button>
                </div>
            </div>

            <!-- Dashboard Overview -->
            <div id="overview" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Sales</h3>
                    <p class="text-3xl font-bold text-teal-600">$12,500</p>
                    <p class="text-sm text-gray-500">This Week</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Products</h3>
                    <p class="text-3xl font-bold text-teal-600">450</p>
                    <p class="text-sm text-gray-500">In Inventory</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Active Orders</h3>
                    <p class="text-3xl font-bold text-teal-600">32</p>
                    <p class="text-sm text-gray-500">Pending Orders</p>
                </div>
            </div>

            <!-- Product Management -->
            <div id="product-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Product Management</h3>
                <p>Manage products in your store, including adding, updating, and deleting products.</p>
            </div>

            <!-- Order Management -->
            <div id="order-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Management</h3>
                <p>Track and manage customer orders, update statuses, and handle returns.</p>
            </div>

            <!-- User Management -->
            <div id="user-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">User Management</h3>
                <p>Manage user profiles, roles, and permissions across the platform.</p>
            </div>

            <!-- Analytics & Reports -->
            <div id="analytics" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Analytics & Reports</h3>
                <p>Analyze your store’s performance, track key metrics, and generate reports.</p>
            </div>

            <!-- Blog Management -->
            <div id="blog-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Blog Management</h3>
                <p>Manage your website’s blog, create posts, and monitor interactions.</p>
            </div>

            <!-- Settings -->
            <div id="settings" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Settings</h3>
                <p>Configure your store’s settings, including payment methods, taxes, and shipping.</p>
            </div>

        </div>

    </div>

</body>
</html>
