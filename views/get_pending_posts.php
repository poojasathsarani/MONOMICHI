<?php
include 'db_connection.php'; // Your database connection

$sql = "SELECT p.id, u.fullname, p.title FROM posts p JOIN users u ON p.user_id = u.id WHERE p.status = 'Pending'";
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($posts);

$conn->close();
?>