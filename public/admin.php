<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}
require '../config/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<header>
    <h2>Admin Panel</h2>
    <nav>
        <a href="menu.php">Menu</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <div class="section">
        <h3>Orders</h3>
        <p>Here you can see all orders and update their status (Preparing / Prepared).</p>
        <!-- You can later load orders table here -->
    </div>

    <div class="section">
        <h3>Menu Management</h3>
        <p>Edit, add or delete menu items here.</p>
        <!-- Link to menu CRUD page -->
        <a href="menu.php">Go to Menu Management</a>
    </div>
</main>

</body>
</html>
