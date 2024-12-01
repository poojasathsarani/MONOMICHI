<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-serif">
    <!-- Navbar -->
    <header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <img src="../images/logo.png" alt="MONOMICHI Logo" class="h-16 w-16 mr-2">
                    MONOMICHI
                </h1>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex space-x-10 items-center">
                <a href="../index.php" class="text-gray-600 hover:text-pink-600 text-lg">HOME</a>
                <a href="../views/products.php" class="text-gray-600 hover:text-pink-600 text-lg">PRODUCTS</a>
                <a href="../views/services.php" class="text-gray-600 hover:text-pink-600 text-lg">SERVICES</a>
                <a href="../views/faqs.php" class="text-gray-600 hover:text-pink-600 text-lg">FAQs</a>
                <a href="../views/contactus.php" class="text-gray-600 hover:text-pink-600 text-lg">CONTACT US</a>
                <a href="../views/aboutus.php" class="text-gray-600 hover:text-pink-600 text-lg">ABOUT US</a>
            </nav>

            <!-- Right Navigation -->
            <div class="hidden lg:flex space-x-6">
                <a href="profile.php" class="flex items-center text-pink-600 hover:text-pink-700 text-lg">
                    <img src="../images/profile-icon.png" alt="Profile" class="h-8 w-8 rounded-full mr-2">
                    <?php echo $user['name']; ?>
                </a>
            </div>
        </div>
    </header>

    <!-- Profile Section -->
    <section class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-lg mx-auto bg-white shadow-lg shadow-pink-600 border-4 border-pink-200 rounded-lg p-8">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Your Profile</h2>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <a href="logout.php" class="mt-4 block text-center text-pink-600 hover:text-pink-700">Log Out</a>
        </div>
    </section>

</body>
</html>
