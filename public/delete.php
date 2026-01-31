<?php
require '../config/db.php';
session_start();

//if session doesnot matches to admin session then immediatly returns to index
if(!isset($_SESSION['admin_logged_in'])){
    header("location: index.php");
    exit;
}

// checking if id is provided or not
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}
$id = $_GET['id'];
//deleting form menu
try {
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// returning back into admin after delete
header("Location: admin.php");
exit
?>


<a href="delete.php?id=<?= $item['id'] ?>">Delete</a>
