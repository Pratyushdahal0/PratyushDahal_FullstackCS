<?php
require "../config/db.php";
include "../includes/header.php";

/* ---------- Filters (your preferred style) ---------- */

$min_price = 0;
if (isset($_GET['min_price'])) {
    $min_price = $_GET['min_price'];
}

$max_price = 100000;
if (isset($_GET['max_price'])) {
    $max_price = $_GET['max_price'];
}

$cuisine = '';
if (isset($_GET['cuisine'])) {
    $cuisine = trim($_GET['cuisine']);
}

$status = 'available';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

/* ---------- Build query FIRST ---------- */

$sql = "SELECT id, dishname, price, cuisine, status
        FROM menu
        WHERE status = ?
        AND price BETWEEN ? AND ?";

$params = [$status, $min_price, $max_price];

if ($cuisine !== '') {
    $sql .= " AND cuisine = ?";
    $params[] = $cuisine;
}

/* ---------- Execute query ---------- */

$menus = [];

if (!empty($_GET)) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Filter Menu</title>
</head>
<body>
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
    color: black;
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

.filter-form {
    margin: 20px;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
.filter-form input,
.filter-form select,
.filter-form button {
    padding: 6px 10px;
    margin-top: 5px;
}
</style>
<h3>Filter Menu</h3>

<form method="GET">

<label>Min:</label><br>
<input type="number" name="min_price" min="0"><br><br>

<label>Max:</label><br>
<input type="number" name="max_price" min="0"><br><br>

<label>Cuisine:</label><br>
<select name="cuisine">
    <option value="">All</option>
    <option value="Indian">Indian</option>
    <option value="Italian">Italian</option>
    <option value="Chinese">Chinese</option>
    <option value="Nepali">Nepali</option>
</select><br><br>

<label>Status:</label><br>
<select name="status">
    <option value="available">Available</option>
    <!--<option value="unavailable">Unavailable</option>-->
</select><br><br>

<button type="submit">Apply</button>
<a href="index.php">Back to menu</a>

</form>

<?php if (!empty($_GET)): ?>

<h3 style="text-align:center;">Menu Items</h3>

<div class="menu-container">
<?php if (!empty($menus)): ?>
    <?php foreach ($menus as $item): ?>
        <div class="menu-card">
            <h3><?= htmlspecialchars($item['dishname']) ?></h3>
            <p class="price">Price: Rs<?= number_format($item['price'], 2) ?></p>
            <p>Status: <?= htmlspecialchars($item['status']) ?></p>
            <label for="quantity">Quantity:</label>
            <input type="number" name="qty" min="1" value="1" class="quantity-input" id="qty_<?= $item['id'] ?>">
            <button type="button" class="order-btn" onclick="addToCart(<?= $item['id'] ?>)">Add</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center;">No menu found.</p>
<?php endif; ?>
</div>
<?php endif; ?>

</body>
</html>
