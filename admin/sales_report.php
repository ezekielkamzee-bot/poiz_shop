<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

// === Total Sales Summary ===
$totalSales = $conn->query("SELECT SUM(total_price) AS total FROM orders WHERE status='Completed'")->fetch_assoc()['total'] ?? 0;

// === Top Selling Products ===
$topProductsQuery = $conn->query("
  SELECT p.name, SUM(oi.quantity) AS qty, SUM(oi.quantity * oi.price) AS revenue
  FROM order_items oi
  JOIN products p ON oi.product_id = p.id
  GROUP BY oi.product_id
  ORDER BY qty DESC
  LIMIT 10
");

$productNames = [];
$productRevenue = [];
$topProducts = [];
while ($row = $topProductsQuery->fetch_assoc()) {
  $productNames[] = $row['name'];
  $productRevenue[] = $row['revenue'];
  $topProducts[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sales Report | MyShop</title>
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="sidebar">
  <h2>MyShop Admin</h2>
  <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="users.php">Users</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="orders.php">Orders</a></li>
    <li><a href="sales_report.php" class="active">Sales Report</a></li>
    <li><a href="admin_logout.php">Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <h2>📈 Sales Summary Report</h2>
  <div class="card">
    <h3>Total Revenue: <span style="color:green;">KSh <?php echo number_format($totalSales, 2); ?></span></h3>
  </div>

  <div class="export-buttons">
    <a href="export_sales_report.php?type=excel" class="btn">⬇ Export Excel</a>
    <a href="export_sales_report.php?type=pdf" class="btn">🧾 Export PDF</a>
  </div>

  <canvas id="salesChart" height="100"></canvas>

  <h3>Top-Selling Products</h3>
  <table>
    <tr><th>Product</th><th>Quantity Sold</th><th>Revenue (KSh)</th></tr>
    <?php foreach ($topProducts as $row): ?>
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['qty']; ?></td>
        <td><?php echo number_format($row['revenue'], 2); ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<script>
const labels = <?php echo json_encode($productNames); ?>;
const data = <?php echo json_encode($productRevenue); ?>;

new Chart(document.getElementById('salesChart'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: 'Revenue by Product (KSh)',
      data: data,
      backgroundColor: 'rgba(0,123,255,0.7)'
    }]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } }
  }
});
</script>
</body>
</html>
