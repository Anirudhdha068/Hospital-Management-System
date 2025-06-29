-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2025 at 06:24 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Anirudhdha', 'a@gmail.com', '1234567890', '2025-03-23 12:35:57'),
(2, 'Prashant', 'p@gmail.com', '1234567890', '2025-03-23 12:35:57'),
(3, 'Aadarsh', 'aa@gmail.com', '1234567890', '2025-03-23 12:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `email`, `phone`, `date`, `timeslot`, `department`, `message`, `created_at`, `user_id`) VALUES
(1, 'ani', 'a@gmail.com', '1234567890', '2025-05-24', '9:00 AM - 11:00 AM', 'Neurology', 'hello sir', '2025-05-01 04:58:46', 1),
(2, 'aaa', 'a@gmail.com', '1234567890', '2025-05-29', '12:00 PM - 2:00 PM', 'Neurology', '', '2025-05-01 05:02:27', 1),
(3, 'asdfghj', 'a@gmail.cjo', '1234567890', '2025-05-29', '9:00 AM - 11:00 AM', 'Neurology', '', '2025-05-01 05:03:47', 1),
(4, 'asdfghj', 'a@gmail.cjo', '1234567890', '2025-05-29', '9:00 AM - 11:00 AM', 'Neurology', '', '2025-05-01 05:04:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `services` text COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `razorpay_payment_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `patient_id`, `services`, `amount`, `created_at`, `razorpay_payment_id`) VALUES
(3, 1, 'General Consultation', 5000000.00, '2025-04-07 11:29:48', NULL),
(4, 1, 'General Consultation', 5000000.00, '2025-04-07 11:33:47', NULL),
(5, 1, 'General Consultation', 5000000.00, '2025-04-07 11:35:01', NULL),
(6, 2, 'General Consultation, Dental Treatment, Lab Test', 84003003.00, '2025-04-07 11:35:48', NULL),
(7, 4, 'General Consultation, Surgery, Dental Treatment, Lab Test, X-Ray, Physiotherapy, Emergency Services', 99999999.99, '2025-04-07 21:47:43', NULL),
(8, 2, 'General Consultation, X-Ray', 200.00, '2025-04-30 21:26:34', NULL),
(9, 2, 'Surgery', 2500.00, '2025-04-30 22:46:50', NULL),
(10, 2, 'Surgery', 2500.00, '2025-04-30 22:46:57', NULL),
(11, 1, 'General Consultation', 300.00, '2025-04-30 22:58:53', NULL),
(12, 1, 'General Consultation', 300.00, '2025-04-30 23:43:42', NULL),
(13, 2, 'General Consultation', 300.00, '2025-04-30 23:44:33', NULL),
(14, 2, 'General Consultation', 300.00, '2025-04-30 23:53:49', NULL),
(15, 2, 'General Consultation', 300.00, '2025-04-30 23:54:48', NULL),
(16, 2, 'General Consultation', 300.00, '2025-04-30 23:58:57', NULL),
(17, 2, 'General Consultation', 300.00, '2025-05-01 00:00:08', NULL),
(18, 1, 'General Consultation', 300.00, '2025-05-01 00:04:05', NULL),
(19, 1, 'General Consultation', 300.00, '2025-05-01 00:04:11', NULL),
(20, 1, 'General Consultation', 300.00, '2025-05-01 00:04:18', NULL),
(21, 1, 'General Consultation', 300.00, '2025-05-01 00:04:24', NULL),
(22, 1, 'General Consultation', 300.00, '2025-05-01 00:21:25', NULL),
(23, 1, 'General Consultation', 300.00, '2025-05-01 00:56:28', NULL),
(24, 1, 'General Consultation', 300.00, '2025-05-01 01:13:50', NULL),
(25, 1, 'General Consultation', 300.00, '2025-05-01 01:14:08', NULL),
(26, 1, 'General Consultation', 300.00, '2025-05-01 08:15:17', 'pay_QPVMV3RGqpI1u5');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `phone`, `role`, `created_at`, `status`) VALUES
(2, 'ram', 'a@gmail.com', NULL, 'Nurse', '2025-04-07 05:34:33', 'active'),
(3, 'raam', 'a@gmail.com', NULL, 'Receptionist', '2025-04-07 05:39:28', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `age`, `blood_group`, `mobile_number`, `email`, `password`, `created_at`) VALUES
(1, 'anirudhdha0', 'vipulbhai', 'poriya', 'Male', 19, 'B+', '1234567890', 'a@gmail.com', '$2y$10$1ZJi.oAHJ8mBnNU6ZMxE/.F5PJ7c9yz764sFP4UQ4IDU6x73EerR6', '2025-03-23 08:19:38'),
(2, 'adarsh', 'zx', 'zxc', 'Male', 1, 'AB+', '1234567891', 'aa@gmail.com', '$2y$10$10NCaA1cvZTguuSIfzYQpOsP6qxFiuOvbPmBY.MHlcHI8yO5FdOSK', '2025-03-24 04:41:49'),
(3, 'aaa', 'aaa', 'aaa', 'Male', 14, 'A-', '1234567999', 'aaa@gmail.com', '$2y$10$sF0i6sX2wTInabKLsmlUzOS9bcfxACCOmqdwFfNCPXOVHchTBFbFm', '2025-04-07 03:34:16'),
(4, 'mayank', 'mahendrabhai', 'chauhan', 'Male', 19, 'O+', '9773433347', 'mayankchauhan4123@gmail.com', '$2y$10$iaHYmMzAWjsSHOz8xUeCfezp6wZYJDMpb47KbTjfZka4Z7T1UKNIi', '2025-04-07 16:14:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
