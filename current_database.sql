-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2021 at 05:15 PM
-- Server version: 10.5.9-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kcms_v7base`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_access`
--

CREATE TABLE `api_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(40) NOT NULL DEFAULT '',
  `all_access` tinyint(1) NOT NULL DEFAULT 0,
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 1, 'boguskey', 10, 1, 0, NULL, 1496174400),
(2, 1, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 10, 1, 0, NULL, 1607114421);

-- --------------------------------------------------------

--
-- Table structure for table `api_limits`
--

CREATE TABLE `api_limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_logs`
--

CREATE TABLE `api_logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_settings`
--

CREATE TABLE `api_settings` (
  `id` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  `setting_name` varchar(64) NOT NULL,
  `setting_value` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_settings`
--

INSERT INTO `api_settings` (`id`, `api_key`, `setting_name`, `setting_value`) VALUES
(1, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'minimum_order_quantity', '1'),
(2, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'maximum_order_quantity', '10'),
(3, 'global', 'minimum_order_quantity', '1'),
(4, 'global', 'maximum_order_quantity', '100'),
(5, 'global', 'require_mobile_number', '0'),
(6, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'require_mobile_number', '1'),
(7, 'global', 'require_mobile_number_error', NULL),
(8, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'require_mobile_number_error', 'Invalid or no mobile number specified.'),
(9, 'global', 'minimum_search_characters', '4'),
(10, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'minimum_search_characters', '3'),
(11, 'global', 'maximum_search_results', '10'),
(12, '96df2d0af87fa6e1874a6622575b4ed667ca33f1', 'maximum_search_results', '4');

-- --------------------------------------------------------

--
-- Table structure for table `api_token`
--

CREATE TABLE `api_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_date` datetime NOT NULL,
  `valid_until` datetime NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_contra`
--

CREATE TABLE `kcms_askgogo_contra` (
  `id` int(11) NOT NULL,
  `contra` varchar(64) NOT NULL,
  `contra_description` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_formulation`
--

