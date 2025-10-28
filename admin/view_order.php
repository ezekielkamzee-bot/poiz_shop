<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$id = $_GET['id'];
$order = $conn->query("
  SELECT o.*, u.username, u.email 
  FROM orders o 
  JOIN users u ON o.user_id = u.id 
  WHERE o.id = $id
")->fetch_assoc();

$items = $conn->query("
  SELECT p.name, oi.quantity, oi.price 
  FROM order_items oi 
  JOIN products p ON oi.product_id = p.id 
  WHERE oi.order_id = $id
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order #<?php echo $id; ?></title>
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
    <h2>Order Details #<?php echo $id; ?></h2>
    <p><strong>User:</strong> <?php echo $order['username']; ?> (<?php echo $order['email']; ?>)</p>
    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
    <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>

    <h3>Items:</h3>
    <table>
      <tr><th>Product</th><th>Quantity</th><th>Price (KSh)</th></tr>
      <?php
      $total = 0;
      while ($row = $items->fetch_assoc()) {
        $subtotal = $row['quantity'] * $row['price'];
        $total += $subtotal;
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$subtotal}</td>
              </tr>";
      }
      ?>
      <tr><td colspan="2"><strong>Total:</strong></td><td><strong><?php echo $total; ?></strong></td></tr>
    </table>

    <br>
    <a href="update_status.php?id=<?php echo $id; ?>&status=Completed" class="btn-save">Mark as Completed</a>
  </div>
</body>
</html>
