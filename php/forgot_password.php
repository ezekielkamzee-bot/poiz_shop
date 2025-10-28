<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store token in database (you can create a column for it)
        $conn->query("UPDATE users SET reset_token = '$token' WHERE email = '$email'");

        // Create reset link
        $resetLink = "http://localhost/ecommerce_project/php/reset_password.php?token=$token";

        // For now, just display it (you can replace this with an email sender)
        $message = "✅ Password reset link: <a href='$resetLink'>$resetLink</a>";
    } else {
        $error = "❌ No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Forgot Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
    <form method="POST">
      <label>Enter your registered email:</label>
      <input type="email" name="email" placeholder="you@example.com" required>
      <button type="submit">Send Reset Link</button>
    </form>
    <p><a href="../login.html">Back to Login</a></p>
  </div>
</body>
</html>
