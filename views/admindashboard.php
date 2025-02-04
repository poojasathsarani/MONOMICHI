<?php
session_start();
include('db_connection.php');

// Redirect to login if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['id'];
$query = "SELECT fullname FROM users WHERE id = ? AND role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin_name = ($result->num_rows > 0) ? $result->fetch_assoc()['fullname'] : "Admin";

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

// Fetch Users (AJAX Request)
if (isset($_GET['fetch_users'])) {
    $query = "SELECT id, fullname, email, role FROM users";
    $result = $conn->query($query);
    
    if ($result) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($users);  // Return JSON Response
    } else {
        echo json_encode(["error" => "Database error: " . $conn->error]);
    }
    exit;
}

// Handle Edit User
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_user'])) {
    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['fullname'], $_POST['email'], $_POST['role'], $_POST['user_id']);
    $stmt->execute();
    echo "<script>alert('User updated successfully!'); window.location.href='admindashboard.php';</script>";
}

// Handle Delete User
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete_user'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $_POST['user_id']);
    $stmt->execute();
    echo "<script>alert('User deleted successfully!'); window.location.href='admindashboard.php';</script>";
}

// Handle Configure Privileges
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['configure_privileges'])) {
    $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
    $stmt->bind_param("si", $_POST['role'], $_POST['user_id']);
    $stmt->execute();
    echo "<script>alert('User privileges updated!'); window.location.href='admindashboard.php';</script>";
}

// User Growth Calculation
$userGrowthQuery = "
    SELECT 
        DATE_FORMAT(registration_date, '%Y-%m') AS month, 
        COUNT(*) AS new_users
    FROM 
        users
    WHERE 
        registration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
    GROUP BY 
        month
    ORDER BY 
        month
";
$userGrowthResult = $conn->query($userGrowthQuery);
$userGrowthData = [];
while ($row = $userGrowthResult->fetch_assoc()) {
    $userGrowthData[] = $row;
}

// Blog Post Growth - Using the existing created_at column from posts table
$blogGrowthQuery = "
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') AS month, 
        COUNT(*) AS new_posts
    FROM 
        posts
    WHERE 
        created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
    AND 
        status = 'Approved'
    GROUP BY 
        month
    ORDER BY 
        month
";
$blogGrowthResult = $conn->query($blogGrowthQuery);
$blogGrowthData = [];
while ($row = $blogGrowthResult->fetch_assoc()) {
    $blogGrowthData[] = $row;
}

// Error handling
if (!$userGrowthResult || !$blogGrowthResult) {
    error_log("Database query error: " . $conn->error);
    // Provide empty arrays as fallback
    $userGrowthData = [];
    $blogGrowthData = [];
}

// Ensure we have at least some data for the charts
if (empty($userGrowthData)) {
    // Add dummy data for the last 6 months
    for ($i = 5; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));
        $userGrowthData[] = ['month' => $month, 'new_users' => 0];
    }
}

