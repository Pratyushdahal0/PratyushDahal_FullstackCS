<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include "../includes/admin_header.php";
require '../config/db.php';

// Fetch orders
$stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - Orders</title>
<link rel="stylesheet" href="../assets/css/adminpage.css">
</head>
<body>

<main>
<div class="section">
<h3>Orders Overview</h3>

<?php if(empty($orders)): ?>
<p style="text-align:center;">No orders yet.</p>
<?php else: ?>
<table>
<tr>
<th>Order ID</th>
<th>Status</th>
<th>Total</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php foreach ($orders as $order): ?>
<tr>
<td><?= $order['id'] ?></td>
<td class="<?= $order['status']=='Prepared'?'status-prepared':'status-preparing' ?>"><?= htmlspecialchars($order['status']) ?></td>
<td>Rs. <?= number_format($order['total_price'],2) ?></td>
<td><?= htmlspecialchars($order['created_at']) ?></td>
<td>
    <a class="view-btn" href="admin_orderstatus.php?order_id=<?= $order['id'] ?>">Update Status</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</div>
</main>

</body>
</html>
<?php
include "../includes/footer.php";
?>
