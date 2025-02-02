<?php
session_start();
include('db_connection.php');

$success = false; // Initialize success flag

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }

    // Get form data
    $userId = $_SESSION['id'];
    $title = $_POST['title'];
    $content = nl2br($_POST['content']); // Convert newlines to <br> tags

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = '../uploads/'; // Path to the uploads directory
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Image successfully uploaded
        } else {
            echo "Error uploading image.";
        }
    } else {
        $imagePath = null;  // No image uploaded
    }

    // SQL query to insert the post into the database with "Pending" status
    $sql = "INSERT INTO posts (user_id, title, content, image_url, created_at, status) VALUES (?, ?, ?, ?, NOW(), 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $userId, $title, $content, $imagePath);

    // Execute the query
    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogger Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
<body class="bg-pink-50 font-serif m-0 p-0 transition-all duration-300">
<!-- Navbar -->
<header class="bg-red-100 shadow sticky top-0 z-50">
        <div class="container mx-auto px-2 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                    <img src="../images/logoo.png" alt="MONOMICHI Logo" class="h-16 w-24 mr-2 mx-44">
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex items-center justify-center w-full max-w-xl ml-84">
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

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-80 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden opacity-0 transform -translate-y-2 transition-all duration-200">
                    <ul class="py-2 text-sm text-gray-700">
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

    <!-- Main Content Section -->
    <div class="max-w-9xl mx-auto p-8 grid grid-cols-6 gap-4 fade-in px-30">
        <!-- Sidebar (Profile & Navigation) -->
        <div class="col-span-3 bg-pink-100 p-8 rounded-xl shadow-xl sticky top-20 ml-40">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Latest Upload</h3>

            <!-- Display Image Preview -->
            <img id="imagePreview" src="" alt="Selected Image" class="w-full h-auto rounded-lg shadow-lg" style="display:none;">

            <?php
            // Fetch approved posts
            $sql = "SELECT id, title, content, image_url FROM posts WHERE status = 'Approved' ORDER BY created_at DESC LIMIT 5";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($postId, $title, $content, $imagePath);

            // Display posts
            while ($stmt->fetch()) {
                // Remove <br> tags from content
                $cleanContent = str_replace(["<br>", "<br/>", "<br />"], "", $content);
                
                echo "<div class='mb-4'>";
                echo "<h4 class='text-lg font-semibold text-gray-800'>$title</h4>";
                echo "<p class='text-gray-600 text-sm'>" . nl2br(htmlspecialchars($cleanContent)) . "</p>"; // Prevent XSS and format newlines

                // Display image if available
                if ($imagePath) {
                    echo "<img src='$imagePath' alt='Post Image' class='w-full h-auto rounded-lg shadow-lg mt-4'>";
                }

                // Like and Comment buttons
                echo "<div class='mt-4 flex justify-between items-center'>";
                echo "<button class='like-btn bg-pink-500 text-white px-4 py-2 rounded-lg flex items-center' data-postid='$postId'><i class='fas fa-heart mr-2'></i>Like</button>";
                echo "<button class='comment-btn bg-green-500 text-white px-4 py-2 rounded-lg flex items-center' data-postid='$postId'><i class='fas fa-comment mr-2'></i>Comment</button>";
                echo "<div class='comment-section' id='comment-section-$postId' style='display: none;'>
                        <textarea class='comment-text' data-postid='$postId' placeholder='Write a comment...' class='w-full p-2 border rounded-lg'></textarea>
                        <button class='submit-comment bg-blue-500 text-white px-4 py-2 rounded-lg mt-2' data-postid='$postId'>Submit</button>
                    </div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>

        <!-- Blog Posts -->
        <div class="col-span-3 space-y-12">
            <!-- New Post Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Share Your Thoughts 📝</h2>
                <form action="blogdashboard.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium">Title</label>
                        <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg mt-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-medium">Content</label>
                        <textarea id="content" name="content" rows="5" class="w-full p-2 border border-gray-300 rounded-lg mt-2" required></textarea>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-medium">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-lg mt-2">
                    </div>

                    <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200">Submit</button>
                </form>
            </div>

            <!-- Popup Box -->
            <?php if ($success): ?>
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-pink-600 mb-2">Post Submitted!</h3>
                        <p class="text-gray-700 mb-4">Your post is pending approval by the admin. Please wait for approval.</p>
                    </div>
                </div>
                <script>
                    // Optionally, redirect to dashboard or remain on the same page after 3 seconds
                    setTimeout(() => {
                        window.location.href = 'blogdashboard.php'; // Redirect to dashboard after 3 seconds
                    }, 3000);
                </script>
            <?php endif; ?>

            <!-- Displaying Pending Posts --> 
            <div class="bg-pink-200 p-6 rounded-lg shadow-lg">
            <?php
            // Fetch the logged-in user's posts with "Pending" status
            $sql = "SELECT title, content, image_url, status FROM posts WHERE user_id = ? AND status = 'Pending' ORDER BY created_at DESC";
            $stmt = $conn->prepare($sql);

            // Ensure that the session id is being set correctly
            if (!isset($_SESSION['id'])) {
                echo "<p class='text-gray-600'>You are not logged in. Please log in to see your posts.</p>";
                exit;
            }

            $userId = $_SESSION['id']; // Get the logged-in user's ID
            $stmt->bind_param("i", $userId);  // Bind the logged-in user ID
            $stmt->execute();
            $stmt->bind_result($title, $content, $imagePath, $status);

            // Check if there are any pending posts
            $hasPendingPosts = false;

            while ($stmt->fetch()) {
                $hasPendingPosts = true;

                // Remove <br> tags from content
                $cleanContent = str_replace(["<br>", "<br/>", "<br />"], "", $content);

                echo "<div class='mb-4'>";
                echo "<h4 class='text-lg font-semibold text-gray-800'>$title</h4>";
                echo "<p class='text-gray-600 text-sm'>" . nl2br(htmlspecialchars($cleanContent)) . "</p>"; // Display text safely and keep line breaks

                // Display image if present
                if ($imagePath) {
                    echo "<img src='" . htmlspecialchars($imagePath) . "' alt='Post Image' class='w-full h-auto rounded-lg shadow-lg mt-4'>";
                }

                // Display status
                echo "<p class='text-sm text-gray-500 mt-2'>Status: <span class='font-semibold text-yellow-600'>$status</span></p>";
                echo "</div>";
            }

            // If no pending posts are found
            if (!$hasPendingPosts) {
                echo "<p class='text-gray-600'>You have no pending posts. Please check back later.</p>";
            }
            ?>
            </div>
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

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    darkModeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });

    // Carousel Controls
    const carousel = document.querySelector('.carousel-images');
    const prevButton = document.querySelector('.carousel-button.prev');
    const nextButton = document.querySelector('.carousel-button.next');
    let currentIndex = 0;

    const updateCarousel = () => {
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    };

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : 0;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex < carousel.children.length - 1) ? currentIndex + 1 : carousel.children.length - 1;
        updateCarousel();
    });


    //JavaScript for Image Preview
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        // Like Button Click Event
        document.querySelectorAll(".like-btn").forEach(button => {
            button.addEventListener("click", function () {
                let postId = this.getAttribute("data-postid");

                fetch("like_post.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `post_id=${postId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.innerHTML = '<i class="fas fa-heart mr-2"></i> Liked';
                        this.classList.add("bg-red-500");
                    } else {
                        this.innerHTML = '<i class="fas fa-heart mr-2"></i> Like';
                        this.classList.remove("bg-red-500");
                    }
                });
            });
        });

        // Comment Button Click Event
        document.querySelectorAll(".comment-btn").forEach(button => {
            button.addEventListener("click", function () {
                let postId = this.getAttribute("data-postid");
                let commentSection = document.getElementById(`comment-section-${postId}`);
                commentSection.style.display = commentSection.style.display === "none" ? "block" : "none";
            });
        });

        // Submit Comment Button Event
        document.querySelectorAll(".submit-comment").forEach(button => {
            button.addEventListener("click", function () {
                let postId = this.getAttribute("data-postid");
                let commentInput = document.querySelector(`.comment-text[data-postid='${postId}']`);
                let commentText = commentInput.value.trim();

                if (commentText === "") return;

                fetch("add_comment.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `post_id=${postId}&comment=${encodeURIComponent(commentText)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let commentDiv = document.createElement("div");
                        commentDiv.classList.add("bg-gray-100", "p-2", "rounded-lg", "mt-2");
                        commentDiv.innerText = data.comment;
                        document.getElementById(`comment-section-${postId}`).appendChild(commentDiv);
                        commentInput.value = "";
                    }
                });
            });
        });
    });
</script>
</html>
