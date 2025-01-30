<?php
session_start();
include 'database.php';  // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM employees WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: profile.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='../login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='../login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
