<?php
require "../config/db.php";
include "../includes/header.php";

$stmt = $conn->prepare("SELECT * FROM menu WHERE status = 'available'");
$stmt->execute();
$menuItems = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
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
            color: green;
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
    </style>
</head>

<body>

<h2 style="text-align:center;">Restaurant Menu</h2>


<div class="reviews-container">

   <?php 
    foreach ($menuItems as $item) {
    echo '<div class="menu-card">';
    echo '<h3>' . htmlspecialchars($item['name'], ENT_QUOTES) . '</h3>';
    echo '<p><strong>Price:</strong> Rs. ' . number_format($item['price'], 2) . '</p>';
    echo '<p><strong>Status:</strong> ' . htmlspecialchars($item['status'], ENT_QUOTES) . '</p>';
    echo '<button>Add Order</button>';
    echo '</div>';
    }
    ?>
</div>

</body>
</html>
<?php
include "../includes/footer.php";
?>