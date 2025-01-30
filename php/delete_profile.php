<?php
session_start();
include 'database.php';  // Database connection

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Profile deleted successfully!'); window.location.href='../login.html';</script>";
} else {
    echo "<script>alert('Error deleting profile: " . $conn->error . "');</script>";
}

$stmt->close();
$conn->close();
?>
