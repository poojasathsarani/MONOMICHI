<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>New Arrivals</title>
</head>
<body class="bg-gray-100">

  <!-- Header Section -->
  <header class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-4">
      <h1 class="text-3xl font-bold text-gray-800">New Arrivals</h1>
      <p class="text-gray-600 mt-2">Discover the latest additions to our collection!</p>
    </div>
  </header>

  <!-- Product Grid Section -->
  <main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <!-- Product Item -->
      <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <img src="https://via.placeholder.com/150" alt="Product 1" class="w-full h-48 object-cover rounded-t-lg">
        <div class="p-4">
          <h2 class="text-lg font-semibold text-gray-800">Product Name 1</h2>
          <p class="text-gray-600 mt-1">Short description of the product.</p>
          <p class="text-gray-900 font-bold mt-2">$25.00</p>
          <button class="w-full bg-blue-500 text-white font-medium py-2 mt-3 rounded-lg hover:bg-blue-600">Add to Cart</button>
        </div>
      </div>
      <!-- Repeat for other products -->
      <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <img src="https://via.placeholder.com/150" alt="Product 2" class="w-full h-48 object-cover rounded-t-lg">
        <div class="p-4">
          <h2 class="text-lg font-semibold text-gray-800">Product Name 2</h2>
          <p class="text-gray-600 mt-1">Short description of the product.</p>
          <p class="text-gray-900 font-bold mt-2">$30.00</p>
          <button class="w-full bg-blue-500 text-white font-medium py-2 mt-3 rounded-lg hover:bg-blue-600">Add to Cart</button>
        </div>
      </div>
      <!-- Add more product items as needed -->
    </div>
  </main>

  <!-- Footer Section -->
  <footer class="bg-gray-800 text-white text-center py-4">
    <p>&copy; 2025 MONOMICHI. All rights reserved.</p>
  </footer>

</body>
</html>
