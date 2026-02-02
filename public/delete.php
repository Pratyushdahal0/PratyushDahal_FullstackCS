<?php
session_start();
require '../config/db.php';

// only admin allowed
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

// allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// CSRF check
if (
    empty($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    die("CSRF validation failed");
}

// check id
if (empty($_POST['id'])) {
    header("Location: admin_menu.php");
    exit;
}

$id = (int) $_POST['id'];

// delete from menu
try {
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    die("Database Error");
}

// redirect back
header("Location: admin_menu.php");
exit;
