<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
  $conn->query("DELETE FROM products WHERE id=$id");
}
header("Location: products.php");
exit;
?>
