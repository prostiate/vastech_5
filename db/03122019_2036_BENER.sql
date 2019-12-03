-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2019 at 02:35 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vastech_5`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `number` varchar(191) DEFAULT NULL,
  `asset_account` int(10) UNSIGNED NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `date` date NOT NULL,
  `cost` decimal(12,2) DEFAULT NULL,
  `credited_account` int(10) UNSIGNED NOT NULL,
  `isDepreciable` int(10) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE `asset_details` (
  `id` int(10) NOT NULL,
  `method` varchar(191) NOT NULL,
  `life` int(10) NOT NULL,
  `rate` int(10) NOT NULL,
  `accumulated_depreciate_account` int(10) UNSIGNED NOT NULL,
  `accumulated_depreciate` decimal(12,2) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashbanks`
--

CREATE TABLE `cashbanks` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `bank_transfer` int(10) DEFAULT NULL,
  `bank_deposit` int(10) DEFAULT NULL,
  `bank_withdrawal_acc` int(10) DEFAULT NULL,
  `bank_withdrawal_ex` int(10) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `number` varchar(191) DEFAULT NULL,
  `pay_from` int(10) UNSIGNED DEFAULT NULL,
  `transfer_from` int(10) UNSIGNED DEFAULT NULL,
  `deposit_to` int(10) UNSIGNED DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `memo` text DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashbank_items`
--

CREATE TABLE `cashbank_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `cashbank_id` int(10) UNSIGNED DEFAULT NULL,
  `receive_from` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `tax_id` int(10) UNSIGNED DEFAULT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coas`
--

CREATE TABLE `coas` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `lock` tinyint(1) DEFAULT 0,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_parent` int(10) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coa_category_id` int(10) UNSIGNED NOT NULL,
  `cashbank` int(10) DEFAULT NULL,
  `default_tax` int(11) DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `state_balance` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coas`
--

