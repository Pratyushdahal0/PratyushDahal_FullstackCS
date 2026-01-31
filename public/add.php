<?php
    require "../config/db.php";
    session_start();

    //making sure only admin can use this
    if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
    }

    $error = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $dishName = $_POST['dishname'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $category = $_POST['category'];

        //validating is name is missing or not price is numeric or not also 
        //checking dish name or price is empty or not
        if($dishName === '' || $price ===''){
            $error = "Dish name and price cannot be empty";
        }else if(!is_numeric($price)){  //checking price is number or not
            $error = "Price should be in number";
        }
        else if($price < 0){ //checking price negative or not
            $error = "Price cannot be negative";
        }else{
            try{
                //insterting 
                $statement = $conn -> prepare("INSERT INTO menu (dishname, price, category, status)VALUES(?,?,?,?) ");
                $statement-> bindValue(1, $dishName);
                $statement-> bindValue(2, $price);  
                $statement-> bindValue(3, $category);
                $statement-> bindValue(4, $status);
                
                $statement->execute();
		        $conn = null;
                header("location:admin.php");
            }catch(PDOException $e){
                die("Database Error : ".$e-> getMessage());
            }
            

            
        }
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu</title>
</head>
<body>
    <form action="" method="POST">
    <!--Dish name-->
    <label for="dishname">Dish Name:</label>
    <input type="text" name="dishname" required>

    <!--Price-->
    <label for="price">Price (Rs.):</label>
    <input type="number" name="price" required>

    <!-- Category -->
     <label for="category">Category:</label>
     <select name="category">
        <option value="starter">Starter</option>
        <option value="main_course">Main Course</option>
        <option value="beverages">Beverages</option>
        <option value="dessert">Desserts</option>
     </select>
    <!--For Status-->
    <label for="status">Status:</label>
    <select name="status">
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
    </select>

    <button type="submit">Add Item</button>

    <!--Showing the error-->
    <?php
       echo $error;
    ?>

    </form>
   

    <p><a href="admin.php">Back to Admin Dashboard</a></p>
</body>
</html>