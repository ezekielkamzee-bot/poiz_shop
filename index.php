<?php
session_start();
include 'php/db_connect.php';
$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>POIZ'S Shop | Home</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* --- Base Page Styles --- */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f8f9fa;
      padding-bottom: 80px; /* Prevent content overlap with fixed footer */
    }

    header {
      background-color: #56df11fb;
      color: #fff;
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    header .container {
      width: 90%;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    header h1 {
      margin: 0;
    }

    nav a {
      color: #e8690ff0;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
    }

    nav a:hover {
      text-decoration: underline;
    }

    /* --- Product Section --- */
    .products {
      width: 90%;
      margin: 30px auto 100px;
      text-align: center;
    }

    .products h2 {
      margin-bottom: 20px;
      font-size: 1.8em;
    }

    /* --- Horizontal Scroll Layout --- */
    .product-grid {
      display: flex;
      overflow-x: auto;
      gap: 20px;
      padding-bottom: 10px;
      scroll-behavior: smooth;
    }

    .product-grid::-webkit-scrollbar {
      height: 8px;
    }

    .product-grid::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 4px;
    }

    /* --- Product Cards --- */
    .product-card {
      flex: 0 0 250px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 15px;
      transition: transform 0.2s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }

    .product-card h3 {
      margin: 10px 0 5px;
      font-size: 18px;
    }

    .product-card p {
      margin: 5px 0;
      font-size: 16px;
      color: #555;
    }

    .product-card form {
      margin-top: 10px;
    }

    .product-card button {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .product-card button:hover {
      background-color: #12adccff;
    }

    /* --- Fixed Footer --- */
    footer {
      background-color: #12a3bdff;
      color: #fff;
      padding: 15px 0;
      text-align: center;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 999;
      box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
    }

    footer .social-links a {
      color: #4e62dfff;
      margin: 0 10px;
      font-size: 18px;
      text-decoration: none;
    }

    footer .social-links a:hover {
      color: #ff009de7;
    }

    footer p {
      margin-top: 10px;
      font-size: 14px;
      color: #ccc;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
      .product-card {
        flex: 0 0 200px;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="container">
    <h1>POIZ'S Shop</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="php/logout.php">Logout</a>
      <?php else: ?>
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
      <?php endif; ?>
      <a href="admin/admin_login.php" target="_blank">Admin</a>
    </nav>
  </div>
</header>

<section class="products">
  <h2>Available Products</h2>
  <div class="product-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="product-card">
        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>KSh <?php echo number_format($row['price'], 2); ?></p>
        <form action="cart.php" method="POST">
          <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
          <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
          <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<footer>
  <div class="social-links">
    <a href="#">Facebook</a> |
    <a href="#">Instagram</a> |
    <a href="#">Twitter</a>
  </div>
  <p>© <?php echo date("Y"); ?> POIZ'S Shop. All Rights Reserved.</p>
</footer>

</body>
</html>
