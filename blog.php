<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Japan Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal {
            display: none;
        }
        .modal-active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="bg-pink-600 p-4 text-white">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <a href="#" class="text-2xl font-bold">Japan Blog</a>
        <div class="space-x-6">
            <a href="#" class="hover:text-gray-200">Home</a>
            <a href="#" class="hover:text-gray-200">Blog</a>
            <a href="#" class="hover:text-gray-200">Profile</a>
        </div>
    </div>
</nav>

<!-- Blog Dashboard -->
<div class="max-w-screen-xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Share Your Thoughts and Experiences About Japan</h1>
        <button id="createPostBtn" class="bg-pink-600 text-white px-6 py-2 rounded-lg">Create New Blog Post</button>
    </div>

    <!-- Blog List Section -->
    <div id="blog-list">
        <!-- Loop through the blogs dynamically -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold">A Journey Through Kyoto</h2>
            <p class="text-gray-500">Category: Culture, Travel</p>
            <p class="text-gray-700 mt-2">Kyoto is a city full of history and beauty. From its majestic temples to the serene gardens, every corner tells a story of Japan's rich cultural heritage...</p>
            <div class="flex items-center space-x-4 mt-4">
                <button class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700">Like</button>
                <button class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700">Comment</button>
            </div>
        </div>

        <!-- Example of Post Modal (hidden by default) -->
        <div id="blogPostModal" class="modal p-8 bg-white rounded-lg shadow-md max-w-xl mx-auto">
            <h3 class="text-xl font-semibold mb-4">Create a New Post</h3>
            <form id="blogForm" action="#" method="POST">
                <input type="text" name="title" placeholder="Blog Title" class="w-full px-4 py-2 mb-4 rounded-lg border border-gray-300 focus:outline-none">
                <textarea name="content" placeholder="Write your blog about Japan..." class="w-full px-4 py-2 mb-4 rounded-lg border border-gray-300 focus:outline-none" rows="6"></textarea>
                <div class="flex items-center space-x-4 mb-4">
                    <input type="file" name="image" accept="image/*" class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700">
                    <select name="category" class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700">
                        <option value="culture">Culture</option>
                        <option value="travel">Travel</option>
                        <option value="food">Food</option>
                    </select>
                </div>
                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg">Submit</button>
                <button type="button" id="cancelPostBtn" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg ml-4">Cancel</button>
            </form>
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer class="bg-gray-800 text-white p-6 mt-12">
    <div class="max-w-screen-xl mx-auto text-center">
        <p>&copy; 2025 Japan Blog. All Rights Reserved.</p>
    </div>
</footer>

<!-- JavaScript to Handle Modal Logic -->
<script>
    // Modal for creating a new post
    const createPostBtn = document.getElementById('createPostBtn');
    const blogPostModal = document.getElementById('blogPostModal');
    const cancelPostBtn = document.getElementById('cancelPostBtn');

    createPostBtn.addEventListener('click', () => {
        blogPostModal.classList.add('modal-active');
    });

    cancelPostBtn.addEventListener('click', () => {
        blogPostModal.classList.remove('modal-active');
    });
</script>

</body>
</html>
