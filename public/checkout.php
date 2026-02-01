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
<link rel="stylesheet" href="../assets/css/checkout.css">
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
<?php
include "../includes/footer.php";
?>

