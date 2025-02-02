<?php
include('db_connection.php');

// Fetch users from database
$users = [];
$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}


// Flag for success message
$deleted = false;

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute SQL query to delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        $deleted = true;  // Set the flag for success
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Main Container -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-pink-400 to-pink-500 text-white p-6 flex flex-col space-y-8">
            <div class="text-3xl font-extrabold mb-8 text-white">Admin Dashboard</div>
            <ul class="space-y-6">
            <li><a href="#user-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Manage Users</a></li>
                <li><a href="#blog-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Blog Management</a></li>
                <li><a href="#cultural-guidance-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Cultural Gidance Management</a></li>
                <li><a href="#analytics" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Analytics & Reports</a></li>
                <li><a href="#settings" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-8 bg-gray-50">

            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div class="text-2xl font-semibold text-gray-800">Welcome Back, Admin!</div>
                <div class="flex items-center space-x-6">
                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200">Messages</button>
                    <button class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-200">Logout</button>
                </div>
            </div>

            <!-- Dashboard Overview -->
            <div id="overview" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Sales</h3>
                    <p class="text-3xl font-bold text-teal-600">Rs. 10 000</p>
                    <p class="text-sm text-gray-500">This Week</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Total Products</h3>
                    <p class="text-3xl font-bold text-teal-600">100</p>
                    <p class="text-sm text-gray-500">In Inventory</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center space-y-4">
                    <h3 class="text-xl font-semibold text-gray-800">Active Orders</h3>
                    <p class="text-3xl font-bold text-teal-600">12</p>
                    <p class="text-sm text-gray-500">Pending Orders</p>
                </div>
            </div>

            <!-- User Management -->
            <div id="user-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 id="user-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">User Management</h3>
                <p>Manage users, edit/delete user accounts, and configure user privileges.</p>
                
                <!-- User Options Section (Initially Hidden) -->
                <div id="user-options" class="hidden mt-4">
                    <!-- View Users Section -->
                    <div id="view-users" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">View Users</h4>
                        <table class="min-w-full border border-gray-200 bg-white text-sm text-left">
                            <thead class="bg-teal-600 text-white">
                                <tr>
                                    <th class="px-4 py-2">User ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="user-table" class="divide-y divide-gray-200">
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($user['fullname']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td class="px-4 py-2">
                                        <button onclick="editUser('<?php echo $user['id']; ?>', '<?php echo $user['fullname']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['role']; ?>')" class="bg-blue-500 text-white px-2 py-1 rounded">Edit User</button>
                                        <button onclick="deleteUser('<?php echo $user['id']; ?>')" class="bg-red-500 text-white px-2 py-1 rounded">Delete User</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Confirmation Popup -->
                    <div id="confirmationPopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                            <h3 class="text-xl font-bold text-pink-600 mb-2">Are you sure you want to delete this user?</h3>
                            <p class="text-gray-700 mb-4">This action cannot be undone.</p>
                            <div class="flex justify-around">
                                <button id="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded">Yes, Delete</button>
                                <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Success Popup Message -->
                    <div id="successPopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                            <h3 class="text-xl font-bold text-pink-600 mb-2">User Deleted Successfully!</h3>
                            <p class="text-gray-700 mb-4">You will be redirected shortly...</p>
                        </div>
                    </div>

                    <!-- Edit User -->
                    <div id="edit-user" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Edit User</h4>
                        <form id="edit-user-form" method="POST" action="edit_user.php" class="space-y-4">
                            <input type="hidden" id="edit-user-id" name="id">
                            <div>
                                <label for="edit-name" class="block text-gray-700">Name:</label>
                                <input type="text" id="edit-name" name="fullname" class="w-full border border-gray-300 p-2 rounded" required>
                            </div>
                            <div>
                                <label for="edit-email" class="block text-gray-700">Email:</label>
                                <input type="email" id="edit-email" name="email" class="w-full border border-gray-300 p-2 rounded" required>
                            </div>
                            <div>
                                <label for="edit-role" class="block text-gray-700">Role:</label>
                                <select id="edit-role" name="role" class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Blog Management -->
            <div id="blog-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 id="blog-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">Blog Management</h3>
                <p>Manage blogs, edit/delete blog posts, and configure blog settings.</p>
                
                <!-- Blog Options Section (Initially hidden) -->
                <div id="blog-options" class="hidden mt-4">
                    <!-- View Blogs -->
                    <div id="view-blogs" class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">View Blogs</h4>
                        <table id="blogs-table" class="w-full table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">Title</th>
                                    <th class="border px-4 py-2">Content</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Blog rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Blog -->
                    <div id="edit-blog" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Edit Blog</h4>
                        <form id="edit-blog-form" class="space-y-4">
                            <div>
                                <label for="edit-blog-id" class="block text-gray-700">Blog ID:</label>
                                <input type="text" id="edit-blog-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Blog ID" required>
                            </div>
                            <div>
                                <label for="edit-blog-title" class="block text-gray-700">Title:</label>
                                <input type="text" id="edit-blog-title" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter title" required>
                            </div>
                            <div>
                                <label for="edit-blog-content" class="block text-gray-700">Content:</label>
                                <textarea id="edit-blog-content" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter content" required></textarea>
                            </div>
                            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update Blog</button>
                        </form>
                    </div>

                    <!-- Delete Blog -->
                    <div id="delete-blog" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Delete Blog</h4>
                        <form id="delete-blog-form" class="space-y-4">
                            <div>
                                <label for="delete-blog-id" class="block text-gray-700">Blog ID:</label>
                                <input type="text" id="delete-blog-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Blog ID" required>
                            </div>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Blog</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Analytics & Reports -->
            <div id="analytics" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Analytics & Reports</h3>
                <p>Analyze your platform's performance, track metrics, and generate reports.</p>
            </div>

            <!-- Settings -->
            <div id="settings" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Settings</h3>
                <p>Configure your platform's settings, including payment methods, taxes, and shipping.</p>
            </div>

        </div>

    </div>

</body>
<script>
    // User Management
    document.getElementById('user-management-heading').addEventListener('click', function() {
        let userOptions = document.getElementById('user-options');
        
        if (userOptions.classList.contains('hidden')) {
            userOptions.classList.remove('hidden');
            userOptions.style.maxHeight = userOptions.scrollHeight + "px";
        } else {
            userOptions.style.maxHeight = "0";
            setTimeout(() => userOptions.classList.add('hidden'), 300);
        }
    });

    function editUser(id, name, email, role) {
            document.getElementById("edit-user-id").value = id;
            document.getElementById("edit-name").value = name;
            document.getElementById("edit-email").value = email;
            document.getElementById("edit-role").value = role;
    }

    function deleteUser(userId) {
        // Show confirmation popup
        document.getElementById("confirmationPopup").classList.remove("hidden");

        // Handle confirmation
        document.getElementById("confirmDelete").onclick = function () {
            // Redirect to delete_user.php with user ID
            window.location.href = "admindashboard.php?id=" + userId;
        };

        // Handle cancellation
        document.getElementById("cancelDelete").onclick = function () {
            // Close the confirmation popup
            document.getElementById("confirmationPopup").classList.add("hidden");
        };
    }

    // Show success popup after user is deleted
    function showSuccessPopup() {
        document.getElementById("successPopup").classList.remove("hidden");

        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = 'admindashboard.php'; // Or any other redirect
        }, 3000);
    }



    

    //Blog Management
    // Toggle the Blog Options section when the heading is clicked
    document.getElementById('blog-management-heading').addEventListener('click', function() {
        const blogOptions = document.getElementById('blog-options');
        blogOptions.classList.toggle('hidden');
    });

    // Load all blogs from localStorage and display them in the table
    function loadBlogs() {
        const blogsTable = document.getElementById('blogs-table').getElementsByTagName('tbody')[0];
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        blogsTable.innerHTML = ''; // Clear the table before rendering

        blogs.forEach(blog => {
            const row = blogsTable.insertRow();
            row.insertCell(0).textContent = blog.id;
            row.insertCell(1).textContent = blog.title;
            row.insertCell(2).textContent = blog.content;

            // Create Action buttons
            const actionsCell = row.insertCell(3);
            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-blue-600');
            editButton.onclick = () => populateEditForm(blog.id);
            
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
            deleteButton.onclick = () => deleteBlog(blog.id);
            
            actionsCell.appendChild(editButton);
            actionsCell.appendChild(deleteButton);
        });
    }

    // Add new blog
    document.getElementById('add-blog-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const newBlog = {
            id: Date.now(), // Unique ID based on timestamp
            title: document.getElementById('add-blog-title').value,
            content: document.getElementById('add-blog-content').value
        };

        // Get existing blogs from localStorage
        let blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        blogs.push(newBlog);
        
        // Save the updated blogs array
        localStorage.setItem('blogs', JSON.stringify(blogs));

        // Clear form and reload blogs
        document.getElementById('add-blog-form').reset();
        loadBlogs();
    });

    // Populate the Edit form with data
    function populateEditForm(blogId) {
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        const blogToEdit = blogs.find(blog => blog.id === blogId);

        if (blogToEdit) {
            document.getElementById('edit-blog-id').value = blogToEdit.id;
            document.getElementById('edit-blog-title').value = blogToEdit.title;
            document.getElementById('edit-blog-content').value = blogToEdit.content;
        }
    }

    // Edit blog
    document.getElementById('edit-blog-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const blogId = parseInt(document.getElementById('edit-blog-id').value);
        const updatedTitle = document.getElementById('edit-blog-title').value;
        const updatedContent = document.getElementById('edit-blog-content').value;
        
        const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
        const blogIndex = blogs.findIndex(blog => blog.id === blogId);
        
        if (blogIndex !== -1) {
            blogs[blogIndex] = { id: blogId, title: updatedTitle, content: updatedContent };
            localStorage.setItem('blogs', JSON.stringify(blogs));
            loadBlogs(); // Reload blog data to reflect changes
        }
    });

    // Delete blog
    function deleteBlog(blogId) {
        const confirmDelete = confirm("Are you sure you want to delete this blog?");
        
        if (confirmDelete) {
            const blogs = JSON.parse(localStorage.getItem('blogs')) || [];
            const updatedBlogs = blogs.filter(blog => blog.id !== blogId);
            
            localStorage.setItem('blogs', JSON.stringify(updatedBlogs));
            loadBlogs(); // Reload the blog list after deletion
        }
    }



    

    // Product Inventory Management

    // Toggle the Product Options section when the heading is clicked
    document.getElementById('product-inventory-heading').addEventListener('click', function() {
        const productOptions = document.getElementById('product-options');
        productOptions.classList.toggle('hidden');
    });

    // Load all products from localStorage and display them in the table
    function loadProducts() {
        const productsTable = document.getElementById('products-table').getElementsByTagName('tbody')[0];
        const products = JSON.parse(localStorage.getItem('products')) || [];
        productsTable.innerHTML = ''; // Clear the table before rendering

        products.forEach(product => {
            const row = productsTable.insertRow();
            row.insertCell(0).textContent = product.id;
            row.insertCell(1).textContent = product.name;
            row.insertCell(2).textContent = product.category;
            row.insertCell(3).textContent = product.price;
            row.insertCell(4).textContent = product.stock;

            // Create Action buttons
            const actionsCell = row.insertCell(5);
            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.classList.add('bg-blue-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-blue-600');
            editButton.onclick = () => populateEditForm(product.id);
            
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-600');
            deleteButton.onclick = () => deleteProduct(product.id);
            
            actionsCell.appendChild(editButton);
            actionsCell.appendChild(deleteButton);
        });
    }

    // Add new product
    document.getElementById('add-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const newProduct = {
            id: Date.now(), // Unique ID based on timestamp
            name: document.getElementById('add-product-name').value,
            category: document.getElementById('add-product-category').value,
            price: document.getElementById('add-product-price').value,
            stock: document.getElementById('add-product-stock').value
        };

        // Get existing products from localStorage
        let products = JSON.parse(localStorage.getItem('products')) || [];
        products.push(newProduct);
        
        // Save the updated products array
        localStorage.setItem('products', JSON.stringify(products));

        // Clear form and reload products
        document.getElementById('add-product-form').reset();
        loadProducts();
    });

    // Populate the Edit form with data
    function populateEditForm(productId) {
        const products = JSON.parse(localStorage.getItem('products')) || [];
        const productToEdit = products.find(product => product.id === productId);

        if (productToEdit) {
            document.getElementById('edit-product-id').value = productToEdit.id;
            document.getElementById('edit-product-name').value = productToEdit.name;
            document.getElementById('edit-product-category').value = productToEdit.category;
            document.getElementById('edit-product-price').value = productToEdit.price;
            document.getElementById('edit-product-stock').value = productToEdit.stock;
        }
    }

    // Edit product
    document.getElementById('edit-product-form').addEventListener('submit', function (event) {
        event.preventDefault();
        
        const productId = parseInt(document.getElementById('edit-product-id').value);
        const updatedName = document.getElementById('edit-product-name').value;
        const updatedCategory = document.getElementById('edit-product-category').value;
        const updatedPrice = document.getElementById('edit-product-price').value;
        const updatedStock = document.getElementById('edit-product-stock').value;
        
        const products = JSON.parse(localStorage.getItem('products')) || [];
        const productIndex = products.findIndex(product => product.id === productId);
        
        if (productIndex !== -1) {
            products[productIndex] = { id: productId, name: updatedName, category: updatedCategory, price: updatedPrice, stock: updatedStock };
            localStorage.setItem('products', JSON.stringify(products));
            loadProducts(); // Reload product data to reflect changes
        }
    });

    // Delete product
    function deleteProduct(productId) {
        const confirmDelete = confirm("Are you sure you want to delete this product?");
        
        if (confirmDelete) {
            const products = JSON.parse(localStorage.getItem('products')) || [];
            const updatedProducts = products.filter(product => product.id !== productId);
            
            localStorage.setItem('products', JSON.stringify(updatedProducts));
            loadProducts(); // Reload the product list after deletion
        }
    }
</script>
</html>
