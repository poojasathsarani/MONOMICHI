<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Main Container -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-teal-600 to-teal-800 text-white p-6 flex flex-col space-y-8">
            <div class="text-3xl font-extrabold mb-8 text-white">Manager Dashboard</div>
            <ul class="space-y-6">
                <li><a href="#user-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Manage Special Item Requests</a></li>
                <li><a href="#blog-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Manage Limited-Time Product Drops</a></li>
                <li><a href="#order-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Blog Management</a></li>
                <li><a href="#product-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Content Moderation</a></li>
                <li><a href="#holiday-drops" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Update Cultural Guidance</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-8 bg-gray-50">

            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div class="text-2xl font-semibold text-gray-800">Welcome Back, Manager!</div>
                <div class="flex items-center space-x-6">
                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200">Messages</button>
                    <button class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-200">Logout</button>
                </div>
            </div>

            <!-- Dashboard Overview -->
            <div id="overview" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Sales</h3>
                    <p class="text-3xl font-bold text-teal-600">Rs. 10 000</p>
                    <p class="text-sm text-gray-500">This Week</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Products</h3>
                    <p class="text-3xl font-bold text-teal-600">100</p>
                    <p class="text-sm text-gray-500">In Inventory</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Active Orders</h3>
                    <p class="text-3xl font-bold text-teal-600">12</p>
                    <p class="text-sm text-gray-500">Pending Orders</p>
                </div>
            </div>

            <!-- Manage Special Item Requests -->
            <div id="special-requests" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Manage Special Item Requests</h3>
                <table class="w-full table-auto bg-white shadow-lg rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border text-left">Customer</th>
                            <th class="px-4 py-2 border text-left">Item Requested</th>
                            <th class="px-4 py-2 border text-left">Status</th>
                            <th class="px-4 py-2 border text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr>
                            <td class="px-4 py-2 border">Viduni Hansini</td>
                            <td class="px-4 py-2 border">Japanese Souvenirs(Omiyage)</td>
                            <td class="px-4 py-2 border">Item Not Available</td> <!-- Status updated to reflect unavailable item -->
                            <td class="px-4 py-2 border">
                                <button class="bg-teal-600 text-white px-4 py-1 rounded-lg hover:bg-teal-700">Approve</button>
                                <button class="bg-red-600 text-white px-4 py-1 rounded-lg hover:bg-red-700">Reject</button>
                                <!-- Additional button to request adding the item to inventory -->
                                <button class="bg-yellow-500 text-white px-4 py-1 rounded-lg hover:bg-yellow-600">Add to Inventory</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Manage Holiday Drops -->
            <div id="holiday-drops" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Manage Limited-Time Product Drops</h3>
                <button class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700">Add New Holiday Drop</button>
                <div class="mt-4">
                    <!-- Placeholder for listing holiday drops -->
                    <ul class="space-y-4">
                        <li class="text-lg text-gray-800">Christmas Limited Edition Items</li>
                        <li class="text-lg text-gray-800">New Year Special Products</li>
                    </ul>
                </div>
            </div>

            <!-- Manage Blog Comments -->
            <div id="blog-management" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Blog Management</h3>
                <table class="w-full table-auto bg-white shadow-lg rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border text-left">User</th>
                            <th class="px-4 py-2 border text-left">Comment</th>
                            <th class="px-4 py-2 border text-left">Status</th>
                            <th class="px-4 py-2 border text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr>
                            <td class="px-4 py-2 border">Nethumi Dahamsa</td>
                            <td class="px-4 py-2 border">Great blog on Japanese culture!</td>
                            <td class="px-4 py-2 border">Pending</td>
                            <td class="px-4 py-2 border">
                                <button class="bg-teal-600 text-white px-4 py-1 rounded-lg hover:bg-teal-700">View the post</button>
                                <button class="bg-teal-600 text-white px-4 py-1 rounded-lg hover:bg-teal-700">Approve</button>
                                <button class="bg-red-600 text-white px-4 py-1 rounded-lg hover:bg-red-700">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Manage Content Moderation -->
            <div id="content-moderation" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Content Moderation</h3>
                <p>Ensure all posts and comments adhere to community guidelines.</p>
                <button class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700">View Pending Content</button>
            </div>

            <!-- Update Cultural Guidance -->
            <div id="cultural-guidance" class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Update Cultural Guidance</h3>
                <textarea class="w-full p-4 border rounded-lg" rows="6" placeholder="Edit cultural guidance and learning materials"></textarea>
                <button class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 mt-4">Update Guidance</button>
            </div>
        </div>
    </div>

</body>
</html>
