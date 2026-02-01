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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .menu-container {
            padding: 20px;
        }

        .menu-card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            text-align: center;
            vertical-align: top;
        }

        .menu-card h3 {
            margin: 10px 0;
        }

        .price {
            font-weight: bold;
            color: green;
        }

        .order-btn {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            background: #ff9800;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .order-btn:hover {
            background: #e68900;
        }
        .cart-container {
  display: flex;
  align-items: center;
  gap: 8px; /* space between icon and text */
  font-family: Arial, sans-serif;
  font-size: 16px;
}

.cart-icon {
  position: relative;
  width: 30px;  /* size of the circle */
  height: 30px;
}

.cart-icon img {
  width: 100%;
  height: 100%;
  border-radius: 50%; /* makes image circular */
  object-fit: cover;
}
#cartCount {
  position: absolute;
  top: -6px;
  right: -6px;
  background-color: red;
  color: white;
  font-size: 12px;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-weight: bold;
}
    </style>
</head>

<body>

<h2 style="text-align:center;">Restaurant Menu</h2>
<div class="cart-container">
  <span class="cart-icon">
    <img src="assets/cart.png" alt="Cart">
    <span id="cartCount"><?= $cartCount ?></span>
  </span>
  <span class="cart-text">Cart</span>
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