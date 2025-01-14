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
        <div class="w-64 bg-gradient-to-b from-teal-600 to-teal-800 text-white p-6 flex flex-col space-y-8">
            <div class="text-3xl font-extrabold mb-8 text-white">Admin Dashboard</div>
            <ul class="space-y-6">
            <li><a href="#user-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Manage Users</a></li>
                <li><a href="#blog-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Blog Management</a></li>
                <li><a href="#order-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Order Management</a></li>
                <li><a href="#product-management" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Product Inventory</a></li>
                <li><a href="#holiday-drops" class="text-lg font-semibold hover:text-cyan-300 transition duration-300">Holiday Drops</a></li>
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
            <div id="user-management" class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h3 id="user-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">User Management</h3>
                <p>Manage users, add/edit/delete user accounts, and configure user privileges.</p>
                
                <!-- User Options Section -->
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
                                <!-- Dynamic user rows will be added here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Add New User -->
                    <div id="add-user" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Add New User</h4>
                        <form id="add-user-form" class="space-y-4">
                            <div>
                                <label for="add-name" class="block text-gray-700">Name:</label>
                                <input type="text" id="add-name" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter name" required>
                            </div>
                            <div>
                                <label for="add-email" class="block text-gray-700">Email:</label>
                                <input type="email" id="add-email" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter email" required>
                            </div>
                            <div>
                                <label for="add-role" class="block text-gray-700">Role:</label>
                                <select id="add-role" class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Add User</button>
                        </form>
                    </div>

                    <!-- Edit User -->
                    <div id="edit-user" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Edit User</h4>
                        <form id="edit-user-form" class="space-y-4">
                            <div>
                                <label for="edit-user-id" class="block text-gray-700">User ID:</label>
                                <input type="text" id="edit-user-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter User ID" required>
                            </div>
                            <div>
                                <label for="edit-name" class="block text-gray-700">Name:</label>
                                <input type="text" id="edit-name" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter name" required>
                            </div>
                            <div>
                                <label for="edit-email" class="block text-gray-700">Email:</label>
                                <input type="email" id="edit-email" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter email" required>
                            </div>
                            <div>
                                <label for="edit-role" class="block text-gray-700">Role:</label>
                                <select id="edit-role" class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update User</button>
                        </form>
                    </div>

                    <!-- Delete User -->
                    <div id="delete-user" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Delete User</h4>
                        <form id="delete-user-form" class="space-y-4">
                            <div>
                                <label for="delete-user-id" class="block text-gray-700">User ID:</label>
                                <input type="text" id="delete-user-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter User ID" required>
                            </div>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete User</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Blog Management -->
            <div id="blog-management" class="bg-white p-6 rounded-lg shadow-lg mb-8">
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

            <!-- Order Management -->
            <div id="order-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 id="order-management-heading" class="text-xl font-semibold text-gray-800 mb-4 cursor-pointer">Order Management</h3>
                <p>View and manage orders, update their status, and handle customer queries.</p>

                <!-- Order Options Section (Initially hidden) -->
                <div id="order-options" class="hidden mt-4">
                    <!-- View Orders -->
                    <div id="view-orders" class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">View Orders</h4>
                        <table id="orders-table" class="w-full table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Order ID</th>
                                    <th class="border px-4 py-2">Customer Name</th>
                                    <th class="border px-4 py-2">Order Date</th>
                                    <th class="border px-4 py-2">Status</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Order rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Update Order Status -->
                    <div id="update-order-status" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Update Order Status</h4>
                        <form id="update-order-status-form" class="space-y-4">
                            <div>
                                <label for="update-order-id" class="block text-gray-700">Order ID:</label>
                                <input type="text" id="update-order-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Order ID" required>
                            </div>
                            <div>
                                <label for="update-order-status" class="block text-gray-700">Status:</label>
                                <select id="update-order-status" class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update Status</button>
                        </form>
                    </div>

                    <!-- Handle Customer Queries -->
                    <div id="handle-queries" class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Handle Customer Queries</h4>
                        <form id="customer-query-form" class="space-y-4">
                            <div>
                                <label for="query-order-id" class="block text-gray-700">Order ID:</label>
                                <input type="text" id="query-order-id" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Order ID" required>
                            </div>
                            <div>
                                <label for="query-response" class="block text-gray-700">Response:</label>
                                <textarea id="query-response" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter your response" required></textarea>
                            </div>
                            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Submit Response</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Inventory -->
            <div id="product-management" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Product Inventory</h3>
                <p>Add, edit, or delete products in the inventory.</p>
            </div>

            <!-- Holiday Drops -->
            <div id="holiday-drops" class="bg-white p-6 rounded-lg shadow-lg mb-8 hover:shadow-2xl transition duration-300">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Limited-Time Holiday Drops</h3>
                <p>Manage special product drops for Japanese holidays and events.</p>
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
    // Function to load users from localStorage
    function loadUsers() {
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const table = document.getElementById('user-table');
        table.innerHTML = ''; // Clear the existing table content before adding new rows
        users.forEach(user => {
            const row = table.insertRow();
            row.insertCell(0).textContent = user.id;
            row.insertCell(1).textContent = user.name;
            row.insertCell(2).textContent = user.email;
            row.insertCell(3).textContent = user.role;
            row.insertCell(4).innerHTML = `
                <button class="edit-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</button>
                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
            `;
        });
        addEventListenersToNewButtons();
    }

    // Load users on page load
    window.onload = loadUsers;

    // Function to add a new user
    document.getElementById('add-user-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form from submitting normally
        
        // Get the form data
        const name = document.getElementById('add-name').value;
        const email = document.getElementById('add-email').value;
        const role = document.getElementById('add-role').value;

        // Create new user object
        const newUser = {
            id: Date.now(), // Use timestamp as a unique ID
            name: name,
            email: email,
            role: role
        };

        // Retrieve existing users from localStorage
        const users = JSON.parse(localStorage.getItem('users')) || [];
        users.push(newUser);

        // Save the updated users list back to localStorage
        localStorage.setItem('users', JSON.stringify(users));

        // Add the new user to the table dynamically
        const table = document.getElementById('user-table');
        const row = table.insertRow();
        row.insertCell(0).textContent = newUser.id;
        row.insertCell(1).textContent = newUser.name;
        row.insertCell(2).textContent = newUser.email;
        row.insertCell(3).textContent = newUser.role;
        row.insertCell(4).innerHTML = `
            <button class="edit-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</button>
            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
        `;

        // Reset the form
        document.getElementById('add-name').value = '';
        document.getElementById('add-email').value = '';
        document.getElementById('add-role').value = 'User'; // Reset role to 'User'

        // Reattach event listeners to the new buttons
        addEventListenersToNewButtons();
    });

    // toggle the user management section
    document.getElementById('user-management-heading').addEventListener('click', function () {
        const userOptions = document.getElementById('user-options');
        userOptions.classList.toggle('hidden');
    });

    // Function to edit user
    document.getElementById('edit-user-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form from submitting normally

        const userId = document.getElementById('edit-user-id').value;
        const updatedName = document.getElementById('edit-name').value;
        const updatedEmail = document.getElementById('edit-email').value;
        const updatedRole = document.getElementById('edit-role').value;

        // Retrieve existing users from localStorage
        let users = JSON.parse(localStorage.getItem('users')) || [];
        
        // Find the user by ID and update their data
        users = users.map(user => {
            if (user.id == userId) {
                user.name = updatedName;
                user.email = updatedEmail;
                user.role = updatedRole;
            }
            return user;
        });

        // Save the updated users list back to localStorage
        localStorage.setItem('users', JSON.stringify(users));

        // Reload the users table to reflect the changes
        loadUsers();

        // Reset the form
        document.getElementById('edit-user-form').reset();
    });

    // Function to add event listeners for Edit and Delete buttons
    function addEventListenersToNewButtons() {
        // Edit button functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const row = button.closest('tr');
                const userId = row.cells[0].textContent;
                const name = row.cells[1].textContent;
                const email = row.cells[2].textContent;
                const role = row.cells[3].textContent;

                document.getElementById('edit-user-id').value = userId;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-email').value = email;
                document.getElementById('edit-role').value = role;

                document.getElementById('edit-user').scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Delete button functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const confirmDelete = confirm("Are you sure you want to delete this user?");
                if (confirmDelete) {
                    const row = button.closest('tr');
                    const userId = row.cells[0].textContent;

                    // Retrieve existing users from localStorage
                    let users = JSON.parse(localStorage.getItem('users')) || [];

                    // Remove the user by filtering out the selected user
                    users = users.filter(user => user.id != userId);

                    // Save the updated users list back to localStorage
                    localStorage.setItem('users', JSON.stringify(users));

                    // Reload the users table to reflect the changes
                    loadUsers();
                }
            });
        });
    }

    // Function to delete user by ID
    document.getElementById('delete-user-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form from submitting normally

        const userIdToDelete = document.getElementById('delete-user-id').value;

        // Retrieve existing users from localStorage
        let users = JSON.parse(localStorage.getItem('users')) || [];

        // Filter out the user with the matching ID
        users = users.filter(user => user.id != userIdToDelete);

        // Save the updated users list back to localStorage
        localStorage.setItem('users', JSON.stringify(users));

        // Reload the users table to reflect the changes
        loadUsers();

        // Reset the form
        document.getElementById('delete-user-id').value = '';
    });

    // Function to add event listeners for Edit and Delete buttons
    function addEventListenersToNewButtons() {
        // Delete button functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                // Show confirmation dialog
                const confirmDelete = confirm("Are you sure you want to delete this user?");
                
                if (confirmDelete) {
                    // Get the row of the clicked delete button
                    const row = button.closest('tr');
                    const userId = row.cells[0].textContent;

                    // Retrieve existing users from localStorage
                    let users = JSON.parse(localStorage.getItem('users')) || [];

                    // Remove the user by filtering out the selected user
                    users = users.filter(user => user.id != userId);

                    // Save the updated users list back to localStorage
                    localStorage.setItem('users', JSON.stringify(users));

                    // Reload the users table to reflect the changes
                    loadUsers();
                }
            });
        });
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




    //Order Management
    // JavaScript to toggle the visibility of the Order Options Section when clicking the Order Management heading
    document.getElementById('order-management-heading').addEventListener('click', function() {
        var orderOptions = document.getElementById('order-options');
        
        // Toggle visibility
        if (orderOptions.classList.contains('hidden')) {
            orderOptions.classList.remove('hidden');
        } else {
            orderOptions.classList.add('hidden');
        }
    });

</script>
</html>
