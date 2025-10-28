<?php
session_start();
include '../php/db_connect.php';
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

$id = $_GET['id'];
$status = $_GET['status'];

$stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: orders.php");
exit;
?>
