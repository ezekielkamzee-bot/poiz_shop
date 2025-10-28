<?php
session_start();

if (isset($_POST['add_to_cart'])) {
  $item = [
    'id' => $_POST['product_id'],
    'name' => $_POST['product_name'],
    'price' => $_POST['price'],
    'quantity' => 1
  ];

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  $found = false;
  foreach ($_SESSION['cart'] as &$cartItem) {
    if ($cartItem['id'] == $item['id']) {
      $cartItem['quantity']++;
      $found = true;
      break;
    }
  }
  if (!$found) {
    $_SESSION['cart'][] = $item;
  }
}

if (isset($_GET['remove'])) {
  foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $_GET['remove']) {
      unset($_SESSION['cart'][$key]);
      break;
    }
  }
  $_SESSION['cart'] = array_values($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart | MyShop</title>
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<header>
  <div class="container">
    <h1>MyShop</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="cart.php">Cart</a>
      <?php if (isset($_SESSION['username'])): ?>
        <a href="php/logout.php">Logout</a>
      <?php else: ?>
        <a href="login.html">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<section class="cart-section">
  <h2>Your Shopping Cart</h2>
  <?php if (!empty($_SESSION['cart'])): ?>
    <table>
      <tr>
        <th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th>
      </tr>
      <?php
      $grandTotal = 0;
      foreach ($_SESSION['cart'] as $item):
        $total = $item['price'] * $item['quantity'];
        $grandTotal += $total;
      ?>
      <tr>
        <td><?php echo htmlspecialchars($item['name']); ?></td>
        <td>KSh <?php echo number_format($item['price'], 2); ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>KSh <?php echo number_format($total, 2); ?></td>
        <td><a href="cart.php?remove=<?php echo $item['id']; ?>">Remove</a></td>
      </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="3"><strong>Grand Total:</strong></td>
        <td colspan="2"><strong>KSh <?php echo number_format($grandTotal, 2); ?></strong></td>
      </tr>
    </table>
    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
  <?php else: ?>
    <p>Your cart is empty.</p>
  <?php endif; ?>
</section>
</body>
</html>
