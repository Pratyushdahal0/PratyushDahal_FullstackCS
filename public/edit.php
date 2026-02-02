<?php
session_start();
require "../config/db.php";


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_POST['id'])) {
    header("Location: admin.php");
    exit;
}
$id = $_POST['id'];


$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    header("Location: admin.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die("Invalid CSRF token");
    }

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
            "UPDATE menu SET dishname=?, cuisine=?, price=?, category=?, status=? WHERE id=?"
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
<title>Edit Menu Item</title>
<link rel="stylesheet" href="../assets/css/edit.css">
</head>
<body>

<h2>Edit Menu Item</h2>

<form method="POST">


<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">


<input type="hidden" name="id" value="<?= $item['id'] ?>">

<label>Dish Name:</label>
<input type="text" name="dishname" value="<?= htmlspecialchars($item['dishname']) ?>" required>

<label for="cuisine">Cuisine:</label>
<select name="cuisine">
<option value="Italian" <?php if($item['cuisine'] == 'Italian') echo 'selected'; ?>>Italian</option>
<option value="Indian" <?php if($item['cuisine'] == 'Indian') echo 'selected'; ?>>Indian</option>
<option value="Chinese" <?php if($item['cuisine'] == 'Chinese') echo 'selected'; ?>>Chinese</option>
<option value="Nepali" <?php if($item['cuisine'] == 'Nepali') echo 'selected'; ?>>Nepali</option>
</select>

<label>Price (Rs.):</label>
<input type="number" name="price" value="<?= htmlspecialchars($item['price']) ?>" required>

<label>Category:</label>
<select name="category" required>
<option value="starter" <?php if($item['category'] == 'starter') echo 'selected'; ?>>Starter</option>
<option value="main_course" <?php if($item['category'] == 'main_course') echo 'selected'; ?>>Main Course</option>
<option value="beverages" <?php if($item['category'] == 'beverages') echo 'selected'; ?>>Beverages</option>
<option value="dessert" <?php if($item['category'] == 'dessert') echo 'selected'; ?>>Dessert</option>
</select>

<label>Status:</label>
<select name="status">
<option value="available" <?php if($item['status'] == 'available') echo 'selected'; ?>>Available</option>
<option value="unavailable" <?php if($item['status'] == 'unavailable') echo 'selected'; ?>>Unavailable</option>
</select>

<button type="submit">Update</button>
</form>

</body>
</html>
