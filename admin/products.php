<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Products Management</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="sidebar">
    <h2>MyShop Admin</h2>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="products.php" class="active">Products</a></li>
      <li><a href="orders.php">Orders</a></li>
      <li><a href="sales_report.php">Sales Report</a></li>
      <li><a href="admin_logout.php">Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h2>Manage Products</h2>
    <a href="add_product.php" class="btn-add">➕ Add New Product</a>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price (KSh)</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
      <?php
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td><img src='../{$row['image_url']}' width='50'></td>
                <td>
                  <a href='edit_product.php?id={$row['id']}' class='btn-edit'>Edit</a>
                  <a href='delete_product.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                </td>
              </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
