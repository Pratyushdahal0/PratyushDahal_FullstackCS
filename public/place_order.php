<?php
session_start();
require "../config/db.php";

$cart = $_SESSION['cart'] ?? [];

if(empty($cart)){
    echo "<p>Cart is empty!</p>";
    echo '<a href="index.php">Back to Menu</a>';
    exit;
}

// Calculate grand total
$grandTotal = 0;
foreach($cart as $item){
    $grandTotal += $item['price'] * $item['quantity'];
}

// Insert order into orders table
$stmt = $conn->prepare("INSERT INTO orders (total_price) VALUES (?)");
$stmt->execute([$grandTotal]);
$orderId = $conn->lastInsertId();

// Insert each item into order_items table
$stmtItem = $conn->prepare("
    INSERT INTO order_items (order_id, dish_id, dish_name, price, quantity, subtotal)
    VALUES (?, ?, ?, ?, ?, ?)
");

foreach($cart as $dishId => $item){
    $subtotal = $item['price'] * $item['quantity'];
    $stmtItem->execute([
        $orderId,
        $dishId,
        $item['name'],
        $item['price'],
        $item['quantity'],
        $subtotal
    ]);
}

// Clear cart
unset($_SESSION['cart']);

// Show confirmation
echo "<h2>Order placed successfully!</h2>";
echo "<p>Grand Total: Rs. ".number_format($grandTotal, 2)."</p>";
echo '<a href="index.php">Back to Menu</a>';
