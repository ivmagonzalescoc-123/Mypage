-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 02:45 PM
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
-- Database: `dental_clinic_bam`
--

-- --------------------------------------------------------

--
-- Table structure for table `dental_payments`
--

CREATE TABLE `dental_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `total_due` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_given` decimal(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_type` varchar(50) DEFAULT 'Cash',
  `tx_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `reference` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dental_payments`
--

INSERT INTO `dental_payments` (`id`, `patient_id`, `service`, `total_due`, `amount_given`, `change_amount`, `payment_type`, `tx_datetime`, `reference`, `note`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cleaning', 500.00, 1000.00, 500.00, 'Card', '2025-12-10 14:09:00', 'PAY-20251210141239-786e2', '', '2025-12-10 13:12:39', NULL),
(2, 2, 'Consultation', 500.00, 500.00, 0.00, 'Cash', '2025-12-10 14:12:00', 'PAY-20251210141338-beac8', '', '2025-12-10 13:13:38', NULL),
(3, 2, 'Filling', 2000.00, 2000.00, 0.00, 'Card', '2025-11-10 20:16:00', 'PAY-20251210144252-b3147', '', '2025-12-10 13:42:52', NULL),
(4, 3, 'Consultation', 15000.00, 15000.00, 0.00, 'Cash', '2025-10-10 17:48:00', 'PAY-20251210144427-8fc62', '', '2025-12-10 13:44:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `email`, `password`, `address`, `city`, `state`, `zip`, `created_at`) VALUES
(1, 'Baloro', 'asda@gmail.com', '$2y$10$amRHQHsvzYddrnFK6anji.Q3SujS4PSlmp0g/ZFdxkrFTQcUlzvRW', 'Zone 3 Balubal', 'Cagayan De Oro', 'Philippines', '9000', '2025-12-04 03:18:24'),
(2, 'Ivan Louiz Gonzales', 'ivma.gonzales.coc@phinmaed.com', '$2y$10$jDTrVQkJxlSkIEoe/WTF/e5PG7b10KaVYw/3ggxXzHSN9E79OPsDu', 'Zone 3 Upper Agusan', 'Cagayan de Oro', 'Philippines', '9000', '2025-12-09 01:46:36'),
(3, 'KC JOY ASNE', 'kcjoy@gmail.com', '$2y$10$1bQmNcXZG6ZkZcqyvq5JRejQFbiZO/DSAlNazKHuGpldbJNQYXt5u', 'Zone 9 Cugman', 'Cagayan De Oro', 'Philippines', '9000', '2025-12-09 08:53:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dental_payments`
--
ALTER TABLE `dental_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tx_datetime` (`tx_datetime`),
  ADD KEY `idx_patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dental_payments`
--
ALTER TABLE `dental_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
