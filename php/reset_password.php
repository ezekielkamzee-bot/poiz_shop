<?php
include 'db_connect.php';
session_start();

// Step 1: Check token in URL
if (!isset($_GET['token'])) {
    die("Invalid or missing token.");
}

$token = $_GET['token'];

// Step 2: Check if token is valid
$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Invalid or expired reset link.");
}

$user = $result->fetch_assoc();

// Step 3: Handle password reset
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET password='$newPassword', reset_token=NULL WHERE reset_token='$token'");
    echo "<p style='color:green;'>✅ Password updated successfully. <a href='../login.html'>Login</a></p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Reset Your Password</h2>
    <form method="POST">
      <label>Enter New Password:</label>
      <input type="password" name="password" required>
      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>
