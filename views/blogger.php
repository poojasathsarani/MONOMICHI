<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogger Community Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            transition: background-color 0.3s;
            margin: 0;
            padding: 0;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .card-flip {
            perspective: 1000px;
        }
        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.5s;
        }
        .card:hover .card-inner {
            transform: rotateY(180deg);
        }
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
        }
        .card-back {
            transform: rotateY(180deg);
            background-color: #F7FAFC;
        }
        .card-header {
            color: #4C51BF;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .post-excerpt {
            color: #333;
            font-size: 1.125rem;
            line-height: 1.6;
        }
        .btn-primary {
            background-color: #3B82F6;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2563EB;
        }
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .highlight-bg {
            background-color: #FEF2F2;
            border-radius: 10px;
            padding: 5px 15px;
            color: #E11D48;
        }
        .parallax {
            background-image: url('https://via.placeholder.com/1920x600');
            height: 400px;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            transition: background-position 0.3s ease-out;
        }
        .parallax:hover {
            background-position: center top;
        }
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
        .trending-tags {
            background-color: #fef9ed;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tag {
            background-color: #e2e8f0;
            border-radius: 5px;
            padding: 5px 12px;
            margin: 5px;
            display: inline-block;
            color: #3182ce;
        }
        .social-media-btn {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .social-btn {
            background-color: #4267B2;
            border-radius: 50%;
            padding: 12px;
            color: white;
            transition: transform 0.3s;
        }
        .social-btn:hover {
            transform: scale(1.1);
        }
        /* Dark Mode Styles */
        .dark-mode {
            background-color: #1F2937;
            color: #e2e8f0;
        }
        .dark-mode .btn-primary {
            background-color: #2563EB;
        }
        .dark-mode .card {
            background-color: #2D3748;
            color: #F7FAFC;
        }
        .dark-mode .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .dark-mode .post-header {
            color: #4C51BF;
        }
        .dark-mode .post-excerpt {
            color: #E2E8F0;
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 2s forwards;
        }
        @keyframes fadeIn {
            100% {
                opacity: 1;
            }
        }
        /* Image Carousel */
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            overflow: hidden;
        }
        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-images img {
            width: 100%;
            border-radius: 15px;
        }
        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
        .carousel-button.prev {
            left: 10px;
        }
        .carousel-button.next {
            right: 10px;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .max-w-7xl {
                max-width: 100%;
                padding: 0 10px;
            }
            .grid-cols-3 {
                grid-template-columns: 1fr;
            }
            .sticky-sidebar {
                position: relative;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-6 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="text-4xl font-semibold">MONOMICHI Blog 🌸</a>
            <button class="btn-primary">Log Out</button>
            <button class="btn-primary" id="darkModeToggle">Toggle Dark Mode</button>
        </div>
    </nav>

    <!-- Parallax Scrolling Banner -->
    <div class="parallax"></div>

    <!-- Main Content Section -->
    <div class="max-w-7xl mx-auto p-8 grid grid-cols-3 gap-8 fade-in">

        <!-- Sidebar (Profile & Navigation) -->
        <div class="col-span-1 bg-white p-6 rounded-xl shadow-xl sticky-sidebar">
            <div class="text-center mb-8">
                <img class="user-avatar mb-4" src="https://via.placeholder.com/150" alt="User Avatar">
                <div class="font-semibold text-xl text-teal-500">Blogger Name 📝</div>
                <div class="text-sm text-gray-500">Passionate about Japanese culture! 🇯🇵</div>
            </div>
            <ul class="space-y-6">
                <li><a href="#create-post" class="text-lg font-semibold text-gray-700 hover:text-teal-500">Create New Post ✍️</a></li>
                <li><a href="#my-posts" class="text-lg font-semibold text-gray-700 hover:text-teal-500">My Posts 📚</a></li>
                <li><a href="#drafts" class="text-lg font-semibold text-gray-700 hover:text-teal-500">Drafts 📝</a></li>
            </ul>
            <!-- Trending Tags -->
            <div class="trending-tags">
                <h3 class="font-semibold text-lg text-teal-500 mb-4">Trending Tags</h3>
                <div class="flex flex-wrap gap-4">
                    <span class="tag">#JapaneseCulture</span>
                    <span class="tag">#Kanji</span>
                    <span class="tag">#Matcha</span>
                    <span class="tag">#Origami</span>
                    <span class="tag">#Kimonos</span>
                </div>
            </div>
        </div>

        <!-- Blog Posts -->
        <div class="col-span-2 space-y-12">
            <div class="card card-flip p-6">
                <div class="card-inner">
                    <div class="card-front">
                        <div class="flex justify-between items-center mb-6">
                            <span class="post-header">Exploring the Art of Japanese Calligraphy ✍️</span>
                            <span class="text-sm text-gray-500">Posted 2 days ago</span>
                        </div>
                        <p class="post-excerpt">Explore the beauty and history of Kanji, and how Japanese Calligraphy is more than just writing. 🖋️</p>
                        <div class="flex space-x-6 items-center mt-4">
                            <button class="like-button" id="like-count1">👍 Like</button>
                            <button class="text-sm hover:text-teal-700">💬 Comment</button>
                            <button class="text-sm hover:text-teal-700">🔗 Share</button>
                        </div>
                    </div>
                    <div class="card-back p-6">
                        <p class="post-excerpt">Get deeper into the techniques and tools used in traditional Japanese calligraphy and how it reflects the culture. 🌸</p>
                        <div class="mt-4 text-sm text-gray-500">
                            <a href="#" class="hover:text-teal-700">Read more...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
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
        </script>
</body>
</html>
