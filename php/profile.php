<?php
session_start();
include 'database.php';  // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='../login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, address, profile_photo FROM employees WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $address, $profile_photo);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="sytles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <?php if ($profile_photo): ?>
            <img src="../uploads/<?php echo htmlspecialchars($profile_photo); ?>" alt="Profile Photo" style="max-width: 200px; border-radius: 10px;">
        <?php else: ?>
            <p>No profile photo uploaded.</p>
        <?php endif; ?>
        <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>

        <!-- Display email and address fields for editing -->
        <h3>Profile Details</h3>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>

        <!-- Update form -->
        <form action="update_profile.php" method="POST">
            <h3>Update Profile</h3>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

            <label for="password">New Password (optional):</label>
            <input type="password" id="password" name="password">

            <button type="submit">Update Profile</button>
        </form>

        <!-- Delete profile -->
        <form action="delete_profile.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile?');">
            <h3>Delete Profile</h3>
            <button type="submit" style="background-color: red; color: white;">Delete Profile</button>
        </form>

        <a href="/login.html" style="color: red;">Logout</a>
    </div>
</body>
</html>
