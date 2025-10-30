-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 03, 2025 at 09:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agrimart1`
--

-- --------------------------------------------------------

--
-- Table structure for table `AddPaddy`
--

CREATE TABLE `AddPaddy` (
  `tittle` varchar(300) NOT NULL DEFAULT '""',
  `subtitle` varchar(300) NOT NULL DEFAULT '""',
  `image` varchar(300) NOT NULL DEFAULT '""',
  `id` int(11) NOT NULL,
  `price` int(11) DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `AddPaddy`
--

INSERT INTO `AddPaddy` (`tittle`, `subtitle`, `image`, `id`, `price`, `quantity`) VALUES
('Paddy', ' Rice (Oryza Sativa) is the second highest produced grain in the world after corn (maize)).', 'uploads/1751513450_paddy(1).png', 1, 100, 1),
('Wheat', 'Wheat is an important source of carbohydrates.', 'uploads/1750918042_wheat.jpeg', 2, 200, 1),
('Peanut', 'Peanuts require less water and have the smallest carbon footprint of any nut', 'uploads/1750918165_peanut.jpg', 3, 150, 1),
('Carrot', 'The carrot plant is a root vegetable that grows underground. ', 'uploads/1750918456_carrot.jpeg', 4, 90, 1),
('Chilli', 'The chilli plant is a small, bushy plant that grows green leaves and produces small, colorful fruits called chillies.', 'uploads/1750918560_chili.jpg', 5, 80, 1),
('Tomato', 'The tomato plant is a short, bushy plant with soft green leaves and yellow flowers. It grows round, red fruits called tomatoes.', 'uploads/1750918639_tomato.jpeg', 6, 250, 1),
('plant', 'The  plant is a short, bushy plant with soft green leaves and yellow flowers. It grows round, red fruits called tomatoes.', 'uploads/1752469610_image.jpg', 23, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `add_cart`
--

CREATE TABLE `add_cart` (
  `email` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_cart`
--

INSERT INTO `add_cart` (`email`, `product_name`, `quantity`, `price`) VALUES
('test@example.com', 'Carrot', 1, 90),
('test@example.com', 'Tomato', 1, 250),
('test@example.com', 'Tomato', 1, 250),
('test@example.com', 'Tomato', 1, 250),
('test@example.com', 'Carrot', 1, 90),
('test@example.com', 'Tomato', 1, 250),
('test@example.com', 'Tomato', 1, 250),
('test@example.com', 'Tomato', 1, 250);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password_hash`) VALUES
(1, 'sugubear@email.com', '$2y$10$WmWis.oRaFHvsEB3UChEvuk0tIeSYibIXlG0692ThwV5Zo/a.Q65u'),
(2, 'admin@email.com', '$2y$10$bHv.wy/NotP48K8YVQuqhu28MA2nT/GBJx0mfKkEedckrR32qu3mK');

-- --------------------------------------------------------

--
-- Table structure for table `agristore`
--

CREATE TABLE `agristore` (
  `id` int(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `productname` varchar(300) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `orderid` varchar(300) NOT NULL,
  `total amount` int(11) NOT NULL DEFAULT 0,
  `email` varchar(300) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(300) NOT NULL DEFAULT '""'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `productname`, `quantity`, `orderid`, `total amount`, `email`, `date`, `address`, `image`) VALUES
(7, 'Wheat', 2, 'pay_Qqqtm1VzAEinEA', 0, 'test@example.com', '2025-07-09', 'Thandalam', 'uploads/1750918042_wheat.jpeg'),
(8, 'Tomato', 4, 'pay_QqrDvT9WgpqAs5', 0, 'test@example.com', '2025-07-09', 'chennai', 'uploads/1750918639_tomato.jpeg'),
(9, 'Peanut', 4, 'pay_QrIP8bz7XEGzoK', 0, 'test@example.com', '2025-07-10', 'chennai', 'uploads/1750918165_peanut.jpg'),
(10, 'Tomato', 2, 'pay_QsnsGLlGqmmELF', 0, 'test@example.com', '2025-07-14', 'chennai', 'uploads/1750918639_tomato.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', '$2y$10$GibZePQ4U81RGZxdUB/VGehMQLdWDTh/irkAIBy0xcR3G8qplqfaO', '2025-06-25 03:52:47'),
(2, 'Kumaravel', 'kumaravel@gmail.com', '$2y$10$8HdZp1auRBhQtMlB2PXW6.waSLE5cFsz7wGqqjp0tb8UZSckqzCvS', '2025-06-25 04:05:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AddPaddy`
--
ALTER TABLE `AddPaddy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `agristore`
--
ALTER TABLE `agristore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AddPaddy`
--
ALTER TABLE `AddPaddy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agristore`
--
ALTER TABLE `agristore`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
