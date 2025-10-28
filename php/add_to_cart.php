<?php
session_start();
include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
  $sql = "SELECT * FROM products WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  if ($product) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
      if ($item['id'] == $product['id']) {
        $item['quantity']++;
        $found = true;
        break;
      }
    }

    if (!$found) {
      $product['quantity'] = 1;
      $_SESSION['cart'][] = $product;
    }
  }
}

echo count($_SESSION['cart']);
?>