CREATE TABLE `kcms_askgogo_formulation` (
  `id` int(11) NOT NULL,
  `formulation` varchar(64) NOT NULL,
  `formulation_description` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_ingredient`
--

CREATE TABLE `kcms_askgogo_ingredient` (
  `id` int(11) NOT NULL,
  `ingredient` varchar(64) NOT NULL,
  `ingredient_desciption` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_keyword`
--

CREATE TABLE `kcms_askgogo_keyword` (
  `id` int(11) NOT NULL,
  `keyword` varchar(32) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc`
--

CREATE TABLE `kcms_askgogo_otc` (
  `id` int(11) NOT NULL,
  `nappi_code` varchar(16) NOT NULL,
  `strength` varchar(16) NOT NULL,
  `pack_size` varchar(32) NOT NULL,
  `note` varchar(255) NOT NULL,
  `load_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_contra`
--

CREATE TABLE `kcms_askgogo_otc_contra` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `contra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_formulation`
--

CREATE TABLE `kcms_askgogo_otc_formulation` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `formulation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_ingredient`
--

CREATE TABLE `kcms_askgogo_otc_ingredient` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_keyword`
--

CREATE TABLE `kcms_askgogo_otc_keyword` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_source`
--

CREATE TABLE `kcms_askgogo_otc_source` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_symptom`
--

CREATE TABLE `kcms_askgogo_otc_symptom` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `symptom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_otc_trade`
--

CREATE TABLE `kcms_askgogo_otc_trade` (
  `id` int(11) NOT NULL,
  `otc_id` int(11) NOT NULL,
  `trade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_source`
--

CREATE TABLE `kcms_askgogo_source` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_description` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_symptom`
--

CREATE TABLE `kcms_askgogo_symptom` (
  `id` int(11) NOT NULL,
  `symptom` varchar(64) NOT NULL,
  `symptom__description` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_askgogo_trade`
--

CREATE TABLE `kcms_askgogo_trade` (
  `id` int(11) NOT NULL,
  `trade` varchar(64) NOT NULL,
  `trade_description` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_attribute`
--

CREATE TABLE `kcms_attribute` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(32) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_attribute`
--

INSERT INTO `kcms_attribute` (`id`, `slug`, `name`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'name', 'name', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(2, 'content', 'content', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(3, 'property', 'property', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(4, 'charset', 'charset', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(5, 'lang', 'lang', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(6, 'scheme', 'scheme', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(7, 'rel', 'rel', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(8, 'href', 'href', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(9, 'type', 'type', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(10, 'http-equiv', 'http-equiv', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(11, 'title', 'title', 'Yes', 'No', '2014-01-07 12:00:00', '2018-02-06 09:56:41'),
(12, 'src', 'src', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(13, 'id', 'id', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(14, 'class', 'class', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(15, 'sizes', 'sizes', 'Yes', 'No', '2014-01-07 12:00:00', '2017-09-02 23:00:00'),
(17, 'itemprop', 'itemprop', 'Yes', 'No', '2014-01-07 12:00:00', '2017-09-02 23:00:00'),
(18, 'description', 'description', 'Yes', 'No', '2020-01-09 23:50:49', '2020-01-09 23:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_block`
--

CREATE TABLE `kcms_block` (
  `id` int(11) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  `author` varchar(255) NOT NULL,
  `extra` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `foot` varchar(64) NOT NULL,
  `view` varchar(64) NOT NULL,
  `region` varchar(64) NOT NULL,
  `block_class` varchar(128) NOT NULL,
  `title_class` varchar(128) NOT NULL,
  `content_class` varchar(128) NOT NULL,
  `foot_class` varchar(128) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_block`
--

INSERT INTO `kcms_block` (`id`, `slug`, `name`, `title`, `author`, `extra`, `body`, `foot`, `view`, `region`, `block_class`, `title_class`, `content_class`, `foot_class`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'welcome_to_kyrandia', 'Welcome to Kyrandia xabc', 'Welcome to Kyrandia CMS', 'Kobus Myburgh', '', '<p><b>Kyrandia CMS (kCMS)</b> is a very customizable CMS built on CodeIgniter 3. With kCMS you have a flexible module development platform, and lots of pre-made modules. Kyrandia CMS is constantly upgraded and renewed and allows the developer great freedom in creating their own modules.</p>', '', 'block-with-title', '', '', '', '', '', 'Yes', 'No', '2018-05-25 16:20:16', '2019-12-22 22:46:15'),
(4, 'full_administration_area', 'Full Administration Area', 'Complete Administration Section', 'Kobus Myburgh', '', '<h3>Administration Section</h3><p><b>Kyrandia CMS</b> has a user friendly administration system where all relevant functionality of the content management system can be managed. Its layout is intuitive, mobile friendly, and clean.&nbsp; Kyrandia CMS is so much more than a Content Management System - it is a complete web platform.</p><h2 style=\"font-family: roboto; background-color: rgb(244, 244, 244);\">Hello Captain. Me, Myself and I.</h2>', '', 'blank', '', '', '', '', '', 'Yes', 'No', '2018-05-25 16:20:16', '2020-01-06 11:57:53'),
(5, 'extended_hooks_system', 'Extended Hooks System', 'Extended Hooks System', '', '', '<h3>Extended Hooks System</h3><p><b>Kyrandia CMS</b> builds onto CodeIgniter\'s versatile hook system to add robust functionality to modules. Modules that follow a few simple rules can implement existing modules\' hooks without requiring existing modules to be modified, norneed the existing modules be aware of new modules\' existence.</p>', '', 'blank', '', '', '', '', '', 'Yes', 'No', '2019-12-22 22:35:49', '2019-12-22 22:49:36'),
(6, 'translation_system', 'Translation System', 'Translation System', '', '', '<h3>Translation System</h3><p><b>Kyrandia CMS</b>&nbsp;extends CodeIgniter\'s translation features allowing you to translate each module into a different language. We currently offer localization. Internationalisation is coming soon. Our filtering hooks system allows you to translate the entire site content into novelty languages, such as pirate speak (included).</p>', '', 'blank', '', '', '', '', '', 'Yes', 'No', '2019-12-22 22:44:20', '2019-12-22 22:50:00'),
(7, 'some_modules_available', 'Some Modules Available', 'Some Modules Available', 'Kobus Myburgh', '', '<h2>Hello Captain. Me, Myself and I.</h2><p><br></p><h2>Some of the modules available:</h2><table class=\"table table-bordered\"><tbody><tr><td>Accordion</td><td>Block</td><td>Help</td></tr><tr><td>Menu</td><td>Metadata</td><td>PDF</td></tr><tr><td>Permission</td><td>Role</td><td>System Logging</td></tr><tr><td>Taxonomy</td><td>User</td><td>Variable</td></tr></tbody></table>', '', 'blank', '', '', '', '', '', 'Yes', 'No', '2018-05-25 16:20:16', '2020-01-06 11:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_csvimport`
--

CREATE TABLE `kcms_csvimport` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `file` varchar(128) NOT NULL,
  `processed` enum('No','Yes') NOT NULL DEFAULT 'No',
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_csvimport`
--

INSERT INTO `kcms_csvimport` (`id`, `slug`, `name`, `file`, `processed`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(2, 'test_import_3', 'Test Import 3', 'uploads/export_5_the_fields.csv', 'No', 'Yes', 'No', '2021-09-25 16:52:07', '2021-09-25 16:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_global_headtag`
--

CREATE TABLE `kcms_global_headtag` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_global_headtag`
--

INSERT INTO `kcms_global_headtag` (`id`, `slug`, `headtag_id`, `priority`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'keywords', 3, 3, 'Yes', 'No', '2014-01-08 12:00:00', '2016-09-18 14:22:06'),
(2, 'description', 4, 4, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(3, 'title', 5, 2, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(4, 'author', 6, 5, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(17, 'charset', 17, 1, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(18, 'viewport-device-width', 18, 3, 'Yes', 'No', '2014-01-08 12:00:00', '2018-05-16 02:03:23'),
(19, 'google-font', 19, 3, 'Yes', 'No', '2014-01-08 12:00:00', '2018-05-16 02:03:30'),
(27, 'robots', 26, 15, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(28, 'favicon', 24, 16, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(29, 'x-ua-compatible', 25, 17, 'Yes', 'No', '2014-01-08 12:00:00', '2014-01-08 12:00:00'),
(30, 'apple-touch-72', 27, 20, 'Yes', 'No', '2018-05-16 02:04:15', '2018-05-16 02:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_global_headtag_attribute`
--

CREATE TABLE `kcms_global_headtag_attribute` (
  `id` int(11) NOT NULL,
  `global_headtag_id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_global_headtag_attribute`
--

INSERT INTO `kcms_global_headtag_attribute` (`id`, `global_headtag_id`, `headtag_id`, `attribute_id`, `value`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 1, 3, 1, 'keywords', 'Yes', 'No', '2014-01-07 12:00:00', '2017-10-02 11:50:20'),
(2, 1, 3, 2, 'kyrandiacms,kcms,impero,excelovate', 'Yes', 'No', '2014-01-07 12:00:00', '2018-03-18 00:20:57'),
(3, 2, 4, 1, 'description', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(4, 2, 4, 2, 'KyrandiaCMS 6.0.0', 'Yes', 'No', '2014-01-07 12:00:00', '2018-03-18 00:21:18'),
(5, 17, 17, 4, 'utf-8', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(6, 18, 18, 1, 'viewport', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(7, 18, 18, 2, 'width=device-width, initial-scale=1.0', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(8, 3, 5, 11, '__SITENAME__', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(9, 4, 6, 1, 'author', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(10, 4, 6, 2, 'KyrandiaCMS 6.0.0', 'Yes', 'No', '2014-01-07 12:00:00', '2018-03-18 00:21:47'),
(11, 19, 19, 8, 'https://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(12, 19, 19, 7, 'stylesheet', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(13, 19, 19, 9, 'text/css', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(48, 28, 24, 7, 'shortcut icon', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(49, 28, 24, 8, '__BASE__assets/images/favicon.ico', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(50, 29, 25, 10, 'X-UA-Compatible', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(51, 29, 25, 2, 'IE=edge', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(52, 27, 26, 1, 'robots', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(53, 27, 26, 2, 'index, follow', 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(54, 30, 27, 7, 'apple-touch-icon', 'Yes', 'No', '2018-05-16 02:04:57', '2018-05-16 02:04:57'),
(55, 30, 27, 15, '72x72', 'Yes', 'No', '2018-05-16 02:05:34', '2018-05-16 02:05:34'),
(56, 30, 27, 8, '__BASE__assets/images/apple-icon-72x72.png', 'Yes', 'No', '2018-05-16 02:06:07', '2018-05-16 02:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_global_meta`
--

CREATE TABLE `kcms_global_meta` (
  `id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_global_meta`
--

INSERT INTO `kcms_global_meta` (`id`, `headtag_id`, `attribute_id`, `value`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(2, 5, 11, 'My website!', 'Yes', 'No', '2020-03-02 17:19:23', '2020-03-02 17:19:23'),
(9, 3, 1, 'keywords', 'Yes', 'No', '2020-03-02 17:20:48', '2020-03-02 17:20:48'),
(10, 3, 2, 'my,website', 'Yes', 'No', '2020-03-02 17:20:48', '2020-03-02 17:20:48'),
(11, 4, 1, 'description', 'Yes', 'No', '2020-03-10 09:22:36', '2020-03-10 09:22:36'),
(12, 4, 2, 'Just another site', 'Yes', 'No', '2020-03-10 09:22:36', '2020-03-10 09:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_headtag`
--

CREATE TABLE `kcms_headtag` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `type` enum('Link','Meta','Title','Custom') NOT NULL DEFAULT 'Meta',
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_headtag`
--

INSERT INTO `kcms_headtag` (`id`, `name`, `slug`, `type`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'og-url', 'og-url', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:42:53'),
(2, 'og-title', 'og-title', 'Meta', 'Yes', 'No', '2016-09-11 00:00:00', '2020-01-09 23:42:45'),
(3, 'keywords', 'keywords', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-01 19:37:14'),
(4, 'description', 'description', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-01 19:37:07'),
(5, 'title', 'title', 'Title', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:45:02'),
(6, 'author', 'author', 'Link', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-10 00:05:15'),
(7, 'og-image', 'og-image', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:42:59'),
(8, 'og-type', 'og-type', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:43:07'),
(9, 'og-description', 'og-description', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:43:13'),
(11, 'twitter-card', 'twitter-card', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:45:41'),
(12, 'twitter-url', 'twitter-url', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:45:54'),
(13, 'twitter-title', 'twitter-title', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:46:08'),
(14, 'twitter-description', 'twitter-description', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:46:20'),
(15, 'twitter-image', 'twitter-image', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:46:31'),
(17, 'charset', 'charset', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:57:16'),
(18, 'viewport', 'viewport', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:57:36'),
(19, 'google-font', 'google-font', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:59:27'),
(20, 'apple-touch-icon', 'apple-touch-icon', 'Link', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-10 00:00:02'),
(21, 'twitter-site', 'twitter-site', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-10 00:00:22'),
(22, 'twitter-creator', 'twitter-creator', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-10 00:00:41'),
(23, 'fb-app-id', 'fb-app-id', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(24, 'icon', 'icon', 'Link', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-10 00:03:11'),
(25, 'x-ua-compatible', 'x-ua-compatible', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(26, 'robots', 'robots', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(41, 'manifest', 'manifest', 'Link', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-09 23:56:46'),
(42, 'msapplication-TileColor', 'msapplication-tilecolor', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-01 19:39:16'),
(43, 'msapplication-TileImage', 'msapplication-tileimage', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-01 19:38:55'),
(44, 'theme-color', 'theme-color', 'Meta', 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-01 19:39:06'),
(47, 'test', 'test', 'Meta', 'Yes', 'No', '2020-01-04 21:53:43', '2020-01-04 21:55:46'),
(49, 'twitter-image-alt', 'twitter-image-alt', 'Meta', 'Yes', 'No', '2020-01-09 23:47:41', '2020-01-09 23:47:41'),
(50, 'article-author', 'article-author', 'Meta', 'Yes', 'No', '2020-01-09 23:48:31', '2020-01-09 23:48:31'),
(51, 'og-locale', 'og-locale', 'Meta', 'Yes', 'No', '2020-01-09 23:49:20', '2020-01-09 23:49:20'),
(52, 'og-site-name', 'og-site-name', 'Meta', 'Yes', 'No', '2020-01-09 23:49:36', '2020-01-09 23:49:36'),
(53, 'og-image-at', 'og-image-at', 'Meta', 'Yes', 'No', '2020-01-09 23:49:49', '2020-01-09 23:49:49'),
(54, 'twitter-dnt', 'twitter-dnt', 'Meta', 'Yes', 'No', '2020-01-09 23:50:07', '2020-01-09 23:50:07'),
(55, 'pinterest', 'pinterest', 'Meta', 'Yes', 'No', '2020-01-09 23:50:35', '2020-01-09 23:51:06'),
(56, 'op-markup-version', 'op-markup-version', 'Meta', 'Yes', 'No', '2020-01-09 23:51:35', '2020-01-09 23:51:35'),
(57, 'canonical', 'canonical', 'Link', 'Yes', 'No', '2020-01-09 23:52:04', '2020-01-09 23:52:04'),
(58, 'fb-article-style', 'fb-article-style', 'Meta', 'Yes', 'No', '2020-01-09 23:52:21', '2020-01-09 23:52:21'),
(59, 'schema-author', 'schema-author', 'Meta', 'Yes', 'No', '2020-01-09 23:53:09', '2020-01-09 23:54:46'),
(60, 'schema-publisher', 'schema-publisher', 'Meta', 'Yes', 'No', '2020-01-09 23:53:25', '2020-01-09 23:54:31'),
(61, 'schema-name', 'schema-name', 'Meta', 'Yes', 'No', '2020-01-09 23:54:16', '2020-01-09 23:54:16'),
(62, 'schema-description', 'schema-description', 'Link', 'Yes', 'No', '2020-01-09 23:55:20', '2020-01-09 23:55:20'),
(63, 'schema-image', 'schema-image', 'Meta', 'Yes', 'No', '2020-01-09 23:55:38', '2020-01-09 23:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_headtag_attribute`
--

CREATE TABLE `kcms_headtag_attribute` (
  `id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_headtag_attribute`
--

INSERT INTO `kcms_headtag_attribute` (`id`, `headtag_id`, `attribute_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 3, 1, 'Yes', 'No', '2014-01-07 12:00:00', '2017-10-02 11:50:20'),
(2, 3, 2, 'Yes', 'No', '2014-01-07 12:00:00', '2018-03-18 00:20:57'),
(3, 4, 1, 'Yes', 'No', '2014-01-07 12:00:00', '2014-01-07 12:00:00'),
(4, 4, 2, 'Yes', 'No', '2014-01-07 12:00:00', '2018-03-18 00:21:18'),
(50, 25, 10, 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(51, 25, 2, 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(52, 26, 1, 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(53, 26, 2, 'Yes', 'No', '2015-05-01 00:00:00', '2015-05-01 00:00:00'),
(67, 47, 1, 'Yes', 'No', '2020-01-04 21:55:46', '2020-01-04 21:55:46'),
(68, 47, 2, 'Yes', 'No', '2020-01-04 21:55:46', '2020-01-04 21:55:46'),
(85, 2, 2, 'Yes', 'No', '2020-01-09 23:42:45', '2020-01-09 23:42:45'),
(86, 2, 3, 'Yes', 'No', '2020-01-09 23:42:45', '2020-01-09 23:42:45'),
(87, 1, 2, 'Yes', 'No', '2020-01-09 23:42:53', '2020-01-09 23:42:53'),
(88, 1, 3, 'Yes', 'No', '2020-01-09 23:42:53', '2020-01-09 23:42:53'),
(89, 7, 2, 'Yes', 'No', '2020-01-09 23:42:59', '2020-01-09 23:42:59'),
(90, 7, 3, 'Yes', 'No', '2020-01-09 23:42:59', '2020-01-09 23:42:59'),
(91, 8, 2, 'Yes', 'No', '2020-01-09 23:43:07', '2020-01-09 23:43:07'),
(92, 8, 3, 'Yes', 'No', '2020-01-09 23:43:07', '2020-01-09 23:43:07'),
(93, 9, 2, 'Yes', 'No', '2020-01-09 23:43:13', '2020-01-09 23:43:13'),
(94, 9, 3, 'Yes', 'No', '2020-01-09 23:43:13', '2020-01-09 23:43:13'),
(99, 5, 11, 'Yes', 'No', '2020-01-09 23:45:02', '2020-01-09 23:45:02'),
(100, 11, 1, 'Yes', 'No', '2020-01-09 23:45:41', '2020-01-09 23:45:41'),
(101, 11, 2, 'Yes', 'No', '2020-01-09 23:45:41', '2020-01-09 23:45:41'),
(102, 12, 1, 'Yes', 'No', '2020-01-09 23:45:54', '2020-01-09 23:45:54'),
(103, 12, 2, 'Yes', 'No', '2020-01-09 23:45:54', '2020-01-09 23:45:54'),
(104, 13, 1, 'Yes', 'No', '2020-01-09 23:46:08', '2020-01-09 23:46:08'),
(105, 13, 2, 'Yes', 'No', '2020-01-09 23:46:08', '2020-01-09 23:46:08'),
(106, 14, 1, 'Yes', 'No', '2020-01-09 23:46:20', '2020-01-09 23:46:20'),
(107, 14, 2, 'Yes', 'No', '2020-01-09 23:46:20', '2020-01-09 23:46:20'),
(108, 15, 1, 'Yes', 'No', '2020-01-09 23:46:31', '2020-01-09 23:46:31'),
(109, 15, 2, 'Yes', 'No', '2020-01-09 23:46:31', '2020-01-09 23:46:31'),
(112, 49, 1, 'Yes', 'No', '2020-01-09 23:47:41', '2020-01-09 23:47:41'),
(113, 49, 2, 'Yes', 'No', '2020-01-09 23:47:41', '2020-01-09 23:47:41'),
(114, 50, 2, 'Yes', 'No', '2020-01-09 23:48:31', '2020-01-09 23:48:31'),
(115, 50, 3, 'Yes', 'No', '2020-01-09 23:48:31', '2020-01-09 23:48:31'),
(116, 51, 2, 'Yes', 'No', '2020-01-09 23:49:20', '2020-01-09 23:49:20'),
(117, 51, 3, 'Yes', 'No', '2020-01-09 23:49:20', '2020-01-09 23:49:20'),
(118, 52, 2, 'Yes', 'No', '2020-01-09 23:49:36', '2020-01-09 23:49:36'),
(119, 52, 3, 'Yes', 'No', '2020-01-09 23:49:36', '2020-01-09 23:49:36'),
(120, 53, 2, 'Yes', 'No', '2020-01-09 23:49:49', '2020-01-09 23:49:49'),
(121, 53, 3, 'Yes', 'No', '2020-01-09 23:49:49', '2020-01-09 23:49:49'),
(122, 54, 1, 'Yes', 'No', '2020-01-09 23:50:07', '2020-01-09 23:50:07'),
(123, 54, 2, 'Yes', 'No', '2020-01-09 23:50:07', '2020-01-09 23:50:07'),
(126, 55, 1, 'Yes', 'No', '2020-01-09 23:51:06', '2020-01-09 23:51:06'),
(127, 55, 2, 'Yes', 'No', '2020-01-09 23:51:06', '2020-01-09 23:51:06'),
(128, 55, 18, 'Yes', 'No', '2020-01-09 23:51:06', '2020-01-09 23:51:06'),
(129, 56, 2, 'Yes', 'No', '2020-01-09 23:51:35', '2020-01-09 23:51:35'),
(130, 56, 3, 'Yes', 'No', '2020-01-09 23:51:35', '2020-01-09 23:51:35'),
(131, 57, 7, 'Yes', 'No', '2020-01-09 23:52:04', '2020-01-09 23:52:04'),
(132, 57, 8, 'Yes', 'No', '2020-01-09 23:52:04', '2020-01-09 23:52:04'),
(133, 58, 2, 'Yes', 'No', '2020-01-09 23:52:21', '2020-01-09 23:52:21'),
(134, 58, 3, 'Yes', 'No', '2020-01-09 23:52:21', '2020-01-09 23:52:21'),
(139, 61, 2, 'Yes', 'No', '2020-01-09 23:54:16', '2020-01-09 23:54:16'),
(140, 61, 17, 'Yes', 'No', '2020-01-09 23:54:16', '2020-01-09 23:54:16'),
(141, 60, 7, 'Yes', 'No', '2020-01-09 23:54:31', '2020-01-09 23:54:31'),
(142, 60, 8, 'Yes', 'No', '2020-01-09 23:54:31', '2020-01-09 23:54:31'),
(143, 59, 7, 'Yes', 'No', '2020-01-09 23:54:46', '2020-01-09 23:54:46'),
(144, 59, 8, 'Yes', 'No', '2020-01-09 23:54:46', '2020-01-09 23:54:46'),
(145, 62, 2, 'Yes', 'No', '2020-01-09 23:55:20', '2020-01-09 23:55:20'),
(146, 62, 17, 'Yes', 'No', '2020-01-09 23:55:20', '2020-01-09 23:55:20'),
(147, 63, 2, 'Yes', 'No', '2020-01-09 23:55:38', '2020-01-09 23:55:38'),
(148, 63, 17, 'Yes', 'No', '2020-01-09 23:55:38', '2020-01-09 23:55:38'),
(149, 41, 7, 'Yes', 'No', '2020-01-09 23:56:46', '2020-01-09 23:56:46'),
(150, 41, 8, 'Yes', 'No', '2020-01-09 23:56:46', '2020-01-09 23:56:46'),
(151, 17, 4, 'Yes', 'No', '2020-01-09 23:57:16', '2020-01-09 23:57:16'),
(152, 18, 1, 'Yes', 'No', '2020-01-09 23:57:36', '2020-01-09 23:57:36'),
(153, 18, 2, 'Yes', 'No', '2020-01-09 23:57:36', '2020-01-09 23:57:36'),
(154, 19, 7, 'Yes', 'No', '2020-01-09 23:59:27', '2020-01-09 23:59:27'),
(155, 19, 8, 'Yes', 'No', '2020-01-09 23:59:27', '2020-01-09 23:59:27'),
(156, 20, 7, 'Yes', 'No', '2020-01-10 00:00:02', '2020-01-10 00:00:02'),
(157, 20, 8, 'Yes', 'No', '2020-01-10 00:00:02', '2020-01-10 00:00:02'),
(158, 21, 1, 'Yes', 'No', '2020-01-10 00:00:22', '2020-01-10 00:00:22'),
(159, 21, 2, 'Yes', 'No', '2020-01-10 00:00:22', '2020-01-10 00:00:22'),
(160, 22, 1, 'Yes', 'No', '2020-01-10 00:00:41', '2020-01-10 00:00:41'),
(161, 22, 2, 'Yes', 'No', '2020-01-10 00:00:41', '2020-01-10 00:00:41'),
(162, 24, 7, 'Yes', 'No', '2020-01-10 00:03:11', '2020-01-10 00:03:11'),
(163, 24, 8, 'Yes', 'No', '2020-01-10 00:03:11', '2020-01-10 00:03:11'),
(164, 24, 15, 'Yes', 'No', '2020-01-10 00:03:11', '2020-01-10 00:03:11'),
(165, 6, 7, 'Yes', 'No', '2020-01-10 00:05:15', '2020-01-10 00:05:15'),
(166, 6, 8, 'Yes', 'No', '2020-01-10 00:05:15', '2020-01-10 00:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_info_block`
--

CREATE TABLE `kcms_info_block` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `info_group` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `image_file` varchar(64) NOT NULL,
  `body_text` text NOT NULL,
  `image_text` text NOT NULL,
  `image_heading` varchar(64) NOT NULL,
  `button_class` varchar(64) NOT NULL,
  `button_text` varchar(64) NOT NULL,
  `section_class` varchar(64) DEFAULT 'banner full',
  `section_id` varchar(64) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_info_block`
--

INSERT INTO `kcms_info_block` (`id`, `slug`, `name`, `info_group`, `description`, `image_path`, `image_file`, `body_text`, `image_text`, `image_heading`, `button_class`, `button_text`, `section_class`, `section_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'info_block_1', 'Info Block 1', 'hielo_main_info_blocks', 'Info Block 1', 'application/views/themes/hielo/images/', 'pic02.jpg', 'Cras aliquet urna ut sapien tincidunt, quis malesuada elit facilisis. Vestibulum sit amet tortor velit. Nam elementum nibh a libero pharetra elementum. Maecenas feugiat ex purus, quis volutpat lacus placerat malesuada.', 'maecenas sapien feugiat ex purus', 'Lorem ipsum dolor', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06'),
(2, 'info_block_2', 'Info Block 2', 'hielo_main_info_blocks', 'Info Block 2', 'application/views/themes/hielo/images/', 'pic03.jpg', 'Cras aliquet urna ut sapien tincidunt, quis malesuada elit facilisis. Vestibulum sit amet tortor velit. Nam elementum nibh a libero pharetra elementum. Maecenas feugiat ex purus, quis volutpat lacus placerat malesuada.', 'mattis elementum sapien pretium tellus', 'Vestibulum sit amet', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(3, 'info_block_1', 'Info Block 1', 'dating_main_info_blocks', 'Info Block 1', 'application/views/themes/dating/images/', 'info1.jpg', 'By default, nobody can message you, except those that have a profile that matches your needs over 90%. You can adjust these settings to allow as many or as little messages based on your choices.', 'Full control over messages', 'Control who messages you!', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06'),
(4, 'info_block_2', 'Info Block 2', 'dating_main_info_blocks', 'Info Block 2', 'application/views/themes/dating/images/', 'info2.jpg', 'We don\'t offer a free dating option, but our rates are so affordable that almost everyone can sign up. This helps us to keep our site clean and full serious romance seekers by creating one small barrier to ensure exclusivity.', 'Affordable', 'Getting in touch is affordable!', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(5, 'info_block_3', 'Info Block 3', 'dating_main_info_blocks', 'Info Block 3', 'application/views/themes/dating/images/', 'info3.jpg', 'Looking for people with similar interests? Check. What about education level? Check! Location? Check. Income? Check. Physical attributes? Check! Refine and save your search profile to ensure only the best matches!', 'Advanced search', 'Find best matching profiles!', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(6, 'info_block_4', 'Info Block 4', 'dating_main_info_blocks', 'Info Block 4', 'application/views/themes/dating/images/', 'info4.jpg', 'Each part of your profile asks you to specify your truthfulness in completing your profile. This helps to filter out users that are not serious about the process. We want to ensure the best matches possible for you.', 'Truth system', 'Get matches that fit you better!', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(7, 'info_block_1', 'Info Block 1', 'flashcards_main_info_blocks', 'Info Block 1', 'application/views/themes/flashcards/images/', 'info1.jpg', 'Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. Body text  for block 1. ', 'Image text for block 1', 'Text for block 1', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06'),
(8, 'info_block_2', 'Info Block 2', 'flashcards_main_info_blocks', 'Info Block 2', 'application/views/themes/flashcards/images/', 'info2.jpg', 'Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. Body text  for block 2. ', 'Image text for block 2', 'Text for block 2', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(9, 'info_block_3', 'Info Block 3', 'flashcards_main_info_blocks', 'Info Block 3', 'application/views/themes/flashcards/images/', 'info3.jpg', 'Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. Body text for block 3. ', 'Image text for block 3', 'Text for block 3', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25'),
(10, 'info_block_4', 'Info Block 4', 'flashcards_main_info_blocks', 'Info Block 4', 'application/views/themes/flashcards/images/', 'info4.jpg', 'Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4. Body text for block 4.', 'Image text for block 4', 'Block 4', 'alt', 'Learn More', 'style2', 'one', 'Yes', 'No', '2020-03-23 03:52:25', '2020-03-23 03:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_layout`
--

CREATE TABLE `kcms_layout` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `file` varchar(128) NOT NULL,
  `areas` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_layout`
--

INSERT INTO `kcms_layout` (`id`, `slug`, `name`, `file`, `areas`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(2, 'two_equal_columns', 'Two equal columns', 'layout_two_equal_columns', 'left,right', 'Yes', 'No', '2016-09-11 20:49:34', '2019-12-27 00:17:47'),
(4, 'three_equal_columns', 'Three equal columns', 'layout_three_equal_columns', 'left,right,center', 'Yes', 'No', '2016-09-25 19:41:24', '2019-12-27 00:19:54'),
(5, 'single_column', 'Single column', 'layout_single_column', 'main', 'Yes', 'No', '2016-09-11 20:49:34', '2019-12-27 00:18:05'),
(6, 'left_side_bar', 'Left side bar', 'layout_left_sidebar', 'left,main', 'Yes', 'No', '2019-12-27 00:19:19', '2020-10-11 02:56:46'),
(7, 'right_side_bar', 'Right side bar', 'layout_right_sidebar', 'right,main', 'Yes', 'No', '2019-12-27 00:20:22', '2019-12-27 00:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_menu`
--

CREATE TABLE `kcms_menu` (
  `id` int(11) NOT NULL,
  `nav_id` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `outer_class` varchar(255) NOT NULL,
  `inner_class` varchar(255) NOT NULL,
  `template_file` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kcms_menu`
--

INSERT INTO `kcms_menu` (`id`, `nav_id`, `slug`, `name`, `description`, `outer_class`, `inner_class`, `template_file`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'adminitems', '', 'Admin', 'Admin top right items', '', '', '', 'Yes', 'No', '2019-11-11 15:55:11', '2019-11-18 14:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_menu_item`
--

CREATE TABLE `kcms_menu_item` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `link_type` enum('Absolute Internal','Relative Internal','External') NOT NULL DEFAULT 'Absolute Internal',
  `class` varchar(255) NOT NULL,
  `icon` varchar(64) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kcms_menu_item`
--

INSERT INTO `kcms_menu_item` (`id`, `slug`, `name`, `description`, `link`, `target`, `link_type`, `class`, `icon`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(3, '', 'Test 1', '', '#test1', '_self', 'Absolute Internal', 'test1', '', 'Yes', 'No', '2019-11-17 00:18:52', '2019-11-17 00:18:52'),
(4, '', 'Test 2', '', '#test2', '_self', 'Absolute Internal', 'test2', '', 'Yes', 'No', '2019-11-17 00:19:28', '2019-11-17 00:19:28'),
(5, '', 'Test 2a', '', '#test1adasdasdasdasd', '_self', 'Absolute Internal', 'test2a', '', 'Yes', 'No', '2019-11-17 00:23:21', '2019-11-18 14:27:48'),
(6, '', 'Test123', '', '#asdasd', '_self', 'Absolute Internal', 'test', '', 'Yes', 'No', '2019-11-18 14:28:32', '2019-11-18 14:28:32'),
(7, '', 'test', '', '#', '_self', 'Absolute Internal', 'asdasdas', '', 'Yes', 'No', '2019-11-18 14:28:44', '2019-11-18 14:28:44'),
(8, '', 'Log out', '', 'logout', '_self', 'Absolute Internal', 'hidden-xs', 'lock-outline', 'Yes', 'No', '2019-11-18 14:54:50', '2019-11-18 15:27:52'),
(9, '', 'Control panel', '', 'control-panel', '_self', 'Absolute Internal', 'hidden-xs', 'view-dashboard', 'Yes', 'No', '2019-11-18 15:21:39', '2019-11-18 15:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_menu_item_link`
--

CREATE TABLE `kcms_menu_item_link` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_menu_item_link`
--

INSERT INTO `kcms_menu_item_link` (`id`, `menu_id`, `menu_item_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(9, 1, 8, 'Yes', 'No', '2019-11-18 14:54:50', '2019-11-18 14:54:50'),
(10, 1, 9, 'Yes', 'No', '2019-11-18 15:21:39', '2019-11-18 15:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_module`
--

CREATE TABLE `kcms_module` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_site` varchar(255) NOT NULL,
  `author_contact` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `slug` varchar(64) NOT NULL,
  `version` varchar(8) NOT NULL,
  `required` enum('No','Yes') NOT NULL DEFAULT 'No',
  `disabled` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_module`
--

INSERT INTO `kcms_module` (`id`, `name`, `description`, `category_id`, `author`, `author_site`, `author_contact`, `status`, `active`, `deleted`, `slug`, `version`, `required`, `disabled`, `createdate`, `moddate`) VALUES
(1, 'Core', 'This module hosts the core features of Kyrandia CMS.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'core', '6.0.0', 'Yes', 'No', '2019-12-08 14:25:07', '2019-12-08 14:56:03'),
(2, 'User', 'This module hosts the user features of Kyrandia CMS.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'user', '6.0.0', 'Yes', 'No', '2019-12-08 14:34:42', '2019-12-08 14:56:28'),
(4, 'Block', 'This module serves content blocks for Kyrandia CMS.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'block', '6.0.0', 'Yes', 'No', '2019-12-08 14:39:33', '2019-12-14 22:56:42'),
(5, 'PDF', 'This module facilitates the generation of PDF documents.', 60, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'pdf', '6.0.0', 'No', 'No', '2019-12-08 14:40:09', '2019-12-08 15:01:42'),
(6, 'Settings', 'This module facilitates system settings and configuration.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'settings', '6.0.0', 'Yes', 'No', '2019-12-08 14:40:52', '2019-12-08 14:56:58'),
(8, 'Menu', 'This module handles KyrandiaCMS\' menus.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'menu', '6.0.0', 'Yes', 'No', '2019-12-08 22:27:38', '2019-12-08 22:27:38'),
(9, 'Permission', 'This module is the base of all access management, namely permissions. Permissions are used in roles to set fine-grained access to specific roles, that are then applied to users.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'permission', '6.0.0', 'Yes', 'No', '2019-12-09 23:19:29', '2019-12-09 23:19:29'),
(10, 'Role', 'This module combines permissions into managed groups so that these grouped permissions can be assigned to users to determine their access to the system.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'role', '6.0.0', 'Yes', 'No', '2019-12-09 23:20:18', '2019-12-09 23:20:18'),
(12, 'Module', 'This module handles all the module-related features of KyrandiaCMS.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'module', '6.0.0', 'Yes', 'No', '2019-12-09 23:44:41', '2019-12-09 23:44:41'),
(18, 'Nucleus (Core)', 'This module contains all the core functions of Kyrandia CMS', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'nucleus', '6.0.0', 'Yes', 'No', '2020-03-22 01:47:58', '2020-03-22 01:47:58'),
(20, 'Variable', 'This module allows the creation and usage of system-wide variables.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'variable', '6.0.0', 'Yes', 'No', '2019-12-13 01:49:35', '2019-12-13 01:49:35'),
(21, 'Widget', 'This module generates widgets.', 69, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'widget', '6.0.0', 'Yes', 'No', '2019-12-20 22:34:30', '2020-03-21 22:31:11'),
(25, 'Filter', 'This module deals with text replacements. Modules that implement filter_hook() functions will be able to tap into its hooks.', 68, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'filter', '6.0.0', 'Yes', 'No', '2019-12-22 13:39:40', '2019-12-22 13:39:40'),
(26, 'Theme', 'This module allows the use of custom themes within the system as opposed to hard-coded themes.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'theme', '6.0.0', 'Yes', 'No', '2019-12-23 14:47:03', '2019-12-23 14:47:03'),
(27, 'Layout', 'This module allows the use of custom layouts within the system as opposed to hard-coded layouts.', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'layout', '6.0.0', 'Yes', 'No', '2019-12-27 00:08:20', '2019-12-27 00:08:20'),
(29, 'Page', 'This module allows the creation of pages for Kyrandia CMS', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'page', '6.0.0', 'Yes', 'No', '2020-01-04 00:37:58', '2020-01-04 00:37:58'),
(31, 'CSVImport', 'This module allows the creation of CSV Imports for Kyrandia CMS', 67, 'Kobus Myburgh', 'https://www.impero.co.za', 'kobus.myburgh@impero.co.za', 'Maintained', 'Yes', 'No', 'csvimport', '7.0.0', 'Yes', 'No', '2021-09-20 00:37:58', '2021-09-20 00:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page`
--

CREATE TABLE `kcms_page` (
  `id` int(11) NOT NULL,
  `name` varchar(1218) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page`
--

INSERT INTO `kcms_page` (`id`, `name`, `slug`, `theme_id`, `layout_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'Welcome', 'welcome', 15, 5, 'Yes', 'No', '2014-01-07 12:00:00', '2020-01-13 22:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page_content`
--

CREATE TABLE `kcms_page_content` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `section_type` varchar(16) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section_area` varchar(32) NOT NULL,
  `section_content` text NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page_content`
--

INSERT INTO `kcms_page_content` (`id`, `page_id`, `section_type`, `section_id`, `section_area`, `section_content`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(9, 1, 'theme', 10, 'main', '', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, 'layout', 5, 'main', '', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 2, 'theme', 13, 'main', '', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 2, 'layout', 5, 'main', '<p>&lt;h2&gt;Scrabble Letter Distribution - sorted by &lt;strong&gt;Tile&lt;/strong&gt;&lt;/h2&gt;</p><p>&lt;table class=\"table table-bordered\"&gt;</p><p>&nbsp; &nbsp; &lt;tbody&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE VALUE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE COUNT&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;A&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;B&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;C&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;D&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;E&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;12&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;F&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;G&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;H&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;I&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;J&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;K&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;5&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;L&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;M&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;N&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;O&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;P&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Q&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;R&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;S&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;T&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;U&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;V&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;W&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;X&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Y&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Z&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;(blank)&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;0&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &lt;/tbody&gt;</p><p>&lt;/table&gt;</p><p><br></p><p><br></p><p><br></p><p><br></p><p>&lt;h2&gt;Scrabble Letter Distribution - sorted by &lt;strong&gt;Tile Value&lt;/strong&gt;&lt;/h2&gt;</p><p>&lt;table class=\"table table-bordered\"&gt;</p><p>&nbsp; &nbsp; &lt;tbody&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE VALUE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE COUNT&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Z&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Q&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;X&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;J&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;K&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;5&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Y&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;W&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;V&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;H&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;F&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;P&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;M&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;C&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;B&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;G&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;D&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;U&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;T&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;S&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;R&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;N&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;O&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;L&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;I&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;E&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;12&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;A&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;(blank)&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;0&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &lt;/tbody&gt;</p><p>&lt;/table&gt;</p><p><br></p><p><br></p><p><br></p><p>&lt;h2&gt;Scrabble Letter Distribution - sorted by &lt;strong&gt;Tile Count&lt;/strong&gt;&lt;/h2&gt;</p><p>&lt;table class=\"table table-bordered\"&gt;</p><p>&nbsp; &nbsp; &lt;tbody&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE VALUE&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;th&gt;TILE COUNT&lt;/th&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;E&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;12&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;A&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;I&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;9&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;O&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;N&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;R&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;T&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;6&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;L&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;S&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;U&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;D&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;G&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;B&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;C&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;P&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;M&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;3&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;F&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;H&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;V&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;W&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Y&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;4&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;(blank)&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;0&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;2&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;J&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;K&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;5&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Q&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;X&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;8&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;tr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;Z&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;10&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;td&gt;1&lt;/td&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/tr&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp; &nbsp; &lt;/tbody&gt;</p><p>&lt;/table&gt;</p>', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page_content_section`
--

CREATE TABLE `kcms_page_content_section` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section_type` varchar(64) NOT NULL,
  `section_container` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `section_content` text NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page_content_section`
--

INSERT INTO `kcms_page_content_section` (`id`, `page_id`, `section_id`, `section_type`, `section_container`, `section_content`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 1, 5, 'main', 'layout', '<p>{{block:welcome-intro}}<br></p>', 'Yes', 'No', '2018-05-25 16:20:30', '2018-05-25 16:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page_headtag`
--

CREATE TABLE `kcms_page_headtag` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `page_id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page_headtag`
--

INSERT INTO `kcms_page_headtag` (`id`, `slug`, `page_id`, `headtag_id`, `priority`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(3, 'keywords', 1, 3, 2, 'Yes', 'No', '2016-09-17 23:03:48', '2016-09-18 00:00:32'),
(4, 'description', 1, 4, 2, 'Yes', 'No', '2016-09-17 23:03:48', '2016-09-18 00:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page_headtag_attribute`
--

CREATE TABLE `kcms_page_headtag_attribute` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `page_headtag_id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page_headtag_attribute`
--

INSERT INTO `kcms_page_headtag_attribute` (`id`, `page_id`, `page_headtag_id`, `headtag_id`, `attribute_id`, `value`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(3, 1, 3, 3, 1, 'keywords', 'Yes', 'No', '2016-09-18 00:00:00', '2016-09-18 12:35:55'),
(4, 1, 3, 3, 2, 'kcms,kyrandiacms,impero,excelovate', 'Yes', 'No', '2016-09-18 00:00:00', '2018-03-18 00:10:09'),
(5, 1, 4, 4, 1, 'description', 'Yes', 'No', '2016-09-18 00:00:00', '2017-09-02 22:53:18'),
(6, 1, 4, 4, 2, 'KyrandiaCMS version 6.0.0', 'Yes', 'No', '2016-09-18 00:00:00', '2018-03-18 00:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_page_meta`
--

CREATE TABLE `kcms_page_meta` (
  `id` int(11) NOT NULL,
  `headtag_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_page_meta`
--

INSERT INTO `kcms_page_meta` (`id`, `headtag_id`, `attribute_id`, `page_id`, `value`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(133, 1, 2, 1, 'kcms', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(134, 1, 3, 1, 'test', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(135, 5, 11, 1, 'testtitle', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(136, 3, 1, 1, 'keywords', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(137, 3, 2, 1, 'test,my,resolve', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(138, 4, 1, 1, 'description', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(139, 4, 2, 1, 'blah de fucking blah', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(140, 2, 2, 1, 'asdasdas', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(141, 2, 3, 1, 'asdasdasd', 'Yes', 'No', '2020-01-13 22:26:52', '2020-01-13 22:26:52'),
(152, 3, 1, 3, 'keywords', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(153, 3, 2, 3, 'test,me,fucker', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(154, 5, 11, 3, 'Spiderman', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(155, 1, 2, 3, 'kcms', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(156, 1, 3, 3, 'asdasd', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(157, 55, 1, 3, 'pinterest', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(158, 55, 2, 3, 'pin', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(159, 55, 18, 3, 'You can pin from my site.', 'Yes', 'No', '2020-01-16 18:05:13', '2020-01-16 18:05:13'),
(169, 5, 11, 2, 'Scrabble Tile Distribution', 'Yes', 'No', '2020-04-05 02:47:13', '2020-04-05 02:47:13'),
(170, 3, 1, 2, 'keywords', 'Yes', 'No', '2020-04-05 02:47:13', '2020-04-05 02:47:13'),
(171, 3, 2, 2, 'scrabble,tile,distribution', 'Yes', 'No', '2020-04-05 02:47:13', '2020-04-05 02:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_parallax_div`
--

CREATE TABLE `kcms_parallax_div` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `image_file` varchar(64) NOT NULL,
  `image_text` text NOT NULL,
  `image_heading` varchar(64) NOT NULL,
  `section_class` varchar(64) DEFAULT 'banner full',
  `section_id` varchar(64) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_parallax_div`
--

INSERT INTO `kcms_parallax_div` (`id`, `slug`, `name`, `description`, `image_path`, `image_file`, `image_text`, `image_heading`, `section_class`, `section_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'hielo_main_parallax_div', 'Parallax Div 1', 'Parallax Div 1', 'application/views/themes/hielo/images/', 'bg.jpg', 'Nam vel ante sit amet libero scelerisque facilisis eleifend vitae urna', 'Morbi maximus justo', 'style3', 'two', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06'),
(2, 'dating_main_parallax_div', 'Parallax Div 1', 'Parallax Div 1', 'application/views/themes/dating/images/', 'bg.jpg', 'Our advanced profile tools allow you to find the best matches for you!', 'Find your special friend today!', 'style3', 'two', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06'),
(3, 'flashcard_main_parallax_div', 'Parallax Div 1', 'Parallax Div 1', 'application/views/themes/flashcard/images/', 'bg.jpg', 'We can change some text here!', 'We can change some text here!', 'style3', 'two', 'Yes', 'No', '2020-03-23 03:20:09', '2020-03-23 03:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_permission`
--

CREATE TABLE `kcms_permission` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `permission` varchar(64) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_permission`
--

INSERT INTO `kcms_permission` (`id`, `slug`, `permission`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, '', 'Access control panel', 'Yes', 'No', '0000-00-00 00:00:00', '2019-11-04 22:25:48'),
(2, '', 'Manage users', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '', 'Add users', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '', 'Edit users', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '', 'Delete users', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '', 'Delete permissions', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '', 'Manage roles', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '', 'Add roles', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '', 'Edit roles', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '', 'Delete roles', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '', 'Manage permissions', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, '', 'Add permissions', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, '', 'Edit permissions', 'Yes', 'No', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, '', 'Manage variables', 'Yes', 'No', '2016-07-06 17:03:10', '2016-07-06 17:03:10'),
(26, '', 'Add variables', 'Yes', 'No', '2016-07-06 17:03:23', '2016-07-06 17:03:23'),
(27, '', 'Edit variables', 'Yes', 'No', '2016-07-06 17:03:40', '2016-07-06 17:03:40'),
(28, '', 'Delete variables', 'Yes', 'No', '2016-07-06 17:03:57', '2016-07-06 17:03:57'),
(37, '', 'Add files', 'Yes', 'No', '2016-07-11 14:08:43', '2016-07-11 14:08:43'),
(38, '', 'Delete files', 'Yes', 'No', '2016-07-11 14:08:49', '2016-07-11 14:08:49'),
(39, '', 'Edit files', 'Yes', 'No', '2016-07-11 14:08:56', '2016-07-11 14:08:56'),
(40, '', 'Manage files', 'Yes', 'No', '2016-07-11 14:09:03', '2016-07-11 14:09:03'),
(263, '', 'Manage metadata', 'Yes', 'No', '2016-09-05 17:53:16', '2016-09-05 17:53:16'),
(264, '', 'Add metadata', 'Yes', 'No', '2016-09-05 17:53:22', '2016-09-05 17:53:22'),
(265, '', 'Delete metadata', 'Yes', 'No', '2016-09-05 17:53:29', '2016-09-05 17:53:29'),
(266, '', 'Edit metadata', 'Yes', 'No', '2016-09-05 17:53:35', '2016-09-05 17:53:35'),
(267, '', 'Manage attributes', 'Yes', 'No', '2016-09-08 21:12:54', '2016-09-08 21:12:54'),
(268, '', 'Add attributes', 'Yes', 'No', '2016-09-08 21:12:59', '2016-09-08 21:12:59'),
(269, '', 'Edit attributes', 'Yes', 'No', '2016-09-08 21:13:06', '2016-09-08 21:13:06'),
(270, '', 'Delete attributes', 'Yes', 'No', '2016-09-08 21:13:14', '2016-09-08 21:13:14'),
(271, '', 'Manage page headtags', 'Yes', 'No', '2016-09-08 21:19:30', '2016-09-08 21:19:30'),
(272, '', 'Add page headtags', 'Yes', 'No', '2016-09-08 21:19:37', '2016-09-08 21:19:37'),
(273, '', 'Delete page headtags', 'Yes', 'No', '2016-09-08 21:19:46', '2016-09-08 21:19:46'),
(274, '', 'Edit page headtags', 'Yes', 'No', '2016-09-08 21:19:53', '2016-09-08 21:19:53'),
(275, '', 'Manage global headtags', 'Yes', 'No', '2016-09-08 21:20:01', '2016-09-08 21:20:01'),
(276, '', 'Add global headtags', 'Yes', 'No', '2016-09-08 21:20:08', '2016-09-08 21:20:08'),
(277, '', 'Delete global headtags', 'Yes', 'No', '2016-09-08 21:20:15', '2016-09-08 21:20:15'),
(278, '', 'Edit global headtags', 'Yes', 'No', '2016-09-08 21:20:21', '2016-09-08 21:20:21'),
(279, '', 'Manage blocks', 'Yes', 'No', '2016-09-08 21:20:28', '2016-09-08 21:20:28'),
(280, '', 'Add blocks', 'Yes', 'No', '2016-09-08 21:20:33', '2016-09-08 21:20:33'),
(281, '', 'Delete blocks', 'Yes', 'No', '2016-09-08 21:20:41', '2016-09-08 21:20:41'),
(282, '', 'Edit blocks', 'Yes', 'No', '2016-09-08 21:20:47', '2016-09-08 21:20:47'),
(283, '', 'Manage layouts', 'Yes', 'No', '2016-09-08 21:20:54', '2016-09-08 21:20:54'),
(284, '', 'Add layouts', 'Yes', 'No', '2016-09-08 21:21:02', '2016-09-08 21:21:02'),
(285, '', 'Delete layouts', 'Yes', 'No', '2016-09-08 21:21:09', '2016-09-08 21:21:09'),
(286, '', 'Edit layouts', 'Yes', 'No', '2016-09-08 21:21:14', '2016-09-08 21:21:14'),
(287, '', 'Manage templates', 'Yes', 'No', '2016-09-08 21:21:19', '2016-09-08 21:21:19'),
(288, '', 'Add templates', 'Yes', 'No', '2016-09-08 21:21:25', '2016-09-08 21:21:25'),
(289, '', 'Delete templates', 'Yes', 'No', '2016-09-08 21:21:32', '2016-09-08 21:21:32'),
(290, '', 'Edit templates', 'Yes', 'No', '2016-09-08 21:21:37', '2016-09-08 21:21:37'),
(291, '', 'Manage pages', 'Yes', 'No', '2016-09-08 21:21:44', '2016-09-08 21:21:44'),
(292, '', 'Add pages', 'Yes', 'No', '2016-09-08 21:21:49', '2016-09-08 21:21:49'),
(293, '', 'Delete pages', 'Yes', 'No', '2016-09-08 21:21:54', '2016-09-08 21:21:54'),
(294, '', 'Edit pages', 'Yes', 'No', '2016-09-08 21:21:58', '2016-09-08 21:21:58'),
(295, '', 'Manage content', 'Yes', 'No', '2016-09-08 21:25:10', '2016-09-08 21:25:10'),
(296, '', 'Add content', 'Yes', 'No', '2016-09-08 21:25:17', '2016-09-08 21:25:17'),
(297, '', 'Delete content', 'Yes', 'No', '2016-09-08 21:25:22', '2016-09-08 21:25:22'),
(298, '', 'Edit content', 'Yes', 'No', '2016-09-08 21:25:27', '2016-09-08 21:25:27'),
(299, '', 'Manage headtags', 'Yes', 'No', '2016-09-08 21:56:49', '2016-09-08 21:56:49'),
(300, '', 'Add headtags', 'Yes', 'No', '2016-09-08 21:56:54', '2016-09-08 21:56:54'),
(301, '', 'Delete headtags', 'Yes', 'No', '2016-09-08 21:57:00', '2016-09-08 21:57:00'),
(302, '', 'Edit headtags', 'Yes', 'No', '2016-09-08 21:57:05', '2016-09-08 21:57:05'),
(328, '', 'Manage newsletters', 'Yes', 'No', '2018-02-08 12:48:26', '2018-05-16 02:11:28'),
(329, '', 'Add newsletters', 'Yes', 'No', '2018-05-16 02:11:37', '2018-05-16 02:11:37'),
(330, '', 'Edit newsletters', 'Yes', 'No', '2018-05-16 02:11:43', '2018-05-16 02:11:43'),
(331, '', 'Delete newsletters', 'Yes', 'No', '2018-05-16 02:11:49', '2018-05-16 02:11:49'),
(334, '', 'Manage menus', 'Yes', 'No', '2019-11-11 11:24:45', '2019-11-11 11:24:45'),
(335, '', 'Add menus', 'Yes', 'No', '2019-11-11 11:25:20', '2019-11-11 11:25:35'),
(336, '', 'Edit menus', 'Yes', 'No', '2019-11-11 11:25:50', '2019-11-11 11:25:50'),
(337, '', 'Delete menus', 'Yes', 'No', '2019-11-11 11:25:57', '2019-11-11 11:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_role`
--

CREATE TABLE `kcms_role` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `role` varchar(32) NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_role`
--

INSERT INTO `kcms_role` (`id`, `slug`, `role`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'administrator', 'Administrator', 'Yes', 'No', '0000-00-00 00:00:00', '2018-05-16 02:12:09'),
(2, 'user', 'User', 'No', 'Yes', '0000-00-00 00:00:00', '2018-05-16 02:12:17'),
(17, 'content_manager', 'Content Manager', 'Yes', 'No', '2016-09-08 21:24:26', '2018-05-16 02:13:25'),
(39, 'super_administrator', 'Super Administrator', 'Yes', 'No', '2018-07-21 01:21:23', '2020-03-02 22:15:32'),
(60, 'test', 'Test', 'Yes', 'No', '2021-04-24 15:39:23', '2021-04-24 15:39:23'),
(61, 'blah', 'Blah', 'Yes', 'No', '2021-04-24 15:40:49', '2021-04-24 15:40:49'),
(62, 'blahasdasd', 'Blahasdasd', 'Yes', 'No', '2021-04-24 15:41:23', '2021-04-24 15:41:23'),
(63, 'example', 'Example', 'Yes', 'No', '2021-04-24 15:42:23', '2021-04-24 15:42:23'),
(64, 'saasdasd', 'saasdasd', 'Yes', 'No', '2021-04-24 15:45:02', '2021-04-24 15:45:02'),
(65, 'asdasdasd', 'asdasdasd', 'Yes', 'No', '2021-04-24 15:45:53', '2021-04-24 15:45:53'),
(66, 'sdfghdfgdfgdfg', 'sdfghdfgdfgdfg', 'Yes', 'No', '2021-04-24 15:45:57', '2021-04-24 15:45:57'),
(67, 'sdgfsdfgsdfgsdfg', 'sdgfsdfgsdfgsdfg', 'Yes', 'No', '2021-04-24 15:46:01', '2021-04-24 15:46:01'),
(68, 'dfafsasfdgasfg', 'dfafsasfdgasfg', 'Yes', 'No', '2021-04-24 15:46:35', '2021-04-24 15:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_role_permission`
--

CREATE TABLE `kcms_role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_role_permission`
--

INSERT INTO `kcms_role_permission` (`role_id`, `permission_id`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 1, 'Yes', 'No', '2018-05-16 02:12:10', '2018-05-16 02:12:10'),
(1, 2, 'Yes', 'No', '2018-05-16 02:12:10', '2018-05-16 02:12:10'),
(1, 3, 'Yes', 'No', '2018-05-16 02:12:10', '2018-05-16 02:12:10'),
(1, 4, 'Yes', 'No', '2018-05-16 02:12:10', '2018-05-16 02:12:10'),
(2, 1, 'No', 'Yes', '2018-05-16 02:12:17', '2018-05-16 02:12:17'),
(17, 37, 'Yes', 'No', '2018-05-16 02:13:25', '2018-05-16 02:13:25'),
(17, 38, 'Yes', 'No', '2018-05-16 02:13:25', '2018-05-16 02:13:25'),
(17, 39, 'Yes', 'No', '2018-05-16 02:13:25', '2018-05-16 02:13:25'),
(17, 40, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 267, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 268, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 269, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 270, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 271, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 272, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 273, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 274, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 275, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 276, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 277, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 278, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 279, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 280, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 281, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 282, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 283, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 284, 'Yes', 'No', '2018-05-16 02:13:26', '2018-05-16 02:13:26'),
(17, 285, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 286, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 287, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 288, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 289, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 290, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 291, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 292, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 293, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 294, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 295, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 296, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 297, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 298, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 299, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 300, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 301, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 302, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 328, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 329, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 330, 'Yes', 'No', '2018-05-16 02:13:27', '2018-05-16 02:13:27'),
(17, 331, 'Yes', 'No', '2018-05-16 02:13:28', '2018-05-16 02:13:28'),
(39, 1, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 2, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 3, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 4, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 5, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 6, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 7, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 8, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 9, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 10, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 11, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 12, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 13, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 25, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 26, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 27, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 28, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 37, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 38, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 39, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 40, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 263, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 264, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 265, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 266, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 267, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 268, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 269, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 270, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 271, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 272, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 273, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 274, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 275, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 276, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 277, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 278, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 279, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 280, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 281, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 282, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 283, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 284, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 285, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 286, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 287, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 288, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 289, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 290, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 291, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 292, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 293, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 294, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 295, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 296, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 297, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 298, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 299, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 300, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 301, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 302, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 328, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 329, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 330, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 331, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 334, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 335, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 336, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32'),
(39, 337, 'Yes', 'No', '2020-03-02 22:15:32', '2020-03-02 22:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_session`
--

CREATE TABLE `kcms_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_session`
--

INSERT INTO `kcms_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0k35n63ggd44euvq9950b423ii7o2jtu', '127.0.0.1', 1621287671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632313238373636363b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d),
('4t2tbei0bsgub2p5b1nnfojs7vft1rvt', '127.0.0.1', 1631447540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633313434373533383b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d);
INSERT INTO `kcms_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('5bf3uf455vt7ukr58gqp92frg257l197', '127.0.0.1', 1632589943, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633323538393734343b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7461786f6e6f6d797c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205461786f6e6f6d79204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3038223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d657461646174617c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204d657461647461204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31312d3232223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73656f7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a333a2273656f223b733a31313a226465736372697074696f6e223b733a32323a224b7972616e646961434d532053454f204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f637376696d706f72747c613a373a7b733a373a2276657273696f6e223b733a353a22372e302e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a393a22637376696d706f7274223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d532043535620496d706f7274204d6f64756c65223b733a343a2264617465223b733a31303a22323032312d30392d3139223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d69647c733a313a2231223b757365726e616d657c733a343a22626c6978223b63757272656e745f69707c733a393a223132372e302e302e31223b63757272656e745f6c6f67696e5f646174657c733a31393a22323032312d30392d32352031343a31323a3139223b70726576696f75735f6c6f67696e5f646174657c733a31393a22323032312d30392d32352031333a32333a3535223b70726576696f75735f69707c733a393a223132372e302e302e31223b757365725f726f6c65737c613a333a7b693a313b613a373a7b733a323a226964223b733a313a2231223b733a343a22736c7567223b733a31333a2261646d696e6973747261746f72223b733a343a22726f6c65223b733a31333a2241646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22303030302d30302d30302030303a30303a3030223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31323a3039223b7d693a31373b613a373a7b733a323a226964223b733a323a223137223b733a343a22736c7567223b733a31353a22636f6e74656e745f6d616e61676572223b733a343a22726f6c65223b733a31353a22436f6e74656e74204d616e61676572223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031362d30392d30382032313a32343a3236223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31333a3235223b7d693a33393b613a373a7b733a323a226964223b733a323a223339223b733a343a22736c7567223b733a31393a2273757065725f61646d696e6973747261746f72223b733a343a22726f6c65223b733a31393a2253757065722041646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031382d30372d32312030313a32313a3233223b733a373a226d6f6464617465223b733a31393a22323032302d30332d30322032323a31353a3332223b7d7d757365725f7065726d697373696f6e737c613a36393a7b693a313b613a343a7b733a323a226964223b733a313a2231223b733a31303a227065726d697373696f6e223b733a32303a2241636365737320636f6e74726f6c2070616e656c223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2231223b7d693a323b613a343a7b733a323a226964223b733a313a2232223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2232223b7d693a333b613a343a7b733a323a226964223b733a313a2233223b733a31303a227065726d697373696f6e223b733a393a22416464207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2233223b7d693a343b613a343a7b733a323a226964223b733a313a2234223b733a31303a227065726d697373696f6e223b733a31303a2245646974207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2234223b7d693a33373b613a343a7b733a323a226964223b733a323a223337223b733a31303a227065726d697373696f6e223b733a393a224164642066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223337223b7d693a33383b613a343a7b733a323a226964223b733a323a223338223b733a31303a227065726d697373696f6e223b733a31323a2244656c6574652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223338223b7d693a33393b613a343a7b733a323a226964223b733a323a223339223b733a31303a227065726d697373696f6e223b733a31303a22456469742066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223339223b7d693a34303b613a343a7b733a323a226964223b733a323a223430223b733a31303a227065726d697373696f6e223b733a31323a224d616e6167652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223430223b7d693a3236373b613a343a7b733a323a226964223b733a333a22323637223b733a31303a227065726d697373696f6e223b733a31373a224d616e6167652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323637223b7d693a3236383b613a343a7b733a323a226964223b733a333a22323638223b733a31303a227065726d697373696f6e223b733a31343a224164642061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323638223b7d693a3236393b613a343a7b733a323a226964223b733a333a22323639223b733a31303a227065726d697373696f6e223b733a31353a22456469742061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323639223b7d693a3237303b613a343a7b733a323a226964223b733a333a22323730223b733a31303a227065726d697373696f6e223b733a31373a2244656c6574652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323730223b7d693a3237313b613a343a7b733a323a226964223b733a333a22323731223b733a31303a227065726d697373696f6e223b733a32303a224d616e6167652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323731223b7d693a3237323b613a343a7b733a323a226964223b733a333a22323732223b733a31303a227065726d697373696f6e223b733a31373a224164642070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323732223b7d693a3237333b613a343a7b733a323a226964223b733a333a22323733223b733a31303a227065726d697373696f6e223b733a32303a2244656c6574652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323733223b7d693a3237343b613a343a7b733a323a226964223b733a333a22323734223b733a31303a227065726d697373696f6e223b733a31383a22456469742070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323734223b7d693a3237353b613a343a7b733a323a226964223b733a333a22323735223b733a31303a227065726d697373696f6e223b733a32323a224d616e61676520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323735223b7d693a3237363b613a343a7b733a323a226964223b733a333a22323736223b733a31303a227065726d697373696f6e223b733a31393a2241646420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323736223b7d693a3237373b613a343a7b733a323a226964223b733a333a22323737223b733a31303a227065726d697373696f6e223b733a32323a2244656c65746520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323737223b7d693a3237383b613a343a7b733a323a226964223b733a333a22323738223b733a31303a227065726d697373696f6e223b733a32303a224564697420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323738223b7d693a3237393b613a343a7b733a323a226964223b733a333a22323739223b733a31303a227065726d697373696f6e223b733a31333a224d616e61676520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323739223b7d693a3238303b613a343a7b733a323a226964223b733a333a22323830223b733a31303a227065726d697373696f6e223b733a31303a2241646420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323830223b7d693a3238313b613a343a7b733a323a226964223b733a333a22323831223b733a31303a227065726d697373696f6e223b733a31333a2244656c65746520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323831223b7d693a3238323b613a343a7b733a323a226964223b733a333a22323832223b733a31303a227065726d697373696f6e223b733a31313a224564697420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323832223b7d693a3238333b613a343a7b733a323a226964223b733a333a22323833223b733a31303a227065726d697373696f6e223b733a31343a224d616e616765206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323833223b7d693a3238343b613a343a7b733a323a226964223b733a333a22323834223b733a31303a227065726d697373696f6e223b733a31313a22416464206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323834223b7d693a3238353b613a343a7b733a323a226964223b733a333a22323835223b733a31303a227065726d697373696f6e223b733a31343a2244656c657465206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323835223b7d693a3238363b613a343a7b733a323a226964223b733a333a22323836223b733a31303a227065726d697373696f6e223b733a31323a2245646974206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323836223b7d693a3238373b613a343a7b733a323a226964223b733a333a22323837223b733a31303a227065726d697373696f6e223b733a31363a224d616e6167652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323837223b7d693a3238383b613a343a7b733a323a226964223b733a333a22323838223b733a31303a227065726d697373696f6e223b733a31333a224164642074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323838223b7d693a3238393b613a343a7b733a323a226964223b733a333a22323839223b733a31303a227065726d697373696f6e223b733a31363a2244656c6574652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323839223b7d693a3239303b613a343a7b733a323a226964223b733a333a22323930223b733a31303a227065726d697373696f6e223b733a31343a22456469742074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323930223b7d693a3239313b613a343a7b733a323a226964223b733a333a22323931223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323931223b7d693a3239323b613a343a7b733a323a226964223b733a333a22323932223b733a31303a227065726d697373696f6e223b733a393a22416464207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323932223b7d693a3239333b613a343a7b733a323a226964223b733a333a22323933223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323933223b7d693a3239343b613a343a7b733a323a226964223b733a333a22323934223b733a31303a227065726d697373696f6e223b733a31303a2245646974207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323934223b7d693a3239353b613a343a7b733a323a226964223b733a333a22323935223b733a31303a227065726d697373696f6e223b733a31343a224d616e61676520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323935223b7d693a3239363b613a343a7b733a323a226964223b733a333a22323936223b733a31303a227065726d697373696f6e223b733a31313a2241646420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323936223b7d693a3239373b613a343a7b733a323a226964223b733a333a22323937223b733a31303a227065726d697373696f6e223b733a31343a2244656c65746520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323937223b7d693a3239383b613a343a7b733a323a226964223b733a333a22323938223b733a31303a227065726d697373696f6e223b733a31323a224564697420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323938223b7d693a3239393b613a343a7b733a323a226964223b733a333a22323939223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323939223b7d693a3330303b613a343a7b733a323a226964223b733a333a22333030223b733a31303a227065726d697373696f6e223b733a31323a22416464206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333030223b7d693a3330313b613a343a7b733a323a226964223b733a333a22333031223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333031223b7d693a3330323b613a343a7b733a323a226964223b733a333a22333032223b733a31303a227065726d697373696f6e223b733a31333a2245646974206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333032223b7d693a3332383b613a343a7b733a323a226964223b733a333a22333238223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333238223b7d693a3332393b613a343a7b733a323a226964223b733a333a22333239223b733a31303a227065726d697373696f6e223b733a31353a22416464206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333239223b7d693a3333303b613a343a7b733a323a226964223b733a333a22333330223b733a31303a227065726d697373696f6e223b733a31363a2245646974206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333330223b7d693a3333313b613a343a7b733a323a226964223b733a333a22333331223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333331223b7d693a353b613a343a7b733a323a226964223b733a313a2235223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2235223b7d693a363b613a343a7b733a323a226964223b733a313a2236223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2236223b7d693a373b613a343a7b733a323a226964223b733a313a2237223b733a31303a227065726d697373696f6e223b733a31323a224d616e61676520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2237223b7d693a383b613a343a7b733a323a226964223b733a313a2238223b733a31303a227065726d697373696f6e223b733a393a2241646420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2238223b7d693a393b613a343a7b733a323a226964223b733a313a2239223b733a31303a227065726d697373696f6e223b733a31303a224564697420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2239223b7d693a31303b613a343a7b733a323a226964223b733a323a223130223b733a31303a227065726d697373696f6e223b733a31323a2244656c65746520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223130223b7d693a31313b613a343a7b733a323a226964223b733a323a223131223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223131223b7d693a31323b613a343a7b733a323a226964223b733a323a223132223b733a31303a227065726d697373696f6e223b733a31353a22416464207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223132223b7d693a31333b613a343a7b733a323a226964223b733a323a223133223b733a31303a227065726d697373696f6e223b733a31363a2245646974207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223133223b7d693a32353b613a343a7b733a323a226964223b733a323a223235223b733a31303a227065726d697373696f6e223b733a31363a224d616e616765207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223235223b7d693a32363b613a343a7b733a323a226964223b733a323a223236223b733a31303a227065726d697373696f6e223b733a31333a22416464207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223236223b7d693a32373b613a343a7b733a323a226964223b733a323a223237223b733a31303a227065726d697373696f6e223b733a31343a2245646974207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223237223b7d693a32383b613a343a7b733a323a226964223b733a323a223238223b733a31303a227065726d697373696f6e223b733a31363a2244656c657465207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223238223b7d693a3236333b613a343a7b733a323a226964223b733a333a22323633223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323633223b7d693a3236343b613a343a7b733a323a226964223b733a333a22323634223b733a31303a227065726d697373696f6e223b733a31323a22416464206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323634223b7d693a3236353b613a343a7b733a323a226964223b733a333a22323635223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323635223b7d693a3236363b613a343a7b733a323a226964223b733a333a22323636223b733a31303a227065726d697373696f6e223b733a31333a2245646974206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323636223b7d693a3333343b613a343a7b733a323a226964223b733a333a22333334223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333334223b7d693a3333353b613a343a7b733a323a226964223b733a333a22333335223b733a31303a227065726d697373696f6e223b733a393a22416464206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333335223b7d693a3333363b613a343a7b733a323a226964223b733a333a22333336223b733a31303a227065726d697373696f6e223b733a31303a2245646974206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333336223b7d693a3333373b613a343a7b733a323a226964223b733a333a22333337223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333337223b7d7d737563636573737c733a38333a22596f752068617665207375636365737366756c6c7920656469746564207468652043535620496d706f7274203c7374726f6e673e5465737420496d706f727420333c2f7374726f6e673e202849443a2032292e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('dsk3jdk61ph62s0r2pllin4u476egle5', '127.0.0.1', 1630857662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633303835373636313b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d);
INSERT INTO `kcms_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('fr7hs1invi3edila4ak09ed0d1a70nk6', '127.0.0.1', 1630606311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633303630363331313b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d),
('htg31kr75mf8l6phq3e48r86mojncl91', '127.0.0.1', 1621289391, 0x5f5f63695f6c6173745f726567656e65726174657c693a313632313238393131383b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d);
INSERT INTO `kcms_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('javtnu4gjs9kjfkncnkh0cs0il55c19r', '127.0.0.1', 1632082345, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633323038323138363b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7461786f6e6f6d797c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205461786f6e6f6d79204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3038223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d657461646174617c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204d657461647461204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31312d3232223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73656f7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a333a2273656f223b733a31313a226465736372697074696f6e223b733a32323a224b7972616e646961434d532053454f204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6373765f696d706f72747c613a373a7b733a373a2276657273696f6e223b733a353a22372e302e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a226373765f696d706f7274223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d532043535620496d706f7274204d6f64756c65223b733a343a2264617465223b733a31303a22323032312d30392d3139223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d69647c733a313a2231223b757365726e616d657c733a343a22626c6978223b63757272656e745f69707c733a393a223132372e302e302e31223b63757272656e745f6c6f67696e5f646174657c733a31393a22323032312d30392d31392031383a32373a3434223b70726576696f75735f6c6f67696e5f646174657c733a31393a22323032312d30392d31392031373a31373a3433223b70726576696f75735f69707c733a393a223132372e302e302e31223b757365725f726f6c65737c613a333a7b693a313b613a373a7b733a323a226964223b733a313a2231223b733a343a22736c7567223b733a31333a2261646d696e6973747261746f72223b733a343a22726f6c65223b733a31333a2241646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22303030302d30302d30302030303a30303a3030223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31323a3039223b7d693a31373b613a373a7b733a323a226964223b733a323a223137223b733a343a22736c7567223b733a31353a22636f6e74656e745f6d616e61676572223b733a343a22726f6c65223b733a31353a22436f6e74656e74204d616e61676572223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031362d30392d30382032313a32343a3236223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31333a3235223b7d693a33393b613a373a7b733a323a226964223b733a323a223339223b733a343a22736c7567223b733a31393a2273757065725f61646d696e6973747261746f72223b733a343a22726f6c65223b733a31393a2253757065722041646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031382d30372d32312030313a32313a3233223b733a373a226d6f6464617465223b733a31393a22323032302d30332d30322032323a31353a3332223b7d7d757365725f7065726d697373696f6e737c613a36393a7b693a313b613a343a7b733a323a226964223b733a313a2231223b733a31303a227065726d697373696f6e223b733a32303a2241636365737320636f6e74726f6c2070616e656c223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2231223b7d693a323b613a343a7b733a323a226964223b733a313a2232223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2232223b7d693a333b613a343a7b733a323a226964223b733a313a2233223b733a31303a227065726d697373696f6e223b733a393a22416464207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2233223b7d693a343b613a343a7b733a323a226964223b733a313a2234223b733a31303a227065726d697373696f6e223b733a31303a2245646974207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2234223b7d693a33373b613a343a7b733a323a226964223b733a323a223337223b733a31303a227065726d697373696f6e223b733a393a224164642066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223337223b7d693a33383b613a343a7b733a323a226964223b733a323a223338223b733a31303a227065726d697373696f6e223b733a31323a2244656c6574652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223338223b7d693a33393b613a343a7b733a323a226964223b733a323a223339223b733a31303a227065726d697373696f6e223b733a31303a22456469742066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223339223b7d693a34303b613a343a7b733a323a226964223b733a323a223430223b733a31303a227065726d697373696f6e223b733a31323a224d616e6167652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223430223b7d693a3236373b613a343a7b733a323a226964223b733a333a22323637223b733a31303a227065726d697373696f6e223b733a31373a224d616e6167652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323637223b7d693a3236383b613a343a7b733a323a226964223b733a333a22323638223b733a31303a227065726d697373696f6e223b733a31343a224164642061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323638223b7d693a3236393b613a343a7b733a323a226964223b733a333a22323639223b733a31303a227065726d697373696f6e223b733a31353a22456469742061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323639223b7d693a3237303b613a343a7b733a323a226964223b733a333a22323730223b733a31303a227065726d697373696f6e223b733a31373a2244656c6574652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323730223b7d693a3237313b613a343a7b733a323a226964223b733a333a22323731223b733a31303a227065726d697373696f6e223b733a32303a224d616e6167652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323731223b7d693a3237323b613a343a7b733a323a226964223b733a333a22323732223b733a31303a227065726d697373696f6e223b733a31373a224164642070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323732223b7d693a3237333b613a343a7b733a323a226964223b733a333a22323733223b733a31303a227065726d697373696f6e223b733a32303a2244656c6574652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323733223b7d693a3237343b613a343a7b733a323a226964223b733a333a22323734223b733a31303a227065726d697373696f6e223b733a31383a22456469742070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323734223b7d693a3237353b613a343a7b733a323a226964223b733a333a22323735223b733a31303a227065726d697373696f6e223b733a32323a224d616e61676520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323735223b7d693a3237363b613a343a7b733a323a226964223b733a333a22323736223b733a31303a227065726d697373696f6e223b733a31393a2241646420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323736223b7d693a3237373b613a343a7b733a323a226964223b733a333a22323737223b733a31303a227065726d697373696f6e223b733a32323a2244656c65746520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323737223b7d693a3237383b613a343a7b733a323a226964223b733a333a22323738223b733a31303a227065726d697373696f6e223b733a32303a224564697420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323738223b7d693a3237393b613a343a7b733a323a226964223b733a333a22323739223b733a31303a227065726d697373696f6e223b733a31333a224d616e61676520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323739223b7d693a3238303b613a343a7b733a323a226964223b733a333a22323830223b733a31303a227065726d697373696f6e223b733a31303a2241646420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323830223b7d693a3238313b613a343a7b733a323a226964223b733a333a22323831223b733a31303a227065726d697373696f6e223b733a31333a2244656c65746520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323831223b7d693a3238323b613a343a7b733a323a226964223b733a333a22323832223b733a31303a227065726d697373696f6e223b733a31313a224564697420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323832223b7d693a3238333b613a343a7b733a323a226964223b733a333a22323833223b733a31303a227065726d697373696f6e223b733a31343a224d616e616765206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323833223b7d693a3238343b613a343a7b733a323a226964223b733a333a22323834223b733a31303a227065726d697373696f6e223b733a31313a22416464206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323834223b7d693a3238353b613a343a7b733a323a226964223b733a333a22323835223b733a31303a227065726d697373696f6e223b733a31343a2244656c657465206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323835223b7d693a3238363b613a343a7b733a323a226964223b733a333a22323836223b733a31303a227065726d697373696f6e223b733a31323a2245646974206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323836223b7d693a3238373b613a343a7b733a323a226964223b733a333a22323837223b733a31303a227065726d697373696f6e223b733a31363a224d616e6167652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323837223b7d693a3238383b613a343a7b733a323a226964223b733a333a22323838223b733a31303a227065726d697373696f6e223b733a31333a224164642074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323838223b7d693a3238393b613a343a7b733a323a226964223b733a333a22323839223b733a31303a227065726d697373696f6e223b733a31363a2244656c6574652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323839223b7d693a3239303b613a343a7b733a323a226964223b733a333a22323930223b733a31303a227065726d697373696f6e223b733a31343a22456469742074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323930223b7d693a3239313b613a343a7b733a323a226964223b733a333a22323931223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323931223b7d693a3239323b613a343a7b733a323a226964223b733a333a22323932223b733a31303a227065726d697373696f6e223b733a393a22416464207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323932223b7d693a3239333b613a343a7b733a323a226964223b733a333a22323933223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323933223b7d693a3239343b613a343a7b733a323a226964223b733a333a22323934223b733a31303a227065726d697373696f6e223b733a31303a2245646974207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323934223b7d693a3239353b613a343a7b733a323a226964223b733a333a22323935223b733a31303a227065726d697373696f6e223b733a31343a224d616e61676520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323935223b7d693a3239363b613a343a7b733a323a226964223b733a333a22323936223b733a31303a227065726d697373696f6e223b733a31313a2241646420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323936223b7d693a3239373b613a343a7b733a323a226964223b733a333a22323937223b733a31303a227065726d697373696f6e223b733a31343a2244656c65746520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323937223b7d693a3239383b613a343a7b733a323a226964223b733a333a22323938223b733a31303a227065726d697373696f6e223b733a31323a224564697420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323938223b7d693a3239393b613a343a7b733a323a226964223b733a333a22323939223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323939223b7d693a3330303b613a343a7b733a323a226964223b733a333a22333030223b733a31303a227065726d697373696f6e223b733a31323a22416464206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333030223b7d693a3330313b613a343a7b733a323a226964223b733a333a22333031223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333031223b7d693a3330323b613a343a7b733a323a226964223b733a333a22333032223b733a31303a227065726d697373696f6e223b733a31333a2245646974206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333032223b7d693a3332383b613a343a7b733a323a226964223b733a333a22333238223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333238223b7d693a3332393b613a343a7b733a323a226964223b733a333a22333239223b733a31303a227065726d697373696f6e223b733a31353a22416464206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333239223b7d693a3333303b613a343a7b733a323a226964223b733a333a22333330223b733a31303a227065726d697373696f6e223b733a31363a2245646974206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333330223b7d693a3333313b613a343a7b733a323a226964223b733a333a22333331223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333331223b7d693a353b613a343a7b733a323a226964223b733a313a2235223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2235223b7d693a363b613a343a7b733a323a226964223b733a313a2236223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2236223b7d693a373b613a343a7b733a323a226964223b733a313a2237223b733a31303a227065726d697373696f6e223b733a31323a224d616e61676520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2237223b7d693a383b613a343a7b733a323a226964223b733a313a2238223b733a31303a227065726d697373696f6e223b733a393a2241646420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2238223b7d693a393b613a343a7b733a323a226964223b733a313a2239223b733a31303a227065726d697373696f6e223b733a31303a224564697420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2239223b7d693a31303b613a343a7b733a323a226964223b733a323a223130223b733a31303a227065726d697373696f6e223b733a31323a2244656c65746520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223130223b7d693a31313b613a343a7b733a323a226964223b733a323a223131223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223131223b7d693a31323b613a343a7b733a323a226964223b733a323a223132223b733a31303a227065726d697373696f6e223b733a31353a22416464207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223132223b7d693a31333b613a343a7b733a323a226964223b733a323a223133223b733a31303a227065726d697373696f6e223b733a31363a2245646974207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223133223b7d693a32353b613a343a7b733a323a226964223b733a323a223235223b733a31303a227065726d697373696f6e223b733a31363a224d616e616765207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223235223b7d693a32363b613a343a7b733a323a226964223b733a323a223236223b733a31303a227065726d697373696f6e223b733a31333a22416464207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223236223b7d693a32373b613a343a7b733a323a226964223b733a323a223237223b733a31303a227065726d697373696f6e223b733a31343a2245646974207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223237223b7d693a32383b613a343a7b733a323a226964223b733a323a223238223b733a31303a227065726d697373696f6e223b733a31363a2244656c657465207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223238223b7d693a3236333b613a343a7b733a323a226964223b733a333a22323633223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323633223b7d693a3236343b613a343a7b733a323a226964223b733a333a22323634223b733a31303a227065726d697373696f6e223b733a31323a22416464206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323634223b7d693a3236353b613a343a7b733a323a226964223b733a333a22323635223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323635223b7d693a3236363b613a343a7b733a323a226964223b733a333a22323636223b733a31303a227065726d697373696f6e223b733a31333a2245646974206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323636223b7d693a3333343b613a343a7b733a323a226964223b733a333a22333334223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333334223b7d693a3333353b613a343a7b733a323a226964223b733a333a22333335223b733a31303a227065726d697373696f6e223b733a393a22416464206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333335223b7d693a3333363b613a343a7b733a323a226964223b733a333a22333336223b733a31303a227065726d697373696f6e223b733a31303a2245646974206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333336223b7d693a3333373b613a343a7b733a323a226964223b733a333a22333337223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333337223b7d7d737563636573737c733a37383a22596f752068617665207375636365737366756c6c79206164646564207468652043535620496d706f7274203c7374726f6e673e67736773646667683c2f7374726f6e673e202849443a203131292e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d);
INSERT INTO `kcms_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('jrsgm2bg4t8pqi6flit1he3lv6r4bcq2', '127.0.0.1', 1631562195, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633313536313937323b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d69647c733a313a2231223b757365726e616d657c733a343a22626c6978223b63757272656e745f69707c733a393a223132372e302e302e31223b63757272656e745f6c6f67696e5f646174657c733a31393a22323032312d30392d31332031383a34363a3435223b70726576696f75735f6c6f67696e5f646174657c733a31393a22323032312d30392d31332032303a34323a3133223b70726576696f75735f69707c733a393a223132372e302e302e31223b757365725f726f6c65737c613a333a7b693a313b613a373a7b733a323a226964223b733a313a2231223b733a343a22736c7567223b733a31333a2261646d696e6973747261746f72223b733a343a22726f6c65223b733a31333a2241646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22303030302d30302d30302030303a30303a3030223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31323a3039223b7d693a31373b613a373a7b733a323a226964223b733a323a223137223b733a343a22736c7567223b733a31353a22636f6e74656e745f6d616e61676572223b733a343a22726f6c65223b733a31353a22436f6e74656e74204d616e61676572223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031362d30392d30382032313a32343a3236223b733a373a226d6f6464617465223b733a31393a22323031382d30352d31362030323a31333a3235223b7d693a33393b613a373a7b733a323a226964223b733a323a223339223b733a343a22736c7567223b733a31393a2273757065725f61646d696e6973747261746f72223b733a343a22726f6c65223b733a31393a2253757065722041646d696e6973747261746f72223b733a363a22616374697665223b733a333a22596573223b733a373a2264656c65746564223b733a323a224e6f223b733a31303a2263726561746564617465223b733a31393a22323031382d30372d32312030313a32313a3233223b733a373a226d6f6464617465223b733a31393a22323032302d30332d30322032323a31353a3332223b7d7d757365725f7065726d697373696f6e737c613a36393a7b693a313b613a343a7b733a323a226964223b733a313a2231223b733a31303a227065726d697373696f6e223b733a32303a2241636365737320636f6e74726f6c2070616e656c223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2231223b7d693a323b613a343a7b733a323a226964223b733a313a2232223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2232223b7d693a333b613a343a7b733a323a226964223b733a313a2233223b733a31303a227065726d697373696f6e223b733a393a22416464207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2233223b7d693a343b613a343a7b733a323a226964223b733a313a2234223b733a31303a227065726d697373696f6e223b733a31303a2245646974207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2234223b7d693a33373b613a343a7b733a323a226964223b733a323a223337223b733a31303a227065726d697373696f6e223b733a393a224164642066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223337223b7d693a33383b613a343a7b733a323a226964223b733a323a223338223b733a31303a227065726d697373696f6e223b733a31323a2244656c6574652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223338223b7d693a33393b613a343a7b733a323a226964223b733a323a223339223b733a31303a227065726d697373696f6e223b733a31303a22456469742066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223339223b7d693a34303b613a343a7b733a323a226964223b733a323a223430223b733a31303a227065726d697373696f6e223b733a31323a224d616e6167652066696c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223430223b7d693a3236373b613a343a7b733a323a226964223b733a333a22323637223b733a31303a227065726d697373696f6e223b733a31373a224d616e6167652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323637223b7d693a3236383b613a343a7b733a323a226964223b733a333a22323638223b733a31303a227065726d697373696f6e223b733a31343a224164642061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323638223b7d693a3236393b613a343a7b733a323a226964223b733a333a22323639223b733a31303a227065726d697373696f6e223b733a31353a22456469742061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323639223b7d693a3237303b613a343a7b733a323a226964223b733a333a22323730223b733a31303a227065726d697373696f6e223b733a31373a2244656c6574652061747472696275746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323730223b7d693a3237313b613a343a7b733a323a226964223b733a333a22323731223b733a31303a227065726d697373696f6e223b733a32303a224d616e6167652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323731223b7d693a3237323b613a343a7b733a323a226964223b733a333a22323732223b733a31303a227065726d697373696f6e223b733a31373a224164642070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323732223b7d693a3237333b613a343a7b733a323a226964223b733a333a22323733223b733a31303a227065726d697373696f6e223b733a32303a2244656c6574652070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323733223b7d693a3237343b613a343a7b733a323a226964223b733a333a22323734223b733a31303a227065726d697373696f6e223b733a31383a22456469742070616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323734223b7d693a3237353b613a343a7b733a323a226964223b733a333a22323735223b733a31303a227065726d697373696f6e223b733a32323a224d616e61676520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323735223b7d693a3237363b613a343a7b733a323a226964223b733a333a22323736223b733a31303a227065726d697373696f6e223b733a31393a2241646420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323736223b7d693a3237373b613a343a7b733a323a226964223b733a333a22323737223b733a31303a227065726d697373696f6e223b733a32323a2244656c65746520676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323737223b7d693a3237383b613a343a7b733a323a226964223b733a333a22323738223b733a31303a227065726d697373696f6e223b733a32303a224564697420676c6f62616c206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323738223b7d693a3237393b613a343a7b733a323a226964223b733a333a22323739223b733a31303a227065726d697373696f6e223b733a31333a224d616e61676520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323739223b7d693a3238303b613a343a7b733a323a226964223b733a333a22323830223b733a31303a227065726d697373696f6e223b733a31303a2241646420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323830223b7d693a3238313b613a343a7b733a323a226964223b733a333a22323831223b733a31303a227065726d697373696f6e223b733a31333a2244656c65746520626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323831223b7d693a3238323b613a343a7b733a323a226964223b733a333a22323832223b733a31303a227065726d697373696f6e223b733a31313a224564697420626c6f636b73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323832223b7d693a3238333b613a343a7b733a323a226964223b733a333a22323833223b733a31303a227065726d697373696f6e223b733a31343a224d616e616765206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323833223b7d693a3238343b613a343a7b733a323a226964223b733a333a22323834223b733a31303a227065726d697373696f6e223b733a31313a22416464206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323834223b7d693a3238353b613a343a7b733a323a226964223b733a333a22323835223b733a31303a227065726d697373696f6e223b733a31343a2244656c657465206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323835223b7d693a3238363b613a343a7b733a323a226964223b733a333a22323836223b733a31303a227065726d697373696f6e223b733a31323a2245646974206c61796f757473223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323836223b7d693a3238373b613a343a7b733a323a226964223b733a333a22323837223b733a31303a227065726d697373696f6e223b733a31363a224d616e6167652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323837223b7d693a3238383b613a343a7b733a323a226964223b733a333a22323838223b733a31303a227065726d697373696f6e223b733a31333a224164642074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323838223b7d693a3238393b613a343a7b733a323a226964223b733a333a22323839223b733a31303a227065726d697373696f6e223b733a31363a2244656c6574652074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323839223b7d693a3239303b613a343a7b733a323a226964223b733a333a22323930223b733a31303a227065726d697373696f6e223b733a31343a22456469742074656d706c61746573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323930223b7d693a3239313b613a343a7b733a323a226964223b733a333a22323931223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323931223b7d693a3239323b613a343a7b733a323a226964223b733a333a22323932223b733a31303a227065726d697373696f6e223b733a393a22416464207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323932223b7d693a3239333b613a343a7b733a323a226964223b733a333a22323933223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323933223b7d693a3239343b613a343a7b733a323a226964223b733a333a22323934223b733a31303a227065726d697373696f6e223b733a31303a2245646974207061676573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323934223b7d693a3239353b613a343a7b733a323a226964223b733a333a22323935223b733a31303a227065726d697373696f6e223b733a31343a224d616e61676520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323935223b7d693a3239363b613a343a7b733a323a226964223b733a333a22323936223b733a31303a227065726d697373696f6e223b733a31313a2241646420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323936223b7d693a3239373b613a343a7b733a323a226964223b733a333a22323937223b733a31303a227065726d697373696f6e223b733a31343a2244656c65746520636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323937223b7d693a3239383b613a343a7b733a323a226964223b733a333a22323938223b733a31303a227065726d697373696f6e223b733a31323a224564697420636f6e74656e74223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323938223b7d693a3239393b613a343a7b733a323a226964223b733a333a22323939223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323939223b7d693a3330303b613a343a7b733a323a226964223b733a333a22333030223b733a31303a227065726d697373696f6e223b733a31323a22416464206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333030223b7d693a3330313b613a343a7b733a323a226964223b733a333a22333031223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333031223b7d693a3330323b613a343a7b733a323a226964223b733a333a22333032223b733a31303a227065726d697373696f6e223b733a31333a2245646974206865616474616773223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333032223b7d693a3332383b613a343a7b733a323a226964223b733a333a22333238223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333238223b7d693a3332393b613a343a7b733a323a226964223b733a333a22333239223b733a31303a227065726d697373696f6e223b733a31353a22416464206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333239223b7d693a3333303b613a343a7b733a323a226964223b733a333a22333330223b733a31303a227065726d697373696f6e223b733a31363a2245646974206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333330223b7d693a3333313b613a343a7b733a323a226964223b733a333a22333331223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465206e6577736c657474657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333331223b7d693a353b613a343a7b733a323a226964223b733a313a2235223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465207573657273223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2235223b7d693a363b613a343a7b733a323a226964223b733a313a2236223b733a31303a227065726d697373696f6e223b733a31383a2244656c657465207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2236223b7d693a373b613a343a7b733a323a226964223b733a313a2237223b733a31303a227065726d697373696f6e223b733a31323a224d616e61676520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2237223b7d693a383b613a343a7b733a323a226964223b733a313a2238223b733a31303a227065726d697373696f6e223b733a393a2241646420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2238223b7d693a393b613a343a7b733a323a226964223b733a313a2239223b733a31303a227065726d697373696f6e223b733a31303a224564697420726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a313a2239223b7d693a31303b613a343a7b733a323a226964223b733a323a223130223b733a31303a227065726d697373696f6e223b733a31323a2244656c65746520726f6c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223130223b7d693a31313b613a343a7b733a323a226964223b733a323a223131223b733a31303a227065726d697373696f6e223b733a31383a224d616e616765207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223131223b7d693a31323b613a343a7b733a323a226964223b733a323a223132223b733a31303a227065726d697373696f6e223b733a31353a22416464207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223132223b7d693a31333b613a343a7b733a323a226964223b733a323a223133223b733a31303a227065726d697373696f6e223b733a31363a2245646974207065726d697373696f6e73223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223133223b7d693a32353b613a343a7b733a323a226964223b733a323a223235223b733a31303a227065726d697373696f6e223b733a31363a224d616e616765207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223235223b7d693a32363b613a343a7b733a323a226964223b733a323a223236223b733a31303a227065726d697373696f6e223b733a31333a22416464207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223236223b7d693a32373b613a343a7b733a323a226964223b733a323a223237223b733a31303a227065726d697373696f6e223b733a31343a2245646974207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223237223b7d693a32383b613a343a7b733a323a226964223b733a323a223238223b733a31303a227065726d697373696f6e223b733a31363a2244656c657465207661726961626c6573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a323a223238223b7d693a3236333b613a343a7b733a323a226964223b733a333a22323633223b733a31303a227065726d697373696f6e223b733a31353a224d616e616765206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323633223b7d693a3236343b613a343a7b733a323a226964223b733a333a22323634223b733a31303a227065726d697373696f6e223b733a31323a22416464206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323634223b7d693a3236353b613a343a7b733a323a226964223b733a333a22323635223b733a31303a227065726d697373696f6e223b733a31353a2244656c657465206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323635223b7d693a3236363b613a343a7b733a323a226964223b733a333a22323636223b733a31303a227065726d697373696f6e223b733a31333a2245646974206d65746164617461223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22323636223b7d693a3333343b613a343a7b733a323a226964223b733a333a22333334223b733a31303a227065726d697373696f6e223b733a31323a224d616e616765206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333334223b7d693a3333353b613a343a7b733a323a226964223b733a333a22333335223b733a31303a227065726d697373696f6e223b733a393a22416464206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333335223b7d693a3333363b613a343a7b733a323a226964223b733a333a22333336223b733a31303a227065726d697373696f6e223b733a31303a2245646974206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333336223b7d693a3333373b613a343a7b733a323a226964223b733a333a22333337223b733a31303a227065726d697373696f6e223b733a31323a2244656c657465206d656e7573223b733a373a22726f6c655f6964223b733a323a223339223b733a31333a227065726d697373696f6e5f6964223b733a333a22333337223b7d7d737563636573737c733a33323a22596f752068617665207375636365737366756c6c79206c6f6767656420696e2e223b5f5f63695f766172737c613a323a7b733a373a2273756363657373223b733a333a226f6c64223b733a353a226572726f72223b733a333a226f6c64223b7d73657474696e67735f73656f7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a333a2273656f223b733a31313a226465736372697074696f6e223b733a32323a224b7972616e646961434d532053454f204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7461786f6e6f6d797c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205461786f6e6f6d79204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3038223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d657461646174617c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a226d65746164617461223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204d657461647461204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31312d3232223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d6572726f727c733a35323a22596f7520646f206e6f742068617665207065726d697373696f6e20746f206d616e61676520676c6f62616c206865616474616773223b),
('qgadd5n5io64hqqii6idqp1593s49n3k', '127.0.0.1', 1631217287, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633313231373238353b73657474696e67735f6e75636c6575737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a373a226e75636c657573223b733a31313a226465736372697074696f6e223b733a32363a224b7972616e646961434d53204e75636c657573204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30332d3232223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7661726961626c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a227661726961626c65223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d53205661726961626c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f636f72657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a22636f7265223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320436f7265204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31302d3137223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d733a31343a227365617263685f656e67696e6573223b613a31383a7b693a303b733a31313a227777772e676f6f676c652e223b693a313b733a31333a227365617263682e7961686f6f2e223b693a323b733a353a2262696e672e223b693a333b733a343a2261736b2e223b693a343b733a31303a22616c6c7468657765622e223b693a353b733a31303a22616c746176697374612e223b693a363b733a31303a227365617263682e616f6c223b693a373b733a363a2262616964752e223b693a383b733a31343a226475636b6475636b676f2e636f6d223b693a393b733a31313a227777772e776f772e636f6d223b693a31303b733a31383a227777772e776562637261776c65722e636f6d223b693a31313b733a31363a227777772e6d797765627365617263682e223b693a31323b733a31373a227777772e696e666f73706163652e636f6d223b693a31333b733a31323a227777772e696e666f2e636f6d223b693a31343b733a31303a22626c656b6b6f2e636f6d223b693a31353b733a31323a22636f6e74656e6b6f2e636f6d223b693a31363b733a31313a22646f6770696c652e636f6d223b693a31373b733a393a22616c6865612e636f6d223b7d7d73657474696e67735f7065726d697373696f6e7c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a31303a227065726d697373696f6e223b733a31313a226465736372697074696f6e223b733a32393a224b7972616e646961434d53205065726d697373696f6e204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f726f6c657c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d5320526f6c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3039223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a313a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d6f64756c657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226d6f64756c65223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204d6f64756c65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3130223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f757365727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a2275736572223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532055736572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d30382d3133223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f626c6f636b7c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a22626c6f636b223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d5320426c6f636b204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f73657474696e67737c613a383a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a383a2273657474696e6773223b733a31313a226465736372697074696f6e223b733a32373a224b7972616e646961434d532053657474696e6773204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3131223b733a383a227265717569726564223b733a333a22596573223b733a31323a22646570656e64656e63696573223b613a323a7b733a343a22636f7265223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d733a343a2275736572223b613a313a7b733a373a2276657273696f6e223b733a353a223d20362e30223b7d7d733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6d656e757c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a343a226d656e75223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d53204d656e75204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7769646765747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a22776964676574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d5320576964676574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3135223b733a383a227265717569726564223b733a323a224e6f223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f66696c7465727c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a2266696c746572223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d532046696c746572204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3134223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f7468656d657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227468656d65223b733a31313a226465736372697074696f6e223b733a32343a224b7972616e646961434d53205468656d65204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f6c61796f75747c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a363a226c61796f7574223b733a31313a226465736372697074696f6e223b733a32353a224b7972616e646961434d53204c61796f7574204d6f64756c65223b733a343a2264617465223b733a31303a22323031392d31322d3233223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d73657474696e67735f706167657c613a373a7b733a373a2276657273696f6e223b733a333a22362e30223b733a363a22616374697665223b733a333a22596573223b733a343a226e616d65223b733a353a227061766765223b733a31313a226465736372697074696f6e223b733a32333a224b7972616e646961434d532050616765204d6f64756c65223b733a343a2264617465223b733a31303a22323032302d30312d3031223b733a383a227265717569726564223b733a333a22596573223b733a363a22617574686f72223b613a333a7b733a343a226e616d65223b733a31333a224b6f627573204d796275726768223b733a353a22656d61696c223b733a32363a226b6f6275732e6d79627572676840696d7065726f2e636f2e7a61223b733a373a2277656273697465223b733a32343a2268747470733a2f2f7777772e696d7065726f2e636f2e7a61223b7d7d);

-- --------------------------------------------------------

--
-- Table structure for table `kcms_settings`
--

CREATE TABLE `kcms_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `value` varchar(255) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_settings`
--

INSERT INTO `kcms_settings` (`id`, `name`, `value`, `updated_by`, `createdate`, `moddate`) VALUES
(1, 'user_send_welcome_mails', 'Yes', 1, '2019-12-13 01:19:25', '2021-02-25 09:27:05'),
(2, 'user_administrator_approve_accounts', 'No', 1, '2019-12-13 01:19:25', '2021-02-25 09:27:05'),
(3, 'settings_name', 'Kyrandia CMS 7.0', 1, '2019-12-13 01:19:25', '2021-02-25 09:27:05'),
(4, 'settings_description', 'This is the default description. For the love of Jupiter, change this, please!', 1, '2019-12-13 01:19:25', '2021-02-25 09:27:05'),
(5, 'profile_allow_upload', 'Yes', 1, '2020-03-02 22:09:46', '2020-03-17 23:53:35'),
(6, 'hielo_test_field', 'No', 1, '2020-03-17 23:53:35', '2020-03-17 23:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_slider`
--

CREATE TABLE `kcms_slider` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `section_class` varchar(64) DEFAULT 'banner full',
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_slider`
--

INSERT INTO `kcms_slider` (`id`, `slug`, `name`, `description`, `image_path`, `section_class`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'hielo_main_slider', 'Hielo Main Slider', 'hielo_main', 'application/views/themes/hielo/images/', 'banner full', 'Yes', 'No', '2020-03-19 23:57:50', '2020-03-21 16:39:51'),
(2, 'dating_main_slider', 'Dating Main Slider', 'dating_main', 'application/views/themes/dating/images/', 'banner full', 'Yes', 'No', '2020-03-19 23:57:50', '2020-03-21 16:39:51'),
(3, 'flashcard_main_slider', 'Flashcard Main Slider', 'flashcard_main', 'application/views/themes/flashcard/images/', 'banner full', 'Yes', 'No', '2020-03-19 23:57:50', '2020-03-21 16:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_slider_item`
--

CREATE TABLE `kcms_slider_item` (
  `id` int(11) NOT NULL,
  `slider_id` int(11) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `image_div_class` varbinary(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `title` varchar(32) NOT NULL,
  `image_text` varchar(32) NOT NULL,
  `image_heading` varchar(16) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_slider_item`
--

INSERT INTO `kcms_slider_item` (`id`, `slider_id`, `slug`, `name`, `image_div_class`, `image`, `title`, `image_text`, `image_heading`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 1, 'slide_01', 'Slide 01', 0x696e6e6572, 'slide01.jpg', 'Slide 01', 'This is the first slide', 'Slide 01', 'Yes', 'No', '2020-03-20 00:03:41', '2020-03-20 00:05:49'),
(2, 1, 'slide_02', 'Slide 02', 0x696e6e6572, 'slide02.jpg', 'Slide 02', 'This is the second slide', 'Slide 02', 'Yes', 'No', '2020-03-20 00:06:35', '2020-03-20 00:07:29'),
(3, 1, 'slide_03', 'Slide 03', 0x696e6e6572, 'slide03.jpg', 'Slide 03', 'This is the third slide', 'Slide 03', 'Yes', 'No', '2020-03-20 00:07:19', '2020-03-20 00:07:19'),
(4, 1, 'slide_04', 'Slide  04', 0x696e6e6572, 'slide04.jpg', 'Slide 04', 'This is the fourth slide', 'Slide 04', 'Yes', 'No', '2020-03-20 00:08:05', '2020-03-20 00:08:05'),
(5, 1, 'slide_05', 'Slide 05', 0x696e6e6572, 'slide05.jpg', 'Slide 05', 'This is the fifth slide', 'Slide 05', 'Yes', 'No', '2020-03-20 00:08:34', '2020-03-20 00:08:34'),
(6, 2, 'slide_01', 'Slide 01', 0x696e6e6572, 'dating1.jpg', 'Banner 1', 'Banner 1', 'Banner 1', 'Yes', 'No', '2020-03-20 00:03:41', '2020-03-20 00:05:49'),
(7, 2, 'slide_02', 'Slide 02', 0x696e6e6572, 'dating2.jpg', 'Banner 2', 'Banner 2', 'Banner 2', 'Yes', 'No', '2020-03-20 00:06:35', '2020-03-20 00:07:29'),
(8, 2, 'slide_03', 'Slide 03', 0x696e6e6572, 'flashindexcard3.jpg', 'Banner 3', 'Banner 3', 'Banner 3', 'Yes', 'No', '2020-03-20 00:07:19', '2020-03-20 00:07:19'),
(9, 2, 'slide_04', 'Slide 04', 0x696e6e6572, 'flashindexcard4.jpg', 'Banner 4', 'Banner 4', 'Banner 4', 'Yes', 'No', '2020-03-20 00:07:19', '2020-03-20 00:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_system_log`
--

CREATE TABLE `kcms_system_log` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `message` text NOT NULL,
  `impact` enum('None','Low','Medium-Low','Medium','Medium-High','High','Critical','Catastrophic') NOT NULL DEFAULT 'Low',
  `class` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `line` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_system_log`
--

INSERT INTO `kcms_system_log` (`id`, `status`, `code`, `type`, `message`, `impact`, `class`, `function`, `line`, `data`, `user_id`, `username`, `ip_address`, `createdate`) VALUES
(1, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 22:44:50'),
(2, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:24:25'),
(3, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:24:29'),
(4, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:24:31'),
(5, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:35:28'),
(6, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:35:28'),
(7, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:35:28'),
(8, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:35:28'),
(9, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:35:28'),
(10, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:49'),
(11, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:49'),
(12, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:49'),
(13, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:49'),
(14, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:49'),
(15, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:36:50'),
(16, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:37:42'),
(17, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:37:42'),
(18, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:37:43'),
(19, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:37:43'),
(20, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:37:43'),
(21, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:07'),
(22, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:07'),
(23, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:07'),
(24, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:07'),
(25, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:07'),
(26, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:32'),
(27, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:32'),
(28, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:32'),
(29, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:32'),
(30, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:33'),
(31, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:34'),
(32, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:34'),
(33, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:34'),
(34, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:34'),
(35, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:39:34'),
(36, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:06'),
(37, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:06'),
(38, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:06'),
(39, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:06'),
(40, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:06'),
(41, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:08'),
(42, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:09'),
(43, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:09'),
(44, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:09'),
(45, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:09'),
(46, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:10'),
(47, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:11'),
(48, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard2.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:11'),
(49, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:11'),
(50, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:11'),
(51, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard1.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:41:11'),
(52, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:44:32'),
(53, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:49:06'),
(54, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:49:07'),
(55, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:51:30'),
(56, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:51:31'),
(57, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:51:33'),
(58, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:52:14'),
(59, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:52:16'),
(60, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:52:17'),
(61, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:53:45'),
(62, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:54:55'),
(63, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:54:57'),
(64, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-17 23:59:29'),
(65, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-18 00:02:30'),
(66, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-18 00:03:09'),
(67, 0, 404, 'Not found', 'Not found: application/views/themes/flashcard/images/bg.jpg - redirected from: http://k7f.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-05-18 00:03:10'),
(68, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:41:11'),
(69, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:41:11'),
(70, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:41:12'),
(71, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 16:42:23'),
(72, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 16:42:23'),
(73, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:06:38'),
(74, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:06:39'),
(75, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:06:39'),
(76, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:07:53'),
(77, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:07:54'),
(78, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:07:54'),
(79, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:11:07'),
(80, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:11:07'),
(81, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:11:08'),
(82, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-05 16:00:48'),
(83, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-05 16:00:48'),
(84, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:11'),
(85, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:11'),
(86, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:50'),
(87, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:50'),
(88, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 17:44:30'),
(89, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 17:44:30'),
(90, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 20:42:13'),
(91, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 20:42:13'),
(92, 0, 404, 'Not found', 'Page /control=panel not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 18:43:34'),
(93, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 18:46:45'),
(94, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 18:46:45'),
(95, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:01:38'),
(96, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/12.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:01:43'),
(97, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:01:45'),
(98, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/12.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:01:55'),
(99, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:04:49'),
(100, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:10:44'),
(101, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:12:22'),
(102, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:12:49'),
(103, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:13:44'),
(104, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:14:32'),
(105, 0, 404, 'Not found', 'Not found: application/modules/theme/assets/images/themes/15.png - redirected from: http://k7b.loc/page/edit_page/1', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 19:15:08'),
(106, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:21:12'),
(107, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:21:13'),
(108, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:21:13'),
(109, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard4.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:25:00'),
(110, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/flashindexcard3.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:25:00'),
(111, 0, 404, 'Not found', 'Not found: application/views/themes/dating/images/header.jpg - redirected from: http://k7b.loc/', 'Medium', 'Nucleus', 'log_404', 245, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-19 12:25:01'),
(112, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 17:17:43'),
(113, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 17:17:43'),
(114, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 18:27:44'),
(115, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 18:27:44'),
(116, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:44:35'),
(117, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:48:29'),
(118, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:48:35'),
(119, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:48:44'),
(120, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:49:46'),
(121, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:49:54'),
(122, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:50:54'),
(123, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:51:20'),
(124, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:52:18'),
(125, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:52:36'),
(126, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:58:03'),
(127, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:58:09'),
(128, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 19:58:17'),
(129, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:04:27'),
(130, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:04:35'),
(131, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:05:11'),
(132, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:05:56'),
(133, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:09:13'),
(134, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:09:48'),
(135, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:10:15'),
(136, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 20:12:24'),
(137, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:19:37'),
(138, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:19:37'),
(139, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:23:55'),
(140, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:23:55'),
(141, 0, 404, 'Not found', 'Page /csvimport/list_csv_imports_data not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:09:24'),
(142, 0, 404, 'Not found', 'Page /csvimport/list_csv_imports_data not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:09:50'),
(143, 0, 200, 'Notice', 'User blix logged in successfully; session data set.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:12:19'),
(144, 0, 200, 'Notice', 'User login attempts reset.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:12:19'),
(145, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 17:02:07'),
(146, 0, 404, 'Not found', 'Page /application/views/themes/admin/vendors/moment/src/moment.min.js.map not found: direct visit.', 'Medium', 'Nucleus', 'log_404', 245, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 17:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_theme`
--

CREATE TABLE `kcms_theme` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `file` varchar(128) NOT NULL,
  `areas` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_theme`
--

INSERT INTO `kcms_theme` (`id`, `slug`, `name`, `file`, `areas`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'admin', 'Admin', 'themes/admin/theme_admin.php', 'main,left', 'Yes', 'No', '2016-09-11 21:00:10', '2016-10-05 16:10:39'),
(12, 'kyrandia', 'Kyrandia', 'themes/kyrandia/theme_kyrandia.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(15, 'maxapi', 'MaxAPI', 'themes/maxapi/theme_maxapi.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(16, 'hielo', 'Hielo', 'themes/hielo/theme_hielo.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(17, 'login', 'Login', 'themes/login/theme_login.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(18, 'dating', 'Dating', 'themes/dating/theme_dating.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(19, 'flashcards', 'Flashcards', 'themes/flashcards/theme_flashcards.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52'),
(20, 'askgogo', 'Ask Gogo', 'themes/askgogo/theme_askgogo.php', 'main', 'Yes', 'No', '2018-02-17 14:17:27', '2020-10-11 02:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_user`
--

CREATE TABLE `kcms_user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `temporary_password` varchar(128) NOT NULL,
  `temporary_password_expires` datetime NOT NULL,
  `salt` varchar(64) NOT NULL,
  `user_type` varchar(32) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_login_date` datetime NOT NULL,
  `locked` enum('Yes','No') NOT NULL DEFAULT 'No',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `welcome_mail` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_user`
--

INSERT INTO `kcms_user` (`id`, `username`, `password`, `email`, `temporary_password`, `temporary_password_expires`, `salt`, `user_type`, `ip_address`, `active`, `attempts`, `last_login_date`, `locked`, `deleted`, `welcome_mail`, `createdate`, `moddate`) VALUES
(1, 'blix', '$2a$08$VpfYEnmdn2mnNqSnxagTUu4tR9W0wAUw4vCBuHXPed1JFJeu8GTKC', 'kobus.myburgh@impero.co.za', '', '0000-00-00 00:00:00', '$2a$08$VpfYEnmdn2mnNqSnxagTUu', 'Super Administrator', '127.0.0.1', 'Yes', 0, '2021-09-25 14:12:19', 'No', 'No', 'Yes', '2014-01-07 09:00:00', '2020-11-01 00:52:59'),
(2, 'kobus', '$2a$08$ktwbasjIsuEs4l1PxTsnYeP.Ew5ANSU0KgvlkVE.RF3QTxO1eB2rq', 'kobus@impero.co.za', '$2a$08$ktwbasjIsuEs4l1PxTsnYeOtwfTggJ2gILFoPPqmkCbn0b97UOf3i', '2019-11-16 04:57:46', '$2a$08$ktwbasjIsuEs4l1PxTsnYe', 'Super Administrator', '127.0.0.1', 'Yes', 0, '2019-11-16 00:46:08', 'Yes', 'No', 'Yes', '2019-11-10 22:59:34', '2020-10-11 02:54:35'),
(3, 'blix2', '$2a$08$NxCnWUzhKr65cfGUEhmdxu/KGaiDtuiW.DhO8ylViz/D.SWwCC.W6', 'kobus3@impero.co.za', '', '0000-00-00 00:00:00', '$2a$08$NxCnWUzhKr65cfGUEhmdxu', '', '', 'Yes', 0, '0000-00-00 00:00:00', 'No', 'No', 'No', '2020-03-02 22:11:51', '2020-03-02 22:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_user_profile`
--

CREATE TABLE `kcms_user_profile` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `initials` varchar(16) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(11) NOT NULL,
  `hobbies` text NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_user_role`
--

CREATE TABLE `kcms_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `access_date` datetime NOT NULL,
  `access_given_by` int(11) NOT NULL,
  `access_revoked_by` int(11) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `active_until` datetime NOT NULL,
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_user_role`
--

INSERT INTO `kcms_user_role` (`user_id`, `role_id`, `access_date`, `access_given_by`, `access_revoked_by`, `active`, `deleted`, `active_until`, `createdate`, `moddate`) VALUES
(1, 1, '2020-11-01 00:52:59', 1, 0, 'Yes', 'No', '2030-10-30 00:52:59', '2020-11-01 00:52:59', '2020-11-01 00:52:59'),
(1, 17, '2020-11-01 00:52:59', 1, 0, 'Yes', 'No', '2030-10-30 00:52:59', '2020-11-01 00:52:59', '2020-11-01 00:52:59'),
(1, 39, '2020-11-01 00:52:59', 1, 0, 'Yes', 'No', '2030-10-30 00:52:59', '2020-11-01 00:52:59', '2020-11-01 00:52:59'),
(2, 1, '2020-10-11 02:54:35', 1, 0, 'Yes', 'No', '2030-10-09 02:54:35', '2020-10-11 02:54:35', '2020-10-11 02:54:35'),
(2, 39, '2020-10-11 02:54:35', 1, 0, 'Yes', 'No', '2030-10-09 02:54:35', '2020-10-11 02:54:35', '2020-10-11 02:54:35'),
(3, 1, '2020-03-02 22:14:29', 1, 0, 'Yes', 'No', '2030-02-28 22:14:29', '2020-03-02 22:14:29', '2020-03-02 22:14:29'),
(3, 17, '2020-03-02 22:14:29', 1, 0, 'Yes', 'No', '2030-02-28 22:14:29', '2020-03-02 22:14:29', '2020-03-02 22:14:29'),
(3, 39, '2020-03-02 22:14:29', 1, 0, 'Yes', 'No', '2030-02-28 22:14:29', '2020-03-02 22:14:29', '2020-03-02 22:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_user_session_log`
--

CREATE TABLE `kcms_user_session_log` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `message` text NOT NULL,
  `impact` enum('None','Low','Medium-Low','Medium','Medium-High','High','Critical','Catastrophic') NOT NULL DEFAULT 'Low',
  `class` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `line` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_user_session_log`
--

INSERT INTO `kcms_user_session_log` (`id`, `status`, `code`, `type`, `message`, `impact`, `class`, `function`, `line`, `data`, `user_id`, `username`, `ip_address`, `createdate`) VALUES
(1, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 224, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:41:53'),
(2, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 224, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:42:02'),
(3, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 224, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-02 16:42:08'),
(4, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 16:42:23'),
(5, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:02:55'),
(6, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:11:45'),
(7, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-02 18:11:50'),
(8, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 227, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-05 15:59:35'),
(9, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 227, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-05 16:00:07'),
(10, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 224, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-05 16:00:35'),
(11, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-05 16:00:48'),
(12, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-05 16:01:00'),
(13, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:11'),
(14, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:19'),
(15, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 11:15:50'),
(16, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-09 19:43:37'),
(17, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 17:44:30'),
(18, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 20:42:06'),
(19, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 20:42:13'),
(20, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 18:46:27'),
(21, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-13 18:46:45'),
(22, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 17:17:43'),
(23, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 18:27:36'),
(24, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-19 18:27:44'),
(25, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:19:37'),
(26, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:23:44'),
(27, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 13:23:55'),
(28, 0, 200, 'Notice', 'You have been logged out successfully.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:10:03'),
(29, 0, 403, 'Forbidden', 'You have entered an invalid username or password.', 'High', 'Nucleus', 'log_403', 224, '[]', -1, 'Logged out user', '127.0.0.1', '2021-09-25 14:12:13'),
(30, 0, 200, 'Notice', 'You have successfully logged in.', 'Low', 'Nucleus', 'log_200', 161, '[]', 1, 'blix', '127.0.0.1', '2021-09-25 14:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_variable`
--

CREATE TABLE `kcms_variable` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` varchar(255) NOT NULL,
  `active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `createdate` datetime NOT NULL,
  `moddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kcms_variable`
--

INSERT INTO `kcms_variable` (`id`, `name`, `value`, `active`, `deleted`, `createdate`, `moddate`) VALUES
(1, 'system_version', '6.0.0', 'Yes', 'No', '2016-07-06 17:13:19', '2019-12-08 23:13:00'),
(2, 'system_name', 'KyrandiaCMS', 'Yes', 'No', '2016-07-06 17:13:19', '2019-12-08 23:11:18'),
(4, 'system_url', 'https://www.kyrandia.co.za', 'Yes', 'No', '2016-07-06 17:13:19', '2019-12-08 23:14:01'),
(5, 'system_login', 'https://www.kyrandia.co.za/login', 'Yes', 'No', '2016-07-06 17:13:19', '2019-12-08 23:13:47'),
(14, 'delete_type', 'hard', 'Yes', 'No', '2017-08-30 16:53:36', '2019-12-08 23:13:10'),
(15, 'activate_url', 'https://www.kyrandia.co.za/activate', 'Yes', 'No', '2016-07-06 17:13:19', '2019-12-08 23:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_alert_log`
--

CREATE TABLE `kcms_watchdog_alert_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_critical_log`
--

CREATE TABLE `kcms_watchdog_critical_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_debug_log`
--

CREATE TABLE `kcms_watchdog_debug_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_emergency_log`
--

CREATE TABLE `kcms_watchdog_emergency_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_error_log`
--

CREATE TABLE `kcms_watchdog_error_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_general_log`
--

CREATE TABLE `kcms_watchdog_general_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_info_log`
--

CREATE TABLE `kcms_watchdog_info_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_notice_log`
--

CREATE TABLE `kcms_watchdog_notice_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kcms_watchdog_warning_log`
--

CREATE TABLE `kcms_watchdog_warning_log` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `http_code` int(11) NOT NULL,
  `level` varchar(16) NOT NULL,
  `context` varchar(64) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `watchdog_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `struct` varchar(64) DEFAULT NULL,
  `source` varchar(32) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` varchar(8) DEFAULT NULL,
  `function` varchar(64) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `args` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `diff_data` text DEFAULT NULL,
  `post_data` text DEFAULT NULL,
  `get_data` text DEFAULT NULL,
  `cookie_data` text DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `server_data` text DEFAULT NULL,
  `backtrace_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `maxapi_contact`
--

CREATE TABLE `maxapi_contact` (
  `contact_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `contact_name` varchar(32) NOT NULL,
  `contact_surname` varchar(32) NOT NULL,
  `contact_email` varchar(64) NOT NULL,
  `contact_phone` varchar(16) NOT NULL,
  `contact_address` varchar(255) NOT NULL,
  `contact_active` enum('Yes','No') NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maxapi_contact`
--

INSERT INTO `maxapi_contact` (`contact_id`, `merchant_id`, `store_id`, `contact_name`, `contact_surname`, `contact_email`, `contact_phone`, `contact_address`, `contact_active`, `create_date`, `modify_date`) VALUES
(1, 1, NULL, 'Tanya', 'Myburgh', 'tanya@coffeecrew.co.za', '27828517584', '115 Bellairs Drive', 'Yes', '2020-11-09 01:38:15', '2020-11-09 01:38:15'),
(2, 1, 1, 'Kobus', 'Myburgh', 'kobus@coffeecrew.co.za', '27820438488', '115 Bellairs Drive', 'Yes', '2020-11-09 01:38:15', '2020-11-09 01:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `maxapi_country`
--

CREATE TABLE `maxapi_country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(64) NOT NULL,
  `country_active` enum('Yes','No') NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maxapi_country`
--

INSERT INTO `maxapi_country` (`country_id`, `country_name`, `country_active`, `create_date`, `modify_date`) VALUES
(1, 'South Africa', 'Yes', '2020-11-09 01:21:41', '2020-11-09 01:21:41'),
(2, 'United States', 'Yes', '2020-11-09 01:21:41', '2020-11-09 01:21:41'),
(3, 'Singapore', 'Yes', '2020-11-21 00:30:11', '2020-11-21 00:30:11'),
(4, 'Malaysia', 'Yes', '2020-11-21 00:30:43', '2020-11-21 00:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `maxapi_currency`
--

CREATE TABLE `maxapi_currency` (
  `currency_id` int(11) NOT NULL,
  `currency_name` varchar(64) NOT NULL,
  `currency_symbol` varchar(16) NOT NULL,
  `country_id` int(11) NOT NULL,
  `currency_active` enum('Yes','No') NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maxapi_currency`
--

INSERT INTO `maxapi_currency` (`currency_id`, `currency_name`, `currency_symbol`, `country_id`, `currency_active`, `create_date`, `modify_date`) VALUES
(1, 'South African Rand', 'R', 1, 'Yes', '2020-11-09 01:22:04', '2020-11-09 01:22:04'),
(2, 'United States Dollar', '$', 2, 'Yes', '2020-11-09 01:22:04', '2020-11-09 01:22:04'),
(6, 'Monopoly Bucks', 'MBX', 1, 'Yes', '2020-11-23 13:17:04', '2020-11-23 13:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `maxapi_payu`
--

CREATE TABLE `maxapi_payu` (
  `id` int(11) NOT NULL,
  `merchantReference` varchar(64) NOT NULL,
  `payUReference` varchar(64) NOT NULL,
  `initiateSuccess` int(2) NOT NULL,
  `initiateDate` datetime NOT NULL,
  `cancelSuccess` int(2) NOT NULL,
  `cancelResultCode` varchar(4) NOT NULL,
  `cancelResultMessage` varchar(64) NOT NULL,
  `cancelDisplayMessage` varchar(64) NOT NULL,
  `cancelDate` datetime NOT NULL,
  `completeSuccess` int(2) NOT NULL,
  `completeResultCode` varchar(4) NOT NULL,
  `completeResultMessage` varchar(64) NOT NULL,
  `completeDate` datetime NOT NULL,
  `transactionType` enum('RESERVE','PAYMENT','RESERVE_CANCEL','FINALIZE') DEFAULT NULL,
  `status` enum('New','Reserved','Cancelled','Completed','Failed') NOT NULL,
  `clientId` varchar(16) NOT NULL,
  `botId` varchar(16) NOT NULL,
  `node` varchar(32) NOT NULL,
  `token` varchar(40) NOT NULL,
  `wicodes` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `createDate` datetime NOT NULL,
  `modifyDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maxapi_payu`
--

INSERT INTO `maxapi_payu` (`id`, `merchantReference`, `payUReference`, `initiateSuccess`, `initiateDate`, `cancelSuccess`, `cancelResultCode`, `cancelResultMessage`, `cancelDisplayMessage`, `cancelDate`, `completeSuccess`, `completeResultCode`, `completeResultMessage`, `completeDate`, `transactionType`, `status`, `clientId`, `botId`, `node`, `token`, `wicodes`, `count`, `createDate`, `modifyDate`) VALUES
(1, 'RFAD_1617295267', '19181550852202', 1, '2021-04-01 18:41:07', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 18:41:07', 'PAYMENT', '', '68662153', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000039|999000040|999000041|999000042|999000043|999000044|999000045', 7, '2021-04-01 18:41:07', '2021-04-27 10:42:17'),
(2, 'RFAD_1617295478', '19181562287899', 1, '2021-04-01 18:44:39', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 18:44:39', 'PAYMENT', '', '68662153', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000046|999000047|999000048|999000049', 4, '2021-04-01 18:44:39', '2021-04-27 10:42:17'),
(3, 'RFAD_1617295897', '19181594041118', 1, '2021-04-01 18:51:37', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 18:51:37', 'PAYMENT', '', '68662153', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000050|999000051|999000052|999000053|999000054|999000055', 6, '2021-04-01 18:51:37', '2021-04-27 10:42:17'),
(4, 'RFAD_1617296104', '19181606442363', 1, '2021-04-01 18:55:04', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 18:55:04', 'PAYMENT', '', '68662153', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000056|999000057', 2, '2021-04-01 18:55:04', '2021-04-27 10:42:17'),
(5, 'RFAD_1617296538', '19181637266273', 1, '2021-04-01 19:02:36', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:02:36', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000058|999000059|999000060|999000061|999000062', 5, '2021-04-01 19:02:36', '2021-04-27 10:42:17'),
(6, 'RFAD_1617296758', '19181672468572', 1, '2021-04-01 19:05:58', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:05:58', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000063|999000064|999000065|999000066', 4, '2021-04-01 19:05:58', '2021-04-27 10:42:17'),
(7, 'RFAD_1617296900', '19181681635706', 1, '2021-04-01 19:08:20', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:08:20', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000067|999000068|999000069', 3, '2021-04-01 19:08:20', '2021-04-27 10:42:17'),
(8, 'RFAD_1617297300', '19181708273111', 1, '2021-04-01 19:15:01', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:15:01', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000070|999000071|999000072|999000073', 4, '2021-04-01 19:15:01', '2021-04-27 10:42:17'),
(9, 'RFAD_1617297443', '19181722475391', 1, '2021-04-01 19:17:23', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:17:23', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000074|999000075|999000076|999000077', 4, '2021-04-01 19:17:23', '2021-04-27 10:42:17'),
(10, 'RFAD_1617297657', '19181738651161', 1, '2021-04-01 19:20:57', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-01 19:20:57', 'PAYMENT', '', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000078|999000079|999000080|999000081|999000082|999000083', 6, '2021-04-01 19:20:57', '2021-04-27 10:42:17'),
(11, 'RFAD_1617346992', '19185068641318', 1, '2021-04-02 09:03:12', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-02 09:03:12', 'PAYMENT', '', '94951732', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000084|999000085|999000086|999000087|999000088', 5, '2021-04-02 09:03:12', '2021-04-27 10:42:17'),
(12, 'RFAD_1617348018', '19185135497377', 1, '2021-04-02 09:20:18', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-02 09:20:18', 'PAYMENT', '', '94951732', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000089|999000090', 2, '2021-04-02 09:20:18', '2021-04-27 10:42:17'),
(13, 'RFAD_1618990060', '19318929851485', 1, '2021-04-21 09:27:40', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-21 09:27:40', 'PAYMENT', '', '94951732', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-21 09:27:40', '2021-04-27 10:42:17'),
(14, 'RFAD_1619064204', '19325996434961', 1, '2021-04-22 06:03:25', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-22 06:03:25', 'PAYMENT', '', '94832697', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000091', 1, '2021-04-22 06:03:25', '2021-04-27 10:42:17'),
(15, 'RFAD_1619070515', '19326551079259', 1, '2021-04-22 07:48:35', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-22 07:48:35', 'PAYMENT', '', '94951732', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000092', 1, '2021-04-22 07:48:35', '2021-04-27 10:42:17'),
(16, 'RFAD_1619079392', '19327623257355', 1, '2021-04-22 10:16:32', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-22 10:16:32', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000093', 1, '2021-04-22 10:16:32', '2021-04-27 10:42:17'),
(17, 'RFAD_1619081603', '19327903856006', 1, '2021-04-22 10:53:23', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-22 10:53:23', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000094', 1, '2021-04-22 10:53:23', '2021-04-27 10:42:17'),
(18, 'RFAD_1619081985', '19327965834805', 1, '2021-04-22 10:59:46', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-22 10:59:46', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000095|999000096', 2, '2021-04-22 10:59:46', '2021-04-27 10:42:17'),
(19, 'RFAD_1619132905', '19333229209745', 1, '2021-04-23 01:08:26', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 01:08:26', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-23 01:08:26', '2021-04-27 10:42:17'),
(20, 'RFAD_1619156951', '19334793837209', 1, '2021-04-23 07:49:12', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 07:49:12', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000099|999000100|999000101', 3, '2021-04-23 07:49:12', '2021-04-27 10:42:17'),
(21, 'RFAD_1619157511', '19334829623342', 1, '2021-04-23 07:58:31', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 07:58:31', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000102|999000103|999000104|999000105', 4, '2021-04-23 07:58:31', '2021-04-27 10:42:17'),
(22, 'RFAD_1619159049', '19334949605198', 1, '2021-04-23 08:24:09', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 08:24:09', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000106', 1, '2021-04-23 08:24:09', '2021-04-27 10:42:17'),
(23, 'RFAD_1619164016', '19335576638370', 1, '2021-04-23 09:46:57', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 09:46:57', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000107|999000108', 2, '2021-04-23 09:46:57', '2021-04-27 10:42:17'),
(24, 'RFAD_1619188078', '19338904411716', 1, '2021-04-23 16:27:59', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 16:27:59', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-23 16:27:59', '2021-04-27 10:42:17'),
(25, 'RFAD_1619191597', '19339286458937', 1, '2021-04-23 17:26:38', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-23 17:26:38', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 5, '2021-04-23 17:26:38', '2021-04-27 10:42:17'),
(26, 'RFAD_1619279003', '19344925890599', 1, '2021-04-24 17:43:24', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 17:43:24', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000116|999000117', 2, '2021-04-24 17:43:24', '2021-04-27 10:42:17'),
(27, 'RFAD_1619279082', '19344930415051', 1, '2021-04-24 17:44:42', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 17:44:42', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-24 17:44:42', '2021-04-27 10:42:17'),
(28, 'RFAD_1619279578', '19344958803538', 1, '2021-04-24 17:52:58', 0, '', '', '', '2021-04-24 17:53:16', 1, '00', 'Successful', '2021-04-24 17:52:58', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-24 17:52:58', '2021-04-27 10:42:17'),
(29, 'RFAD_1619279975', '19344985086180', 1, '2021-04-24 17:59:36', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 17:59:36', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000122', 1, '2021-04-24 17:59:36', '2021-04-27 10:42:17'),
(30, 'RFAD_1619280077', '19344992426979', 1, '2021-04-24 18:01:18', 0, '', '', '', '2021-04-24 18:01:47', 1, '00', 'Successful', '2021-04-24 18:01:18', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 9, '2021-04-24 18:01:18', '2021-04-27 10:42:17'),
(31, 'RFAD_1619280972', '83804960662663', 1, '2021-04-24 18:16:14', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 18:16:14', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000132', 1, '2021-04-24 18:16:14', '2021-04-27 10:42:17'),
(32, 'RFAD_1619281202', '83806216054827', 1, '2021-04-24 18:20:04', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 18:20:04', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000133', 1, '2021-04-24 18:20:04', '2021-04-27 10:42:17'),
(33, 'RFAD_1619281286', '83806683448694', 1, '2021-04-24 18:21:26', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 18:21:26', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000134|999000135', 2, '2021-04-24 18:21:26', '2021-04-27 10:42:17'),
(34, 'BOT_1619281803_749', '83809732851014', 1, '2021-04-24 18:30:04', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-24 18:30:04', 'PAYMENT', '', '99447596', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000136', 1, '2021-04-24 18:30:04', '2021-04-27 10:42:17'),
(35, 'BOT_1619336251_504', '83952392622629', 1, '2021-04-25 09:37:33', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-25 09:37:33', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000137|999000138|999000139', 3, '2021-04-25 09:37:33', '2021-04-27 10:42:17'),
(36, 'BOT_1619339725_112', '83964987671660', 1, '2021-04-25 10:35:27', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-25 10:35:27', 'PAYMENT', '', '99862734', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000140|999000141|999000142|999000143|999000144', 5, '2021-04-25 10:35:27', '2021-04-27 10:42:17'),
(37, 'BOT_1619339732_375', '83965014664157', 1, '2021-04-25 10:35:34', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-25 10:35:34', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000145|999000146|999000147|999000148|999000149', 5, '2021-04-25 10:35:34', '2021-04-27 10:42:17'),
(38, 'BOT_1619420160_605', '84201914838406', 1, '2021-04-26 08:56:02', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-26 08:56:02', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 3, '2021-04-26 08:56:02', '2021-04-27 10:42:17'),
(39, 'BOT_1619441789_542', '84299634814141', 1, '2021-04-26 14:56:30', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-26 14:56:30', 'PAYMENT', '', '100091445', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000153', 1, '2021-04-26 14:56:30', '2021-04-27 10:42:17'),
(40, 'BOT_1619445469_72', '84321071825812', 1, '2021-04-26 15:57:51', 0, '', '', '', '2021-04-26 15:58:14', 1, '00', 'Successful', '2021-04-26 15:57:51', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 1, '2021-04-26 15:57:51', '2021-04-27 10:42:17'),
(41, 'BOT_1619445562_555', '84321441616923', 1, '2021-04-26 15:59:22', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-26 15:59:22', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000155', 1, '2021-04-26 15:59:22', '2021-04-27 10:42:17'),
(42, 'BOT_1619511322_243', '84500194851137', 1, '2021-04-27 10:15:25', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 10:15:25', 'PAYMENT', '', '100261769', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000156', 1, '2021-04-27 10:15:25', '2021-04-27 10:42:17'),
(43, 'BOT_1619512561_5', '84505392084443', 1, '2021-04-27 10:36:03', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 10:36:03', 'PAYMENT', '', '100261769', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000157', 1, '2021-04-27 10:36:03', '2021-04-27 10:42:17'),
(44, 'BOT_1619512865_521', '84506713811567', 1, '2021-04-27 10:41:06', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 10:41:06', 'PAYMENT', '', '99290240', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '999000158', 1, '2021-04-27 10:41:06', '2021-04-27 10:42:17'),
(45, 'BOT_1619512979_990', '84507188218327', 1, '2021-04-27 10:43:01', 0, '', '', '', '2021-04-27 10:43:09', 1, '00', 'Successful', '2021-04-27 10:43:01', 'PAYMENT', 'Cancelled', '100261769', '866818', 'Bknecasue->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 1, '2021-04-27 10:43:01', '2021-04-27 10:43:09'),
(46, 'BOT_1619517438_880', '84525307432963', 1, '2021-04-27 11:57:19', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 11:57:19', 'PAYMENT', 'Completed', '94832697', '794655', 'Bkm3m6o5t->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 1, '2021-04-27 11:57:19', '2021-04-27 11:57:19'),
(47, 'BOT_1619535871_438', '19366371458090', 1, '2021-04-27 17:04:32', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 17:04:32', 'PAYMENT', 'Completed', '100325474', '794655', 'Bknygjxid->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-27 17:04:32', '2021-04-27 17:04:32'),
(48, 'BOT_1619537557_882', '19366576436779', 1, '2021-04-27 17:32:37', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 17:32:37', 'PAYMENT', 'Completed', '100325474', '794655', 'Bknygjxid->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-27 17:32:37', '2021-04-27 17:32:37'),
(49, 'BOT_1619537857_980', '19366619622129', 1, '2021-04-27 17:37:38', 0, '', '', '', '0000-00-00 00:00:00', 1, '00', 'Successful', '2021-04-27 17:37:38', 'PAYMENT', 'Completed', '100325474', '794655', 'Bknygjxid->Nkmz2qmrj', 'e1ce3ae4b4f86e72567d0bf0978aa4b4d9a955be', '', 2, '2021-04-27 17:37:38', '2021-04-27 17:37:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_access`
--
ALTER TABLE `api_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_limits`
--
ALTER TABLE `api_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_logs`
--
ALTER TABLE `api_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_settings`
--
ALTER TABLE `api_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_token`
--
ALTER TABLE `api_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_contra`
--
ALTER TABLE `kcms_askgogo_contra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_formulation`
--
ALTER TABLE `kcms_askgogo_formulation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_ingredient`
--
ALTER TABLE `kcms_askgogo_ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_keyword`
--
ALTER TABLE `kcms_askgogo_keyword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc`
--
ALTER TABLE `kcms_askgogo_otc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_contra`
--
ALTER TABLE `kcms_askgogo_otc_contra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_formulation`
--
ALTER TABLE `kcms_askgogo_otc_formulation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_ingredient`
--
ALTER TABLE `kcms_askgogo_otc_ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_keyword`
--
ALTER TABLE `kcms_askgogo_otc_keyword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_source`
--
ALTER TABLE `kcms_askgogo_otc_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_symptom`
--
ALTER TABLE `kcms_askgogo_otc_symptom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_otc_trade`
--
ALTER TABLE `kcms_askgogo_otc_trade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_source`
--
ALTER TABLE `kcms_askgogo_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_symptom`
--
ALTER TABLE `kcms_askgogo_symptom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_askgogo_trade`
--
ALTER TABLE `kcms_askgogo_trade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_attribute`
--
ALTER TABLE `kcms_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_block`
--
ALTER TABLE `kcms_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_csvimport`
--
ALTER TABLE `kcms_csvimport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_global_headtag`
--
ALTER TABLE `kcms_global_headtag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_global_headtag_attribute`
--
ALTER TABLE `kcms_global_headtag_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_global_meta`
--
ALTER TABLE `kcms_global_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_headtag`
--
ALTER TABLE `kcms_headtag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_headtag_attribute`
--
ALTER TABLE `kcms_headtag_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_info_block`
--
ALTER TABLE `kcms_info_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_layout`
--
ALTER TABLE `kcms_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_menu`
--
ALTER TABLE `kcms_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_menu_item`
--
ALTER TABLE `kcms_menu_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_menu_item_link`
--
ALTER TABLE `kcms_menu_item_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_module`
--
ALTER TABLE `kcms_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page`
--
ALTER TABLE `kcms_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page_content`
--
ALTER TABLE `kcms_page_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page_content_section`
--
ALTER TABLE `kcms_page_content_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page_headtag`
--
ALTER TABLE `kcms_page_headtag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page_headtag_attribute`
--
ALTER TABLE `kcms_page_headtag_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_page_meta`
--
ALTER TABLE `kcms_page_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_parallax_div`
--
ALTER TABLE `kcms_parallax_div`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_permission`
--
ALTER TABLE `kcms_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_role`
--
ALTER TABLE `kcms_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_role_permission`
--
ALTER TABLE `kcms_role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Indexes for table `kcms_session`
--
ALTER TABLE `kcms_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_settings`
--
ALTER TABLE `kcms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_slider`
--
ALTER TABLE `kcms_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_slider_item`
--
ALTER TABLE `kcms_slider_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_system_log`
--
ALTER TABLE `kcms_system_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_theme`
--
ALTER TABLE `kcms_theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_user`
--
ALTER TABLE `kcms_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `kcms_user_profile`
--
ALTER TABLE `kcms_user_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ux__user_id` (`user_id`);

--
-- Indexes for table `kcms_user_role`
--
ALTER TABLE `kcms_user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `kcms_user_session_log`
--
ALTER TABLE `kcms_user_session_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kcms_variable`
--
ALTER TABLE `kcms_variable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maxapi_contact`
--
ALTER TABLE `maxapi_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `ix__contact_name` (`contact_name`),
  ADD KEY `ix__merchant_id` (`merchant_id`),
  ADD KEY `ix__store_id` (`store_id`),
  ADD KEY `ix__contact_surname` (`contact_surname`),
  ADD KEY `ix__contact_email` (`contact_email`),
  ADD KEY `ix__contact_phone` (`contact_phone`),
  ADD KEY `ix__contact_active` (`contact_active`);

--
-- Indexes for table `maxapi_country`
--
ALTER TABLE `maxapi_country`
  ADD PRIMARY KEY (`country_id`),
  ADD KEY `ix__country_active` (`country_active`),
  ADD KEY `ix__country_name` (`country_name`);

--
-- Indexes for table `maxapi_currency`
--
ALTER TABLE `maxapi_currency`
  ADD PRIMARY KEY (`currency_id`),
  ADD KEY `ix__country_id` (`country_id`),
  ADD KEY `ix__currency_active` (`currency_active`),
  ADD KEY `ix__currency_name` (`currency_name`),
  ADD KEY `ix__currency_symbol` (`currency_symbol`);

--
-- Indexes for table `maxapi_payu`
--
ALTER TABLE `maxapi_payu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_access`
--
ALTER TABLE `api_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `api_limits`
--
ALTER TABLE `api_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_logs`
--
ALTER TABLE `api_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_settings`
--
ALTER TABLE `api_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `api_token`
--
ALTER TABLE `api_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_contra`
--
ALTER TABLE `kcms_askgogo_contra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_formulation`
--
ALTER TABLE `kcms_askgogo_formulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_ingredient`
--
ALTER TABLE `kcms_askgogo_ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_keyword`
--
ALTER TABLE `kcms_askgogo_keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc`
--
ALTER TABLE `kcms_askgogo_otc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_contra`
--
ALTER TABLE `kcms_askgogo_otc_contra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_formulation`
--
ALTER TABLE `kcms_askgogo_otc_formulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_ingredient`
--
ALTER TABLE `kcms_askgogo_otc_ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_keyword`
--
ALTER TABLE `kcms_askgogo_otc_keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_source`
--
ALTER TABLE `kcms_askgogo_otc_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_symptom`
--
ALTER TABLE `kcms_askgogo_otc_symptom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_otc_trade`
--
ALTER TABLE `kcms_askgogo_otc_trade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_source`
--
ALTER TABLE `kcms_askgogo_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_symptom`
--
ALTER TABLE `kcms_askgogo_symptom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_askgogo_trade`
--
ALTER TABLE `kcms_askgogo_trade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_attribute`
--
ALTER TABLE `kcms_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kcms_block`
--
ALTER TABLE `kcms_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kcms_csvimport`
--
ALTER TABLE `kcms_csvimport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kcms_global_headtag`
--
ALTER TABLE `kcms_global_headtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kcms_global_headtag_attribute`
--
ALTER TABLE `kcms_global_headtag_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `kcms_global_meta`
--
ALTER TABLE `kcms_global_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kcms_headtag`
--
ALTER TABLE `kcms_headtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `kcms_headtag_attribute`
--
ALTER TABLE `kcms_headtag_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `kcms_info_block`
--
ALTER TABLE `kcms_info_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kcms_layout`
--
ALTER TABLE `kcms_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kcms_menu`
--
ALTER TABLE `kcms_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kcms_menu_item`
--
ALTER TABLE `kcms_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kcms_menu_item_link`
--
ALTER TABLE `kcms_menu_item_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kcms_module`
--
ALTER TABLE `kcms_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `kcms_page`
--
ALTER TABLE `kcms_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kcms_page_content`
--
ALTER TABLE `kcms_page_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kcms_page_content_section`
--
ALTER TABLE `kcms_page_content_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kcms_page_headtag`
--
ALTER TABLE `kcms_page_headtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kcms_page_headtag_attribute`
--
ALTER TABLE `kcms_page_headtag_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kcms_page_meta`
--
ALTER TABLE `kcms_page_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `kcms_parallax_div`
--
ALTER TABLE `kcms_parallax_div`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kcms_permission`
--
ALTER TABLE `kcms_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `kcms_role`
--
ALTER TABLE `kcms_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kcms_settings`
--
ALTER TABLE `kcms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kcms_slider`
--
ALTER TABLE `kcms_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kcms_slider_item`
--
ALTER TABLE `kcms_slider_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kcms_system_log`
--
ALTER TABLE `kcms_system_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `kcms_theme`
--
ALTER TABLE `kcms_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kcms_user`
--
ALTER TABLE `kcms_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kcms_user_profile`
--
ALTER TABLE `kcms_user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kcms_user_session_log`
--
ALTER TABLE `kcms_user_session_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kcms_variable`
--
ALTER TABLE `kcms_variable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `maxapi_contact`
--
ALTER TABLE `maxapi_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maxapi_country`
--
ALTER TABLE `maxapi_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `maxapi_currency`
--
ALTER TABLE `maxapi_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maxapi_payu`
--
ALTER TABLE `maxapi_payu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
