<?php
session_start();

//requsting 
if($_SERVER['REQUEST_METHOD']=='POST'){
    session_destroy();
    header("location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
</head>
<body>

<h2>Logout</h2>

<p>Are you sure you want to logout?</p>

<form method="POST">
    <button type="submit">Yes, Logout</button>
    <a href="admin.php">No</a>
</form>

</body>
</html>
