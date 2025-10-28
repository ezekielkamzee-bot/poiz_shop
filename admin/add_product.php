<?php
session_start();
include '../php/db_connect.php';

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $image_url_input = trim($_POST['image_url']); // URL input from form

  $imagePath = "";

  // Case 1: User provided image URL
  if (!empty($image_url_input)) {
    // Validate if it's a valid URL
    if (filter_var($image_url_input, FILTER_VALIDATE_URL)) {
      $imagePath = $image_url_input;
    } else {
      $error = "Invalid image URL format!";
    }
  }
  // Case 2: User uploaded image file
  elseif (!empty($_FILES["image"]["name"])) {
    $targetDir = "../uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
      $imagePath = "uploads/" . $imageName;
    } else {
      $error = "Error uploading image file!";
    }
  } else {
    $error = "Please provide an image URL or upload a file.";
  }

  // Insert into database if everything is valid
  if (!isset($error) && !empty($imagePath)) {
    $stmt = $conn->prepare("INSERT INTO products (name, price, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $imagePath);
    $stmt->execute();
    header("Location: products.php?success=1");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product | Admin</title>
  <link rel="stylesheet" href="../css/admin.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
      min-height: 100vh;
      background-color: #f9f9f9;
    }

    .sidebar {
      background-color: #222;
      color: white;
      width: 220px;
      padding: 20px;
    }

    .sidebar h2 {
      margin-top: 0;
      text-align: center;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar li {
      margin: 15px 0;
    }

    .sidebar a {
      color: #bbb;
      text-decoration: none;
      display: block;
      padding: 8px;
      border-radius: 6px;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background-color: #007bff;
      color: #fff;
    }

    .main-content {
      flex: 1;
      padding: 40px;
    }

    .product-form {
      background: white;
      border-radius: 10px;
      padding: 25px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    .product-form label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    .product-form input[type="text"],
    .product-form input[type="number"],
    .product-form input[type="url"],
    .product-form input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 5px;
    }

    .btn-save {
      margin-top: 20px;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn-save:hover {
      background-color: #0056b3;
    }

    .error {
      color: red;
      background: #ffe0e0;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 10px;
    }

    h2 {
      margin-bottom: 10px;
    }

  </style>
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
    <h2>Add New Product</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="product-form">
      <label>Product Name:</label>
      <input type="text" name="name" required>

      <label>Price (KSh):</label>
      <input type="number" step="0.01" name="price" required>

      <label>Image URL (optional):</label>
      <input type="url" name="image_url" placeholder="https://example.com/image.jpg">

      <label>or Upload Image File:</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" class="btn-save">Save Product</button>
    </form>
  </div>
</body>
</html>
