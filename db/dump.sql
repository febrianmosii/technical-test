-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2021 at 09:40 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technical_test_detik`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_merchants`
--

CREATE TABLE `ref_merchants` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `latitude` varchar(25) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_merchants`
--

INSERT INTO `ref_merchants` (`id`, `name`, `address`, `phone`, `email`, `longitude`, `latitude`, `created_at`, `update_at`, `deleted_at`) VALUES
(1, 'SlaluStock', 'Jl Suryopranoto 8 B Kompl Harmoni Plaza Bl K/13, Dki Jakarta', '021-725-2064', 'kludge@hotmail.com', '106.816666', '-6.200000', '2021-11-10 23:50:39', '2021-11-10 23:50:39', NULL),
(2, 'Tokoramai', 'Jl Kramat Raya 45, Dki Jakarta', '021-846-2061', 'muadip@icloud.com', '113.482498', '-7.161367', '2021-11-10 23:50:39', '2021-11-10 23:50:39', NULL),
(3, 'Tokomajumundur', 'Jl Panglima Polim XIII 137 RT 007/09, Dki Jakarta', '031-847-0946', 'maradine@me.com', '128.190643', '-3.654703', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(4, 'Semogalaris', 'Jl Wijaya II Kompl Wijaya Grand Centre Bl E/14-A', '031-376-3536', 'nighthawk@sbcglobal.net', '120.195465', '-2.994494', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(5, 'Rumahbarang', 'Jl Rempoa Raya 3, Dki Jakarta', '021-386-0530', 'bdbrown@hotmail.com', '107.519760', '-7.025253', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(6, 'BookingPro', 'Jl Brigjen Katamso 11', '021-475-8541', 'tromey@gmail.com', '110.828316', '-7.550676', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(7, 'Tokoadasemua', 'Jl Kendangsari Bl I/25,Kendangsari', '022-43-1693', 'paulv@icloud.com', '111.713127', '-8.086410', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(8, 'Olahragasehat', 'Perum Winong KG II 398 Yk', '021-864-8268', 'dbanarse@msn.com', '111.466614', '-7.866688', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(9, 'Gudangsport', 'Psr Raya II 66-B,Balai Baru (Pasar Baru)', '021-739-9144', 'pedwards@live.com', '106.116669', '-2.133333', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL),
(10, 'Mustikamakeup', 'Jl HR Rasuna Said Kav X-6/8 Sentra Mulia Lt 17 607, Dki Jakarta', '021-831-6941', 'caronni@hotmail.com', '119.42379', '-5.135399', '2021-11-10 23:50:40', '2021-11-10 23:50:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref_payment_types`
--

CREATE TABLE `ref_payment_types` (
  `id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_payment_types`
--

INSERT INTO `ref_payment_types` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'virtual_account', 'Virtual Account', '2021-11-10 23:24:00', '2021-11-10 23:24:00', NULL),
(2, 'credit_card', 'Credit Card', '2021-11-10 23:24:00', '2021-11-10 23:24:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref_statuses`
--

CREATE TABLE `ref_statuses` (
  `id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref_statuses`
--

INSERT INTO `ref_statuses` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'pending', 'Pending', '2021-11-10 22:52:53', '2021-11-10 22:52:53', NULL),
(2, 'paid', 'Paid', '2021-11-10 22:52:53', '2021-11-10 22:52:53', NULL),
(3, 'failed', 'Failed', '2021-11-10 22:53:05', '2021-11-10 22:53:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(25) NOT NULL,
  `ref_status_id` int(11) NOT NULL DEFAULT 1,
  `ref_payment_type_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `number_va` bigint(12) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_id`, `ref_status_id`, `ref_payment_type_id`, `merchant_id`, `customer_name`, `number_va`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'INV-101121-000001', 1, 1, 1, 'Febrian', 10029996555925, '2021-11-11 15:02:56', '2021-11-11 15:02:56', NULL),
(2, 'INV-101121-000002', 2, 2, 1, 'Rian', NULL, '2021-11-11 15:03:45', '2021-11-11 15:03:45', NULL),
(3, 'INV-101121-000003', 3, 1, 2, 'Doni', 10029977019206, '2021-11-11 15:05:23', '2021-11-11 15:05:23', NULL),
(4, 'INV-101121-000004', 2, 1, 2, 'Doni', 10029940676009, '2021-11-11 15:05:53', '2021-11-11 15:05:53', NULL),
(5, 'INV-101121-000005', 2, 1, 2, 'Rafael', 10029982475852, '2021-11-11 15:06:08', '2021-11-11 15:06:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `item_name`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'TV 21 Inch', 1, '2021-11-11 15:02:56', '2021-11-11 15:02:56', NULL),
(2, 1, 'Remote TV ', 1, '2021-11-11 15:02:56', '2021-11-11 15:02:56', NULL),
(3, 1, 'Kabel Jack TV', 3, '2021-11-11 15:02:56', '2021-11-11 15:02:56', NULL),
(4, 2, 'Sambel Terasi', 5, '2021-11-11 15:03:45', '2021-11-11 15:03:45', NULL),
(5, 2, 'Kecap ', 3, '2021-11-11 15:03:45', '2021-11-11 15:03:45', NULL),
(6, 2, 'Garam', 1, '2021-11-11 15:03:45', '2021-11-11 15:03:45', NULL),
(7, 3, 'Air Mineral', 10, '2021-11-11 15:05:23', '2021-11-11 15:05:23', NULL),
(8, 3, 'Ciki', 100, '2021-11-11 15:05:23', '2021-11-11 15:05:23', NULL),
(9, 3, 'Permen', 5, '2021-11-11 15:05:23', '2021-11-11 15:05:23', NULL),
(10, 4, 'Martabak Telor', 10, '2021-11-11 15:05:53', '2021-11-11 15:05:53', NULL),
(11, 4, 'Martabak Bangka', 100, '2021-11-11 15:05:53', '2021-11-11 15:05:53', NULL),
(12, 5, 'Martabak Telor', 3, '2021-11-11 15:06:08', '2021-11-11 15:06:08', NULL),
(13, 5, 'Martabak Bangka', 3, '2021-11-11 15:06:08', '2021-11-11 15:06:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_merchants`
--
ALTER TABLE `ref_merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_payment_types`
--
ALTER TABLE `ref_payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_statuses`
--
ALTER TABLE `ref_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`),
  ADD KEY `ref_status_id` (`ref_status_id`),
  ADD KEY `merchant_id` (`merchant_id`),
  ADD KEY `ref_payment_type_id` (`ref_payment_type_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transcation_id` (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ref_merchants`
--
ALTER TABLE `ref_merchants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ref_payment_types`
--
ALTER TABLE `ref_payment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ref_statuses`
--
ALTER TABLE `ref_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `ref_merchants` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`ref_payment_type_id`) REFERENCES `ref_payment_types` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`ref_status_id`) REFERENCES `ref_statuses` (`id`);

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
