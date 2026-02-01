<?php
session_start();
require "../config/db.php";
include "../includes/header.php";

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$cartCount = 0;
foreach($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
}

$stmt = $conn->prepare("SELECT id, dishname, price, status FROM menu WHERE status = 'available'");
$stmt->execute();
$menuItems = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title> 
    <!--linking google font-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <!--linking google font-->
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<h2 class="resturant_menu">Restaurant Menu</h2>
<div class="cart_container">
  <span class="cart_icon">
    <span class="material-symbols-outlined">shopping_cart</span>
    <span id="cartCount"><?= $cartCount ?></span>
  </span>
  <!--<span class="cart-text">Cart</span>-->
</div>

<div class="reviews-container">

   <?php 
    foreach ($menuItems as $item) {
    echo '<div class="menu-card">';
    echo '<h3>' . htmlspecialchars($item['dishname'], ENT_QUOTES) . '</h3>';
    echo '<p><strong>Price:</strong> Rs. ' . number_format($item['price'], 2) . '</p>';
    echo '<p><strong>Status:</strong> ' . htmlspecialchars($item['status'], ENT_QUOTES) . '</p>';
    echo '<label>Quantity:</label>';
    echo '<input type="number" name="qty" min="1" value="1" class="quantity-input" id="qty_' . $item['id'] . '">';

    echo '<button type="button" class="order-btn" onclick="addToCart(' . $item['id'] . ')">Add</button>';

    echo '</div>';
    }
    ?>
</div>
<div style="text-align:center; margin:20px;">
  <form action="checkout.php" method="POST">
    <button class="order-btn">Place Order</button>
  </form>
</div>
<script src="../assets/js/cart.js"></script>
</body>
</html>
<?php
include "../includes/footer.php";
?>