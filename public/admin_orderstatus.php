<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

include "../includes/admin_header.php";
require '../config/db.php';

// Handle status update
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])){
    $orderId = (int)$_POST['order_id'];
    $newStatus = $_POST['status'];
    $allowed = ['Preparing','Prepared'];
    if(in_array($newStatus, $allowed)){
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $orderId]);
        $message = "Order #$orderId status updated to $newStatus";
    }
}

// Fetch all orders
$stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Order Status</title>
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; padding:20px; }
table { width:90%; margin:20px auto; border-collapse: collapse; background:#fff; }
th, td { padding:10px; border:1px solid #ddd; text-align:center; }
th { background:#ff9800; color:white; }
select { padding:5px; }
button { padding:5px 10px; background:#28a745; color:white; border:none; border-radius:3px; cursor:pointer; }
button:hover { background:#218838; }
.message { text-align:center; color:green; margin:10px 0; }
.status-preparing { color: orange; font-weight:bold; }
.status-prepared { color: green; font-weight:bold; }
</style>
</head>
<body>

<h2 style="text-align:center;">Orders</h2>

<?php if(!empty($message)) echo "<p class='message'>$message</p>"; ?>

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

<?php foreach($orders as $order): ?>
<tr>
<td><?= $order['id'] ?></td>
<td class="<?= $order['status']=='Prepared'?'status-prepared':'status-preparing' ?>">
    <?= htmlspecialchars($order['status']) ?>
</td>
<td>Rs. <?= number_format($order['total_price'],2) ?></td>
<td><?= htmlspecialchars($order['created_at']) ?></td>
<td>
    <form method="POST" style="margin:0;">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <select name="status">
            <option value="Preparing" <?= $order['status']=='Preparing'?'selected':'' ?>>Preparing</option>
            <option value="Prepared" <?= $order['status']=='Prepared'?'selected':'' ?>>Prepared</option>
        </select>
        <button type="submit">Update</button>
    </form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</body>
</html>
