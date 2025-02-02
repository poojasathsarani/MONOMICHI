<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$userId = $_SESSION['id'];
$postId = $_POST['post_id'];

// Check if user already liked the post
$checkLike = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
$checkLike->bind_param("ii", $userId, $postId);
$checkLike->execute();
$result = $checkLike->get_result();

if ($result->num_rows == 0) {
    // Add a like
    $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();
    echo json_encode(["success" => true]);
} else {
    // Remove like
    $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();
    echo json_encode(["success" => false]);
}
?>
