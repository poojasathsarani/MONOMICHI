<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$userId = $_SESSION['id'];
$postId = $_POST['post_id'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (user_id, post_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userId, $postId, $comment);
$stmt->execute();

if ($stmt) {
    echo json_encode(["success" => true, "comment" => htmlspecialchars($comment)]);
} else {
    echo json_encode(["error" => "Failed to add comment"]);
}
?>
