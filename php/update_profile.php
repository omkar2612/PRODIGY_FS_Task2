<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in first!'); window.location.href='../login.html';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Prepare the UPDATE query
    $stmt = $conn->prepare("UPDATE employees SET email = ?, address = ? WHERE id = ?");
    
    // Check if the statement is prepared successfully
    if ($stmt === false) {
        die('Statement prepare failed: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param('ssi', $email, $address, $user_id);  // Adjusted to match placeholders
    
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
