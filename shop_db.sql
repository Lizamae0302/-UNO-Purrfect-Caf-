-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 11:19 PM
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
(1, 'Chocolate Sliced Cake', 'Cakes', 150.00, 86, 'a1.jpg'),
(2, 'Latte', 'Coffee', 80.00, 91, 'l1.jpg');

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
(6, 19, 'Chocolate Sliced Cake', '', 10, 150.00, '2025-05-28 05:39:08'),
(7, 20, 'Chocolate Sliced Cake', '', 2, 150.00, '2025-05-28 22:10:49'),
(8, 20, 'Latte', '', 2, 80.00, '2025-05-28 22:10:49');

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
(10, 19, 'Coffee Den', '2025-05-31', '11:50:00', 'Available', '1', NULL),
(11, 20, 'Chill Spot', '2025-05-30', '16:03:00', 'Available', '2', NULL),
(12, 20, 'Chill Spot', '2025-05-24', '16:16:00', 'Available', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rposorder_items`
--

CREATE TABLE `rposorder_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rposorder_items`
--

INSERT INTO `rposorder_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(198, 'ORD-6834bca1d853e', '67', 1, 25.00),
(199, 'ORD-6834bca1d853e', '67', 1, 26.00),
(200, 'ORD-6834bca1d853e', '67', 1, 30.00),
(201, 'ORD-6834bca1d853e', '67', 1, 23.00),
(202, 'ORD_6834bcb324268', '67f8cbf22b360', 1, 25.00),
(203, 'ORD_6834bcb324268', '67f8b3d743e75', 1, 26.00),
(204, 'ORD_6834bcb324268', '67f8b3aaccfb5', 1, 30.00),
(205, 'ORD_6834bcb324268', '67f8b38bd9d36', 1, 23.00),
(206, 'ORD-6834bdc513e43', '67', 1, 8.00),
(207, 'ORD-6834bdc513e43', '67', 1, 10.00),
(208, 'ORD_6834bdcbad374', '67f7f2af9f8cf', 1, 8.00),
(209, 'ORD_6834bdcbad374', '67f7f26d8ac27', 1, 10.00),
(210, 'ORD-6834bdfc3d43c', '67', 1, 12.00),
(211, 'ORD-6834bdfc3d43c', '67', 1, 8.00),
(212, 'ORD-6834bdfc3d43c', '67', 1, 10.00),
(213, 'ORD-6834bdfc3d43c', '67', 1, 24.00),
(214, 'ORD-6834bdfc3d43c', '67', 1, 30.00),
(215, 'ORD-6834bdfc3d43c', '67', 1, 25.00),
(216, 'ORD_6834be08df1d8', '67f7f30bad96d', 1, 12.00),
(217, 'ORD_6834be08df1d8', '67f7f2af9f8cf', 1, 8.00),
(218, 'ORD_6834be08df1d8', '67f7f26d8ac27', 1, 10.00),
(219, 'ORD_6834be08df1d8', '67f8abb123ea5', 1, 24.00),
(220, 'ORD_6834be08df1d8', '67f8b072da259', 1, 30.00),
(221, 'ORD_6834be08df1d8', '67f8cbf22b360', 1, 25.00),
(222, 'ORD-6835f4392c600', '67', 2, 12.00),
(223, 'ORD_6835f43f1e2d1', '67ed994376e7c', 2, 12.00),
(224, 'ORD-6835f5d0abb04', '67', 1, 12.00),
(225, 'ORD-6835f5d0abb04', '67', 1, 15.00),
(226, 'ORD-6835f5d0abb04', '67', 1, 13.00),
(227, 'ORD-6835f5d0abb04', '67', 1, 14.00),
(228, 'ORD-6835f7cf01880', '67', 1, 12.00),
(229, 'ORD-6835f7cf01880', '67', 1, 15.00),
(230, 'ORD-6835f7cf01880', '67', 1, 13.00),
(231, 'ORD-6835f7cf01880', '67', 1, 14.00),
(232, 'ORD-6835f7cf01880', '67', 1, 15.00),
(233, 'ORD-6835f7cf01880', '67', 1, 20.00),
(234, 'ORD-683607ac65565', '67', 1, 30.00),
(235, 'ORD-683607ac65565', '67', 1, 20.00),
(236, 'ORD-683607ac65565', '67', 1, 30.00),
(237, 'ORD-683607ac65565', '67', 1, 26.00),
(238, 'ORD-683607ac65565', '67', 1, 25.00),
(239, 'ORD-683607ac65565', '67', 1, 26.00),
(240, 'ORD_683607b17c104', '67f8b072da259', 1, 30.00),
(241, 'ORD_683607b17c104', '67f8b0337de33', 1, 20.00),
(242, 'ORD_683607b17c104', '67f8b3aaccfb5', 1, 30.00),
(243, 'ORD_683607b17c104', '67f8b3d743e75', 1, 26.00),
(244, 'ORD_683607b17c104', '67f8cbf22b360', 1, 25.00),
(245, 'ORD_683607b17c104', '67f8aef64f28e', 1, 26.00),
(246, 'ORD-68360ff54e983', '67', 1, 12.00),
(247, 'ORD-68360ff54e983', '67', 1, 15.00),
(248, 'ORD-68360ff54e983', '67', 1, 13.00),
(249, 'ORD-683613df98cc0', '67', 1, 12.00),
(250, 'ORD-683613df98cc0', '67', 1, 15.00),
(251, 'ORD-68368757a50d7', '67', 1, 12.00),
(252, 'ORD_68368774a396d', '67ed994376e7c', 1, 12.00),
(253, 'ORD-6837489e4dec3', '67', 1, 12.00),
(254, 'ORD-6837489e4dec3', '67', 1, 15.00),
(255, 'ORD-6837489e4dec3', '67', 1, 13.00),
(256, 'ORD-6837489e4dec3', '67', 1, 14.00),
(257, 'ORD_683748a502177', '67ed994376e7c', 1, 12.00),
(258, 'ORD_683748a502177', '67ed998dab100', 1, 15.00),
(259, 'ORD_683748a502177', '67ed9a367c823', 1, 13.00),
(260, 'ORD_683748a502177', '67ed9a7a93ba7', 1, 14.00),
(261, 'ORD-6837670b9e94e', '67', 1, 123.00),
(262, 'ORD-6837670b9e94e', '67', 1, 177.00),
(263, 'ORD-6837670b9e94e', '67', 1, 138.00),
(264, 'ORD-6837670b9e94e', '67', 1, 145.00),
(265, 'ORD_6837671e50d7f', '67ed994376e7c', 1, 123.00),
(266, 'ORD_6837671e50d7f', '67ed998dab100', 1, 177.00),
(267, 'ORD_6837671e50d7f', '67ed9a367c823', 1, 138.00),
(268, 'ORD_6837671e50d7f', '67ed9af76dd3d', 1, 145.00),
(269, 'ORD-68377baa74f25', '67', 2, 123.00),
(270, 'ORD-68377baa74f25', '67', 2, 177.00),
(271, 'ORD-68377baa74f25', '67', 1, 138.00),
(272, 'ORD-68377baa74f25', '67', 1, 128.00),
(273, 'ORD-68377baa74f25', '67', 1, 160.00),
(274, 'ORD_68377bb55a584', '67ed994376e7c', 2, 123.00),
(275, 'ORD_68377bb55a584', '67ed998dab100', 2, 177.00),
(276, 'ORD_68377bb55a584', '67ed9a367c823', 1, 138.00),
(277, 'ORD_68377bb55a584', '67ed9a7a93ba7', 1, 128.00),
(278, 'ORD_68377bb55a584', '67ed9aba4d359', 1, 160.00);

-- --------------------------------------------------------

--
-- Table structure for table `rpos_admin`
--

CREATE TABLE `rpos_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_number` varchar(20) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `admin_profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpos_admin`
--

INSERT INTO `rpos_admin` (`admin_id`, `admin_number`, `admin_name`, `admin_email`, `admin_password`, `admin_profile_pic`) VALUES
(1, 'HAO-837', 'Admin', 'admin@mail.com', '$2y$10$eRvwhExbm5Zf9LsH/1lD7eFDG1f2l5KEGfS8X4fjBx28i1PbcYKL2', 'uploads/photo_2025-04-08_18-02-56.jpg'),
(2, 'NOK-3200', 'Admin', 'admin@mail.com', '531c154c293dfa54ca8eb77046c68c1aad5eb1f8', 'uploads/1747302362_Omori x Dan Heng.jpg'),
(5, 'RTB-2240', 'Liza', 'lizawang@mail.com', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', 'uploads/1748174040_photo_2025-04-08_18-19-16 (3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_orders`
--

CREATE TABLE `rpos_orders` (
  `order_id` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `cash_received` decimal(10,2) NOT NULL,
  `change_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `barcode` varchar(255) NOT NULL,
  `staff_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpos_orders`
--

INSERT INTO `rpos_orders` (`order_id`, `total_price`, `cash_received`, `change_amount`, `created_at`, `barcode`, `staff_id`) VALUES
('ORD-6834bca1d853e', 104.00, 0.00, 0.00, '2025-05-26 19:10:25', '', '3'),
('ORD-6834bdc513e43', 18.00, 0.00, 0.00, '2025-05-26 19:15:17', '', '3'),
('ORD-6834bdfc3d43c', 109.00, 0.00, 0.00, '2025-05-26 19:16:12', '', '5'),
('ORD-6835f4392c600', 24.00, 0.00, 0.00, '2025-05-27 17:19:53', '', '3'),
('ORD-6835f5d0abb04', 54.00, 0.00, 0.00, '2025-05-27 17:26:40', '', '3'),
('ORD-6835f7cf01880', 89.00, 0.00, 0.00, '2025-05-27 17:35:11', '', '3'),
('ORD-683607ac65565', 157.00, 0.00, 0.00, '2025-05-27 18:42:52', '', '3'),
('ORD-68360ff54e983', 40.00, 0.00, 0.00, '2025-05-27 19:18:13', '', '3'),
('ORD-683613df98cc0', 27.00, 0.00, 0.00, '2025-05-27 19:34:55', '', '3'),
('ORD-68368757a50d7', 12.00, 0.00, 0.00, '2025-05-28 03:47:35', '', '3'),
('ORD-6837489e4dec3', 54.00, 0.00, 0.00, '2025-05-28 17:32:14', '', '3'),
('ORD-6837670b9e94e', 583.00, 0.00, 0.00, '2025-05-28 19:42:03', '', '3'),
('ORD-68377baa74f25', 1026.00, 0.00, 0.00, '2025-05-28 21:10:02', '', '3'),
('ORD_6834bcb324268', 104.00, 104.00, 0.00, '2025-05-26 19:10:43', '', '3'),
('ORD_6834bdcbad374', 18.00, 100.00, 82.00, '2025-05-26 19:15:23', '', '3'),
('ORD_6834be08df1d8', 109.00, 120.00, 11.00, '2025-05-26 19:16:24', '', '5'),
('ORD_6835f43f1e2d1', 24.00, 100.00, 76.00, '2025-05-27 17:19:59', '', '3'),
('ORD_683607b17c104', 157.00, 200.00, 43.00, '2025-05-27 18:42:57', '', '3'),
('ORD_68368774a396d', 12.00, 20.20, 8.20, '2025-05-28 03:48:04', '', '3'),
('ORD_683748a502177', 54.00, 100.00, 46.00, '2025-05-28 17:32:21', '', '3'),
('ORD_6837671e50d7f', 583.00, 1000.00, 417.00, '2025-05-28 19:42:22', '', '3'),
('ORD_68377bb55a584', 1026.00, 1500.00, 474.00, '2025-05-28 21:10:13', '', '3');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_products`
--

CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `barcode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_products`
--

INSERT INTO `rpos_products` (`prod_id`, `prod_name`, `prod_img`, `prod_desc`, `prod_price`, `created_at`, `barcode`) VALUES
('67ed994376e7c', 'Chocolate Sliced Cake', 'a1.jpg', 'a rich and velvety chocolate cake slice, topped with delicate swirls of whipped cream and a dusting of cocoa, served elegantly on a pristine white plate.', '123', '2025-05-28 18:34:44.273966', '1541766079330'),
('67ed998dab100', 'Lotus Ala Creme', 'a2.jpg', 'a decadent chocolate brownie topped with a crisp Lotus biscuit, paired with velvety whipped cream drizzled in caramel and adorned with biscuit crumbles—an exquisite fusion of crunch and creaminess.', '177', '2025-05-28 18:35:01.575217', '9976870597791'),
('67ed9a367c823', 'Rocky Road Overload', 'a3.jpg', 'a luscious chocolate cake draped in silky cream, adorned with dark and white chocolate shavings, and crowned with a vibrant cherry—an indulgent harmony of rich textures and flavors.', '138', '2025-05-28 18:35:15.892006', '1980726410842'),
('67ed9a7a93ba7', 'Teiny Crun', 'a4.jpg', 'a delicate chocolate dessert sits elegantly on a fluted, gold-rimmed plate, exuding sophistication. The rich, velvety chocolate dome is nestled within a crisp, textured crust, creating a harmonious balance of textures.', '128', '2025-05-28 18:35:31.829477', '9531434716164'),
('67ed9aba4d359', 'Oreo Sliced Cake', 'a5.jpg', 'a luscious slice of Oreo cheesecake rests gracefully on a fluted, cream-toned plate, exuding indulgence. The velvety white filling sits atop a rich, dark cookie crust, offering a perfect balance of texture and flavor.', '160', '2025-05-28 18:35:50.426731', '8254236316240'),
('67ed9af76dd3d', 'MuffCream', 'a6.jpg', 'a decadent chocolate brownie, rich and fudgy, sits elegantly on a pristine white plate, crowned with a perfectly round scoop of vanilla ice cream. A light dusting of cocoa powder adds a refined touch, between the warm, dense brownie and the cool, creamy ice cream.', '145', '2025-05-28 18:36:18.747027', '8430395921192'),
('67f7f1dcd9f6d', 'Choco Donut', '488850373_9541537959255705_8456886246150593934_n.jpg', 'Classic chocolate-glazed donut topped with rich cocoa drizzle and chocolate bits.', '40', '2025-05-28 18:38:12.631060', '3206424404685'),
('67f7f22adbc04', 'Caramel Cream Donut', '488216439_691189646585858_8421141630714838163_n.jpg', 'Filled with smooth caramel cream and finished with a golden caramel glaze.', '55', '2025-05-28 18:38:28.288134', '1591842361422'),
('67f7f26d8ac27', 'Overload Donut', '488229131_1947927939309912_1140293732050680399_n.jpg', 'Fully loaded with chocolate chips, caramel chunks, and crushed cookies for maximum flavor.', '65', '2025-05-28 18:38:50.637495', '3622482925809'),
('67f7f2af9f8cf', 'Cookies and Cream Donut', '487566472_2384827061893305_4790642078583606911_n.jpg', 'Topped with crushed cookies and filled with sweet cream for a cookies-and-cream twist.', '50', '2025-05-28 18:39:07.881602', '4363612785748'),
('67f7f30bad96d', 'Puffy Carapea Donut', '462537084_468294408879033_6468609028808671357_n.jpg', 'Light and airy donut glazed with buttery caramel and a hint of peanut crunch.', '45', '2025-05-28 18:40:31.382815', '5330749234356'),
('67f7f36b44484', 'Peanut Creme Donut', '486060238_667416742441299_4149415021418620414_n.jpg', 'Filled with creamy peanut butter and topped with crushed peanuts and a light sugar glaze.', '50', '2025-05-28 18:40:48.037822', '4599678534956'),
('67f8aadccf142', 'Choco Cherry Ice Cream', '489364700_573326245135581_4216551039213881937_n.jpg', 'A luscious blend of chocolate ice cream swirled with cherry syrup and bits of real cherries.', '150', '2025-05-28 18:41:15.579874', '4203881406886'),
('67f8ab3a86502', 'Peacreme Ice Cream', '488900098_1174624637446933_5638387877384752116_n.jpg', 'Creamy peanut and caramel-flavored ice cream with a smooth, nutty finish.', '150', '2025-05-28 18:44:37.420693', '9552559705970'),
('67f8abb123ea5', 'Strawberry Syrup Ice Cream', '487287497_1190601892605528_1202403885984741471_n.jpg', 'Velvety strawberry ice cream drizzled with rich strawberry syrup for extra sweetness.', '135', '2025-05-28 18:43:12.189861', '3928087763830'),
('67f8abefcd7a5', 'Chocolate Syrup Ice Cream', '488390502_1392323052202781_2087115825040501144_n.jpg', 'Classic chocolate ice cream layered with decadent chocolate syrup for double the cocoa love.', '23', '2025-04-11 05:43:11.843111', '5012550419527'),
('67f8ac34af753', 'Choco Coated Creme Ice Cream', '488920216_660866250214361_2177938219457860434_n.jpg', 'Creamy vanilla-based ice cream wrapped in a crunchy chocolate shell—smooth inside, crisp outside.', '100', '2025-05-28 18:43:34.749762', '8423041713029'),
('67f8ac6a96d65', 'Mocha Peanut Ice Cream', '487297261_3643841845910826_5911464815070360056_n.jpg', ' A bold fusion of mocha and peanut flavors, offering a rich and nutty coffee-infused scoop.', '120', '2025-05-28 18:44:07.711284', '9296438515471'),
('67f8ad9b9a9ec', 'Caramel Cookie Cupcake', '489366390_576887628065715_5030010938183827188_n.jpg', 'A soft vanilla cupcake topped with creamy caramel frosting and a crunchy cookie crumble.', '63', '2025-05-28 18:45:15.628644', '8335472000817'),
('67f8ae8e0f5fe', 'Cherry on Top Cupcake', '488177693_517356964567290_2654076725360481368_n.jpg', 'Fluffy cake with cherry-infused frosting, finished with a juicy cherry on top.', '75', '2025-05-28 18:45:38.992915', '4986359792352'),
('67f8aef64f28e', 'Strawberry Yogurt Cupcake', '485829616_460591683742360_8503415031587448514_n.jpg', 'A refreshing blend of strawberry and yogurt in a soft cupcake, topped with a tangy frosting.', '60', '2025-05-28 18:45:58.662076', '5588208028217'),
('67f8af36d0b5e', 'Cherry Velvet Cupcake', '486864881_24355775084022541_1700389157287586632_n.jpg', ' A twist on red velvet with hints of cherry and a smooth cream cheese frosting.\r\n', '89', '2025-05-28 18:46:16.548354', '9064532850305'),
('67f8af8f82dd2', 'Matcha Strawberry Cupcake ', '487225240_9760273617421184_7977331674206233994_n.jpg', 'Earthy matcha cake paired with strawberry frosting for a perfect balance of bold and sweet.', '78', '2025-05-28 18:46:35.746889', '4766266154388'),
('67f8afd06bb75', 'Strawberry Cupcake ', '487241209_4347485918853156_5170281151392843599_n.jpg', 'Light and moist strawberry-flavored cake topped with sweet strawberry buttercream.', '55', '2025-05-28 18:46:55.363238', '3453491871890'),
('67f8b0337de33', 'Avocado Smoothie', 'f81682ee5177f4782de3bfc506ab4f03.jpg', 'Creamy and rich, made with fresh avocado for a smooth, satisfying blend.', '155', '2025-05-28 18:47:12.618758', '3076280077459'),
('67f8b072da259', 'Strawberry Banana Smoothie', '822e94f127074d2f43101dc4e9be71a1.jpg', 'A classic duo of sweet strawberries and ripe bananas blended to perfection.', '140', '2025-05-28 18:47:31.077740', '1529048292288'),
('67f8b0d9930ab', 'Four Season Smoothie', 'b50abdc25831da5dbae9d1b388c6c9d9.jpg', 'A tropical mix of mango, pineapple, orange, and banana for a refreshing burst of flavor.', '200', '2025-05-28 18:47:45.778741', '3978690215035'),
('67f8b139d39d3', 'Berry Mixed Smoothie ', 'bd820f02b154f043db38b614988dd6c1.jpg', 'A vibrant blend of blueberries, strawberries, raspberries, and blackberries—berrylicious and refreshing.\r\n', '190', '2025-05-28 18:47:57.998509', '3080629414584'),
('67f8b1b163d43', 'Mango Smoothie', '7bb33f4149df29b815250928ccd6b549.jpg', 'Sweet, tropical mango blended into a smooth, icy treat bursting with sunshine flavor.', '120', '2025-05-28 18:48:10.607428', '8195539182098'),
('67f8b201b49a6', 'Kiwi Avocado ', '9a75113dc08267b57a5d79cec7b039ad.jpg', ' A unique combo of tangy kiwi and creamy avocado for a refreshing yet rich smoothie experience.', '160', '2025-05-28 18:48:22.297736', '5404110898208'),
('67f8b32d7cdd8', 'Latte', '488534808_2536526720016563_5853654681662568213_n (1).jpg', 'TBA', '55', '2025-05-28 18:48:42.412968', '6339507360633'),
('67f8b35fdbce8', 'Iced Americano', '487296196_1340268330584664_8178677798480785696_n (1).jpg', 'TBA', '70', '2025-05-28 18:48:54.995812', '5927750708169'),
('67f8b38bd9d36', 'Matcha', '488174299_1182507476747389_4926142331614694864_n (1).jpg', 'TBA', '55', '2025-05-28 18:49:12.179245', '9103645599838'),
('67f8b3aaccfb5', 'Toblerone', '489428829_1735930330327747_7534730089067927129_n (1).jpg', 'TBA', '80', '2025-05-28 18:49:29.909792', '7702284937609'),
('67f8b3d743e75', 'Peanuts', '486061553_1395354614825200_4155531274373402885_n (1).jpg', 'TBA', '65', '2025-05-28 18:49:43.723679', '5525185931567'),
('67f8cbf22b360', 'Strawberry latte', '485808713_1385720382612123_8799238730387260949_n (1).jpg', 'TBA', '75', '2025-05-28 18:50:03.538997', '7439496942489');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff`
--

CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `staff_profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_staff`
--

INSERT INTO `rpos_staff` (`staff_id`, `staff_name`, `staff_number`, `staff_email`, `staff_password`, `created_at`, `staff_profile_pic`) VALUES
(3, 'Kieven', 'PAM-2158', 'kiebs@mail.com', '531c154c293dfa54ca8eb77046c68c1aad5eb1f8', '2025-04-09 17:59:45.671518', 'uploads/1744221585_488244545_574418341657668_6448408771905102441_n.jpg'),
(4, 'Zeik', 'DEN-1779', 'zeik@mail.com', '2abd9867cad9eeee50033bf1d4310baa0c3c2aed', '2025-04-08 09:51:10.639353', NULL),
(5, 'Yukirin', 'KIV-1212', 'yukichirin@mail.com', 'c02a6ec5dfd73cfc10ca7de517ef168a97d0aa71', '2025-05-25 17:28:34.535320', 'uploads/1748194114_photo_2025-04-08_18-02-56.jpg'),
(6, 'Liza', 'RTB-2240', 'lizawang@mail.com', '3d46fa50ee2e6568e758edd5a132f14ce6bde0b1', '2025-04-08 10:23:04.415436', NULL),
(7, 'Kathlyn', 'PVA-1085', 'kathlyn@mail.com', 'e98c6f4782613af753fae0fcc5d8e8876cd73663', '2025-04-08 10:26:11.436257', NULL),
(8, 'Rosemarie', 'STJ-1643', 'rosemarie@mail.com', '26167afa20739a59f7b63b94859093b55c6f2faa', '2025-04-08 10:27:47.540940', NULL),
(9, 'Cj', 'TYG-7467', 'cjnoval@mail.com', 'dhen', '2025-04-10 01:32:56.070273', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff_attendance`
--

CREATE TABLE `rpos_staff_attendance` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `log_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpos_staff_attendance`
--

INSERT INTO `rpos_staff_attendance` (`id`, `staff_id`, `time_in`, `time_out`, `log_date`) VALUES
(2, 3, '2025-05-25 01:21:38', '2025-05-25 01:22:22', '2025-05-26'),
(3, 5, '2025-05-26 01:27:32', '2025-05-26 01:28:48', '2025-05-26'),
(4, 4, '2025-05-26 01:37:46', '2025-05-26 01:38:13', '2025-05-26'),
(5, 7, '2025-05-26 01:45:07', '2025-05-26 01:46:05', '2025-05-26'),
(6, 8, '2025-05-26 01:47:16', '2025-05-26 01:47:20', '2025-05-26'),
(7, 3, '2025-05-27 00:00:08', '2025-05-27 01:56:19', '2025-05-27'),
(8, 5, '2025-05-27 03:15:43', '2025-05-27 03:17:56', '2025-05-27'),
(9, 3, '2025-05-28 00:03:05', '2025-05-28 01:45:31', '2025-05-28'),
(10, 3, '2025-05-29 01:12:07', '2025-05-29 03:40:07', '2025-05-29'),
(11, 5, '2025-05-29 05:14:36', '2025-05-29 05:14:44', '2025-05-29');

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
(19, 'cyte', 'hite@mail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user'),
(20, 'Jiang Jai', 'jiangi@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user');

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
-- Indexes for table `rposorder_items`
--
ALTER TABLE `rposorder_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `rpos_products`
--
ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `rpos_staff_attendance`
--
ALTER TABLE `rpos_staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rposorder_items`
--
ALTER TABLE `rposorder_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rpos_staff_attendance`
--
ALTER TABLE `rpos_staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
