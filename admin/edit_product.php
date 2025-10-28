<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$id = $_GET['id'] ?? null;
if (!$id) header("Location: products.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];

  if (!empty($_FILES["image"]["name"])) {
    $targetDir = "../uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    $imagePath = "uploads/" . $imageName;
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image_url=? WHERE id=?");
    $stmt->bind_param("sdsi", $name, $price, $imagePath, $id);
  } else {
    $stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $name, $price, $id);
  }

  $stmt->execute();
  header("Location: products.php");
  exit;
}

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
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
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data" class="product-form">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

      <label>Price (KSh):</label>
      <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

      <label>Current Image:</label><br>
      <img src="../<?php echo $product['image_url']; ?>" width="100"><br><br>

      <label>Change Image:</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" class="btn-save">Update Product</button>
    </form>
  </div>
</body>
</html>
