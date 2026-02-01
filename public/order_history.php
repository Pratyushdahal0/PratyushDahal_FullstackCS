<?php
session_start();
require "../config/db.php";
include "../includes/admin_header.php";

if (!isset($_SESSION['admin_logged_in'])) {
    die("Login first. <a href='login.php'>Login</a>");
}

// Fetch orders safely
try {
    $stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
    $orders = $stmt->fetchAll();
} catch(PDOException $e) {
    $orders = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../assets/css/adminorderhis.css">
</head>
<body>
    <h2>Order History</h2>

    <?php if(empty($orders)): ?>
        <p>No orders yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
            
            <?php foreach($orders as $o): ?>
                <?php
                if($o['status'] == 'Prepared'){
                    $statusClass = 'prepared';
                } else {
                    $statusClass = 'preparing';
                }
                ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td class="<?= $statusClass ?>">
                        <?= htmlspecialchars($o['status']) ?>
                    </td>
                    <td>Rs. <?= number_format($o['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($o['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            
        </table>
    <?php endif; ?>
</body>
</html>

<?php include "../includes/footer.php"; ?>