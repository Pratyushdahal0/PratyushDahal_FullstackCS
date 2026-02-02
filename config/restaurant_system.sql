
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `dishname` varchar(100) NOT NULL,
  `cuisine` varchar(60) DEFAULT NULL,
  `category` varchar(60) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) 

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `dishname`, `cuisine`, `category`, `price`, `status`, `created_at`) VALUES
(4, 'Pizza', 'Chinese', 'main_course', 400.00, 'available', '2026-02-01 09:58:29'),
(5, 'Cappacino', 'Italian', 'main course', 270.00, 'available', '2026-02-01 11:31:35'),
(6, 'Chi. Chilly', 'Chinese', 'starter', 300.00, 'available', '2026-02-01 11:34:08'),
(8, 'Test', 'Italian', 'starter', 100.00, 'available', '2026-02-02 09:54:57');


CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Preparing','Prepared','Cancelled') NOT NULL DEFAULT 'Preparing',
  `created_at` datetime DEFAULT current_timestamp()
)


INSERT INTO `orders` (`id`, `total_price`, `status`, `created_at`) VALUES
(1, 1700.00, 'Preparing', '2026-02-01 18:06:35'),
(2, 1350.00, 'Prepared', '2026-02-01 18:39:47'),
(3, 850.00, 'Preparing', '2026-02-01 23:39:54'),
(4, 1700.00, 'Prepared', '2026-02-01 23:41:40'),
(5, 1120.00, 'Prepared', '2026-02-01 23:43:47'),
(6, 250.00, 'Prepared', '2026-02-01 23:53:47'),
(7, 1120.00, 'Preparing', '2026-02-02 01:10:47'),
(8, 870.00, 'Preparing', '2026-02-02 01:26:09'),
(9, 520.00, 'Preparing', '2026-02-02 01:26:23'),
(10, 1740.00, 'Prepared', '2026-02-02 12:44:15'),
(11, 750.00, 'Prepared', '2026-02-02 15:38:49');



CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
)


INSERT INTO `order_items` (`id`, `order_id`, `dish_id`, `dish_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 2, 'Pizza', 850.00, 2, 1700.00),
(2, 2, 2, 'Pizza', 850.00, 1, 850.00),
(3, 2, 3, 'Keema Noodle', 250.00, 2, 500.00),
(4, 3, 2, 'Pizza', 850.00, 1, 850.00),
(5, 4, 2, 'Pizza', 850.00, 2, 1700.00),
(6, 5, 2, 'Pizza', 850.00, 1, 850.00),
(7, 5, 5, 'Cappacino', 270.00, 1, 270.00),
(8, 6, 3, 'Keema Noodle', 250.00, 1, 250.00),
(9, 7, 2, 'Pizza', 870.00, 1, 870.00),
(10, 7, 3, 'Keema Noodle', 250.00, 1, 250.00),
(11, 8, 2, 'Pizza', 870.00, 1, 870.00),
(12, 9, 3, 'Keema Noodle', 250.00, 1, 250.00),
(13, 9, 5, 'Cappacino', 270.00, 1, 270.00),
(14, 10, 2, 'Pizza', 870.00, 2, 1740.00),
(15, 11, 3, 'Keema Noodle', 250.00, 3, 750.00);


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
)


INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$6Yd.HMObOlQeV60ODkvTFOJ.qraS7MkZ6kZxJHN48EVWZL4wjzcZm');
