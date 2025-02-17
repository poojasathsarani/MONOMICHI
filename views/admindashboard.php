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






// Fetch Users
if (isset($_GET['fetch_users'])) {
    $query = "SELECT id, fullname, email, role FROM users";
    $result = $conn->query($query);
    
    if ($result) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($users);
    } else {
        echo json_encode(["error" => "Database error: " . $conn->error]);
    }
    exit;
}

// Edit User
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_user'])) {
    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['fullname'], $_POST['email'], $_POST['role'], $_POST['user_id']);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user: " . $conn->error;
    }
    exit;
}

// Delete User
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete_user'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $_POST['user_id']);

    if ($stmt->execute()) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
    exit;
}





// Fetch blogs from database
if (isset($_GET['fetch_blogs'])) {
    try {
        header('Content-Type: application/json');
        
        $sql = "SELECT p.id, p.title, p.content, p.status, p.image_url, p.created_at, u.fullname as author_name 
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        $result = $conn->query($sql);
        
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
        
        $blogs = [];
        while ($row = $result->fetch_assoc()) {
            // Sanitize the output
            $blogs[] = array(
                'id' => htmlspecialchars($row['id']),
                'title' => htmlspecialchars($row['title']),
                'content' => nl2br($row['content']),
                'status' => htmlspecialchars($row['status']),
                'image_url' => htmlspecialchars($row['image_url']),
                'author_name' => htmlspecialchars($row['author_name']),
                'created_at' => htmlspecialchars($row['created_at'])
            );
        }
        
        echo json_encode(["status" => "success", "data" => $blogs], JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
    exit;
}

// Update blog status (Approve or Decline)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the required fields are set
    if (isset($data['update_status']) && isset($data['blog_id']) && isset($data['status'])) {
        try {
            $blogId = filter_var($data['blog_id'], FILTER_VALIDATE_INT);
            $status = $data['status'];

            if ($blogId === false) {
                throw new Exception("Invalid blog ID");
            }

            if (!in_array($status, ['Approved', 'Pending'])) {
                throw new Exception("Invalid status");
            }

            // Update the blog status in the database
            $sql = "UPDATE posts SET status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("si", $status, $blogId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $stmt->close();
            echo json_encode([
                "status" => "success", 
                "message" => "Blog status updated to " . $status
            ]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
    exit;
}


// Delete blog
if (isset($_POST['delete_blog']) && isset($_POST['blog_id'])) {
    try {
        header('Content-Type: application/json');
        
        $blogId = filter_var($_POST['blog_id'], FILTER_VALIDATE_INT);
        if ($blogId === false) {
            throw new Exception("Invalid blog ID");
        }
        
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("i", $blogId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
        echo json_encode(["status" => "success", "message" => "Blog deleted"]);
        
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
    exit;
}






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $created_by = $_SESSION['id'];
    $image_path = null;

    // Debug file upload
    error_log(print_r($_FILES, true));

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/cultural_guidance/';
        
        // Create directory with full permissions
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = uniqid() . '_' . $_FILES['image']['name'];
        $upload_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $image_path = 'uploads/cultural_guidance/' . $file_name;
        } else {
            $upload_error = error_get_last();
            error_log("Upload error: " . print_r($upload_error, true));
        }
    }

    $stmt = $conn->prepare("INSERT INTO cultural_guidance_posts (title, content, image_path, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $content, $image_path, $created_by);

    if ($stmt->execute()) {
        header("Location: admindashboard.php?success=1");
    } else {
        header("Location: admindashboard.php?error=1");
    }
    exit();
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
                    <h1 class="text-4xl font-bold tracking-tight">Admin Hub</h1>
                    <p class="text-sm text-blue-100 mt-2">Management & Analytics Platform</p>
                </div>
                <nav>
                    <ul class="space-y-2">
                    <li>
                        <a href="#user-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a6 6 0 00-12 0v1h5M9 8a4 4 0 118 0 4 4 0 01-8 0z" />
                            </svg>
                            User Management
                        </a>
                    </li>

                    <li>
                        <a href="#blog-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M3 10h18M3 6h18M3 14h9M3 18h6" />
                            </svg>
                            Blog Management
                        </a>
                    </li>

                    <li>
                        <a href="#cultural-guidance-management" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 110 20 10 10 0 010-20zm0 0v10m0 0h4m-4 0h-4" />
                            </svg>
                            Cultural Guidance Management
                        </a>
                    </li>

                    <li>
                        <a href="#analytics" class="flex items-center p-3 hover:bg-white/10 rounded-lg transition duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19v-3m4 3v-6m4 6v-9m4 9V5m4 14V10" />
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
                    <div class="bg-white rounded-lg shadow-lg p-6 w-1/2 max-h-[80vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h3 id="modal-title" class="text-xl font-bold text-gray-800">User Management</h3>
                            <button id="close-modal" class="text-gray-600 hover:text-gray-900 text-lg">&times;</button>
                        </div>

                        <!-- Main Modal Content -->
                        <div id="modal-content">
                            <p class="mb-4">Select an option:</p>
                            <div class="space-y-3">
                                <button id="view-users-btn" class="bg-blue-500 text-white px-4 py-2 rounded w-full">View Users</button>
                            </div>
                        </div>

                        <!-- View Users Section -->
                        <div id="view-users-content" class="hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">User List</h3>
                            <div class="max-h-[60vh] overflow-y-auto border border-gray-300 rounded-lg">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead class="sticky top-0 bg-gray-200">
                                        <tr>
                                            <th class="border border-gray-300 p-2">ID</th>
                                            <th class="border border-gray-300 p-2">Full Name</th>
                                            <th class="border border-gray-300 p-2">Email</th>
                                            <th class="border border-gray-300 p-2">Role</th>
                                            <th class="border border-gray-300 p-2">Edit</th>
                                            <th class="border border-gray-300 p-2">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-list"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <button id="back-btn" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 hidden">Back</button>
                    </div>
                </div>
            </div>

            <!-- Blog Management -->
            <div id="blog-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 id="blog-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">Blog Management</h3>
                <p>Manage blogs, approve/delete blog posts, and configure blog settings.</p>
    
                <!-- Blog Options Section -->
                <div id="blog-options" class="hidden mt-4">
                    <!-- View Blogs -->
                    <div id="view-blogs" class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Blog Posts</h4>
                        <table id="blogs-table" class="w-full table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">Title</th>
                                    <th class="border px-4 py-2">Author</th>
                                    <th class="border px-4 py-2">Status</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Blog rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Blog View Modal -->
            <div id="blog-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <!-- Header Section -->
                        <div class="flex justify-between items-center pb-3 border-b">
                            <h3 class="text-2xl font-semibold text-gray-800" id="modal-title"></h3>
                            <button onclick="closeModal()" class="text-black close-modal text-xl font-bold hover:text-gray-700">&times;</button>
                        </div>
                        
                        <!-- Blog data -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-semibold">Author:</span>
                                <span id="modal-author" class="ml-2"></span>
                            </div>
                            <div>
                                <span class="font-semibold">Created:</span>
                                <span id="modal-date" class="ml-2"></span>
                            </div>
                            <div>
                                <span class="font-semibold">Status:</span>
                                <span id="modal-status" class="ml-2"></span>
                            </div>
                        </div>
                        
                        <!-- Blog Content -->
                        <div class="mt-6">
                            <div id="modal-content" class="prose max-w-none text-gray-700"></div>
                        </div>
                        
                        <!-- Blog Image -->
                        <div id="modal-image" class="mt-20">
                            <!-- Image will be rendered here if available -->
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-end mt-6 gap-4">
                            <button id="modal-approve" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Approve
                            </button>
                            <button id="modal-decline" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Decline
                            </button>
                            <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Close
                            </button>
                        </div>
                        <!-- Success Message Popup -->
                        <div id="success-popup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                                <h3 id="popup-title" class="text-xl font-bold text-green-600 mb-2"></h3>
                                <p id="popup-message" class="text-gray-700 mb-4"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Cultural Guidance -->
            <div id="cultural-guidance-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition-all duration-300">
                <h3 id="cultural-guidance-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">Cultural Guidance Management</h3>
                <p>Edit and update cultural guidance and learning materials.</p>
            </div>

            <div id="cultural-guidance-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
                <div class="bg-white rounded-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Add Cultural Guidance Post
                        </h2>
                        <button id="close-cultural-guidance-modal" class="text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form id="cultural-guidance-form" class="space-y-6">
                        <div>
                            <label for="post-title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" id="post-title" name="title" required 
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"/>
                        </div>

                        <div>
                            <label for="post-content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea id="post-content" name="content" rows="6" required 
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none"></textarea>
                        </div>

                        <div>
                            <label for="post-image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-all">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="post-image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="post-image" name="image" type="file" accept="image/*" class="sr-only"/>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <button type="button" id="cancel-cultural-guidance" 
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-300 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Submit Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>




            <!-- Analytics & Reports -->
            <a href="generate_report.php">
                <div id="analytics" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300 cursor-pointer">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Analytics & Reports</h3>
                    <p>Generate comprehensive reports and analyze platform metrics</p>
                </div>
            </a>
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





    $(document).ready(function () {
        function toggleModal(show = true) {
            if (show) {
                $("#user-management-modal").removeClass("hidden");
            } else {
                $("#user-management-modal").addClass("hidden");
                resetModal();
            }
        }

        function resetModal() {
            $("#modal-content").show();
            $("#view-users-content, #back-btn").hide();
        }

        // Fetch Users
        function loadUsers() {
            $.ajax({
                url: "admindashboard.php?fetch_users=1",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.error) {
                        alert("Error: " + response.error);
                        return;
                    }

                    let rows = response.map(user => 
                        `<tr data-id="${user.id}">
                            <td>${user.id}</td>
                            <td><input type="text" class="edit-field fullname" value="${user.fullname}" disabled></td>
                            <td><input type="text" class="edit-field email" value="${user.email}" disabled></td>
                            <td><input type="text" class="edit-field role" value="${user.role}" disabled></td>
                            <td>
                                <button class="edit-user bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                <button class="save-user bg-green-500 text-white px-2 py-1 rounded hidden">Save</button>
                            </td>
                            <td><button class="delete-user bg-red-500 text-white px-2 py-1 rounded">Delete</button></td>
                        </tr>`
                    ).join('');
                    $("#user-list").html(rows);
                },
                error: function (xhr, status, error) {
                    alert("AJAX Error: " + error);
                    console.log(xhr.responseText);
                }
            });
        }

        $("#user-management").click(() => toggleModal(true));
        $("#close-modal").click(() => toggleModal(false));

        $("#view-users-btn").click(() => {
            $("#modal-content").hide();
            $("#view-users-content, #back-btn").show();
            loadUsers();
        });

        $("#back-btn").click(() => resetModal());

        // Edit User
        $(document).on("click", ".edit-user", function () {
            let row = $(this).closest("tr");
            row.find(".edit-field").prop("disabled", false);
            row.find(".edit-user").hide();
            row.find(".save-user").removeClass("hidden");
        });

        // Save User
        $(document).on("click", ".save-user", function () {
            let row = $(this).closest("tr");
            let userId = row.data("id");
            let fullname = row.find(".fullname").val();
            let email = row.find(".email").val();
            let role = row.find(".role").val();

            $.post("admindashboard.php", { edit_user: 1, user_id: userId, fullname, email, role }, function (response) {
                alert(response);
                loadUsers();
            });
        });

        // Delete User
        $(document).on("click", ".delete-user", function () {
            let row = $(this).closest("tr");
            let userId = row.data("id");

            if (confirm("Are you sure you want to delete this user?")) {
                $.post("admindashboard.php", { delete_user: 1, user_id: userId }, function (response) {
                    alert(response);
                    loadUsers();
                });
            }
        });
    });


    

    // Blog Management
    document.getElementById('blog-management-heading').addEventListener('click', function() {
        const blogOptions = document.getElementById('blog-options');
        blogOptions.classList.toggle('hidden');
        loadBlogs();
    });

    function loadBlogs() {
        fetch('admindashboard.php?fetch_blogs=1')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'error') {
                    throw new Error(data.message);
                }
                
                const blogsTable = document.getElementById('blogs-table').getElementsByTagName('tbody')[0];
                blogsTable.innerHTML = ''; // Clear the table
                
                data.data.forEach(blog => {
                    const row = blogsTable.insertRow();
                    
                    // Add table cells
                    row.insertCell(0).textContent = blog.id;
                    row.insertCell(1).textContent = blog.title;
                    row.insertCell(2).textContent = blog.author_name;
                    
                    const statusCell = row.insertCell(3);
                    statusCell.textContent = blog.status;
                    statusCell.classList.add(blog.status === 'Approved' ? 'text-green-600' : 'text-yellow-600');
                    
                    const actionsCell = row.insertCell(4);
                    
                    // View button
                    const viewButton = document.createElement('button');
                    viewButton.textContent = 'View';
                    viewButton.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-blue-600', 'mr-2');
                    viewButton.onclick = () => viewBlog(blog);
                    actionsCell.appendChild(viewButton);
                    
                    // Delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
                    deleteButton.onclick = () => deleteBlog(blog.id);
                    actionsCell.appendChild(deleteButton);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load blogs: ' + error.message);
            });
    }

    function viewBlog(blog) {
        console.log('Blog data:', blog);
        
        const modal = document.getElementById('blog-modal');
        
        // Set title
        const titleElement = document.getElementById('modal-title');
        titleElement.textContent = blog.title || 'No Title';
        
        // Set author
        const authorElement = document.getElementById('modal-author');
        authorElement.textContent = blog.author_name || 'Unknown Author';
        
        // Set date with formatted date
        const formattedDate = new Date(blog.created_at).toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        const dateElement = document.getElementById('modal-date');
        dateElement.textContent = formattedDate;
        
        // Set content with line breaks preserved
        const contentElement = document.getElementById('modal-content');
        contentElement.innerHTML = blog.content ? blog.content.replace(/\n/g, "<br>") : 'No content available';

        // Ensure content scrolls properly
        contentElement.classList.add("overflow-y-auto", "max-h-[500px]");
        
        // Set status with color coding
        const statusElement = document.getElementById('modal-status');
        statusElement.textContent = blog.status;
        statusElement.className = 'ml-2 font-medium';
        statusElement.classList.add(blog.status === 'Approved' ? 'text-green-600' : 'text-yellow-600');
        
        // Handle image display
        const modalImage = document.getElementById('modal-image');
        if (blog.image_url && blog.image_url.trim() !== '') {
            modalImage.innerHTML = `
                <div class="rounded-lg overflow-hidden mt-4">
                    <img src="${blog.image_url}" 
                        alt="Blog image" 
                        class="max-w-full max-h-64 object-contain rounded-lg shadow-md mx-auto"
                        onerror="this.style.display='none'"
                    >
                </div>`;
        } else {
            modalImage.innerHTML = ''; // Clear if no image
        }
        
        // Set up approve/decline buttons
        const approveButton = document.getElementById('modal-approve');
        const declineButton = document.getElementById('modal-decline');
        const successPopup = document.getElementById('success-popup');
        const popupTitle = document.getElementById('popup-title');
        const popupMessage = document.getElementById('popup-message');

        approveButton.onclick = () => updateBlogStatus(blog.id, 'Approved');
        declineButton.onclick = () => updateBlogStatus(blog.id, 'Pending');

        function updateBlogStatus(blogId, status) {
        // Send an AJAX request to update the status
        fetch('admindashboard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                update_status: true,
                blog_id: blogId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Change popup message dynamically
                if (status === 'Approved') {
                    popupTitle.innerText = "Post Approved!";
                    popupMessage.innerText = "The blog post has been approved successfully.";
                } else {
                    popupTitle.innerText = "Post Declined!";
                    popupMessage.innerText = "The blog post has been moved to pending.";
                }

                // Show the popup
                successPopup.classList.remove("hidden");

                // Hide the popup after 3 seconds
                setTimeout(() => {
                    successPopup.classList.add("hidden");
                }, 3000);
            } else {
                // Handle error if any
                alert('Error updating blog status: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }


        // Show/hide buttons based on current status
        if (blog.status === 'Approved') {
            approveButton.classList.add('hidden');
            declineButton.classList.remove('hidden');
        } else {
            approveButton.classList.remove('hidden');
            declineButton.classList.add('hidden');
        }
        
        // Show modal
        modal.classList.remove('hidden');
    }

    // Function to close modal
    function closeModal() {
        document.getElementById('blog-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('blog-modal');
        if (event.target === modal) {
            closeModal();
        }
    }

    function deleteBlog(blogId) {
        if (!confirm('Are you sure you want to delete this blog? This action cannot be undone.')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('delete_blog', '1');
        formData.append('blog_id', blogId);
        
        fetch('admindashboard.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                throw new Error(data.message);
            }
            alert('Blog deleted successfully');
            loadBlogs(); // Reload the table
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete blog: ' + error.message);
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('blog-modal');
        if (event.target === modal) {
            closeModal();
        }
    }






    document.addEventListener('DOMContentLoaded', function() {
        const culturalGuidanceHeading = document.getElementById('cultural-guidance-heading');
        const culturalGuidanceModal = document.getElementById('cultural-guidance-modal');
        const closeCulturalGuidanceModal = document.getElementById('close-cultural-guidance-modal');
        const cancelCulturalGuidance = document.getElementById('cancel-cultural-guidance');
        const culturalGuidanceForm = document.getElementById('cultural-guidance-form');

        // Open modal when cultural guidance heading is clicked
        culturalGuidanceHeading.addEventListener('click', function() {
            culturalGuidanceModal.classList.remove('hidden');
        });

        // Close modal functions
        function closeModal() {
            culturalGuidanceModal.classList.add('hidden');
            culturalGuidanceForm.reset(); // Reset form
        }

        closeCulturalGuidanceModal.addEventListener('click', closeModal);
        cancelCulturalGuidance.addEventListener('click', closeModal);

        // Modal close on clicking outside
        culturalGuidanceModal.addEventListener('click', function(event) {
            if (event.target === culturalGuidanceModal) {
                closeModal();
            }
        });

        // Form submission
        culturalGuidanceForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(culturalGuidanceForm);

            fetch('admindashboard.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data && data.status === 'success') {
                    alert('Cultural guidance post added successfully!');
                    closeModal();
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Cultural guidance post added successfully!');
            });
        });
    });








    // Report Generate
    document.addEventListener('DOMContentLoaded', function() {
        const analytics = document.getElementById('analytics');
        const modal = document.getElementById('analyticsModal');
        const closeButton = document.getElementById('closeAnalyticsModal');
        const generateBtn = document.getElementById('generateBtn');

        analytics.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeButton.addEventListener('click', closeModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        let selectedReportType = '';

        // Handle report type selection
        document.querySelectorAll('[onclick^="generateReport"]').forEach(element => {
            element.addEventListener('click', function() {
                // Remove previous selection highlight
                document.querySelectorAll('[onclick^="generateReport"]').forEach(el => {
                    el.classList.remove('bg-blue-100');
                    el.classList.add('hover:bg-blue-50');
                });
                
                // Add highlight to selected report
                this.classList.add('bg-blue-100');
                this.classList.remove('hover:bg-blue-50');
                
                selectedReportType = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            });
        });

        generateBtn.addEventListener('click', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (!selectedReportType) {
                alert('Please select a report type.');
                return;
            }

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }

            // Send the request to generate the report
            const formData = new FormData();
            formData.append('report_type', selectedReportType);
            formData.append('start_date', startDate);
            formData.append('end_date', endDate);

            fetch('admindashboard.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(filePath => {
                alert('Report generated: ' + filePath);
                // Optionally, trigger download or show the link
                window.location.href = filePath;
            })
            .catch(error => {
                console.error('Error generating report:', error);
                alert('An error occurred while generating the report.');
            });
        });
    });

    function closeModal() {
        const modal = document.getElementById('analyticsModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function generateReport(type, startDate, endDate) {
        const formData = new FormData();
        formData.append('type', type);
        formData.append('startDate', startDate);
        formData.append('endDate', endDate);

        const generateBtn = document.getElementById('generateBtn');
        generateBtn.disabled = true;
        generateBtn.innerHTML = 'Generating...';

        fetch('admindashboard.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            generateBtn.disabled = false;
            generateBtn.innerHTML = 'Generate Report';
            
            if (data.includes('Error')) {
                alert(data);
            } else {
                const blob = new Blob([data], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `${type}_report_${startDate}_to_${endDate}.csv`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                closeModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while generating the report');
            generateBtn.disabled = false;
            generateBtn.innerHTML = 'Generate Report';
        });
    }
    </script>
</body>
</html>
<?php
$conn->close();
?>