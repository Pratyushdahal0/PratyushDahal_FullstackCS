<?php
session_start();

// creating empty array to store id
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// check if item_id is sent
if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    // add item to cart empty array 
    $_SESSION['cart'][] = $itemId;

    // return total items count
    echo count($_SESSION['cart']);
}

?>