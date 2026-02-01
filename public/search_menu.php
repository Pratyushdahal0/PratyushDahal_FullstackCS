<?php
require "../config/db.php";
include "../includes/header.php";


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

$sql = "SELECT id, dishname, price, cuisine, status
        FROM menu
        WHERE status = ?
        AND price BETWEEN ? AND ?";
$params = [$status, $min_price, $max_price];

if ($cuisine !== '') {
    $sql .= " AND cuisine = ?";
    $params[] = $cuisine;
}

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
    <link rel="stylesheet" href="../assets/css/search.css">
</head>
<body>
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
                        <button type="button" class="order-btn" onclick="addToCart(<?= $item['id'] ?>)">Add to Cart</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No menu items found matching based on your filter</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>

<?php include "../includes/footer.php"; ?>