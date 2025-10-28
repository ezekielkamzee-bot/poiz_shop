<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}
$users = $conn->query("SELECT id, username, email, created_at FROM users");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Users | MyShop</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="sidebar">
  <h2>MyShop Admin</h2>
  <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="users.php" class="active">Users</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="orders.php">Orders</a></li>
    <li><a href="sales_report.php">Sales Report</a></li>
    <li><a href="admin_logout.php">Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <h2>All Registered Users</h2>
  <table>
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Created</th></tr>
    <?php while ($row = $users->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>
