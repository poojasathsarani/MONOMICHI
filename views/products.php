<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONOMICHI - Product Page</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-gray-100">

  <!-- Navigation Bar -->
  <nav class="bg-white shadow-md">
    <div class="max-w-screen-xl mx-auto px-4 py-5 flex justify-between items-center">
      <a href="#" class="text-2xl font-semibold text-gray-800">MONOMICHI</a>
      <div class="lg:flex space-x-6 hidden">
        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Home</a>
        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Shop</a>
        <a href="#" class="text-gray-600 hover:text-blue-600 transition">Cart</a>
      </div>
      <button class="lg:hidden text-gray-600 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Product Search and Filter -->
  <div class="w-full p-4 bg-gray-50 shadow-md rounded-lg">
    <div class="flex space-x-4 items-center">
      <input type="text" id="productSearch" class="w-full p-3 rounded-lg border border-gray-300 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search for products..." onkeyup="filterProducts()">
      <div>
        <label for="categoryFilter" class="sr-only">Category</label>
        <select id="categoryFilter" class="p-3 rounded-lg border border-gray-300 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterProducts()">
          <option value="">All Categories</option>
          <option value="Tea Sets">Tea Sets</option>
          <option value="Calligraphy Brushes">Calligraphy Brushes</option>
          <option value="Dolls">Dolls</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Product Listing -->
  <div class="container mx-auto mt-8 px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="product-list">
      <!-- Sample Product Card 1 -->
      <div class="product-card bg-white rounded-lg shadow-lg p-4 transition-transform duration-300 transform hover:scale-105" data-name="Traditional Tea Set" data-category="Tea Sets">
        <img src="product1.jpg" class="w-full h-48 object-cover rounded-t-lg transition-transform duration-300 transform hover:scale-105" alt="Traditional Tea Set">
        <div class="p-4">
          <h5 class="text-xl font-semibold text-gray-800">Traditional Tea Set</h5>
          <p class="text-gray-600 mt-2">A beautifully crafted traditional Japanese tea set. Perfect for tea lovers!</p>
          <div class="flex items-center space-x-2 mt-2">
            <span class="text-yellow-500">★★★★☆</span>
            <span class="text-gray-600">20 reviews</span>
          </div>
          <p class="text-lg font-bold text-gray-800 mt-2">$40.00</p>
          <div class="flex items-center space-x-4 mt-4">
            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Add to Cart</button>
            <button class="text-blue-500 hover:text-blue-600 transition" onclick="addToWishlist(this)">♥</button>
          </div>
        </div>
      </div>

      <!-- Sample Product Card 2 -->
      <div class="product-card bg-white rounded-lg shadow-lg p-4 transition-transform duration-300 transform hover:scale-105" data-name="Japanese Calligraphy Brush" data-category="Calligraphy Brushes">
        <img src="product2.jpg" class="w-full h-48 object-cover rounded-t-lg transition-transform duration-300 transform hover:scale-105" alt="Japanese Calligraphy Brush">
        <div class="p-4">
          <h5 class="text-xl font-semibold text-gray-800">Japanese Calligraphy Brush</h5>
          <p class="text-gray-600 mt-2">Handmade brush for Japanese calligraphy. Ideal for artists and beginners.</p>
          <div class="flex items-center space-x-2 mt-2">
            <span class="text-yellow-500">★★★★☆</span>
            <span class="text-gray-600">12 reviews</span>
          </div>
          <p class="text-lg font-bold text-gray-800 mt-2">$25.00</p>
          <div class="flex items-center space-x-4 mt-4">
            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Add to Cart</button>
            <button class="text-blue-500 hover:text-blue-600 transition" onclick="addToWishlist(this)">♥</button>
          </div>
        </div>
      </div>

      <!-- Sample Product Card 3 -->
      <div class="product-card bg-white rounded-lg shadow-lg p-4 transition-transform duration-300 transform hover:scale-105" data-name="Kokeshi Doll" data-category="Dolls">
        <img src="product3.jpg" class="w-full h-48 object-cover rounded-t-lg transition-transform duration-300 transform hover:scale-105" alt="Kokeshi Doll">
        <div class="p-4">
          <h5 class="text-xl font-semibold text-gray-800">Kokeshi Doll</h5>
          <p class="text-gray-600 mt-2">Handcrafted wooden doll, a traditional Japanese souvenir.</p>
          <div class="flex items-center space-x-2 mt-2">
            <span class="text-yellow-500">★★★★☆</span>
            <span class="text-gray-600">15 reviews</span>
          </div>
          <p class="text-lg font-bold text-gray-800 mt-2">$15.00</p>
          <div class="flex items-center space-x-4 mt-4">
            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Add to Cart</button>
            <button class="text-blue-500 hover:text-blue-600 transition" onclick="addToWishlist(this)">♥</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-8">
      <ul class="flex justify-center space-x-4">
        <li><a href="#" class="text-blue-600 hover:text-blue-800 transition">Previous</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800 transition">1</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800 transition">2</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800 transition">3</a></li>
        <li><a href="#" class="text-blue-600 hover:text-blue-800 transition">Next</a></li>
      </ul>
    </nav>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center py-4 mt-8">
    <p>&copy; 2025 MONOMICHI. All Rights Reserved.</p>
  </footer>

  <!-- Custom JS for Interactive Features -->
  <script>
    // Filter products based on search input and category filter
    function filterProducts() {
      const searchQuery = document.getElementById('productSearch').value.toLowerCase();
      const categoryFilter = document.getElementById('categoryFilter').value;
      const products = document.querySelectorAll('.product-card');
      products.forEach(product => {
        const productName = product.getAttribute('data-name').toLowerCase();
        const productCategory = product.getAttribute('data-category').toLowerCase();
        if (productName.includes(searchQuery) && (categoryFilter === '' || productCategory === categoryFilter.toLowerCase())) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
    }

    // Add product to wishlist
    function addToWishlist(button) {
      const productName = button.closest('.product-card').querySelector('h5').innerText;
      alert(productName + " has been added to your wishlist!");
      // Simple confetti effect on adding to wishlist
      confetti();
    }
  </script>

</body>
</html>
