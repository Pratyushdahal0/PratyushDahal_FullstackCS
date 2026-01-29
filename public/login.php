<?php
require '../config/db.php';
session_start();

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

$error = '';

try{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //checking whether the token matches or not with post submmiting token
       if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
         die('Invalid CSRF token');
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        //fetching data for matching if milcha ki nai email pass from db using prepared statement
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user){
            if(password_verify($password, $user['password'])){
                session_regenerate_id(true);
                $_SESSION['admin_logged_in']= true;
                $_SESSION['user_id']= $user['id'];
                header("location: admin.php");
                exit;
            }else{
                $error = "Invalid email or password";
            }
        }else{
            $error= "Invalid email or password";
        }

    }


}catch(Exception $e){
   $error = "Something went wrong";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <!--Form -->
    <form method="POST">
        <!--  XSS preventing-->
          <?php if ($error): ?>
             <p style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
         <?php endif; ?>

        <!-- adding csrf token to the form -->
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <!-- Email -->
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" name="password" required>

        <!--Submit button -->
        <button type="submit">Login</button>
    </form>
          <!--Signup ko lagi ho-->
          <p>Don't have an account yet? <a href="signup.php">Sign up</a></p>
</body>
</html>