<?php
session_start();
require "../config/db.php";

$cart = $_SESSION['cart'] ?? [];

$grandTotal = 0;
foreach($cart as $item){
    $grandTotal += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Cart Summary</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
.cart-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
.cart-table th, .cart-table td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
.cart-table th { background-color: #ff9800; color: #fff; }
.total-row { font-weight: bold; background-color: #f0f0f0; }
.order-btn { margin-top: 20px; padding: 12px 25px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
.order-btn:hover { background: #218838; }
</style>
</head>
<body>

<h2>Cart Summary</h2>

<?php if(empty($cart)): ?>
<p>Your cart is empty!</p>
<a href="index.php">Back to Menu</a>
<?php else: ?>
<table class="cart-table">
<tr>
<th>Dish Name</th>
<th>Price (Rs.)</th>
<th>Quantity</th>
<th>Subtotal (Rs.)</th>
</tr>

<?php foreach($cart as $dishId => $item): 
    $subtotal = $item['price'] * $item['quantity'];
?>
<tr>
<td><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></td>
<td><?= number_format($item['price'], 2) ?></td>
<td><?= $item['quantity'] ?></td>
<td><?= number_format($subtotal, 2) ?></td>
</tr>
<?php endforeach; ?>

<tr class="total-row">
<td colspan="3">Grand Total</td>
<td><?= number_format($grandTotal, 2) ?></td>
</tr>
</table>

<form action="place_order.php" method="POST">
<button class="order-btn">Place Order</button>
</form>
<?php endif; ?>

</body>
</html>
