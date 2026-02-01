<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Ordering System Admin</title>
</head>
<body>
<!--css for navigation -->
    <style>
.restaurant-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
}
.nav-brand h1 {
    margin: 0;
    color: #172428;
    font-size: 1.5rem;
    font-weight: 600;
}
.nav-links {
    display: flex;
    gap: 1.5rem;
}
.nav-link {
    color: #172428;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
}
.nav-link:hover {
    background-color: #34495e;
    color: white;
    
}

</style>
    <nav class="restaurant-nav">
    <!-- Restaurant Name -->
    <div class="nav-brand h1">
        Restaurant Ordering System Admin Pannel
    </div>

    <!-- Waiter Navigation -->
    <div clas="nav-links">
        <a href="admin.php" class="nav-link"> Admin Page </a>
        <a href="admin_menu.php" class="nav-link"> Menu </a>
        <a href="admin_orderstatus.php" class="nav-link"> Orders </a>
        <a href="order_history.php" class="nav-link"> Orders History </a>
        <a href="logout.php" class="nav-link"> Logout </a>
    </div>

</nav>
</body>
</html>










