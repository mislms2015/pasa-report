-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2023 at 04:24 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasa_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `pasa_data`
--

CREATE TABLE `pasa_data` (
  `id` int(11) NOT NULL,
  `sequence_number` varchar(100) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date_registered` varchar(100) NOT NULL,
  `primary_min` varchar(25) NOT NULL,
  `brand_emp` varchar(255) NOT NULL,
  `mran` varchar(255) NOT NULL,
  `recipient_min` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_initiated` varchar(100) NOT NULL,
  `date_failed` varchar(100) NOT NULL,
  `date_requested` varchar(100) NOT NULL,
  `date_debit_confirmed` varchar(100) NOT NULL,
  `date_credit_confirmed` varchar(100) NOT NULL,
  `denomination_id` varchar(100) NOT NULL,
  `pasa_type` varchar(100) NOT NULL,
  `BRAND` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pasa_load`
--

CREATE TABLE `pasa_load` (
  `id` int(11) NOT NULL,
  `sequence_number` varchar(100) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date_registered` varchar(100) NOT NULL,
  `primary_min` varchar(25) NOT NULL,
  `brand_emp` varchar(255) NOT NULL,
  `mran` varchar(255) NOT NULL,
  `recipient_min` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_initiated` varchar(100) NOT NULL,
  `date_failed` varchar(100) NOT NULL,
  `date_requested` varchar(100) NOT NULL,
  `date_debit_confirmed` varchar(100) NOT NULL,
  `date_credit_confirmed` varchar(100) NOT NULL,
  `denomination_id` varchar(100) NOT NULL,
  `pasa_type` varchar(100) NOT NULL,
  `BRAND` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pasa_points`
--

CREATE TABLE `pasa_points` (
  `id` int(11) NOT NULL,
  `sequence_number` varchar(100) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date_registered` varchar(100) NOT NULL,
  `primary_min` varchar(25) NOT NULL,
  `brand_emp` varchar(255) NOT NULL,
  `mran` varchar(255) NOT NULL,
  `recipient_min` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_initiated` varchar(100) NOT NULL,
  `date_failed` varchar(100) NOT NULL,
  `date_requested` varchar(100) NOT NULL,
  `date_debit_confirmed` varchar(100) NOT NULL,
  `date_credit_confirmed` varchar(100) NOT NULL,
  `denomination_id` varchar(100) NOT NULL,
  `pasa_type` varchar(100) NOT NULL,
  `BRAND` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pasa_promo`
--

CREATE TABLE `pasa_promo` (
  `id` int(11) NOT NULL,
  `sequence_number` varchar(100) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date_registered` varchar(100) NOT NULL,
  `primary_min` varchar(25) NOT NULL,
  `brand_emp` varchar(255) NOT NULL,
  `mran` varchar(255) NOT NULL,
  `recipient_min` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date_initiated` varchar(100) NOT NULL,
  `date_failed` varchar(100) NOT NULL,
  `date_requested` varchar(100) NOT NULL,
  `date_debit_confirmed` varchar(100) NOT NULL,
  `date_credit_confirmed` varchar(100) NOT NULL,
  `denomination_id` varchar(100) NOT NULL,
  `pasa_type` varchar(100) NOT NULL,
  `BRAND` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pasa_data`
--
ALTER TABLE `pasa_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`STATUS`),
  ADD KEY `idx_brand` (`BRAND`),
  ADD KEY `idx_denom_id` (`denomination_id`);

--
-- Indexes for table `pasa_load`
--
ALTER TABLE `pasa_load`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`STATUS`),
  ADD KEY `idx_brand` (`BRAND`),
  ADD KEY `idx_denom_id` (`denomination_id`);

--
-- Indexes for table `pasa_points`
--
ALTER TABLE `pasa_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`STATUS`),
  ADD KEY `idx_brand` (`BRAND`),
  ADD KEY `idx_denom_id` (`denomination_id`);

--
-- Indexes for table `pasa_promo`
--
ALTER TABLE `pasa_promo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`STATUS`),
  ADD KEY `idx_brand` (`BRAND`),
  ADD KEY `idx_denom_id` (`denomination_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pasa_data`
--
ALTER TABLE `pasa_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasa_load`
--
ALTER TABLE `pasa_load`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasa_points`
--
ALTER TABLE `pasa_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasa_promo`
--
ALTER TABLE `pasa_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
