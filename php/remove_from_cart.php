<?php
session_start();

$id = $_GET['id'] ?? null;

if ($id && isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $id) {
      unset($_SESSION['cart'][$key]);
      break;
    }
  }
  $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: ../cart.php");
exit;
?>
