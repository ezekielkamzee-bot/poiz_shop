<?php
include 'db_connect.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "
    <div class='product-card'>
      <img src='{$row['image_url']}' alt='{$row['name']}' />
      <h3>{$row['name']}</h3>
      <p>KSh {$row['price']}</p>
      <button class='add-to-cart' data-id='{$row['id']}'>Add to Cart</button>
    </div>
    ";
  }
} else {
  echo "<p>No products found.</p>";
}
?>
