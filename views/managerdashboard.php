<?php
session_start();
include('db_connection.php');

// Redirect to login if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$manager_id = $_SESSION['id'];
$query = "SELECT fullname FROM users WHERE id = ? AND role = 'manager'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
$managername = ($result->num_rows > 0) ? $result->fetch_assoc()['fullname'] : "Manager";

// Fetch customer messages
$sql = "SELECT name, email, message FROM customers ORDER BY created_at DESC";
$result = $conn->query($sql);
$messages = ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch dashboard counts
$counts = [
    'userCount' => "SELECT COUNT(*) as total FROM users",
    'blogCount' => "SELECT COUNT(*) as total FROM posts WHERE status='Approved'",
    'culturalPostCount' => "SELECT COUNT(*) as total FROM cultural_guidance_posts",
    'productCount' => "SELECT COUNT(*) as total FROM products WHERE status='available'"
];

foreach ($counts as $key => $query) {
    $result = $conn->query($query);
    $$key = ($result) ? $result->fetch_assoc()['total'] : 0;
}

// User Growth Query - March 2025
$userGrowthQuery = "
SELECT 
    DATE(registration_date) AS date, 
    COUNT(*) AS new_users
FROM 
    users
WHERE 
    registration_date >= '2025-02-02'
    AND registration_date <= '2025-02-13'
GROUP BY 
    date
ORDER BY 
    date
";
$userGrowthResult = $conn->query($userGrowthQuery);
$userGrowthData = [];
while ($row = $userGrowthResult->fetch_assoc()) {
$userGrowthData[] = $row;
}

// Blog Post Growth Query - March 2025
$blogGrowthQuery = "
SELECT 
    DATE(created_at) AS date, 
    COUNT(*) AS new_posts
FROM 
    posts
WHERE 
    created_at >= '2025-02-02'
    AND created_at <= '2025-02-13'
AND 
    status = 'Approved'
GROUP BY 
    date
ORDER BY 
    date
";
$blogGrowthResult = $conn->query($blogGrowthQuery);
$blogGrowthData = [];
while ($row = $blogGrowthResult->fetch_assoc()) {
$blogGrowthData[] = $row;
}

// Fill in missing dates with zero values
$start = new DateTime('2025-02-02');
$end = new DateTime('2025-02-13');
$interval = new DateInterval('P1D');
$dateRange = new DatePeriod($start, $interval, $end->modify('+1 day'));

$filledUserData = [];
$filledBlogData = [];

foreach ($dateRange as $date) {
$dateStr = $date->format('Y-m-d');

// Fill user data
$found = false;
foreach ($userGrowthData as $data) {
    if ($data['date'] === $dateStr) {
        $filledUserData[$dateStr] = $data['new_users'];
        $found = true;
        break;
    }
}
if (!$found) {
    $filledUserData[$dateStr] = 0;
}

// Fill blog data
$found = false;
foreach ($blogGrowthData as $data) {
    if ($data['date'] === $dateStr) {
        $filledBlogData[$dateStr] = $data['new_posts'];
        $found = true;
        break;
    }
}
if (!$found) {
    $filledBlogData[$dateStr] = 0;
}
}




// Handle Accept/Deny form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["request_id"]) && isset($_POST["action"])) {
    $request_id = intval($_POST["request_id"]);
    $action = $_POST["action"];

    // Set status based on action
    $status = ($action === 'accept') ? 'Accepted' : 'Denied';

    // Update request status in the database
    $sql = "UPDATE special_requests SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $request_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Request updated successfully!'); window.location.href='managerdashboard.php#special-requests-modal';</script>";
    } else {
        echo "<script>alert('Failed to update request!'); window.location.href='managerdashboard.php#special-requests-modal';</script>";
    }
    
    $stmt->close();
}

