-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2018 at 10:03 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8*/;

--
-- Database: `premux_test_customer`
--
DROP DATABASE IF EXISTS `premux_test_customers`;
DROP DATABASE IF EXISTS `premux_test_customer`;
DROP DATABASE IF EXISTS `tycol_test_customers`;
DROP DATABASE IF EXISTS `tycol_test_customer`;
CREATE DATABASE IF NOT EXISTS `premux_test_customer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `premux_test_customer`;

-- --------------------------------------------------------

--
-- Table structure for table `tm_customer`
--
-- Creation: Sep 04, 2018 at 03:27 AM
--

DROP TABLE IF EXISTS `tm_customer`;
CREATE TABLE IF NOT EXISTS `tm_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(20) NOT NULL COMMENT 'a value to programmatically generate',
  `master_email` varchar(255) NOT NULL,
  `master_doman` varchar(255) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `billing_date` date NOT NULL,
  `account_number` int(11) NOT NULL COMMENT 'a public account id should be 6 digits (1m) ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tm_plan`
--
-- Creation: Sep 03, 2018 at 08:00 AM
--

DROP TABLE IF EXISTS `tm_plan`;
CREATE TABLE IF NOT EXISTS `tm_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longblob NOT NULL,
  `per_user_price` decimal(15,4) NOT NULL,
  `max_users` int(11) NOT NULL COMMENT 'a maximum number of users allowed on plan 0 means no maximum',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
