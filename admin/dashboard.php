<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$revenue = $conn->query("SELECT SUM(total_price) AS total FROM orders")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | MyShop</title>
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="sidebar">
  <h2>MyShop Admin</h2>
  <ul>
    <li><a href="dashboard.php" class="active">Dashboard</a></li>
    <li><a href="users.php">Users</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="orders.php">Orders</a></li>
    <li><a href="sales_report.php">Sales Report</a></li>
    <li><a href="admin_logout.php">Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <h2>Welcome, Admin 👋</h2>
  <div class="stats">
    <div class="card"><h3><?php echo $users; ?></h3><p>Users</p></div>
    <div class="card"><h3><?php echo $products; ?></h3><p>Products</p></div>
    <div class="card"><h3><?php echo $orders; ?></h3><p>Orders</p></div>
    <div class="card"><h3>KSh <?php echo number_format($revenue, 2); ?></h3><p>Total Revenue</p></div>
  </div>
</div>
</body>
</html>
