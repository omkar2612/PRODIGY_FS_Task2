<?php
include 'database.php';  // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $address = $_POST['address'];
    $profile_photo = null;

    // Handle file upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $upload_dir = '../uploads/';
        $file_name = uniqid() . "_" . basename($_FILES['profile_photo']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
            $profile_photo = $file_name;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO employees (username, password, email, address, profile_photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $email, $address, $profile_photo);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='../login.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
