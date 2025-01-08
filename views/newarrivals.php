<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Arrivals - MONOMICHI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
  <script>
    // Trigger confetti on page load
    window.onload = () => {
      confetti({
        particleCount: 100,
        spread: 70,
        origin: { y: 0.6 }
      });
    };
  </script>
</head>
<body class="bg-gray-50">

  <!-- Page Header -->
  <section class="text-center py-12 bg-gray-100">
    <h1 class="text-4xl font-bold text-gray-900">New Arrivals</h1>
    <p class="mt-4 text-lg text-gray-600">Discover the latest additions to our collection! From traditional Japanese items to pop culture treasures, find something unique today.</p>
  </section>

  <!-- Sorting and Filters -->
  <section class="flex justify-between items-center px-4 py-6 bg-gray-50">
    <div class="flex items-center space-x-4">
      <label for="category" class="text-lg font-semibold text-gray-700">Category:</label>
      <select id="category" class="px-4 py-2 border border-gray-300 rounded-md">
        <option value="all">All Categories</option>
        <option value="traditional">Traditional Japanese</option>
        <option value="pop-culture">Pop Culture</option>
        <option value="stationery">Stationery</option>
        <option value="home-decor">Home Decor</option>
      </select>
    </div>

    <div class="flex items-center space-x-4">
      <label for="sort-by" class="text-lg font-semibold text-gray-700">Sort by:</label>
      <select id="sort-by" class="px-4 py-2 border border-gray-300 rounded-md">
        <option value="latest">Latest</option>
        <option value="price-low-to-high">Price: Low to High</option>
        <option value="price-high-to-low">Price: High to Low</option>
      </select>
    </div>
  </section>

  <!-- Product Grid -->
  <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4 py-8">
    <!-- Product 1 -->
    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow transform hover:scale-105">
      <img src="path/to/product-image.jpg" alt="Product Name" class="w-full h-48 object-cover rounded-md">
      <h3 class="mt-4 text-xl font-semibold text-gray-800">Product Name</h3>
      <p class="mt-2 text-lg font-semibold text-gray-900">₹ Price</p>
      <a href="#" class="mt-4 inline-block w-full text-center py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors">Add to Cart</a>
    </div>
    <!-- Repeat for more products -->
    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow transform hover:scale-105">
      <img src="path/to/product-image.jpg" alt="Product Name" class="w-full h-48 object-cover rounded-md">
      <h3 class="mt-4 text-xl font-semibold text-gray-800">Product Name</h3>
      <p class="mt-2 text-lg font-semibold text-gray-900">₹ Price</p>
      <a href="#" class="mt-4 inline-block w-full text-center py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors">Add to Cart</a>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow transform hover:scale-105">
      <img src="path/to/product-image.jpg" alt="Product Name" class="w-full h-48 object-cover rounded-md">
      <h3 class="mt-4 text-xl font-semibold text-gray-800">Product Name</h3>
      <p class="mt-2 text-lg font-semibold text-gray-900">₹ Price</p>
      <a href="#" class="mt-4 inline-block w-full text-center py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors">Add to Cart</a>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow transform hover:scale-105">
      <img src="path/to/product-image.jpg" alt="Product Name" class="w-full h-48 object-cover rounded-md">
      <h3 class="mt-4 text-xl font-semibold text-gray-800">Product Name</h3>
      <p class="mt-2 text-lg font-semibold text-gray-900">₹ Price</p>
      <a href="#" class="mt-4 inline-block w-full text-center py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors">Add to Cart</a>
    </div>
    <!-- Add more products as needed -->
  </section>

  <!-- Load More Button -->
  <section class="text-center py-6">
    <button class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors">Load More</button>
  </section>

  <!-- Back to Top Button -->
  <section class="text-center py-6">
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-md hover:bg-gray-700 transition-colors">Back to Top</button>
  </section>

</body>
</html>
