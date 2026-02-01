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

<h2 style="text-align:center;">Order History</h2>

<?php if(empty($orders)): ?>
<p style="text-align:center;">No orders yet.</p>
<?php else: ?>
<table style="width:90%;margin:20px auto;background:#fff;border-collapse:collapse;">
<tr>
    <th style="padding:10px;border-bottom:1px solid #eee;">Order ID</th>
    <th style="padding:10px;border-bottom:1px solid #eee;">Status</th>
    <th style="padding:10px;border-bottom:1px solid #eee;">Total</th>
    <th style="padding:10px;border-bottom:1px solid #eee;">Date</th>
</tr>

<?php foreach($orders as $o): ?>
<tr>
    <td style="padding:10px;text-align:center;"><?= (int)$o['id'] ?></td>
    <td style="padding:10px;text-align:center; 
        <?= $o['status']=='Prepared' ? 'color:green;font-weight:bold;' : 'color:orange;font-weight:bold;' ?>">
        <?= htmlspecialchars($o['status']) ?>
    </td>
    <td style="padding:10px;text-align:center;">Rs. <?= number_format($o['total_price'],2) ?></td>
    <td style="padding:10px;text-align:center;"><?= htmlspecialchars($o['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
