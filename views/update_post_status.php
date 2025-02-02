<?php
include 'db_connection.php';

$postId = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE posts SET status = '$status' WHERE id = $postId";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}