<?php
session_start();
require "../config/db.php";
include "../includes/header.php";

// Initialize cart
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Count cart items
$cartCount = 0;
foreach($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
}

// Filter parameters
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

// Build query
$sql = "SELECT id, dishname, price, cuisine, status
        FROM menu
        WHERE status = ?
        AND price BETWEEN ? AND ?";
$params = [$status, $min_price, $max_price];

if ($cuisine !== '') {
    $sql .= " AND cuisine = ?";
    $params[] = $cuisine;
}

// Execute query
$menus = [];
if (!empty($_GET)) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $menus = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/search.css">
</head>
<body>
    <h2 class="resturant_menu">Search Menu</h2>
    
    <!-- Cart Display -->
    <div class="cart_container">
        <span class="cart_icon">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span id="cartCount"><?= $cartCount ?></span>
        </span>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <h3>Search and Filter Menu</h3>
        <form method="GET">
            <div class="form-group">
                <label>Min Price:</label>
                <input type="number" name="min_price" min="0" placeholder="0" value="<?= htmlspecialchars($min_price) ?>">
            </div>
            
            <div class="form-group">
                <label>Max Price:</label>
                <input type="number" name="max_price" min="0" placeholder="10000" value="<?= htmlspecialchars($max_price) ?>">
            </div>
            
            <div class="form-group">
                <label>Cuisine:</label>
                <select name="cuisine">
                    <option value="">All</option>
                    <option value="Indian" <?= $cuisine=='Indian'?'selected':'' ?>>Indian</option>
                    <option value="Italian" <?= $cuisine=='Italian'?'selected':'' ?>>Italian</option>
                    <option value="Chinese" <?= $cuisine=='Chinese'?'selected':'' ?>>Chinese</option>
                    <option value="Nepali" <?= $cuisine=='Nepali'?'selected':'' ?>>Nepali</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Status:</label>
                <select name="status">
                    <option value="available">Available</option>
                </select>
            </div>
            
            <button type="submit">Apply Filters</button>
            <a href="index.php">Back to menu</a>
        </form>
    </div>

    <!-- Menu Items -->
    <?php if (!empty($_GET)): ?>
        <div class="menu-container">
            <?php if (!empty($menus)): ?>
                <?php foreach ($menus as $item): ?>
                    <div class="menu-card">
                        <h3><?= htmlspecialchars($item['dishname']) ?></h3>
                        <p class="price">Rs. <?= number_format($item['price'], 2) ?></p>
                        <p>Cuisine: <?= htmlspecialchars($item['cuisine']) ?></p>
                        <p>Status: <?= htmlspecialchars($item['status']) ?></p>
                        <label for="qty_<?= $item['id'] ?>">Quantity:</label>
                        <input type="number" name="qty" min="1" value="1" class="quantity-input" id="qty_<?= $item['id'] ?>">
                        <button type="button" class="order-btn" onclick="addToCart(<?= $item['id'] ?>)">Add</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No menu items found matching your filter</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- order place garni button -->
    <div style="text-align:center; margin:20px;">
        <form action="checkout.php" method="POST">
            <button class="order-btn">Place Order</button>
        </form>
    </div>

    <script src="../assets/js/cart.js"></script>
</body>
</html>

<?php include "../includes/footer.php"; ?>