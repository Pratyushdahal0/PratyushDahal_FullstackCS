<?php
$server = "mysql:host=localhost;dbname=np03cs4a240192";
$user = "np03cs4a240192";
$password = "Pratyush2005";

//connecting to the database using pdo
try{
    $conn = new PDO($server, $user, $password);
    //echo("connected");
}catch(PDOException $e){
    die(" Database error : ".$e -> getMessage());
}



?> 