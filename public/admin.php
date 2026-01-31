<?php
include "../includes/admin_header.php";
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}
require '../config/db.php';

//$stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
//$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>



<main>
    <div class="section">
        <h3>Orders</h3>
        <p>Here you can see all orders and update their status (Preparing / Prepared).</p>
        <!-- You can later load orders table here -->
         <table>
<tr>
  <th>Order ID</th>
  <th>User</th>
  <th>Status</th>
</tr>

<?php foreach ($orders as $order): ?>
<tr>
  <td><?= $order['id'] ?></td>
  <td><?= htmlspecialchars($order['status']) ?></td>
  <td>
    <form method="POST">
      <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
      <select name="status">
        <option value="Preparing">Preparing</option>
        <option value="Prepared">Prepared</option>
      </select>
      <button type="submit">Update</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</table>
    </div>

    <div class="section">
        <h3>Menu Management</h3>
        <!-- Link to menu CRUD page -->
        <a href="admin_menu.php">Go to Menu Management</a>
    </div>
</main>

</body>
</html>