INSERT INTO `coas` (`id`, `company_id`, `user_id`, `lock`, `code`, `is_parent`, `parent_id`, `name`, `coa_category_id`, `cashbank`, `default_tax`, `balance`, `state_balance`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 0, '1-10001', 1, NULL, 'Cash', 3, 1, NULL, '0.00', '0.00', NULL, '2019-12-03 08:29:35', NULL),
(2, 0, 0, 0, '1-10002', 1, NULL, 'Bank Account', 3, 1, NULL, '0.00', '0.00', NULL, '2019-12-01 08:03:20', NULL),
(3, 0, 0, 0, '1-10003', 1, NULL, 'Giro', 3, 1, NULL, '0.00', '0.00', NULL, '2019-10-01 14:22:47', NULL),
(4, 0, 0, 0, '1-10100', 1, NULL, 'Account Receivable', 1, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 08:29:35', NULL),
(5, 0, 0, 0, '1-10101', 1, NULL, 'Unbilled Accounts Receivable', 1, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 07:25:30', NULL),
(6, 0, 0, 0, '1-10102', 1, NULL, 'Doubtful Receivable', 1, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 09:57:04', NULL),
(7, 0, 0, 0, '1-10200', 1, NULL, 'Inventory', 4, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 12:44:55', NULL),
(8, 0, 0, 0, '1-10300', 1, NULL, 'Other Receivables', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 09:18:44', NULL),
(9, 0, 0, 0, '1-10301', 1, NULL, 'Employee Receivables', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 09:18:44', NULL),
(10, 0, 0, 0, '1-10400', 1, NULL, 'Undeposited Funds', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-19 19:43:30', NULL),
(11, 0, 0, 0, '1-10401', 1, NULL, 'Other current assets', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-20 11:11:05', NULL),
(12, 0, 0, 0, '1-10402', 1, NULL, 'Prepaid expenses', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-20 10:08:54', NULL),
(13, 0, 0, 0, '1-10403', 1, NULL, 'Advances', 2, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(14, 0, 0, 0, '1-10500', 1, NULL, 'VAT In', 2, 0, NULL, '0.00', '0.00', NULL, '2019-11-01 11:28:56', NULL),
(15, 0, 0, 0, '1-10501', 1, NULL, 'Prepaid Income Tax - PPh 22', 2, 0, NULL, '0.00', '0.00', NULL, '2019-09-20 11:10:51', NULL),
(16, 0, 0, 0, '1-10502', 1, NULL, 'Prepaid Income Tax - PPh 23', 2, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(17, 0, 0, 0, '1-10503', 1, NULL, 'Prepaid Income Tax - PPh 25', 2, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(18, 0, 0, 0, '1-10700', 1, NULL, 'Fixed Assets - Land', 5, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(19, 0, 0, 0, '1-10701', 1, NULL, 'Fixed Assets - Building', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-19 14:28:07', NULL),
(20, 0, 0, 0, '1-10702', 1, NULL, 'Fixed Assets - Building', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 07:45:44', NULL),
(21, 0, 0, 0, '1-10703', 1, NULL, 'Fixed Assets - Vehicles', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 12:40:01', NULL),
(22, 0, 0, 0, '1-10704', 1, NULL, 'Fixed Assets - Machinery & Equipment', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 14:22:57', NULL),
(23, 0, 0, 0, '1-10705', 1, NULL, 'Fixed Assets - Office Equipment Fixed A', 5, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(24, 0, 0, 0, '1-10706', 1, NULL, 'Fixed Assets - Leased Asset', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 14:26:36', NULL),
(25, 0, 0, 0, '1-10707', 1, NULL, 'Intangible Assets', 5, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 14:31:27', NULL),
(26, 0, 0, 0, '1-10708', 1, NULL, 'Trade Mark', 5, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(27, 0, 0, 0, '1-10709', 1, NULL, 'Copyright', 5, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(28, 0, 0, 0, '1-10710', 1, NULL, 'Good Will', 5, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(29, 0, 0, 0, '1-10751', 1, NULL, 'Accumulated Depreciation - Building', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(30, 0, 0, 0, '1-10752', 1, NULL, 'Accumulated Depreciation - Building Improvements', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(31, 0, 0, 0, '1-10753', 1, NULL, 'Accumulated Depreciation - Vehicles', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(32, 0, 0, 0, '1-10754', 1, NULL, 'Accumulated Depreciation - Machinery & Equipment', 7, 0, NULL, '0.00', '0.00', NULL, '2019-09-24 07:51:17', NULL),
(33, 0, 0, 0, '1-10755', 1, NULL, 'Accumulated Depreciation - Office Equipment', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(34, 0, 0, 0, '1-10756', 1, NULL, 'Accumulated Depreciation - Leased Asset', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(35, 0, 0, 0, '1-10757', 1, NULL, 'Accumulated Amortization', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(36, 0, 0, 0, '1-10758', 1, NULL, 'Accumulated Amortization : Trade Mark', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(37, 0, 0, 0, '1-10759', 1, NULL, 'Accumulated Amortization : Copyright', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(38, 0, 0, 0, '1-10760', 1, NULL, 'Accumulated Amortization : Good Will', 7, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(39, 0, 0, 0, '1-10800', 1, NULL, 'Investments', 6, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(40, 0, 0, 0, '2-20100', 1, NULL, 'Trade Payable', 8, 0, NULL, '0.00', '0.00', NULL, '2019-12-01 08:38:44', NULL),
(41, 0, 0, 0, '2-20101', 1, NULL, 'Unbilled Accounts Payable', 8, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 06:35:17', NULL),
(42, 0, 0, 0, '2-20200', 1, NULL, 'Other Payables', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(43, 0, 0, 0, '2-20201', 1, NULL, 'Salaries Payable', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(44, 0, 0, 0, '2-20202', 1, NULL, 'Dividends Payable', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(45, 0, 0, 0, '2-20203', 1, NULL, 'Unearned Revenue', 10, 0, NULL, '0.00', '0.00', NULL, '2019-09-30 05:51:41', NULL),
(46, 0, 0, 0, '2-20301', 1, NULL, 'Accrued Utilities', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(47, 0, 0, 0, '2-20302', 1, NULL, 'Accrued Interest', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(48, 0, 0, 0, '2-20399', 1, NULL, 'Other Accrued Expenses', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(49, 0, 0, 0, '2-20400', 1, NULL, 'Bank Loans', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(50, 0, 0, 0, '2-20500', 1, NULL, 'VAT Out', 10, 0, NULL, '0.00', '0.00', NULL, '2019-11-01 11:31:55', NULL),
(51, 0, 0, 0, '2-20501', 1, NULL, 'Tax Payable - PPh 21', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(52, 0, 0, 0, '2-20502', 1, NULL, 'Tax Payable - PPh 22', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(53, 0, 0, 0, '2-20503', 1, NULL, 'Tax Payable - PPh 23', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(54, 0, 0, 0, '2-20504', 1, NULL, 'Tax Payable - PPh 29', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(55, 0, 0, 0, '2-20599', 1, NULL, 'Other Taxes Payable', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(56, 0, 0, 0, '2-20600', 1, NULL, 'Loan from Shareholders', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(57, 0, 0, 0, '2-20601', 1, NULL, 'Other Current Liabilities', 10, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(58, 0, 0, 0, '2-20700', 1, NULL, 'Employee Benefit Liabilities', 11, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(59, 0, 0, 0, '3-30000', 1, NULL, 'Paid In Capital', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(60, 0, 0, 0, '3-30001', 1, NULL, 'Additional Paid In Capital', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(61, 0, 0, 0, '3-30100', 1, NULL, 'Retained Earnings', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(62, 0, 0, 0, '3-30200', 1, NULL, 'Dividends', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(63, 0, 0, 0, '3-30300', 1, NULL, 'Other Comprehensive Income', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(64, 0, 0, 0, '3-30999', 1, NULL, 'Opening Balance Equity', 12, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(65, 0, 0, 0, '4-40000', 1, NULL, 'Revenue', 13, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 08:09:13', NULL),
(66, 0, 0, 0, '4-40100', 1, NULL, 'Sales Discount', 13, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(67, 0, 0, 0, '4-40200', 1, NULL, 'Sales Return', 13, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 08:23:29', NULL),
(68, 0, 0, 0, '4-40201', 1, NULL, 'Unbilled Revenues', 13, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 07:25:30', NULL),
(69, 0, 0, 0, '5-50000', 1, NULL, 'Cost of Sales', 15, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 08:23:29', NULL),
(70, 0, 0, 0, '5-50100', 1, NULL, 'Purchase Discounts', 15, 0, NULL, '0.00', '0.00', NULL, '2019-11-01 11:17:08', NULL),
(71, 0, 0, 0, '5-50200', 1, NULL, 'Purchase Return', 15, 0, NULL, '0.00', '0.00', NULL, '2019-09-19 11:59:19', NULL),
(72, 0, 0, 0, '5-50300', 1, NULL, 'Shipping/Freight & Delivery', 15, 0, NULL, '0.00', '0.00', NULL, '2019-10-28 19:14:48', NULL),
(73, 0, 0, 0, '5-50400', 1, NULL, 'Import Charges', 15, 0, NULL, '0.00', '0.00', NULL, '2019-10-28 19:13:45', NULL),
(74, 0, 0, 0, '5-50500', 1, NULL, 'Cost of Production', 15, 0, NULL, '0.00', '0.00', NULL, '2019-12-03 12:44:55', NULL),
(75, 0, 0, 0, '6-60000', 1, NULL, 'Selling Expenses', 16, 0, NULL, '0.00', '0.00', NULL, '2019-09-29 20:05:59', NULL),
(76, 0, 0, 0, '6-60001', 1, NULL, 'Advertising & Promotion', 16, 0, NULL, '0.00', '0.00', NULL, '2019-09-29 20:05:59', NULL),
(77, 0, 0, 0, '6-60002', 1, NULL, 'Commission & Fees', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(78, 0, 0, 0, '6-60003', 1, NULL, 'Fuel, Toll and Parking - Sales', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(79, 0, 0, 0, '6-60004', 1, NULL, 'Travelling - Sales', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(80, 0, 0, 0, '6-60005', 1, NULL, 'Communication - Sales', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(81, 0, 0, 0, '6-60006', 1, NULL, 'Other Marketing', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(82, 0, 0, 0, '6-60100', 1, NULL, 'General & Administrative Expenses', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(83, 0, 0, 0, '6-60101', 1, NULL, 'Salaries', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(84, 0, 0, 0, '6-60102', 1, NULL, 'Wages', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(85, 0, 0, 0, '6-60103', 1, NULL, 'Meals and Transport', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(86, 0, 0, 0, '6-60104', 1, NULL, 'Overtime', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(87, 0, 0, 0, '6-60105', 1, NULL, 'Medical', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(88, 0, 0, 0, '6-60106', 1, NULL, 'THR and Bonus', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(89, 0, 0, 0, '6-60107', 1, NULL, 'Jamsostek', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(90, 0, 0, 0, '6-60108', 1, NULL, 'Incentive', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(91, 0, 0, 0, '6-60109', 1, NULL, 'Severance', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(92, 0, 0, 0, '6-60110', 1, NULL, 'Other Benefit and Allowances', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(93, 0, 0, 0, '6-60200', 1, NULL, 'Donations', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(94, 0, 0, 0, '6-60201', 1, NULL, 'Entertainment', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(95, 0, 0, 0, '6-60202', 1, NULL, 'Fuel, Toll and Parking - General', 16, 0, NULL, '0.00', '0.00', NULL, '2019-10-13 12:42:41', NULL),
(96, 0, 0, 0, '6-60203', 1, NULL, 'Repair and Maintenance', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(97, 0, 0, 0, '6-60204', 1, NULL, 'Travelling - General', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(98, 0, 0, 0, '6-60205', 1, NULL, 'Meals', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(99, 0, 0, 0, '6-60206', 1, NULL, 'Communication - General', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(100, 0, 0, 0, '6-60207', 1, NULL, 'Dues & Subscription', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(101, 0, 0, 0, '6-60208', 1, NULL, 'Insurance', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(102, 0, 0, 0, '6-60209', 1, NULL, 'Legal & Professional Fees', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(103, 0, 0, 0, '6-60210', 1, NULL, 'Employee Benefit Expense', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(104, 0, 0, 0, '6-60211', 1, NULL, 'Utilities Expense', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(105, 0, 0, 0, '6-60212', 1, NULL, 'Training & Developments', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(106, 0, 0, 0, '6-60213', 1, NULL, 'Bad Debt Expense', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(107, 0, 0, 0, '6-60214', 1, NULL, 'Taxes and Licenses', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(108, 0, 0, 0, '6-60215', 1, NULL, 'Penalties', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(109, 0, 0, 0, '6-60217', 1, NULL, 'Electricity', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(110, 0, 0, 0, '6-60218', 1, NULL, 'Water', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(111, 0, 0, 0, '6-60219', 1, NULL, 'Service Charge', 16, 0, NULL, '0.00', '0.00', NULL, '2019-10-20 18:38:04', NULL),
(112, 0, 0, 0, '6-60220', 1, NULL, 'Subcribe Software', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(113, 0, 0, 0, '6-60300', 1, NULL, 'Office Expense', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(114, 0, 0, 0, '6-60301', 1, NULL, 'Stationery & Printing', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(115, 0, 0, 0, '6-60302', 1, NULL, 'Stamp & Duty', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(116, 0, 0, 0, '6-60303', 1, NULL, 'Securities and Cleaning', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(117, 0, 0, 0, '6-60304', 1, NULL, 'Supplies and Materials', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(118, 0, 0, 0, '6-60305', 1, NULL, 'Subcontractors', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(119, 0, 0, 0, '6-60400', 1, NULL, 'Rental Expense - Building', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(120, 0, 0, 0, '6-60401', 1, NULL, 'Rental Expense - Vehicle', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(121, 0, 0, 0, '6-60402', 1, NULL, 'Rental Expense - Operating Lease', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(122, 0, 0, 0, '6-60403', 1, NULL, 'Rental Expense - Others', 16, 0, NULL, '0.00', '0.00', NULL, '2019-09-16 16:52:47', NULL),
(123, 0, 0, 0, '6-60500', 1, NULL, 'Depreciation - Building', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(124, 0, 0, 0, '6-60501', 1, NULL, 'Depreciation - Building Improvements', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(125, 0, 0, 0, '6-60502', 1, NULL, 'Depreciation - Vehicle', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(126, 0, 0, 0, '6-60503', 1, NULL, 'Depreciation - Machinery & Equipment', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(127, 0, 0, 0, '6-60504', 1, NULL, 'Depreciation - Office Equipment', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(128, 0, 0, 0, '6-60599', 1, NULL, 'Depreciation - Leased Asset', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(129, 0, 0, 0, '6-60600', 1, NULL, 'Amortization: Trade Mark', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(130, 0, 0, 0, '6-60601', 1, NULL, 'Amortization: Copyright', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(131, 0, 0, 0, '6-60602', 1, NULL, 'Amortization: Good Will', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(132, 0, 0, 0, '6-60216', 1, NULL, 'Waste Goods Expense', 16, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(133, 0, 0, 0, '7-70000', 1, NULL, 'Interest Income - Bank', 14, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(134, 0, 0, 0, '7-70001', 1, NULL, 'Interest Income - Time deposit', 14, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(135, 0, 0, 0, '7-70002', 1, NULL, 'Rounding', 14, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(136, 0, 0, 0, '7-70099', 1, NULL, 'Other Income', 14, 0, NULL, '0.00', '0.00', NULL, '2019-09-09 12:20:31', NULL),
(137, 0, 0, 0, '8-80000', 1, NULL, 'Interest Expense', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(138, 0, 0, 0, '8-80001', 1, NULL, 'Provision', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(139, 0, 0, 0, '8-80002', 1, NULL, '(Gain)/Loss on Disposal of Fixed Assets', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(140, 0, 0, 0, '8-80100', 1, NULL, 'Inventory Adjustments', 17, 0, NULL, '0.00', '0.00', NULL, '2019-09-30 04:36:36', NULL),
(141, 0, 0, 0, '8-80999', 1, NULL, 'Other Miscellaneous Expense', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(142, 0, 0, 0, '9-90000', 1, NULL, 'Income Taxes - Current', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(143, 0, 0, 0, '9-90001', 1, NULL, 'Income Taxes - Deferred', 17, 0, NULL, '0.00', '0.00', NULL, NULL, NULL),
(144, NULL, 1, 0, '11111111', 0, 3, 'test hehe update', 16, NULL, 2, '0.00', NULL, '2019-12-01 06:17:54', '2019-12-01 06:40:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coa_categories`
--

CREATE TABLE `coa_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coa_categories`
--

INSERT INTO `coa_categories` (`id`, `company_id`, `user_id`, `name`) VALUES
(1, 0, 0, 'Account Receivable (A/R)'),
(2, 0, 0, 'Other Current Assets'),
(3, 0, 0, 'Cash & Bank'),
(4, 0, 0, 'Inventory'),
(5, 0, 0, 'Fixed Assets'),
(6, 0, 0, 'Other Assets'),
(7, 0, 0, 'Depreciation & Amortization'),
(8, 0, 0, 'Accounts Payable (A/P)'),
(9, 0, 0, 'Credit Card'),
(10, 0, 0, 'Other Current Liabilities'),
(11, 0, 0, 'Long Term Liabilities'),
(12, 0, 0, 'Equity'),
(13, 0, 0, 'Income'),
(14, 0, 0, 'Other Income'),
(15, 0, 0, 'Cost of Sales'),
(16, 0, 0, 'Expenses'),
(17, 0, 0, 'Other Expense');

-- --------------------------------------------------------

--
-- Table structure for table `coa_details`
--

CREATE TABLE `coa_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `ref_id` int(10) DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `is_logo` tinyint(1) DEFAULT 0,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `user_id`, `company_id`, `is_logo`, `address`, `shipping_address`, `name`, `phone`, `fax`, `tax_number`, `website`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 0, 'Sentra niaga 5 Blok SN 5.3 No. 10 & 3       \r\nHarapan Indah - Bekasi', NULL, 'F A S', NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-28 22:38:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `account_receivable_id` int(10) UNSIGNED DEFAULT NULL,
  `account_payable_id` int(10) UNSIGNED DEFAULT NULL,
  `term_id` int(10) UNSIGNED DEFAULT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_vendor` tinyint(1) NOT NULL DEFAULT 1,
  `type_customer` tinyint(1) NOT NULL DEFAULT 1,
  `type_other` tinyint(1) NOT NULL DEFAULT 1,
  `type_employee` tinyint(1) NOT NULL DEFAULT 1,
  `is_limit` int(10) NOT NULL,
  `limit_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_limit_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `last_limit_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handphone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `another_info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `default_accounts`
--

CREATE TABLE `default_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `default_accounts`
--

INSERT INTO `default_accounts` (`id`, `company_id`, `user_id`, `name`, `account_id`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'default_sales_revenue', 65, '2019-07-17 10:57:20', '2019-07-17 10:57:21'),
(2, 0, 0, 'default_sales_discount', 66, '2019-07-17 10:59:49', '2019-07-17 10:59:50'),
(3, 0, 0, 'dafault_sales_return', 67, '2019-07-17 10:59:47', '2019-07-17 10:59:51'),
(4, 0, 0, 'default_sales_shipping', 136, NULL, NULL),
(5, 0, 0, 'dafault_unearned_revenue', 45, NULL, NULL),
(6, 0, 0, 'default_unbilled_sales', 68, NULL, NULL),
(7, 0, 0, 'default_unbilled_receivable', 5, NULL, NULL),
(8, 0, 0, 'default_sales_tax_receiveable', 50, NULL, NULL),
(10, 0, 0, 'default_purchase', 69, NULL, NULL),
(11, 0, 0, 'default_purchase_shipping', 72, NULL, NULL),
(12, 0, 0, 'default_prepayment', 12, NULL, NULL),
(13, 0, 0, 'default_unbilled_payable', 41, NULL, NULL),
(14, 0, 0, 'default_purchase_tax_receivable', 14, NULL, NULL),
(15, 0, 0, 'default_account_receivable', 4, NULL, NULL),
(16, 0, 0, 'default_account_payable', 40, NULL, NULL),
(17, 0, 0, 'default_inventory', 7, NULL, NULL),
(18, 0, 0, 'default_inventory_general', 140, NULL, NULL),
(19, 0, 0, 'default_inventory_waste', 132, NULL, NULL),
(20, 0, 0, 'default_inventory_production', 74, NULL, NULL),
(21, 0, 0, 'default_opening_balance equity', 64, NULL, NULL),
(22, 0, 0, 'default_fixed_asset', 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `pay_from_coa_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `term_id` int(10) UNSIGNED DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `amount_paid` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `expense_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `tax_id` int(11) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_limit_balances`
--

CREATE TABLE `history_limit_balances` (
  `id` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `to_limit_balance` decimal(12,2) NOT NULL,
  `from_limit_balance` decimal(12,2) NOT NULL,
  `type_limit_balance` varchar(191) NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `other_transaction_id` int(10) NOT NULL,
  `number` varchar(191) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `memo` text DEFAULT NULL,
  `status` int(10) NOT NULL,
  `total_debit` decimal(12,2) DEFAULT NULL,
  `total_credit` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_entry_items`
--

CREATE TABLE `journal_entry_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `journal_entry_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logo_uploadeds`
--

CREATE TABLE `logo_uploadeds` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimensions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logo_uploadeds`
--

INSERT INTO `logo_uploadeds` (`id`, `company_id`, `name`, `dimensions`, `path`, `created_at`, `updated_at`) VALUES
(1, 1, '1574954528_5ddfe62073776.jpg', '300|600', 'C:\\xampp\\htdocs\\vastech_vast\\storage\\app/public/images', '2019-11-28 15:22:09', '2019-11-28 15:22:09'),
(2, 1, '1574980242_5de04a9213185.jpg', '300|600', 'C:\\xampp\\htdocs\\vastech_vast\\storage\\app/public/images', '2019-11-28 22:30:42', '2019-11-28 22:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_03_25_133901_create_co_as_table', 1),
(4, '2019_03_26_011955_create_products_table', 2),
(5, '2019_03_26_065549_create_categories_table', 3),
(21, '2019_03_26_065733_create_units_table', 4),
(22, '2019_03_26_070023_create_product_categories_table', 4),
(23, '2019_03_26_084423_create_warehouses_table', 4),
(24, '2019_03_26_103700_create_stock_adjusments_table', 4),
(25, '2019_04_01_115455_create_contacts_table', 5),
(26, '2019_04_06_094530_create_purchase_orders_table', 5),
(27, '2019_04_09_070409_create_terms_table', 5),
(28, '2019_04_09_085224_create_transaction_formats_table', 6),
(29, '2019_04_09_091404_create_taxes_table', 7),
(30, '2019_04_17_005202_create_purchase_products_table', 7),
(31, '2019_04_17_131810_create_purchase_details_table', 7),
(32, '2019_04_17_135125_create_purchase_quotes_table', 7),
(33, '2019_04_17_173457_create_purchase_deliveries_table', 8),
(34, '2019_04_17_173511_create_purchase_invoices_table', 8),
(35, '2019_04_24_053930_create_trans_numbers_table', 9),
(36, '2019_08_21_224054_create_permission_tables', 10),
(37, '2019_11_28_190618_create_logo_uploadeds_table', 11),
(38, '2019_11_28_190809_create_company_settings_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `other_payment_methods`
--

CREATE TABLE `other_payment_methods` (
  `id` int(19) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `other_payment_methods`
--

INSERT INTO `other_payment_methods` (`id`, `company_id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'Cash', '2019-08-30 16:51:53', '2019-08-30 16:53:55', NULL),
(2, NULL, NULL, 'Check', NULL, NULL, NULL),
(3, NULL, NULL, 'Bank Transfer', NULL, NULL, NULL),
(4, NULL, NULL, 'Credit Card', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_product_categories`
--

CREATE TABLE `other_product_categories` (
  `id` int(19) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `other_product_categories`
--

INSERT INTO `other_product_categories` (`id`, `company_id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'Unsigned', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_statuses`
--

CREATE TABLE `other_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `other_statuses`
--

INSERT INTO `other_statuses` (`id`, `company_id`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'Open', NULL, NULL),
(2, 0, 0, 'Closed', NULL, NULL),
(3, 0, 0, 'Paid', NULL, NULL),
(4, 0, 0, 'Partial', NULL, NULL),
(5, 0, 0, 'Overdue', NULL, NULL),
(6, 0, 0, 'Sent', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_taxes`
--

CREATE TABLE `other_taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int(11) NOT NULL,
  `sell_tax_account` int(10) UNSIGNED NOT NULL,
  `buy_tax_account` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_taxes`
--

INSERT INTO `other_taxes` (`id`, `company_id`, `user_id`, `name`, `rate`, `sell_tax_account`, `buy_tax_account`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 'None', 0, 50, 14, NULL, NULL, NULL),
(2, 0, 0, 'PPN', 10, 50, 14, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_terms`
--

CREATE TABLE `other_terms` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_terms`
--

INSERT INTO `other_terms` (`id`, `company_id`, `user_id`, `name`, `length`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 'Custom', 0, '2019-07-03 02:09:02', '2019-07-03 02:09:04', NULL),
(2, 0, 0, 'Net 30', 30, '2019-06-18 09:05:17', '2019-06-18 09:05:19', NULL),
(3, 0, 0, 'Cash on Delivery', 0, '2019-06-18 09:05:59', '2019-06-18 09:06:00', NULL),
(4, 0, 0, 'Net 15', 15, '2019-06-18 09:06:18', '2019-06-18 09:06:19', NULL),
(5, 0, 0, 'Net 60', 60, '2019-06-18 09:06:32', '2019-06-18 09:06:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_transactions`
--

CREATE TABLE `other_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `ref_id` int(10) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL COMMENT 'delivery payment null',
  `number` varchar(191) DEFAULT NULL,
  `number_complete` varchar(191) DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` int(10) UNSIGNED DEFAULT NULL,
  `due_date` date DEFAULT NULL COMMENT 'delivery payment null',
  `status` int(4) UNSIGNED NOT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `other_units`
--

CREATE TABLE `other_units` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_units`
--

INSERT INTO `other_units` (`id`, `company_id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 0, 'PCS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 0, 0, 'BTG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 0, 0, 'LBR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 0, 0, 'BKS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 0, 0, 'PCS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 0, 0, 'ZAK', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 0, 0, 'PAIL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 0, 0, 'M3', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 0, 0, 'BH', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 0, 0, 'SET', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 0, 0, 'KG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 0, 0, 'STEL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(13, 0, 0, 'ROLL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(14, 0, 0, 'DUS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(15, 0, 0, 'KLG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 0, 0, 'BALL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 0, 0, 'SCH', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 0, 0, 'KTN', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(19, 0, 0, 'LTR', '2019-08-26 15:39:06', '2019-08-26 15:39:06', NULL),
(20, NULL, NULL, 'PSG', '2019-10-20 18:57:07', '2019-10-20 18:57:07', NULL),
(21, NULL, NULL, 'SOSIS', NULL, NULL, NULL),
(22, NULL, NULL, 'TUBE', NULL, NULL, NULL),
(23, NULL, NULL, 'UNIT', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_fours`
--

CREATE TABLE `production_fours` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `result_qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `number` int(10) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `balance_due` float NOT NULL DEFAULT 0,
  `grandtotal` float NOT NULL DEFAULT 0,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_four_items`
--

CREATE TABLE `production_four_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_four_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_ones`
--

CREATE TABLE `production_ones` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `result_qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `number` int(10) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `subtotal_raw` float NOT NULL DEFAULT 0,
  `subtotal_cost` float NOT NULL DEFAULT 0,
  `grandtotal` float NOT NULL DEFAULT 0,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_one_costs`
--

CREATE TABLE `production_one_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_one_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `estimated_cost` float NOT NULL,
  `multiplier` int(10) NOT NULL,
  `amount` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_one_items`
--

CREATE TABLE `production_one_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_one_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `amount` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_threes`
--

CREATE TABLE `production_threes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `result_qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `number` int(10) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `balance_due` float NOT NULL DEFAULT 0,
  `grandtotal` float NOT NULL DEFAULT 0,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_three_items`
--

CREATE TABLE `production_three_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_three_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_twos`
--

CREATE TABLE `production_twos` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `result_qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `number` int(10) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `balance_due` float NOT NULL DEFAULT 0,
  `grandtotal` float NOT NULL DEFAULT 0,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_two_items`
--

CREATE TABLE `production_two_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_two_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `avg_price` decimal(12,2) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_product_category_id` int(10) UNSIGNED DEFAULT NULL,
  `other_unit_id` int(10) UNSIGNED DEFAULT 0,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_buy` tinyint(1) DEFAULT 0,
  `buy_price` decimal(12,2) DEFAULT NULL,
  `buy_tax` int(10) UNSIGNED NOT NULL,
  `buy_account` int(10) UNSIGNED NOT NULL,
  `is_sell` tinyint(1) DEFAULT 0,
  `sell_price` decimal(12,2) DEFAULT NULL,
  `sell_tax` int(10) UNSIGNED NOT NULL,
  `sell_account` int(10) UNSIGNED NOT NULL,
  `is_track` tinyint(1) DEFAULT 0,
  `is_bundle` tinyint(1) NOT NULL DEFAULT 0,
  `min_qty` int(11) DEFAULT 0,
  `default_inventory_account` int(10) UNSIGNED NOT NULL,
  `qty` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, NULL, NULL, '0.00', 'MULLION 5648   0.423 4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(3, NULL, NULL, '0.00', 'MULLION 5648   0.423 3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(4, NULL, NULL, '0.00', 'MULLION 6023   0.306 4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(5, NULL, NULL, '0.00', 'MULLION 6023   0.306 3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(6, NULL, NULL, '0.00', 'BEAD MULLION 5649   0.159 4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(7, NULL, NULL, '0.00', 'BEAD MULLION 5649   0.159 3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(8, NULL, NULL, '0.00', 'TRANSOME 9041   0.179 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(9, NULL, NULL, '0.00', 'CASEMENT JENDELA 6002   0.247 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(10, NULL, NULL, '0.00', 'STOPPER TIANG 5650   0.238 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(11, NULL, NULL, '0.00', 'STOPPER AMBANG 6012   0.187 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(12, NULL, NULL, '0.00', 'GLASS BEAD 6001   0.083 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(13, NULL, NULL, '0.00', 'M SCREW 6081   0.556 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(14, NULL, NULL, '0.00', 'M BEAD 6082   0.486 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(15, NULL, NULL, '0.00', 'GLASS BEAD 6083   0.196 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(16, NULL, NULL, '0.00', 'M POLOS 6085   0.521 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(17, NULL, NULL, '0.00', 'M COVER 6088   0.265 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(18, NULL, NULL, '0.00', 'STOPPER PINTU 6090   0.148 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(19, NULL, NULL, '0.00', 'TUTUP ALUR 11540   0.069 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(20, NULL, NULL, '0.00', 'AMBANG ATAS 6043   0.436 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(21, NULL, NULL, '0.00', 'TIANG LOCKASE 6044   0.527 4.35', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(22, NULL, NULL, '0.00', 'TIANG MOHAIR 6045   0.548 4.35', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(23, NULL, NULL, '0.00', 'TIANG ENGSEL 7140   0.368 4.35', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(24, NULL, NULL, '0.00', 'AMBANG BAWAH 6061   0.635 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(25, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062   0.119 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(26, NULL, NULL, '0.00', 'KUSEN TANDUK 7322   0.383 5.45', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(27, NULL, NULL, '0.00', 'KUSEN TANDUK 7322   0.383 5.65', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(28, NULL, NULL, '0.00', 'KUSEN TANDUK 7322   0.383 5.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(29, NULL, NULL, '0.00', 'KUSEN TANDUK 7322   0.383 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(30, NULL, NULL, '0.00', 'KUSEN TANDUK 7322   0.383 6.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(31, NULL, NULL, '0.00', 'COVER TANDUK 7323   0.197 5.45', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(32, NULL, NULL, '0.00', 'COVER TANDUK 7323   0.197 5.65', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(33, NULL, NULL, '0.00', 'COVER TANDUK 7323   0.197 5.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(34, NULL, NULL, '0.00', 'COVER TANDUK 7323   0.197 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(35, NULL, NULL, '0.00', 'COVER TANDUK 7323   0.197 6.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(36, NULL, NULL, '0.00', 'FRAME JENDELA 3602   0.198 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(37, NULL, NULL, '0.00', 'FRAME JENDELA 3602   0.198 5.65', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(38, NULL, NULL, '0.00', 'FRAME JENDELA 3602   0.198 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(39, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 3604   0.136 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(40, NULL, NULL, '0.00', 'U ALUMINIUM 1037   0.105 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(41, NULL, NULL, '0.00', 'LOUVRE 8665   0.184 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(42, NULL, NULL, '0.00', 'MULLION CANOPY 6023   0.306 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(43, NULL, NULL, '0.00', 'HOLLOW 40X40 6438   0.16 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(44, NULL, NULL, '0.00', 'HOLLOW 20X40X1.2 9597   0.12 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(45, NULL, NULL, '0.00', 'CORNER BLOCK 30587     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(46, NULL, NULL, '0.00', 'PINTU SPANDREEL 7118   0.275 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(47, NULL, NULL, '0.00', 'DOOR HANDLE 8991   0.179 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(48, NULL, NULL, '0.00', 'PANASAP DARK BLUE 6MM       0.008', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(49, NULL, NULL, '0.00', 'PANASAP DARK BLUE 8MM       0.008', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(50, NULL, NULL, '0.00', 'HOLLOW 40X40X1MM 4223   0.402 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(51, NULL, NULL, '0.00', 'STIFFNER     0.157 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(52, NULL, NULL, '0.00', 'SEALANT SILGLAZE EX.GE 116233.23     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(53, NULL, NULL, '0.00', 'MASKING TAPE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(54, NULL, NULL, '0.00', 'FRICTION STAY TOP HUNG FS HD S250 12\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(55, NULL, NULL, '0.00', 'FRICTION STAY TOP HUNG FS S/S 8\" (STANDARD)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(56, NULL, NULL, '0.00', 'CASEMENT HANDLE DEKKSON CH-428       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(57, NULL, NULL, '0.00', 'FLOOR HINGES FH80 SSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(58, NULL, NULL, '0.00', 'PULL HANDLE PH802 38X1200 PSS+SSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(59, NULL, NULL, '0.00', 'PATCH FITTING PT10, PT20, & US10 (W/CYLINDER)     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(60, NULL, NULL, '0.00', 'TOP PIVOT PT -  24       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(61, NULL, NULL, '0.00', 'PULL HANDLE TYPE 809 (32X350) PSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(62, NULL, NULL, '0.00', 'MORTISE LOCK MTS RL84030 SSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(63, NULL, NULL, '0.00', 'DOUBLE CYLINDER CYL DC DL65MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(64, NULL, NULL, '0.00', 'ESCUTCHEON (DEKKSON ESCN 84030 SN)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(65, NULL, NULL, '0.00', 'HINGES DL4\"X3\"X3 MM 2 BB SSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(66, NULL, NULL, '0.00', 'DOOR CLOSER DKS 300 HO       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(67, NULL, NULL, '0.00', 'FLUSH BOLT FB 508 NA(12\" & 6\")       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(68, NULL, NULL, '0.00', 'SCREW FISCHER S8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(69, NULL, NULL, '0.00', 'SCREW 8x3\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(70, NULL, NULL, '0.00', 'SCREW 8x3/4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(71, NULL, NULL, '0.00', 'BUTIL SEALER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(72, NULL, NULL, '0.00', 'SHIM RUBBER WARNA HITAM @50M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(73, NULL, NULL, '0.00', 'BRAKET 50X50X4MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(74, NULL, NULL, '0.00', 'U SHAPE BRAKET 50X50X4MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(75, NULL, NULL, '0.00', 'WINDOW WALL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(76, NULL, NULL, '0.00', 'SETTING BLOK 10X10X1M 7429.69     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(77, NULL, NULL, '0.00', 'KARET STOPPER PINTU 351.4     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(78, NULL, NULL, '0.00', 'KARET STOPPER JENDELA 6916.65     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(79, NULL, NULL, '0.00', 'KARET SKONENG JENDELA 6916.65     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(80, NULL, NULL, '0.00', 'BRAKET MULLION 125MMx60MM FIN. GALVANIS PJG 90MM  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(81, NULL, NULL, '0.00', 'BRAKET BESI 40X40MM FIN. GALVANIS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(82, NULL, NULL, '0.00', 'DINABOLT dia M10 PJG 80MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(83, NULL, NULL, '0.00', 'BOLT NUT dia M8 PJG 60MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(84, NULL, NULL, '0.00', 'SINGLE TAPE LEBAR 20MM WARNA HITAM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(85, NULL, NULL, '0.00', 'RESIBON 14\" EX.NIPPON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(86, NULL, NULL, '0.00', 'KAWAT LAS RD 26       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(87, NULL, NULL, '0.00', 'WINDOW WALL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(88, NULL, NULL, '0.00', 'CAT EX. PROPAN      0.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(89, NULL, NULL, '0.00', 'CURTAIN WALL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(90, NULL, NULL, '0.00', 'Mullion Lidah 27936   0.429 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(91, NULL, NULL, '0.00', 'Mullion Lidah 27936   0.429 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(92, NULL, NULL, '0.00', 'Mullion Lidah 27936   0.429 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(93, NULL, NULL, '0.00', 'Mullion Atachment (Tanpa PC) 27937     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(94, NULL, NULL, '0.00', 'Hollow Aluminium 2\"x4\"x 1.40mm ( Alex ) 497   0.27', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(95, NULL, NULL, '0.00', 'Perimeter Mullion Hollow 3/4\"x3/4\"x 0.90mm(Alex) 8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(96, NULL, NULL, '0.00', 'U Aluminium 3/4\"x3/4\"x0.95mm (Alex) 1078   0.113 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(97, NULL, NULL, '0.00', 'Trunsom Lidah 27938   0.292 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(98, NULL, NULL, '0.00', 'Cover Trunsom Lidah 27939   0.083 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(99, NULL, NULL, '0.00', 'Capping Horizontal & Vertikal 27573   0.08 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(100, NULL, NULL, '0.00', 'Receiver Horizontal & Vertikal 27574   0.053 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(101, NULL, NULL, '0.00', 'Siku Aluminium 20x40x3mm (Tanpa PC/Alex) 621     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(102, NULL, NULL, '0.00', 'M - Polos 18400   0.272 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(103, NULL, NULL, '0.00', 'M - Polos 18400   0.272 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(104, NULL, NULL, '0.00', 'M - Screw 18410   0.289 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(105, NULL, NULL, '0.00', 'M - 1/2 Screw 18412B   0.245 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(106, NULL, NULL, '0.00', 'GLASS BEAD 18405   0.1 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(107, NULL, NULL, '0.00', 'M - Cover 18403   0.129 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(108, NULL, NULL, '0.00', 'TUTUP ALUR 18406   0.07 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(109, NULL, NULL, '0.00', 'STOPPER PINTU 7587   0.139 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(110, NULL, NULL, '0.00', 'TIANG ENGSEL 5730   0.368 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(111, NULL, NULL, '0.00', 'TIANG MOHAIR 4203   0.369 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(112, NULL, NULL, '0.00', 'AMBANG ATAS 4201   0.298 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(113, NULL, NULL, '0.00', 'AMBANG BAWAH 4204   0.419 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(114, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062   0.12 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(115, NULL, NULL, '0.00', 'Stopper Jendela 20502   0.107 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(116, NULL, NULL, '0.00', 'FRAME JENDELA 20503   0.202 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(117, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 20500   0.07 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(118, NULL, NULL, '0.00', 'KACA CLEAR 8MM Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(119, NULL, NULL, '0.00', 'Kaca Clear Tempered 8 mm Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(120, NULL, NULL, '0.00', 'Kaca Clear 10 mm Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(121, NULL, NULL, '0.00', 'Kaca Clear Tempered 10 mm Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(122, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 12MM Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(123, NULL, NULL, '0.00', 'Coak Pojok       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(124, NULL, NULL, '0.00', 'Gosok Pinggir       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(125, NULL, NULL, '0.00', 'Lubang Handle       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(126, NULL, NULL, '0.00', 'Sealant DC 688 ex. Dowcorning       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(127, NULL, NULL, '0.00', 'Automatic Door ES 200 Easy/2-2500 Ex. Dorma (2x1  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(128, NULL, NULL, '0.00', 'Stainless Steel Finish Hairline 1.20mm uk 300x400m', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(129, NULL, NULL, '0.00', 'PT10, PT20, US10 + Cylinder ex. Dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(130, NULL, NULL, '0.00', 'PT24 ex. Dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(131, NULL, NULL, '0.00', 'Floor Hinge BTS 84 Ex Dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(132, NULL, NULL, '0.00', 'Pull Handle ART PH 243 /L-600mm ex. Wilka       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(133, NULL, NULL, '0.00', 'Friction Stay 10\" Top Hung ex. Gracia       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(134, NULL, NULL, '0.00', 'Friction Stay 28\" Top Hung ex. Gracia       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(135, NULL, NULL, '0.00', 'Casement Handle ART 119 Non Locking ex. Gracia    ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(136, NULL, NULL, '0.00', 'Hinges ART 2200 4\"x3\"x2 mm BB SSS ex. Gracia      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(137, NULL, NULL, '0.00', 'Lockset ART 6352 ex. Gracia       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(138, NULL, NULL, '0.00', 'Handle ART 352 ex. Gracia       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(139, NULL, NULL, '0.00', 'Door Closer TS68 ex. Dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(140, NULL, NULL, '0.00', 'BAK CAT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(141, NULL, NULL, '0.00', 'Bracket Besi Siku Finish Galvanis ( Type A )      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(142, NULL, NULL, '0.00', 'Bracket Besi Siku Finish Galvanis ( Type B )      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(143, NULL, NULL, '0.00', 'Butil Sealer Kusen 4\" Type bendera 1       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(144, NULL, NULL, '0.00', 'Butil Sealer Kusen 4\" Type bendera 2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(145, NULL, NULL, '0.00', 'CAT EX. PROPAN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(146, NULL, NULL, '0.00', 'Dinabolt HLC M12x75/35 mm ex. Hilty       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(147, NULL, NULL, '0.00', 'Fiser S8 + Skrup 8x2\" PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(148, NULL, NULL, '0.00', 'Hollow Besi      60x60x3mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(149, NULL, NULL, '0.00', 'Hollow Besi Finish Galvanis      35x15x1.6mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(150, NULL, NULL, '0.00', 'Kalsiboard      6mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(151, NULL, NULL, '0.00', 'Karet Back Up Warna Putih      10mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(152, NULL, NULL, '0.00', 'Karet Sirip Jendela Warna Putih       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(153, NULL, NULL, '0.00', 'Karet Stopper Jendela Warna Putih       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(154, NULL, NULL, '0.00', 'Karet Stopper Pintu Warna Putih       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(155, NULL, NULL, '0.00', 'KUAS ROLL CAT KECIL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(156, NULL, NULL, '0.00', 'MASKING TAPE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(157, NULL, NULL, '0.00', 'Meni Kansai 5kg       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(158, NULL, NULL, '0.00', 'Mohair Warna Abu-Abu       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(159, NULL, NULL, '0.00', 'Mur M10       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(160, NULL, NULL, '0.00', 'Murbaut M10x80mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(161, NULL, NULL, '0.00', 'Plat Sheet      1.20mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(162, NULL, NULL, '0.00', 'Proteksi Aluminium Warna Abu-Abu       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(163, NULL, NULL, '0.00', 'Resibon 14\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(164, NULL, NULL, '0.00', 'Ring M10       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(165, NULL, NULL, '0.00', 'Rockwoll Density 60      50mm ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(166, NULL, NULL, '0.00', 'Screw 6x3/8\" FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(167, NULL, NULL, '0.00', 'Screw 8x1/2\" FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(168, NULL, NULL, '0.00', 'Screw 8x2\" + Fiser S6       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(169, NULL, NULL, '0.00', 'Screw 8x3/4\" PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(170, NULL, NULL, '0.00', 'Setting Blok Warna Hitam      10x10mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(171, NULL, NULL, '0.00', 'Shim Rubber Warna Hitam       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(172, NULL, NULL, '0.00', 'SIKU ALUMINIUM 3/4\"x3/4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(173, NULL, NULL, '0.00', 'Single Tape Putih      17x10mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(174, NULL, NULL, '0.00', 'Single Tape Putih      17x8mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(175, NULL, NULL, '0.00', 'Skrup 8x3/4\" PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(176, NULL, NULL, '0.00', 'Terod M8 panjang 1 meter + Ring Mur       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(177, NULL, NULL, '0.00', 'Thiner Impala 5 kg       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(178, NULL, NULL, '0.00', 'Zincalume      0.3mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(179, NULL, NULL, '0.00', 'Capping + Receiver Curtain Wall      60x60x3mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(180, NULL, NULL, '0.00', 'Curtain Wall Tempered / Non Tempered       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(181, NULL, NULL, '0.00', 'Curtain Wall Tempered / Non Tempered       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(182, NULL, NULL, '0.00', 'Fire Stop       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(183, NULL, NULL, '0.00', 'Frameless Kaca Clear Tempered       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(184, NULL, NULL, '0.00', 'Frameless Kaca Clear Tempered       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(185, NULL, NULL, '0.00', 'Frameless U Aluminium 3/4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(186, NULL, NULL, '0.00', 'Jendela Casement Top Hung       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(187, NULL, NULL, '0.00', 'Kusen 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(188, NULL, NULL, '0.00', 'List Hollow Aluminium Curtain Wall       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(189, NULL, NULL, '0.00', 'Pasang Door Closer       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(190, NULL, NULL, '0.00', 'Pasang Perkuatan Hollow Besi       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(191, NULL, NULL, '0.00', 'Pembuatan Gudang + Site Office       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(192, NULL, NULL, '0.00', 'Perkuatan Hollow Besi       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(193, NULL, NULL, '0.00', 'Pintu Frameless       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(194, NULL, NULL, '0.00', 'Pintu Swing       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(195, NULL, NULL, '0.00', 'Sealant       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(196, NULL, NULL, '0.00', 'Sealant Kaca Frameless       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(197, NULL, NULL, '0.00', 'Window Stoll + Tutup Curtain Wall       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(198, NULL, NULL, '0.00', 'Kontrakan Pekerja Asumsi 5 Bln 4 kamar (24 orang) ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(199, NULL, NULL, '0.00', 'Safety APD       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(200, NULL, NULL, '0.00', 'Pemasangan Scafolding       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(201, NULL, NULL, '0.00', 'Pembuatan Site Office + Gudang       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(202, NULL, NULL, '0.00', 'Iuran Kebersihan lingkungan & keamanan       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(203, NULL, NULL, '0.00', 'Entertain       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(204, NULL, NULL, '0.00', 'Corner Block Edico ( Tanpa PC ) 30587     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(205, NULL, NULL, '0.00', 'Mullion Lidah 6879   0.408 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(206, NULL, NULL, '0.00', 'Mullion Lidah 6879   0.408 4.35', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(207, NULL, NULL, '0.00', 'Mullion Lidah 6879   0.408 4.65', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(208, NULL, NULL, '0.00', 'Mullion Lidah 6879   0.408 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(209, NULL, NULL, '0.00', 'Mullion Atachment (Tanpa PC) 6880     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(210, NULL, NULL, '0.00', 'Mullion Glass Joint 6023   0.306 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(211, NULL, NULL, '0.00', 'Mullion Glass Joint 6023   0.306 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(212, NULL, NULL, '0.00', 'Mullion Atachment (Tanpa PC) 6024     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(213, NULL, NULL, '0.00', 'U Aluminium 1\"x1\"x1.00mm 1011   0.076 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(214, NULL, NULL, '0.00', 'Trunsom Lidah 6881   0.308 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(215, NULL, NULL, '0.00', 'Capping Horizontal & Vertikal Kecil 5250   0.088 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(216, NULL, NULL, '0.00', 'Capping Horizontal Besar 9255   0.161 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(217, NULL, NULL, '0.00', 'Receiver Horizontal & Vertikal 9256   0.074 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(218, NULL, NULL, '0.00', 'Siku Aluminium 30x30x3 mm (Tanpa PC) 549     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(219, NULL, NULL, '0.00', 'M - Polos 4404   0.261 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(220, NULL, NULL, '0.00', 'M SCREW 4401   0.278 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(221, NULL, NULL, '0.00', 'STOPPER PINTU 6090R   0.075 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(222, NULL, NULL, '0.00', 'TIANG ENGSEL 5730   0.184 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(223, NULL, NULL, '0.00', 'TIANG MOHAIR 4203   0.185 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(224, NULL, NULL, '0.00', 'Laminated CL tmprd 6mm + PVB 1.14 mm + CL tmprd 6m', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(225, NULL, NULL, '0.00', 'Kusen Curtain Wall + Kaca / DC 795 Struktural Seal', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(226, NULL, NULL, '0.00', 'Kusen Curtain Wall + Kaca / DC 791 Weathershield S', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(227, NULL, NULL, '0.00', 'Bracket Besi Finish Galvanis      100x100x5mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(228, NULL, NULL, '0.00', 'Dinabolt      M12x100mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(229, NULL, NULL, '0.00', 'Karet Back Up tebal 10mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(230, NULL, NULL, '0.00', 'Karet Shim Rubber lebar 2cm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(231, NULL, NULL, '0.00', 'Karet Sirip Jendela Warna Hitam 726     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(232, NULL, NULL, '0.00', 'Karet Stopper Jendela Warna Hitam 606 A     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(233, NULL, NULL, '0.00', 'Murbaut      M10x80mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(234, NULL, NULL, '0.00', 'Setting Blok Warna Hitam       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(235, NULL, NULL, '0.00', 'Terod      M8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(236, NULL, NULL, '0.00', 'Hollow 2\" T 2mm 9914   0.2 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(237, NULL, NULL, '0.00', 'Hollow 2\" T 2mm 9914   0.2 3.9', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(238, NULL, NULL, '0.00', 'Transome V 6007   0.332 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(239, NULL, NULL, '0.00', 'Transome V 6007   0.332 3.9', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(240, NULL, NULL, '0.00', 'Transome Horizontal 5653   0.257 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(241, NULL, NULL, '0.00', 'Transome Horizontal 5653   0.257 4.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(242, NULL, NULL, '0.00', 'Transome Horizontal 5653   0.257 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(243, NULL, NULL, '0.00', 'Bead Transome 5654   0.081 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(244, NULL, NULL, '0.00', 'Bead Transome 5654   0.081 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(245, NULL, NULL, '0.00', 'Ceping 50x50 mm 9255   0.321 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(246, NULL, NULL, '0.00', 'Ceping 50x50 mm 9255   0.321 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(247, NULL, NULL, '0.00', 'Ceping 50x50 mm 9255   0.321 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(248, NULL, NULL, '0.00', 'Stopper Jendela 6733   0.145 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(249, NULL, NULL, '0.00', 'Bolt Nut      M10x75mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(250, NULL, NULL, '0.00', 'Bolt Nut      M8x65mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(251, NULL, NULL, '0.00', 'Bracket Besi Siku      50x50x4mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(252, NULL, NULL, '0.00', 'Bracket Besi Siku      75x75x5mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(253, NULL, NULL, '0.00', 'Bracket Mullion Type CNA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(254, NULL, NULL, '0.00', 'Cat Zinckromat       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(255, NULL, NULL, '0.00', 'PANASAP DARK BLUE 6MM Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(256, NULL, NULL, '0.00', 'PANASAP DARK BLUE 8MM Cut Size     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(257, NULL, NULL, '0.00', 'Acp Seven PVDF T. 4mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(258, NULL, NULL, '0.00', 'KACA CLEAR 8MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(259, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 12MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(260, NULL, NULL, '0.00', 'Kaca Panasap Blue Green 6mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(261, NULL, NULL, '0.00', 'Kaca Laminated Clear 6+0,76+6mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(262, NULL, NULL, '0.00', 'GOSOK KACA       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(263, NULL, NULL, '0.00', 'COAK KACA       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(264, NULL, NULL, '0.00', 'LUBANG KACA       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(265, NULL, NULL, '0.00', 'Silicone ACP DC 791       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(266, NULL, NULL, '0.00', 'Silicone DC 688       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(267, NULL, NULL, '0.00', 'Bead Transome 5654   0.081 4.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(268, NULL, NULL, '0.00', 'PT 21, top center, Door Strap dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(269, NULL, NULL, '0.00', 'Bead Jendela 921R   0.138 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(270, NULL, NULL, '0.00', 'Cover Rel Stainless Steel       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(271, NULL, NULL, '0.00', 'Engsel kupu kupu ex Dekson EL 4x3x2mm sss       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(272, NULL, NULL, '0.00', 'Flastbolt Dekson 6\" Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(273, NULL, NULL, '0.00', 'Friction Stay Dekson 20\" HD       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(274, NULL, NULL, '0.00', 'Lever Handle Ex Dekson LHSR 0016 22mm sss       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(275, NULL, NULL, '0.00', 'Lockcase Roler + Cylinder Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(276, NULL, NULL, '0.00', 'Pool Handle ex dorma       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(277, NULL, NULL, '0.00', 'Rambuncis CH 428 NA Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(278, NULL, NULL, '0.00', 'Hollow 50x50 T 1.1mm 4238   0.203 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(279, NULL, NULL, '0.00', 'Hollow 50x50 T 1.1mm 4238   0.203 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(280, NULL, NULL, '0.00', 'Hollow 50x50 T 1.1mm 4238   0.203 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(281, NULL, NULL, '0.00', 'Daun Jendela 3602   0.199 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(282, NULL, NULL, '0.00', 'Clip Caping 072-SS02     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(283, NULL, NULL, '0.00', 'MULLION 12653   0.509 5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(284, NULL, NULL, '0.00', 'MULLION 12653   0.509 5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(285, NULL, NULL, '0.00', 'MULLION 12653   0.509 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(286, NULL, NULL, '0.00', 'MULLION 12653   0.509 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(287, NULL, NULL, '0.00', 'MULLION 12653   0.509 4.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(288, NULL, NULL, '0.00', 'MULLION 12653   0.509 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(289, NULL, NULL, '0.00', 'MULLION 12653   0.509 3.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(290, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(291, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(292, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(293, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(294, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 4.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(295, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(296, NULL, NULL, '0.00', 'Sub Mullion (mullionx2) 12656   0.235 3.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(297, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(298, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(299, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(300, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(301, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 4.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(302, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(303, NULL, NULL, '0.00', 'Cover Mullion ( mullionx2 ) 12655   0.046 3.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(304, NULL, NULL, '0.00', 'Fix Transome 12652   0.305 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(305, NULL, NULL, '0.00', 'Fix Transome 12652   0.305 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(306, NULL, NULL, '0.00', 'Fix Transome 12652   0.305 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(307, NULL, NULL, '0.00', 'Fix Transome 12652   0.305 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(308, NULL, NULL, '0.00', 'Fix Transome 12652   0.305 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(309, NULL, NULL, '0.00', 'Male Transome 12650   0.286 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(310, NULL, NULL, '0.00', 'Male Transome 12650   0.286 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(311, NULL, NULL, '0.00', 'Male Transome 12650   0.286 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(312, NULL, NULL, '0.00', 'Male Transome 12650   0.286 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(313, NULL, NULL, '0.00', 'Female Transome 12651   0.276 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(314, NULL, NULL, '0.00', 'Female Transome 12651   0.276 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(315, NULL, NULL, '0.00', 'Female Transome 12651   0.276 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(316, NULL, NULL, '0.00', 'Female Transome 12651   0.276 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(317, NULL, NULL, '0.00', 'Bull Nose 1803127   0.344 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(318, NULL, NULL, '0.00', 'Bull Nose 1803127   0.344 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(319, NULL, NULL, '0.00', 'Bull Nose 1803127   0.344 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(320, NULL, NULL, '0.00', 'Bull Nose 1803127   0.344 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(321, NULL, NULL, '0.00', 'Bull Nose 1803127   0.344 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(322, NULL, NULL, '0.00', 'Tutup Bull Nose PMA-04   0.394 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(323, NULL, NULL, '0.00', 'Tutup Bull Nose PMA-04   0.394 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(324, NULL, NULL, '0.00', 'Tutup Bull Nose PMA-04   0.394 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(325, NULL, NULL, '0.00', 'Tutup Bull Nose PMA-04   0.394 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(326, NULL, NULL, '0.00', 'Tutup Bull Nose PMA-04   0.394 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(327, NULL, NULL, '0.00', 'Top Stiffener / Female 784     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(328, NULL, NULL, '0.00', 'Bottom Stiffener / Male 785     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(329, NULL, NULL, '0.00', 'Antivibration Clip 787     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(330, NULL, NULL, '0.00', 'Conector Capping male female MF 9k-97420   0.224 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(331, NULL, NULL, '0.00', 'Conector Capping fix MF 9k-97413   0.202 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(332, NULL, NULL, '0.00', 'Joint Sleeve MF 12654   0.269 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(333, NULL, NULL, '0.00', 'Siku 50x50x3mm (braket transome fix) MF 536   0.2 ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(334, NULL, NULL, '0.00', 'Siku 25x25x3mm (braket transome F n M) MF 534   0.', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(335, NULL, NULL, '0.00', 'Acp 1.25 x 4.08 Reynobond 0.5 pvdf       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-12-03 12:09:30', NULL),
(336, NULL, NULL, '0.00', 'Kaca Stopsol Focus Euro Grey 8mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(337, NULL, NULL, '0.00', 'Kaca Polos 8mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(338, NULL, NULL, '0.00', 'Sealant ex DC 688       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(339, NULL, NULL, '0.00', 'Sealant Structural 983 Dow Corning (Two Part)     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(340, NULL, NULL, '0.00', 'Aluminium screw (stiffenner to main frame)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(341, NULL, NULL, '0.00', 'Aluminium Sheet    2.71 1.20mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(342, NULL, NULL, '0.00', 'Bending Aluminium Sheet       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(343, NULL, NULL, '0.00', 'Bolt Nut      M12x100mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(344, NULL, NULL, '0.00', 'Bolt Nut      M10x100mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(345, NULL, NULL, '0.00', 'Bolt Nut (Mullion ke Sub Mullion)      M8x20mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(346, NULL, NULL, '0.00', 'Bolt Nut Conector Base Caping      M6x25mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(347, NULL, NULL, '0.00', 'Bracket Besi Finish Galvanis      100x100x8mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(348, NULL, NULL, '0.00', 'Brasing Siku Finish Zincromat      30x30', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(349, NULL, NULL, '0.00', 'Cat Meni Kansai Zinckromat       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(350, NULL, NULL, '0.00', 'Dinabolt      M16x100mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(351, NULL, NULL, '0.00', 'Hollow Aluminium MF      40x40mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(352, NULL, NULL, '0.00', 'Rubber-1       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(353, NULL, NULL, '0.00', 'Rubber-2 (Mullion)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(354, NULL, NULL, '0.00', 'Rubber-3 (sub mullion & transome)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(355, NULL, NULL, '0.00', 'Rubber-4 (male transome)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(356, NULL, NULL, '0.00', 'Rubber-5 (male transome)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(357, NULL, NULL, '0.00', 'Rubber-6 (male transome)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(358, NULL, NULL, '0.00', 'Rubber-7 setting blok (transome)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(359, NULL, NULL, '0.00', 'Screw (Bracket Caping Vertical)      8 x 3/8\"', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(360, NULL, NULL, '0.00', 'Screw (Outer Frame)      6 x 3/4\"', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(361, NULL, NULL, '0.00', 'Siku (u/ brazing t=1.5m)      40x40x4mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(362, NULL, NULL, '0.00', 'SIKU ALUMINIUM 3/4\"x3/4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(363, NULL, NULL, '0.00', 'STIFFNER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(364, NULL, NULL, '0.00', 'Zincalume    0.3  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(365, NULL, NULL, '0.00', 'THINER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(366, NULL, NULL, '0.00', 'Pabrikasi CW       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(367, NULL, NULL, '0.00', 'Pasang CW       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(368, NULL, NULL, '0.00', 'Pasang BullNose       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(369, NULL, NULL, '0.00', 'Pasang ACP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(370, NULL, NULL, '0.00', 'Pasang Backing Spandril       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(371, NULL, NULL, '0.00', 'Pasang Windows Toll       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(372, NULL, NULL, '0.00', 'Pasang Fire Stop       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(373, NULL, NULL, '0.00', 'Transport Material       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(374, NULL, NULL, '0.00', 'Fee Project + Intertine       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(375, NULL, NULL, '0.00', 'Theodolite + Autolevel       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(376, NULL, NULL, '0.00', 'Scafolding       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(377, NULL, NULL, '0.00', 'Kebersihan & Keamanan Proyek       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(378, NULL, NULL, '0.00', 'KONTRAKAN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(379, NULL, NULL, '0.00', 'M POLOS 5104     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(380, NULL, NULL, '0.00', 'M POLOS 5104     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(381, NULL, NULL, '0.00', 'M POLOS 5104     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(382, NULL, NULL, '0.00', 'M POLOS 5104     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(383, NULL, NULL, '0.00', 'M SCREW 5101     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(384, NULL, NULL, '0.00', 'STOPER PINTU 6090R     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(385, NULL, NULL, '0.00', 'STOPER PINTU 6090R     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(386, NULL, NULL, '0.00', 'Hollow 100x100x2mm 216     3.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(387, NULL, NULL, '0.00', 'Hollow 100x100x2mm 216     3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(388, NULL, NULL, '0.00', 'Hollow 100x100x2mm 216     4.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(389, NULL, NULL, '0.00', 'Hollow 100x100x2mm 216     5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(390, NULL, NULL, '0.00', 'Mullion 120x50 6023     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(391, NULL, NULL, '0.00', 'JOINT SLAVE 6024     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(392, NULL, NULL, '0.00', 'HOLLOW 40X40 3201     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(393, NULL, NULL, '0.00', 'stefiner Alko A8213       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(394, NULL, NULL, '0.00', 'Siku 3/4       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(395, NULL, NULL, '0.00', 'ACP 1.22 x 4.88 Maco 0.5 pvdf       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-12-03 12:08:53', NULL),
(396, NULL, NULL, '0.00', 'kaca temp laminated 6+6 pvb1.14mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(397, NULL, NULL, '0.00', 'Sealant alumunium       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(398, NULL, NULL, '0.00', 'karet Back up       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(399, NULL, NULL, '0.00', 'Bracket 50x50 t=4 mm galvanise       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(400, NULL, NULL, '0.00', 'Perkuatan besi siku 40x40 t=4mm pj 6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(401, NULL, NULL, '0.00', 'Dinabolt M12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(402, NULL, NULL, '0.00', 'Boltn Nut m12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(403, NULL, NULL, '0.00', 'Screw 8x3/4 fabrikasi       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(404, NULL, NULL, '0.00', 'Fisher+screw 8\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(405, NULL, NULL, '0.00', 'Shim rubber (2cm)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(406, NULL, NULL, '0.00', 'karet stoper       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(407, NULL, NULL, '0.00', 'Bracket 100x80x5mm (grill)+ (kanopy)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(408, NULL, NULL, '0.00', 'besi siku u/ perkuatan acp 40x40       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(409, NULL, NULL, '0.00', 'Single tape       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(410, NULL, NULL, '0.00', 'Resibon 14\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(411, NULL, NULL, '0.00', 'KUAS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(412, NULL, NULL, '0.00', 'Pasang Kusen 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(413, NULL, NULL, '0.00', 'Pasang Canopy       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(414, NULL, NULL, '0.00', 'Pasang Grill       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(415, NULL, NULL, '0.00', 'Gondola       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(416, NULL, NULL, '0.00', 'Aluminium Siku 3/4\" T 2 mm       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(417, NULL, NULL, '0.00', 'Aluminium M Polos 5085   0.524 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(418, NULL, NULL, '0.00', 'Aluminium Open Back 5087   0.443 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(419, NULL, NULL, '0.00', 'Aluminium M Screw 5081   0.553 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(420, NULL, NULL, '0.00', 'Aluminium Sill Screw 5082   0.5 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(421, NULL, NULL, '0.00', 'Aluminium Bead Sill 5083   0.193 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(422, NULL, NULL, '0.00', 'TIANG ENGSEL 5730   0.367 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(423, NULL, NULL, '0.00', 'TIANG MOHAIR 4203   0.368 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(424, NULL, NULL, '0.00', 'TIANG POLOS 4202   0.356 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(425, NULL, NULL, '0.00', 'AMBANG ATAS 4201   0.297 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(426, NULL, NULL, '0.00', 'AMBANG BAWAH 4204   0.418 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(427, NULL, NULL, '0.00', 'Bead Pintu 6062   0.12 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(428, NULL, NULL, '0.00', 'Aluminium Stoper Pintu 6090R   0.418 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(429, NULL, NULL, '0.00', 'Aluminium U Louvre 1037   0.105 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(430, NULL, NULL, '0.00', 'Daun Louvre 7072   0.184 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(431, NULL, NULL, '0.00', 'Aluminium U Louvre 4575   0.276 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(432, NULL, NULL, '0.00', 'Aluminium Daun Louvre 9571   0.329 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(433, NULL, NULL, '0.00', 'Aluminium Hollow 4223     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(434, NULL, NULL, '0.00', 'Aluminium Mullion 6023     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(435, NULL, NULL, '0.00', 'Aluminium Stifner 610     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(436, NULL, NULL, '0.00', 'Aluminium Siku 30x30x3 mm 549     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(437, NULL, NULL, '0.00', 'Dinabolt      M10x80mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(438, NULL, NULL, '0.00', 'Dinabolt      M12x75mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(439, NULL, NULL, '0.00', 'Fisher S8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(440, NULL, NULL, '0.00', 'Kuas Cat 2\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(441, NULL, NULL, '0.00', 'Multyplex T. 9mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(442, NULL, NULL, '0.00', 'Ring Per       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(443, NULL, NULL, '0.00', 'Ring Per Ø 10       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(444, NULL, NULL, '0.00', 'Ring Per Ø 12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(445, NULL, NULL, '0.00', 'Ring Per Ø 8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(446, NULL, NULL, '0.00', 'Ring Plate       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(447, NULL, NULL, '0.00', 'Ring Plate Ø 10       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(448, NULL, NULL, '0.00', 'Ring Plate Ø 12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(449, NULL, NULL, '0.00', 'Ring Plate Ø 8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(450, NULL, NULL, '0.00', 'Screw Kayu 12x3\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(451, NULL, NULL, '0.00', 'Screw S8x3/4\" Jp/PHB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(452, NULL, NULL, '0.00', 'Screw S8x2\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(453, NULL, NULL, '0.00', 'Setting Block      10x10mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(454, NULL, NULL, '0.00', 'Single tape      28mmx12mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(455, NULL, NULL, '0.00', 'Terod      Ø 8mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(456, NULL, NULL, '0.00', 'THINER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(457, NULL, NULL, '0.00', 'Upah Pasang Cw Kaca T. 8mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(458, NULL, NULL, '0.00', 'Upah pasang cw kaca 12mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(459, NULL, NULL, '0.00', 'Upah Pasang Jendela       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(460, NULL, NULL, '0.00', 'Upah Pasang Daun Pintu Frameless       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(461, NULL, NULL, '0.00', 'Upah Pasang Grill       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(462, NULL, NULL, '0.00', 'Upah Pasang Shop front       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(463, NULL, NULL, '0.00', 'Upah Pasang Kaca 8mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(464, NULL, NULL, '0.00', 'Upah Pasang ACP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(465, NULL, NULL, '0.00', 'Upah Pasang Ceping       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(466, NULL, NULL, '0.00', 'Upah Pasang Skyligh Kaca Laminated 6+0,76+6mm     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(467, NULL, NULL, '0.00', 'Upah Pasang Louvre       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(468, NULL, NULL, '0.00', 'Upah Pasang Talang       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(469, NULL, NULL, '0.00', 'Upah Pasang Bracket Pistol Grill       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(470, NULL, NULL, '0.00', 'Upah Pasang Besi Siku       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(471, NULL, NULL, '0.00', 'Kontrakan Pekerja Asumsi 4 bln       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(472, NULL, NULL, '0.00', 'Vertical Main Frame 782     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(473, NULL, NULL, '0.00', 'Top Stiffener / Female 784     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(474, NULL, NULL, '0.00', 'Bottom Stiffener / Male 785     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(475, NULL, NULL, '0.00', 'Vertical Frame Bracket (steel 75x75) 787     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(476, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(477, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(478, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(479, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004   0.205 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(480, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004   0.205 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(481, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004   0.205 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(482, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004   0.205 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(483, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004   0.205 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(484, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(485, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(486, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(487, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(488, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(489, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(490, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(491, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(492, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(493, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(494, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(495, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(496, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(497, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(498, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(499, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(500, NULL, NULL, '0.00', 'COVER POLOS 9K-86008   0.077 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(501, NULL, NULL, '0.00', 'COVER POLOS 9K-86008   0.077 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(502, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(503, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(504, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(505, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010   0.039 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(506, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010   0.039 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(507, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(508, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(509, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(510, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742   0.22 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(511, NULL, NULL, '0.00', 'TIANG MOHER K-76814   0.206 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(512, NULL, NULL, '0.00', 'TIANG POLOS K-76813   0.206 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(513, NULL, NULL, '0.00', 'AMBANG ATAS K-76816   0.13 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(514, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815   0.249 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(515, NULL, NULL, '0.00', 'GLASS BEAD PINTU K-76817   0.043 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(516, NULL, NULL, '0.00', 'LOUVRE K-76867   0.322 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(517, NULL, NULL, '0.00', 'LOUVRE K-76867   0.322 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(518, NULL, NULL, '0.00', 'LOUVRE K-76867   0.322 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(519, NULL, NULL, '0.00', 'LOUVRE K-76867   0.322 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(520, NULL, NULL, '0.00', 'U LOUVRE K-75671   0.11 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(521, NULL, NULL, '0.00', 'U LOUVRE K-75671   0.11 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(522, NULL, NULL, '0.00', 'U LOUVRE K-75671   0.11 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(523, NULL, NULL, '0.00', 'U 1\" MF K 72736     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(524, NULL, NULL, '0.00', 'MULLION K-66142     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(525, NULL, NULL, '0.00', 'MULLION K-66142     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(526, NULL, NULL, '0.00', 'MULLION K-66142     4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(527, NULL, NULL, '0.00', 'MULLION K-66142     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(528, NULL, NULL, '0.00', 'MULLION K-66142     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(529, NULL, NULL, '0.00', 'MULLION Skyligth YS-1 K-70703     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(530, NULL, NULL, '0.00', 'MULLION Skyligth YS-1 K-70703     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(531, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(532, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(533, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732     4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(534, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(535, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(536, NULL, NULL, '0.00', 'M SCREW 5101     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(537, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(538, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(539, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733     4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(540, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(541, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(542, NULL, NULL, '0.00', 'JOINT SLAVE 9K-99760     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(543, NULL, NULL, '0.00', 'TRANSOME U/ AMBANG K-70706     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(544, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 072-SS02     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(545, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 072-SS02     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(546, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 072-SS02     4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(547, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 072-SS02     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(548, NULL, NULL, '0.00', 'RECEIVER U/ TRANSOME 072-SS02     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(549, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(550, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(551, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01     4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(552, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(553, NULL, NULL, '0.00', 'CAPPING TRANSOME 072-SS03     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(554, NULL, NULL, '0.00', 'Besi Siku      50x50mm ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(555, NULL, NULL, '0.00', 'Besi Siku 40x40x3 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(556, NULL, NULL, '0.00', 'M POLOS 9K-86002     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(557, NULL, NULL, '0.00', 'M POLOS 9K-86002     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(558, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004     5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(559, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(560, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(561, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86004     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(562, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(563, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814   0.206 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(564, NULL, NULL, '0.00', 'MULLION 6879     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(565, NULL, NULL, '0.00', 'CURTAIN WALL 6879     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(566, NULL, NULL, '0.00', 'Pasang Capping       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(567, NULL, NULL, '0.00', 'Pasang U 1\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(568, NULL, NULL, '0.00', 'Pasang Pintu Swing alumunium       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(569, NULL, NULL, '0.00', 'Upah Pasang Kaca 6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(570, NULL, NULL, '0.00', 'Upah Pasang Kaca Tempered 12mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(571, NULL, NULL, '0.00', 'Pasang Brecing       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(572, NULL, NULL, '0.00', 'Perkuatan Mullion       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(573, NULL, NULL, '0.00', 'Receiver Capping Transome 6884     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(574, NULL, NULL, '0.00', 'JOINT SLAVE 6880     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(575, NULL, NULL, '0.00', 'Pintu Sliding (DW-18 UK2482x2640 Starmas)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(576, NULL, NULL, '0.00', 'Kalsiboard      10mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(577, NULL, NULL, '0.00', 'Siku Alumunium 3/4\"x3/4\"X2.0mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(578, NULL, NULL, '0.00', 'Compound       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(579, NULL, NULL, '0.00', 'ACP 1220 x 4880       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-12-03 12:22:24', NULL),
(580, NULL, NULL, '0.00', 'Hollow Alumunium 40x40 (1 1/2)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(581, NULL, NULL, '0.00', 'Hollow Galvanis 35x30x0.6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(582, NULL, NULL, '0.00', 'Hollow Galvanis 40x40x1.6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(583, NULL, NULL, '0.00', 'Hollow Galvanis 40x40x1.6mm (hollow besi)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(584, NULL, NULL, '0.00', 'Bending Hollow Galvanis 35X35X0.6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(585, NULL, NULL, '0.00', 'SEALANT N10 EX.GE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(586, NULL, NULL, '0.00', 'Sealant Struktur SSG 4000       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(587, NULL, NULL, '0.00', 'Proteksi       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(588, NULL, NULL, '0.00', 'BACK UP TEBAL 10MM WARNA PUTIH       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(589, NULL, NULL, '0.00', 'Dinabolt      m10x70', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(590, NULL, NULL, '0.00', 'Bolt Nut dia M12X70 mm (mur baut)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(591, NULL, NULL, '0.00', 'Amplas       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(592, NULL, NULL, '0.00', 'Besi siku 50x50x4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(593, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(594, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01   0.15 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(595, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01   0.15 4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(596, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01   0.15 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(597, NULL, NULL, '0.00', 'CAPPING TIANG 072-SS01   0.15 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(598, NULL, NULL, '0.00', 'CAPPING TRANSOME 072-SS03   0.09 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(599, NULL, NULL, '0.00', 'MULLION K-66142   0.278 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(600, NULL, NULL, '0.00', 'MULLION K-66142   0.278 4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(601, NULL, NULL, '0.00', 'MULLION K-66142   0.278 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(602, NULL, NULL, '0.00', 'TRANSOME U/ AMBANG K-70706   0.21 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(603, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732   0.135 4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(604, NULL, NULL, '0.00', 'TRANSOME U/ TIANG K-70732   0.135 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(605, NULL, NULL, '0.00', 'GLASS BEAD TIANG K-70733   0.032 4.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(606, NULL, NULL, '0.00', 'U 1\" MF K-72736     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(607, NULL, NULL, '0.00', 'Bending Aluminium Sheet 1.2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(608, NULL, NULL, '0.00', 'Bending Aluminium Sheet 2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(609, NULL, NULL, '0.00', 'Aluminium Sheet 2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(610, NULL, NULL, '0.00', 'Tormax Automatic Imotion LS 2302 Series Double on ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(611, NULL, NULL, '0.00', 'Cover mesin automatic Door       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(612, NULL, NULL, '0.00', 'PT24 Ex. Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(613, NULL, NULL, '0.00', 'Pull Handle PH 802 39x1200 PSS Ex. Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(614, NULL, NULL, '0.00', 'Floorhinge BTS 84 Ex. Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(615, NULL, NULL, '0.00', 'Mesiu+Ramset+Engel Clip       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(616, NULL, NULL, '0.00', 'Spigot       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(617, NULL, NULL, '0.00', 'KACA CLEAR 8MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(618, NULL, NULL, '0.00', 'Kaca Clear Tempered 8 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(619, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 12MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(620, NULL, NULL, '0.00', 'Rockwoll Density 60       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(621, NULL, NULL, '0.00', 'Shim Rubber Warna Hitam       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(622, NULL, NULL, '0.00', 'Setting Block       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(623, NULL, NULL, '0.00', 'Bracket Besi Siku Galvanis 100X100X8mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(624, NULL, NULL, '0.00', 'FRICTION STAY FS S/S 22\" DKS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(625, NULL, NULL, '0.00', 'FRICTION STAY FS S/S 24\" DKS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(626, NULL, NULL, '0.00', 'Rambuncis HDL CH 425 L/H NA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(627, NULL, NULL, '0.00', 'Kaca Stopsol 8mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(628, NULL, NULL, '0.00', 'Kaca Clear 10 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(629, NULL, NULL, '0.00', 'Kaca Clear 6mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(630, NULL, NULL, '0.00', 'Kaca laminated clear 8+8+pvb1,14 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(631, NULL, NULL, '0.00', 'Kaca Clear 12mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(632, NULL, NULL, '0.00', 'Bor   1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(633, NULL, NULL, '0.00', 'Hollow Aluminium 20x40 (1x1/2)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(634, NULL, NULL, '0.00', 'Bracket Besi Siku 50x50x5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(635, NULL, NULL, '0.00', 'KACA SPIDER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(636, NULL, NULL, '0.00', 'HOLLOW 40X40X1MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(637, NULL, NULL, '0.00', 'Besi Siku 40x40x4 mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(638, NULL, NULL, '0.00', 'Spider 1 Kaki Type SF 8111A       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(639, NULL, NULL, '0.00', 'kaca laminated 8mm + PVB Clear 1.52mm + ClearTemp6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(640, NULL, NULL, '0.00', 'Tutup Dop Karet Hitam DIA 10mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(641, NULL, NULL, '0.00', 'Tutup Dop Hitam DIA 4cm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(642, NULL, NULL, '0.00', 'Spider 2 Kaki Type SF 8112       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(643, NULL, NULL, '0.00', 'Spider 2 Kaki Type 8112A       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(644, NULL, NULL, '0.00', 'Spider 4 Kaki Type 8114       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(645, NULL, NULL, '0.00', 'Dow Corning DC 688       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(646, NULL, NULL, '0.00', 'Pasang Kaca Spider       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(647, NULL, NULL, '0.00', 'ACP PERGOLA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(648, NULL, NULL, '0.00', 'Screw 8x1/2\" PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(649, NULL, NULL, '0.00', 'Resibon 4\" @ 20pcs       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(650, NULL, NULL, '0.00', 'Kontrakan Selama 2 Bulan Untuk 60org       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(651, NULL, NULL, '0.00', 'SEALANT DC 991       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(652, NULL, NULL, '0.00', 'Tiang / Ambang WW 10522   0.539 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(653, NULL, NULL, '0.00', 'Tiang / Ambang WW 10522   0.539 5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(654, NULL, NULL, '0.00', 'Tiang / Ambang WW 10522   0.539 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(655, NULL, NULL, '0.00', 'Cover WW 10523   0.242 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(656, NULL, NULL, '0.00', 'Glasbet WW 3317   0.141 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(657, NULL, NULL, '0.00', 'Glasbet WW 3317   0.141 5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(658, NULL, NULL, '0.00', 'Glasbet WW 3317   0.141 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(659, NULL, NULL, '0.00', 'U Jalusi 3\" 1037   0.105 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(660, NULL, NULL, '0.00', 'Jalusi 3\" 7072   0.184 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(661, NULL, NULL, '0.00', 'Aluminium M Polos 5085   0.524 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(662, NULL, NULL, '0.00', 'Aluminium M Polos 5085   0.524 3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(663, NULL, NULL, '0.00', 'Aluminium M Screw 5081   0.553 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(664, NULL, NULL, '0.00', 'Aluminium Sill Screw 5082   0.251 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(665, NULL, NULL, '0.00', 'Aluminium Sill Screw 5082   0.251 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(666, NULL, NULL, '0.00', 'Aluminium Bead Sill 5083   0.106 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(667, NULL, NULL, '0.00', 'Aluminium Bead Sill 5083   0.106 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(668, NULL, NULL, '0.00', 'M COVER 6088   0.125 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(669, NULL, NULL, '0.00', 'M COVER 6088   0.125 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(670, NULL, NULL, '0.00', 'M COVER 6088   0.125 3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(671, NULL, NULL, '0.00', 'LOUVRE 6048   0.329 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(672, NULL, NULL, '0.00', 'TIANG MOHAIR 4203   0.368 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(673, NULL, NULL, '0.00', 'Hollow 2\" T 2mm 9914   0.2 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(674, NULL, NULL, '0.00', 'Hollow 2\" T 2mm 9914   0.2 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(675, NULL, NULL, '0.00', 'Aluminium Siku 3/4\" T 2 mm 9911   0.076 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(676, NULL, NULL, '0.00', 'POWDER COATING 10522     4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(677, NULL, NULL, '0.00', 'POWDER COATING 10522     5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(678, NULL, NULL, '0.00', 'POWDER COATING 10522     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(679, NULL, NULL, '0.00', 'POWDER COATING 10523     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(680, NULL, NULL, '0.00', 'POWDER COATING 3317     4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(681, NULL, NULL, '0.00', 'POWDER COATING 3317     5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(682, NULL, NULL, '0.00', 'POWDER COATING 3317     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(683, NULL, NULL, '0.00', 'POWDER COATING 1037     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(684, NULL, NULL, '0.00', 'POWDER COATING 7072     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(685, NULL, NULL, '0.00', 'POWDER COATING 5085     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(686, NULL, NULL, '0.00', 'POWDER COATING 5085     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(687, NULL, NULL, '0.00', 'POWDER COATING 5085     3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(688, NULL, NULL, '0.00', 'POWDER COATING 5081     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(689, NULL, NULL, '0.00', 'POWDER COATING 5081     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(690, NULL, NULL, '0.00', 'POWDER COATING 10522     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(691, NULL, NULL, '0.00', 'POWDER COATING 10522     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(692, NULL, NULL, '0.00', 'POWDER COATING 5083     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(693, NULL, NULL, '0.00', 'POWDER COATING 5083     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(694, NULL, NULL, '0.00', 'POWDER COATING 6088     3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(695, NULL, NULL, '0.00', 'POWDER COATING 6088     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(696, NULL, NULL, '0.00', 'POWDER COATING 6088     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(697, NULL, NULL, '0.00', 'POWDER COATING 11540     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(698, NULL, NULL, '0.00', 'POWDER COATING 4575     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(699, NULL, NULL, '0.00', 'POWDER COATING 6048     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(700, NULL, NULL, '0.00', 'POWDER COATING 3602     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(701, NULL, NULL, '0.00', 'POWDER COATING 3604     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(702, NULL, NULL, '0.00', 'POWDER COATING 5730     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(703, NULL, NULL, '0.00', 'POWDER COATING 4203     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(704, NULL, NULL, '0.00', 'POWDER COATING 4203     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(705, NULL, NULL, '0.00', 'POWDER COATING 4202     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(706, NULL, NULL, '0.00', 'POWDER COATING 4201     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(707, NULL, NULL, '0.00', 'POWDER COATING 4201     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(708, NULL, NULL, '0.00', 'POWDER COATING 6062     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(709, NULL, NULL, '0.00', 'POWDER COATING 6090R     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(710, NULL, NULL, '0.00', 'POWDER COATING 9914     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(711, NULL, NULL, '0.00', 'POWDER COATING 9914     5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(712, NULL, NULL, '0.00', 'POWDER COATING 9914     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(713, NULL, NULL, '0.00', 'POWDER COATING 9911     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(714, NULL, NULL, '0.00', 'UPAH PASANG KACA 12mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(715, NULL, NULL, '0.00', 'alum & acp       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(716, NULL, NULL, '0.00', 'Screw 6x2 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(717, NULL, NULL, '0.00', 'KARET SIRIP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(718, NULL, NULL, '0.00', 'AUTOMATIC DOOR EX MANUSA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(719, NULL, NULL, '0.00', 'Back Up Hitam T. 10 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(720, NULL, NULL, '0.00', 'Silicone       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(721, NULL, NULL, '0.00', 'KACA PANASAP EURO GREY 6MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(722, NULL, NULL, '0.00', 'MULLION 6023   0.306 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(723, NULL, NULL, '0.00', 'TRANSOME U/ TIANG 6008   0.206 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(724, NULL, NULL, '0.00', 'TRANSOME U/ TIANG 6008   0.206 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(725, NULL, NULL, '0.00', 'Transome V 6007   0.332 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(726, NULL, NULL, '0.00', 'BRACKET Z 6005     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(727, NULL, NULL, '0.00', 'KACA TEMPERED POLOS 12mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(728, NULL, NULL, '0.00', 'Acp Seven 0.5 PVDF 122x488       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(729, NULL, NULL, '0.00', 'ALUMINIUM SHEET T= 1,2mm 122x244       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(730, NULL, NULL, '0.00', 'Patch Fitting : Dekson - PT 10, PT 20 , PT 24     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(731, NULL, NULL, '0.00', 'Kunci Dekson - US 10       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(732, NULL, NULL, '0.00', 'PULL HANDLE DEKKSON SQ PH DL801 30x15x600 SSS     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(733, NULL, NULL, '0.00', 'Floorhinge BTS 75 Ex. DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(734, NULL, NULL, '0.00', 'Aluminium screw (panel to stiffenner)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(735, NULL, NULL, '0.00', 'Bracket siku 75x75x7mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(736, NULL, NULL, '0.00', 'Dinabolt M14       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(737, NULL, NULL, '0.00', 'Sealant mullion       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(738, NULL, NULL, '0.00', 'Sealant transome       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(739, NULL, NULL, '0.00', 'Paper tape       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(740, NULL, NULL, '0.00', 'Pasang pintu FR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(741, NULL, NULL, '0.00', 'Hollow 38x38 MF       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(742, NULL, NULL, '0.00', 'Braket Siku 40x40x4mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(743, NULL, NULL, '0.00', 'Bolt Nut M8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(744, NULL, NULL, '0.00', 'Aluminium Siku 30x30x3 mm 549   0.121 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(745, NULL, NULL, '0.00', 'Kaca Clear Lami 6+6 (12) mm Ex. Asahimas       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(746, NULL, NULL, '0.00', 'Bracket U 50x50 T= 5mm galvanise       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(747, NULL, NULL, '0.00', 'Pasang Sky Light Kaca       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(748, NULL, NULL, '0.00', 'Mullion 50x100x2mm 6023     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(749, NULL, NULL, '0.00', 'SKYLIGHT & KANOPI KACA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(750, NULL, NULL, '0.00', 'Mullion 50x100x2mm 6023   0.306 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(751, NULL, NULL, '0.00', 'Siku 40x40x4mm 558   0.16 1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(752, NULL, NULL, '0.00', 'ACP REYNOBOND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(753, NULL, NULL, '0.00', 'POWDER COATING 6023   1.618 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(754, NULL, NULL, '0.00', 'POWDER COATING 558     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(755, NULL, NULL, '0.00', 'GF, SKY LIGHT, & ACP MIRROR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(756, NULL, NULL, '0.00', 'Kawat Las       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(757, NULL, NULL, '0.00', 'Vertical Main Frame 782     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(758, NULL, NULL, '0.00', 'Vertical Main Frame 784     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(759, NULL, NULL, '0.00', 'Vertical Main Frame 785     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(760, NULL, NULL, '0.00', 'Mullion 50x100x2mm 6023   0.306 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(761, NULL, NULL, '0.00', 'POWDER COATING 6023   1.618 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(762, NULL, NULL, '0.00', 'POWDER COATING 6024   1.455 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(763, NULL, NULL, '0.00', 'Kaca Lami Stopsol Euro Grey 6mm + PVB 1.14 + Clear', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(764, NULL, NULL, '0.00', 'Screw 6x3/4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(765, NULL, NULL, '0.00', 'Hollow Aluminium 1,5\"x1,5\"x1mm P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(766, NULL, NULL, '0.00', 'Sealant alumunium WACKER HS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(767, NULL, NULL, '0.00', 'Hollow 2\" T 2mm 9914   0.2 5.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(768, NULL, NULL, '0.00', 'Door closer       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(769, NULL, NULL, '0.00', 'Automatic Door Ex Manusa (swing)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(770, NULL, NULL, '0.00', 'Silicone WACKER WS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(771, NULL, NULL, '0.00', 'Silicone ACP WACKER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(772, NULL, NULL, '0.00', 'Upah Pasang Daun Pintu Swing       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(773, NULL, NULL, '0.00', 'KAWAT LAS RD 26    0.3  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(774, NULL, NULL, '0.00', 'KAIN MAJUN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(775, NULL, NULL, '0.00', 'Upah Pasang Sealant       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(776, NULL, NULL, '0.00', 'Cutting groving       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(777, NULL, NULL, '0.00', 'Plat Besi       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(778, NULL, NULL, '0.00', 'PAKU RIVET       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(779, NULL, NULL, '0.00', 'Tiang / Ambang WW 10522   0.539 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(780, NULL, NULL, '0.00', 'Glasbet WW 3317   0.141 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(781, NULL, NULL, '0.00', 'Glasbet WW 3317   0.141 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(782, NULL, NULL, '0.00', 'M SCREW 5081   0.553 5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(783, NULL, NULL, '0.00', 'Aluminium Sill Screw 5082   0.251 5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(784, NULL, NULL, '0.00', 'Aluminium Bead Sill 5083   0.106 5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(785, NULL, NULL, '0.00', 'COVER M 5088   0.125 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(786, NULL, NULL, '0.00', 'COVER M 5088   0.125 5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(787, NULL, NULL, '0.00', 'COVER M 5088   0.125 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(788, NULL, NULL, '0.00', 'COVER M 5088   0.125 3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(789, NULL, NULL, '0.00', 'TIANG POLOS 4202   0.356 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(790, NULL, NULL, '0.00', 'STOPER PINTU 6090R   0.12 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(791, NULL, NULL, '0.00', 'CYLINDER 70 EX WIKA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(792, NULL, NULL, '0.00', 'BRACKET SIKU 100X50 T.4mm GALVANISE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(793, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 6mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(794, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 6mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(795, NULL, NULL, '0.00', 'Bracket pistol 650x400 galvanise       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(796, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(797, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(798, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(799, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(800, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(801, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(802, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(803, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(804, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(805, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010   0.039 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(806, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(807, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(808, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015   0.039 5.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(809, NULL, NULL, '0.00', 'TIANG ENGSEL K-94391   0.182 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(810, NULL, NULL, '0.00', 'TIANG ENGSEL K-94391   0.182 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(811, NULL, NULL, '0.00', 'TIANG MOHER K-94392   0.221 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(812, NULL, NULL, '0.00', 'TIANG MOHER K-94392   0.221 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(813, NULL, NULL, '0.00', 'TIANG POLOS K-94393   0.217 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(814, NULL, NULL, '0.00', 'AMBANG ATAS K-94389   0.28 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(815, NULL, NULL, '0.00', 'AMBANG ATAS K-94390   0.32 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(816, NULL, NULL, '0.00', 'CASEMENT JENDELA K-75694   0.134 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(817, NULL, NULL, '0.00', 'GLASS BEAD JENDELA K-75696   0.054 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(818, NULL, NULL, '0.00', 'Stopper Jendela K-75693   0.079 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(819, NULL, NULL, '0.00', 'BEAD K-70705   0.054 4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(820, NULL, NULL, '0.00', 'BEAD K-70705   0.054 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(821, NULL, NULL, '0.00', 'Seting Block kaca (3 cm)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(822, NULL, NULL, '0.00', 'MOHER @100m       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(823, NULL, NULL, '0.00', 'SEALANT CW 791       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(824, NULL, NULL, '0.00', 'SEALANT CW 795       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(825, NULL, NULL, '0.00', 'Dinabolt M10 ex Viser       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(826, NULL, NULL, '0.00', 'Kalsiboard      6mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(827, NULL, NULL, '0.00', 'Kalsiboard      6mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(828, NULL, NULL, '0.00', 'Cat DULUX 1ltr= 5m2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(829, NULL, NULL, '0.00', 'PERKUATAN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(830, NULL, NULL, '0.00', 'BRACKET 50x70x70 T 4mm GALVANISE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(831, NULL, NULL, '0.00', 'HOLLOW BESI 40x60 T 2mm GALVANISE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(832, NULL, NULL, '0.00', 'U 1\"       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(833, NULL, NULL, '0.00', 'FACADE DAN INTERIOR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(834, NULL, NULL, '0.00', 'AMBANG BAWAH K-94390   0.32 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(835, NULL, NULL, '0.00', 'GOSOK MESIN       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(836, NULL, NULL, '0.00', 'SEALANT DC 791       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(837, NULL, NULL, '0.00', 'BRACKET 40X40 GALVANISE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(838, NULL, NULL, '0.00', 'al section 1 edico 27721     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(839, NULL, NULL, '0.00', 'al section 2 edico 27722     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(840, NULL, NULL, '0.00', 'siku 3x3 t=2 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(841, NULL, NULL, '0.00', 'Hollow gypsum 40x40       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(842, NULL, NULL, '0.00', 'Hollow gypsum 20x40 0.35 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(843, NULL, NULL, '0.00', 'Gypsum 12 mm knauf       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(844, NULL, NULL, '0.00', 'skrup gypsum       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(845, NULL, NULL, '0.00', 'al section 27640     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(846, NULL, NULL, '0.00', 'calsiboard 6 mm 10cm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(847, NULL, NULL, '0.00', 'Textile Tape       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(848, NULL, NULL, '0.00', 'Hollow besi 40x40 t= 2 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(849, NULL, NULL, '0.00', 'U 3/4 x 3/4       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(850, NULL, NULL, '0.00', 'BENDING TRANSOME K-70706     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(851, NULL, NULL, '0.00', 'SUNBLAST       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(852, NULL, NULL, '0.00', 'Kaca Stopsol 8 mm blue green       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(853, NULL, NULL, '0.00', 'PASANG KACA PIRAMID       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(854, NULL, NULL, '0.00', 'PASANG SHOPFRONT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(855, NULL, NULL, '0.00', 'PASANG KACA CW + SEALANT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(856, NULL, NULL, '0.00', 'PASANG CURTAIN BOX + GYPSUM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(857, NULL, NULL, '0.00', 'PASANG PARTISI CALSIBOARD AREA WINDOW STOOL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(858, NULL, NULL, '0.00', 'PASANG GRILL HOLLOW 20x100       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(859, NULL, NULL, '0.00', 'PASANG GRILL HOLLOW 50x150       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(860, NULL, NULL, '0.00', 'PASANG GRILL ELIPS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(861, NULL, NULL, '0.00', 'PASANG GUTTER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(862, NULL, NULL, '0.00', 'PASANG PINTU FRAMELESS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(863, NULL, NULL, '0.00', 'PASANG PINTU SLIDING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(864, NULL, NULL, '0.00', 'PASANG JENDELA CASEMENT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(865, NULL, NULL, '0.00', 'UPAH PASANG KACA 10MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(866, NULL, NULL, '0.00', 'Bedeng       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(867, NULL, NULL, '0.00', 'LISTRIK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(868, NULL, NULL, '0.00', 'KULI BONGKAR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(869, NULL, NULL, '0.00', 'ACP REYNOBOND       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(870, NULL, NULL, '0.00', 'SEWA SCAFOLDING & GONDOLA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(871, NULL, NULL, '0.00', 'PASANG CURTAIN WALL KACA 8MM + CAPING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(872, NULL, NULL, '0.00', 'PASANG CURTAIN WALL KACA LAMINATED 12MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(873, NULL, NULL, '0.00', 'PASANG JENDELA CURTAIN WALL TOP HUNG       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(874, NULL, NULL, '0.00', 'SEWA SITE OFFICE + GUDANG       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(875, NULL, NULL, '0.00', 'Screw 6x3/4\" PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(876, NULL, NULL, '0.00', 'SPANDEK BLUE SCOPE       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(877, NULL, NULL, '0.00', 'SPANDEK BLUE SCOPE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(878, NULL, NULL, '0.00', 'triplek       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(879, NULL, NULL, '0.00', 'SEALANT DC 795       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(880, NULL, NULL, '0.00', 'MULLION K-66142   0.278 4.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(881, NULL, NULL, '0.00', 'P & P PINTU & JENDELA ALUMUNIUM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(882, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(883, NULL, NULL, '0.00', 'M POLOS 9K-86002   0.188 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(884, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(885, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(886, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(887, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(888, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(889, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(890, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(891, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(892, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(893, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(894, NULL, NULL, '0.00', 'COVER M 9K-86007   0.06 5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(895, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(896, NULL, NULL, '0.00', 'COVER ALUR 9k-86030   0.04 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(897, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742   0.22 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(898, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742   0.22 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(899, NULL, NULL, '0.00', 'TIANG MOHER K-76814   0.206 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(900, NULL, NULL, '0.00', 'TIANG MOHER K-76814   0.206 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(901, NULL, NULL, '0.00', 'TIANG POLOS K-76813   0.206 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(902, NULL, NULL, '0.00', 'TIANG POLOS K-76813   0.206 4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(903, NULL, NULL, '0.00', 'AMBANG BAWAH K-76817   0.043 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(904, NULL, NULL, '0.00', 'Kaca Polos 6 mm        1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(905, NULL, NULL, '0.00', 'Kaca Clear 10 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(906, NULL, NULL, '0.00', 'Kaca Tempered 12mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(907, NULL, NULL, '0.00', 'Film Sunblast       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(908, NULL, NULL, '0.00', 'Sealant alumunium       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(909, NULL, NULL, '0.00', 'Karet Back up kusen 1cm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(910, NULL, NULL, '0.00', 'Karet Back up kaca       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(911, NULL, NULL, '0.00', 'Pasang Shopfront 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(912, NULL, NULL, '0.00', 'BEAD MULLION K-70704   0.08 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(913, NULL, NULL, '0.00', 'BEAD MULLION K-70704   0.08 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(914, NULL, NULL, '0.00', 'Sealant Kaca       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(915, NULL, NULL, '0.00', 'Joint Sleeve MF K-70702     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(916, NULL, NULL, '0.00', 'CAPPING 5207   0.19 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(917, NULL, NULL, '0.00', 'CAPPING 5207   0.19 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(918, NULL, NULL, '0.00', 'BRACKET ALM U 1028   0.174 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(919, NULL, NULL, '0.00', 'U PENUTUP 8242   0.083 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(920, NULL, NULL, '0.00', 'Kaca laminated 12mm (clear 6+ pvb 0.76+ clear 6)  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(921, NULL, NULL, '0.00', 'MULLION K-70703   0.166 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(922, NULL, NULL, '0.00', 'MULLION K-70703   0.166 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(923, NULL, NULL, '0.00', 'M SCREW 9K-86001   0.188 4.55', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(924, NULL, NULL, '0.00', 'M BEAD 9K-86005   0.131 4.55', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(925, NULL, NULL, '0.00', 'BEAD 9K-86009   0.057 4.55', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(926, NULL, NULL, '0.00', 'Kaca Laminted Sunergy (clear 4mm+0.76 +4mm)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(927, NULL, NULL, '0.00', 'Screw Groofing 8x3       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(928, NULL, NULL, '0.00', 'UPAH PASANG KACA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(929, NULL, NULL, '0.00', 'Kaca Laminated Sunergy (clear 5mm+0.76+5mm)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(930, NULL, NULL, '0.00', 'SPANDRIL K-75611   0.126 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(931, NULL, NULL, '0.00', 'CAPPING 072-SS03   0.09 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(932, NULL, NULL, '0.00', 'CAPPING 072-SS03   0.09 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(933, NULL, NULL, '0.00', 'Bracket U Besi 46x40x3mm (1868)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(934, NULL, NULL, '0.00', 'RECEIVER 072-SS02     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(935, NULL, NULL, '0.00', 'RECEIVER 072-SS02     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(936, NULL, NULL, '0.00', 'HOLLOW 25. 4X50.8 K-72730   0.152 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(937, NULL, NULL, '0.00', 'JASA BENDING PLAT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(938, NULL, NULL, '0.00', 'UPAH PASANG RANGKA ACP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(939, NULL, NULL, '0.00', 'STOPPER 16015   0.127 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(940, NULL, NULL, '0.00', 'HOLLOW 20X100 29164   0.239 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(941, NULL, NULL, '0.00', 'HOLLOW 20X100 29164   0.239 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(942, NULL, NULL, '0.00', 'HOLLOW 20X100 29164   0.239 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(943, NULL, NULL, '0.00', 'Hollow 50x150 27947   0.4 5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(944, NULL, NULL, '0.00', 'Curtain Box 27721   0.222 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(945, NULL, NULL, '0.00', 'Windows Stool 27640   0.216 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(946, NULL, NULL, '0.00', 'SCREW 8x3/4 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-11-29 07:29:46', NULL),
(947, NULL, NULL, '0.00', 'Mata Resibon 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(948, NULL, NULL, '0.00', 'Curtain Box 27722   0.232 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(949, NULL, NULL, '0.00', 'Grill Hollow 40x40 MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(950, NULL, NULL, '0.00', 'MULLION 27615   2.22 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(951, NULL, NULL, '0.00', 'Cover Mulion 27617   1.85 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(952, NULL, NULL, '0.00', 'JOINT SLEEVE 27616     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(953, NULL, NULL, '0.00', 'TRANSOME 27760   1.63 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(954, NULL, NULL, '0.00', 'Hollow Aluminium 1,5\"x1,5\"x1mm P.600 4223     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(955, NULL, NULL, '0.00', 'U 3/4\"x3/4\"x1.00 mm 639     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(956, NULL, NULL, '0.00', 'Hollow 50.8x152.4x3 mm 767   2.44 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(957, NULL, NULL, '0.00', 'Hollow 10x20x1.1 mm 3209   0.36 1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(958, NULL, NULL, '0.00', 'Hollow 12.7x25.4x1 mm 4516   0.46 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(959, NULL, NULL, '0.00', 'Hollow 50.8x25.4x1.2 mm 4512   0.92 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(960, NULL, NULL, '0.00', 'Kaca Clear Tempered 8 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(961, NULL, NULL, '0.00', 'Kaca Reflektif Euro Grey Tempered 8 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(962, NULL, NULL, '0.00', 'Kaca Clear Tempered 10 mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(963, NULL, NULL, '0.00', 'Kaca Digital Printing on Extra Clear Tempered 12 m', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(964, NULL, NULL, '0.00', 'Sliding Door Type 90W       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(965, NULL, NULL, '0.00', 'Pull Handle PH SQ DL802 30x20x1800 SSS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(966, NULL, NULL, '0.00', 'Kunci 8128 ex. Dekson       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(967, NULL, NULL, '0.00', 'BRACKET BESI 100x100x5 MM FINISH GALVANIS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(968, NULL, NULL, '0.00', 'CALCIBOARD 6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(969, NULL, NULL, '0.00', 'Jasa Bending Aluminium Sheet       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(970, NULL, NULL, '0.00', 'Single Tape L: 30mm T: 8mm Warna Hitem P: 5m      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(971, NULL, NULL, '0.00', 'Zincalume       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(972, NULL, NULL, '0.00', 'Alum Sheet T 1.20mm Finish Powder Coating       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(973, NULL, NULL, '0.00', 'CAT BACKING SPANDRELL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(974, NULL, NULL, '0.00', 'Aluminium Spigot 1/2\'x1\"x1mm P 6.00 MF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(975, NULL, NULL, '0.00', 'Curtain Wall Kaca Clear Tempered 8mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(976, NULL, NULL, '0.00', 'Curtain Wall Kaca Clear Tempered 10mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(977, NULL, NULL, '0.00', 'ENGSEL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(978, NULL, NULL, '0.00', 'OVERPAL & GEMBOK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(979, NULL, NULL, '0.00', 'KACA FRAMLESS KACA REFLEKTIF 8MM TEMPERED       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(980, NULL, NULL, '0.00', 'U 3/4\"x3/4\"x1.00 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(981, NULL, NULL, '0.00', 'PASANG UNP (50x100) MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(982, NULL, NULL, '0.00', 'Gantungan Bracket Besi SIku (50x50) mm P 80cm     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(983, NULL, NULL, '0.00', 'Windows Stool       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(984, NULL, NULL, '0.00', 'Hollow 50.8x152.4x3 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(985, NULL, NULL, '0.00', 'Hollow 10x20x1.1 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(986, NULL, NULL, '0.00', 'Hollow 12.7x25.4x1 mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(987, NULL, NULL, '0.00', 'HOLLOW 25. 4X50.8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(988, NULL, NULL, '0.00', 'SEALANT KACA FRAMELESS & SCREEN A & B       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(989, NULL, NULL, '0.00', 'U 1/2 P 6.00       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(990, NULL, NULL, '0.00', 'M POLOS 11302   0.228 4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(991, NULL, NULL, '0.00', 'M SCREW 11301   0.228 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(992, NULL, NULL, '0.00', 'M BEAD 11303   0.194 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(993, NULL, NULL, '0.00', 'BEAD 11309   0.048 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(994, NULL, NULL, '0.00', 'COVER M 11307   0.104 5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(995, NULL, NULL, '0.00', 'STOPPER PINTU 6090R   0.148 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(996, NULL, NULL, '0.00', 'U 3/4 x 3/4       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(997, NULL, NULL, '0.00', 'ALUMINIUM DAN KACA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(998, NULL, NULL, '0.00', 'Patch Fitting Set       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(999, NULL, NULL, '0.00', 'Patch Fitting PT40       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1000, NULL, NULL, '0.00', 'Pull Handle 38x350       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1001, NULL, NULL, '0.00', 'PASANG U 3/4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1002, NULL, NULL, '0.00', 'ACP PVDF ALLOY 1100 GREY WHITE EX. ALUONTOP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1003, NULL, NULL, '0.00', 'ACP PVDF ALLOY 3003 BLACK COFEE ex. Maco       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1004, NULL, NULL, '0.00', 'COVER M 27617   0.308 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1005, NULL, NULL, '0.00', 'JOINT SLEEVE       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1006, NULL, NULL, '0.00', 'TRANSOME 27760   0.272 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1007, NULL, NULL, '0.00', 'Hollow Aluminium 1,5\"x1,5\"x1mm P.600 4223   0.272 ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1008, NULL, NULL, '0.00', 'U 3/4\"x3/4\"x1.00 mm 639   0.272 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1009, NULL, NULL, '0.00', 'Hollow 50.8x152.4x3 mm 767   0.081 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1010, NULL, NULL, '0.00', 'MULLION 27615   0.081 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1011, NULL, NULL, '0.00', 'Hollow 10x20x1.1 mm 3209   0.06 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1012, NULL, NULL, '0.00', 'Hollow 12.7x25.4x1 mm 4516   0.06 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1013, NULL, NULL, '0.00', 'Hollow 50.8x25.4x1.2 mm 4512   0.131 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1014, NULL, NULL, '0.00', 'MULLION 27615   0.37 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1015, NULL, NULL, '0.00', 'terpal biru     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1016, NULL, NULL, '0.00', 'LEM PRALON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1017, NULL, NULL, '0.00', 'LEM BESI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1018, NULL, NULL, '0.00', 'DOUBLE TAPE      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1019, NULL, NULL, '0.00', 'PIPA PRALON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1020, NULL, NULL, '0.00', 'PIPA KENI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1021, NULL, NULL, '0.00', 'MULLION STICK 6010     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1022, NULL, NULL, '0.00', 'UPAH PASANG BREZING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1023, NULL, NULL, '0.00', 'SIKU 50X50X5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1024, NULL, NULL, '0.00', 'BRACKET SIKU 50X50X5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1025, NULL, NULL, '0.00', 'BRACKET SIKU 50X55X50 T 5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1026, NULL, NULL, '0.00', 'BRACKET SIKU 50X80X50 T 5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1027, NULL, NULL, '0.00', 'BRACKET SIKU 95X75X70 T 5mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1028, NULL, NULL, '0.00', 'SCREW 8 X 2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1029, NULL, NULL, '0.00', 'FLUSH HANDLE KEND FPP.75.01 US32D       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1030, NULL, NULL, '0.00', 'REL ATAS COBURN 1-12-3M AL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1031, NULL, NULL, '0.00', 'REL BAWAH COBURN SERIE 100-1M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1032, NULL, NULL, '0.00', 'BREKET SAMPING COBURN 1-005       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1033, NULL, NULL, '0.00', 'BAUT BREKET 12MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1034, NULL, NULL, '0.00', 'RODA ATAS COBURN 1-246       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1035, NULL, NULL, '0.00', 'PENAHAN BAWAH COBURN 42-371       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1036, NULL, NULL, '0.00', 'SKRUP ROOVING 2\'       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1037, NULL, NULL, '0.00', 'Mullion 50x100x2mm 6023   0.306 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1038, NULL, NULL, '0.00', 'Transome Horizontal 5653   0.257 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1039, NULL, NULL, '0.00', 'Bead Transome 5654   0.081 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1040, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 9442     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1041, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 9442     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1042, NULL, NULL, '0.00', 'RECEIVER U/ TIANG 9442     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1043, NULL, NULL, '0.00', 'RECEIVER U/ AMBANG 9442     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1044, NULL, NULL, '0.00', 'CAPPING 9255     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1045, NULL, NULL, '0.00', 'CAPPING 9255     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1046, NULL, NULL, '0.00', 'CAPPING 9255     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1047, NULL, NULL, '0.00', 'CAPPING 9255     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1048, NULL, NULL, '0.00', 'WASHER PLATE 40x40 P 3 MM GALVANIS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1049, NULL, NULL, '0.00', 'BESI CNP 65x150 MM P.6 M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1050, NULL, NULL, '0.00', 'CAPPING TIANG (50x100) 11590     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1051, NULL, NULL, '0.00', 'LEVER HANDLE (MTS IL + ESCN + CYL) 84030 DEK      ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1052, NULL, NULL, '0.00', 'BOLT NUT M10 X 60       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1053, NULL, NULL, '0.00', 'SCREW 8 X 3/4 STAINLESS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1054, NULL, NULL, '0.00', 'FLUSHBOLT 12 DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1055, NULL, NULL, '0.00', 'BOLT NUT M10 X 70       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1056, NULL, NULL, '0.00', 'U ALUMINIUM 9,5x9,5x0,95 MM 1002     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1057, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 50,8x152,4x3 MM 767     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1058, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 12.7x12.7x0.90 MM 4508     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1059, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 25.4x101.6x1.20 MM 4225     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1060, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 25.4x50.8x1 MM 4587     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1061, NULL, NULL, '0.00', 'AMBANG ATAS 4201     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1062, NULL, NULL, '0.00', 'AMBANG BAWAH 4204     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1063, NULL, NULL, '0.00', 'TIANG LOCKASE 4202     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1064, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1065, NULL, NULL, '0.00', 'SCREW 6 X 1/2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1066, NULL, NULL, '0.00', 'MATA GERINDA WD TEBAL 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1067, NULL, NULL, '0.00', 'MATA GERINDA WD TIPIS 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1068, NULL, NULL, '0.00', 'ACP ALUCOBEST       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-12-03 12:44:55', NULL),
(1069, NULL, NULL, '0.00', 'CW, WW, & ACP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1070, NULL, NULL, '0.00', 'HOLLOW GALVANISE 40x40       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1071, NULL, NULL, '0.00', 'TRIPLEK 6MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1072, NULL, NULL, '0.00', 'SCREW GYPSUM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1073, NULL, NULL, '0.00', 'MEJA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1074, NULL, NULL, '0.00', 'KURSI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1075, NULL, NULL, '0.00', 'KABEL 1.5 MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1076, NULL, NULL, '0.00', 'STECKER (COLOKAN)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1077, NULL, NULL, '0.00', 'TERMINAL LUBANG 4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1078, NULL, NULL, '0.00', 'LAMPU TL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1079, NULL, NULL, '0.00', 'AMBANG TENGAH K-94380     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1080, NULL, NULL, '0.00', 'ALUMINIUM U\'\' K-72736     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1081, NULL, NULL, '0.00', 'TIANG LOUVRE K-75671     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1082, NULL, NULL, '0.00', 'Daun Louvre K-76867     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1083, NULL, NULL, '0.00', 'BESI SIKU 50x50x3MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1084, NULL, NULL, '0.00', 'APAR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1085, NULL, NULL, '0.00', 'CAT VINILEX       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1086, NULL, NULL, '0.00', 'GLASS D. HANDLE GHD 0003 D32 X 300 MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1087, NULL, NULL, '0.00', 'LOCKCASE KEND K 877738-25 US 32D       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1088, NULL, NULL, '0.00', 'CYLINDER KEND 08610-10 US 14       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1089, NULL, NULL, '0.00', 'FLUSH BOLT KEND 333 12\" US 14       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1090, NULL, NULL, '0.00', 'FLUSH BOLT KEND 333 6\" US 14       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1091, NULL, NULL, '0.00', 'HINGE GRIFF 1902 SS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1092, NULL, NULL, '0.00', 'LEVER HANDLE GRIFF 1225/2510/2511-F1       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1093, NULL, NULL, '0.00', 'LOCKCASE GRIFF 2110.00 SS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1094, NULL, NULL, '0.00', 'CYLINDER GRIFF 3301.60 SM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1095, NULL, NULL, '0.00', 'DOORCLOSER GRIFF 78 SA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1096, NULL, NULL, '0.00', 'HOLLOW BESI 100X100X3mm P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1097, NULL, NULL, '0.00', 'BRACKET BESI 70X115X70 T 5mm GALVANISE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1098, NULL, NULL, '0.00', 'Tiang / Ambang WW 7322     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1099, NULL, NULL, '0.00', 'Tiang / Ambang WW       4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1100, NULL, NULL, '0.00', 'Cover WW 7323     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1101, NULL, NULL, '0.00', 'Cover WW 7323     4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1102, NULL, NULL, '0.00', 'Cover WW 7323     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1103, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 3604     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1104, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 3604     4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1105, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 3604     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1106, NULL, NULL, '0.00', 'JOINT SLEEVE 6024     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1107, NULL, NULL, '0.00', 'TRANSOME 6007     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1108, NULL, NULL, '0.00', 'RECEIVER U/ TRANSOME 9256     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1109, NULL, NULL, '0.00', 'RECEIVER U/ TRANSOME 9256     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1110, NULL, NULL, '0.00', 'Tiang / Ambang WW 7322     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1111, NULL, NULL, '0.00', 'JOINT SLEEVE 6024     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1112, NULL, NULL, '0.00', 'HOLLOW 20X40X1.2 9597     3.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1113, NULL, NULL, '0.00', 'KAWAT WAYER @25kg       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1114, NULL, NULL, '0.00', 'SCREW 8 X 1       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1115, NULL, NULL, '0.00', 'PLASTIK COR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1116, NULL, NULL, '0.00', 'PILOX MERAH       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1117, NULL, NULL, '0.00', 'METERAN @5m       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1118, NULL, NULL, '0.00', 'SCREW 8 X 1 1/2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1119, NULL, NULL, '0.00', 'BOLTNUT M10 X 110       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1120, NULL, NULL, '0.00', 'CAT SEIV SILVER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1121, NULL, NULL, '0.00', 'KARET TRANSOME 448 HITAM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1122, NULL, NULL, '0.00', 'CLEAN PROFILE 9K-86016     5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1123, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1124, NULL, NULL, '0.00', 'Bead Pintu K-76817     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1125, NULL, NULL, '0.00', 'BOLTNUT M10X80       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1126, NULL, NULL, '0.00', 'TIANG ENGSEL K-94391     5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1127, NULL, NULL, '0.00', 'ASDRAT M8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1128, NULL, NULL, '0.00', 'RING M8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1129, NULL, NULL, '0.00', 'MUR M8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1130, NULL, NULL, '0.00', 'JENDELA SLIDING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1131, NULL, NULL, '0.00', 'OPEN BACK SKRUP 4403     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1132, NULL, NULL, '0.00', 'TIANG KUSEN 11284     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1133, NULL, NULL, '0.00', 'REL ATAS 11285     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1134, NULL, NULL, '0.00', 'REL BAWAH 11286     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1135, NULL, NULL, '0.00', 'FRAME 11282     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1136, NULL, NULL, '0.00', 'FRAME KAIT 11281     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1137, NULL, NULL, '0.00', 'AMBANG ATAS 11283     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1138, NULL, NULL, '0.00', 'AMBANG BAWAH 11287     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1139, NULL, NULL, '0.00', 'RODA SLIDING RSD BESAR EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1140, NULL, NULL, '0.00', 'CRESENT LOCK CL 393 WHITE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1141, NULL, NULL, '0.00', 'SCREW ROOVING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1142, NULL, NULL, '0.00', 'BESI HOLLOW 40x40x0.6 MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1143, NULL, NULL, '0.00', 'BESI SIKU 50x50x5 MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1144, NULL, NULL, '0.00', 'BESI HOLLOW GALV 40x40x1MM FULL P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1145, NULL, NULL, '0.00', 'MURBAUT M6 X 80       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1146, NULL, NULL, '0.00', 'MUR M6       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1147, NULL, NULL, '0.00', 'RING M6       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1148, NULL, NULL, '0.00', 'DINABOLT M10 X 48       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1149, NULL, NULL, '0.00', 'SKRUP 8X2 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1150, NULL, NULL, '0.00', 'FISHER S6       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1151, NULL, NULL, '0.00', 'SKRUP 8 X 1/2 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1152, NULL, NULL, '0.00', 'SKRUP 6 X 3/8 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1153, NULL, NULL, '0.00', 'BESI WF 150 X 7.5 T5MM P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1154, NULL, NULL, '0.00', 'BESI PIPA DIA 3\' T3MM P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1155, NULL, NULL, '0.00', 'SELING BAJA DIA 8MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1156, NULL, NULL, '0.00', 'SKRUP 8 X 1 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1157, NULL, NULL, '0.00', 'MURBAUT M8X75       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1158, NULL, NULL, '0.00', 'BEAD MULLION 27516   0.074 6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1159, NULL, NULL, '0.00', 'RECEIVER 27515     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1160, NULL, NULL, '0.00', 'DYNABOLT M12X7.5       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1161, NULL, NULL, '0.00', 'Siku 3/4       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1162, NULL, NULL, '0.00', 'HOLLOW 20X40 P.600       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1163, NULL, NULL, '0.00', 'DYNABOLT M12X55       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1164, NULL, NULL, '0.00', 'DOUBLE GLASS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1165, NULL, NULL, '0.00', 'SCREW 12X4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1166, NULL, NULL, '0.00', 'RESIBON POTONG 4\'\' @10PCS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1167, NULL, NULL, '0.00', 'PULL HANDLE PH 32X600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1168, NULL, NULL, '0.00', 'P & P PINTU & KUSEN ALUMINIUM KACA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1169, NULL, NULL, '0.00', 'P & P FASAD ALUMINIUM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1170, NULL, NULL, '0.00', 'PLAT SHEET 1220X2440X2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1171, NULL, NULL, '0.00', 'M POLOS 9K-86002     4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1172, NULL, NULL, '0.00', 'TIANG ENGSEL & KUNCI K-97901     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1173, NULL, NULL, '0.00', 'AMBANG ATAS & BAWAH K-97902     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1174, NULL, NULL, '0.00', 'BEAD TIANG ENGSEL K-97905     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1175, NULL, NULL, '0.00', 'MURBAUT M8 X 60       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1176, NULL, NULL, '0.00', 'TIANG STOPER 9K-92319     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1177, NULL, NULL, '0.00', 'MURBAUT M10 X 100       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1178, NULL, NULL, '0.00', 'BEAD KACA K-97908     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1179, NULL, NULL, '0.00', 'SKRUP 10 X 3 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1180, NULL, NULL, '0.00', 'Kalsiboard       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1181, NULL, NULL, '0.00', 'Backing Spandrell       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1182, NULL, NULL, '0.00', 'POLICE LINE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1183, NULL, NULL, '0.00', 'CAT JOTA SHIELD 1860       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1184, NULL, NULL, '0.00', 'BULU ROLL CAT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1185, NULL, NULL, '0.00', 'HOLLOW BESI 40X40 P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1186, NULL, NULL, '0.00', 'CLEAN PROFILE 9K-86016     5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1187, NULL, NULL, '0.00', 'CLEAN PROFILE 9K-86016     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1188, NULL, NULL, '0.00', 'M BEAD 9K-86005     5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1189, NULL, NULL, '0.00', 'M BEAD 9K-86005     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1190, NULL, NULL, '0.00', 'BEAD 9K-86009     5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1191, NULL, NULL, '0.00', 'BEAD 9K-86009     5.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1192, NULL, NULL, '0.00', 'AMBANG ATAS K-76816     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1193, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010     5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1194, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1195, NULL, NULL, '0.00', 'KACA LAMINATED CLEAR (4+0.38+4)       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1196, NULL, NULL, '0.00', 'UPAH PASANG KACA LAMINATED CLEAR (4+0.38+4)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1197, NULL, NULL, '0.00', 'SHIMREK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1198, NULL, NULL, '0.00', 'SCREW 3X12 GALV       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1199, NULL, NULL, '0.00', 'GLASS CLEANER       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1200, NULL, NULL, '0.00', 'BRACKET 100X100X70 T.6mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1201, NULL, NULL, '0.00', 'WASHER PLAT 40X40 T. 4mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1202, NULL, NULL, '0.00', 'ACP SEVEN       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1203, NULL, NULL, '0.00', 'USUK / CNP T 0.75 P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1204, NULL, NULL, '0.00', 'RENG       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1205, NULL, NULL, '0.00', 'PLASTIK SAMPAH       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1206, NULL, NULL, '0.00', 'ACP GREY RAL QS 7015 4MM 1220 X 4880MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1207, NULL, NULL, '0.00', 'ACP SUB SILVER QS 3102 PVDF 0.5MM 1220x4880MM     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1208, NULL, NULL, '0.00', 'PULL HANDLE DL 802 32X800X600 PSS+SSS EX DEKSON   ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1209, NULL, NULL, '0.00', 'DOOR CLOSER 522 NA EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1210, NULL, NULL, '0.00', 'P & P KUSEN ALM, ACP DAN KANOPI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1211, NULL, NULL, '0.00', 'M POLOS 9K-86002     5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1212, NULL, NULL, '0.00', 'SINGLE TAPE PUTIH 5MM X 12MM X 5M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1213, NULL, NULL, '0.00', 'SINGLE TAPE PUTIH 5MM X 20MM X 5M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1214, NULL, NULL, '0.00', 'SINGLE TAPE HITAM 6MM X 40MM X 5M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1215, NULL, NULL, '0.00', 'SINGLE TAPE PUTIH 8MM X 17MM X 5M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1216, NULL, NULL, '0.00', 'MUR M12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1217, NULL, NULL, '0.00', 'RING M12       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1218, NULL, NULL, '0.00', 'DINABOLT M12 X 90       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1219, NULL, NULL, '0.00', 'HINGES ESS EL 4 X 3 X 2 2BB SSS DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1220, NULL, NULL, '0.00', 'CYL DC DL 60MM SN EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1221, NULL, NULL, '0.00', 'DUSPROF DP 003 SS EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1222, NULL, NULL, '0.00', 'LHTR 84030 OVAL EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1223, NULL, NULL, '0.00', 'RELL 8901 D4 EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1224, NULL, NULL, '0.00', 'ROLLER RSW KECIL EX DEKSON       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1225, NULL, NULL, '0.00', 'M BEAD 9K-86005     5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1226, NULL, NULL, '0.00', 'BEAD 9K-86009     5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1227, NULL, NULL, '0.00', 'ALUM U 1/2\" K-72734     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1228, NULL, NULL, '0.00', 'AMBANG ATAS K-76816     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1229, NULL, NULL, '0.00', 'KARET BEAD MULLION @100m       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1230, NULL, NULL, '0.00', 'BESI SIKU 25 X 25 X 1.5MM P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1231, NULL, NULL, '0.00', 'TRANSOME U/ TIANG 6008     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1232, NULL, NULL, '0.00', 'SCREW 12X3 GALV       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1233, NULL, NULL, '0.00', 'SEALANT GGN BLACK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1234, NULL, NULL, '0.00', 'PRINTER EPSON L1300       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1235, NULL, NULL, '0.00', 'MEJA UNO TIPE UOD 1031       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1236, NULL, NULL, '0.00', 'RODA TROLY 300KG T4.5CM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1237, NULL, NULL, '0.00', 'HOLLOW 40 X 40 T0.35 0.4M GALV       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1238, NULL, NULL, '0.00', 'SEALANT GGN BROWN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1239, NULL, NULL, '0.00', 'WD 40       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1240, NULL, NULL, '0.00', 'CLING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1241, NULL, NULL, '0.00', 'SEALANT DC 688 WHITE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1242, NULL, NULL, '0.00', 'SEALANT DC 688 BLACK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1243, NULL, NULL, '0.00', 'SEALANT DC 991 WHITE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1244, NULL, NULL, '0.00', 'TAMBANG M12 @50M       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1245, NULL, NULL, '0.00', 'HELM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1246, NULL, NULL, '0.00', 'ROMPI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1247, NULL, NULL, '0.00', 'KACA TEMPERED SUNERGY CLEAR 10MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1248, NULL, NULL, '0.00', 'KACA TEMPERED SUNERGY CLEAR 6MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1249, NULL, NULL, '0.00', 'KACA TEMPERED SUNERGY CLEAR 10MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1250, NULL, NULL, '0.00', 'KACA SUNERGY CLEAR 10MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1251, NULL, NULL, '0.00', 'CANOPY', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1252, NULL, NULL, '0.00', 'KACA CLEAR 08 MM DARK BLUE       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1253, NULL, NULL, '0.00', 'NEXSTA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1254, NULL, NULL, '0.00', 'PE-844A NEXSTA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1255, NULL, NULL, '0.00', 'BRACKET U 25X45X25X2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1256, NULL, NULL, '0.00', 'BRACKET H 225X51X50X5mm (SISI KANAN & KIRI)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1257, NULL, NULL, '0.00', 'BRACKET H 225X51X50X5mm (SISI TENGAH)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1258, NULL, NULL, '0.00', 'WINDOW WALL 9016     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1259, NULL, NULL, '0.00', 'Cover WW 9017     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1260, NULL, NULL, '0.00', 'SHOE DOOR 11489     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1261, NULL, NULL, '0.00', 'SCREW + FISHER S8       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1262, NULL, NULL, '0.00', 'KARET SIRIP SB-01       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1263, NULL, NULL, '0.00', 'KARET STOPER 606A       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1264, NULL, NULL, '0.00', 'KALSIBOARD 8mm 1200X2400       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1265, NULL, NULL, '0.00', 'SAFETY APD & GUDANG       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1266, NULL, NULL, '0.00', 'BESI SIKU 48X48 T 4.5       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1267, NULL, NULL, '0.00', 'SEALANT IKA GLAZING N10 DARK BROWN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1268, NULL, NULL, '0.00', 'BY SEWA SCAFOLDING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1269, NULL, NULL, '0.00', 'COATING ALM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1270, NULL, NULL, '0.00', 'HOLLOW 40X40 4223     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1271, NULL, NULL, '0.00', 'HOLLOW 40X40       4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1272, NULL, NULL, '0.00', 'HOLLOW 40X40 K-76851     4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1273, NULL, NULL, '0.00', 'SCREW 8X3 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1274, NULL, NULL, '0.00', 'SCREW 10X3 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1275, NULL, NULL, '0.00', 'KACA STOPSOL SUPERSILVER FOCUS CLEAR 8MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1276, NULL, NULL, '0.00', 'SIKU ALUM 30X30 T 3mm P.600       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1277, NULL, NULL, '0.00', 'LAM 10,76MM (SUN CL 5MM + 0.76 CL + SUN CL 5MM)   ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1278, NULL, NULL, '0.00', 'KACA PANASAP BLUE GREEN 8MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1279, NULL, NULL, '0.00', 'KACA STOPSOL FOCUS BLUE GREEN 8MM       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1280, NULL, NULL, '0.00', 'WINDOW WALL 70X30X1mm 9572     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1281, NULL, NULL, '0.00', 'Cover WW 9573     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1282, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 921     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1283, NULL, NULL, '0.00', 'FRAME JENDELA 5091     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1284, NULL, NULL, '0.00', 'MULLION 100X40X1.3mm 6013     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1285, NULL, NULL, '0.00', 'DYNABOLT M10X50       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1286, NULL, NULL, '0.00', 'SEALANT DC 791 BLACK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1287, NULL, NULL, '0.00', 'SEALANT DC 791 GREY       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1288, NULL, NULL, '0.00', 'SEALANT DC 795 BLACK TURBO FOIL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1289, NULL, NULL, '0.00', 'KLOS KAYU 4X3       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1290, NULL, NULL, '0.00', 'SIKU BESI 50X50 T 3mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1291, NULL, NULL, '0.00', 'SIKU BESI 40X40 T 4mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1292, NULL, NULL, '0.00', 'LAM TEMP CL 13, 14 MM (6MM+1.14 CL+ 6MM)       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1293, NULL, NULL, '0.00', 'SEALANT GGN BLACK (SOSIS)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1294, NULL, NULL, '0.00', 'BESI SIKU 30x30 T 3 MM P.600       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1295, NULL, NULL, '0.00', 'PLAT BESI 40x150 T 1.2MM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1296, NULL, NULL, '0.00', 'M SCREW FINISH YB1 9K-86001     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1297, NULL, NULL, '0.00', 'M 1/2 SCREW FINISH YB1 9K-86005     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1298, NULL, NULL, '0.00', 'GLASS BEAD FINISH YB1 9K-86009     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1299, NULL, NULL, '0.00', 'M COVER FINISH YB1 9K-86007     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1300, NULL, NULL, '0.00', 'U LOUVRE FINISH YB1 K-75671     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1301, NULL, NULL, '0.00', 'TUTUP ALUR FINISH YB1 9k-86030     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1302, NULL, NULL, '0.00', 'U ALUMINIUM FINISH YB1 2K-466B     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1303, NULL, NULL, '0.00', 'LOUVRE BESAR FINISH YB1 K-76867     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1304, NULL, NULL, '0.00', 'STOPER PINTU FINISH YB1 9K-86015     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1305, NULL, NULL, '0.00', 'LOUVRE KECIL FINISH YB1 K-254     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1306, NULL, NULL, '0.00', 'U ALUMINIUM FINISH YB1 K-72734     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1307, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM FINISH YB1 K-98618     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1308, NULL, NULL, '0.00', 'SPANDRELL ALUMINIUM FINISH YB1 9K-99588     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1309, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM FINISH YB1 K-98607     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1310, NULL, NULL, '0.00', 'AMBANG ATAS 9K-86070     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1311, NULL, NULL, '0.00', 'STOPER JENDELA FINISH YB1 K-70780     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1312, NULL, NULL, '0.00', 'FRAME JENDELA FINISH YB1 K-75694     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1313, NULL, NULL, '0.00', 'AMBANG BAWAH 9K-86071     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1314, NULL, NULL, '0.00', 'GLASS BEAD JENDELA FINISH YB1 K-75696     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1315, NULL, NULL, '0.00', 'MULLION FINISH YB1 K-70736     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1316, NULL, NULL, '0.00', 'AMBANG ATAS FINISH YB1 9K-86070     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1317, NULL, NULL, '0.00', 'AMBANG BAWAH FINISH YB1 9K-86071     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1318, NULL, NULL, '0.00', 'BEAD MULLION FINISH YB1 K-70737     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1319, NULL, NULL, '0.00', 'TRUNSOME FINISH YB1 K-70706     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1320, NULL, NULL, '0.00', 'STOPER TIANG FINISH YB1 K-70738     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1321, NULL, NULL, '0.00', 'STOPER AMBANG FINISH YB1 K-70734     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1322, NULL, NULL, '0.00', 'FRAME JENDELA FINISH YB1 K-70710     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1323, NULL, NULL, '0.00', 'KABEL PROTECTOR TC 4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1324, NULL, NULL, '0.00', 'KUKU MACAN (CLAM SLING)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1325, NULL, NULL, '0.00', 'LAMPU TEMBAK 300 WATT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1326, NULL, NULL, '0.00', 'LAMPU TEMBAK 500 WATT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1327, NULL, NULL, '0.00', 'COVER TANDUK 7322     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1328, NULL, NULL, '0.00', 'GYPSUM A PLUS 09MM 1200X2400       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1329, NULL, NULL, '0.00', 'ACP SEVEN 0.3MM 1220 X4880X4       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1330, NULL, NULL, '0.00', 'SCREW ROOFING 8 X 3/4       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1331, NULL, NULL, '0.00', 'KUAS CAT 1 1/2       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1332, NULL, NULL, '0.00', 'BESI BEHEL 8mm FULL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1333, NULL, NULL, '0.00', 'KAYU KASO 40 X 60       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1334, NULL, NULL, '0.00', 'HOLLOW BESI 20X40 T 1.6mm GALVANIS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1335, NULL, NULL, '0.00', 'TIANG YS1C K-97901     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1336, NULL, NULL, '0.00', 'TIANG YS1C K-97901     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1337, NULL, NULL, '0.00', 'AMBANG ATAS YS1C K-97901     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1338, NULL, NULL, '0.00', 'AMBANG TENGAH YS1C K-97903     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1339, NULL, NULL, '0.00', 'AMBANG BAWAH YS1C K-97914     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1340, NULL, NULL, '0.00', 'BEAD PINTU YS1C K-97908     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1341, NULL, NULL, '0.00', 'STOPER PINTU YS1C 9K-97727     5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1342, NULL, NULL, '0.00', 'STOPER PINTU YS1C 9K-97727     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1343, NULL, NULL, '0.00', 'COVER POLOS YS1C K-97905     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1344, NULL, NULL, '0.00', 'COVER POLOS YS1C K-97905     5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1345, NULL, NULL, '0.00', 'COVER TANDUK YS1C 9K-92319     4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1346, NULL, NULL, '0.00', 'SEALANT GGN WHITE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1347, NULL, NULL, '0.00', 'SEALANT GGN GREY       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1348, NULL, NULL, '0.00', 'BY. COATING 7322 P. 600 RALL 9005 JOTUN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1349, NULL, NULL, '0.00', 'BY. COATING 7322 P. 550 RALL 9005 JOTUN       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1350, NULL, NULL, '0.00', 'KUAS 4\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1351, NULL, NULL, '0.00', 'ROLL CAT       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1352, NULL, NULL, '0.00', 'SEALANT AL SEAL 205 GREY (FOOD GRADE)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1353, NULL, NULL, '0.00', 'SEALANT AL SEAL 205 WHITE (FOOD GRADE)       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1354, NULL, NULL, '0.00', 'SCREW 8 X 1 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1355, NULL, NULL, '0.00', 'BRACKET SIKU 200X50X50 T.5MM GALVANIS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1356, NULL, NULL, '0.00', 'HOLLOW 100x50 YS-1 K-98618     4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1357, NULL, NULL, '0.00', 'HOLLOW 100x50 YS-1 K-98618     3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1358, NULL, NULL, '0.00', 'HOLLOW 100x50 YS-1 K-98618     3.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1359, NULL, NULL, '0.00', 'VERTICAL SUNSHADING       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1360, NULL, NULL, '0.00', 'BEAD JENDELA FINISH YB1 K-70735     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1361, NULL, NULL, '0.00', 'PT10, PT20, US10, PT 24 EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1362, NULL, NULL, '0.00', 'SEALANT IKA SEAL 988 GREY       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1363, NULL, NULL, '0.00', 'SEALANT IKA SEAL 988 WHITE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1364, NULL, NULL, '0.00', 'SCREW 8 X 2 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1365, NULL, NULL, '0.00', 'PAKU RIVET 450       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1366, NULL, NULL, '0.00', 'SEALANT DC 688 GRAY       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1367, NULL, NULL, '0.00', 'BEAD AMBANG TENGAH K-575     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1368, NULL, NULL, '0.00', 'GLASS BEAD 4409     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1369, NULL, NULL, '0.00', 'TUTUP M 4407     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1370, NULL, NULL, '0.00', 'Z SCREW 4402     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1371, NULL, NULL, '0.00', 'PORTAL STAINLESS STEEL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1372, NULL, NULL, '0.00', 'PORTAL STAINLESS STEEL       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1373, NULL, NULL, '0.00', 'FRICTION STAY 24\" DKS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1374, NULL, NULL, '0.00', 'HINGES 4X3X2 BB SSS DKS       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1375, NULL, NULL, '0.00', 'LEVER HANDLE LHTR 84030 SSS DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1376, NULL, NULL, '0.00', 'CYLINDER CYL DL 65mm DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1377, NULL, NULL, '0.00', 'MORTISELOCK MTS IL 84030 SSS DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1378, NULL, NULL, '0.00', 'CASEMENT HANDLE CH 425 DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1379, NULL, NULL, '0.00', 'U 3/8 482     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1380, NULL, NULL, '0.00', 'SIKU ALUMINIUM 30X30       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1381, NULL, NULL, '0.00', 'U 1/2       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1382, NULL, NULL, '0.00', 'BESI CNP 100X50X2.8mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1383, NULL, NULL, '0.00', 'HOLLOW BESI 20X40X2mm       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1384, NULL, NULL, '0.00', 'SCREW 10X3 PAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1385, NULL, NULL, '0.00', 'RAMBUNCIS 423 DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1386, NULL, NULL, '0.00', 'HOLE CAP       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1387, NULL, NULL, '0.00', 'PIVOT HINGE CPH-500 US 32D KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1388, NULL, NULL, '0.00', 'LOCKCASE K 87738-25 US 32D KEND + STRIKE PLATE    ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1389, NULL, NULL, '0.00', 'DUST PROOF STRIKE 013/12N US26 KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1390, NULL, NULL, '0.00', 'HINGE SEL0007 4X3X3 US32D KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1391, NULL, NULL, '0.00', 'CASEMENT STAY CMT 45-008 BRS US32D KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1392, NULL, NULL, '0.00', 'RAMBUNCIS 76-034 KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1393, NULL, NULL, '0.00', 'DOOR STOPPER 75-014 US14D KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1394, NULL, NULL, '0.00', 'DYNABOLT M12X80       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1395, NULL, NULL, '0.00', 'KUAS CAT 3\"       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1396, NULL, NULL, '0.00', 'PT10, PT20, US10, PT24, CYL EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1397, NULL, NULL, '0.00', 'PT30 EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1398, NULL, NULL, '0.00', 'PROTEKSI BIRU       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1399, NULL, NULL, '0.00', 'SHIMRUBBER @25m       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1400, NULL, NULL, '0.00', 'Karetp Stopper Hitam 606A       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1401, NULL, NULL, '0.00', 'Karet Sirip Hitam SB01       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1402, NULL, NULL, '0.00', 'Karet Stopper Hitam 606       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1403, NULL, NULL, '0.00', 'Karet Sirip Hitam 726       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1404, NULL, NULL, '0.00', 'Karet Stopper Hitam 0952       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1405, NULL, NULL, '0.00', 'Karet Bead Mullion Hitam 606       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1406, NULL, NULL, '0.00', 'Bracket Besi Siku 60x120x60x5 MM Finish Galvanis  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1407, NULL, NULL, '0.00', 'Klos Kayu 40x60       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1408, NULL, NULL, '0.00', 'DYNABOLT M10X60 HILTI       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1409, NULL, NULL, '0.00', 'PULL HANDLE TG-F 8355/215/SS 32X350 DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1410, NULL, NULL, '0.00', 'CASEMENT STAY 12\" EX. GRACIA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1411, NULL, NULL, '0.00', 'CASEMENT STAY 16\" EX. GRACIA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1412, NULL, NULL, '0.00', 'CASEMENT STAY 20\" EX. GRACIA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1413, NULL, NULL, '0.00', 'WINDOW LOCK NON LOCKING EX. GRACIA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1414, NULL, NULL, '0.00', 'PURE LEVER HANDLES 8906/SS OVAL SERIES+ESCUTCHEON ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1415, NULL, NULL, '0.00', 'BUTT HINGES 4\"X3\"X3MM 2BB-SS EX. DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1416, NULL, NULL, '0.00', 'DOUBLE CYLINDER PC91/61 MM EX. DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1417, NULL, NULL, '0.00', 'DOOR CLOSER TS 90 EX. DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1418, NULL, NULL, '0.00', 'LOCKCHASE DST 952/30MM-SP20-SS+BACKPLATE EX. DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1419, NULL, NULL, '0.00', 'PULL HANDLE PH DL 802 38 X 1200 DEK       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1420, NULL, NULL, '0.00', 'SEALANT GGN CLEAR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1421, NULL, NULL, '0.00', 'SIKU 25X25 T. 2mm K-256     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1422, NULL, NULL, '0.00', 'SIKU 50X50 T. 4mm       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1423, NULL, NULL, '0.00', 'SIKU 50X50 T. 4mm K-99881     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1424, NULL, NULL, '0.00', 'CASEMENT HANDLE ART 120 WHITE LOCKING EX. GRACIA  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1425, NULL, NULL, '0.00', 'SINGLE TAPE L 3cm T 3mm HITAM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1426, NULL, NULL, '0.00', 'PH GHD 0003 I US 32D D32X300 KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1427, NULL, NULL, '0.00', 'HINGE SEL0010 4X3X3 2BB KEND       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1428, NULL, NULL, '0.00', 'KACA STOPSOL HS EURO GREY 8mm       1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1429, NULL, NULL, '0.00', 'AUTOMATIC SLIDING DOOR ES 200 EASY EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1430, NULL, NULL, '0.00', 'AUTOMATIC SLIDING DOOR ES 200 EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1431, NULL, NULL, '0.00', 'ESCUTCHEON 2516 SS EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1432, NULL, NULL, '0.00', 'HINGE 1902 SS 2BB EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1433, NULL, NULL, '0.00', 'LEVER HANDLE 1225/2515 DU F1 EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1434, NULL, NULL, '0.00', 'LEVER HANDLE + ESCUTCHEON 1225/2516 F1 EX GRIFF   ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1435, NULL, NULL, '0.00', 'LOCKCASE 2110 SS EX GRIFF + STRIKE PLATE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1436, NULL, NULL, '0.00', 'DOUBLE CYLINDER 3301.60 EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1437, NULL, NULL, '0.00', 'DOOR CLOSER 78 SA EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1438, NULL, NULL, '0.00', 'FLUSH BOLT 1611 NC 8\" EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1439, NULL, NULL, '0.00', 'FLUSH BOLT 1611 NC 12\" EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1440, NULL, NULL, '0.00', 'DUST PROOF STRIKE 1618 EX GRIFF       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1441, NULL, NULL, '0.00', 'LOCKCASE 2209 SS EX GRIFF + STRIKE PLATE       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1442, NULL, NULL, '0.00', 'SINGLE TAPE UK 12MM X 10MM HITAM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1443, NULL, NULL, '0.00', 'SINGLE TAPE UK 25MM X 5MM HITAM       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1444, NULL, NULL, '0.00', 'SELANG SPIRAL 15 MTR       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1445, NULL, NULL, '0.00', 'FH BTS 75 + (PT10, PT20, US10 + CYL) EX DORMA     ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1446, NULL, NULL, '0.00', 'PT40 EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1447, NULL, NULL, '0.00', 'FH BTS 75 BO EX DORMA       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1448, NULL, NULL, '0.00', 'KLOS KAYU 40X30       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1449, NULL, NULL, '0.00', 'SCREW 6X1/2 FAB       ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1450, NULL, NULL, '0.00', 'HOLLOW 20X40 T 1.8mm       6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1451, NULL, NULL, '0.00', 'KACA CLEAR 5mm     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1452, NULL, NULL, '0.00', 'THEODOLITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1453, NULL, NULL, '0.00', 'PULL HANDLE CUSTOM STAINLESS UK 20X90X1950', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1454, NULL, NULL, '0.00', 'STIFFNER     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1455, NULL, NULL, '0.00', 'HOLLOW BESI 35X35X1.6mm P.600 GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1456, NULL, NULL, '0.00', 'ACP SEVEN (1220X2440) 0.5 5005 WHITE QS 3103     0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1457, NULL, NULL, '0.00', 'DOOR STOPPER 75-014 US14D EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1458, NULL, NULL, '0.00', 'FLUSH BOLT 333 6\" US14 EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1459, NULL, NULL, '0.00', 'FLUSH BOLT 333 12\" US14 EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1460, NULL, NULL, '0.00', 'DUST PROOF STRIKE 013/12N US26 EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1461, NULL, NULL, '0.00', 'FLUSH HANDLE FPP 75.07 US 32D EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1462, NULL, NULL, '0.00', 'SEALANT DC NETRAL + WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1463, NULL, NULL, '0.00', 'SEALANT AL SEAL 205 CLEAR (FOOD GRADE)', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1464, NULL, NULL, '0.00', 'HOLLOW 40X40X1.2 P.600     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1465, NULL, NULL, '0.00', 'HOLLOW 20X80 T 1.5mm 27650  NC 72786  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1466, NULL, NULL, '0.00', 'MULLION 50X100 T 2mm 27556  NC 72786  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1467, NULL, NULL, '0.00', 'FRICTION STAY GRACIA TOP HUNG 12\'\' SS EX WILKA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1468, NULL, NULL, '0.00', 'FRICTION STAY GRACIA TOP HUNG 16\'\' SS EX WILKA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1469, NULL, NULL, '0.00', 'FRICTION STAY GRACIA TOP HUNG 20\'\' SS EX WILKA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1470, NULL, NULL, '0.00', 'RAMBUNCIS GRACIA NON LOCKING ART 119 BROWN WILKA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1471, NULL, NULL, '0.00', 'SCREW ROOFING 8X3/4 PAB (1000 PCS)', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1472, NULL, NULL, '0.00', 'SIKU ALUMINIUM 3/4     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1473, NULL, NULL, '0.00', 'LHTR 84030 OVAL SSS + ESCN DEK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1474, NULL, NULL, '0.00', 'PLAT STRIP ALUM T 2mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1475, NULL, NULL, '0.00', 'U 3/4 x 3/4     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1476, NULL, NULL, '0.00', 'PULL HANDLE TG-F 8355/215/SS 32X450 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1477, NULL, NULL, '0.00', 'PLAT SHEET 1200 X 2400 T 2mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1478, NULL, NULL, '0.00', 'PLAT SHEET 1220 X 2440 T 2mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1479, NULL, NULL, '0.00', 'TRIPLEK 3MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1480, NULL, NULL, '0.00', 'GLASSWOLL DENSITY 48 T.25MM ( 1200 X 2300 )', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1481, NULL, NULL, '0.00', 'LEM AIBON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1482, NULL, NULL, '0.00', 'LEM FOX KUNING @12L', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1483, NULL, NULL, '0.00', 'NITOBOND EC BASE+HARDENER EP FOSROC', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1484, NULL, NULL, '0.00', 'HINGE SEL0007 4X3X2.5MM US32D EX KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1485, NULL, NULL, '0.00', 'LOCKCASE K87735-25 US 32D KEND + STRIKE PLATE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1486, NULL, NULL, '0.00', 'CASEMENTSTAY CMI 45-16\" HD BRS US32D KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1487, NULL, NULL, '0.00', 'DOORCLOSER 83210 2-4 RA SILVER KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1488, NULL, NULL, '0.00', 'REL ATAS COBURN 1-12-3M AL KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1489, NULL, NULL, '0.00', 'RODA ATAS COBURN 1-246 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1490, NULL, NULL, '0.00', 'BRACKET SAMPING COBURN 1-005 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1491, NULL, NULL, '0.00', 'BAUT BRACKET M12MM KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1492, NULL, NULL, '0.00', 'REL BAWAH COBURN SERIE 100-1M KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1493, NULL, NULL, '0.00', 'PENAHAN BAWAH COBURN 42-371 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1494, NULL, NULL, '0.00', 'LOCKCASE SLIDING AL CISA 46240-25 US14 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1495, NULL, NULL, '0.00', 'SLIDING SET P85-2M KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1496, NULL, NULL, '0.00', 'EDICO 27721  NC 72786  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1497, NULL, NULL, '0.00', 'EDICO 27722  NC 72786  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1498, NULL, NULL, '0.00', 'EDICO 12071  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1499, NULL, NULL, '0.00', 'EDICO 27640  NC 72786  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1500, NULL, NULL, '0.00', 'MURBAUT M12X130 + RING', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1501, NULL, NULL, '0.00', 'HOLLOW 100X50X1.8mm K-98618  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1502, NULL, NULL, '0.00', 'SIKU 25X25 T. 2mm K-256  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1503, NULL, NULL, '0.00', 'TRIPLEK 4mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1504, NULL, NULL, '0.00', 'REL SLIDING SL 100 EX DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1505, NULL, NULL, '0.00', 'HANDLE PINTU SLOT BT 01 SS EX SES', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1506, NULL, NULL, '0.00', 'STOPER PINTU K-75692  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1507, NULL, NULL, '0.00', 'M SCREW 9K-86001  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1508, NULL, NULL, '0.00', 'PLAT SHEET 1000X2000 T 1mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1509, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1510, NULL, NULL, '0.00', 'U ALUMINIUM K-72734  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1511, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 100 X 50 K-98618  MF  7.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1512, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 100 X 50 K-98618  MF  6.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1513, NULL, NULL, '0.00', 'U LOUVRE 2K-466B  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1514, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 100 X 50 K-98618  MF  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1515, NULL, NULL, '0.00', 'LOUVRE KECIL K-254  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1516, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  YS-1  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1517, NULL, NULL, '0.00', 'SIKU ALUMINIUM 25 X 25 K-256  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1518, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  YS-1  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1519, NULL, NULL, '0.00', 'AMBANG ATAS K-76816  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1520, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1521, NULL, NULL, '0.00', 'GLASS BEAD K-76817  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1522, NULL, NULL, '0.00', 'SHIMRUBBER', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1523, NULL, NULL, '0.00', 'Kalsiboard 1200X2400  6mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1524, NULL, NULL, '0.00', 'M SCREW 9K-86001  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1525, NULL, NULL, '0.00', 'M POLOS 9K-86002  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1526, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1527, NULL, NULL, '0.00', 'U ALUMINIUM 2K-466B  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1528, NULL, NULL, '0.00', 'STOPER PINTU K-75692  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1529, NULL, NULL, '0.00', 'M 1/2 SCREW 9K-86005  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1530, NULL, NULL, '0.00', 'GLASS BEAD 9K-86009  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1531, NULL, NULL, '0.00', 'M COVER 9K-86007  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1532, NULL, NULL, '0.00', 'TUTUP ALUR 9k-86030  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1533, NULL, NULL, '0.00', 'U ALUM 1/2\" K-72734  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1534, NULL, NULL, '0.00', 'U ALUM 1\" K-72736  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1535, NULL, NULL, '0.00', 'Stopper Jendela K-70780  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1536, NULL, NULL, '0.00', 'FRAME JENDELA K-75694  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1537, NULL, NULL, '0.00', 'GLASS BEAD K-75696  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1538, NULL, NULL, '0.00', 'SEALANT DC 991   BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1539, NULL, NULL, '0.00', 'SEALANT DC 795   BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1540, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1541, NULL, NULL, '0.00', 'U ALUMINIUM 2K-466B  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1542, NULL, NULL, '0.00', 'M 1/2 SCREW 9K-86005  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1543, NULL, NULL, '0.00', 'BEAD 9K-86009  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1544, NULL, NULL, '0.00', 'M COVER 9K-86007  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1545, NULL, NULL, '0.00', 'COVER ALUR 9k-86030  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1546, NULL, NULL, '0.00', 'LOUVRE KECIL K-254  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1547, NULL, NULL, '0.00', 'REL ATAS 9K-86065  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1548, NULL, NULL, '0.00', 'REL BAWAH 9K-86066  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1549, NULL, NULL, '0.00', 'FRAME ATAS K-75526  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1550, NULL, NULL, '0.00', 'FRAME BAWAH K-75527  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1551, NULL, NULL, '0.00', 'TIANG KIRI KANAN 9K-99715  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1552, NULL, NULL, '0.00', 'FRAME KIRI KANAN K-75528  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1553, NULL, NULL, '0.00', 'TIANG KAIT K-75529  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1554, NULL, NULL, '0.00', 'HOLLOW ALUM 20X40X1mm   MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1555, NULL, NULL, '0.00', 'M SCREW 9K-86001  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1556, NULL, NULL, '0.00', 'U ALUM 1/2\" K-72734  YK-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1557, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 100 X 50 K-98618  MF  6.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1558, NULL, NULL, '0.00', 'RODA SLIDING RSW KECIL DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1559, NULL, NULL, '0.00', 'CRESENT LOCK CL 330 DEKSON  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1560, NULL, NULL, '0.00', 'CORNER BEAD', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1561, NULL, NULL, '0.00', 'HOLLOW 40X40 K-76851  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1562, NULL, NULL, '0.00', 'FLOORHINGE BTS 80 EX DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1563, NULL, NULL, '0.00', 'TRIPLEK 9mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1564, NULL, NULL, '0.00', 'LEM MAXBOND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1565, NULL, NULL, '0.00', 'U STAINLESS 2 cm x 2 cm T 1 m P.3 HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1566, NULL, NULL, '0.00', 'SIKU 599  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1567, NULL, NULL, '0.00', 'M POLOS 11536A  ARTIC WHITE  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1568, NULL, NULL, '0.00', 'M SCREW 11536  ARTIC WHITE  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1569, NULL, NULL, '0.00', 'M SCREW 11536  ARTIC WHITE  4.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1570, NULL, NULL, '0.00', 'COVER M 11510  ARTIC WHITE  4.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1571, NULL, NULL, '0.00', 'SILL SCREW 11537  ARTIC WHITE  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1572, NULL, NULL, '0.00', 'SILL SCREW 11537  ARTIC WHITE  4.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1573, NULL, NULL, '0.00', 'BEAD SILL 11538  ARTIC WHITE  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1574, NULL, NULL, '0.00', 'STOPER PINTU 7587  ARTIC WHITE  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1575, NULL, NULL, '0.00', 'TIANG ENGSEL 5730  ARTIC WHITE  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1576, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  ARTIC WHITE  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1577, NULL, NULL, '0.00', 'AMBANG ATAS 4201  ARTIC WHITE  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1578, NULL, NULL, '0.00', 'AMBANG BAWAH 4204  ARTIC WHITE  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1579, NULL, NULL, '0.00', 'Bead Pintu 6062  ARTIC WHITE  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1580, NULL, NULL, '0.00', 'MULLION 6013  ARTIC WHITE  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1581, NULL, NULL, '0.00', 'MULLION 6013  ARTIC WHITE  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1582, NULL, NULL, '0.00', 'U LOUVRE 1037  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1583, NULL, NULL, '0.00', 'Daun Louvre 7072  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1584, NULL, NULL, '0.00', 'WINDOW WALL 9217  ARTIC WHITE  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1585, NULL, NULL, '0.00', 'WINDOW WALL 9217  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1586, NULL, NULL, '0.00', 'Cover WW 9218  ARTIC WHITE  5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1587, NULL, NULL, '0.00', 'GLASS BEAD 921R  ARTIC WHITE  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1588, NULL, NULL, '0.00', 'Daun Jendela 3602  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1589, NULL, NULL, '0.00', 'U CHANEL 1/2\" 1004  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1590, NULL, NULL, '0.00', 'TUTUP ALUR 11540  ARTIC WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1591, NULL, NULL, '0.00', 'BEAD SILL 11538  ARTIC WHITE  4.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1592, NULL, NULL, '0.00', 'U STAINLESS 1.5 cm x 1.5 cm T 1 m P.3 HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1593, NULL, NULL, '0.00', 'MUR BAUT M10X150', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1594, NULL, NULL, '0.00', 'PAKU RIVET 550', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1595, NULL, NULL, '0.00', 'U 3/4 X 1 1/2 768  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1596, NULL, NULL, '0.00', 'U 1/2 X 3 4233  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1597, NULL, NULL, '0.00', 'CYL DEC50 30+30MM DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1598, NULL, NULL, '0.00', 'AL SIKU 15 X 20 9K-90503  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1599, NULL, NULL, '0.00', 'BRACKET SIKU 100 X 50 X 70 T 6mm   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1600, NULL, NULL, '0.00', 'M POLOS 9K-86002  PW-02  3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1601, NULL, NULL, '0.00', 'M BEAD 9K-86005  PW-02  3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1602, NULL, NULL, '0.00', 'BEAD 9K-86009  PW-02  3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1603, NULL, NULL, '0.00', 'SEALANT SEAL NFLEX BOSTIK  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1604, NULL, NULL, '0.00', 'BUTIL SEALER 1 BENDERA   PUTIH  30 X 70', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1605, NULL, NULL, '0.00', 'BUTIL SEALER 2 BENDERA   PUTIH  30 X 70', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1606, NULL, NULL, '0.00', 'M POLOS 4404  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1607, NULL, NULL, '0.00', 'M COVER 4407  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1608, NULL, NULL, '0.00', 'M SCREW 4401  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1609, NULL, NULL, '0.00', 'U ALUMINIUM 4575  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1610, NULL, NULL, '0.00', 'LOUVRE 6048  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1611, NULL, NULL, '0.00', 'P & P ALUM LOUVRE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1612, NULL, NULL, '0.00', 'KACA PANASAP 6MM  GREEN  1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1613, NULL, NULL, '0.00', 'Kaca Tempered 8mm STOPSOL  FOCUS EURO GRAY  1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1614, NULL, NULL, '0.00', 'DINABOLT HLC 12X55/15 HILTI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1615, NULL, NULL, '0.00', 'Mullion 50x100x2mm 6023  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-11-29 07:29:50', NULL),
(1616, NULL, NULL, '0.00', 'Screw 6x3/4 FAB', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1617, NULL, NULL, '0.00', 'SEALANT NETRAL PLUS DOWSIL  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1618, NULL, NULL, '0.00', 'SEALANT IKA SEAL 988   BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1619, NULL, NULL, '0.00', 'DYNABOLT M10X60', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1620, NULL, NULL, '0.00', 'SEALANT DC 688   CLEAR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1621, NULL, NULL, '0.00', 'SEALANT NETRAL PLUS DOWSIL  CLEAR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1622, NULL, NULL, '0.00', 'SEALANT IKA SEAL 988  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1623, NULL, NULL, '0.00', 'SWITCH AUTOMATIC DOOR DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1624, NULL, NULL, '0.00', 'SENSOR AUTOMATIC DOOR DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1625, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1626, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1627, NULL, NULL, '0.00', 'AMBANG ATAS K-97901  YS1C  5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1628, NULL, NULL, '0.00', 'AMBANG BAWAH K-97914  YS1C  5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1629, NULL, NULL, '0.00', 'COVER TANDUK 9K-92319  YS1C  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1630, NULL, NULL, '0.00', 'SEALANT SEAL IT RIGHT   BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1631, NULL, NULL, '0.00', 'ACP DP4 UK 1.220 X 2.440 MACO  MIROR SPECULAR  0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1632, NULL, NULL, '0.00', 'ACP JY6046 UK 1.220 X 4.880 JIYU  SILVER MIRROR  0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1633, NULL, NULL, '0.00', 'SPIDER FITTING DEKSON 8212 160MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1634, NULL, NULL, '0.00', 'SPIDER FITTING DEKSON 8214 160MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1635, NULL, NULL, '0.00', 'PURE LEVER HANDEL ( L SHAPE ) 8906', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1636, NULL, NULL, '0.00', 'MORTISELOCK 281A 55MM 24MM SQUARE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1637, NULL, NULL, '0.00', 'ROLLER LATCH LOCK 232A 55MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1638, NULL, NULL, '0.00', 'HINGES 4X3X3MM 2BB 304, SSS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1639, NULL, NULL, '0.00', 'TS 68/EN/3/4/HO/SILVER', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1640, NULL, NULL, '0.00', 'POWDER COATING RALL 9005 JOTUN     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1641, NULL, NULL, '0.00', 'SEALANT DC 791   WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1642, NULL, NULL, '0.00', 'SEALANT GLAZING NETRAL HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1643, NULL, NULL, '0.00', 'U STAINLESS 5CM X 4CM X 3CM X 2.5CM T 2MM   HAIRLI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1644, NULL, NULL, '0.00', 'M SCREW 4401  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1645, NULL, NULL, '0.00', 'STOPPER TEMPEL 5959  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1646, NULL, NULL, '0.00', 'STOPPER TEMPEL 7586  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1647, NULL, NULL, '0.00', 'BRACKET SIKU 80X55X55 T5MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1648, NULL, NULL, '0.00', 'Bead Pintu K-97908  YS1C  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1649, NULL, NULL, '0.00', 'AMBANG ATAS K-97901  YS1C  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1650, NULL, NULL, '0.00', 'AMBANG BAWAH K-97914  YS1C  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1651, NULL, NULL, '0.00', 'COVER TANDUK 9K-92319  YS1C  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1652, NULL, NULL, '0.00', 'AMBANG TENGAH K-97903  YS1C  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1653, NULL, NULL, '0.00', 'karet stoper WS-10  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1654, NULL, NULL, '0.00', 'LOCKCASE DST 400+BACKPLAT DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1655, NULL, NULL, '0.00', 'BIAYA CUTTING GROVING ACP     1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1656, NULL, NULL, '0.00', 'PIPA BESI 2\'     2MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1657, NULL, NULL, '0.00', 'SCREW 8X2 FAB', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1658, NULL, NULL, '0.00', 'DINABOLT MS BOLT 12 M10X70MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1659, NULL, NULL, '0.00', 'DINABOLT MS BOLT 16 M12X80MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1660, NULL, NULL, '0.00', 'HOLLOW BESI 20X40 T0.8 P.600', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1661, NULL, NULL, '0.00', 'PULL HANDLE PP 73.06 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1662, NULL, NULL, '0.00', 'PUSH PLATE 73.07 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1663, NULL, NULL, '0.00', 'LOCKCASE ROLLER BOLT LOCK 232 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1664, NULL, NULL, '0.00', 'AKRILIK UK 1220 X 2400 T 15MM   CLEAR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1665, NULL, NULL, '0.00', 'PULLHANDLE PH DL 801 32X450 SILVER', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1666, NULL, NULL, '0.00', 'TUTUP ALUR 11540  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1667, NULL, NULL, '0.00', 'SEWA MESIN HIGH PRESSURE 120 BAR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1668, NULL, NULL, '0.00', 'SCREW ROOFING BAJA RINGAN', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1669, NULL, NULL, '0.00', 'ASBES GELOMBANG P.240', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1670, NULL, NULL, '0.00', 'KABEL NYM 2 X 1 1/2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1671, NULL, NULL, '0.00', 'KABEL SERABUT 2 X 0.75', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1672, NULL, NULL, '0.00', 'TERMINAL 3 LUBANG', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1673, NULL, NULL, '0.00', 'HANDLE SLOT GRENDEL 002 88 ONASSIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1674, NULL, NULL, '0.00', 'KASO BAJA RINGAN', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1675, NULL, NULL, '0.00', 'PLAT STAINLESS TYPE A 520X850 T 1.2   HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1676, NULL, NULL, '0.00', 'PLAT STAINLESS TYPE B 850X1000 T 1.2   HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1677, NULL, NULL, '0.00', 'PLAT STAINLESS TYPE C 220X2440 T 1.2   HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1678, NULL, NULL, '0.00', 'CAT P\'TALIT WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1679, NULL, NULL, '0.00', 'DEMPUL ISAMO HIJAU', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1680, NULL, NULL, '0.00', 'SEALANT DC 991   LIGHT GREY', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1681, NULL, NULL, '0.00', 'U ALUM 25X100 T1MM 11441  NC72786GREY METALIC SATI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1682, NULL, NULL, '0.00', 'SEALANT DC 991   GREY', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1683, NULL, NULL, '0.00', 'LATCH LFS 001P  DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1684, NULL, NULL, '0.00', 'SCOTLIGHT KAIN 5CM 3M', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1685, NULL, NULL, '0.00', 'SENTER KEPALA ( HEAD LAMP )', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1686, NULL, NULL, '0.00', 'BOX PANEL', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1687, NULL, NULL, '0.00', 'KWH METER 1 PHASE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1688, NULL, NULL, '0.00', 'STOP KONTAK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1689, NULL, NULL, '0.00', 'MCB 1 PHASE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1690, NULL, NULL, '0.00', 'STEKER', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1691, NULL, NULL, '0.00', 'KABEL 3X21/2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1692, NULL, NULL, '0.00', 'U ALUM 25X100 T1MM 11441  NC72786GREY METALIC SATI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1693, NULL, NULL, '0.00', 'TOP CENTER ( STANG FH BTS 75 ) DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1694, NULL, NULL, '0.00', 'BOTTOM STRAP ( STANG FH BTS 75 ) DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1695, NULL, NULL, '0.00', 'TANG KOMBINASI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1696, NULL, NULL, '0.00', 'KAWAT BENDRAT', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1697, NULL, NULL, '0.00', 'MATA CUTTING WD 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1698, NULL, NULL, '0.00', 'DOOR STOPER STP-FN 016 KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1699, NULL, NULL, '0.00', 'DYNABOLT M10X75', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1700, NULL, NULL, '0.00', 'STANG FLOORHINGE BTS 75 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1701, NULL, NULL, '0.00', 'STANG BTS 84 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1702, NULL, NULL, '0.00', 'CAT A 1500 4SEASON BRILIANT WHITE TOA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1703, NULL, NULL, '0.00', 'BRACKET H 130X55X50X5MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1704, NULL, NULL, '0.00', 'BRACKET H 150X55X50X5MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1705, NULL, NULL, '0.00', 'BRACKET H 170X55X50X5MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1706, NULL, NULL, '0.00', 'BRACKET H 190X55X50X5MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1707, NULL, NULL, '0.00', 'BRACKET U 25X49X25X2MM   GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1708, NULL, NULL, '0.00', 'TYPE P1 PLATSHEET UK 0.165 X 2100 T 2MM PB 80', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1709, NULL, NULL, '0.00', 'TYPE P2 PLATSHEET UK 0.325 X 2100 T 2MM PB 80', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1710, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1711, NULL, NULL, '0.00', 'AMBANG ATAS K-76816  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1712, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1713, NULL, NULL, '0.00', 'Bead Pintu K-76817  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1714, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1715, NULL, NULL, '0.00', 'ALAT TARIKAN AIR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1716, NULL, NULL, '0.00', 'GEMUK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1717, NULL, NULL, '0.00', 'WD COOL', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1718, NULL, NULL, '0.00', 'PINTU LMR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1719, NULL, NULL, '0.00', 'Kaca Clear 6mm   GREEN  1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1720, NULL, NULL, '0.00', 'LHTR 84030 SSS, CYL DL 65mm, MTS IL 84030 SSS DEK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1721, NULL, NULL, '0.00', 'DOOR CLOSER DCL300 HO NA   BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1722, NULL, NULL, '0.00', 'DOOR CLOSER PINTU', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1723, NULL, NULL, '0.00', 'SIKU ALUMINIUM 1.5\"X1.5\"X1mm   MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1724, NULL, NULL, '0.00', 'HOLLOW ALUMINIUM 1.5\"X1.5\"X1mm     6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1725, NULL, NULL, '0.00', 'HOLLOW 30X60 T 2,5MM 2978    5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1726, NULL, NULL, '0.00', 'BESI SIKU 70X70X7mm', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1727, NULL, NULL, '0.00', 'FACADE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1728, NULL, NULL, '0.00', 'CAT MENI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1729, NULL, NULL, '0.00', 'PLAT BENDING 100X20X4MM P.2400 FIN GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1730, NULL, NULL, '0.00', 'U 3/4\"x3/4\"x1.00 mm   CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1731, NULL, NULL, '0.00', 'DOUBLE TAPE 3M  HITAM  LEBAR 1\"', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1732, NULL, NULL, '0.00', 'STOPPER JENDELA CW 13031  MF  5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1733, NULL, NULL, '0.00', 'M - Polos 9K-86002  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1734, NULL, NULL, '0.00', 'M - Screw 9K-86001  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1735, NULL, NULL, '0.00', 'M - Screw 9K-86001  PB 80  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1736, NULL, NULL, '0.00', 'SILL SCREW 9K-86005  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1737, NULL, NULL, '0.00', 'SILL SCREW 9K-86005  PB 80  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1738, NULL, NULL, '0.00', 'M - Cover 9K-86007  PB 80  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1739, NULL, NULL, '0.00', 'LOUVRE k-98953  PB 80  3.7', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1740, NULL, NULL, '0.00', 'LOUVRE k-98953  PB 80  4.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1741, NULL, NULL, '0.00', 'LOUVRE k-98953  PB 80  5.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1742, NULL, NULL, '0.00', 'U LOUVRE K-252A  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1743, NULL, NULL, '0.00', 'U LOUVRE K-252A  PB 80  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1744, NULL, NULL, '0.00', 'LOUVRE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1745, NULL, NULL, '0.00', 'BRACKET BRACING BESI SIKU 40X40X4MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1746, NULL, NULL, '0.00', 'BRACKET BRACING BESI SIKU 50X50X5MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1747, NULL, NULL, '0.00', 'ACP FLAT', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1748, NULL, NULL, '0.00', 'ACP SIRIP HOLLOW ALUMUNIUM 70X200MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1749, NULL, NULL, '0.00', 'ACP SUNSCREEN 54 UNIT', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1750, NULL, NULL, '0.00', 'TALANG SS+RANGKA BESI+TRIPLEK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1751, NULL, NULL, '0.00', 'PIPA TALANG', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1752, NULL, NULL, '0.00', 'CAPPING ACP 93.71 M\'', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1753, NULL, NULL, '0.00', 'STIKER SANDBLAST', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1754, NULL, NULL, '0.00', 'CLEANING SPANDRELL CANOPY ENTRANCE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1755, NULL, NULL, '0.00', 'CLEANING SPANDRELL DI BAWAH OVERSTEK LANTAI 4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1756, NULL, NULL, '0.00', 'LIST SS TOP COPING + TRIPLEK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1757, NULL, NULL, '0.00', 'TUTUP ALUR 9k-86030  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1758, NULL, NULL, '0.00', 'STIFFNER   ALCO  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1759, NULL, NULL, '0.00', 'SEALANT IKA SEAL 1022   LIGHT GREY', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1760, NULL, NULL, '0.00', 'BACKPLAT LOCKCASE DST 952', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1761, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010  YS1C  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1762, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010  YS1C  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1763, NULL, NULL, '0.00', 'HOLLOW 40X40 30544  edico  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1764, NULL, NULL, '0.00', 'PE-844A NEXSTA 2978    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1765, NULL, NULL, '0.00', 'DOUBLE CYLINDER CYL DC DL 60MM SN EX DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1766, NULL, NULL, '0.00', 'LEVER HANDLE LHTR 0017 OVAL SSS EX DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1767, NULL, NULL, '0.00', 'FRICTION STAY TOP HUNG BP8TH EX BRISTOL', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1768, NULL, NULL, '0.00', 'FRICTION STAY TOP HUNG BP10TH EX BRISTOL', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1769, NULL, NULL, '0.00', 'FRICTION STAY TOP HUNG BP22HD-S EX BRISTOL', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1770, NULL, NULL, '0.00', 'LIGHTNING CASEMENT HANDLES TYPE RIGHT EX CHARISMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1771, NULL, NULL, '0.00', 'KARET STOPPER JENDELA FILITY 2K-22464  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1772, NULL, NULL, '0.00', 'KARET SIRIP JENDELA FILITY 2K-22280  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1773, NULL, NULL, '0.00', 'M SCREW 9K-86041  YS1C  5.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1774, NULL, NULL, '0.00', 'M POLOS 9K-86042  YS1C  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1775, NULL, NULL, '0.00', 'M 1/2 SCREW 9K-86045  YS1C  5.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1776, NULL, NULL, '0.00', 'GLASS BEAD 9K-86029  YS1C  5.85', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1777, NULL, NULL, '0.00', 'M COVER 9K-86027  YS1C  4.15', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1778, NULL, NULL, '0.00', 'OPEN BACK SCREW 9K-86043  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1779, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86044  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1780, NULL, NULL, '0.00', 'OPEN BACK COVER 9K-86028  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1781, NULL, NULL, '0.00', 'M 1/2 LOUVRE 9K-86048  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1782, NULL, NULL, '0.00', 'STOPPER PINTU 9K-86032  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1783, NULL, NULL, '0.00', 'SPANDRELL ALUMUNIUM K-75611  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1784, NULL, NULL, '0.00', 'HOLLOW ALUMUNIUM 40X60X2MM K-98612  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1785, NULL, NULL, '0.00', 'TUTUP ALUR 9K-86030  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1786, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1787, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1788, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1789, NULL, NULL, '0.00', 'GLASS BEAD K-76817  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1790, NULL, NULL, '0.00', 'M-TANDUK 9K-86061  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1791, NULL, NULL, '0.00', 'M-TANDUK TANPA COVER 9K-86064  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1792, NULL, NULL, '0.00', 'GLASS BEAD JENDELA K-75696  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1793, NULL, NULL, '0.00', 'Stopper Jendela K-70780  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1794, NULL, NULL, '0.00', 'FRAME JENDELA FILITY 9K-86105  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1795, NULL, NULL, '0.00', 'GLASSBEAD JENDELA FILITY 9K-86115  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1796, NULL, NULL, '0.00', 'CORNER BLOCK MILL FINISH JENDELA FILITY 9K-10695  ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1797, NULL, NULL, '0.00', 'U LOUVRE 2K-466B  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1798, NULL, NULL, '0.00', 'U LOUVRE KECIL K-254  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1799, NULL, NULL, '0.00', 'MORTISELOCK DST 952 DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1800, NULL, NULL, '0.00', 'MORTISELOCK DST 952 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1801, NULL, NULL, '0.00', 'Single tape UK L 10 CM  HITAM  1 CM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1802, NULL, NULL, '0.00', 'TIANG OUTHER SAMPING K-75525  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1803, NULL, NULL, '0.00', 'REL BAWAH K-75524  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1804, NULL, NULL, '0.00', 'REL ATAS K-75523  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1805, NULL, NULL, '0.00', 'AMBANG ATAS K-75526  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1806, NULL, NULL, '0.00', 'AMBANG BAWAH K-75527  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1807, NULL, NULL, '0.00', 'TIANG KAIT K-75528  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1808, NULL, NULL, '0.00', 'TIANG POLOS K-75528  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1809, NULL, NULL, '0.00', 'TIANG POLOS K-75529  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1810, NULL, NULL, '0.00', 'DYNABLOT M10X80 HILTI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1811, NULL, NULL, '0.00', 'BRACKET SIKU 100X50X50 T 4MM GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1812, NULL, NULL, '0.00', 'Daun Louvre 7072  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1813, NULL, NULL, '0.00', 'U LOUVRE 1037  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1814, NULL, NULL, '0.00', 'BRACKET U 25X50X49 T2MM GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1815, NULL, NULL, '0.00', 'U LOUVRE 1080  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1816, NULL, NULL, '0.00', 'GLASS BEAD 1828    6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1817, NULL, NULL, '0.00', 'ENGSEL PIANO L 32MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1818, NULL, NULL, '0.00', 'M SCREW 9K-86001  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1819, NULL, NULL, '0.00', 'HINGE DL 4X3X2MM 2BB SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1820, NULL, NULL, '0.00', 'ESCN 84030 SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1821, NULL, NULL, '0.00', 'FLUSH BOLT FB 508 NA (8 & 12) DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1822, NULL, NULL, '0.00', 'DUST PROOF DP 003 SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1823, NULL, NULL, '0.00', 'SLIDING RAIL SR 8901 D4 2000+FLOOR GUIDE+BRACKET D', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1824, NULL, NULL, '0.00', 'MORTICE LOCK MTS SLD DL 8225 SSS+BACKING PLATE DEK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1825, NULL, NULL, '0.00', 'BUTT HINGES 4\"X3\"X2 2BB SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1826, NULL, NULL, '0.00', 'U LOUVRE K-252A  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1827, NULL, NULL, '0.00', 'LOUVRE KECIL K-254  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1828, NULL, NULL, '0.00', 'GEMBOK 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1829, NULL, NULL, '0.00', 'LAKBAN HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1830, NULL, NULL, '0.00', 'PILOX 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1831, NULL, NULL, '0.00', 'HOLLOW ALUM K 98617  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1832, NULL, NULL, '0.00', 'HOLLOW ALUM K-98618  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1833, NULL, NULL, '0.00', 'HOLLOW ALUM K 66536  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1834, NULL, NULL, '0.00', 'SPANDRELL ALUMUNIUM 9K-99588  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1835, NULL, NULL, '0.00', 'HOLLOW ALUM K 98617  YK-1N  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1836, NULL, NULL, '0.00', 'HOLLOW ALUM K-98618  YK-1N  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1837, NULL, NULL, '0.00', 'HOLLOW ALUM K 66536  YK-1N  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1838, NULL, NULL, '0.00', 'LEM FOX', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1839, NULL, NULL, '0.00', 'KARET STOPPER PINTU 0952  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1840, NULL, NULL, '0.00', 'STICKER SANDBLAST 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1841, NULL, NULL, '0.00', 'STICKER SANDBLAST 0952', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1842, NULL, NULL, '0.00', 'PLAT SHEET 1200X2400    1.2MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1843, NULL, NULL, '0.00', 'STICKER SANDBLAST J2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1844, NULL, NULL, '0.00', 'STICKER SANDBLAST J3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1845, NULL, NULL, '0.00', 'STICKER SANDBLAST P1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1846, NULL, NULL, '0.00', 'STICKER SANDBLAST P1C', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1847, NULL, NULL, '0.00', 'STICKER SANDBLAST P2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1848, NULL, NULL, '0.00', 'PLAT BESI UK 30X1.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1849, NULL, NULL, '0.00', 'M SCREW 9K-86041  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1850, NULL, NULL, '0.00', 'GLASS BEAD 9K-86029  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1851, NULL, NULL, '0.00', 'M COVER 9K-86027  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1852, NULL, NULL, '0.00', 'MULLION K-70703  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1853, NULL, NULL, '0.00', 'BEAD K-70705  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1854, NULL, NULL, '0.00', 'BEAD MULLION K-70704  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1855, NULL, NULL, '0.00', 'TRANSOME K-70706  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1856, NULL, NULL, '0.00', 'MULLION K-70703  YS1C  6.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1857, NULL, NULL, '0.00', 'MULLION K-70705  YS1C  6.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1858, NULL, NULL, '0.00', 'TRANSOME K-70706  YS1C  5.15', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1859, NULL, NULL, '0.00', 'MORTISELOCK IL DL84030 SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1860, NULL, NULL, '0.00', 'BRACKET SIKU 100X100X70 T5MM GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1861, NULL, NULL, '0.00', 'MORTISELOCK IL DL84030 SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1862, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010  YS1C  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1863, NULL, NULL, '0.00', 'KARET STOPPER JENDELA FILITY 9K 20754', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1864, NULL, NULL, '0.00', 'MULLION K-66142  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1865, NULL, NULL, '0.00', 'TRANSOME K-70706  PB 80  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1866, NULL, NULL, '0.00', 'CORNER BLOCK MILL FINISH JENDELA FILITY 9K-10695', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1867, NULL, NULL, '0.00', 'GALVALUM L 1200 P.2040 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1868, NULL, NULL, '0.00', 'GALVALUM L 1200 P.3400 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1869, NULL, NULL, '0.00', 'TRIPLEK 12MM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1870, NULL, NULL, '0.00', 'LOCKCASE 2112 EX GRIFF = STRIKE PLATE 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1871, NULL, NULL, '0.00', 'CASEMENT HANDEL CH 429  BLACK', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1872, NULL, NULL, '0.00', 'TOPHUNG (B) MPL J1 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1873, NULL, NULL, '0.00', 'FIX J2 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1874, NULL, NULL, '0.00', 'FIX J3 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1875, NULL, NULL, '0.00', 'FIX J4 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1876, NULL, NULL, '0.00', 'FIX J5 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1877, NULL, NULL, '0.00', 'FIX J6 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1878, NULL, NULL, '0.00', 'TYPE A (AD3) BR1 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1879, NULL, NULL, '0.00', 'TYPE A (AD3) BR1 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1880, NULL, NULL, '0.00', 'TYPE A (W6) R1B-2B NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1881, NULL, NULL, '0.00', 'TYPE A2 (SD1) C1-C2 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1882, NULL, NULL, '0.00', 'TYPE B (W1) D1-D4 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1883, NULL, NULL, '0.00', 'TYPE B (W2) BR3 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1884, NULL, NULL, '0.00', 'TYPE B (W5) R 1A-4A NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1885, NULL, NULL, '0.00', 'TYPE C ( AD1) A NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1886, NULL, NULL, '0.00', 'TYPE C (W3) BR4 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1887, NULL, NULL, '0.00', 'TYPE D (W4) BR2 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1888, NULL, NULL, '0.00', 'FD1 R FOL 1A & 1B NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1889, NULL, NULL, '0.00', 'M SCREW 6081  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1890, NULL, NULL, '0.00', 'M BEAD 6082  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1891, NULL, NULL, '0.00', 'GLASS BEAD 6083  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1892, NULL, NULL, '0.00', 'GLASS BEAD 6088  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1893, NULL, NULL, '0.00', 'STOPER PINTU 6090R  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1894, NULL, NULL, '0.00', 'TUTUP ALUR 11540  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1895, NULL, NULL, '0.00', 'MULLION 6023  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1896, NULL, NULL, '0.00', 'TRANSOME U/ TIANG 6008  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1897, NULL, NULL, '0.00', 'JOINT SLEEVE 6024  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1898, NULL, NULL, '0.00', 'GALVALUM L100 P.3010 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1899, NULL, NULL, '0.00', 'GALVALUM L100 P.3460 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1900, NULL, NULL, '0.00', 'GALVALUM L200 P.3200 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1901, NULL, NULL, '0.00', 'GALVALUM L70 P.3620 T.0.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1902, NULL, NULL, '0.00', 'MULLION 6009  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1903, NULL, NULL, '0.00', 'JOINT SLEEVE 6024  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-11-29 07:29:50', NULL),
(1904, NULL, NULL, '0.00', 'TRANSOME 6007  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1905, NULL, NULL, '0.00', 'TIANG ENGSEL 5730  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1906, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1907, NULL, NULL, '0.00', 'TIANG POLOS 4202  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1908, NULL, NULL, '0.00', 'AMBANG BAWAH 4204  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1909, NULL, NULL, '0.00', 'AMBANG ATAS 4201  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1910, NULL, NULL, '0.00', 'GLASS BEAD 6062  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1911, NULL, NULL, '0.00', 'WINDOW WALL 9016  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1912, NULL, NULL, '0.00', 'Cover WW 9017  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1913, NULL, NULL, '0.00', 'Glasbet WW 3317  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1914, NULL, NULL, '0.00', 'Stopper Jendela 6733  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1915, NULL, NULL, '0.00', 'FRAME JENDELA 435  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1916, NULL, NULL, '0.00', 'KACA STOPSOL FOCUS GREEN 6MM ASAHIMAS    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1917, NULL, NULL, '0.00', 'KACA STOPSOL FOCUS GREEN 8MM ASAHIMAS    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1918, NULL, NULL, '0.00', 'FIX J7 NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1919, NULL, NULL, '0.00', 'MATA BOR 10MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1920, NULL, NULL, '0.00', 'WD POTONG 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1921, NULL, NULL, '0.00', 'WIPPER 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1922, NULL, NULL, '0.00', 'KANEBO 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1923, NULL, NULL, '0.00', 'EMBER HITAM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1924, NULL, NULL, '0.00', 'ISI CUTTER 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1925, NULL, NULL, '0.00', 'PEMBERIH KACA 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1926, NULL, NULL, '0.00', 'RING KUNCI 12X13 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1927, NULL, NULL, '0.00', 'MATA DRIVER 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1928, NULL, NULL, '0.00', 'SANDFLEX 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1929, NULL, NULL, '0.00', 'MATA BOR 6MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1930, NULL, NULL, '0.00', 'MATA BOR 3.5 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1931, NULL, NULL, '0.00', 'F\'TALIT SILVER 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1932, NULL, NULL, '0.00', 'KAIN KASA 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1933, NULL, NULL, '0.00', 'KACA MATA LAS 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1934, NULL, NULL, '0.00', 'MATA POTONG 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1935, NULL, NULL, '0.00', 'OBENG 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1936, NULL, NULL, '0.00', 'GERGAJI 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1937, NULL, NULL, '0.00', 'MATA BOR BETON 12MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1938, NULL, NULL, '0.00', 'MATA BOR 12MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1939, NULL, NULL, '0.00', 'MATA BOR 6MM BOSH', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1940, NULL, NULL, '0.00', 'MATA BOR 12MM BOSH', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1941, NULL, NULL, '0.00', 'SKRAP 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1942, NULL, NULL, '0.00', 'SELANG 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1943, NULL, NULL, '0.00', 'ALAT POTONG BESI 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1944, NULL, NULL, '0.00', 'SIKU 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1945, NULL, NULL, '0.00', 'MATA BOR 6MM NACHI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1946, NULL, NULL, '0.00', 'MATA BOR 12MM NACHI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1947, NULL, NULL, '0.00', 'RING PAS 14 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1948, NULL, NULL, '0.00', 'RING 16-17 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1949, NULL, NULL, '0.00', 'SPONS BUSA 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1950, NULL, NULL, '0.00', 'DYNABOLT M10X100 HILTI', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1951, NULL, NULL, '0.00', 'M COVER 9K-86007  PW-02  3.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1952, NULL, NULL, '0.00', 'KACA LAMINATED CL 5MMX0.76XCL5MM ASAHIMAS    0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1953, NULL, NULL, '0.00', 'KACA LAMINATED CL 5MMX0.76XCL5MM ASAHIMAS    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1954, NULL, NULL, '0.00', 'KACA TEMPERED STOPSOL FOCUS EUROGREY 8MM ASAHIMAS ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1955, NULL, NULL, '0.00', 'KACA CLEAR TEMPERED 15MM ASAHIMAS    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1956, NULL, NULL, '0.00', 'SEALANT DC 991 DOWSIL  DARK GREY', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1957, NULL, NULL, '0.00', 'SARUNG TANGAN 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1958, NULL, NULL, '0.00', 'KARUNG 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1959, NULL, NULL, '0.00', 'BRACKET SIKU 90X55X55 T 5MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1960, NULL, NULL, '0.00', 'BRACKET SIKU 55X80X55 T 5MM 072-SS01', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1961, NULL, NULL, '0.00', 'AMBANG ATAS K-76816  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1962, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1963, NULL, NULL, '0.00', 'GLASS BEAD 9K-86029  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1964, NULL, NULL, '0.00', 'GLASS BEAD JENDELA K-75696  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1965, NULL, NULL, '0.00', 'GLASS BEAD K-76817  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1966, NULL, NULL, '0.00', 'M 1/2 LOUVRE 9K-86048  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1967, NULL, NULL, '0.00', 'M COVER 9K-86045  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1968, NULL, NULL, '0.00', 'M 1/2 SCREW 9K-86045  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1969, NULL, NULL, '0.00', 'M COVER 9K-86027  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1970, NULL, NULL, '0.00', 'M POLOS 9K-86042  YS1C  4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1971, NULL, NULL, '0.00', 'M SCREW 9K-86041  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1972, NULL, NULL, '0.00', 'M-TANDUK 9K-86061  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1973, NULL, NULL, '0.00', 'M-TANDUK TANPA COVER 9K-86064  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1974, NULL, NULL, '0.00', 'MULLION K-70703  YS1C  4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1975, NULL, NULL, '0.00', 'MULLION K-70705  YS1C  4.3', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1976, NULL, NULL, '0.00', 'MULLION K-70705  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1977, NULL, NULL, '0.00', 'OPEN BACK COVER 9K-86028 YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1978, NULL, NULL, '0.00', 'OPEN BACK SCREW 9K-86043  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1979, NULL, NULL, '0.00', 'OPENBACK POLOS 9K-86044  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1980, NULL, NULL, '0.00', 'SPANDRELL ALUMUNIUM K-75611  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1981, NULL, NULL, '0.00', 'Stopper Jendela K-70780  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1982, NULL, NULL, '0.00', 'STOPER PINTU 9K-86032  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1983, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1984, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1985, NULL, NULL, '0.00', 'TUTUP ALUR 9K-86030  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1986, NULL, NULL, '0.00', 'U LOUVRE 2K-466B  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1987, NULL, NULL, '0.00', 'U LOUVRE KECIL K-254  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1988, NULL, NULL, '0.00', 'U LOUVRE KECIL K-254  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1989, NULL, NULL, '0.00', 'M - Screw 9K-86041  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1990, NULL, NULL, '0.00', 'HOLLOW 70X200T2MM 29017  RALL 9003 WHITE SMO  4.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1991, NULL, NULL, '0.00', 'DOUBLE CYLINDER PC91 DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1992, NULL, NULL, '0.00', 'OPEN BACK SCREW 4403  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1993, NULL, NULL, '0.00', 'TUTUP RATA 4408  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1994, NULL, NULL, '0.00', 'U ALUM 3/4X4  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1995, NULL, NULL, '0.00', 'ACP SEVEN 0.3MM 1220 X4880X4 -    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1996, NULL, NULL, '0.00', 'STOPER PINTU 6090R  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1997, NULL, NULL, '0.00', 'OPEN BACK SCREW 4403  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1998, NULL, NULL, '0.00', 'OPEN BACK COVER 4408  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(1999, NULL, NULL, '0.00', 'M - 1/2 Screw 4402  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2000, NULL, NULL, '0.00', 'U LOUVRE 4575  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2001, NULL, NULL, '0.00', 'LOUVRE 6048  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2002, NULL, NULL, '0.00', 'TIANG ENGSEL 5730  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2003, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2004, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  BLACK ANODIZE  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2005, NULL, NULL, '0.00', 'TIANG POLOS 4202  BLACK ANODIZE  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2006, NULL, NULL, '0.00', 'AMBANG BAWAH 4204  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2007, NULL, NULL, '0.00', 'AMBANG ATAS 4201  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2008, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2009, NULL, NULL, '0.00', 'STOPER PINTU 7587  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2010, NULL, NULL, '0.00', 'COVER M 27617  BLACK  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2011, NULL, NULL, '0.00', 'SPANDRELL 1706  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2012, NULL, NULL, '0.00', 'KARET SIRIP 726  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2013, NULL, NULL, '0.00', 'SINGLE TAPE L25MM T 3MM -  HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2014, NULL, NULL, '0.00', 'KARET STOPER 606 U  HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2015, NULL, NULL, '0.00', 'KARET STOPER 606 U  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2016, NULL, NULL, '0.00', 'MULLION 6010  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2017, NULL, NULL, '0.00', 'Hollow 10x20x1.1 mm 3209  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2018, NULL, NULL, '0.00', 'SCREW ROOVING 8X1 FAB -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2019, NULL, NULL, '0.00', 'KARET STOPPER 107 -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2020, NULL, NULL, '0.00', 'KARET MOHAIR -  ABU-ABU', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2021, NULL, NULL, '0.00', 'KACA STOPSOL FOCUS GREEN 6MM ASAHIMAS    0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2022, NULL, NULL, '0.00', 'M - 1/2 Screw 9K-86005  YS-1  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2023, NULL, NULL, '0.00', 'M BEAD 9K-86009  YS-1  4.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2024, NULL, NULL, '0.00', 'COVER M 9K-86007  YS-1  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2025, NULL, NULL, '0.00', 'HOLLOW 11X23MM -  BLACK ANODIZE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2026, NULL, NULL, '0.00', 'ACP SEVEN POLYESTER 0.21MM 1220x4880x4 -    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2027, NULL, NULL, '0.00', 'KABEL NYM 4X4 @50M -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2028, NULL, NULL, '0.00', 'M SCREW 9K-86001  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2029, NULL, NULL, '0.00', 'STOPER PINTU 9K-86015  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2030, NULL, NULL, '0.00', 'M SCREW 9K-86001  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2031, NULL, NULL, '0.00', 'STOPER PINTU 9K-86010  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2032, NULL, NULL, '0.00', 'U LOUVRE 2K-466B  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2033, NULL, NULL, '0.00', 'U LOUVRE KECIL K-254  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2034, NULL, NULL, '0.00', 'U ALUM K-72734  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2035, NULL, NULL, '0.00', 'AMBANG ATAS K-76816  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2036, NULL, NULL, '0.00', 'TIANG ENGSEL 9K-99742  MF  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2037, NULL, NULL, '0.00', 'TIANG MOHAIR K-76814  MF  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2038, NULL, NULL, '0.00', 'AMBANG BAWAH K-76815  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2039, NULL, NULL, '0.00', 'Bead Pintu K-76817  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2040, NULL, NULL, '0.00', 'REL ATAS 9K-86065  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2041, NULL, NULL, '0.00', 'REL BAWAH 9K-86066  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL);
INSERT INTO `products` (`id`, `company_id`, `user_id`, `avg_price`, `name`, `code`, `other_product_category_id`, `other_unit_id`, `desc`, `is_buy`, `buy_price`, `buy_tax`, `buy_account`, `is_sell`, `sell_price`, `sell_tax`, `sell_account`, `is_track`, `is_bundle`, `min_qty`, `default_inventory_account`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2042, NULL, NULL, '0.00', 'AMBANG ATAS K-75526  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2043, NULL, NULL, '0.00', 'AMBANG BAWAH K-75527  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2044, NULL, NULL, '0.00', 'TIANG KIRI KANAN 9K-99715  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2045, NULL, NULL, '0.00', 'FRAME KIRI KANAN K-75528  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2046, NULL, NULL, '0.00', 'TIANG KAIT K-75529  YB1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2047, NULL, NULL, '0.00', 'KACA SUNERGY CLEAR 4MM +PVB 0.38+ CLEAR 4MM ASAHIM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2048, NULL, NULL, '0.00', 'Kaca Clear 6mm ASAHIMAS    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2049, NULL, NULL, '0.00', 'PLATSHEET 1000X2000 T2MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2050, NULL, NULL, '0.00', 'CRESENTLOCK CL 330 BROWN DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2051, NULL, NULL, '0.00', 'MCB 3PX32A -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2052, NULL, NULL, '0.00', 'KWH DIGITAL 3P X 32A -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2053, NULL, NULL, '0.00', 'BOX MCB 20X30 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2054, NULL, NULL, '0.00', 'TERMINAL / STEKER -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2055, NULL, NULL, '0.00', 'ACC WERING -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, '2019-12-03 12:04:18', NULL),
(2056, NULL, NULL, '0.00', 'ROCKWOLL DENSITY 40KG UK 600X1200 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2057, NULL, NULL, '0.00', 'ACP SEVEN (1220X2440) 0.5 5005 WHITE QS 3103 -    ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2058, NULL, NULL, '0.00', 'PULL HANDLE HD 0003 US 32 EX KEND -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2059, NULL, NULL, '0.00', 'LEVER HANDLE HREO 75.01 SS US32D KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2060, NULL, NULL, '0.00', 'BRACKET SIKU 75X75X60 T5MM GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2061, NULL, NULL, '0.00', 'CASEMENT HANDLE CH 425 DEK -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2062, NULL, NULL, '0.00', 'PULLHANDLE PH801 32X600 PSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2063, NULL, NULL, '0.00', 'CAT DECOR D1-400 FANTASY FAIRE 049-5 PROPAN', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2064, NULL, NULL, '0.00', 'PT10,PT20, US10, PT24, CYL EX DEKSON -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2065, NULL, NULL, '0.00', 'MESIN POTONG ALUM LS1016L MAKITA -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2066, NULL, NULL, '0.00', 'TRIPLEK 12MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2067, NULL, NULL, '0.00', 'BESI SIKU 22X22X2MM P.6000 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2068, NULL, NULL, '0.00', 'LAMPU TEMBAK 300 WATT+ BOX', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2069, NULL, NULL, '0.00', 'STOP KONTAK ISI 4 LUBANG', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2070, NULL, NULL, '0.00', 'KUAS 2.5\"', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2071, NULL, NULL, '0.00', 'PISAU KERAMIK 4\"', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2072, NULL, NULL, '0.00', 'CAT DECOR D1-400 FANTASY FAIRE 049-5 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2073, NULL, NULL, '0.00', 'CAT DECOR D1-400 FANTASY FAIRE 049-5 PROPAN    2.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2074, NULL, NULL, '0.00', 'BUTYL SEALER 3\' B1 -  HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2075, NULL, NULL, '0.00', 'BUTYL SEALER 3\' B2 -  HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2076, NULL, NULL, '0.00', 'CAT VINILEX -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2077, NULL, NULL, '0.00', 'BRACKET SIKU 70X70X60 T5MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2078, NULL, NULL, '0.00', 'M COVER 86063  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2079, NULL, NULL, '0.00', 'FIRE BLANKET UK 1200X1200 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2080, NULL, NULL, '0.00', 'UPAH PASANG ATAP -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2081, NULL, NULL, '0.00', 'UPAH PASANG FLASHING -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2082, NULL, NULL, '0.00', 'BAJA RINGAN CMP 75 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2083, NULL, NULL, '0.00', 'TRIPLEK 8MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2084, NULL, NULL, '0.00', 'CAT VINILEX -  PUTIH', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2085, NULL, NULL, '0.00', 'ASBES 1M X 270CM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2086, NULL, NULL, '0.00', 'SKRUP ROOFING 7.5CM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2087, NULL, NULL, '0.00', 'SKRUP ROOVING 2\' -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2088, NULL, NULL, '0.00', 'HOLLOW 40X40X1MM -  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2089, NULL, NULL, '0.00', 'SINGLE TAPE UK 40 T5MM -  HITAM', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2090, NULL, NULL, '0.00', 'PLAT SHEET 1000X2000XT2MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2091, NULL, NULL, '0.00', 'DOOR CLOSER TS 68 HO DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2092, NULL, NULL, '0.00', 'BRACKET SIKU 50X50X60 T4MM GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2093, NULL, NULL, '0.00', 'MURBAUT M6X70MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2094, NULL, NULL, '0.00', 'PULL HANDLE PH DL 802 38X1000 PSS/SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2095, NULL, NULL, '0.00', 'LOUVRE EKSTERIOR,SOLAR TUFF,DAN ACP DROP CEILING -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2096, NULL, NULL, '0.00', 'SKRUP ROOVING 24X20 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2097, NULL, NULL, '0.00', 'SKRUP ROOVING 24X75 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2098, NULL, NULL, '0.00', 'BEAD MULLION 6008  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2099, NULL, NULL, '0.00', 'TRANSOME 6007  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2100, NULL, NULL, '0.00', 'U LOUVRE 4575  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2101, NULL, NULL, '0.00', 'U LOUVRE 4575  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2102, NULL, NULL, '0.00', 'SIKU ALUM 1/2 -  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2103, NULL, NULL, '0.00', 'SIKU ALUM 1/2 -  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2104, NULL, NULL, '0.00', 'HOLLOW 1 1/2 T1.2 -  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2105, NULL, NULL, '0.00', 'BRACKET H 145X55X50 T5MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2106, NULL, NULL, '0.00', 'BRACKET U 40X50X55 T5MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2107, NULL, NULL, '0.00', 'HOLLOW 44.45X101.60 T1.3 422  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2108, NULL, NULL, '0.00', 'M POLOS 9K-86042  YS1C  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2109, NULL, NULL, '0.00', 'GLASS BEAD 9K-86009  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2110, NULL, NULL, '0.00', 'GAGANG ROL CAT -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2111, NULL, NULL, '0.00', 'SENG GELOMBANG 0.2 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2112, NULL, NULL, '0.00', 'SKRUP ATAP 5CM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2113, NULL, NULL, '0.00', 'LAMPU 50 WATT -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2114, NULL, NULL, '0.00', 'SAKLAR SERI -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2115, NULL, NULL, '0.00', 'MCB 5A -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2116, NULL, NULL, '0.00', 'HOLLOW BESI 40X40 T0.8 P.6 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2117, NULL, NULL, '0.00', 'SKRUP 8 X 1 FAB -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2118, NULL, NULL, '0.00', 'WINDOW WALL 9K 86072  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2119, NULL, NULL, '0.00', 'Cover WW 9K 86073  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2120, NULL, NULL, '0.00', 'TIANG ENGSEL 9K 85701  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2121, NULL, NULL, '0.00', 'TIANG MOHAIR 9K 85702  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2122, NULL, NULL, '0.00', 'TIANG KUNCI 9K 85748  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2123, NULL, NULL, '0.00', 'AMBANG BAWAH K-94389  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2124, NULL, NULL, '0.00', 'FRAME JENDELA K-94393  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2125, NULL, NULL, '0.00', 'REL ATAS K-75523  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2126, NULL, NULL, '0.00', 'REL BAWAH K-75524  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2127, NULL, NULL, '0.00', 'TIANG SAMPING K-75525  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2128, NULL, NULL, '0.00', 'TIANG POLOS K-75528  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2129, NULL, NULL, '0.00', 'OPEN BACK SCREW 9K 86003  PW-02  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2130, NULL, NULL, '0.00', 'MORTISE LOCK MTS IL DL 8485 SSS DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2131, NULL, NULL, '0.00', 'FRICTIONSTAY FS S/S 10\' DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2132, NULL, NULL, '0.00', 'FRICTIONSTAY FS S/S 12\' DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2133, NULL, NULL, '0.00', 'FRICTIONSTAY FS S/S 16\' HD DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2134, NULL, NULL, '0.00', 'CRESENTLOCK CL310 DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2135, NULL, NULL, '0.00', 'CASEMENTHANDLE CH 429 DEKSON  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2136, NULL, NULL, '0.00', 'ESPAGNOLET EPL AL 828A 1500+HDL DEKSON  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2137, NULL, NULL, '0.00', 'FLUSHBOLT FB 508 DEKSON  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2138, NULL, NULL, '0.00', 'NEXSTA70 9K 94845  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2139, NULL, NULL, '0.00', 'NEXSTA70 9K 94841  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2140, NULL, NULL, '0.00', 'NEXSTA70 3K 6315B  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2141, NULL, NULL, '0.00', 'HOOK LO NEXSTA  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2142, NULL, NULL, '0.00', 'AUTOMATICDOOR ES 80 COMPACT DOUBLE COMPLETE DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2143, NULL, NULL, '0.00', 'HOLLOW BESI 30X30 T1.6 P.6 -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2144, NULL, NULL, '0.00', 'SKRUP ROOVING 5CM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2145, NULL, NULL, '0.00', 'SINGLE TAPE 30MM X 5MM -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2146, NULL, NULL, '0.00', 'FOLDING N 9K 94489  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2147, NULL, NULL, '0.00', 'FOLDING N 9K 94410  YK1N', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2148, NULL, NULL, '0.00', 'JASA BENDING PLAT ALUM 165X2100 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2149, NULL, NULL, '0.00', 'JASA BENDING PLAT ALUM 325X2100 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2150, NULL, NULL, '0.00', 'KACA MISLITE 5MM -    0', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2151, NULL, NULL, '0.00', 'CERMIN 6 MM BEVEL 3 CM KELILING 6 MM -    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2152, NULL, NULL, '0.00', 'BINGKAI STAINLES UK 1700X1100 -  HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2153, NULL, NULL, '0.00', 'BINGKAI STAINLES UK 1770X1100 -  HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2154, NULL, NULL, '0.00', 'BINGKAI STAINLES UK 2070X1100 -  HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2155, NULL, NULL, '0.00', 'BINGKAI STAINLES UK 2200X1100 -  HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2156, NULL, NULL, '0.00', 'KACA LAMINATED 13MM (CL 6MM+1.14CL+6MM EURO GREY) ', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2157, NULL, NULL, '0.00', 'MURBAUT M8X70 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2158, NULL, NULL, '0.00', 'DOOR STOPER 75-016 US14D KEND', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2159, NULL, NULL, '0.00', 'PURE LEVER HANDLE 8100/SS OVAL SERIES+ESCN DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2160, NULL, NULL, '0.00', 'ESCUTCHEON DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2161, NULL, NULL, '0.00', 'HOLLOW ALUM 20X40X1mm ALEX  WHITE  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2162, NULL, NULL, '0.00', 'LOCKCASE ROLLER DST952/30MM-SP20SS + BACKPLATE DOR', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2163, NULL, NULL, '0.00', 'COVER ALUR 9K-86030  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2164, NULL, NULL, '0.00', 'MURBAUT M10X50MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2165, NULL, NULL, '0.00', 'PEMASANGAN FACADE ALUMUNIUM ENERGY BUILDING -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2166, NULL, NULL, '0.00', 'M SCREW 4401  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2167, NULL, NULL, '0.00', 'M POLOS 4404  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2168, NULL, NULL, '0.00', 'M POLOS 4404  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2169, NULL, NULL, '0.00', 'M POLOS 4404  MF  5.2', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2170, NULL, NULL, '0.00', 'M - 1/2 Screw 4402  MF  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2171, NULL, NULL, '0.00', 'M COVER 4407  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2172, NULL, NULL, '0.00', 'M COVER 4407  MF  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2173, NULL, NULL, '0.00', 'M COVER 4407  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2174, NULL, NULL, '0.00', 'OPEN BACK SKRUP 4403  MF  5.5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2175, NULL, NULL, '0.00', 'STOPER PINTU 6090R  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2176, NULL, NULL, '0.00', 'TUTUP ALUR 11540  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2177, NULL, NULL, '0.00', 'U LOUVRE 4575  MF  3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2178, NULL, NULL, '0.00', 'U LOUVRE 4575  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2179, NULL, NULL, '0.00', 'U LOUVRE 4575  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2180, NULL, NULL, '0.00', 'LOUVRE 6048  MF  5.1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2181, NULL, NULL, '0.00', 'LOUVRE 6048  MF  5.75', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2182, NULL, NULL, '0.00', 'LOUVRE 6048  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2183, NULL, NULL, '0.00', 'U LOUVRE KECIL 1037  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2184, NULL, NULL, '0.00', 'LOUVRE KECIL 7072  MF  5.75', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2185, NULL, NULL, '0.00', 'TIANG ENGSEL 5730  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2186, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2187, NULL, NULL, '0.00', 'TIANG POLOS 4202  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2188, NULL, NULL, '0.00', 'AMBANG BAWAH 4204  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2189, NULL, NULL, '0.00', 'AMBANG BAWAH 4204  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2190, NULL, NULL, '0.00', 'TIANG MOHAIR 4203  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2191, NULL, NULL, '0.00', 'TIANG POLOS 4202  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2192, NULL, NULL, '0.00', 'AMBANG ATAS 4201  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2193, NULL, NULL, '0.00', 'AMBANG ATAS 4201  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2194, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2195, NULL, NULL, '0.00', 'GLASS BEAD PINTU 6062  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2196, NULL, NULL, '0.00', 'M 1/2 SCREW 9K-86005  YS-1  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2197, NULL, NULL, '0.00', 'ENGSEL PINTU UK 4X3X2 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2198, NULL, NULL, '0.00', 'BAUT ROOFING 10X19 -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2199, NULL, NULL, '0.00', 'BRACKET TYPE A UK 153X200X45X53 T4MM -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2200, NULL, NULL, '0.00', 'BRACKET TYPE B UK 360X153X45X53 T4MM -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2201, NULL, NULL, '0.00', 'FD UK 5990X2490 NEXTA70  PW02', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2202, NULL, NULL, '0.00', 'M POLOS 4624  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2203, NULL, NULL, '0.00', 'KACA CERMIN 5MM -    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2204, NULL, NULL, '0.00', 'SIKU STAINLESS SUS304 UK 90X70 T2MM -  HAIRLINE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2205, NULL, NULL, '0.00', 'DOOR SEAL KARET -  WHITE', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2206, NULL, NULL, '0.00', 'DEMPUL SAMPOLAK -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2207, NULL, NULL, '0.00', 'Amplas -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2208, NULL, NULL, '0.00', 'M POLOS BENDING -    7.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2209, NULL, NULL, '0.00', 'M POLOS BENDING -    8.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2210, NULL, NULL, '0.00', 'AMBANG ATAS 0241  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2211, NULL, NULL, '0.00', 'AMBANG BAWAH 0244  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2212, NULL, NULL, '0.00', 'TIANG MOHAIR 0243  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2213, NULL, NULL, '0.00', 'TIANG POLOS 0242  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2214, NULL, NULL, '0.00', 'U LOUVRE 9570  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2215, NULL, NULL, '0.00', 'U LOUVRE 9570  MF  3.6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2216, NULL, NULL, '0.00', 'U LOUVRE 9570  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2217, NULL, NULL, '0.00', 'U LOUVRE A0140  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2218, NULL, NULL, '0.00', 'KAWAT WIRE 5MM @50 KG -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2219, NULL, NULL, '0.00', 'KACA STOPSOL FOCUS CLEAR 8MM -    1', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2220, NULL, NULL, '0.00', 'M - Screw 18410  MF  5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2221, NULL, NULL, '0.00', 'M 1/2 SCREW 18412B  MF  5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2222, NULL, NULL, '0.00', 'GLASS BEAD 18405  MF  5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2223, NULL, NULL, '0.00', 'GLASS BEAD JENDELA 20500  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2224, NULL, NULL, '0.00', 'M - Cover 18403  MF  5.8', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2225, NULL, NULL, '0.00', 'Stopper Jendela 20502  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2226, NULL, NULL, '0.00', 'TUTUP ALUR 18406  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2227, NULL, NULL, '0.00', 'FRAME JENDELA 20503  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2228, NULL, NULL, '0.00', 'U LOUVRE 11441  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2229, NULL, NULL, '0.00', 'STOPER PINTU 18497  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2230, NULL, NULL, '0.00', 'TIANG ENGSEL 19268  MF  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2231, NULL, NULL, '0.00', 'TIANG ENGSEL 19268  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2232, NULL, NULL, '0.00', 'TIANG MOHAIR 19201  MF  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2233, NULL, NULL, '0.00', 'TIANG MOHAIR 19201  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2234, NULL, NULL, '0.00', 'AMBANG ATAS 19202  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2235, NULL, NULL, '0.00', 'AMBANG BAWAH 19203  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2236, NULL, NULL, '0.00', 'Bead Pintu 19204  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2237, NULL, NULL, '0.00', 'TIANG POLOS 19200  MF  4.4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2238, NULL, NULL, '0.00', 'LOUVRE 18540  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2239, NULL, NULL, '0.00', 'LOUVRE 18500  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2240, NULL, NULL, '0.00', 'BRACKET SIKU 100X100X100 T10MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2241, NULL, NULL, '0.00', 'BRACKET SIKU 100X100X170 T10MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2242, NULL, NULL, '0.00', 'BRACKET PLAT BESI 100X100 T10MM -  GALVANIS', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2243, NULL, NULL, '0.00', 'FRICTIONSTAY FS 14\' S/S DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2244, NULL, NULL, '0.00', 'FRICTIONSTAY 20\' C SERIES DEKSON', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2245, NULL, NULL, '0.00', 'HOLLOW 25.4X38.1 1.2 4593  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2246, NULL, NULL, '0.00', 'SPANDRELL DOUBLE 8109  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2247, NULL, NULL, '0.00', 'U ALUM 1079  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2248, NULL, NULL, '0.00', 'STOPER PINTU 430  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2249, NULL, NULL, '0.00', 'REL ATAS 9102  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2250, NULL, NULL, '0.00', 'REL BAWAH 9103  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2251, NULL, NULL, '0.00', 'TIANG SAMPING 9104  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2252, NULL, NULL, '0.00', 'TIANG POLOS 9055  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2253, NULL, NULL, '0.00', 'TIANG KAIT 9054  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2254, NULL, NULL, '0.00', 'AMBANG ATAS 9058  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2255, NULL, NULL, '0.00', 'U LOUVRE 644  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2256, NULL, NULL, '0.00', 'U ALUM 640  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2257, NULL, NULL, '0.00', 'AMBANG ATAS 9056  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2258, NULL, NULL, '0.00', 'STOPPER PINTU SLIDING 430  CA  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2259, NULL, NULL, '0.00', 'PURE LEVER HANDLE 8100V/OVAL SERIES DORMA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2260, NULL, NULL, '0.00', 'MURBAUT M10X120 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2261, NULL, NULL, '0.00', 'U LOUVRE 644  MF  6', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2262, NULL, NULL, '0.00', 'KAWAT BAJA 0.5MM -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2263, NULL, NULL, '0.00', 'KARUNG GONI -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2264, NULL, NULL, '0.00', 'TALI TAMBANG 10MM @25M -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2265, NULL, NULL, '0.00', 'TALI TAMBANG 12MM @25M -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2266, NULL, NULL, '0.00', 'MATA BOR 4\' -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2267, NULL, NULL, '0.00', 'SELANG WATERPASS @30M -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2268, NULL, NULL, '0.00', 'WATERPASS -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2269, NULL, NULL, '0.00', 'ALAT SIPAT + TINTA -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2270, NULL, NULL, '0.00', 'PE-844 I NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2271, NULL, NULL, '0.00', 'PE-844B NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2272, NULL, NULL, '0.00', 'PE-844C NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2273, NULL, NULL, '0.00', 'PE-844D NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2274, NULL, NULL, '0.00', 'PE-844E NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2275, NULL, NULL, '0.00', 'PE-844G NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2276, NULL, NULL, '0.00', 'PE-844H NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2277, NULL, NULL, '0.00', 'PE-844F NEXSTA', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2278, NULL, NULL, '0.00', 'ASBES P.210 -', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2279, NULL, NULL, '0.00', 'Mullion 50x100x2mm 27556  MF  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2280, NULL, NULL, '0.00', 'BEAD MULLION 27516  MF  5', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2281, NULL, NULL, '0.00', 'TRANSOME 27842  MF  4', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, NULL, NULL, NULL),
(2282, NULL, 4, '0.00', '6081 ARTIC WHITE P. 600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:39:50', '2019-10-31 07:15:54', NULL),
(2283, NULL, 4, '0.00', '6088 ARTIC WHITE P. 600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:44:06', '2019-10-31 07:15:54', NULL),
(2284, NULL, 4, '0.00', '6082 ARTIC WHITE P. 600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:44:40', '2019-10-31 07:15:54', NULL),
(2285, NULL, 4, '0.00', '6083 ARTIC WHITE P. 600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:45:13', '2019-10-31 07:15:54', NULL),
(2286, NULL, 4, '0.00', '11540 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:45:48', '2019-12-03 12:44:55', NULL),
(2287, NULL, 4, '0.00', '6090R ARTIC WHITE P. 600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:46:48', '2019-10-31 07:15:54', NULL),
(2288, NULL, 4, '0.00', '4202 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:49:03', '2019-11-28 23:57:11', NULL),
(2289, NULL, 4, '0.00', '4203 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:49:50', '2019-10-31 07:15:54', NULL),
(2290, NULL, 4, '0.00', '4201 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:50:18', '2019-12-03 12:44:55', NULL),
(2291, NULL, 4, '0.00', '4204 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:50:44', '2019-11-28 22:13:03', NULL),
(2292, NULL, 4, '0.00', '5730 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:51:12', '2019-10-31 07:15:54', NULL),
(2293, NULL, 4, '0.00', '6062 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:51:55', '2019-10-31 07:15:54', NULL),
(2294, NULL, 4, '0.00', '9016 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:52:31', '2019-10-31 07:15:54', NULL),
(2295, NULL, 4, '0.00', '9017 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:52:54', '2019-10-31 07:15:54', NULL),
(2296, NULL, 4, '0.00', '3317 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:53:35', '2019-12-03 08:23:29', NULL),
(2297, NULL, 4, '0.00', '6733 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:54:15', '2019-10-31 07:15:54', NULL),
(2298, NULL, 4, '0.00', '435 ARTIC WHITE P.600', NULL, 1, 2, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-10-31 06:54:51', '2019-10-31 07:15:54', NULL),
(2299, NULL, 5, '0.00', 'W7A\' 4540x1760', NULL, 1, 1, NULL, 1, '0.00', 1, 69, 1, '0.00', 1, 65, 1, 0, 0, 7, 0, '2019-11-29 04:08:04', '2019-11-29 07:01:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_bundle_costs`
--

CREATE TABLE `product_bundle_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_bundle_items`
--

CREATE TABLE `product_bundle_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `bundle_product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_deliveries`
--

CREATE TABLE `purchase_deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `transaction_no` int(10) DEFAULT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `selected_pq_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_po_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_delivery_items`
--

CREATE TABLE `purchase_delivery_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_delivery_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_item_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(19) NOT NULL DEFAULT 0,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(19) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoices`
--

CREATE TABLE `purchase_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `transaction_no_pq` int(10) DEFAULT NULL,
  `transaction_no_po` int(10) DEFAULT NULL,
  `transaction_no_pd` int(10) DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `amount_paid` decimal(12,2) DEFAULT NULL,
  `total_return` decimal(12,2) DEFAULT NULL,
  `debit_memo` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `selected_pq_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_pd_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_po_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `witholding_coa_id` int(10) DEFAULT NULL,
  `witholding_amount_rp` decimal(12,2) DEFAULT NULL,
  `witholding_amount_per` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_items`
--

CREATE TABLE `purchase_invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_invoice_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(10) DEFAULT NULL,
  `qty_remaining_return` int(10) DEFAULT NULL,
  `unit_id` int(11) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(11) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_pos`
--

CREATE TABLE `purchase_invoice_pos` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_invoice_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_po_items`
--

CREATE TABLE `purchase_invoice_po_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_invoice_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_item_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `qty_remaining_return` int(10) NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `transaction_no_pq` int(10) DEFAULT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `jasa_only` int(10) NOT NULL DEFAULT 0,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `selected_pq_id` int(10) UNSIGNED DEFAULT NULL,
  `total_qty` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deposit` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(10) DEFAULT NULL COMMENT 'REQUEST SUKSES',
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payments`
--

CREATE TABLE `purchase_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `account_id` int(10) UNSIGNED NOT NULL COMMENT 'PAY FROM',
  `other_payment_method_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `transaction_no_pi` int(10) UNSIGNED DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment_items`
--

CREATE TABLE `purchase_payment_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_invoice_id` int(10) UNSIGNED NOT NULL,
  `purchase_payment_id` int(10) UNSIGNED NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_quotes`
--

CREATE TABLE `purchase_quotes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `term_id` int(10) UNSIGNED DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_quote_items`
--

CREATE TABLE `purchase_quote_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_quote_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `number` varchar(191) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date NOT NULL,
  `transaction_no_pi` int(10) NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `selected_pi_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_items`
--

CREATE TABLE `purchase_return_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_return_id` int(10) UNSIGNED NOT NULL,
  `purchase_invoice_item_id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED DEFAULT NULL,
  `purchase_order_item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty_invoice` int(10) NOT NULL,
  `qty_remaining_invoice` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', 'web', NULL, NULL),
(2, 'Ultimate', 'web', NULL, NULL),
(3, 'Administrator', 'web', NULL, NULL),
(4, 'Sales Quote', 'web', NULL, NULL),
(5, 'Sales Order', 'web', NULL, NULL),
(6, 'Sales Delivery', 'web', NULL, NULL),
(7, 'Sales Invoice', 'web', NULL, NULL),
(8, 'Sales Payment', 'web', NULL, NULL),
(9, 'Sales Return', 'web', NULL, NULL),
(10, 'Purchase Quote', 'web', NULL, NULL),
(11, 'Purchase Order', 'web', NULL, NULL),
(12, 'Purchase Delivery', 'web', NULL, NULL),
(13, 'Purchase Invoice', 'web', NULL, NULL),
(14, 'Purchase Payment', 'web', NULL, NULL),
(15, 'Purchase Return', 'web', NULL, NULL),
(16, 'Expense', 'web', NULL, NULL),
(17, 'Production', 'web', NULL, NULL),
(18, 'Contact', 'web', NULL, NULL),
(19, 'Good & Services', 'web', NULL, NULL),
(20, 'Stock Adjustment', 'web', NULL, NULL),
(21, 'Warehouses', 'web', NULL, NULL),
(22, 'Warehouse Transfer', 'web', NULL, NULL),
(23, 'Cash & Bank', 'web', NULL, NULL),
(24, 'Chart of Account', 'web', NULL, NULL),
(25, 'Other List', 'web', NULL, NULL),
(26, 'Reports', 'web', NULL, NULL),
(27, 'Setting', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_deliveries`
--

CREATE TABLE `sale_deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `transaction_no` int(10) DEFAULT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `selected_sq_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_so_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sale_delivery_items`
--

CREATE TABLE `sale_delivery_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_delivery_id` int(10) UNSIGNED DEFAULT 0,
  `sale_order_item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(19) NOT NULL DEFAULT 0,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(19) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoices`
--

CREATE TABLE `sale_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `transaction_no_sq` int(10) DEFAULT NULL,
  `transaction_no_so` int(10) DEFAULT NULL,
  `transaction_no_sd` int(10) DEFAULT NULL,
  `transaction_no_spk` int(10) DEFAULT NULL COMMENT 'REQUEST SUKSES',
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `is_marketting` int(10) DEFAULT NULL,
  `marketting` int(10) UNSIGNED DEFAULT NULL,
  `jasa_only` int(10) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `costtotal` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `amount_paid` decimal(12,2) DEFAULT NULL,
  `total_return` decimal(12,2) DEFAULT NULL,
  `credit_memo` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `selected_sq_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_sd_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_so_id` int(10) UNSIGNED DEFAULT NULL,
  `selected_spk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'REQUEST SUKSES',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `witholding_coa_id` int(10) DEFAULT NULL,
  `witholding_amount_rp` decimal(12,2) DEFAULT NULL,
  `witholding_amount_per` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoice_costs`
--

CREATE TABLE `sale_invoice_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_invoice_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoice_items`
--

CREATE TABLE `sale_invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_invoice_id` int(10) UNSIGNED NOT NULL,
  `sale_order_item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(10) DEFAULT NULL,
  `qty_remaining_return` int(10) DEFAULT NULL,
  `unit_id` int(11) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `cost_unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(11) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `cost_amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_orders`
--

CREATE TABLE `sale_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `transaction_no_sq` int(10) DEFAULT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `is_marketting` int(10) DEFAULT NULL COMMENT 'REQUEST SUKSES',
  `marketting` int(10) UNSIGNED DEFAULT NULL COMMENT 'REQUEST SUKSES',
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `selected_sq_id` int(10) UNSIGNED DEFAULT NULL,
  `total_qty` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_order_items`
--

CREATE TABLE `sale_order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `qty_remaining` int(10) DEFAULT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `harga_nota` decimal(12,2) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payments`
--

CREATE TABLE `sale_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `account_id` int(10) UNSIGNED NOT NULL COMMENT 'PAY FROM',
  `other_payment_method_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `transaction_no_si` int(10) UNSIGNED DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payment_items`
--

CREATE TABLE `sale_payment_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_invoice_id` int(10) UNSIGNED NOT NULL,
  `sale_payment_id` int(10) UNSIGNED NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_quotes`
--

CREATE TABLE `sale_quotes` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `term_id` int(10) UNSIGNED DEFAULT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `balance_due` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sale_quote_items`
--

CREATE TABLE `sale_quote_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_quote_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `number` varchar(191) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date NOT NULL,
  `transaction_no_si` int(10) NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `taxtotal` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `selected_si_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_items`
--

CREATE TABLE `sale_return_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_return_id` int(10) UNSIGNED NOT NULL,
  `sale_invoice_item_id` int(10) UNSIGNED NOT NULL,
  `sale_order_id` int(10) UNSIGNED DEFAULT NULL,
  `sale_order_item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty_invoice` int(10) NOT NULL,
  `qty_remaining_invoice` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL,
  `amountsub` decimal(12,2) DEFAULT NULL,
  `amounttax` decimal(12,2) DEFAULT NULL,
  `amountgrand` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spks`
--

CREATE TABLE `spks` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `number` varchar(191) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) DEFAULT 'NULL',
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spk_items`
--

CREATE TABLE `spk_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `spk_id` int(10) UNSIGNED NOT NULL,
  `selected_wip_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `qty_remaining` int(10) NOT NULL,
  `qty_remaining_sent` int(10) DEFAULT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_type` int(10) NOT NULL,
  `adjustment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `coa_id` int(10) UNSIGNED NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_details`
--

CREATE TABLE `stock_adjustment_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_adjustment_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `recorded` int(10) NOT NULL,
  `actual` int(10) DEFAULT 0,
  `difference` int(10) DEFAULT 0,
  `avg_price` float DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 99, 'Owner', 'superadmin@super.admin', NULL, '$2y$10$fkQD.EeYmLfrew3VrAJVJ.HTKZ2pxZ15G3e9ffdIk0NVbM/VUKP4y', NULL, '2019-10-30 08:56:24', '2019-10-30 08:56:24'),
(2, 99, 'Ultimate', 'admin@admin.com', NULL, '$2y$10$oBskhWYzQPKIzKwlIoDnte2W1LTYYbFFEq5d2GFuTOpef/MDO0oBy', NULL, '2019-10-30 08:58:38', '2019-10-30 08:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `user_id`, `name`, `code`, `address`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 1, 'Unsigned', NULL, NULL, NULL, '2019-11-29 01:49:11', '2019-11-29 01:49:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_details`
--

CREATE TABLE `warehouse_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty_in` int(10) NOT NULL DEFAULT 0,
  `qty_out` int(10) NOT NULL DEFAULT 0,
  `type` varchar(191) DEFAULT NULL,
  `number` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_transfers`
--

CREATE TABLE `warehouse_transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `number` varchar(191) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `from_warehouse_id` int(10) UNSIGNED NOT NULL,
  `to_warehouse_id` int(10) UNSIGNED NOT NULL,
  `memo` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_transfer_items`
--

CREATE TABLE `warehouse_transfer_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_transfer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_transfer_items`
--

INSERT INTO `warehouse_transfer_items` (`id`, `warehouse_transfer_id`, `product_id`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2282, 900, '2019-11-28 08:34:56', '2019-11-28 08:34:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wips`
--

CREATE TABLE `wips` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_no_spk` int(10) NOT NULL,
  `production_method` int(10) NOT NULL,
  `result_product` int(10) UNSIGNED NOT NULL,
  `result_qty` int(10) NOT NULL,
  `selected_spk_id` int(10) UNSIGNED NOT NULL,
  `number` varchar(191) DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `desc` text DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `other_transaction_id` int(10) UNSIGNED NOT NULL,
  `vendor_ref_no` varchar(191) DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `margin_type` varchar(191) NOT NULL,
  `margin_value` decimal(5,3) DEFAULT NULL,
  `margin_total` decimal(12,2) DEFAULT NULL,
  `grandtotal_without_qty` decimal(12,2) DEFAULT NULL,
  `grandtotal_with_qty` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wip_items`
--

CREATE TABLE `wip_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `wip_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty_require` int(10) NOT NULL,
  `qty_total` int(10) NOT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assasset_account` (`asset_account`),
  ADD KEY `asscredited_account` (`credited_account`),
  ADD KEY `assetsuser_id` (`user_id`),
  ADD KEY `assetscompany_id` (`company_id`);

--
-- Indexes for table `asset_details`
--
ALTER TABLE `asset_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assdetaccumulated_depreciate_account` (`accumulated_depreciate_account`);

--
-- Indexes for table `cashbanks`
--
ALTER TABLE `cashbanks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cbdeposit_to` (`deposit_to`),
  ADD KEY `cbtransfer_from` (`transfer_from`),
  ADD KEY `cbother_transaction_id` (`other_transaction_id`),
  ADD KEY `cbstatus` (`status`),
  ADD KEY `cbcontact_id` (`contact_id`),
  ADD KEY `cbpay_from` (`pay_from`) USING BTREE,
  ADD KEY `cabauser_id` (`user_id`),
  ADD KEY `cabacompany_id` (`company_id`);

--
-- Indexes for table `cashbank_items`
--
ALTER TABLE `cashbank_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cbdreceive_from` (`receive_from`),
  ADD KEY `cbcashbank` (`cashbank_id`),
  ADD KEY `cbdtax_id` (`tax_id`),
  ADD KEY `cbiexpense_id` (`expense_id`);

--
-- Indexes for table `coas`
--
ALTER TABLE `coas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coa_category_id` (`coa_category_id`),
  ADD KEY `coauser_id` (`user_id`),
  ADD KEY `coacompany_id` (`company_id`);

--
-- Indexes for table `coa_categories`
--
ALTER TABLE `coa_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coaccompany_id` (`company_id`),
  ADD KEY `coacuser_id` (`user_id`);

--
-- Indexes for table `coa_details`
--
ALTER TABLE `coa_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coa_id` (`coa_id`),
  ADD KEY `FK_coa_details_contacts` (`contact_id`),
  ADD KEY `coaother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `coaduser_id` (`user_id`),
  ADD KEY `coadcompany_id` (`company_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comuser_id` (`user_id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contactaccount_payable` (`account_payable_id`) USING BTREE,
  ADD KEY `contactaccount_receivable` (`account_receivable_id`) USING BTREE,
  ADD KEY `contactterm_id` (`term_id`) USING BTREE,
  ADD KEY `contactuser_id` (`user_id`),
  ADD KEY `contactcompany_id` (`company_id`);

--
-- Indexes for table `default_accounts`
--
ALTER TABLE `default_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_table_mapping_co_as` (`account_id`),
  ADD KEY `defaccuser_id` (`user_id`),
  ADD KEY `defacccompany_id` (`company_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expensesother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `expensespay_from_coa_id` (`pay_from_coa_id`) USING BTREE,
  ADD KEY `expensespayment_method_id` (`payment_method_id`) USING BTREE,
  ADD KEY `expensescontact_id` (`contact_id`) USING BTREE,
  ADD KEY `expensesstatus` (`status`) USING BTREE,
  ADD KEY `expensesterm_id` (`term_id`) USING BTREE,
  ADD KEY `exuser_id` (`user_id`),
  ADD KEY `excompany_id` (`company_id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expensesitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `expensesitemcoa_id` (`coa_id`) USING BTREE,
  ADD KEY `expenseitemexpense_id` (`expense_id`) USING BTREE;

--
-- Indexes for table `history_limit_balances`
--
ALTER TABLE `history_limit_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_limit_balancesuser_id` (`user_id`),
  ADD KEY `history_limit_balancescontact_id` (`contact_id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jeother_transaction_id` (`other_transaction_id`),
  ADD KEY `jestatus` (`status`),
  ADD KEY `jurecompany_id` (`company_id`),
  ADD KEY `jureuser_id` (`user_id`);

--
-- Indexes for table `journal_entry_items`
--
ALTER TABLE `journal_entry_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jeijournal_entry_id` (`journal_entry_id`),
  ADD KEY `jeicoa_id` (`coa_id`);

--
-- Indexes for table `logo_uploadeds`
--
ALTER TABLE `logo_uploadeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `other_payment_methods`
--
ALTER TABLE `other_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opmcompany_id` (`company_id`),
  ADD KEY `opmuser_id` (`user_id`);

--
-- Indexes for table `other_product_categories`
--
ALTER TABLE `other_product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opccompany_id` (`company_id`),
  ADD KEY `opcuser_id` (`user_id`);

--
-- Indexes for table `other_statuses`
--
ALTER TABLE `other_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oscompany_id` (`company_id`),
  ADD KEY `osuser_id` (`user_id`);

--
-- Indexes for table `other_taxes`
--
ALTER TABLE `other_taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxbuy_tax_account` (`buy_tax_account`) USING BTREE,
  ADD KEY `taxsell_tax_account` (`sell_tax_account`) USING BTREE,
  ADD KEY `otaxuser_id` (`user_id`) USING BTREE,
  ADD KEY `otaxcompany_id` (`company_id`) USING BTREE;

--
-- Indexes for table `other_terms`
--
ALTER TABLE `other_terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otermuser_id` (`user_id`),
  ADD KEY `otermcompany_id` (`company_id`);

--
-- Indexes for table `other_transactions`
--
ALTER TABLE `other_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_transstatus` (`status`) USING BTREE,
  ADD KEY `other_transcontact` (`contact`) USING BTREE,
  ADD KEY `otranscompany_id` (`company_id`),
  ADD KEY `otransuser_id` (`user_id`);

--
-- Indexes for table `other_units`
--
ALTER TABLE `other_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ouuser_id` (`user_id`),
  ADD KEY `oucompany_id` (`company_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_fours`
--
ALTER TABLE `production_fours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodfourcontact_id` (`contact_id`) USING BTREE,
  ADD KEY `prodfourother_transaction` (`other_transaction_id`) USING BTREE,
  ADD KEY `prodfourstatus` (`status`) USING BTREE,
  ADD KEY `prodfourwarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `prodfourresult_product` (`product_id`) USING BTREE,
  ADD KEY `prodfourunit_id` (`unit_id`) USING BTREE,
  ADD KEY `pfuser_id` (`user_id`),
  ADD KEY `pfcompany_id` (`company_id`);

--
-- Indexes for table `production_four_items`
--
ALTER TABLE `production_four_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proditemfourproduct_id` (`product_id`) USING BTREE,
  ADD KEY `prodfouritemproduction_one_id` (`production_four_id`) USING BTREE;

--
-- Indexes for table `production_ones`
--
ALTER TABLE `production_ones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodonecontact_id` (`contact_id`),
  ADD KEY `prodoneother_transaction` (`other_transaction_id`),
  ADD KEY `prodonestatus` (`status`),
  ADD KEY `prodonewarehouse_id` (`warehouse_id`),
  ADD KEY `prodoneresult_product` (`product_id`),
  ADD KEY `produtunit_id` (`unit_id`),
  ADD KEY `pocompany_id` (`company_id`),
  ADD KEY `pouser_id` (`user_id`);

--
-- Indexes for table `production_one_costs`
--
ALTER TABLE `production_one_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poccoa_id` (`coa_id`),
  ADD KEY `pocproduction_one_id` (`production_one_id`);

--
-- Indexes for table `production_one_items`
--
ALTER TABLE `production_one_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodoneitemproduction_one_id` (`production_one_id`),
  ADD KEY `proditemproduct_id` (`product_id`);

--
-- Indexes for table `production_threes`
--
ALTER TABLE `production_threes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `protreunit_id` (`unit_id`) USING BTREE,
  ADD KEY `protreresult_product` (`product_id`) USING BTREE,
  ADD KEY `protrewarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `protrestatus` (`status`) USING BTREE,
  ADD KEY `protrecontact_id` (`contact_id`) USING BTREE,
  ADD KEY `protreother_transaction` (`other_transaction_id`) USING BTREE,
  ADD KEY `ptcompany_id` (`company_id`),
  ADD KEY `ptuser_id` (`user_id`);

--
-- Indexes for table `production_three_items`
--
ALTER TABLE `production_three_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotreitemproduction_tre_id` (`production_three_id`) USING BTREE,
  ADD KEY `protreditemproduct_id` (`product_id`) USING BTREE;

--
-- Indexes for table `production_twos`
--
ALTER TABLE `production_twos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodtwocontact_id` (`contact_id`) USING BTREE,
  ADD KEY `prodtwoother_transaction` (`other_transaction_id`) USING BTREE,
  ADD KEY `prodtwostatus` (`status`) USING BTREE,
  ADD KEY `prodtwowarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `prodtworesult_product` (`product_id`) USING BTREE,
  ADD KEY `prodtwounit_id` (`unit_id`) USING BTREE,
  ADD KEY `ptwcompany_id` (`company_id`),
  ADD KEY `ptwuser_id` (`user_id`);

--
-- Indexes for table `production_two_items`
--
ALTER TABLE `production_two_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodtwoitemproduction_one_id` (`production_two_id`) USING BTREE,
  ADD KEY `prodtwitemproduct_id` (`product_id`) USING BTREE;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_products_product_categories` (`other_product_category_id`),
  ADD KEY `FK_products_units` (`other_unit_id`),
  ADD KEY `FK_products_coas` (`buy_account`),
  ADD KEY `FK_products_coas_2` (`sell_account`),
  ADD KEY `FK_products_coas_3` (`default_inventory_account`),
  ADD KEY `FK_products_other_taxes` (`buy_tax`),
  ADD KEY `FK_products_other_taxes_2` (`sell_tax`),
  ADD KEY `produser_id` (`user_id`),
  ADD KEY `prodcompany_id` (`company_id`);

--
-- Indexes for table `product_bundle_costs`
--
ALTER TABLE `product_bundle_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `probuncostcoa_id` (`coa_id`),
  ADD KEY `probuncostproduct_id` (`product_id`);

--
-- Indexes for table `product_bundle_items`
--
ALTER TABLE `product_bundle_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `probunitemproduct_id` (`product_id`),
  ADD KEY `probunitembunproduct_id` (`bundle_product_id`);

--
-- Indexes for table `purchase_deliveries`
--
ALTER TABLE `purchase_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchasedeliverycontact_id` (`contact_id`) USING BTREE,
  ADD KEY `purchasedeliverywarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `purchasedeliverystatus` (`status`) USING BTREE,
  ADD KEY `purchasedeliveryselected_po_id` (`selected_po_id`) USING BTREE,
  ADD KEY `purchasedeliveryother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `purchasedeliveryterm_id` (`term_id`) USING BTREE,
  ADD KEY `pdcompany_id` (`company_id`),
  ADD KEY `pduser_id` (`user_id`);

--
-- Indexes for table `purchase_delivery_items`
--
ALTER TABLE `purchase_delivery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdeliveryitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `pdeliveryitempurchase_delivery_id` (`purchase_delivery_id`) USING BTREE,
  ADD KEY `pdeliveryitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `pdeliveryitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `pdipurchase_order_item_id` (`purchase_order_item_id`);

--
-- Indexes for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchaseinvoicecontact_id` (`contact_id`) USING BTREE,
  ADD KEY `purchaseinvoiceterm_id` (`term_id`) USING BTREE,
  ADD KEY `purchaseinvoicewarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `purchaseinvoicestatus` (`status`) USING BTREE,
  ADD KEY `purchaseinvoiceselected_pd_id` (`selected_pd_id`) USING BTREE,
  ADD KEY `purchaseinvoiceother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `purchaseinvoiceselected_po_id` (`selected_po_id`) USING BTREE,
  ADD KEY `purchaseinvoiceselected_pq_id` (`selected_pq_id`) USING BTREE,
  ADD KEY `picompany_id` (`company_id`),
  ADD KEY `piuser_id` (`user_id`);

--
-- Indexes for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinvoiceitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `pinvoiceitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `pinvoiceitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `pinvoiceitempurchase_invoice_id` (`purchase_invoice_id`) USING BTREE,
  ADD KEY `piipurchase_order_item_id` (`purchase_order_item_id`);

--
-- Indexes for table `purchase_invoice_pos`
--
ALTER TABLE `purchase_invoice_pos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pipopo_id` (`purchase_order_id`) USING BTREE,
  ADD KEY `pipopurchase_invoice_id` (`purchase_invoice_id`) USING BTREE;

--
-- Indexes for table `purchase_invoice_po_items`
--
ALTER TABLE `purchase_invoice_po_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pipoipo_id` (`purchase_order_id`) USING BTREE,
  ADD KEY `pipoipurchase_invoice_id` (`purchase_invoice_id`) USING BTREE,
  ADD KEY `pipoiproduct_id` (`product_id`) USING BTREE,
  ADD KEY `pipoipurchase_order_item_id` (`purchase_order_item_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchaseorderstatus` (`status`) USING BTREE,
  ADD KEY `purchaseorderwarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `purchaseorderother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `purchaseorderterm_id` (`term_id`) USING BTREE,
  ADD KEY `purchaseordercontact_id` (`contact_id`) USING BTREE,
  ADD KEY `purchaseorderselected_pq_id` (`selected_pq_id`) USING BTREE,
  ADD KEY `pocompany_id` (`company_id`),
  ADD KEY `pouser_id` (`user_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `porderitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `porderitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `porderitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `porderitempurchase_order_id` (`purchase_order_id`) USING BTREE;

--
-- Indexes for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppaymentstatus` (`status`) USING BTREE,
  ADD KEY `ppaymentcontact_id` (`contact_id`) USING BTREE,
  ADD KEY `ppaymentother_payment_method_id` (`other_payment_method_id`) USING BTREE,
  ADD KEY `ppaymentaccount_id` (`account_id`) USING BTREE,
  ADD KEY `ppaymentother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `ppaymenttransaction_no_pi` (`transaction_no_pi`) USING BTREE,
  ADD KEY `ppcompany_id` (`company_id`),
  ADD KEY `ppuser_id` (`user_id`);

--
-- Indexes for table `purchase_payment_items`
--
ALTER TABLE `purchase_payment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppaymentitemspurchase_invoice_id` (`purchase_invoice_id`),
  ADD KEY `ppaymentitemspurchase_payment_id` (`purchase_payment_id`) USING BTREE;

--
-- Indexes for table `purchase_quotes`
--
ALTER TABLE `purchase_quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pquotecontact_id` (`contact_id`) USING BTREE,
  ADD KEY `pquoteterm_id` (`term_id`) USING BTREE,
  ADD KEY `pquotestatus` (`status`) USING BTREE,
  ADD KEY `pquoteother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `pqcompany_id` (`company_id`),
  ADD KEY `pquser_id` (`user_id`);

--
-- Indexes for table `purchase_quote_items`
--
ALTER TABLE `purchase_quote_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pquoteitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `pquoteitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `pquoteitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `pquoteitempurchase_quote_id` (`purchase_quote_id`) USING BTREE;

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prcompany_id` (`company_id`) USING BTREE,
  ADD KEY `pruser_id` (`user_id`) USING BTREE,
  ADD KEY `prcontact_id` (`contact_id`),
  ADD KEY `prother_transaction_id` (`other_transaction_id`),
  ADD KEY `prwarehouse_id` (`warehouse_id`),
  ADD KEY `prstatus` (`status`),
  ADD KEY `prselected_pi_id` (`selected_pi_id`) USING BTREE;

--
-- Indexes for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pritempurchase_return_id` (`purchase_return_id`) USING BTREE,
  ADD KEY `pritemproduct_id` (`product_id`),
  ADD KEY `pritemunit_id` (`unit_id`),
  ADD KEY `pritemtax_id` (`tax_id`),
  ADD KEY `pripurchase_invoice_item_id` (`purchase_invoice_item_id`) USING BTREE,
  ADD KEY `pripurchase_order_id` (`purchase_order_id`),
  ADD KEY `pripurchase_order_item_id` (`purchase_order_item_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sale_deliveries`
--
ALTER TABLE `sale_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saledeliveryselected_so_id` (`selected_so_id`) USING BTREE,
  ADD KEY `saledeliverystatus` (`status`) USING BTREE,
  ADD KEY `saledeliverywarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `saledeliverycontact_id` (`contact_id`) USING BTREE,
  ADD KEY `other_transaction_id` (`other_transaction_id`),
  ADD KEY `sdcompany_id` (`company_id`),
  ADD KEY `sduser_id` (`user_id`);

--
-- Indexes for table `sale_delivery_items`
--
ALTER TABLE `sale_delivery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemsale_delivery_id` (`sale_delivery_id`) USING BTREE,
  ADD KEY `itemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `itemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `itemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `itemsale_order_item_id` (`sale_order_item_id`) USING BTREE;

--
-- Indexes for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleinvoicecontact_id` (`contact_id`) USING BTREE,
  ADD KEY `saleinvoiceselected_sd_id` (`selected_sd_id`) USING BTREE,
  ADD KEY `saleinvoicestatus` (`status`) USING BTREE,
  ADD KEY `saleinvoicewarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `saleinvoiceterm_id` (`term_id`) USING BTREE,
  ADD KEY `saleinvoiceother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `saleinvoiceselected_so_id` (`selected_so_id`) USING BTREE,
  ADD KEY `saleinvoiceselected_sq_id` (`selected_sq_id`) USING BTREE,
  ADD KEY `sicompany_id` (`company_id`),
  ADD KEY `siuser_id` (`user_id`),
  ADD KEY `saleinvoiceselected_spk_id` (`selected_spk_id`) USING BTREE,
  ADD KEY `simarketting` (`marketting`);

--
-- Indexes for table `sale_invoice_costs`
--
ALTER TABLE `sale_invoice_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siccoa_id` (`coa_id`),
  ADD KEY `sicsale_invoice_id` (`sale_invoice_id`);

--
-- Indexes for table `sale_invoice_items`
--
ALTER TABLE `sale_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceitemtax_id` (`tax_id`) USING BTREE,
  ADD KEY `invoiceitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `invoiceitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `invoiceitemsale_invoice_id` (`sale_invoice_id`) USING BTREE,
  ADD KEY `siisale_order_item_id` (`sale_order_item_id`);

--
-- Indexes for table `sale_orders`
--
ALTER TABLE `sale_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saleordercontact_id` (`contact_id`) USING BTREE,
  ADD KEY `saleorderterm_id` (`term_id`) USING BTREE,
  ADD KEY `saleorderother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `saleorderwarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `saleorderselected_sq_id` (`selected_sq_id`) USING BTREE,
  ADD KEY `saleorderstatus` (`status`) USING BTREE,
  ADD KEY `socompany_id` (`company_id`),
  ADD KEY `souser_id` (`user_id`),
  ADD KEY `somarketting` (`marketting`);

--
-- Indexes for table `sale_order_items`
--
ALTER TABLE `sale_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderitemsale_order_id` (`sale_order_id`) USING BTREE,
  ADD KEY `orderitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `orderitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `orderitemtax_id` (`tax_id`) USING BTREE;

--
-- Indexes for table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spaccount_id` (`account_id`) USING BTREE,
  ADD KEY `spstatus` (`status`) USING BTREE,
  ADD KEY `sptransaction_no_si` (`transaction_no_si`) USING BTREE,
  ADD KEY `spcontact_id` (`contact_id`) USING BTREE,
  ADD KEY `spother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `spother_payment_method_id` (`other_payment_method_id`) USING BTREE,
  ADD KEY `spcompany_id` (`company_id`),
  ADD KEY `spuser_id` (`user_id`);

--
-- Indexes for table `sale_payment_items`
--
ALTER TABLE `sale_payment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spaymentitemspurchase_invoice_id` (`sale_invoice_id`) USING BTREE,
  ADD KEY `spaymentitemspurchase_payment_id` (`sale_payment_id`) USING BTREE;

--
-- Indexes for table `sale_quotes`
--
ALTER TABLE `sale_quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slquotestatus` (`status`) USING BTREE,
  ADD KEY `slquoteother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `slquoteterm_id` (`term_id`) USING BTREE,
  ADD KEY `slquotecontact_id` (`contact_id`) USING BTREE,
  ADD KEY `sqcompany_id` (`company_id`),
  ADD KEY `squser_id` (`user_id`);

--
-- Indexes for table `sale_quote_items`
--
ALTER TABLE `sale_quote_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salquoteitemsale_quote_id` (`sale_quote_id`) USING BTREE,
  ADD KEY `salquoteitemproduct_id` (`product_id`) USING BTREE,
  ADD KEY `salquoteitemunit_id` (`unit_id`) USING BTREE,
  ADD KEY `salquoteitemtax_id` (`tax_id`) USING BTREE;

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `srselected_si_id` (`selected_si_id`) USING BTREE,
  ADD KEY `srstatus` (`status`) USING BTREE,
  ADD KEY `srwarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `srother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `srcontact_id` (`contact_id`) USING BTREE,
  ADD KEY `sruser_id` (`user_id`) USING BTREE,
  ADD KEY `srcompany_id` (`company_id`) USING BTREE;

--
-- Indexes for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `srisale_return_id` (`sale_return_id`) USING BTREE,
  ADD KEY `srisale_order_id` (`sale_order_id`) USING BTREE,
  ADD KEY `sritax_id` (`tax_id`) USING BTREE,
  ADD KEY `sriunit_id` (`unit_id`) USING BTREE,
  ADD KEY `sriproduct_id` (`product_id`) USING BTREE,
  ADD KEY `srisale_order_item_id` (`sale_order_item_id`) USING BTREE,
  ADD KEY `srisale_invoice_item_id` (`sale_invoice_item_id`) USING BTREE;

--
-- Indexes for table `spks`
--
ALTER TABLE `spks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spkcompany_id` (`company_id`),
  ADD KEY `spkuser_id` (`user_id`),
  ADD KEY `spkcontact_id` (`contact_id`),
  ADD KEY `spkwarehouse_id` (`warehouse_id`),
  ADD KEY `spkother_transaction_id` (`other_transaction_id`),
  ADD KEY `spkstatus` (`status`);

--
-- Indexes for table `spk_items`
--
ALTER TABLE `spk_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spkitemproduct_id` (`product_id`),
  ADD KEY `spkitemspk_id` (`spk_id`),
  ADD KEY `spkitemstatus` (`status`),
  ADD KEY `spkitemselected_wip_id` (`selected_wip_id`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sawarehouse_id` (`warehouse_id`) USING BTREE,
  ADD KEY `saother_transaction_id` (`other_transaction_id`) USING BTREE,
  ADD KEY `sacoa_id` (`coa_id`) USING BTREE,
  ADD KEY `sacompany_id` (`company_id`),
  ADD KEY `sauser_id` (`user_id`);

--
-- Indexes for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_stock_adjustment_detail_products` (`product_id`),
  ADD KEY `FK_stock_adjustment_detail_stock_adjusments` (`stock_adjustment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `ucompany_id` (`company_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wcompany_id` (`company_id`),
  ADD KEY `wuser_id` (`user_id`);

--
-- Indexes for table `warehouse_details`
--
ALTER TABLE `warehouse_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_warehouse_detail_warehouses` (`warehouse_id`),
  ADD KEY `FK_warehouse_detail_products` (`product_id`);

--
-- Indexes for table `warehouse_transfers`
--
ALTER TABLE `warehouse_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wtcompany_id` (`company_id`),
  ADD KEY `wtuser_id` (`user_id`),
  ADD KEY `wtfrom_warehouse_id` (`from_warehouse_id`),
  ADD KEY `wtto_warehouse_id` (`to_warehouse_id`),
  ADD KEY `wtother_transaction_id` (`other_transaction_id`);

--
-- Indexes for table `warehouse_transfer_items`
--
ALTER TABLE `warehouse_transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wtiwarehouse_transfer_id` (`warehouse_transfer_id`),
  ADD KEY `wtiproduct_id` (`product_id`);

--
-- Indexes for table `wips`
--
ALTER TABLE `wips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wipcompany_id` (`company_id`),
  ADD KEY `wipuser_id` (`user_id`),
  ADD KEY `wipselected_spk_id` (`selected_spk_id`),
  ADD KEY `wipcontact_id` (`contact_id`),
  ADD KEY `wipother_transaction_id` (`other_transaction_id`),
  ADD KEY `wipwarehouse_id` (`warehouse_id`),
  ADD KEY `wipstatus` (`status`),
  ADD KEY `wipresult_product` (`result_product`);

--
-- Indexes for table `wip_items`
--
ALTER TABLE `wip_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wipitemproduct_id` (`product_id`),
  ADD KEY `wipitemwip_id` (`wip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details`
--
ALTER TABLE `asset_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashbanks`
--
ALTER TABLE `cashbanks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashbank_items`
--
ALTER TABLE `cashbank_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coas`
--
ALTER TABLE `coas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `coa_categories`
--
ALTER TABLE `coa_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `coa_details`
--
ALTER TABLE `coa_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_accounts`
--
ALTER TABLE `default_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_limit_balances`
--
ALTER TABLE `history_limit_balances`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_entry_items`
--
ALTER TABLE `journal_entry_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logo_uploadeds`
--
ALTER TABLE `logo_uploadeds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `other_payment_methods`
--
ALTER TABLE `other_payment_methods`
  MODIFY `id` int(19) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `other_product_categories`
--
ALTER TABLE `other_product_categories`
  MODIFY `id` int(19) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `other_statuses`
--
ALTER TABLE `other_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `other_taxes`
--
ALTER TABLE `other_taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `other_terms`
--
ALTER TABLE `other_terms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `other_transactions`
--
ALTER TABLE `other_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_units`
--
ALTER TABLE `other_units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_fours`
--
ALTER TABLE `production_fours`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_four_items`
--
ALTER TABLE `production_four_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_ones`
--
ALTER TABLE `production_ones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_one_costs`
--
ALTER TABLE `production_one_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_one_items`
--
ALTER TABLE `production_one_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_threes`
--
ALTER TABLE `production_threes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_three_items`
--
ALTER TABLE `production_three_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_twos`
--
ALTER TABLE `production_twos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_two_items`
--
ALTER TABLE `production_two_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2300;

--
-- AUTO_INCREMENT for table `product_bundle_costs`
--
ALTER TABLE `product_bundle_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_bundle_items`
--
ALTER TABLE `product_bundle_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_deliveries`
--
ALTER TABLE `purchase_deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_delivery_items`
--
ALTER TABLE `purchase_delivery_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoice_pos`
--
ALTER TABLE `purchase_invoice_pos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoice_po_items`
--
ALTER TABLE `purchase_invoice_po_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payment_items`
--
ALTER TABLE `purchase_payment_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_quotes`
--
ALTER TABLE `purchase_quotes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_quote_items`
--
ALTER TABLE `purchase_quote_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sale_deliveries`
--
ALTER TABLE `sale_deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_delivery_items`
--
ALTER TABLE `sale_delivery_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_invoice_costs`
--
ALTER TABLE `sale_invoice_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_invoice_items`
--
ALTER TABLE `sale_invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_orders`
--
ALTER TABLE `sale_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_order_items`
--
ALTER TABLE `sale_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payments`
--
ALTER TABLE `sale_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payment_items`
--
ALTER TABLE `sale_payment_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_quotes`
--
ALTER TABLE `sale_quotes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_quote_items`
--
ALTER TABLE `sale_quote_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spks`
--
ALTER TABLE `spks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spk_items`
--
ALTER TABLE `spk_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouse_details`
--
ALTER TABLE `warehouse_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_transfers`
--
ALTER TABLE `warehouse_transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_transfer_items`
--
ALTER TABLE `warehouse_transfer_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wips`
--
ALTER TABLE `wips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wip_items`
--
ALTER TABLE `wip_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assasset_account` FOREIGN KEY (`asset_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asscredited_account` FOREIGN KEY (`credited_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_details`
--
ALTER TABLE `asset_details`
  ADD CONSTRAINT `assdetaccumulated_depreciate_account` FOREIGN KEY (`accumulated_depreciate_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cashbanks`
--
ALTER TABLE `cashbanks`
  ADD CONSTRAINT `cbcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbdeposit_to` FOREIGN KEY (`deposit_to`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbpay_from` FOREIGN KEY (`pay_from`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbtransfer_from` FOREIGN KEY (`transfer_from`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cashbank_items`
--
ALTER TABLE `cashbank_items`
  ADD CONSTRAINT `cbcashbank` FOREIGN KEY (`cashbank_id`) REFERENCES `cashbanks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbdreceive_from` FOREIGN KEY (`receive_from`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbdtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cbiexpense_id` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coas`
--
ALTER TABLE `coas`
  ADD CONSTRAINT `coa_category_id` FOREIGN KEY (`coa_category_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coa_details`
--
ALTER TABLE `coa_details`
  ADD CONSTRAINT `FK_coa_details_contacts` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coaother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD CONSTRAINT `company_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contactaccount_payable` FOREIGN KEY (`account_payable_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contactaccount_receivable` FOREIGN KEY (`account_receivable_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contactterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `default_accounts`
--
ALTER TABLE `default_accounts`
  ADD CONSTRAINT `FK_table_mapping_co_as` FOREIGN KEY (`account_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expensescontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensesother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensespay_from_coa_id` FOREIGN KEY (`pay_from_coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensespayment_method_id` FOREIGN KEY (`payment_method_id`) REFERENCES `other_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensesstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensesterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD CONSTRAINT `expenseitemexpense_id` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensesitemcoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expensesitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_limit_balances`
--
ALTER TABLE `history_limit_balances`
  ADD CONSTRAINT `history_limit_balancescontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_limit_balancesuser_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `journal_entry_items`
--
ALTER TABLE `journal_entry_items`
  ADD CONSTRAINT `jeicoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jeijournal_entry_id` FOREIGN KEY (`journal_entry_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `other_taxes`
--
ALTER TABLE `other_taxes`
  ADD CONSTRAINT `taxbuy_tax_account` FOREIGN KEY (`buy_tax_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taxsell_tax_account` FOREIGN KEY (`sell_tax_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `other_transactions`
--
ALTER TABLE `other_transactions`
  ADD CONSTRAINT `other_transcontact` FOREIGN KEY (`contact`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `other_transstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_fours`
--
ALTER TABLE `production_fours`
  ADD CONSTRAINT `prodfourcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodfourother_transaction` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodfourresult_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodfourstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodfourunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodfourwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_four_items`
--
ALTER TABLE `production_four_items`
  ADD CONSTRAINT `prodfouritemproduction_one_id` FOREIGN KEY (`production_four_id`) REFERENCES `production_fours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proditemfourproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_ones`
--
ALTER TABLE `production_ones`
  ADD CONSTRAINT `prodonecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodoneother_transaction` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodoneresult_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodonestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodonewarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_one_costs`
--
ALTER TABLE `production_one_costs`
  ADD CONSTRAINT `poccoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pocproduction_one_id` FOREIGN KEY (`production_one_id`) REFERENCES `production_ones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_one_items`
--
ALTER TABLE `production_one_items`
  ADD CONSTRAINT `proditemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodoneitemproduction_one_id` FOREIGN KEY (`production_one_id`) REFERENCES `production_ones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_threes`
--
ALTER TABLE `production_threes`
  ADD CONSTRAINT `protrecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protreother_transaction` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protreresult_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protrestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protreunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protrewarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_three_items`
--
ALTER TABLE `production_three_items`
  ADD CONSTRAINT `prodotreitemproduction_tre_id` FOREIGN KEY (`production_three_id`) REFERENCES `production_threes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `protreditemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_twos`
--
ALTER TABLE `production_twos`
  ADD CONSTRAINT `prodtwocontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtwoother_transaction` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtworesult_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtwostatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtwounit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtwowarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production_two_items`
--
ALTER TABLE `production_two_items`
  ADD CONSTRAINT `prodtwitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodtwoitemproduction_one_id` FOREIGN KEY (`production_two_id`) REFERENCES `production_twos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products_coas` FOREIGN KEY (`buy_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_coas_2` FOREIGN KEY (`sell_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_coas_3` FOREIGN KEY (`default_inventory_account`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_other_taxes` FOREIGN KEY (`buy_tax`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_other_taxes_2` FOREIGN KEY (`sell_tax`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_product_categories` FOREIGN KEY (`other_product_category_id`) REFERENCES `other_product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_units` FOREIGN KEY (`other_unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_bundle_costs`
--
ALTER TABLE `product_bundle_costs`
  ADD CONSTRAINT `probuncostcoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `probuncostproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_bundle_items`
--
ALTER TABLE `product_bundle_items`
  ADD CONSTRAINT `probunitembunproduct_id` FOREIGN KEY (`bundle_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `probunitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_deliveries`
--
ALTER TABLE `purchase_deliveries`
  ADD CONSTRAINT `purchasedeliverycontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasedeliveryother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasedeliveryselected_po_id` FOREIGN KEY (`selected_po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasedeliverystatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasedeliveryterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchasedeliverywarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_delivery_items`
--
ALTER TABLE `purchase_delivery_items`
  ADD CONSTRAINT `pdeliveryitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdeliveryitempurchase_delivery_id` FOREIGN KEY (`purchase_delivery_id`) REFERENCES `purchase_deliveries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdeliveryitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdeliveryitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdipurchase_order_item_id` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  ADD CONSTRAINT `purchaseinvoicecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoiceother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoiceselected_pd_id` FOREIGN KEY (`selected_pd_id`) REFERENCES `purchase_deliveries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoiceselected_po_id` FOREIGN KEY (`selected_po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoiceselected_pq_id` FOREIGN KEY (`selected_pq_id`) REFERENCES `purchase_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoicestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoiceterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseinvoicewarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_invoice_items`
--
ALTER TABLE `purchase_invoice_items`
  ADD CONSTRAINT `piipurchase_order_item_id` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinvoiceitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinvoiceitempurchase_invoice_id` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinvoiceitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinvoiceitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_invoice_pos`
--
ALTER TABLE `purchase_invoice_pos`
  ADD CONSTRAINT `pipopo_id` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pipopurchase_invoice_id` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_invoice_po_items`
--
ALTER TABLE `purchase_invoice_po_items`
  ADD CONSTRAINT `pipoipo_id` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pipoiproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pipoipurchase_invoice_id` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pipoipurchase_order_item_id` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchaseordercontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseorderother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseorderselected_pq_id` FOREIGN KEY (`selected_pq_id`) REFERENCES `purchase_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseorderstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseorderterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchaseorderwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `porderitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `porderitempurchase_order_id` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `porderitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `porderitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  ADD CONSTRAINT `ppaymentaccount_id` FOREIGN KEY (`account_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymentcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymentother_payment_method_id` FOREIGN KEY (`other_payment_method_id`) REFERENCES `other_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymentother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymentstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymenttransaction_no_pi` FOREIGN KEY (`transaction_no_pi`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_payment_items`
--
ALTER TABLE `purchase_payment_items`
  ADD CONSTRAINT `ppaymentitemspurchase_invoice_id` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ppaymentitemspurchase_payment_id` FOREIGN KEY (`purchase_payment_id`) REFERENCES `purchase_payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_quotes`
--
ALTER TABLE `purchase_quotes`
  ADD CONSTRAINT `pquotecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquoteother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquotestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquoteterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_quote_items`
--
ALTER TABLE `purchase_quote_items`
  ADD CONSTRAINT `pquoteitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquoteitempurchase_quote_id` FOREIGN KEY (`purchase_quote_id`) REFERENCES `purchase_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquoteitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pquoteitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `prcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prselected_pi_id` FOREIGN KEY (`selected_pi_id`) REFERENCES `purchase_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD CONSTRAINT `pripurchase_invoice_item_id` FOREIGN KEY (`purchase_invoice_item_id`) REFERENCES `purchase_invoice_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pripurchase_order_id` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pripurchase_order_item_id` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pritemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pritempurchase_return_id` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pritemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pritemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_deliveries`
--
ALTER TABLE `sale_deliveries`
  ADD CONSTRAINT `saledeliverycontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saledeliveryselected_so_id` FOREIGN KEY (`selected_so_id`) REFERENCES `sale_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saledeliverystatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saledeliverywarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_delivery_items`
--
ALTER TABLE `sale_delivery_items`
  ADD CONSTRAINT `itemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemsale_delivery_id` FOREIGN KEY (`sale_delivery_id`) REFERENCES `sale_deliveries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemsale_order_item_id` FOREIGN KEY (`sale_order_item_id`) REFERENCES `sale_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  ADD CONSTRAINT `saleinvoicecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceselected_sd_id` FOREIGN KEY (`selected_sd_id`) REFERENCES `sale_deliveries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceselected_so_id` FOREIGN KEY (`selected_so_id`) REFERENCES `sale_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceselected_spk_id` FOREIGN KEY (`selected_spk_id`) REFERENCES `spks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceselected_sq_id` FOREIGN KEY (`selected_sq_id`) REFERENCES `sale_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoicestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoiceterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleinvoicewarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simarketting` FOREIGN KEY (`marketting`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_invoice_costs`
--
ALTER TABLE `sale_invoice_costs`
  ADD CONSTRAINT `siccoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sicsale_invoice_id` FOREIGN KEY (`sale_invoice_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_invoice_items`
--
ALTER TABLE `sale_invoice_items`
  ADD CONSTRAINT `invoiceitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoiceitemsale_invoice_id` FOREIGN KEY (`sale_invoice_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoiceitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoiceitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siisale_order_item_id` FOREIGN KEY (`sale_order_item_id`) REFERENCES `sale_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_orders`
--
ALTER TABLE `sale_orders`
  ADD CONSTRAINT `saleordercontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleorderother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleorderselected_sq_id` FOREIGN KEY (`selected_sq_id`) REFERENCES `sale_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleorderstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleorderterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saleorderwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `somarketting` FOREIGN KEY (`marketting`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_order_items`
--
ALTER TABLE `sale_order_items`
  ADD CONSTRAINT `orderitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitemsale_order_id` FOREIGN KEY (`sale_order_id`) REFERENCES `sale_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD CONSTRAINT `spaccount_id` FOREIGN KEY (`account_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spother_payment_method_id` FOREIGN KEY (`other_payment_method_id`) REFERENCES `other_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sptransaction_no_si` FOREIGN KEY (`transaction_no_si`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_payment_items`
--
ALTER TABLE `sale_payment_items`
  ADD CONSTRAINT `spaymentitemspurchase_invoice_id` FOREIGN KEY (`sale_invoice_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spaymentitemspurchase_payment_id` FOREIGN KEY (`sale_payment_id`) REFERENCES `sale_payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_quotes`
--
ALTER TABLE `sale_quotes`
  ADD CONSTRAINT `slquotecontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slquoteother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slquotestatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slquoteterm_id` FOREIGN KEY (`term_id`) REFERENCES `other_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_quote_items`
--
ALTER TABLE `sale_quote_items`
  ADD CONSTRAINT `salquoteitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salquoteitemsale_quote_id` FOREIGN KEY (`sale_quote_id`) REFERENCES `sale_quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salquoteitemtax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salquoteitemunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `srcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srselected_si_id` FOREIGN KEY (`selected_si_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sruser_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD CONSTRAINT `sriproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srisale_invoice_item_id` FOREIGN KEY (`sale_invoice_item_id`) REFERENCES `sale_invoice_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srisale_order_id` FOREIGN KEY (`sale_order_id`) REFERENCES `sale_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srisale_order_item_id` FOREIGN KEY (`sale_order_item_id`) REFERENCES `sale_order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `srisale_return_id` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sritax_id` FOREIGN KEY (`tax_id`) REFERENCES `other_taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sriunit_id` FOREIGN KEY (`unit_id`) REFERENCES `other_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spks`
--
ALTER TABLE `spks`
  ADD CONSTRAINT `spkcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spk_items`
--
ALTER TABLE `spk_items`
  ADD CONSTRAINT `spkitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkitemselected_wip_id` FOREIGN KEY (`selected_wip_id`) REFERENCES `wips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkitemspk_id` FOREIGN KEY (`spk_id`) REFERENCES `spks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spkitemstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD CONSTRAINT `sacoa_id` FOREIGN KEY (`coa_id`) REFERENCES `coas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`),
  ADD CONSTRAINT `sawarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD CONSTRAINT `FK_stock_adjustment_detail_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_stock_adjustment_detail_stock_adjusments` FOREIGN KEY (`stock_adjustment_id`) REFERENCES `stock_adjustments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warehouse_details`
--
ALTER TABLE `warehouse_details`
  ADD CONSTRAINT `FK_warehouse_detail_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_warehouse_detail_warehouses` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warehouse_transfers`
--
ALTER TABLE `warehouse_transfers`
  ADD CONSTRAINT `wtfrom_warehouse_id` FOREIGN KEY (`from_warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wtother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wtto_warehouse_id` FOREIGN KEY (`to_warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warehouse_transfer_items`
--
ALTER TABLE `warehouse_transfer_items`
  ADD CONSTRAINT `wtiproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wtiwarehouse_transfer_id` FOREIGN KEY (`warehouse_transfer_id`) REFERENCES `warehouse_transfers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wips`
--
ALTER TABLE `wips`
  ADD CONSTRAINT `wipcontact_id` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipother_transaction_id` FOREIGN KEY (`other_transaction_id`) REFERENCES `other_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipresult_product` FOREIGN KEY (`result_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipselected_spk_id` FOREIGN KEY (`selected_spk_id`) REFERENCES `spks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipstatus` FOREIGN KEY (`status`) REFERENCES `other_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipwarehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wip_items`
--
ALTER TABLE `wip_items`
  ADD CONSTRAINT `wipitemproduct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wipitemwip_id` FOREIGN KEY (`wip_id`) REFERENCES `wips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
