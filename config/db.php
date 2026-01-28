<?php
$server = "mysql:host=localhost;dbname=restaurant_system";
$user = "root";
$password = "";

//connecting to the database using pdo
try{
    $conn = new PDO($server, $user, $password);
    echo("connected");
}catch(PDOException $e){
    die(" Database error : ".$e -> getMessage());
}



?> 