<?php
require '../config/db.php';
session_start();

// Generate CSRF token if not exists
if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

try{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
            die('Invalid CSRF token');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch user
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])){
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // new token
            header("Location: admin.php");
            exit;
        } else {
            $error = "Invalid email or password";
        }
    }
} catch(Exception $e){
    $error = "Something went wrong";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<form method="POST">
<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
<?php endif; ?>
<h2>Admin Login</h2>
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

<label for="email">Email</label>
<input type="email" name="email" required>

<label for="password">Password</label>
<input type="password" name="password" required>

<button type="submit">Login</button>
</form>
</body>
</html>
<?php include "../includes/footer.php"; ?>
