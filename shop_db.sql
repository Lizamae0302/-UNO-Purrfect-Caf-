-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 05:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_prices`
--

CREATE TABLE `branch_prices` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(147, 17, 15, 'Lotus Ala Creme', 15, 1, 'a2.jpg'),
(179, 18, 15, 'Lotus Ala Creme', 13, 10, 'a2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(17, 16, 'zeik', 'zeikcereno6@gmail.com', '1212312', 'seven'),
(18, 16, 'zeik', 'zeikcereno6@gmail.com', '1212312', 'uwu'),
(19, 16, 'lanov', 'zeikcereno6@gmail.com', '1', 'ngek');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(46, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 12, '2025-04-02 17:25:59', 'completed'),
(47, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 12, '2025-04-02 17:43:57', 'pending'),
(48, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Lotus Ala Creme (1) ', 15, '2025-04-02 18:01:22', 'pending'),
(49, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'zeik (1) ', 10, '2025-04-02 18:18:41', 'pending'),
(50, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 17, '2025-04-02 23:31:33', 'pending'),
(51, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'zeiky (1) ', 17, '2025-04-03 00:18:12', 'pending'),
(52, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 17, '2025-04-03 00:24:54', 'pending'),
(53, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 17, '2025-04-03 00:28:44', 'pending'),
(54, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 17, '2025-04-03 00:32:56', 'pending'),
(55, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) ', 17, '2025-04-03 09:15:54', 'pending'),
(56, 16, 'zeik', '1212312', 'zeikcereno6@gmail.com', 'Cash on Delivery', 'da\r\ncasxad', 'Chocolate Sliced Cake (1) , Lotus Ala Creme (1) , Rocky Road Overload (1) ', 43, '2025-04-03 10:01:55', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE `passes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `terms` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `max_capacity` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`id`, `name`, `branch`, `description`, `terms`, `price`, `image`, `max_capacity`, `created_at`) VALUES
(1, 'Day Pass', 'Session Road Branch', 'Enjoy a day in our cozy café with cats and coffee.', 'Valid for one day only. Non-transferable.', 380.00, 'image/pass.jpg', 10, '2025-04-10 13:24:51'),
(2, 'Monthly Pass', NULL, 'Unlimited access for a month.', 'Valid for 30 days from first booking.', 2000.00, 'image/pass.jpg', 5, '2025-04-10 13:24:51'),
(3, 'Cat Lounge Pass', NULL, 'Access to the lounge filled with cats!', 'Valid for 3 hours. Bring socks.', 500.00, 'image/pass.jpg', 8, '2025-04-10 13:24:51'),
(4, 'Chill Spot Pass', NULL, 'Relax and chill with our pets.', '2-hour access. No outside food.', 350.00, 'image/pass.jpg', 6, '2025-04-10 13:24:51'),
(5, 'Coffee Den Pass', NULL, 'Perfect for remote work with cats and drinks.', 'Includes 1 free drink.', 450.00, 'image/pass.jpg', 7, '2025-04-10 13:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image`, `category`, `stock`) VALUES
(13, 'Chocolate Sliced Cake', 'a rich and velvety chocolate cake slice, topped with delicate swirls of whipped cream and a dusting of cocoa, served elegantly on a pristine white plate.', 17, 'a1.jpg', 'desserts', 82),
(15, 'Lotus Ala Creme', 'a decadent chocolate brownie topped with a crisp Lotus biscuit, paired with velvety whipped cream drizzled in caramel and adorned with biscuit crumbles—an exquisite fusion of crunch and creaminess.', 13, 'a2.jpg', 'desserts', 9),
(16, 'Rocky Road Overload', 'a luscious chocolate cake draped in silky cream, adorned with dark and white chocolate shavings, and crowned with a vibrant cherry—an indulgent harmony of rich textures and flavors.', 13, 'a3.jpg', '', 9),
(17, 'Teiny Crun', 'a delicate chocolate dessert sits elegantly on a fluted, gold-rimmed plate, exuding sophistication. The rich, velvety chocolate dome is nestled within a crisp, textured crust, creating a harmonious balance of textures. ', 14, 'a4.jpg', '', 10),
(18, 'Oreo Sliced Cake', 'a luscious slice of Oreo cheesecake rests gracefully on a fluted, cream-toned plate, exuding indulgence. The velvety white filling sits atop a rich, dark cookie crust, offering a perfect balance of texture and flavor. ', 11, 'a5.jpg', '', 10),
(19, 'MuffCream', 'a decadent chocolate brownie, rich and fudgy, sits elegantly on a pristine white plate, crowned with a perfectly round scoop of vanilla ice cream. A light dusting of cocoa powder adds a refined touch, between the warm, dense brownie and the cool, creamy ice cream. ', 15, 'a6.jpg', '', 10),
(20, 'Latte', 'a beautifully crafted iced latte is served in a clear glass, showcasing the rich layers of dark coffee and creamy, frothy milk. Topped with a delicate swirl of whipped cream and a dusting of cocoa powder, this drink exudes elegance and indulgence.', 24, 'l1.jpg', '', 10),
(21, 'Iced Americano', 'a perfectly layered iced Americano sits in a sleek glass, elegantly transitioning from creamy white milk to bold, rich espresso. Topped with glistening ice cubes, the drink exudes a refreshing allure. ', 15, 'l2.jpg', '', 10),
(22, 'Matcha', 'a delicate matcha latte served in a sleek glass, showcasing mesmerizing swirls of vibrant green tea blending seamlessly with creamy milk. Topped with a cloud of velvety whipped cream and a dusting of fine matcha powder, it exudes an air of refined indulgence. ', 20, 'l3.jpg', '', 10),
(23, 'Toblerone', 'a rich and indulgent Toblerone-inspired coffee, overflowing with velvety froth and drizzled with luscious chocolate. Topped with delicate chocolate shavings and a dusting of cocoa, this decadent creation is served in a charming white cup, elegantly spilling onto its saucer.', 20, 'l4.jpg', '', 10),
(24, 'Peanuts', 'a smooth and nutty peanut-infused coffee, delicately blended with creamy milk and served over ice. Topped with crunchy peanut crumbles, this indulgent drink offers a perfect balance of rich coffee aroma and the comforting sweetness of roasted peanuts. ', 10, 'l5.jpg', '', 10),
(25, 'Strawberry', 'a luscious fusion of rich coffee and velvety strawberry cream, layered beautifully in a glass. The delicate pink and white swirls create a visually stunning contrast, crowned with a dollop of smooth strawberry foam and a fresh, juicy berry.', 20, 'l6.jpg', '', 10),
(29, 'zeiky', '', 17, '▫️juli▫️.jpg', '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pass_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `pass_id`, `reservation_date`, `reservation_time`, `status`, `created_at`) VALUES
(1, 0, 5, '2025-04-12', '02:37:10', 'Pending', '2025-04-12 08:37:10'),
(2, 16, 5, '2025-04-12', '03:22:47', 'Pending', '2025-04-12 09:22:47'),
(3, 0, 1, '2025-05-06', '03:08:19', 'Pending', '2025-05-06 09:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `rating`, `message`, `created_at`) VALUES
(1, 'zeik', 5, 'pogi nya', '2025-04-09 00:30:50'),
(5, 'dm noval', 2, 'educ man akoa', '2025-04-09 10:06:36'),
(6, 'jai marapo', 5, 'ibog ko kiben', '2025-04-09 10:15:48'),
(7, 'CJ', 1, 'ge daw', '2025-04-09 10:16:59'),
(8, 'zeik', 3, 'try', '2025-04-09 10:19:37'),
(10, 'Jai', 1, 'Way lami, siya ra\r\n', '2025-05-06 01:11:42'),
(11, 'Jai', 1, 'ug ako nlng diay?', '2025-05-06 01:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `branch`, `price`, `image`, `created_at`) VALUES
(1, 'Cat Lounge', 'Cebu', 250.00, 'image/caf14.jpg', '2025-04-10 19:09:43'),
(2, 'Coffee Den', 'Baguio', 200.00, 'image/caf15.jpg', '2025-04-10 19:09:43'),
(3, 'Chill Spot', 'Paris', 300.00, 'image/caf13.jpg', '2025-04-10 19:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(10, 'admin A', 'admin01@gmail.com', '698d51a19d8a121ce581499d7b701668', 'admin'),
(14, 'user A', 'user01@gmail.com', '698d51a19d8a121ce581499d7b701668', 'user'),
(15, 'user B', 'user02@gmail.com', '698d51a19d8a121ce581499d7b701668', 'user'),
(16, 'zeik', 'zeikcereno6@gmail.com', 'bb3aec0fdcdbc2974890f805c585d432', 'user'),
(17, 'CJ', 'zeiksenpai6@gmail.com', 'bb3aec0fdcdbc2974890f805c585d432', 'user'),
(18, 'cj', 'yukichirin@gmail.com', 'b7adde8a9eec8ce92b5ee0507ce054a4', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `name`, `price`, `image`) VALUES
(60, 14, 19, 'pink bouquet', 15, 'pink bouquet.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_prices`
--
ALTER TABLE `branch_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passes`
--
ALTER TABLE `passes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_prices`
--
ALTER TABLE `branch_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch_prices`
--
ALTER TABLE `branch_prices`
  ADD CONSTRAINT `branch_prices_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