// Fetch special requests
$sql = "SELECT sr.id, u.fullname AS customer_name, sr.item_name, sr.description, sr.created_at, sr.status 
        FROM special_requests sr
        JOIN users u ON sr.user_id = u.id
        ORDER BY sr.created_at DESC";

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        html {
            scroll-behavior: smooth;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-serif">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-80 bg-gradient-to-br from-pink-600 to-pink-200 text-white p-6 shadow-2xl flex flex-col justify-between">
            <div>
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold tracking-tight">Manager Hub</h1>
                    <p class="text-sm text-blue-100 mt-2">Management & Analytics Platform</p>
                </div>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#special-request" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c2.21 0 4-1.79 4-4S14.21 0 12 0 8 1.79 8 4s1.79 4 4 4zm0 2c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                                </svg>
                                Manage Customer Special Request Items
                            </a>
                        </li>
                        <li>
                            <a href="#inventory-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 10h18M3 16h18M3 20h18M6 4v16M12 4v16M18 4v16"/>
                                </svg>
                                Inventory Management
                            </a>
                        </li>
                        <li>
                            <a href="#limited-time-drops-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8V4M8 12H4m16 0h-4m-4 4v4m4-4l4 4m-8-8l-4 4m0-8l4-4"/>
                                </svg>
                                Limited Time Drops Management
                            </a>
                        </li>
                        <li>
                            <a href="#order-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-2 12H5L3 4zm0 0l3 6h12l3-6"/>
                                </svg>
                                Order Management
                            </a>
                        </li>
                        <li>
                            <a href="#blog-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h10"/>
                                </svg>
                                Blog Management
                            </a>
                        </li>
                        <li>
                            <a href="#analytics" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4zm8 0v16M4 12h16"/>
                                </svg>
                                Analytics & Reports
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <button class="w-full bg-red-500 hover:bg-red-600 py-3 rounded-lg font-semibold transition"
                onclick="window.location.href='logout.php'">
                Logout
            </button>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-10 bg-gray-50 overflow-y-auto">
            <!-- Header -->
            <header class="flex justify-between items-center mb-10">
                <div>
                    <p class="text-2xl font-semibold text-gray-800">Welcome Back, <?php echo htmlspecialchars($managername); ?>!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Button to trigger the modal -->
                    <button class="bg-pink-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition" onclick="showModal()">Messages</button>

                    <!-- Modal Structure -->
                    <div id="messageModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 transition-opacity">
                        <div class="bg-white rounded-lg w-2/5 p-6 shadow-lg">
                            <div class="flex justify-between items-center border-b pb-3">
                                <h2 class="text-2xl font-semibold text-gray-700">User Messages</h2>
                                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                            </div>

                            <div id="messagesContainer" class="mt-4 max-h-80 overflow-y-auto space-y-4 p-2">
                                <?php if (empty($messages)): ?>
                                    <p class="text-gray-500 text-center">No messages found.</p>
                                <?php else: ?>
                                    <?php foreach ($messages as $message): ?>
                                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                                            <div class="flex justify-between items-center">
                                                <strong class="text-lg text-gray-700">
                                                    <?php echo htmlspecialchars($message['name']); ?>
                                                </strong>
                                                <span class="text-sm text-gray-500"><?php echo htmlspecialchars($message['email']); ?></span>
                                            </div>
                                            <p class="text-gray-600 mt-2"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                            <div class="flex justify-end mt-3">
                                                <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Reply%20to%20your%20message" 
                                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 flex items-center space-x-2 transition">
                                                    <span>Reply</span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Stats -->
            <div class="grid grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Users</h3>
                        <p class="text-2xl font-bold"><?php echo number_format($userCount); ?></p>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 1 0 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197M13 7a4 4 0 1 1-8 0 4 4 0 1 1 8 0z" />
                        </svg>
                    </div>
                </div>
            </div>
                <!-- Similar cards for other metrics -->
            </div>

            <!-- Charts and Analytics -->
            <div class="p-6 bg-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Daily User Growth</h3>
                        <div class="h-64">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Daily Blog Post Growth</h3>
                        <div class="h-64">
                            <canvas id="blogChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Special Request Card -->
            <div id="manager-special-request" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300 cursor-pointer">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    Manager Dashboard
                </h3>
                <p class="text-gray-600">Comprehensive management of special requests and system controls</p>
            </div>

            <!-- Manager Modal -->
            <div id="manager-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center">
                <div class="bg-white rounded-xl shadow-2xl w-[600px] p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Manager Control Center</h2>
                        <button id="close-manager-modal" class="text-gray-600 hover:text-red-500 text-3xl">&times;</button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Special Item Request Button -->
                        <button id="open-special-requests-modal" class="manager-option bg-blue-100 hover:bg-blue-200 p-4 rounded-lg flex flex-col items-center" data-action="special-requests">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span class="font-semibold text-blue-800">Special Item Requests</span>
                        </button>

                        <!-- Modal for Special Requests -->
                        <div id="special-requests-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center">
                            <div class="bg-white rounded-xl shadow-2xl w-[800px] p-8 max-h-[80vh] overflow-y-auto">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-800">Special Item Requests</h2>
                                    <button id="close-special-requests-modal" class="text-gray-600 hover:text-red-500 text-3xl">&times;</button>
                                </div>

                                <div id="requests-container">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "
                                                <div class='p-4 bg-gray-100 rounded-lg shadow mb-4'>
                                                    <h3 class='text-lg font-semibold text-gray-800'>{$row['item_name']}</h3>
                                                    <p class='text-gray-600'>Requested by: <span class='font-medium'>{$row['customer_name']}</span></p>
                                                    <p class='text-gray-500'>{$row['description']}</p>
                                                    <p class='text-gray-400 text-sm'>Requested on: {$row['created_at']}</p>
                                                    <p class='text-gray-700 font-semibold'>Status: <span class='text-".($row['status'] === 'Accepted' ? "green" : ($row['status'] === 'Denied' ? "red" : "yellow"))."-500'>{$row['status']}</span></p>
                                                    <div class='mt-4'>
                                                        <form method='POST' class='inline-block'>
                                                            <input type='hidden' name='request_id' value='{$row['id']}'>
                                                            <button type='submit' name='action' value='accept' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'>Accept</button>
                                                        </form>
                                                        <form method='POST' class='inline-block ml-2'>
                                                            <input type='hidden' name='request_id' value='{$row['id']}'>
                                                            <button type='submit' name='action' value='deny' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>Deny</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                    } else {
                                        echo "<p class='text-gray-600'>No special requests found.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Product Inventory Button -->
                        <button class="manager-option bg-green-100 hover:bg-green-200 p-4 rounded-lg flex flex-col items-center transition-all duration-200 transform hover:scale-105" data-action="inventory">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-semibold text-green-800">Product Inventory</span>
                        </button>

                        <script>
                        // Modal HTML Template
                        const modalHTML = `
                        <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1001;">
                            <div class="relative top-20 mx-auto p-5 border w-[32rem] shadow-lg rounded-md bg-white animate-modalSlide">
                                <div class="mt-3">
                                    <div class="flex items-center mb-4">
                                        <svg class="h-8 w-8 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <h3 class="text-xl font-semibold text-gray-900">Add New Product</h3>
                                    </div>
                                    
                                    <form id="productForm" class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Product Name *</label>
                                                <input type="text" name="productname" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Category *</label>
                                                <select name="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                                    <option value="">Select Category</option>
                                                    <option value="New Arrivals">New Arrivals</option>
                                                    <option value="Limited Time Offers">Limited Time Offers</option>
                                                    <option value="Home & Interior">Home & Interior</option>
                                                    <option value="Health & Beauty">Health & Beauty</option>
                                                    <option value="Fashion & Lifestyle">Fashion & Lifestyle</option>
                                                    <option value="Traditional Decorations">Traditional Decorations</option>
                                                    <option value="Food & Drinks">Food & Drinks</option>
                                                    <option value="Stationeries">Stationeries</option>
                                                    <option value="Books">Books</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Price *</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">Rs. </span>
                                                    </div>
                                                    <input type="number" step="0.01" name="price" required class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Stock *</label>
                                                <input type="number" name="stock" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Image Selection *</label>
                                            <div class="mt-2 space-y-4">
                                                <div class="flex space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="imageType" value="upload" class="form-radio" checked>
                                                        <span class="ml-2">Upload Image</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="imageType" value="url">
                                                        <span class="ml-2">Image URL</span>
                                                    </label>
                                                </div>

                                                <div id="uploadSection" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                                <span>Upload a file</span>
                                                                <input type="file" name="imageFile" accept="image/*" class="sr-only">
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                                    </div>
                                                </div>

                                                <div id="urlSection" class="hidden">
                                                    <input type="url" name="imageUrl" placeholder="Enter Google image URL" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors"></textarea>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                                <input type="number" step="0.01" name="weight" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                                    <option value="available">Available</option>
                                                    <option value="unavailable">Unavailable</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex justify-end space-x-3 pt-4 border-t">
                                            <div class="mt-4 flex justify-end">
                                                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                                    Cancel
                                                </button>
                                            </div>
                                            <button type="submit" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors inline-flex items-center">
                                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Add Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        `;

                        // Loading Spinner HTML
                        const loadingSpinnerHTML = `
                        <div id="loadingSpinner" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" style="z-index: 1002;">
                            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-green-600"></div>
                        </div>
                        `;

                        // Show loading spinner
                        function showLoading() {
                            const spinner = document.getElementById('loadingSpinner');
                            if (spinner) {
                                spinner.classList.remove('hidden');
                            }
                        }

                        // Hide loading spinner
                        function hideLoading() {
                            const spinner = document.getElementById('loadingSpinner');
                            if (spinner) {
                                spinner.classList.add('hidden');
                            }
                        }

                        // Wait for DOM to be fully loaded
                        document.addEventListener('DOMContentLoaded', function() {
                            // Add modal and spinner to body
                            document.body.insertAdjacentHTML('beforeend', modalHTML);
                            document.body.insertAdjacentHTML('beforeend', loadingSpinnerHTML);

                            // Add click event for inventory button
                            const inventoryButton = document.querySelector('[data-action="inventory"]');
                            if (inventoryButton) {
                                inventoryButton.addEventListener('click', () => {
                                    const modal = document.getElementById('productModal');
                                    if (modal) modal.classList.remove('hidden');
                                });
                            }

                            // Form submission handler
                            const productForm = document.getElementById('productForm');
                            if (productForm) {
                                productForm.addEventListener('submit', async (e) => {
                                    e.preventDefault();
                                    showLoading();

                                    try {
                                        const formData = new FormData(e.target);
                                        const data = {
                                            productname: formData.get('productname').trim(),
                                            category: formData.get('category'),
                                            price: parseFloat(formData.get('price')),
                                            stock: parseInt(formData.get('stock')),
                                            description: formData.get('description')?.trim() || '',
                                            weight: parseFloat(formData.get('weight')) || 0,
                                            status: formData.get('status') || 'available'
                                        };

                                        // Handle image upload/URL
                                        const imageType = formData.get('imageType');
                                        if (imageType === 'upload') {
                                            const imageFile = formData.get('imageFile');
                                            if (imageFile && imageFile.size > 0) {
                                                const uploadData = new FormData();
                                                uploadData.append('image', imageFile);
                                                
                                                const uploadResponse = await fetch('../api/upload_image.php', {
                                                    method: 'POST',
                                                    body: uploadData
                                                });

                                                const uploadResult = await uploadResponse.json();
                                                if (!uploadResult.success) {
                                                    throw new Error(uploadResult.message || 'Image upload failed');
                                                }
                                                
                                                data.imagePath = uploadResult.imagePath;
                                            } else {
                                                throw new Error('Please select an image file');
                                            }
                                        } else {
                                            const imageUrl = formData.get('imageUrl');
                                            if (!imageUrl || imageUrl.trim() === '') {
                                                throw new Error('Please enter an image URL');
                                            }
                                            data.imagePath = imageUrl.trim();
                                        }

                                        // Validate required fields
                                        const requiredFields = ['productname', 'category', 'price', 'stock', 'imagePath'];
                                        const missingFields = requiredFields.filter(field => !data[field]);
                                        
                                        if (missingFields.length > 0) {
                                            throw new Error(`Please fill in all required fields: ${missingFields.join(', ')}`);
                                        }

                                        // Make the API call
                                        const response = await fetch("../api/insert_product.php", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                            },
                                            body: JSON.stringify(data)
                                        });

                                        const result = await response.json();
                                        
                                        if (result.success) {
                                            showPopup('Success', 'Product added successfully!', 'success');
                                            closeModal();
                                        } else {
                                            throw new Error(result.error || 'Failed to add product');
                                        }

                                    } catch (error) {
                                        console.error('Error:', error);
                                        showNotification('Error', error.message, 'error');
                                    } finally {
                                        hideLoading();
                                    }
                                });
                            }

                            // Function to close popup
                            function closePopup() {
                                const popup = document.getElementById("customPopup");
                                if (popup) {
                                    popup.remove();
                                }
                            }

                            // Function to display a popup message
                            function showPopup(title, message, type) {
                                // Remove existing popups before adding a new one
                                closePopup();

                                const popup = document.createElement("div");
                                popup.id = "customPopup"; // Assign an ID for easy selection
                                popup.classList.add(
                                    "fixed",
                                    "inset-0",
                                    "bg-gray-900",
                                    "bg-opacity-50",
                                    "flex",
                                    "items-center",
                                    "justify-center",
                                    "z-50"
                                );

                                popup.innerHTML = `
                                    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                                        <h3 class="text-xl font-bold ${
                                            type === "success" ? "text-green-600" : "text-red-600"
                                        } mb-2">${title}</h3>
                                        <p class="text-gray-700 mb-4">${message}</p>
                                        <button id="popupCloseBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg">OK</button>
                                    </div>
                                `;

                                document.body.appendChild(popup);

                                // Attach event listener to close button after adding to DOM
                                document.getElementById("popupCloseBtn").addEventListener("click", closePopup);
                            }

                            // Add image type toggle handlers
                            const radioButtons = document.querySelectorAll('input[name="imageType"]');
                            if (radioButtons) {
                                radioButtons.forEach(radio => {
                                    radio.addEventListener('change', (e) => {
                                        const uploadSection = document.getElementById('uploadSection');
                                        const urlSection = document.getElementById('urlSection');
                                        
                                        if (uploadSection && urlSection) {
                                            if (e.target.value === 'upload') {
                                                uploadSection.classList.remove('hidden');
                                                urlSection.classList.add('hidden');
                                                const urlInput = document.querySelector('input[name="imageUrl"]');
                                                if (urlInput) urlInput.value = '';
                                            } else {
                                                uploadSection.classList.add('hidden');
                                                urlSection.classList.remove('hidden');
                                                const fileInput = document.querySelector('input[name="imageFile"]');
                                                if (fileInput) fileInput.value = '';
                                            }
                                        }
                                    });
                                });
                            }

                            // Function to show notifications
                            function showNotification(title, message, type) {
                                const notification = document.createElement('div');
                                notification.classList.add('notification', type); 
                                notification.innerHTML = `
                                    <strong>${title}</strong><br/>
                                    ${message}
                                `;
                                document.body.appendChild(notification);
                                setTimeout(() => {
                                    notification.remove();
                                }, 3000);
                            }

                            // Add modal outside click handler
                            const modal = document.getElementById('productModal');
                            if (modal) {
                                modal.addEventListener('click', (e) => {
                                    if (e.target === modal) {
                                        closeModal();
                                    }
                                });
                            }

                            function closeModal() {
                                const modal = document.getElementById('productModal');
                                if (modal) {
                                    modal.classList.add('hidden'); // Hide the modal
                                }
                            }
                        });
                        </script>

                        <button class="manager-option bg-yellow-100 hover:bg-yellow-200 p-4 rounded-lg flex flex-col items-center" data-action="holiday-drops">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-semibold text-yellow-800">Holiday Drops</span>
                        </button>

                        <button class="manager-option bg-purple-100 hover:bg-purple-200 p-4 rounded-lg flex flex-col items-center" data-action="reports">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="font-semibold text-purple-800">Reports</span>
                        </button>

                        <button class="manager-option bg-red-100 hover:bg-red-200 p-4 rounded-lg flex flex-col items-center" data-action="orders">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="font-semibold text-red-800">Manage Orders</span>
                        </button>

                        <button class="manager-option bg-indigo-100 hover:bg-indigo-200 p-4 rounded-lg flex flex-col items-center" data-action="blog-interactions">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span class="font-semibold text-indigo-800">Blog Interactions</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Charts initialization
    document.addEventListener('DOMContentLoaded', function() {
        // User Growth Chart
        new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_keys($filledUserData)); ?>,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo json_encode(array_values($filledUserData)); ?>,
                    borderColor: '#4ade80',
                    backgroundColor: 'rgba(74, 222, 128, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointBackgroundColor: '#4ade80',
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return new Date(context[0].label).toLocaleDateString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                const date = new Date(this.getLabelForValue(value));
                                return date.getDate(); // Just show the day of month
                            }
                        }
                    }
                }
            }
        });

        // Blog Post Chart
        new Chart(document.getElementById('blogChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($filledBlogData)); ?>,
                datasets: [{
                    label: 'New Blog Posts',
                    data: <?php echo json_encode(array_values($filledBlogData)); ?>,
                    backgroundColor: 'rgba(96, 165, 250, 0.8)',
                    borderColor: 'rgba(96, 165, 250, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins:{
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return new Date(context[0].label).toLocaleDateString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                const date = new Date(this.getLabelForValue(value));
                                return date.getDate(); // Just show the day of month
                            }
                        }
                    }
                }
            }
        });
    });

    // Function to show the modal
    function showModal() {
        document.getElementById("messageModal").classList.remove("hidden");
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("messageModal").classList.add("hidden");
    }

    // Close modal when clicking outside the content
    document.getElementById('messageModal').addEventListener('click', function(event) {
        if (event.target === this) { // Check if the click is outside the modal content
            closeModal();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const managerCard = document.getElementById('manager-special-request');
        const managerModal = document.getElementById('manager-modal');
        const closeModalBtn = document.getElementById('close-manager-modal');
        const managerOptions = document.querySelectorAll('.manager-option');

        // Open Modal
        managerCard.addEventListener('click', () => {
            managerModal.classList.remove('hidden');
        });

        // Close Modal
        closeModalBtn.addEventListener('click', () => {
            managerModal.classList.add('hidden');
        });
    });






    document.addEventListener("DOMContentLoaded", function () {
        const openModalBtn = document.getElementById("open-special-requests-modal");
        const closeModalBtn = document.getElementById("close-special-requests-modal");
        const modal = document.getElementById("special-requests-modal");

        // Open Modal
        if (openModalBtn) {
            openModalBtn.addEventListener("click", function () {
                modal.classList.remove("hidden");
            });
        }

        // Close Modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener("click", function () {
                modal.classList.add("hidden");
            });
        }
    });

    </script>
</body>
</html>
<?php
$conn->close();
?>