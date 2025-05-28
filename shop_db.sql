-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 05:33 PM
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
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Confirmed',
  `booked_at` datetime DEFAULT current_timestamp()
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
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `name`, `price`, `quantity`, `image`) VALUES
(14, 0, 1, 'Chocolate Sliced Cake', 150.00, 1, 'a1.jpg'),
(29, 19, 1, 'Chocolate Sliced Cake', 150.00, 1, 'a1.jpg'),
(30, 19, 2, 'Latte', 80.00, 1, 'l1.jpg'),
(31, 17, 1, 'Chocolate Sliced Cake', 150.00, 1, 'a1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Cakes'),
(2, 'Coffee'),
(3, 'Ice Cream'),
(4, 'Cupcakes'),
(5, 'Donut'),
(6, 'Smoothies');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_id`, `created_at`) VALUES
(1, 17, '2025-05-24 21:27:46'),
(2, 16, '2025-05-24 22:02:17'),
(3, 19, '2025-05-28 11:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_messages`
--

CREATE TABLE `conversation_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender` enum('user','admin') NOT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation_messages`
--

INSERT INTO `conversation_messages` (`id`, `conversation_id`, `sender`, `message`, `image`, `sent_at`, `is_read`) VALUES
(1, 1, 'user', 'ibog kaau ko niya.', 'uploads/1748093266_e201d7d4cae8d13edac24f2c934ddc3c.jpg', '2025-05-24 21:27:46', 0),
(2, 1, 'admin', 'pagpuyo, naa na to\'y educ.', 'uploads/1748093301_5f19e80e03724a8e047ba5f7ae1e83a2.jpg', '2025-05-24 21:28:21', 0),
(3, 2, 'user', 'di nako niya.', 'uploads/1748095337_dc4ff8ffce65f8af42687a2053cd0b73.jpg', '2025-05-24 22:02:17', 0),
(4, 2, 'admin', 'saba ara ey, makakita gai ka niya maibog dayun ka.', 'uploads/1748095495_7db061550e9556686a64fbdafea2cc5f.jpg', '2025-05-24 22:04:55', 0),
(5, 3, 'user', 'uweeeeeee', '', '2025-05-28 11:40:12', 0),
(6, 3, 'admin', 'ibog ka wawang?', 'uploads/1748403672_6bc90786962a230e9233e17177a8b145.jpg', '2025-05-28 11:41:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `user_name`, `email`, `subject`, `message`, `reply`, `replied_at`, `created_at`, `reply_image`) VALUES
(1, 17, 'Cj', 'zeiksenpai6@gmail.com', 'concern', 'keot kaau siya.', 'reyal, legit, sa tru.', '2025-05-24 13:11:09', '2025-05-24 12:21:52', ''),
(5, 17, 'Cj', 'zeiksenpai6@gmail.com', 'concern', 'ibog kaau ko niya.', NULL, NULL, '2025-05-24 13:11:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `status` enum('Pending','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `image`) VALUES
(1, 'Chocolate Sliced Cake', 'Cakes', 150.00, 88, 'a1.jpg'),
(2, 'Latte', 'Coffee', 80.00, 93, 'l1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `user_id`, `product_name`, `product_image`, `quantity`, `price`, `order_time`) VALUES
(1, 17, 'Chocolate Sliced Cake', NULL, 1, 150.00, '2025-05-27 23:53:02'),
(2, 17, 'Latte', '', 2, 80.00, '2025-05-27 18:00:36'),
(3, 17, 'Chocolate Sliced Cake', '', 1, 150.00, '2025-05-27 18:51:32'),
(4, 17, 'Latte', '', 1, 80.00, '2025-05-27 18:56:30'),
(5, 19, 'Latte', '', 4, 80.00, '2025-05-28 05:39:08'),
(6, 19, 'Chocolate Sliced Cake', '', 10, 150.00, '2025-05-28 05:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `room` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `branch`, `room`, `date`, `time`, `guests`, `notes`, `created_at`) VALUES
(1, 'Zeik', 'zeiksenpai6@gmail.com', 'Paris', 'Chill Spot', '2025-05-22', '22:30:00', 1, '', '2025-05-22 14:39:11'),
(2, 'Zeik', 'zeiksenpai6@gmail.com', 'Cebu', 'Cat Lounge', '2025-05-22', '22:41:00', 2, '', '2025-05-22 14:41:50'),
(3, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-22', '22:55:00', 1, '', '2025-05-22 14:55:20'),
(4, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-22', '11:16:00', 10, '', '2025-05-22 15:16:09'),
(5, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-23', '12:20:00', 1, '', '2025-05-22 16:24:21'),
(6, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-23', '12:29:00', 20, '', '2025-05-22 16:29:13'),
(7, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-23', '12:30:00', 20, '', '2025-05-22 16:31:02'),
(8, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Coffee Den', '2025-05-23', '21:45:00', 5, '', '2025-05-23 01:45:39'),
(9, 'zeik', 'zeikcereno6@gmail.com', 'Baguio', 'Cat Lounge', '2025-12-01', '19:01:00', 7, 'purrfect!', '2025-05-24 14:01:07'),
(10, 'CJ', 'zeiksenpai6@gmail.com', 'Paris', 'Chill Spot', '2025-05-25', '19:28:00', 2, 'wew', '2025-05-24 23:31:00'),
(11, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Cat Lounge', '2025-05-25', '19:40:00', 1, '', '2025-05-24 23:34:11'),
(12, 'CJ', 'zeiksenpai6@gmail.com', 'Paris', 'Chill Spot', '2025-05-25', '07:40:00', 2, '', '2025-05-24 23:35:01'),
(13, 'CJ', 'zeiksenpai6@gmail.com', 'Cebu', 'Coffee Den', '2025-05-25', '22:37:00', 1, '', '2025-05-24 23:37:09'),
(14, 'CJ', 'zeiksenpai6@gmail.com', 'Cebu', 'Coffee Den', '2025-05-25', '07:38:00', 1, '', '2025-05-24 23:38:12'),
(15, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Cat Lounge', '2025-05-25', '09:33:00', 3, '', '2025-05-25 01:31:06'),
(16, 'CJ', 'zeiksenpai6@gmail.com', 'Paris', 'Chill Spot', '2025-05-29', '21:41:00', 1, '', '2025-05-25 01:41:19'),
(17, 'CJ', 'zeiksenpai6@gmail.com', 'Baguio', 'Cat Lounge', '2025-06-07', '11:53:00', 2, 'uwu', '2025-05-27 15:50:34'),
(18, 'CJ', 'zeiksenpai6@gmail.com', 'Paris', 'Chill Spot', '2025-05-28', '00:52:00', 3, '', '2025-05-27 16:49:15');

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
(11, 'Jai', 1, 'ug ako nlng diay?', '2025-05-06 01:12:28'),
(12, 'cyte', 5, 'thank you siopao sa cake', '2025-05-28 03:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `guest_limit` int(11) NOT NULL,
  `availability` enum('available','fully_booked') NOT NULL DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `branch`, `price`, `guest_limit`, `availability`, `image`, `created_at`) VALUES
(1, 'Cat Lounge', 'Baguio', 380.00, 20, 'available', 'uploads/rooms/1748086235_caf14.jpg', '2025-05-24 11:30:35'),
(2, 'Coffee Den', 'Cebu', 250.00, 30, 'available', 'uploads/rooms/1748086300_caf15.jpg', '2025-05-24 11:31:40'),
(3, 'Chill Spot', 'Paris', 330.00, 50, 'available', 'uploads/rooms/1748086349_caf13.jpg', '2025-05-24 11:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `room_bookings`
--

CREATE TABLE `room_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` varchar(50) NOT NULL,
  `guests` text DEFAULT NULL,
  `reservation_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_bookings`
--

INSERT INTO `room_bookings` (`id`, `user_id`, `room_name`, `booking_date`, `booking_time`, `status`, `guests`, `reservation_code`) VALUES
(1, 17, 'Coffee Den', '2025-08-04', '19:07:00', 'Pending', '2', NULL),
(2, 17, 'Coffee Den', '2025-08-04', '19:37:00', 'Pending', '2', NULL),
(3, 17, 'Cat Lounge', '2025-12-01', '08:01:00', 'Pending', '1', NULL),
(4, 17, 'Chill Spot', '2025-05-28', '02:51:00', 'Pending', '1', NULL),
(5, 17, 'Coffee Den', '2025-05-30', '03:20:00', 'Pending', '1', NULL),
(6, 17, 'Chill Spot', '2025-05-28', '18:01:00', 'Pending', '1', NULL),
(7, 17, 'Chill Spot', '2025-05-29', '06:20:00', 'Pending', '2', NULL),
(8, 17, 'Coffee Den', '2025-05-31', '11:32:00', 'Available', '2', NULL),
(9, 19, 'Cat Lounge', '2025-05-30', '02:40:00', 'Available', '2', NULL),
(10, 19, 'Coffee Den', '2025-05-31', '11:50:00', 'Available', '1', NULL);

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
(18, 'cj', 'yukichirin@gmail.com', 'b7adde8a9eec8ce92b5ee0507ce054a4', 'user'),
(19, 'cyte', 'hite@mail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user');

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation_messages`
--
ALTER TABLE `conversation_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
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
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `room_bookings`
--
ALTER TABLE `room_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_code` (`reservation_code`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conversation_messages`
--
ALTER TABLE `conversation_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_bookings`
--
ALTER TABLE `room_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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

--
-- Constraints for table `conversation_messages`
--
ALTER TABLE `conversation_messages`
  ADD CONSTRAINT `conversation_messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`);

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `room_bookings`
--
ALTER TABLE `room_bookings`
  ADD CONSTRAINT `room_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
