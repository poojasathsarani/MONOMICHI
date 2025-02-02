<?php
include 'db_connection.php';

$postId = $_GET['id'];

$sql = "SELECT p.id, u.fullname, p.title, p.content, p.image_url, p.created_at FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = $postId";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $post = $result->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode($post);
} else {
    echo json_encode(['error' => 'Post not found']);
}

$conn->close();
?>