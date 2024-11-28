<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <header class="bg-red-100 shadow">
        <div class="container mx-auto px-6 py-2 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <img src="../images/logo1.jpg" alt="MONOMICHI Logo" class="h-20 w-20 mr-2">
                    MONOMICHI
                </h1>
            </div>

            <!-- Centered Navigation -->
            <nav class="space-x-20 flex pr-10">
                <a href="../index.php" class="text-gray-600 hover:text-pink-600 text-2l">HOME</a>
                <a href="../views/products.php" class="text-gray-600 hover:text-pink-600 text-2l">PRODUCTS</a>
                <a href="../views/services.php" class="text-gray-600 hover:text-pink-600 text-2l">SERVICES</a>
                <a href="../views/faqs.php" class="text-gray-600 hover:text-pink-600 text-2l">FAQs</a>
                <a href="../views/contactus.php" class="text-gray-600 hover:text-pink-600 text-2l">CONTACT US</a>
                <a href="../views/aboutus.php" class="text-gray-600 hover:text-pink-600 text-2l">ABOUT US</a>
            </nav>

            <!-- Right Navigation -->
            <div class="space-x-6">
                <a href="../views/register.php" class="bg-pink-600 border-pink-600 text-white hover:bg-white hover:text-pink-600 py-2 px-6 rounded-full text-l font-semibold transition duration-300 ease-in-out transform hover:scale-105">Sign Up</a>
                <a href="../views/login.php" class="bg-white border-2 border-pink-600 text-pink-600 py-2 px-6 rounded-full text-l font-semibold transition duration-300 ease-in-out transform hover:bg-pink-600 hover:text-white hover:scale-105">Log In</a>
            </div>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="bg-cover bg-center h-screen" id="carousel">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center text-white">
                <h2 class="text-7xl font-bold">Welcome to MONOMICHI</h2>
                <p class="mt-4 text-lg">Explore authentic Japanese items and learn about Japanese culture.</p>
                <div class="mt-6">
                    <a href="#categories" class="px-6 py-3 bg-pink-600 hover:bg-red-700 rounded-full text-white font-semibold">Explore Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="container mx-auto px-6 py-16">
        <h3 class="text-3xl font-semibold text-center text-gray-800">Shop by Categories</h3>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://m.media-amazon.com/images/I/71yV-gx2KiL.jpg" alt="Stationery" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Stationery</h4>
                    <p class="mt-2 text-gray-600">Explore a collection of authentic Japanese stationery items.</p>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://miro.medium.com/v2/resize:fit:1080/1*v5fYCtaEIlF_v-Pe8szVbg.png" alt="Educational Books" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Educational Books</h4>
                    <p class="mt-2 text-gray-600">Dive into Japanese language and culture with our books.</p>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="https://photos.smugmug.com/Tokyo/n-S6Q5Pp/Kaiseki-/i-nDJStrP/0/f58c76ea/L/shutterstock_201996094-L.jpg" alt="Snacks" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="text-xl font-semibold">Tea & Snacks</h4>
                    <p class="mt-2 text-gray-600">Savor traditional Japanese snacks and teas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 py-10 text-gray-700">
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
                <p>&copy; 2024 MONOMICHI online store since 2011. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
<script>
    const images = [
        'https://t3.ftcdn.net/jpg/06/75/94/90/360_F_675949019_5piKZ1ScELyshhXbg24tFFUt0BwHuSWY.jpg',
        'https://images.rawpixel.com/image_800/czNmcy1wcml2YXRlL3Jhd3BpeGVsX2ltYWdlcy93ZWJzaXRlX2NvbnRlbnQvdjExNTUtYi0wMTFjLXguanBn.jpg',
        'https://t4.ftcdn.net/jpg/06/03/60/43/360_F_603604300_a64EoKEw3rM1P0c9ik9QjSB0shYRGewB.jpg',
        'https://img.freepik.com/free-vector/pink-trees-sky-banner-vector_53876-127811.jpg?semt=ais_hybrid',
        'https://static.vecteezy.com/system/resources/thumbnails/005/447/389/small_2x/spring-cherry-blossom-mountain-landscape-free-vector.jpg'
    ];

    let currentIndex = 0;

    function changeBackground() {
        const carousel = document.getElementById('carousel');
        carousel.style.backgroundImage = `url('${images[currentIndex]}')`;
        currentIndex = (currentIndex + 1) % images.length; // Loop through the images
    }

    setInterval(changeBackground, 5000); // Change every 5 seconds
    changeBackground(); // Set initial background
</script>
</html>