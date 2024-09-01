-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 11, 2024 at 12:11 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mybillingnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `areas_area_name_unique` (`area_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Dhanmondi', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Kolabagan', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_pools`
--

DROP TABLE IF EXISTS `assign_pools`;
CREATE TABLE IF NOT EXISTS `assign_pools` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_statuses`
--

DROP TABLE IF EXISTS `billing_statuses`;
CREATE TABLE IF NOT EXISTS `billing_statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `billing_status_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billing_statuses`
--

INSERT INTO `billing_statuses` (`id`, `billing_status_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Free', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `block_reasons`
--

DROP TABLE IF EXISTS `block_reasons`;
CREATE TABLE IF NOT EXISTS `block_reasons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `block_reason_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_reason_desc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `block_reasons_block_reason_name_deleted_at_unique` (`block_reason_name`,`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boxes`
--

DROP TABLE IF EXISTS `boxes`;
CREATE TABLE IF NOT EXISTS `boxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `box_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subzone_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boxes_subzone_id_foreign` (`subzone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boxes`
--

INSERT INTO `boxes` (`id`, `box_name`, `subzone_id`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Box 1', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Box 2', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_router_changes`
--

DROP TABLE IF EXISTS `bulk_router_changes`;
CREATE TABLE IF NOT EXISTS `bulk_router_changes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

DROP TABLE IF EXISTS `business_types`;
CREATE TABLE IF NOT EXISTS `business_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_types`
--

INSERT INTO `business_types` (`id`, `business_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Shop', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Corporate', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `change_client_statuses`
--

DROP TABLE IF EXISTS `change_client_statuses`;
CREATE TABLE IF NOT EXISTS `change_client_statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_hotspot_to_pppoes`
--

DROP TABLE IF EXISTS `change_hotspot_to_pppoes`;
CREATE TABLE IF NOT EXISTS `change_hotspot_to_pppoes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `static_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_pass_ip_macs`
--

DROP TABLE IF EXISTS `change_pass_ip_macs`;
CREATE TABLE IF NOT EXISTS `change_pass_ip_macs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_pass` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_pass` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_mac` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_mac` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_pppoe_to_hotspots`
--

DROP TABLE IF EXISTS `change_pppoe_to_hotspots`;
CREATE TABLE IF NOT EXISTS `change_pppoe_to_hotspots` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `static_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_router_logs`
--

DROP TABLE IF EXISTS `change_router_logs`;
CREATE TABLE IF NOT EXISTS `change_router_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_router` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_router` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_userid_logs`
--

DROP TABLE IF EXISTS `change_userid_logs`;
CREATE TABLE IF NOT EXISTS `change_userid_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_controls`
--

DROP TABLE IF EXISTS `client_controls`;
CREATE TABLE IF NOT EXISTS `client_controls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_or_husband_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int NOT NULL,
  `blood_group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_form_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `road_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_flat_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` int NOT NULL,
  `district_id` int NOT NULL,
  `upazila_id` int NOT NULL,
  `tbl_zone_id` bigint UNSIGNED NOT NULL,
  `subzone_id` bigint UNSIGNED NOT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_type_id` int NOT NULL,
  `connection_employee_id` int NOT NULL,
  `reference_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_person` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_pic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_form_pic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_client_category_id` bigint UNSIGNED NOT NULL,
  `sub_office_id` int NOT NULL,
  `reseller_id` int NOT NULL DEFAULT '0',
  `tbl_bill_cycle_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_tbl_zone_id_foreign` (`tbl_zone_id`),
  KEY `customers_subzone_id_foreign` (`subzone_id`),
  KEY `customers_tbl_client_category_id_foreign` (`tbl_client_category_id`),
  KEY `customers_tbl_bill_cycle_id_foreign` (`tbl_bill_cycle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `father_or_husband_name`, `mother_name`, `gender`, `blood_group`, `date_of_birth`, `reg_form_no`, `occupation`, `vat_status`, `nid_number`, `email`, `fb_id`, `mobile1`, `mobile2`, `phone`, `road_no`, `house_flat_no`, `area_id`, `district_id`, `upazila_id`, `tbl_zone_id`, `subzone_id`, `latitude`, `longitude`, `present_address`, `permanent_address`, `remarks`, `business_type_id`, `connection_employee_id`, `reference_by`, `contract_person`, `profile_pic`, `nid_pic`, `reg_form_pic`, `account_no`, `tbl_client_category_id`, `sub_office_id`, `reseller_id`, `tbl_bill_cycle_id`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Savannah Bradshaw', 'Dieter Holmes', 'Price Hays', 1, '5', '272592000', '375', 'Alias in id recusand', 'Yes', '436', 'xufoh@mailinator.com', 'Do voluptate consequ', 'Ut officiis quia est', 'Voluptas dolor exerc', '+1 (377) 791-2208', 'Ipsum maxime velit m', 'Animi cum eu quia e', 1, 3, 1, 2, 1, 'Amet sint ex esse', 'Lorem dicta vel iste', 'Quo sed ut fugiat ve', 'Qui officia ratione', 'Omnis laboriosam ve', 2, 5, 'Lorem illo alias fug', 'Consectetur cillum', '', '', '', '1', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, '2024-07-10 03:23:11', '2024-07-10 03:23:11'),
(2, 'Constance Bray', 'Debra Jensen', 'Jolie Ryan', 2, '1', '172972800', '253', 'Lorem rem recusandae', 'Yes', '705', 'gokalu@mailinator.com', 'Sint qui consequatur', 'Reprehenderit quia m', 'Eos nihil et dolore', '+1 (538) 142-6316', 'Aliqua Laudantium', 'Numquam vel est cum', 1, 4, 1, 2, 2, 'Est odio sunt autem', 'Aut voluptate facili', 'Autem dolores et neq', 'Voluptas tempor reru', 'Quibusdam est qui el', 2, 5, 'Ratione commodi unde', 'Eum esse sit qui di', '', '', '', '2', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, '2024-07-10 03:43:30', '2024-07-10 03:43:30'),
(3, 'Thane Chang', 'Addison Benson', 'Jessica Turner', 1, '0', '1704067200', '778', 'Id proident qui ma', 'Yes', '655', 'nepukof@mailinator.com', 'Vero qui earum qui d', 'Eum delectus quo su', 'Qui quo et sapiente', '+1 (838) 865-6494', 'Aut incididunt eiusm', 'Dolor est quas qui d', 1, 3, 1, 2, 1, 'Ad dolores voluptate', 'Ut ipsa sed est obc', 'Voluptatem eveniet', 'Ullamco sit sequi d', 'Magnam omnis molesti', 2, 5, 'Est tenetur velit v', 'Porro provident pra', '', '', '', '3', 1, 2, 0, NULL, NULL, NULL, NULL, NULL, '2024-07-10 07:15:36', '2024-07-10 07:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `customer_profiles`
--

DROP TABLE IF EXISTS `customer_profiles`;
CREATE TABLE IF NOT EXISTS `customer_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_vendors`
--

DROP TABLE IF EXISTS `device_vendors`;
CREATE TABLE IF NOT EXISTS `device_vendors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_vendor_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `bn_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Barishal', '', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniqid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_html` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_stat` int NOT NULL,
  `receiver_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_attendence_summaries`
--

DROP TABLE IF EXISTS `hrm_attendence_summaries`;
CREATE TABLE IF NOT EXISTS `hrm_attendence_summaries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `shift_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `total_time` double NOT NULL,
  `over_time` double NOT NULL,
  `late_mark` int NOT NULL DEFAULT '0',
  `early_mark` int NOT NULL DEFAULT '0',
  `leave_mark` int NOT NULL DEFAULT '0',
  `leave_type` int NOT NULL DEFAULT '0',
  `gov_holiday` int NOT NULL DEFAULT '0',
  `weekly_holiday` int NOT NULL DEFAULT '0',
  `absent` int NOT NULL DEFAULT '0',
  `administrative` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hrm_attendence_summaries_employee_id_deleted_at_unique` (`employee_id`,`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_increments`
--

DROP TABLE IF EXISTS `hrm_increments`;
CREATE TABLE IF NOT EXISTS `hrm_increments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL,
  `previous_gross` double NOT NULL,
  `increment_percent` double NOT NULL,
  `increment_amount` double NOT NULL,
  `current_gross` double NOT NULL,
  `increment_type` int NOT NULL,
  `entry_date` datetime NOT NULL,
  `entry_by` int NOT NULL,
  `administrative_status` int NOT NULL,
  `administrative_by` int NOT NULL,
  `administrative_date` datetime NOT NULL,
  `approve_status` int NOT NULL,
  `approve_date` datetime NOT NULL,
  `approve_by` int NOT NULL,
  `status` int DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_id` (`emp_id`,`month`,`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_increment_types`
--

DROP TABLE IF EXISTS `hrm_increment_types`;
CREATE TABLE IF NOT EXISTS `hrm_increment_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_level`
--

DROP TABLE IF EXISTS `hrm_level`;
CREATE TABLE IF NOT EXISTS `hrm_level` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `level_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_shift_setup`
--

DROP TABLE IF EXISTS `hrm_shift_setup`;
CREATE TABLE IF NOT EXISTS `hrm_shift_setup` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `shift_id` bigint UNSIGNED NOT NULL,
  `shift_team_id` bigint UNSIGNED NOT NULL,
  `sun` int NOT NULL,
  `mon` int NOT NULL,
  `tue` int NOT NULL,
  `wed` int NOT NULL,
  `thu` int NOT NULL,
  `fri` int NOT NULL,
  `sat` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hrm_shift_setup_team_id_foreign` (`team_id`),
  KEY `hrm_shift_setup_shift_id_foreign` (`shift_id`),
  KEY `hrm_shift_setup_shift_team_id_foreign` (`shift_team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_tbl_shift`
--

DROP TABLE IF EXISTS `hrm_tbl_shift`;
CREATE TABLE IF NOT EXISTS `hrm_tbl_shift` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `late_time` time DEFAULT NULL,
  `begining_start` time NOT NULL,
  `begining_end` time NOT NULL,
  `out_start` time NOT NULL,
  `out_end` time NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_types`
--

DROP TABLE IF EXISTS `invoice_types`;
CREATE TABLE IF NOT EXISTS `invoice_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_types`
--

INSERT INTO `invoice_types` (`id`, `invoice_type_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Weekly', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE IF NOT EXISTS `ips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `package` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mas_banks`
--

DROP TABLE IF EXISTS `mas_banks`;
CREATE TABLE IF NOT EXISTS `mas_banks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mas_departments`
--

DROP TABLE IF EXISTS `mas_departments`;
CREATE TABLE IF NOT EXISTS `mas_departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mas_departments`
--

INSERT INTO `mas_departments` (`id`, `department`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'IT', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mas_designation`
--

DROP TABLE IF EXISTS `mas_designation`;
CREATE TABLE IF NOT EXISTS `mas_designation` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mas_designation`
--

INSERT INTO `mas_designation` (`id`, `designation`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Manager', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mas_employees`
--

DROP TABLE IF EXISTS `mas_employees`;
CREATE TABLE IF NOT EXISTS `mas_employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_pin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joing` date NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suboffice_id` int NOT NULL,
  `payment_mode` int NOT NULL,
  `bank_id` int NOT NULL,
  `acc_no` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_id` int NOT NULL,
  `salry_status` int NOT NULL,
  `last_increment_date` date NOT NULL,
  `last_increment_amount` double NOT NULL,
  `blood_group` int NOT NULL,
  `mobile2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_station` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_resig` date NOT NULL,
  `birth_certificate` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_promotion` date NOT NULL,
  `system_user_id` int NOT NULL,
  `last_promotion_date` date NOT NULL,
  `mas_employees` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provision_days` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `e-tin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_group_id` int NOT NULL,
  `reporting_manager` int NOT NULL,
  `reporting_manager_des` int NOT NULL,
  `emp_type_name` int NOT NULL,
  `date_of_permanent` date NOT NULL,
  `roster_shift` int NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mas_employees_department_id_foreign` (`department_id`),
  KEY `mas_employees_designation_id_foreign` (`designation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mas_employees`
--

INSERT INTO `mas_employees` (`id`, `employee_name`, `emp_no`, `emp_pin`, `emp_name`, `date_of_birth`, `date_of_joing`, `department_id`, `designation_id`, `address`, `mobile`, `email`, `suboffice_id`, `payment_mode`, `bank_id`, `acc_no`, `shift_id`, `salry_status`, `last_increment_date`, `last_increment_amount`, `blood_group`, `mobile2`, `work_station`, `father_name`, `date_of_resig`, `birth_certificate`, `gender`, `last_promotion`, `system_user_id`, `last_promotion_date`, `mas_employees`, `image`, `provision_days`, `e-tin`, `user_group_id`, `reporting_manager`, `reporting_manager_des`, `emp_type_name`, `date_of_permanent`, `roster_shift`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 'Abdullah\r\n', '1', '1', '1', '2002-01-01', '2024-06-01', 1, 1, '1', '1', '1', 1, 1, 1, '1', 1, 1, '2024-06-01', 1, 1, '1', '1', '1', '2024-06-01', '1', '1', '2024-06-01', 1, '2024-06-01', '1', '1', '1', '1', 1, 1, 11, 1, '2024-06-01', 11, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mas_invoices`
--

DROP TABLE IF EXISTS `mas_invoices`;
CREATE TABLE IF NOT EXISTS `mas_invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_number` int NOT NULL,
  `bill_number` int NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_period` date NOT NULL,
  `client_id` int NOT NULL,
  `remarks` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cur_arrear` double NOT NULL,
  `pre_arrear` double NOT NULL,
  `vatper` double NOT NULL,
  `vat` double NOT NULL DEFAULT '0',
  `bill_amount` double NOT NULL,
  `total_bill` double NOT NULL DEFAULT '0',
  `avat` double DEFAULT NULL,
  `abill_amount` double DEFAULT NULL,
  `atotal_bill` double DEFAULT NULL,
  `collection_amnt` double DEFAULT NULL,
  `ait_adjustment` double DEFAULT NULL,
  `ait_adj_date` date DEFAULT NULL,
  `vat_adjust_ment` double DEFAULT NULL,
  `vat_adjust_date` date NOT NULL,
  `other_adjustment` double NOT NULL,
  `discount_amnt` double NOT NULL,
  `discount_date` date NOT NULL,
  `downtimeadjust` double NOT NULL,
  `comments` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceobjet_id_pro` int NOT NULL,
  `receive_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `view_status` int NOT NULL DEFAULT '0',
  `entry_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `entry_date` date DEFAULT NULL,
  `update_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `update_date` date DEFAULT NULL,
  `invoice_cat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_add_item` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_add_amount` double NOT NULL,
  `adv_rec` double NOT NULL,
  `unit` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_amnt` double NOT NULL,
  `client_type` int NOT NULL,
  `next_inv_date` date NOT NULL,
  `project_id` int NOT NULL,
  `journal_status` int NOT NULL,
  `journal_id` int NOT NULL,
  `work_order` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_order_date` date NOT NULL,
  `last_col_date` date NOT NULL,
  `advrec` double NOT NULL,
  `serv_id` int NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `full_pay` int NOT NULL,
  `invoice_cat_id` int NOT NULL,
  `discount_onsale` double NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `tbl_invoice_cat_id` bigint UNSIGNED NOT NULL,
  `tbl_srv_type_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mas_invoices_customer_id_foreign` (`customer_id`),
  KEY `mas_invoices_tbl_invoice_cat_id_foreign` (`tbl_invoice_cat_id`),
  KEY `mas_invoices_tbl_srv_type_id_foreign` (`tbl_srv_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mas_sms`
--

DROP TABLE IF EXISTS `mas_sms`;
CREATE TABLE IF NOT EXISTS `mas_sms` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sms_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` int NOT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int NOT NULL,
  `is_parent` tinyint(1) NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `pid`, `route`, `level`, `is_parent`, `icon`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Zones', 14, 'zone', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(3, 'Block Reason', 14, 'blockreason', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(4, 'Business Type', 14, 'businesstype', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(5, 'Suboffice', 14, 'suboffice', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(6, 'Department', 14, 'department', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(7, 'Task Progress', 14, 'taskprogress', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(8, 'Variables', 14, 'variables', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(9, 'Designation', 14, 'designation', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(10, 'Area', 14, 'area', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(11, 'Router', 15, 'router', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(12, 'Static IP', 15, 'staticip', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(13, 'Nas List', 15, 'nas', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(14, 'Global Setup', 0, '#', 0, 1, '<i class=\"fa-solid fa-outdent\"></i>', 1, '1', '1', NULL, NULL, '2024-02-28 13:24:41', '2024-02-28 13:24:41'),
(15, 'Radius', 0, '#', 0, 1, '<i class=\"fa-solid fa-microchip\"></i>', 1, '1', '1', NULL, NULL, '2024-02-28 13:24:41', '2024-02-28 13:24:41'),
(16, 'Mikrotik Graph', 14, 'mikrotikgraph', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(17, 'IP', 15, 'ip', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(18, 'Assign Pool', 15, 'assignpool', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(19, 'Client Control', 15, 'clientcontrol', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(20, 'SMS & Email', 0, '#', 0, 1, '<i class=\"fa-solid fa-envelope-open-text\"></i>', 1, '1', '1', NULL, NULL, '2024-02-28 13:24:41', '2024-02-28 13:24:41'),
(21, 'Send Single SMS', 20, 'sendsinglesms', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(22, 'Send SMS', 20, 'sendsms', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(23, 'SMS Template', 20, 'smstemplate', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(24, 'SMS Setup', 20, 'smssetup', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(25, 'Billing', 0, '#', 0, 1, '<i class=\"fa-solid fa-money-bill-wheat\"></i>', 1, '1', '1', NULL, NULL, '2024-02-28 13:24:41', '2024-02-28 13:24:41'),
(26, 'Monthly Invoice Update', 25, 'monthlyinvoiceupdate', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(27, 'Edit Invoice', 25, 'editinvoice', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(28, 'Edit Invoice Collection(All)', 25, 'invoicecollection', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(29, 'Daily Collection Sheet', 25, 'dailycollectionsheet', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(30, 'Send Email', 20, 'sendemail', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(31, 'Email Template', 20, 'emailtemplate', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(32, 'Invoice Collection(Home)', 25, 'invoicecollectionhome', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(33, 'Advance Information', 25, 'advanceinformation', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(34, 'Renew Customer', 25, 'renewcustomer', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(35, 'Other Invoice', 25, 'otherinvoice', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(36, 'Send Email & SMS ', 20, 'emailandsms', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(37, 'Email Setup', 20, 'emailsetup', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(38, 'Email Log', 20, 'emaillog', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(39, 'Customer Type', 14, 'customertype', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(40, 'IP Pool', 15, 'ippool', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(41, 'Bulk Router Change', 15, 'bulkrouterchange', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(42, 'Service Log', 15, 'servicelog', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(43, 'Radius Access Log', 15, 'accesslog', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(44, 'User Status Report', 15, 'userstatusreport', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(45, 'Company Setup', 0, '#', 0, 1, '<i class=\"fa-solid fa-outdent\"></i>', 1, '1', '1', NULL, NULL, '2024-02-28 13:24:41', '2024-02-28 13:24:41'),
(46, 'Customers', 45, 'customers', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(47, 'Services', 45, 'services', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53'),
(48, 'Monthly Invoice Create', 25, 'monthlyinvoicecreate', 1, 0, '', 1, '1', '1', NULL, NULL, '2024-02-23 23:01:53', '2024-02-23 23:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_17_091521_create_menus_table', 1),
(7, '2024_01_18_102923_create_tbl_zone_table', 1),
(8, '2024_01_18_102924_create_sub_zones_table', 1),
(9, '2024_01_18_102925_create_boxes_table', 1),
(10, '2024_01_18_104707_create_network_servers_table', 1),
(11, '2024_01_18_104718_create_protocol_types_table', 1),
(12, '2024_01_18_104809_create_device_vendors_table', 1),
(13, '2024_01_18_121811_create_billing_statuses_table', 1),
(14, '2024_01_18_122134_create_customer_profiles_table', 1),
(15, '2024_01_18_122155_create_invoice_types_table', 1),
(16, '2024_01_21_102919_create_divisions_table', 1),
(17, '2024_01_21_102926_create_tbl_districts_table', 1),
(18, '2024_01_21_102940_create_upazilas_table', 1),
(19, '2024_01_21_103114_create_unions_table', 1),
(20, '2024_02_13_102500_create_block_reasons_table', 1),
(21, '2024_02_15_094026_create_business_types_table', 1),
(22, '2024_02_15_113811_create_mas_departments_table', 1),
(23, '2024_02_15_122325_create_variables_table', 1),
(24, '2024_02_17_043736_create_areas_table', 1),
(25, '2024_02_17_044309_create_designations_table', 1),
(26, '2024_02_17_051122_create_task_progress_table', 1),
(27, '2024_02_18_050938_create_tbl_bill_types_table', 1),
(28, '2024_02_18_050938_create_tbl_leavetype_table', 1),
(29, '2024_02_19_121906_create_employees_table', 1),
(30, '2024_02_20_081747_create_tbl_routers_table', 1),
(31, '2024_02_20_105049_create_ip_pools_table', 1),
(32, '2024_02_24_052439_create_static_ips_table', 1),
(33, '2024_02_24_053307_create_microtik_graphs_table', 1),
(34, '2024_02_25_120421_create_nas_table', 1),
(35, '2024_02_28_071728_create_bulk_router_changes_table', 1),
(36, '2024_02_28_090621_create_ips_table', 1),
(37, '2024_02_28_112339_create_client_controls_table', 1),
(38, '2024_03_07_064405_create_radchecks_table', 1),
(39, '2024_03_07_064547_create_tbl_client_categories_table', 1),
(40, '2024_03_07_064637_create_tbl_srv_types_table', 1),
(41, '2024_03_09_100804_create_tbl_client_types_table', 1),
(42, '2024_03_10_070603_create_tbl_status_types_table', 1),
(43, '2024_03_10_070739_create_tbl_bandwidth_plans_table', 1),
(44, '2024_03_13_095050_create_radreplies_table', 1),
(45, '2024_03_13_095223_create_radusergroups_table', 1),
(46, '2024_03_18_040745_create_trn_clients_service_logs_table', 1),
(47, '2024_03_18_072542_create_tbl_email_setup_table', 1),
(48, '2024_03_18_073055_create_tbl_email_templates_table', 1),
(49, '2024_03_18_073201_create_tbl_email_logs_table', 1),
(50, '2024_03_18_073437_create_tbl_crm_email_setup_table', 1),
(51, '2024_03_18_073711_create_emails_table', 1),
(52, '2024_03_18_073927_create_tbl_sms_templates_table', 1),
(53, '2024_03_18_074048_create_tbl_sms_setup_table', 1),
(54, '2024_03_18_074143_create_tbl_sms_logs_table', 1),
(55, '2024_03_18_074246_create_tbl_sms_allocation_table', 1),
(56, '2024_03_18_074400_create_mas_sms_table', 1),
(57, '2024_03_19_060900_create_tbl_bill_cycles_table', 1),
(58, '2024_03_27_043803_create_radgroupreplies_table', 1),
(59, '2024_03_27_044038_create_radgroupchecks_table', 1),
(60, '2024_03_31_052655_create_tbl_invoice_cats_table', 1),
(61, '2024_04_03_101748_create_mas_banks_table', 1),
(62, '2024_04_04_052312_create_nisl_mas_members_table', 1),
(63, '2024_04_04_062151_create_tbl_suboffices_table', 1),
(64, '2024_04_24_071226_create_tbl_holidays_table', 1),
(65, '2024_05_05_043909_create_trn_static_ips_table', 1),
(66, '2024_05_05_073450_create_tbl_schedules_table', 1),
(67, '2024_05_06_045902_create_hrm_tbl_shifts_table', 1),
(68, '2024_05_07_043615_create_hrm_levels_table', 1),
(69, '2024_05_07_060214_create_tbl_schedule_teams_table', 1),
(70, '2024_05_07_074609_create_tbl_shift_teams_table', 1),
(71, '2024_05_07_074610_create_hrm_shift_setups_table', 1),
(72, '2024_05_07_123530_create_tbl_companies_table', 1),
(73, '2024_05_16_121516_create_trn_invoices_table', 1),
(74, '2024_05_20_053719_create_change_router_logs_table', 1),
(75, '2024_05_20_072123_create_tbl_parameters_table', 1),
(76, '2024_05_20_084731_create_change_userid_logs_table', 1),
(77, '2024_05_21_072021_create_change_pass_ip_macs_table', 1),
(78, '2024_05_21_072111_create_change_client_statuses_table', 1),
(79, '2024_05_21_115449_create_radacct_table', 1),
(80, '2024_05_25_050504_create_tbl_weekends_table', 1),
(81, '2024_05_26_053043_create_hrm_attendence_summaries_table', 1),
(82, '2024_06_01_082751_create_hrm_increments_table', 1),
(83, '2024_06_02_112730_create_hrm_increment_types_table', 1),
(84, '2024_06_04_052440_create_tbl_cable_types_table', 1),
(85, '2024_06_06_122016_create_tbl_vat_types_table', 1),
(86, '2024_06_06_123218_create_tbl_units_table', 1),
(87, '2024_07_01_112107_create_change_hotspot_to_pppoes_table', 1),
(88, '2024_07_01_114255_create_change_pppoe_to_hotspots_table', 1),
(89, '2025_01_01_122258_create_customers_table', 1),
(90, '2025_01_02_044343_create_mas_invoices_table', 1),
(92, '2025_01_04_064137_create_trn_clients_services_table', 1),
(93, '2025_01_05_054615_create_trn_clients_service_ratechanges_table', 1),
(94, '2025_01_03_043950_create_tbl_advance_bills_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

DROP TABLE IF EXISTS `nas`;
CREATE TABLE IF NOT EXISTS `nas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nasname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'other',
  `ports` int DEFAULT NULL,
  `secret` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'secret',
  `server` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `community` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'RADIUS Client',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nasname` (`nasname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_servers`
--

DROP TABLE IF EXISTS `network_servers`;
CREATE TABLE IF NOT EXISTS `network_servers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_cluster` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nisl_mas_members`
--

DROP TABLE IF EXISTS `nisl_mas_members`;
CREATE TABLE IF NOT EXISTS `nisl_mas_members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_id` bigint DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` int NOT NULL DEFAULT '0',
  `suboffice_id` int NOT NULL,
  `data_status` int DEFAULT '0',
  `reseller_id` int NOT NULL,
  `zone_office` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `User_ID` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protocol_types`
--

DROP TABLE IF EXISTS `protocol_types`;
CREATE TABLE IF NOT EXISTS `protocol_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `protocol_type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

DROP TABLE IF EXISTS `radacct`;
CREATE TABLE IF NOT EXISTS `radacct` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `acctsessionid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acctuniqueid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `groupname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `realm` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nasipaddress` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nasportid` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nasporttype` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acctstarttime` datetime DEFAULT NULL,
  `acctupdatetime` datetime DEFAULT NULL,
  `acctstoptime` datetime DEFAULT NULL,
  `acctinterval` int DEFAULT NULL,
  `acctsessiontime` int UNSIGNED DEFAULT NULL,
  `acctauthentic` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connectinfo_start` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connectinfo_stop` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acctinputoctets` bigint DEFAULT NULL,
  `acctoutputoctets` bigint DEFAULT NULL,
  `calledstationid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `callingstationid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acctterminatecause` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `servicetype` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framedprotocol` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framedipaddress` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acctuniqueid` (`acctuniqueid`),
  KEY `acctsessionid` (`acctsessionid`),
  KEY `username` (`username`),
  KEY `nasipaddress` (`nasipaddress`),
  KEY `acctstarttime` (`acctstarttime`),
  KEY `acctstoptime` (`acctstoptime`),
  KEY `acctinterval` (`acctinterval`),
  KEY `acctsessiontime` (`acctsessiontime`),
  KEY `framedipaddress` (`framedipaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

DROP TABLE IF EXISTS `radcheck`;
CREATE TABLE IF NOT EXISTS `radcheck` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

DROP TABLE IF EXISTS `radgroupcheck`;
CREATE TABLE IF NOT EXISTS `radgroupcheck` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

DROP TABLE IF EXISTS `radgroupreply`;
CREATE TABLE IF NOT EXISTS `radgroupreply` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

DROP TABLE IF EXISTS `radreply`;
CREATE TABLE IF NOT EXISTS `radreply` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

DROP TABLE IF EXISTS `radusergroup`;
CREATE TABLE IF NOT EXISTS `radusergroup` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `groupname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `priority` int NOT NULL DEFAULT '1',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `static_ips`
--

DROP TABLE IF EXISTS `static_ips`;
CREATE TABLE IF NOT EXISTS `static_ips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `range` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_zones`
--

DROP TABLE IF EXISTS `sub_zones`;
CREATE TABLE IF NOT EXISTS `sub_zones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subzone_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_zones_zone_id_foreign` (`zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_zones`
--

INSERT INTO `sub_zones` (`id`, `subzone_name`, `zone_id`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'sub zone 1', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Sub Zone 2', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_progress`
--

DROP TABLE IF EXISTS `task_progress`;
CREATE TABLE IF NOT EXISTS `task_progress` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advance_bills`
--

DROP TABLE IF EXISTS `tbl_advance_bills`;
CREATE TABLE IF NOT EXISTS `tbl_advance_bills` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `srv_id` int NOT NULL,
  `rec_date` date NOT NULL,
  `bill_month` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_year` double NOT NULL,
  `amount` double NOT NULL,
  `discount` double NOT NULL,
  `entry_by` int NOT NULL,
  `entry_date` date NOT NULL,
  `money_recipt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_advance_bills_client_id_foreign` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bandwidth_plans`
--

DROP TABLE IF EXISTS `tbl_bandwidth_plans`;
CREATE TABLE IF NOT EXISTS `tbl_bandwidth_plans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bandwidth_plan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_bandwidth_plans`
--

INSERT INTO `tbl_bandwidth_plans` (`id`, `bandwidth_plan`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '10Mbps', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '20Mbps', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_cycles`
--

DROP TABLE IF EXISTS `tbl_bill_cycles`;
CREATE TABLE IF NOT EXISTS `tbl_bill_cycles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_types`
--

DROP TABLE IF EXISTS `tbl_bill_types`;
CREATE TABLE IF NOT EXISTS `tbl_bill_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_type_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_bill_types`
--

INSERT INTO `tbl_bill_types` (`id`, `bill_type_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Pre-Paid', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Post Paid', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cable_types`
--

DROP TABLE IF EXISTS `tbl_cable_types`;
CREATE TABLE IF NOT EXISTS `tbl_cable_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cable_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cable_types`
--

INSERT INTO `tbl_cable_types` (`id`, `cable_type`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cat 6', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Cat5', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client_categories`
--

DROP TABLE IF EXISTS `tbl_client_categories`;
CREATE TABLE IF NOT EXISTS `tbl_client_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_client_categories`
--

INSERT INTO `tbl_client_categories` (`id`, `name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Silver', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Gold', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client_types`
--

DROP TABLE IF EXISTS `tbl_client_types`;
CREATE TABLE IF NOT EXISTS `tbl_client_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(11,0) NOT NULL,
  `reseller_id` int NOT NULL,
  `share_rate` double NOT NULL,
  `share_percent` double DEFAULT NULL,
  `hotspot` int NOT NULL,
  `pcq` int NOT NULL,
  `days` int NOT NULL,
  `view_portal` int NOT NULL,
  `view_distridutor` int DEFAULT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_client_types`
--

INSERT INTO `tbl_client_types` (`id`, `name`, `unit`, `description`, `price`, `reseller_id`, `share_rate`, `share_percent`, `hotspot`, `pcq`, `days`, `view_portal`, `view_distridutor`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Silver', 'kbps', NULL, 1000, 1, 10, NULL, 1, 1, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Gold', 'mbps', NULL, 1, 1, 1, NULL, 1, 1, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

DROP TABLE IF EXISTS `tbl_company`;
CREATE TABLE IF NOT EXISTS `tbl_company` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_emergency` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hst_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_user` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_image` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_per` double NOT NULL,
  `comp_id` int NOT NULL,
  `default_service` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crm_email_setup`
--

DROP TABLE IF EXISTS `tbl_crm_email_setup`;
CREATE TABLE IF NOT EXISTS `tbl_crm_email_setup` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setFrom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SMTPAuth` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Host` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SMTPSecure` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addReplyTo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addCC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addBCC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isHTML` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mailer` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_email` int NOT NULL,
  `receive_email` int NOT NULL,
  `department` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_districts`
--

DROP TABLE IF EXISTS `tbl_districts`;
CREATE TABLE IF NOT EXISTS `tbl_districts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_districts_division_id_foreign` (`division_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_districts`
--

INSERT INTO `tbl_districts` (`id`, `name`, `bn_name`, `lat`, `lon`, `url`, `division_id`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Dhaka', '', '', '', '', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Shariatpur', '', '', '', '', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_logs`
--

DROP TABLE IF EXISTS `tbl_email_logs`;
CREATE TABLE IF NOT EXISTS `tbl_email_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_email` bigint UNSIGNED NOT NULL,
  `snder_id` int NOT NULL,
  `email_status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_email_logs_from_email_foreign` (`from_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_setup`
--

DROP TABLE IF EXISTS `tbl_email_setup`;
CREATE TABLE IF NOT EXISTS `tbl_email_setup` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setFrom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SMTPAuth` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Host` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SMTPSecure` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addReplyTo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addCC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addBCC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isHTML` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mailer` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_email` int NOT NULL,
  `receive_email` int NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_email_setup_department_id_foreign` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_templates`
--

DROP TABLE IF EXISTS `tbl_email_templates`;
CREATE TABLE IF NOT EXISTS `tbl_email_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `command` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holidays`
--

DROP TABLE IF EXISTS `tbl_holidays`;
CREATE TABLE IF NOT EXISTS `tbl_holidays` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_date` date NOT NULL,
  `allowance_status` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_cats`
--

DROP TABLE IF EXISTS `tbl_invoice_cats`;
CREATE TABLE IF NOT EXISTS `tbl_invoice_cats` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `inv_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ip_pool`
--

DROP TABLE IF EXISTS `tbl_ip_pool`;
CREATE TABLE IF NOT EXISTS `tbl_ip_pool` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `router_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ranges` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_ip_pool_router_id_foreign` (`router_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leavetype`
--

DROP TABLE IF EXISTS `tbl_leavetype`;
CREATE TABLE IF NOT EXISTS `tbl_leavetype` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_allocation` int NOT NULL,
  `carry_forward` int NOT NULL,
  `carry_max_days` int NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mikrotik_graphing`
--

DROP TABLE IF EXISTS `tbl_mikrotik_graphing`;
CREATE TABLE IF NOT EXISTS `tbl_mikrotik_graphing` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `router_id` int NOT NULL,
  `interface` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allow_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_on` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `router_id` (`router_id`,`interface`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parameters`
--

DROP TABLE IF EXISTS `tbl_parameters`;
CREATE TABLE IF NOT EXISTS `tbl_parameters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parameter_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter_value` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter_status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_routers`
--

DROP TABLE IF EXISTS `tbl_routers`;
CREATE TABLE IF NOT EXISTS `tbl_routers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `router_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `router_ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `router_username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `router_password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `router_location` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` int NOT NULL,
  `web_server_port` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wefig_username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wefig_pass` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssh_port` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_client` int DEFAULT NULL,
  `radius_auth` int NOT NULL,
  `radius_acct` int NOT NULL,
  `local_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lan_interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dns1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dns2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `router_type` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_routers`
--

INSERT INTO `tbl_routers` (`id`, `router_name`, `router_ip`, `router_username`, `router_password`, `router_location`, `port`, `web_server_port`, `wefig_username`, `wefig_pass`, `r_secret`, `ssh_port`, `active_client`, `radius_auth`, `radius_acct`, `local_address`, `lan_interface`, `dns1`, `dns2`, `active`, `router_type`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Router 1', '1.2.4.3', 'user', '1234', 'dhaka', 1, '80', 'user', 'user', '123', '221', 100, 1, 1, '1', '1', '1', '1', '1', '1', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE IF NOT EXISTS `tbl_schedule` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `late_time` time NOT NULL,
  `begining_start` time NOT NULL,
  `begining_end` time NOT NULL,
  `out_start` time NOT NULL,
  `out_end` time NOT NULL,
  `sat` int DEFAULT NULL,
  `sun` int DEFAULT NULL,
  `mon` int DEFAULT NULL,
  `tues` int DEFAULT NULL,
  `wed` int DEFAULT NULL,
  `thurs` int DEFAULT NULL,
  `fri` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule_team`
--

DROP TABLE IF EXISTS `tbl_schedule_team`;
CREATE TABLE IF NOT EXISTS `tbl_schedule_team` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shift_team`
--

DROP TABLE IF EXISTS `tbl_shift_team`;
CREATE TABLE IF NOT EXISTS `tbl_shift_team` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_shift_team_team_id_foreign` (`team_id`),
  KEY `tbl_shift_team_emp_id_foreign` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_allocation`
--

DROP TABLE IF EXISTS `tbl_sms_allocation`;
CREATE TABLE IF NOT EXISTS `tbl_sms_allocation` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_ammount` double NOT NULL,
  `allocate_ammount` double NOT NULL,
  `allocation_date` date NOT NULL,
  `total` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_logs`
--

DROP TABLE IF EXISTS `tbl_sms_logs`;
CREATE TABLE IF NOT EXISTS `tbl_sms_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_api` int NOT NULL,
  `snder_id` int NOT NULL,
  `sms_status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_setup`
--

DROP TABLE IF EXISTS `tbl_sms_setup`;
CREATE TABLE IF NOT EXISTS `tbl_sms_setup` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit_param` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_param` text COLLATE utf8mb4_unicode_ci,
  `return_value_type` int DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_templates`
--

DROP TABLE IF EXISTS `tbl_sms_templates`;
CREATE TABLE IF NOT EXISTS `tbl_sms_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `command` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL DEFAULT '1',
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_srv_types`
--

DROP TABLE IF EXISTS `tbl_srv_types`;
CREATE TABLE IF NOT EXISTS `tbl_srv_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `srv_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_srv_types`
--

INSERT INTO `tbl_srv_types` (`id`, `srv_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bdix', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Broadband', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status_types`
--

DROP TABLE IF EXISTS `tbl_status_types`;
CREATE TABLE IF NOT EXISTS `tbl_status_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `inv_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_status_types`
--

INSERT INTO `tbl_status_types` (`id`, `inv_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Exiped', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Active', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suboffices`
--

DROP TABLE IF EXISTS `tbl_suboffices`;
CREATE TABLE IF NOT EXISTS `tbl_suboffices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_suboffices`
--

INSERT INTO `tbl_suboffices` (`id`, `name`, `contact_person`, `contact_number`, `email`, `address`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Branch 1', '', '', '', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Branch 2', '', '', '', '', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

DROP TABLE IF EXISTS `tbl_units`;
CREATE TABLE IF NOT EXISTS `tbl_units` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `unit_display` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_detail` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vat_types`
--

DROP TABLE IF EXISTS `tbl_vat_types`;
CREATE TABLE IF NOT EXISTS `tbl_vat_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_weekend`
--

DROP TABLE IF EXISTS `tbl_weekend`;
CREATE TABLE IF NOT EXISTS `tbl_weekend` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weekend` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zone`
--

DROP TABLE IF EXISTS `tbl_zone`;
CREATE TABLE IF NOT EXISTS `tbl_zone` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `advance_amount` double DEFAULT NULL,
  `advance_date` date DEFAULT NULL,
  `distributor_status` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_zone`
--

INSERT INTO `tbl_zone` (`id`, `zone_name`, `zone_code`, `discount`, `advance_amount`, `advance_date`, `distributor_status`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Zone 1', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Zone 2', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trn_clients_services`
--

DROP TABLE IF EXISTS `trn_clients_services`;
CREATE TABLE IF NOT EXISTS `trn_clients_services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bandwidth_plan_id` bigint UNSIGNED DEFAULT NULL,
  `installation_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_connectivity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `router_id` bigint UNSIGNED DEFAULT NULL,
  `device` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mac_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box_id` bigint UNSIGNED DEFAULT NULL,
  `cable_req` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_core` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiber_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_bill_type_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_type_id` bigint UNSIGNED DEFAULT NULL,
  `bill_start_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_client_type_id` bigint UNSIGNED DEFAULT NULL,
  `monthly_bill` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_status_id` bigint UNSIGNED DEFAULT NULL,
  `tbl_status_type_id` bigint UNSIGNED DEFAULT NULL,
  `include_vat` int NOT NULL DEFAULT '0',
  `greeting_sms_sent` int NOT NULL DEFAULT '0',
  `link_from` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_to` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `bandwidth` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `unit_qty` double NOT NULL,
  `vat_rate` double NOT NULL,
  `rate_amnt` double NOT NULL,
  `vat_amnt` double NOT NULL,
  `number_of_tv` int NOT NULL,
  `number_of_channel` int NOT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `srv_type_id` bigint UNSIGNED DEFAULT NULL,
  `vat_type_id` bigint UNSIGNED DEFAULT NULL,
  `block_date` date DEFAULT NULL,
  `static_ip` int DEFAULT NULL,
  `block_reason_id` bigint UNSIGNED DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trn_clients_services_customer_id_foreign` (`customer_id`),
  KEY `trn_clients_services_bandwidth_plan_id_foreign` (`bandwidth_plan_id`),
  KEY `trn_clients_services_router_id_foreign` (`router_id`),
  KEY `trn_clients_services_box_id_foreign` (`box_id`),
  KEY `trn_clients_services_tbl_bill_type_id_foreign` (`tbl_bill_type_id`),
  KEY `trn_clients_services_invoice_type_id_foreign` (`invoice_type_id`),
  KEY `trn_clients_services_tbl_client_type_id_foreign` (`tbl_client_type_id`),
  KEY `trn_clients_services_billing_status_id_foreign` (`billing_status_id`),
  KEY `trn_clients_services_tbl_status_type_id_foreign` (`tbl_status_type_id`),
  KEY `trn_clients_services_unit_id_foreign` (`unit_id`),
  KEY `trn_clients_services_district_id_foreign` (`district_id`),
  KEY `trn_clients_services_srv_type_id_foreign` (`srv_type_id`),
  KEY `trn_clients_services_vat_type_id_foreign` (`vat_type_id`),
  KEY `trn_clients_services_block_reason_id_foreign` (`block_reason_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trn_clients_services`
--

INSERT INTO `trn_clients_services` (`id`, `customer_id`, `user_id`, `password`, `bandwidth_plan_id`, `installation_date`, `remarks`, `type_of_connectivity`, `router_id`, `device`, `mac_address`, `ip_number`, `box_id`, `cable_req`, `no_of_core`, `core_color`, `fiber_code`, `tbl_bill_type_id`, `invoice_type_id`, `bill_start_date`, `tbl_client_type_id`, `monthly_bill`, `billing_status_id`, `tbl_status_type_id`, `include_vat`, `greeting_sms_sent`, `link_from`, `link_to`, `bandwidth`, `unit_id`, `unit_qty`, `vat_rate`, `rate_amnt`, `vat_amnt`, `number_of_tv`, `number_of_channel`, `district_id`, `srv_type_id`, `vat_type_id`, `block_date`, `static_ip`, `block_reason_id`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, 1, 'xiwyqavola', 'Pa$$w0rd!', 2, '01.07.2024', 'Omnis laboriosam ve', '2', 1, 'Assumenda non in ab', 'Ipsum culpa ullam qu', '102', 1, 'Quod saepe enim ut p', 'Consequatur non volu', 'Voluptas et quae in', 'Laborum anim suscipi', 2, 1, '01.07.2024', 1, '12', 1, 2, 0, 1, '', '', '', NULL, 0, 0, 0, 0, 0, 0, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-10 03:23:11', '2024-07-10 03:44:04'),
(7, 2, 'rahut', 'Pa$$w0rd!', 1, '01.07.2024', 'Quibusdam est qui el', '1', 1, 'Veritatis nihil anim', 'Occaecat asperiores', '904', 1, 'Sint aute ex alias f', 'Atque dolorem aut au', 'Quas eos id esse ne', 'Quia commodi laboris', 2, 1, '01.07.2024', 2, '4', 1, 2, 0, 0, '', '', '', NULL, 0, 0, 0, 0, 0, 0, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-10 03:43:30', '2024-07-10 03:43:30'),
(8, 3, 'dejonijux', 'Pa$$w0rd!', 1, '01.07.2024', 'Magnam omnis molesti', '1', 1, 'In facilis quae odio', 'Tenetur quasi ad dic', '892', 2, 'Nisi qui est in labo', 'Mollitia eum obcaeca', 'A velit in ut perfe', 'Non enim nisi repreh', 2, 1, '01.07.2024', 2, '6', 1, 2, 1, 0, '', '', '', NULL, 0, 0, 0, 0, 0, 0, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-10 07:15:36', '2024-07-10 07:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `trn_clients_service_logs`
--

DROP TABLE IF EXISTS `trn_clients_service_logs`;
CREATE TABLE IF NOT EXISTS `trn_clients_service_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `srv_id` int NOT NULL,
  `action_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_rate` double NOT NULL,
  `p_vat` double NOT NULL,
  `active_date` date NOT NULL,
  `c_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_rate` double NOT NULL,
  `c_vat` double NOT NULL,
  `comments` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trn_clients_service_ratechanges`
--

DROP TABLE IF EXISTS `trn_clients_service_ratechanges`;
CREATE TABLE IF NOT EXISTS `trn_clients_service_ratechanges` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `punit` double NOT NULL,
  `punit_qty` double NOT NULL DEFAULT '0',
  `prate` double NOT NULL,
  `pvat` double NOT NULL,
  `rate_change_date` datetime NOT NULL,
  `cunit` double NOT NULL,
  `cunit_qty` double NOT NULL DEFAULT '0',
  `crate` double NOT NULL,
  `cvat` double NOT NULL,
  `trn_clients_service_id` bigint UNSIGNED DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trn_clients_service_ratechanges_customer_id_foreign` (`customer_id`),
  KEY `trn_clients_service_ratechanges_trn_clients_service_id_foreign` (`trn_clients_service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trn_invoices`
--

DROP TABLE IF EXISTS `trn_invoices`;
CREATE TABLE IF NOT EXISTS `trn_invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoiceobject_id` int NOT NULL DEFAULT '0',
  `serv_id` int NOT NULL,
  `client_id` int NOT NULL,
  `billing_year` int NOT NULL,
  `billing_month` int NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unitqty` int NOT NULL,
  `rate` double NOT NULL,
  `vat` double NOT NULL,
  `billingdays` int NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `camnt` double NOT NULL,
  `cvat` double NOT NULL,
  `total` double NOT NULL,
  `collection_amnt` double NOT NULL DEFAULT '0',
  `discount_amnt` double NOT NULL DEFAULT '0',
  `discount_date` date DEFAULT NULL,
  `discount_comments` text COLLATE utf8mb4_unicode_ci,
  `entry_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_date` date NOT NULL,
  `comments` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reseller_id` int NOT NULL,
  `share_rate` double NOT NULL,
  `extra_bill` double DEFAULT NULL,
  `arrar` double DEFAULT NULL,
  `change_date` date NOT NULL,
  `punit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `punitqty` int NOT NULL,
  `prate` double NOT NULL,
  `pvate` double NOT NULL,
  `c_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pshare_rate` double NOT NULL DEFAULT '0',
  `extra_share_rate` double NOT NULL,
  `package_id` int DEFAULT NULL,
  `ppackage_id` int DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trn_static_ips`
--

DROP TABLE IF EXISTS `trn_static_ips`;
CREATE TABLE IF NOT EXISTS `trn_static_ips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `static_ip_id` int NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unions`
--

DROP TABLE IF EXISTS `unions`;
CREATE TABLE IF NOT EXISTS `unions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upazila_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unions_upazila_id_foreign` (`upazila_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

DROP TABLE IF EXISTS `upazilas`;
CREATE TABLE IF NOT EXISTS `upazilas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upazilas_district_id_foreign` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upazilas`
--

INSERT INTO `upazilas` (`id`, `name`, `bn_name`, `url`, `district_id`, `status`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Dhanmondi', '', '', 3, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Naria', '', '', 4, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abdullah', 'abdullahbaig@mail.com', NULL, '$2y$12$3xGkuQd3LPmrnaTJum53LOQUgLartzP3k6ECv284x9SuhggrAe2OO', NULL, NULL, NULL, '2024-07-10 02:57:28', '2024-07-10 02:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

DROP TABLE IF EXISTS `variables`;
CREATE TABLE IF NOT EXISTS `variables` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `variable_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boxes`
--
ALTER TABLE `boxes`
  ADD CONSTRAINT `boxes_subzone_id_foreign` FOREIGN KEY (`subzone_id`) REFERENCES `sub_zones` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_subzone_id_foreign` FOREIGN KEY (`subzone_id`) REFERENCES `sub_zones` (`id`),
  ADD CONSTRAINT `customers_tbl_bill_cycle_id_foreign` FOREIGN KEY (`tbl_bill_cycle_id`) REFERENCES `tbl_bill_cycles` (`id`),
  ADD CONSTRAINT `customers_tbl_client_category_id_foreign` FOREIGN KEY (`tbl_client_category_id`) REFERENCES `tbl_client_categories` (`id`),
  ADD CONSTRAINT `customers_tbl_zone_id_foreign` FOREIGN KEY (`tbl_zone_id`) REFERENCES `tbl_zone` (`id`);

--
-- Constraints for table `hrm_shift_setup`
--
ALTER TABLE `hrm_shift_setup`
  ADD CONSTRAINT `hrm_shift_setup_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `hrm_tbl_shift` (`id`),
  ADD CONSTRAINT `hrm_shift_setup_shift_team_id_foreign` FOREIGN KEY (`shift_team_id`) REFERENCES `tbl_shift_team` (`id`),
  ADD CONSTRAINT `hrm_shift_setup_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `tbl_schedule_team` (`id`);

--
-- Constraints for table `mas_employees`
--
ALTER TABLE `mas_employees`
  ADD CONSTRAINT `mas_employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `mas_departments` (`id`),
  ADD CONSTRAINT `mas_employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `mas_designation` (`id`);

--
-- Constraints for table `mas_invoices`
--
ALTER TABLE `mas_invoices`
  ADD CONSTRAINT `mas_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `mas_invoices_tbl_invoice_cat_id_foreign` FOREIGN KEY (`tbl_invoice_cat_id`) REFERENCES `tbl_invoice_cats` (`id`),
  ADD CONSTRAINT `mas_invoices_tbl_srv_type_id_foreign` FOREIGN KEY (`tbl_srv_type_id`) REFERENCES `tbl_srv_types` (`id`);

--
-- Constraints for table `sub_zones`
--
ALTER TABLE `sub_zones`
  ADD CONSTRAINT `sub_zones_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `tbl_zone` (`id`);

--
-- Constraints for table `tbl_advance_bills`
--
ALTER TABLE `tbl_advance_bills`
  ADD CONSTRAINT `tbl_advance_bills_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  ADD CONSTRAINT `tbl_districts_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`);

--
-- Constraints for table `tbl_email_logs`
--
ALTER TABLE `tbl_email_logs`
  ADD CONSTRAINT `tbl_email_logs_from_email_foreign` FOREIGN KEY (`from_email`) REFERENCES `tbl_email_setup` (`id`);

--
-- Constraints for table `tbl_email_setup`
--
ALTER TABLE `tbl_email_setup`
  ADD CONSTRAINT `tbl_email_setup_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `mas_departments` (`id`);

--
-- Constraints for table `tbl_ip_pool`
--
ALTER TABLE `tbl_ip_pool`
  ADD CONSTRAINT `tbl_ip_pool_router_id_foreign` FOREIGN KEY (`router_id`) REFERENCES `tbl_routers` (`id`);

--
-- Constraints for table `tbl_shift_team`
--
ALTER TABLE `tbl_shift_team`
  ADD CONSTRAINT `tbl_shift_team_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `mas_employees` (`id`),
  ADD CONSTRAINT `tbl_shift_team_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `tbl_schedule_team` (`id`);

--
-- Constraints for table `trn_clients_services`
--
ALTER TABLE `trn_clients_services`
  ADD CONSTRAINT `trn_clients_services_bandwidth_plan_id_foreign` FOREIGN KEY (`bandwidth_plan_id`) REFERENCES `tbl_bandwidth_plans` (`id`),
  ADD CONSTRAINT `trn_clients_services_billing_status_id_foreign` FOREIGN KEY (`billing_status_id`) REFERENCES `billing_statuses` (`id`),
  ADD CONSTRAINT `trn_clients_services_block_reason_id_foreign` FOREIGN KEY (`block_reason_id`) REFERENCES `block_reasons` (`id`),
  ADD CONSTRAINT `trn_clients_services_box_id_foreign` FOREIGN KEY (`box_id`) REFERENCES `boxes` (`id`),
  ADD CONSTRAINT `trn_clients_services_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `trn_clients_services_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`id`),
  ADD CONSTRAINT `trn_clients_services_invoice_type_id_foreign` FOREIGN KEY (`invoice_type_id`) REFERENCES `invoice_types` (`id`),
  ADD CONSTRAINT `trn_clients_services_router_id_foreign` FOREIGN KEY (`router_id`) REFERENCES `tbl_routers` (`id`),
  ADD CONSTRAINT `trn_clients_services_srv_type_id_foreign` FOREIGN KEY (`srv_type_id`) REFERENCES `tbl_srv_types` (`id`),
  ADD CONSTRAINT `trn_clients_services_tbl_bill_type_id_foreign` FOREIGN KEY (`tbl_bill_type_id`) REFERENCES `tbl_bill_types` (`id`),
  ADD CONSTRAINT `trn_clients_services_tbl_client_type_id_foreign` FOREIGN KEY (`tbl_client_type_id`) REFERENCES `tbl_client_types` (`id`),
  ADD CONSTRAINT `trn_clients_services_tbl_status_type_id_foreign` FOREIGN KEY (`tbl_status_type_id`) REFERENCES `tbl_status_types` (`id`),
  ADD CONSTRAINT `trn_clients_services_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `tbl_units` (`id`),
  ADD CONSTRAINT `trn_clients_services_vat_type_id_foreign` FOREIGN KEY (`vat_type_id`) REFERENCES `tbl_vat_types` (`id`);

--
-- Constraints for table `trn_clients_service_ratechanges`
--
ALTER TABLE `trn_clients_service_ratechanges`
  ADD CONSTRAINT `trn_clients_service_ratechanges_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `trn_clients_service_ratechanges_trn_clients_service_id_foreign` FOREIGN KEY (`trn_clients_service_id`) REFERENCES `trn_clients_services` (`id`);

--
-- Constraints for table `unions`
--
ALTER TABLE `unions`
  ADD CONSTRAINT `unions_upazila_id_foreign` FOREIGN KEY (`upazila_id`) REFERENCES `upazilas` (`id`);

--
-- Constraints for table `upazilas`
--
ALTER TABLE `upazilas`
  ADD CONSTRAINT `upazilas_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
