-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2014 at 09:04 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ecovacs`
--
CREATE DATABASE IF NOT EXISTS `ecovacs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ecovacs`;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authnet_customer_id` int(11) NOT NULL,
  `authnet_payment_profile_id` int(11) NOT NULL,
  `response` text NOT NULL,
  `number` varchar(255) NOT NULL,
  `exp_month` int(11) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `string_id` varchar(255) NOT NULL,
  `card_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `option` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `opt_in` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) NOT NULL,
  `phone_extension` varchar(10) DEFAULT NULL,
  `b_first_name` varchar(50) NOT NULL,
  `b_last_name` varchar(50) NOT NULL,
  `b_address` varchar(100) DEFAULT NULL,
  `b_apt` varchar(10) DEFAULT NULL,
  `b_city` varchar(50) NOT NULL,
  `b_state_province` varchar(20) NOT NULL,
  `b_zip` varchar(15) NOT NULL,
  `b_country` varchar(50) NOT NULL,
  `s_first_name` varchar(50) NOT NULL,
  `s_last_name` varchar(50) NOT NULL,
  `s_address` varchar(100) NOT NULL,
  `s_apt` varchar(10) NOT NULL,
  `s_city` varchar(50) NOT NULL,
  `s_state_province` varchar(20) NOT NULL,
  `s_zip` int(11) NOT NULL,
  `s_country` varchar(50) NOT NULL,
  `s_phone` int(11) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `payment_option` varchar(50) DEFAULT NULL,
  `subtotal` float NOT NULL DEFAULT '0',
  `shipping_type` varchar(20) DEFAULT NULL,
  `shipping_total` float NOT NULL DEFAULT '0',
  `coupon_code` varchar(20) DEFAULT NULL,
  `discount_total` float NOT NULL DEFAULT '0',
  `tax_rate` float NOT NULL,
  `tax_total` float NOT NULL DEFAULT '0',
  `taxable_subtotal` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `ordered_at` datetime DEFAULT NULL,
  `exported_at` datetime DEFAULT NULL,
  `shipped_on` date DEFAULT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_lines`
--

CREATE TABLE IF NOT EXISTS `order_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `option` varchar(255) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_sku` varchar(50) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `taxable_price` float NOT NULL,
  `shipping` float NOT NULL DEFAULT '0',
  `outside_shipping` float NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'primary',
  `promotion` varchar(255) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL,
  `long_desc` text,
  `image` varchar(255) NOT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `order`, `title`, `price`, `taxable_price`, `shipping`, `outside_shipping`, `type`, `promotion`, `desc`, `long_desc`, `image`, `tracking`, `created_at`, `updated_at`) VALUES
(1, 'WIN399', 1, 'WINBOT 30-Day Risk-Free Trial Package', 399.95, 399.95, 0, 30, 'primary', '0', '', NULL, 'images/winbot-pin.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(2, '5WIN399', 1, 'WINBOT 30-Day Risk-Free Trial Package', 79.99, 399.95, 24.95, 54.95, 'primary', '0', '5 payments of $79.99', NULL, 'images/winbot-pin.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(3, 'WINEC', 2, 'Extra WINBOT Extension Cord 4''9"', 14.99, 14.99, 8.5, 8.5, 'upsell', '0', '', NULL, 'images/ExtCord-Upsell.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(4, 'WINMP', 3, 'Additional 3 Sets of WINBOT Microfiber Cleaning Pads', 19.99, 14.99, 8.5, 8.5, 'upsell', '0', 'Additional 3 Sets of WINBOT Microfiber Cleaning Pads', NULL, 'images/CleaningPads-Upsell.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(5, 'WINCS', 4, 'Extra WINBOT Cleaning Solution 70.5 oz', 19.99, 19.99, 8.5, 8.5, 'upsell', '0', 'Extra WINBOT Cleaning Solution 70.5 oz', NULL, 'images/Solution-Upsell.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(6, 'WINADD', 5, 'Additional WINBOT With Standard Accessories', 299, 299, 24.95, 54.95, 'upsell', '0', 'Additional WINBOT With Standard Accessories', NULL, 'images/WinBot-Upsell.jpg', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00'),
(7, NULL, 6, 'Standard Shipping', 0, 0, 0, 0, 'shipping', '0', 'Standard Shipping', NULL, '', NULL, '2014-04-23 00:00:00', '2014-04-23 00:00:00');
