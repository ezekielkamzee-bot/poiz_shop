<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit;
}
if (empty($_SESSION['cart'])) {
  header("Location: cart.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout | MyShop</title>
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<header>
  <div class="container">
    <h1>MyShop</h1>
  </div>
</header>

<section class="checkout-section">
  <h2>Checkout</h2>
  <form action="php/place_order.php" method="POST" class="checkout-form">
    <label>Full Name:</label>
    <input type="text" name="name" required>

    <label>Address:</label>
    <textarea name="address" required></textarea>

    <label>Payment Method:</label>
    <select name="payment" required>
      <option value="Cash on Delivery">Cash on Delivery</option>
      <option value="M-Pesa">M-Pesa</option>
    </select>

    <button type="submit" class="btn-checkout">Place Order</button>
  </form>
</section>
</body>
</html>
