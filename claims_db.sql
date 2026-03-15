-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2026 at 04:51 PM
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
-- Database: `claims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `item_id`, `user_id`, `answer1`, `answer2`, `answer3`, `status`, `created_at`) VALUES
(1, 2, 3, 'Orange', 'Fountain', 'Basag', 'rejected', '2026-03-14 16:00:54'),
(2, 4, 3, 'White', 'GGN Canteen', 'Has scratches', 'approved', '2026-03-14 16:39:41'),
(3, 4, 3, 'white', 'scaa', 'csacsa', 'approved', '2026-03-14 16:52:05'),
(4, 7, 3, 'Black', 'GGN Canteen', 'Gray Case', 'approved', '2026-03-14 17:22:16'),
(5, 9, 5, 'Black', 'Roof deck', 'hole', 'approved', '2026-03-15 14:56:41'),
(6, 10, 3, 'csaca', 'csacas', 'csacsa', 'approved', '2026-03-15 15:07:37'),
(7, 11, 3, 'ascacsaca', 'gsavsac', 'csacagsa', 'approved', '2026-03-15 15:24:51'),
(8, 12, 4, 'scacacsa', 'csagasgaga', 'scacsacacsaf', 'approved', '2026-03-15 15:31:02'),
(9, 13, 4, 'scsacfga', 'csacasc', 'sgaaca', 'rejected', '2026-03-15 15:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location_found` varchar(100) NOT NULL,
  `date_found` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `answer1` varchar(100) NOT NULL,
  `answer2` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'available',
  `approval_status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `category`, `description`, `location_found`, `date_found`, `image`, `posted_by`, `answer1`, `answer2`, `created_at`, `status`, `approval_status`) VALUES
(12, 'Macbook Air', 'Laptop', 'May gasgas', 'GGN Canteen', '2023-08-04', '1773588626_macbook.png', 3, '', '', '2026-03-15 15:32:04', 'claimed', 'approved'),
(13, 'iPad Air', 'Cellphone', 'scacac aca', 'GGN Canteen', '2024-08-23', '1773588858_ipad.png', 3, '', '', '2026-03-15 15:44:55', 'claimed', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('student','admin') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `fullname`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Francine Sto. Domingo', 'fastodomingo@student.hau.edu.ph', '$2y$10$FwiAhjBT.H11pPeVwrwm4ucjm.pwDATD8zpXSoQbs.18yGXFE/RT2', '2026-03-01 16:36:01', 'student'),
(2, 'Gabriel Bondoc', 'gcbondoc@student.hau.edu.ph', '$2y$10$uWmMF/R2A3d8XNIzcL3gOeUT8h6QWcwJq0lvZdvJcXCIQytFk4u86', '2026-03-01 16:37:14', 'student'),
(3, 'Fendi Cruz', 'fjcruz@student.hau.edu.ph', '$2y$10$qrC.PWyM7ziH28.qnNI6HOsD8WngOgOT8p/hVbgfok3KQGkBm1v0a', '2026-03-14 14:50:03', 'student'),
(4, 'Lauren  Garin', 'lgarin@student.hau.edu.ph', '$2y$10$f7ITnOF9WCJmO16c3Z7XGuMnh0sKtdejNVM.IXuuTUCpE5yP5TNKS', '2026-03-14 15:03:18', 'student'),
(5, 'Gab Bondoc', 'gjbondoc@student.hau.edu.ph', '$2y$10$E7vwUmhCBcAKamN9sESGUexZ7pOeQnJncjIuhEA6A.1Z/6c6lIgwm', '2026-03-14 15:15:21', 'admin'),
(6, 'Butiki Baboy', 'butiki@gmail.com', '$2y$10$zqC0wkC2YwkvTOjMt8XHX.dvz7kG0zE.R72O60KBZ4mzWKAmhXEbK', '2026-03-14 15:32:36', 'student'),
(7, 'Marie David', 'mdavid@student.hau.edu.ph', '$2y$10$IMBJFqHDwy2CN/DRf8h.RO0BGwTp00/o97pk2P4HYvNoYeikyE4..', '2026-03-14 15:55:37', 'student'),
(8, 'Kits David', 'kdavid@student.hau.edu.ph', '$2y$10$3uDy/MM5PlzEMn9fPvaYNul8TtmZlwcoqrXpFBGull.tX5qxicIRu', '2026-03-14 17:03:31', 'student'),
(9, 'Pedro Batumbakal', 'pbatumbakal@student.hau.edu.ph', '$2y$10$pVYwXUq5AFJf0tkg7Nl9cOMjBFJJufbZ/8fWEGwUXW9RSkpBKNq4C', '2026-03-14 17:24:41', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
