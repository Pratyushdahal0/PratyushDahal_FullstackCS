<?php
require 'db.php';

try{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        //fetching data for matching if milcha ki nai email pass from db using prepared statement
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email']);
        $user = $stmt->fetch();

        if($user){
            if(password_verify($password, $user['password'])){
                header['location: index.php'];
                exit;
            }else{
                $echo("Incorrect password");
            }
        }else{
            $echo("Email does not exists");
        }

    }


}catch(Exception $e){
    echo("Something went wrong");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!--Form -->
    <form method="POST">

        <!-- Email -->
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" name="password" required>

        <!--Submit button -->
        <button type="login">Login</button>
    </form>
</body>
</html>