<?php
// Include necessary files
require_once(__DIR__ . '/../tcpdf/tcpdf.php');

// Database Connection
include('db_connection.php');

// Database Class to handle database operations
class Database {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Fetch Users from the database
    public function getUsers() {
        $query = "SELECT fullname, email FROM users";
        return $this->fetchResults($query);
    }

    // Fetch Orders from the database
    public function getOrders() {
        $query = "SELECT id, full_name, address FROM orders";
        return $this->fetchResults($query);
    }

    // Fetch Products from the database
    public function getProducts() {
        $query = "SELECT productname, price, stock FROM Products";
        return $this->fetchResults($query);
    }

    // Fetch Customer Feedback
    public function getCustomerFeedback() {
        $query = "SELECT name, message FROM customers";
        return $this->fetchResults($query);
    }

    // Fetch Community Engagement Posts
    public function getCommunityEngagement() {
        $query = "SELECT users.fullname, posts.title, posts.status FROM posts JOIN users ON posts.user_id = users.id";
        return $this->fetchResults($query);
    }

    // Fetch Cultural Content Posts
    public function getCulturalContent() {
        $query = "SELECT title, created_by, created_at FROM cultural_guidance_posts";
        return $this->fetchResults($query);
    }

    // Helper function to fetch results
    private function fetchResults($query) {
        $result = mysqli_query($this->conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}

// PDFReport Class to generate PDF reports
class PDFReport extends TCPDF {
    public function outputReport() {
        $this->Output('report.pdf', 'D'); // Download the PDF file
    }

    public function addLogo() {
        // Add Logo (adjust position & size)
        $this->Image('../images/logoo.png', 10, 8, 33);

        // Move cursor down to prevent overlap
        $this->Ln(30); // Adjust space below the logo
    }

    public function addTitle($title) {
        // Set Title with MONOMICHI Name
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'MONOMICHI - ' . $title, 0, 1, 'C');
        $this->Ln(10); // Space below the title
    }

    public function generateTable($header, $data) {
        // Table Header
        $this->SetFont('helvetica', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(60, 10, $col, 1, 0, 'C'); // Adjust column width
        }
        $this->Ln();

        // Table Body
        $this->SetFont('helvetica', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(60, 10, $col, 1, 0, 'C'); // Adjust column width
            }
            $this->Ln();
        }
        $this->Ln(5); // Space after table
    }
}


// ReportGenerator Class to handle report generation
class generate_report {
    private $reports;
    private $db;

    public function __construct($reports) {
        $this->reports = $reports;
        $this->db = new Database();
    }

    public function generateReports() {
        // Create PDF object
        $pdf = new PDFReport();
        $pdf->AddPage();
        $pdf->addLogo(); // Add the logo
        $pdf->setTitle('Generated Reports');
    
        foreach ($this->reports as $report) {
            switch ($report) {
                case 'users':
                    $pdf->addTitle('Users Report');
                    $users = $this->db->getUsers();
                    $pdf->generateTable(['Full Name', 'Email'], $users);
                    break;
    
                case 'orders':
                    $pdf->addTitle('Orders Report');
                    $orders = $this->db->getOrders();
                    $pdf->generateTable(['Order ID', 'Name', 'Address'], $orders);
                    break;
    
                case 'products':
                    $pdf->addTitle('Products Report');
                    $products = $this->db->getProducts();
                    $pdf->generateTable(['Product Name', 'Price', 'Stock'], $products);
                    break;
    
                case 'customer_feedback':
                    $pdf->addTitle('Customer Feedback Report');
                    $feedback = $this->db->getCustomerFeedback();
                    $pdf->generateTable(['Customer', 'Message'], $feedback);
                    break;
    
                case 'community_engagement':
                    $pdf->addTitle('Community Engagement Report');
                    $engagement = $this->db->getCommunityEngagement();
                    $pdf->generateTable(['User', 'Title', 'Status'], $engagement);
                    break;
    
                case 'cultural_content':
                    $pdf->addTitle('Cultural Content Report');
                    $content = $this->db->getCulturalContent();
                    $pdf->generateTable(['Title', 'Created By', 'Date'], $content);
                    break;
            }
        }
    
        // Output PDF
        $pdf->outputReport();
    }    

