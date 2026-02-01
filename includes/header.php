<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restaurant Ordering System</title>
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
</head>
<body>
<nav class="restaurant-nav">
    <div class="nav-brand">
        <h1>Restaurant Ordering System</h1>
    </div>
    <div class="nav-links">
        <a href="index.php" class="nav-link">Menu</a>
        <a href="search_menu.php" class="nav-link">Search Menu</a>
        <a href="login.php" class="nav-link">Admin Login</a>
    </div>
</nav>
</body>
</html>