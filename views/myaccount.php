<?php
// Start the session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get user details from session
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Hardcoded user data for demo purposes
$users = [
    'admin' => ['name' => 'Admin User', 'email' => 'admin@monomichi.com', 'role' => 'Admin'],
    'manager' => ['name' => 'Manager User', 'email' => 'manager@monomichi.com', 'role' => 'Manager'],
    'customer' => ['name' => 'Customer User', 'email' => 'customer@monomichi.com', 'role' => 'Customer'],
    'blogger' => ['name' => 'Blogger User', 'email' => 'blogger@monomichi.com', 'role' => 'Blogger']
];

// Retrieve user info based on the role
$userInfo = isset($users[$role]) ? $users[$role] : null;

// If user info doesn't exist, redirect to login page
if (!$userInfo) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <section class="min-h-screen flex items-center justify-center bg-gray-100">
        <!-- Profile Container -->
        <div class="max-w-lg mx-auto bg-white shadow-lg border-4 border-pink-200 rounded-lg p-8">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Profile</h2>

            <!-- User Info -->
            <div class="text-lg text-gray-700 mb-4">
                <strong>Name:</strong> <?php echo htmlspecialchars($userInfo['name']); ?>
            </div>
            <div class="text-lg text-gray-700 mb-4">
                <strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?>
            </div>
            <div class="text-lg text-gray-700 mb-4">
                <strong>Role:</strong> <?php echo htmlspecialchars($userInfo['role']); ?>
            </div>

            <!-- Logout Button -->
            <div class="flex justify-center">
                <a href="logout.php" class="py-2 px-6 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300 ease-in-out">Log Out</a>
            </div>
        </div>
    </section>
</body>
</html>
