<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
    header("Location: ../cart.php");
    exit;
}

$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$payment = $_POST['payment'] ?? '';

if ($name && $address && $payment) {
    // Find the user ID (from session)
    $user_id = $_SESSION['user']['id'];

    // Calculate total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert into orders table
    $orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Pending')");
    $orderStmt->bind_param("id", $user_id, $total);
    $orderStmt->execute();
    $order_id = $orderStmt->insert_id;

    // Insert order items
    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $item) {
        $itemStmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $itemStmt->execute();
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo "<script>alert('Order placed successfully!'); window.location.href='../index.php';</script>";
} else {
    echo "<script>alert('Please fill all fields!'); window.history.back();</script>";
}
?>
