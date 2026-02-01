<?php
session_start();
require "../config/db.php";
header('Content-Type: application/json');

if(isset($_POST['item_id'], $_POST['quantity'])){
    $item_id = (int)$_POST['item_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    // Fetch menu item
    $stmt = $conn->prepare("SELECT dishname, price FROM menu WHERE id=?");
    $stmt->execute([$item_id]);
    $dish = $stmt->fetch();

    if($dish){
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        if(isset($_SESSION['cart'][$item_id])){
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$item_id] = [
                'name' => $dish['dishname'],
                'price' => $dish['price'],
                'quantity' => $quantity
            ];
        }
    }

    // Calculate total cart quantity
    $totalQty = 0;
    foreach($_SESSION['cart'] as $c) $totalQty += $c['quantity'];

    echo json_encode(['totalQty' => $totalQty]);
    exit;
}

// If no valid data
echo json_encode(['totalQty' => 0]);
