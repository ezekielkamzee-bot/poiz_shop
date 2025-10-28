<?php
include '../php/db_connect.php';

if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['image_url'])) {
    $name = $_GET['name'];
    $price = $_GET['price'];
    $image_url = $_GET['image_url'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $image_url);

    if ($stmt->execute()) {
        echo "✅ Product '$name' added successfully (KSh $price).";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
} else {
    echo "⚠️ Use URL format:<br>";
    echo "http://localhost/ecommerce_project/admin/add_product_url.php?name=TV&price=25000&image_url=uploads/tv.jpg";
}
?>
