CREATE DATABASE IF NOT EXISTS restaurant_system;
USE restaurant_system;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE orders (
  id int(11) NOT NULL,
  total_price decimal(10,2) NOT NULL,
  status enum('Preparing','Prepared','Cancelled') NOT NULL DEFAULT 'Preparing',
  created_at datetime DEFAULT current_timestamp()
)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,         
    order_id INT NOT NULL,                      
    dish_id INT NOT NULL,                        
    dish_name VARCHAR(255) NOT NULL,            
    price DECIMAL(10,2) NOT NULL,               
    quantity INT NOT NULL,                       
    subtotal DECIMAL(10,2) NOT NULL,           
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

