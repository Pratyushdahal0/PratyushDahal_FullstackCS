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
    $orderId = $_POST['order_id'];
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
<link rel="stylesheet" href="../assets/css/adminorderstatus.css">
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
<?php 
include "../includes/footer.php"
?>
