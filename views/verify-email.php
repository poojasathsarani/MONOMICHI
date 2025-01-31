<?php
// Include database connection
include('db_connection.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $email = $user['email'];

        // Redirect to reset password form
        header("Location: reset-password.php?email=$email");
        exit();
    } else {
        echo "The token is invalid or has expired.";
    }
}
?>
