<?php
    require "../config/db.php";
    session_start();

    //making sure only admin can use this
    if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
    }

    $error = '';
    $success = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $dishName = $_POST['dishname'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        //validating is name is missing or not price is numeric or not also 
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu</title>
</head>
<body>
    <form action="" method="POST">
    <!--Dish name-->
    <label for="dishname">Dish Name:</label>
    <input type="text" name="dishname" required>

    <!--Price-->
    <label for="price">Price (Rs.):</label>
    <input type="number" name="price" required>

    <!--For Status-->
    <label for="status">Status:</label>
    <select name="status">
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
    </select>

    <button type="submit">Add Item</button>

    </form>
   

    <p><a href="admin.php">Back to Admin Dashboard</a></p>
</body>
</html>