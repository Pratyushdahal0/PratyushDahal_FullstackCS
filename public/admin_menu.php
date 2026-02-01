<?php
require "../config/db.php";
include "../includes/admin_header.php";
session_start();

// only admin allowed
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// fetch all menu items
$stmt = $conn->prepare("SELECT * FROM menu ORDER BY id ASC");
$stmt->execute();
$menuItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Menu Management</title>
    <link rel="stylesheet" href="../assets/css/adminmenu.css">
</head>

<body>

<h2 style="text-align:center;">Menu Management</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Dish Name</th>
        <th>Cuisine</th>
        <th>Price (Rs.)</th>
        <th>Status</th>
        <th>Category</th>
    </tr>

    <?php foreach ($menuItems as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['dishname']) ?></td>
            <td><?= htmlspecialchars($item['cuisine']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= htmlspecialchars($item['status']) ?></td>
            <td><?= htmlspecialchars($item['category']) ?></td>
            <td>
                <a class="editbtn" href="edit.php?id=<?= $item['id'] ?>">Edit</a>
                <a class="deletebtn"
                   href="delete.php?id=<?= $item['id'] ?>"
                   onclick="return confirm('Are you sure you want to delete this item?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div style="text-align:center;">
    <a href="add.php"> Add New Menu Item</a>
</div>

</body>
</html>

<?php include "../includes/footer.php"; ?>