    private function generateUserReport($pdf) {
        $users = $this->db->getUsers();
        $pdf->Cell(0, 10, 'Users Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(90, 10, 'Name', 1, 0, 'C');
        $pdf->Cell(90, 10, 'Email', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($users as $user) {
            $pdf->Cell(90, 10, $user['fullname'], 1);
            $pdf->Cell(90, 10, $user['email'], 1, 1);
        }
    }

    private function generateOrderReport($pdf) {
        $orders = $this->db->getOrders();
        $pdf->Cell(0, 10, 'Orders Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Order ID', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Name', 1, 0, 'C');
        $pdf->Cell(80, 10, 'Address', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($orders as $order) {
            $pdf->Cell(40, 10, $order['id'], 1);
            $pdf->Cell(70, 10, $order['full_name'], 1);
            $pdf->Cell(80, 10, $order['address'], 1, 1);
        }
    }

    private function generateProductReport($pdf) {
        $products = $this->db->getProducts();
        $pdf->Cell(0, 10, 'Products Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(70, 10, 'Product Name', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Price', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Stock', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($products as $product) {
            $pdf->Cell(70, 10, $product['productname'], 1);
            $pdf->Cell(60, 10, $product['price'], 1);
            $pdf->Cell(60, 10, $product['stock'], 1, 1);
        }
    }

    private function generateCustomerFeedbackReport($pdf) {
        $feedback = $this->db->getCustomerFeedback();
        $pdf->Cell(0, 10, 'Customer Feedback Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(90, 10, 'Customer Name', 1, 0, 'C');
        $pdf->Cell(90, 10, 'Message', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($feedback as $entry) {
            $pdf->Cell(90, 10, $entry['name'], 1);
            $pdf->Cell(90, 10, $entry['message'], 1, 1);
        }
    }

    private function generateCommunityEngagementReport($pdf) {
        $engagement = $this->db->getCommunityEngagement();
        $pdf->Cell(0, 10, 'Community Engagement Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(60, 10, 'User', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Post Title', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Status', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($engagement as $entry) {
            $pdf->Cell(60, 10, $entry['fullname'], 1);
            $pdf->Cell(60, 10, $entry['title'], 1);
            $pdf->Cell(60, 10, $entry['status'], 1, 1);
        }
    }

    private function generateCulturalContentReport($pdf) {
        $culturalContent = $this->db->getCulturalContent();
        $pdf->Cell(0, 10, 'Cultural Content Report', 0, 1);

        // Table Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(70, 10, 'Title', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Created By', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Created At', 1, 1, 'C');
        
        // Table Content
        $pdf->SetFont('helvetica', '', 10);
        foreach ($culturalContent as $content) {
            $pdf->Cell(70, 10, $content['title'], 1);
            $pdf->Cell(70, 10, $content['created_by'], 1);
            $pdf->Cell(50, 10, $content['created_at'], 1, 1);
        }
    }
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reports = isset($_POST['reports']) ? $_POST['reports'] : [];
    if (!empty($reports)) {
        $reportGenerator = new generate_report($reports);
        $reportGenerator->generateReports();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Reports to Generate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-100 to-[pink]-300 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 hover:scale-105">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
            📊 Select Reports to Generate
        </h2>
        <form action="" method="POST">
            <div class="space-y-4">
                <!-- Reports checkboxes -->
                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="users" id="users" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="users" class="text-lg text-gray-700 cursor-pointer font-medium">Users Report</label>
                </div>
                
                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="orders" id="orders" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="orders" class="text-lg text-gray-700 cursor-pointer font-medium">Orders Report</label>
                </div>

                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="products" id="products" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="products" class="text-lg text-gray-700 cursor-pointer font-medium">Products Report</label>
                </div>

                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="customer_feedback" id="customer_feedback" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="customer_feedback" class="text-lg text-gray-700 cursor-pointer font-medium">Customer Feedback</label>
                </div>

                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="community_engagement" id="community_engagement" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="community_engagement" class="text-lg text-gray-700 cursor-pointer font-medium">Community Engagement</label>
                </div>

                <div class="flex items-center space-x-3 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition">
                    <input type="checkbox" name="reports[]" value="cultural_content" id="cultural_content" class="form-checkbox h-6 w-6 text-blue-500 rounded-md transition-all">
                    <label for="cultural_content" class="text-lg text-gray-700 cursor-pointer font-medium">Cultural Content</label>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-700 transition-all transform hover:scale-105 flex items-center gap-2">
                    📝 Generate Reports
                </button>
            </div>
        </form>
    </div>
</body>
</html>