if (empty($blogGrowthData)) {
    // Add dummy data for the last 6 months
    for ($i = 5; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));
        $blogGrowthData[] = ['month' => $month, 'new_posts' => 0];
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        .gradient-sidebar {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        html {
            scroll-behavior: smooth;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-80 gradient-sidebar text-white p-6 shadow-2xl flex flex-col justify-between">
            <div>
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold tracking-tight">Admin Hub</h1>
                    <p class="text-sm text-blue-100 mt-2">Management & Analytics Platform</p>
                </div>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#user-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                User Management
                            </a>
                        </li>
                        <li>
                            <a href="#blog-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Blog Management
                            </a>
                        </li>
                        <li>
                            <a href="#cultural-guidance-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Cultural Guidance Management
                            </a>
                        </li>
                        <li>
                            <a href="#analytics" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Analytics
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
                    <p class="text-2xl font-semibold text-gray-800">Welcome Back, <?php echo htmlspecialchars($admin_name); ?>!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Button to trigger the modal -->
                    <button class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition" onclick="showModal()">Messages</button>

                    <!-- Modal Structure -->
                    <div id="messageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg w-1/2 p-6">
                            <h2 class="text-xl font-semibold mb-4">Messages Sent by Users</h2>
                            <div id="messagesContainer">
                                <!-- Messages will be dynamically inserted here -->
                                <?php if (empty($messages)): ?>
                                    <p>No messages found.</p>
                                <?php else: ?>
                                    <?php foreach ($messages as $message): ?>
                                        <div class="mb-4">
                                            <strong><?php echo htmlspecialchars($message['name']); ?> (<?php echo htmlspecialchars($message['email']); ?>):</strong>
                                            <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Reply%20to%20your%20message" 
                                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition ml-20">
                                            Reply
                                            </a>
                                            <hr class="my-4">
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 mt-4">Close</button>
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
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 818 0z" />
                        </svg>
                    </div>
                </div>
            </div>
                <!-- Similar cards for other metrics -->
            </div>

            <!-- Charts and Analytics -->
            <div class="grid grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold mb-4">User Growth</h3>
                    <canvas id="userGrowthChart"></canvas>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Blog Post Overview</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="container mx-auto mt-10">
                <!-- User Management -->
                <div id="user-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300 cursor-pointer">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">
                        User Management
                    </h3>
                    <p>Manage users, edit/delete user accounts, and configure user privileges.</p>
                </div>

                <!-- Modal for User Management -->
                <div id="user-management-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
                        <div class="flex justify-between items-center mb-4">
                            <h3 id="modal-title" class="text-xl font-bold text-gray-800">User Management</h3>
                            <button id="close-modal" class="text-gray-600 hover:text-gray-900 text-lg">&times;</button>
                        </div>

                        <!-- Main Modal Content -->
                        <div id="modal-content">
                            <p class="mb-4">Select an option:</p>
                            <div class="space-y-3">
                                <button id="view-users-btn" class="bg-blue-500 text-white px-4 py-2 rounded w-full">View Users</button>
                                <button id="edit-user-btn" class="bg-yellow-500 text-white px-4 py-2 rounded w-full">Edit User</button>
                                <button id="delete-user-btn" class="bg-red-500 text-white px-4 py-2 rounded w-full">Delete User</button>
                                <button id="configure-privileges-btn" class="bg-green-500 text-white px-4 py-2 rounded w-full">Configure Privileges</button>
                            </div>
                        </div>

                        <!-- View Users Section -->
                        <div id="view-users-content" class="hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">User List</h3>
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border border-gray-300 p-2">ID</th>
                                        <th class="border border-gray-300 p-2">Full Name</th>
                                        <th class="border border-gray-300 p-2">Email</th>
                                        <th class="border border-gray-300 p-2">Role</th>
                                    </tr>
                                </thead>
                                <tbody id="user-list"></tbody>
                            </table>
                        </div>

                        <!-- Form Section -->
                        <div id="form-section" class="hidden mt-4">
                            <h3 id="form-title" class="text-lg font-semibold text-gray-800 mb-4"></h3>
                            <form id="user-form">
                                <input type="hidden" id="user-id">
                                <div class="mb-4">
                                    <label class="block text-gray-700">Full Name</label>
                                    <input type="text" id="user-fullname" class="w-full border border-gray-300 p-2 rounded">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">Email</label>
                                    <input type="email" id="user-email" class="w-full border border-gray-300 p-2 rounded">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">Role</label>
                                    <select id="user-role" class="w-full border border-gray-300 p-2 rounded">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <button type="submit" id="submit-btn" class="bg-blue-500 text-white px-4 py-2 rounded w-full"></button>
                            </form>
                        </div>

                        <!-- Back Button -->
                        <button id="back-btn" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 hidden">Back</button>
                    </div>
                </div>
            </div>

            <!-- Blog Management -->
            <div id="blog-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 id="blog-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">Blog Management</h3>
                <p>Manage blogs, edit/delete blog posts, and configure blog settings.</p>
                
                <!-- Blog Options Section (Initially hidden) -->
                <div id="blog-options" class="hidden mt-4">
                    <!-- View Blogs -->
                    <div id="view-blogs" class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">View Blogs</h4>
                        <table id="blogs-table" class="w-full table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">Title</th>
                                    <th class="border px-4 py-2">Content</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Blog rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Blog -->
                    <div id="edit-blog" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Edit Blog</h4>
                        <form id="edit-blog-form" class="space-y-4">
                            <div>
                                <label for="edit-blog-id" class="block text-gray-700">Blog ID:</label>
                                <input type="text" id="edit-blog-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Blog ID" required>
                            </div>
                            <div>
                                <label for="edit-blog-title" class="block text-gray-700">Title:</label>
                                <input type="text" id="edit-blog-title" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter title" required>
                            </div>
                            <div>
                                <label for="edit-blog-content" class="block text-gray-700">Content:</label>
                                <textarea id="edit-blog-content" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter content" required></textarea>
                            </div>
                            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update Blog</button>
                        </form>
                    </div>

                    <!-- Delete Blog -->
                    <div id="delete-blog" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Delete Blog</h4>
                        <form id="delete-blog-form" class="space-y-4">
                            <div>
                                <label for="delete-blog-id" class="block text-gray-700">Blog ID:</label>
                                <input type="text" id="delete-blog-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Blog ID" required>
                            </div>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Blog</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cultural Guidance -->
            <div id="cultural-guidance-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Cultural Guidance</h3>
                <p>Edit and update cultural guidance and learning materials.</p>
            </div>

            <!-- Analytics & Reports -->
            <div id="analytics" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Analytics & Reports</h3>
                <p>Analyze your platform's performance, track metrics, and generate reports.</p>
            </div>

            <!-- Settings -->
            <div id="settings" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Settings</h3>
                <p>Configure your platform's settings, including payment methods, taxes, and shipping.</p>
            </div>
        </div>
    </div>

    <script>
        // Charts initialization
        document.addEventListener('DOMContentLoaded', function() {
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthLabels = <?php echo json_encode(array_column($userGrowthData, 'month')); ?>;
        const userGrowthValues = <?php echo json_encode(array_column($userGrowthData, 'new_users')); ?>;

        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: userGrowthLabels,
                datasets: [{
                    label: 'New Users',
                    data: userGrowthValues,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User Growth Over Last 6 Months'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Blog Post Growth Chart
        const blogGrowthCtx = document.getElementById('revenueChart').getContext('2d');
        const blogGrowthLabels = <?php echo json_encode(array_column($blogGrowthData, 'month')); ?>;
        const blogGrowthValues = <?php echo json_encode(array_column($blogGrowthData, 'new_posts')); ?>;

        new Chart(blogGrowthCtx, {
            type: 'bar',
            data: {
                labels: blogGrowthLabels,
                datasets: [{
                    label: 'New Blog Posts',
                    data: blogGrowthValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Blog Posts Growth Over Last 6 Months'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
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




    $(document).ready(function () {
        // Open & Close Modal Functions
        function toggleModal(show = true) {
            if (show) {
                $("#user-management-modal").removeClass("hidden");
            } else {
                $("#user-management-modal").addClass("hidden");
                resetModal();
            }
        }

        // Reset Modal Content
        function resetModal() {
            $("#modal-content").show();
            $("#view-users-content, #form-section, #back-btn").hide();
        }

        // Fetch and Load Users
        function loadUsers() {
            $.ajax({
                url: "admindashboard.php?fetch_users=1",  // Ensure the correct file path
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert("Error: " + response.error);
                        return;
                    }

                    let rows = response.map(user => 
                        `<tr>
                            <td>${user.id}</td>
                            <td>${user.fullname}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                        </tr>`
                    ).join('');
                    $("#user-list").html(rows);
                },
                error: function(xhr, status, error) {
                    alert("AJAX Error: " + error);
                    console.log(xhr.responseText);  // Debugging
                }
            });
        }

        // Open Modal
        $("#user-management").click(() => toggleModal(true));

        // Close Modal
        $("#close-modal").click(() => toggleModal(false));

        // View Users
        $("#view-users-btn").click(() => {
            $("#modal-content").hide();
            $("#view-users-content, #back-btn").show();
            loadUsers();
        });

        // Handle Form Actions (Edit, Delete, Configure)
        $("#edit-user-btn, #delete-user-btn, #configure-privileges-btn").click(function () {
            let action = $(this).attr("id").replace("-btn", "");
            $("#modal-content").hide();
            $("#form-section, #back-btn").show();
            $("#form-title").text(action.replace("-", " ").toUpperCase());
            $("#submit-btn").text(action.replace("-", " "));
        });

        // Back Button
        $("#back-btn").click(() => resetModal());
    });


    

    //Blog Management
    // Toggle the Blog Options section when the heading is clicked
    document.getElementById('blog-management-heading').addEventListener('click', function() {
        const blogOptions = document.getElementById('blog-options');
        blogOptions.classList.toggle('hidden');
    });

    // Load all blogs from localStorage and display them in the table
    function loadBlogs() {
        const blogsTable = document.getElementById('blogs-table').getElementsByTagName('tbody')[0];
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        blogsTable.innerHTML = ''; // Clear the table before rendering

        blogs.forEach(blog => {
            const row = blogsTable.insertRow();
            row.insertCell(0).textContent = blog.id;
            row.insertCell(1).textContent = blog.title;
            row.insertCell(2).textContent = blog.content;

            // Create Action buttons
            const actionsCell = row.insertCell(3);
            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-blue-600');
            editButton.onclick = () => populateEditForm(blog.id);
            
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
            deleteButton.onclick = () => deleteBlog(blog.id);
            
            actionsCell.appendChild(editButton);
            actionsCell.appendChild(deleteButton);
        });
    }

    // Add new blog
    document.getElementById('add-blog-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const newBlog = {
            id: Date.now(), // Unique ID based on timestamp
            title: document.getElementById('add-blog-title').value,
            content: document.getElementById('add-blog-content').value
        };

        // Get existing blogs from localStorage
        let blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        blogs.push(newBlog);
        
        // Save the updated blogs array
        localStorage.setItem('blogs', JSON.stringify(blogs));

        // Clear form and reload blogs
        document.getElementById('add-blog-form').reset();
        loadBlogs();
    });

    // Populate the Edit form with data
    function populateEditForm(blogId) {
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        const blogToEdit = blogs.find(blog => blog.id === blogId);

        if (blogToEdit) {
            document.getElementById('edit-blog-id').value = blogToEdit.id;
            document.getElementById('edit-blog-title').value = blogToEdit.title;
            document.getElementById('edit-blog-content').value = blogToEdit.content;
        }
    }

    // Edit blog
    document.getElementById('edit-blog-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const blogId = parseInt(document.getElementById('edit-blog-id').value);
        const updatedTitle = document.getElementById('edit-blog-title').value;
        const updatedContent = document.getElementById('edit-blog-content').value;
        
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        const blogIndex = blogs.findIndex(blog => blog.id === blogId);
        
        if (blogIndex !== -1) {
            blogs[blogIndex] = { id: blogId, title: updatedTitle, content: updatedContent };
            localStorage.setItem('blogs', JSON.stringify(blogs));
            loadBlogs(); // Reload blog data to reflect changes
        }
    });

    // Delete blog
    function deleteBlog(blogId) {
        const confirmDelete = confirm("Are you sure you want to delete this blog?");
        
        if (confirmDelete) {
            const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
            const updatedBlogs = blogs.filter(blog => blog.id !== blogId);
            
            localStorage.setItem('blogs', JSON.stringify(updatedBlogs));
            loadBlogs(); // Reload the blog list after deletion
        }
    }



    

    // Product Inventory Management

    // Toggle the Product Options section when the heading is clicked
    document.getElementById('product-inventory-heading').addEventListener('click', function() {
        const productOptions = document.getElementById('product-options');
        productOptions.classList.toggle('hidden');
    });

    // Load all products from localStorage and display them in the table
    function loadProducts() {
        const productsTable = document.getElementById('products-table').getElementsByTagName('tbody')[0];
        const products = JSON.parse(localStorage.getItem('products')) || [];
        productsTable.innerHTML = ''; // Clear the table before rendering

        products.forEach(product => {
            const row = productsTable.insertRow();
            row.insertCell(0).textContent = product.id;
            row.insertCell(1).textContent = product.name;
            row.insertCell(2).textContent = product.category;
            row.insertCell(3).textContent = product.price;
            row.insertCell(4).textContent = product.stock;

            // Create Action buttons
            const actionsCell = row.insertCell(5);
            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-blue-600');
            editButton.onclick = () => populateEditForm(product.id);
            
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
            deleteButton.onclick = () => deleteProduct(product.id);
            
            actionsCell.appendChild(editButton);
            actionsCell.appendChild(deleteButton);
        });
    }

    // Add new product
    document.getElementById('add-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const newProduct = {
            id: Date.now(), // Unique ID based on timestamp
            name: document.getElementById('add-product-name').value,
            category: document.getElementById('add-product-category').value,
            price: document.getElementById('add-product-price').value,
            stock: document.getElementById('add-product-stock').value
        };

        // Get existing products from localStorage
        let products = JSON.parse(localStorage.getItem('products')) || [];
        products.push(newProduct);
        
        // Save the updated products array
        localStorage.setItem('products', JSON.stringify(products));

        // Clear form and reload products
        document.getElementById('add-product-form').reset();
        loadProducts();
    });

    // Populate the Edit form with data
    function populateEditForm(productId) {
        const products = JSON.parse(localStorage.getItem('products')) || [];
        const productToEdit = products.find(product => product.id === productId);

        if (productToEdit) {
            document.getElementById('edit-product-id').value = productToEdit.id;
            document.getElementById('edit-product-name').value = productToEdit.name;
            document.getElementById('edit-product-category').value = productToEdit.category;
            document.getElementById('edit-product-price').value = productToEdit.price;
            document.getElementById('edit-product-stock').value = productToEdit.stock;
        }
    }

    // Edit product
    document.getElementById('edit-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const productId = parseInt(document.getElementById('edit-product-id').value);
        const updatedName = document.getElementById('edit-product-name').value;
        const updatedCategory = document.getElementById('edit-product-category').value;
        const updatedPrice = document.getElementById('edit-product-price').value;
        const updatedStock = document.getElementById('edit-product-stock').value;
        
        const products = JSON.parse(localStorage.getItem('products')) || [];
        const productIndex = products.findIndex(product => product.id === productId);
        
        if (productIndex !== -1) {
            products[productIndex] = { id: productId, name: updatedName, category: updatedCategory, price: updatedPrice, stock: updatedStock };
            localStorage.setItem('products', JSON.stringify(products));
            loadProducts(); // Reload product data to reflect changes
        }
    });

    // Delete product
    function deleteProduct(productId) {
        const confirmDelete = confirm("Are you sure you want to delete this product?");
        
        if (confirmDelete) {
            const products = JSON.parse(localStorage.getItem('products')) || [];
            const updatedProducts = products.filter(product => product.id !== productId);
            
            localStorage.setItem('products', JSON.stringify(updatedProducts));
            loadProducts(); // Reload the product list after deletion
        }
    }
    </script>
</body>
</html>
<?php
$conn->close();
?>