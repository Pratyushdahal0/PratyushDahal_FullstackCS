<?php
session_start();
require "../config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffae6;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            border: 2px solid #f4d03f;
        }
        
        h2 {
            color: #2d8659;
            text-align: center;
        }
        
        .total {
            background-color: #fff9c4;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #2d5016;
        }
        
        a {
            display: inline-block;
            background-color: #4caf50;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        a:hover {
            background-color: #45a049;
        }
        
        .empty {
            color: #d32f2f;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
<?php
// check if cart exists in session, if not create empty array
if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}

if(empty($cart)){
    echo '<p class="empty">Cart is empty!</p>';
    echo '<a href="index.php">Back to Menu</a>';
    echo '</div></body></html>';
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
echo '<h2>Order Placed Successfully!</h2>';
echo '<div class="total">Grand Total: Rs. '.number_format($grandTotal, 2).'</div>';
echo '<a href="index.php">Back to Menu</a>';
?>
    </div>
</body>
</html>
<?php include "../includes/footer.php"; ?>