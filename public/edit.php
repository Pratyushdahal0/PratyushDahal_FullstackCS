<?php
require "../config/db.php";
session_start();

// admin le matrai access garna milxa
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

//checking id if exits or not
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}
$id = $_GET['id'];
// Fetching existing menu item
$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

//if there is not item then we return back to admin.php
if(!$item){
    header("Location: admin.php");
    exit;
}

// now updating dish when we click submit button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dishName = trim($_POST['dishname']);
    $price = $_POST['price'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $cuisine = $_POST['cuisine'];

    if ($dishName === '' || $price === '' || $category === '') {
        $error = "Dish name and price are required";
    } elseif (!is_numeric($price)) {
        $error = "Price must be a number";
    } elseif ($price < 0) {
        $error = "Price cannot be negative";
    } else {
        $stmt = $conn->prepare(
        "UPDATE menu SET dishname=?, cuisine=?, price=?, category=?, status=?  WHERE id=?"
        );
        $stmt->execute([$dishName, $cuisine, $price, $category, $status, $id]);

        header("Location: admin.php");
        exit;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit.php</title>
</head>
<body>
    <h2>Edit Menu Item</h2>

    <!--creating form-->
    <form method="POST">
    <label>Dish Name:</label><br>
    <input type="text" name="dishname" value="<?= htmlspecialchars($item['dishname']) ?>" required><br><br>

     <label for="cuisine">Cuisine:</label>
     <select name="cuisine">
        <option value="Italian">Italian</option>
        <option value="Indian">Indian</option>
        <option value="Chinese">Chinese</option>
        <option value="Nepali">Nepali</option>
     </select><br><br>

    <!--label Price-->
    <label>Price (Rs.):</label><br>
    <input type="number" name="price" value="<?= htmlspecialchars($item['price']) ?>" required><br><br>

<!--label category-->
    <label>Category:</label><br>
        <select name="category" required>
            <option value="starter" <?= $item['category']=='starter' ? 'selected' : '' ?>>Starter</option>
            <option value="main_course" <?= $item['category']=='main course' ? 'selected' : '' ?>>Main Course</option>
            <option value="beverages" <?= $item['category']=='beverages' ? 'selected' : '' ?>>Beverages</option>
            <option value="dessert" <?= $item['category']=='dessert' ? 'selected' : '' ?>>Dessert</option>
            </select><br><br>

<!--label status-->
    <label>Status:</label><br>
    <select name="status">
        <option value="available" <?= $item['status']=='available' ? 'selected' : '' ?>>Available</option>
        <option value="unavailable" <?= $item['status']=='unavailable' ? 'selected' : '' ?>>Unavailable</option>
    </select><br><br>

    <button type="submit">Update</button>
</form>
</body>
</html>