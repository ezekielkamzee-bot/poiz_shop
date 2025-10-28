<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Orders</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="sidebar">
    <h2>MyShop Admin</h2>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="orders.php" class="active">Orders</a></li>
      <li><a href="sales_report.php">Sales Report</a></li>
      <li><a href="admin_logout.php">Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h2>Orders Management</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Total (KSh)</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
      <?php
      $result = $conn->query("
        SELECT o.id, u.username, o.total_price, o.status, o.created_at
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.id DESC
      ");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['total_price']}</td>
                <td>{$row['status']}</td>
                <td>{$row['created_at']}</td>
                <td>
                  <a href='view_order.php?id={$row['id']}' class='btn-edit'>View</a>
                  <a href='update_status.php?id={$row['id']}&status=Completed' class='btn-save'>Mark Complete</a>
                </td>
              </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
