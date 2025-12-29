-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2020 at 03:46 PM
-- Server version: 5.7.32
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
-- Database: `php7opti_stracture7`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `admin_user_group_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `pwd_change_date` datetime NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `admin_user_group_id`, `branch_id`, `username`, `password`, `full_name`, `email`, `mobile`, `photo`, `last_login`, `pwd_change_date`, `status`, `created`, `updated`) VALUES
(1, 1, 0, 'admin', '0192023a7bbd73250516f069df18b500', 'ADMIN', '', '7575058824', '', '2020-10-28 15:44:19', '2020-10-22 11:05:05', 'Active', '2019-02-04 19:18:01', '2020-10-22 11:05:05'),
(10, 2, 9, 'reema', '04f459e03003549c661afc0ef5bc37ac', 'Reema Mehta', 'reema@optiinfo.com', '09662729411', '', '2020-01-30 18:32:45', '2019-11-01 18:32:30', 'Active', '2020-01-30 18:32:30', '2020-01-30 18:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_group`
--

CREATE TABLE `admin_user_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user_group`
--

INSERT INTO `admin_user_group` (`id`, `group_name`, `description`, `status`, `created`) VALUES
(1, 'Super Admin', 'All Rights', 'Active', '2019-02-04 19:18:01'),
(2, 'Branch Admin', 'Few Rights', 'Inactive', '2019-02-12 16:30:46'),
(3, 'Operator', '', 'Active', '2019-02-27 11:50:33'),
(4, 'Abc', 'Sfsdfg', 'Inactive', '2020-02-26 12:09:57'),
(5, 'Abcfg', 'Dafaf', 'Inactive', '2020-02-26 12:10:08'),
(6, 'Abvcb', 'Gfdgd', 'Inactive', '2020-02-26 12:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `address`, `person_name`, `contact_number`, `email`, `admin_user_id`, `status`, `created`, `updated`) VALUES
(9, 'Opti Solutions', 'R.T.O. relacation,, Bhuj\r\nBhuj', 'Reema Mehta', '9662729411', 'reema@optiinfo.com', 1, 'Active', '2020-01-30 18:32:13', '2020-03-17 16:38:11'),
(10, 'Bag Bee', 'test', 'test', '7412589630', 'test@gmail.com', 1, 'Active', '2020-03-17 16:40:16', '2020-03-17 16:40:16'),
(11, 'Ratna World 1', 'Mumbai', 'Vishal Shah', '9898989898', 'info@optiinfo.com', 1, 'Active', '2020-10-23 18:00:31', '2020-10-27 20:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `menu_detail`
--

CREATE TABLE `menu_detail` (
  `id` int(11) NOT NULL,
  `menu_master_id` int(11) NOT NULL,
  `menu_file_label_id` int(11) NOT NULL,
  `sort_order` int(2) NOT NULL,
  `show_in_menu` enum('No','Yes') NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_detail`
--

INSERT INTO `menu_detail` (`id`, `menu_master_id`, `menu_file_label_id`, `sort_order`, `show_in_menu`, `admin_user_id`, `status`, `created`, `updated`) VALUES
(268, 15, 132, 4, 'Yes', 1, 'Active', '2020-10-19 15:57:46', '2020-10-19 15:57:46'),
(215, 16, 112, 1, 'Yes', 1, 'Active', '2020-01-30 13:22:34', '2020-01-30 13:22:34'),
(216, 16, 109, 2, 'No', 1, 'Active', '2020-01-30 13:22:34', '2020-01-30 13:22:34'),
(217, 16, 111, 3, 'Yes', 1, 'Active', '2020-01-30 13:22:34', '2020-01-30 13:22:34'),
(218, 16, 110, 4, 'No', 1, 'Active', '2020-01-30 13:22:34', '2020-01-30 13:22:34'),
(219, 16, 126, 5, 'Yes', 1, 'Active', '2020-01-30 13:22:34', '2020-01-30 13:22:34'),
(250, 17, 121, 4, 'No', 1, 'Active', '2020-03-17 17:09:48', '2020-03-17 17:09:48'),
(249, 17, 122, 3, 'Yes', 1, 'Active', '2020-03-17 17:09:48', '2020-03-17 17:09:48'),
(239, 18, 116, 4, 'Yes', 1, 'Active', '2020-01-30 13:39:37', '2020-01-30 13:39:37'),
(238, 18, 117, 3, 'Yes', 1, 'Active', '2020-01-30 13:39:37', '2020-01-30 13:39:37'),
(237, 18, 118, 2, 'No', 1, 'Active', '2020-01-30 13:39:37', '2020-01-30 13:39:37'),
(236, 18, 119, 1, 'Yes', 1, 'Active', '2020-01-30 13:39:37', '2020-01-30 13:39:37'),
(232, 19, 123, 1, 'Yes', 1, 'Active', '2020-01-30 13:26:15', '2020-01-30 13:26:15'),
(233, 19, 125, 2, 'Yes', 1, 'Active', '2020-01-30 13:26:15', '2020-01-30 13:26:15'),
(234, 19, 124, 3, 'No', 1, 'Active', '2020-01-30 13:26:15', '2020-01-30 13:26:15'),
(235, 19, 120, 4, 'Yes', 1, 'Active', '2020-01-30 13:26:15', '2020-01-30 13:26:15'),
(240, 18, 127, 5, 'No', 1, 'Active', '2020-01-30 13:39:37', '2020-01-30 13:39:37'),
(248, 17, 113, 2, 'No', 1, 'Active', '2020-03-17 17:09:48', '2020-03-17 17:09:48'),
(247, 17, 114, 1, 'Yes', 1, 'Active', '2020-03-17 17:09:48', '2020-03-17 17:09:48'),
(251, 20, 115, 1, 'Yes', 1, 'Inactive', '2020-10-16 16:07:53', '2020-10-16 16:07:53'),
(255, 21, 130, 1, 'Yes', 1, 'Inactive', '2020-10-19 15:52:27', '2020-10-19 15:52:27'),
(256, 21, 115, 2, 'Yes', 1, 'Inactive', '2020-10-19 15:52:27', '2020-10-19 15:52:27'),
(267, 15, 131, 3, 'Yes', 1, 'Active', '2020-10-19 15:57:46', '2020-10-19 15:57:46'),
(266, 15, 130, 2, 'Yes', 1, 'Active', '2020-10-19 15:57:46', '2020-10-19 15:57:46'),
(265, 15, 115, 1, 'Yes', 1, 'Active', '2020-10-19 15:57:46', '2020-10-19 15:57:46'),
(269, 22, 115, 1, 'No', 1, 'Inactive', '2020-10-19 18:06:32', '2020-10-19 18:06:50'),
(271, 23, 133, 1, 'No', 1, 'Active', '2020-10-19 18:43:33', '2020-10-19 18:43:33'),
(277, 24, 136, 3, 'Yes', 1, 'Active', '2020-10-20 15:35:37', '2020-10-20 15:35:37'),
(276, 24, 135, 2, 'Yes', 1, 'Active', '2020-10-20 15:35:37', '2020-10-20 15:35:37'),
(275, 24, 134, 1, 'Yes', 1, 'Active', '2020-10-20 15:35:37', '2020-10-20 15:35:37'),
(278, 25, 138, 1, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(279, 25, 139, 2, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(280, 25, 137, 3, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(281, 25, 143, 4, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(282, 25, 140, 5, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(283, 25, 141, 6, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(284, 25, 144, 7, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(285, 25, 142, 8, 'Yes', 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:12'),
(309, 26, 146, 4, 'Yes', 1, 'Active', '2020-10-21 13:00:52', '2020-10-21 13:00:52'),
(308, 26, 147, 3, 'Yes', 1, 'Active', '2020-10-21 13:00:52', '2020-10-21 13:00:52'),
(307, 26, 150, 2, 'Yes', 1, 'Active', '2020-10-21 13:00:52', '2020-10-21 13:00:52'),
(306, 26, 149, 1, 'Yes', 1, 'Active', '2020-10-21 13:00:52', '2020-10-21 13:00:52'),
(310, 27, 151, 1, 'Yes', 1, 'Active', '2020-10-21 14:52:59', '2020-10-21 14:52:59'),
(311, 27, 152, 2, 'Yes', 1, 'Active', '2020-10-21 14:52:59', '2020-10-21 14:52:59'),
(312, 27, 153, 3, 'Yes', 1, 'Active', '2020-10-21 14:52:59', '2020-10-21 14:52:59'),
(314, 28, 154, 1, 'No', 1, 'Active', '2020-10-21 15:09:28', '2020-10-21 15:09:28'),
(315, 29, 155, 1, 'No', 1, 'Active', '2020-10-21 15:39:14', '2020-10-21 15:39:14'),
(316, 30, 156, 1, 'Yes', 1, 'Active', '2020-10-21 15:53:57', '2020-10-21 15:53:57'),
(317, 30, 157, 2, 'Yes', 1, 'Active', '2020-10-21 15:53:57', '2020-10-21 15:53:57'),
(318, 30, 158, 3, 'Yes', 1, 'Active', '2020-10-21 15:53:57', '2020-10-21 15:53:57'),
(319, 31, 161, 1, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(320, 31, 162, 2, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(321, 31, 160, 3, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(322, 31, 166, 4, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(323, 31, 163, 5, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(324, 31, 165, 6, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(325, 31, 164, 7, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48'),
(326, 31, 159, 8, 'Yes', 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `menu_file_label`
--

CREATE TABLE `menu_file_label` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `parameters` varchar(255) NOT NULL,
  `file_label` varchar(255) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_file_label`
--

INSERT INTO `menu_file_label` (`id`, `file_name`, `parameters`, `file_label`, `admin_user_id`, `status`, `created`, `updated`) VALUES
(109, 'admin_user_addedit', '', 'User Add', 1, 'Active', '2020-01-30 13:18:50', '2020-01-30 13:18:50'),
(110, 'admin_user_group_addedit', '', 'User Group Add', 1, 'Active', '2020-01-30 13:18:54', '2020-01-30 13:18:54'),
(111, 'admin_user_group_list', '', 'User Group List', 1, 'Active', '2020-01-30 13:18:59', '2020-01-30 13:18:59'),
(112, 'admin_user_list', '', 'User List', 1, 'Active', '2020-01-30 13:19:03', '2020-01-30 13:19:03'),
(113, 'branch_addedit', '', 'Branch Add', 1, 'Active', '2020-01-30 13:19:06', '2020-01-30 13:19:06'),
(114, 'branch_list', '', 'Branch List', 1, 'Active', '2020-01-30 13:19:10', '2020-01-30 13:19:10'),
(115, 'home', '', 'Dashboard', 1, 'Active', '2020-01-30 13:19:14', '2020-01-30 13:19:14'),
(116, 'menu_access_control', '', 'Menu Access', 1, 'Active', '2020-01-30 13:19:21', '2020-01-30 13:19:21'),
(117, 'menu_file_label', '', 'Menu File Label', 1, 'Active', '2020-01-30 13:19:33', '2020-01-30 13:19:33'),
(118, 'menu_master_addedit', '', 'Menu Add', 1, 'Active', '2020-01-30 13:19:43', '2020-01-30 13:19:43'),
(119, 'menu_master_list', '', 'Menu List', 1, 'Active', '2020-01-30 13:19:45', '2020-01-30 13:19:50'),
(120, 'message_log_list', '', 'SMS Log', 1, 'Active', '2020-01-30 13:19:54', '2020-01-30 13:19:54'),
(121, 'setting_addedit', '', 'Setting Edit', 1, 'Active', '2020-01-30 13:19:58', '2020-01-30 13:20:08'),
(122, 'setting_list', '', 'Setting List', 1, 'Active', '2020-01-30 13:20:04', '2020-01-30 13:20:04'),
(123, 'sms_addedit', '', 'Send SMS', 1, 'Active', '2020-01-30 13:20:12', '2020-01-30 13:20:12'),
(124, 'sms_template_addedit', '', 'SMS Template Add', 1, 'Active', '2020-01-30 13:20:18', '2020-01-30 13:20:18'),
(125, 'sms_template_list', '', 'SMS Template List', 1, 'Active', '2020-01-30 13:20:24', '2020-01-30 13:20:24'),
(126, 'user_logs_list', '', 'User Logs', 1, 'Active', '2020-01-30 13:20:29', '2020-01-30 13:20:29'),
(127, 'menu_file_label_addedit', '', 'Menu File Label Add', 1, 'Active', '2020-01-30 13:39:26', '2020-01-30 13:39:26'),
(128, 'class_room_addedit', '', 'Class Room Add', 1, 'Active', '2020-03-17 17:03:23', '2020-03-17 17:03:23'),
(129, 'class_room_list', '', 'Class Room List', 1, 'Active', '2020-03-17 17:03:28', '2020-03-17 17:03:28'),
(130, 'dashboard1', '', 'Dashboard 1', 1, 'Active', '2020-10-19 15:51:31', '2020-10-19 15:57:15'),
(131, 'dashboard2', '', 'Dashboard 2', 1, 'Active', '2020-10-19 15:54:11', '2020-10-19 15:54:11'),
(132, 'dashboard3', '', 'Dashboard 3', 1, 'Active', '2020-10-19 15:54:15', '2020-10-19 15:54:15'),
(133, 'widgets', '', 'Widgets', 1, 'Active', '2020-10-19 18:11:05', '2020-10-19 18:11:05'),
(134, 'chartjs', '', 'ChartJS', 1, 'Active', '2020-10-20 15:34:09', '2020-10-20 15:34:15'),
(135, 'chartfloat', '', 'Float', 1, 'Active', '2020-10-20 15:34:16', '2020-10-20 15:34:16'),
(136, 'chartinline', '', 'Inline', 1, 'Active', '2020-10-20 15:34:19', '2020-10-20 15:34:19'),
(137, 'ui_element_buttons', '', 'Buttons', 1, 'Active', '2020-10-20 16:11:43', '2020-10-20 16:11:43'),
(138, 'ui_element_general', '', 'General', 1, 'Active', '2020-10-20 16:11:46', '2020-10-20 16:11:46'),
(139, 'ui_element_icons', '', 'Icons', 1, 'Active', '2020-10-20 16:11:48', '2020-10-20 16:11:48'),
(140, 'ui_element_modals', '', 'Modals', 1, 'Active', '2020-10-20 16:11:54', '2020-10-20 16:12:00'),
(141, 'ui_element_navbar', '', 'Navbar', 1, 'Active', '2020-10-20 16:12:05', '2020-10-20 16:12:05'),
(142, 'ui_element_ribbons', '', 'Ribbons', 1, 'Active', '2020-10-20 16:12:09', '2020-10-20 16:12:09'),
(143, 'ui_element_sliders', '', 'Sliders', 1, 'Active', '2020-10-20 16:12:12', '2020-10-20 16:12:12'),
(144, 'ui_element_timeline', '', 'Timeline', 1, 'Active', '2020-10-20 16:12:15', '2020-10-20 16:12:15'),
(145, 'forms_general_elemets', '', 'General Elements', 1, 'Active', '2020-10-21 12:48:11', '2020-10-21 12:48:11'),
(146, 'forms_validations', '', 'Validations', 1, 'Active', '2020-10-21 12:48:23', '2020-10-21 12:48:23'),
(147, 'forms_editors', '', 'Editors', 1, 'Active', '2020-10-21 12:48:31', '2020-10-21 12:48:31'),
(148, 'forms_advanced_elemets', '', 'Advanced Elements', 1, 'Active', '2020-10-21 12:49:00', '2020-10-21 12:49:00'),
(149, 'forms_general_elements', '', 'General Elements', 1, 'Active', '2020-10-21 12:58:32', '2020-10-21 12:58:32'),
(150, 'forms_advanced_elements', '', 'Advanced Elements', 1, 'Active', '2020-10-21 13:00:35', '2020-10-21 13:00:35'),
(151, 'tables_simple_tables', '', 'Simple Tables', 1, 'Active', '2020-10-21 14:51:41', '2020-10-21 14:51:41'),
(152, 'tables_data_tables', '', 'Data Tables', 1, 'Active', '2020-10-21 14:51:51', '2020-10-21 14:51:51'),
(153, 'tables_jsgrid', '', 'JsGrid', 1, 'Active', '2020-10-21 14:52:00', '2020-10-21 14:52:00'),
(154, 'gallery', '', 'Gallery', 1, 'Active', '2020-10-21 15:08:27', '2020-10-21 15:08:27'),
(155, 'calendar', '', 'Calendar', 1, 'Active', '2020-10-21 15:38:45', '2020-10-21 15:38:45'),
(156, 'mailbox_inbox', '', 'Inbox', 1, 'Active', '2020-10-21 15:53:03', '2020-10-21 15:53:03'),
(157, 'mailbox_compose', '', 'Compose', 1, 'Active', '2020-10-21 15:53:06', '2020-10-21 15:53:06'),
(158, 'mailbox_read', '', 'Read', 1, 'Active', '2020-10-21 15:53:08', '2020-10-21 15:53:08'),
(159, 'pages_contacts', '', 'Contacts', 1, 'Active', '2020-10-21 16:40:49', '2020-10-21 16:40:49'),
(160, 'pages_ecommerce', '', 'Ecommerce', 1, 'Active', '2020-10-21 16:40:54', '2020-10-21 16:40:54'),
(161, 'pages_invoice', '', 'Invoice', 1, 'Active', '2020-10-21 16:40:57', '2020-10-21 16:40:57'),
(162, 'pages_profile', '', 'Profile', 1, 'Active', '2020-10-21 16:41:02', '2020-10-21 16:41:02'),
(163, 'pages_project_add', '', 'Project Add', 1, 'Active', '2020-10-21 16:41:13', '2020-10-21 16:41:13'),
(164, 'pages_project_detail', '', 'Project Detail', 1, 'Active', '2020-10-21 16:41:21', '2020-10-21 16:41:21'),
(165, 'pages_project_edit', '', 'Project Edit', 1, 'Active', '2020-10-21 16:41:29', '2020-10-21 16:41:29'),
(166, 'pages_projects', '', 'Projects', 1, 'Active', '2020-10-21 16:41:33', '2020-10-21 16:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `menu_master`
--

CREATE TABLE `menu_master` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `icon_class` varchar(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `background_color` varchar(255) NOT NULL,
  `text_color` varchar(255) NOT NULL,
  `sort_order` int(2) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`id`, `label`, `icon_class`, `file_name`, `background_color`, `text_color`, `sort_order`, `admin_user_id`, `status`, `created`, `updated`) VALUES
(15, 'Dashboard', 'fa fa-tachometer-alt', '', '', '', 2, 1, 'Active', '2020-01-30 13:21:43', '2020-10-19 15:57:46'),
(16, 'Administrator', 'fa fa-users', '', '', '', 15, 1, 'Active', '2020-01-30 13:22:34', '2020-10-17 12:34:40'),
(17, 'Masters', 'fa fa-cog', '', '', '', 12, 1, 'Active', '2020-01-30 13:23:37', '2020-03-17 17:09:48'),
(18, 'Menu Setting', 'fa fa-bars', '', '', '', 14, 1, 'Active', '2020-01-30 13:25:14', '2020-01-30 13:39:37'),
(19, 'SMS', 'fa fa-mobile', '', '', '', 13, 1, 'Active', '2020-01-30 13:26:15', '2020-01-30 13:26:49'),
(20, 'Dashboard2', 'fas fa-tachometer-alt', '', '', '', 1, 1, 'Inactive', '2020-10-16 16:07:53', '2020-10-16 16:08:31'),
(22, 'Home', 'fa fa-home', 'home', '', '', 15, 1, 'Inactive', '2020-10-19 18:06:32', '2020-10-19 18:06:50'),
(21, 'Dashboard2', 'fas fa-tachometer-alt', 'dashboard1', '', '', 15, 1, 'Inactive', '2020-10-19 15:52:27', '2020-10-19 15:54:28'),
(23, 'Widgets', 'fas fa-th', 'widgets', '', '', 3, 1, 'Active', '2020-10-19 18:13:03', '2020-10-19 18:43:33'),
(24, 'Charts', 'fas fa-chart-pie', '', '', '', 4, 1, 'Active', '2020-10-20 15:35:13', '2020-10-20 15:35:53'),
(25, 'UI Elements', 'fas fa-tree', '', '', '', 5, 1, 'Active', '2020-10-20 16:14:12', '2020-10-20 16:14:18'),
(26, 'Forms', 'fas fa-edit', '', '', '', 6, 1, 'Active', '2020-10-21 12:51:52', '2020-10-21 13:00:52'),
(27, 'Tables', 'fas fa-table', '', '', '', 7, 1, 'Active', '2020-10-21 14:52:59', '2020-10-21 14:53:06'),
(28, 'Gallery', 'far fa-image', 'gallery', '', '', 9, 1, 'Active', '2020-10-21 15:09:03', '2020-10-21 15:09:28'),
(29, 'Calendar', 'far fa-calendar-alt', 'calendar', '', '', 8, 1, 'Active', '2020-10-21 15:39:14', '2020-10-21 15:39:21'),
(30, 'Mailbox', 'far fa-envelope', '', '', '', 10, 1, 'Active', '2020-10-21 15:53:57', '2020-10-21 15:54:03'),
(31, 'Pages', 'fas fa-book', '', '', '', 11, 1, 'Active', '2020-10-21 16:43:48', '2020-10-21 16:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `menu_user_access`
--

CREATE TABLE `menu_user_access` (
  `id` int(11) NOT NULL,
  `admin_user_group_id` int(11) NOT NULL,
  `menu_master_id` int(11) NOT NULL,
  `menu_file_label_id` int(11) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_user_access`
--

INSERT INTO `menu_user_access` (`id`, `admin_user_group_id`, `menu_master_id`, `menu_file_label_id`, `permission`, `status`, `created`, `updated`) VALUES
(240, 3, 15, 0, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(241, 3, 19, 0, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(242, 3, 0, 115, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(243, 3, 0, 123, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(244, 3, 0, 125, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(245, 3, 0, 124, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52'),
(246, 3, 0, 120, 'Yes', 'Active', '2020-03-17 15:41:52', '2020-03-17 15:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `message_log`
--

CREATE TABLE `message_log` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `msg_id` varchar(255) NOT NULL,
  `called_from` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `message` text NOT NULL,
  `to_number` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `delivery_report` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_log`
--

INSERT INTO `message_log` (`id`, `branch_id`, `msg_id`, `called_from`, `datetime`, `message`, `to_number`, `date`, `time`, `delivery_report`) VALUES
(2924, 9, 'send message failed', 'ADMIN_SEND_SMS', '2020-10-17 11:47:42', 'fgghfhgfgh', '8401041343', '2020-10-17', '00:00:00', 'send message failed');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `object_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `object_field`, `object_value`, `description`, `status`, `created`, `updated`) VALUES
(12, 'ADMIN_SMS_NOS', '', '', 'Active', '2020-01-28 13:35:37', '2020-01-28 13:35:37'),
(13, 'ADMIN_EMAIL_IDS', '', '', 'Active', '2020-01-28 13:35:37', '2020-01-28 13:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `sms_template`
--

CREATE TABLE `sms_template` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `account_user_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_id` int(11) NOT NULL,
  `action` enum('Insert','Update','Delete','Restore') NOT NULL,
  `changed_on` datetime NOT NULL,
  `description` text NOT NULL,
  `inserted_from` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `admin_user_id`, `account_user_id`, `ip_address`, `table_name`, `table_id`, `action`, `changed_on`, `description`, `inserted_from`) VALUES
(1, 1, 0, '192.168.1.6', 'branch', 9, 'Insert', '2020-01-30 18:32:13', 'INSERTED data in branch \nname = Optimatrix,\naddress = R.T.O. relacation,, Bhuj\r\nBhuj,\nperson_name = Reema Mehta,\ncontact_number = 9662729411,\nemail = reema@optiinfo.com,\nsave = SAVE,', '/structure7/admin/index.php?view=branch_addedit'),
(2, 1, 0, '192.168.1.6', 'admin_user', 10, 'Insert', '2020-01-30 18:32:30', 'INSERTED data in admin_user \nadmin_user_group_id = 2,\nfull_name = Reema Mehta,\nbranch_id = 9,\nusername = reema,\nemail = reema@optiinfo.com,\nmobile = 09662729411,\nsave = SAVE,', '/structure7/admin/index.php?view=admin_user_addedit'),
(3, 1, 0, '192.168.1.4', 'admin_user_group', 2, 'Delete', '2020-02-24 12:40:35', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(4, 1, 0, '192.168.1.4', 'admin_user_group', 2, 'Restore', '2020-02-24 12:40:46', 'RESTOREED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list&recycle=true'),
(5, 1, 0, '192.168.1.4', 'admin_user_group', 2, 'Delete', '2020-02-24 12:41:42', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(6, 1, 0, '192.168.1.4', 'admin_user_group', 4, 'Insert', '2020-02-26 12:09:57', 'INSERTED data in admin_user_group \ngroup_name = abc,\ndescription = sfsdfg,\nsave = SAVE,', '/structure7/admin/index.php?view=admin_user_group_addedit'),
(7, 1, 0, '192.168.1.4', 'admin_user_group', 5, 'Insert', '2020-02-26 12:10:08', 'INSERTED data in admin_user_group \ngroup_name = abcfg,\ndescription = dafaf,\nsave = SAVE,', '/structure7/admin/index.php?view=admin_user_group_addedit'),
(8, 1, 0, '192.168.1.4', 'admin_user_group', 6, 'Insert', '2020-02-26 12:34:01', 'INSERTED data in admin_user_group \ngroup_name = abvcb,\ndescription = gfdgd,\nsave = SAVE,', '/structure7/admin/index.php?view=admin_user_group_addedit'),
(9, 1, 0, '192.168.1.12', 'admin_user_group', 6, 'Delete', '2020-02-27 16:14:28', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(10, 1, 0, '192.168.1.12', 'admin_user_group', 4, 'Delete', '2020-02-27 18:13:22', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(11, 1, 0, '192.168.1.12', 'admin_user_group', 4, 'Restore', '2020-02-27 18:13:29', 'RESTOREED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list&recycle=true'),
(12, 1, 0, '192.168.1.12', 'admin_user_group', 4, 'Delete', '2020-02-27 18:13:34', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?pg_no=0&view=admin_user_group_list'),
(13, 1, 0, '192.168.1.12', 'admin_user_group', 5, 'Delete', '2020-02-27 18:13:43', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(14, 1, 0, '192.168.1.12', 'admin_user_group', 6, 'Restore', '2020-02-27 18:13:49', 'RESTOREED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list&recycle=true'),
(15, 1, 0, '192.168.1.12', 'admin_user_group', 6, 'Delete', '2020-02-27 18:50:23', 'DELETEED data in admin_user_group', '/structure7/admin/index.php?view=admin_user_group_list'),
(16, 1, 0, '192.168.1.5', 'branch', 9, 'Delete', '2020-03-17 16:22:02', 'DELETEED data in branch', '/structure7/admin/index.php?view=branch_list'),
(17, 1, 0, '192.168.1.5', 'branch', 9, 'Restore', '2020-03-17 16:22:06', 'RESTOREED data in branch', '/structure7/admin/index.php?view=branch_list&recycle=true'),
(18, 1, 0, '192.168.1.5', 'branch', 9, 'Update', '2020-03-17 16:38:11', 'UPDATEED data in branch \nname = opti solutions,\naddress = R.T.O. relacation,, Bhuj\r\nBhuj,\nperson_name = Reema Mehta,\ncontact_number = 9662729411,\nemail = reema@optiinfo.com,\nsave = SAVE,', '/structure7/admin/index.php?view=branch_addedit&id=9&page_no=0'),
(19, 1, 0, '192.168.1.5', 'branch', 10, 'Insert', '2020-03-17 16:40:16', 'INSERTED data in branch \nname = bag bee,\naddress = test,\nperson_name = test,\ncontact_number = 7412589630,\nemail = test@gmail.com,\nsave = SAVE,', '/structure7/admin/index.php?view=branch_addedit'),
(20, 1, 0, '192.168.1.5', 'menu_file_label', 128, 'Insert', '2020-03-17 17:03:23', 'INSERTED data in menu_file_label \nfile_name = class_room_addedit,\nfile_label = Class Room Add,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://192.168.1.111/structure7/admin/index.php?view=menu_file_label'),
(21, 1, 0, '192.168.1.5', 'menu_file_label', 129, 'Insert', '2020-03-17 17:03:28', 'INSERTED data in menu_file_label \nfile_name = class_room_list,\nfile_label = Class Room List,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://192.168.1.111/structure7/admin/index.php?view=menu_file_label'),
(22, 1, 0, '192.168.1.5', 'menu_master', 17, 'Update', '2020-03-17 17:04:05', 'UPDATEED data in menu_master \nlabel = Masters,\nicon_class = fa fa-cog,\nsort_order = 2,\nmenu_file_label_id = 114,\nmenu_file_label_id = 113,\nmenu_file_label_id = 122,\nmenu_file_label_id = 121,\nmenu_file_label_id = 129,\nmenu_file_label_id = 128,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = No,\nshow_in_menu = Yes,\nshow_in_menu = No,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=17&page_no=0'),
(23, 1, 0, '192.168.1.5', 'class_room', 1, 'Insert', '2020-03-17 17:05:11', 'INSERTED data in class_room \nname = test,\nsave = SAVE,', '/structure7/admin/index.php?view=class_room_addedit'),
(24, 1, 0, '192.168.1.5', 'menu_master', 17, 'Update', '2020-03-17 17:09:48', 'UPDATEED data in menu_master \nlabel = Masters,\nicon_class = fa fa-cog,\nsort_order = 2,\nmenu_file_label_id = 114,\nmenu_file_label_id = 113,\nmenu_file_label_id = 122,\nmenu_file_label_id = 121,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = No,\nshow_in_menu = Yes,\nshow_in_menu = No,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=17&page_no=0'),
(25, 1, 0, '::1', 'menu_master', 20, 'Insert', '2020-10-16 16:07:53', 'INSERTED data in menu_master \nlabel = Dashboard2,\nicon_class = fas fa-tachometer-alt,\nsort_order = 6,\nmenu_file_label_id = 115,\nshow_menu = on,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(26, 1, 0, '::1', 'menu_master', 20, 'Update', '2020-10-16 16:08:01', 'UPDATEED data in menu_master \nsort_order = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(27, 1, 0, '::1', 'menu_master', 20, 'Delete', '2020-10-16 16:08:31', 'DELETEED data in menu_master', '/structure7/admin/index.php?view=menu_master_list'),
(28, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:33:24', 'UPDATEED data in menu_master \nsort_order = 6,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&order_by=ASC'),
(29, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:33:34', 'UPDATEED data in menu_master \nsort_order = 2,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&order_by=ASC'),
(30, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:33:39', 'UPDATEED data in menu_master \nsort_order = 6,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&order_by=ASC'),
(31, 1, 0, '::1', 'menu_master', 16, 'Update', '2020-10-17 12:33:46', 'UPDATEED data in menu_master \nsort_order = 5,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&order_by=ASC'),
(32, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:34:26', 'UPDATEED data in menu_master \nsort_order = 4,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&order_by=DESC'),
(33, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:34:34', 'UPDATEED data in menu_master \nsort_order = 3,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&'),
(34, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 12:34:36', 'UPDATEED data in menu_master \nsort_order = 2,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&'),
(35, 1, 0, '::1', 'menu_master', 16, 'Update', '2020-10-17 12:34:40', 'UPDATEED data in menu_master \nsort_order = 6,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list&order_by_field_name=label&'),
(36, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 15:58:38', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa tachometer-alt,\nfile_name = home,\nsort_order = 2,\nmenu_file_label_id = 115,\nshow_in_menu = No,\nshow_in_menu = No,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(37, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 15:58:51', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa tachometer-alt,\nfile_name = home,\nsort_order = 2,\nmenu_file_label_id = 115,\nshow_in_menu = No,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(38, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-17 15:59:08', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa fa-tachometer-alt,\nfile_name = home,\nsort_order = 2,\nmenu_file_label_id = 115,\nshow_in_menu = No,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(39, 1, 0, '::1', 'menu_file_label', 130, 'Insert', '2020-10-19 15:51:31', 'INSERTED data in menu_file_label \nfile_name = dashboard1,\nfile_label = Dashboard 1,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(40, 1, 0, '::1', 'menu_master', 21, 'Insert', '2020-10-19 15:52:27', 'INSERTED data in menu_master \nlabel = Dashboard2,\nicon_class = fas fa-tachometer-alt,\nfile_name = dashboard1,\nsort_order = 7,\nmenu_file_label_id = 130,\nmenu_file_label_id = 115,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(41, 1, 0, '::1', 'menu_file_label', 131, 'Insert', '2020-10-19 15:54:11', 'INSERTED data in menu_file_label \nfile_name = dashboard2,\nfile_label = Dashboard 2,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(42, 1, 0, '::1', 'menu_file_label', 132, 'Insert', '2020-10-19 15:54:15', 'INSERTED data in menu_file_label \nfile_name = dashboard3,\nfile_label = Dashboard 3,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(43, 1, 0, '::1', 'menu_master', 21, 'Delete', '2020-10-19 15:54:28', 'DELETEED data in menu_master', '/structure7/admin/index.php?view=menu_master_list'),
(44, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-19 15:54:48', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa fa-tachometer-alt,\nfile_name = home,\nsort_order = 2,\nmenu_file_label_id = 115,\nmenu_file_label_id = 130,\nmenu_file_label_id = 131,\nmenu_file_label_id = 132,\nshow_in_menu = No,\nshow_in_menu = No,\nshow_in_menu = No,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(45, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-19 15:55:04', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa fa-tachometer-alt,\nfile_name = home,\nsort_order = 2,\nmenu_file_label_id = 115,\nmenu_file_label_id = 130,\nmenu_file_label_id = 131,\nmenu_file_label_id = 132,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(46, 1, 0, '::1', 'menu_file_label', 130, 'Update', '2020-10-19 15:56:43', 'UPDATEED data in menu_file_label \nfile_name = dashboard1,\nfile_label = Dashboard V1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(47, 1, 0, '::1', 'menu_file_label', 130, 'Update', '2020-10-19 15:57:15', 'UPDATEED data in menu_file_label \nfile_name = dashboard1,\nfile_label = Dashboard 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(48, 1, 0, '::1', 'menu_master', 15, 'Update', '2020-10-19 15:57:46', 'UPDATEED data in menu_master \nlabel = Dashboard,\nicon_class = fa fa-tachometer-alt,\nsort_order = 2,\nmenu_file_label_id = 115,\nmenu_file_label_id = 130,\nmenu_file_label_id = 131,\nmenu_file_label_id = 132,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=15&page_no=0'),
(49, 1, 0, '::1', 'menu_master', 22, 'Insert', '2020-10-19 18:06:32', 'INSERTED data in menu_master \nlabel = Home,\nicon_class = fa fa-home,\nfile_name = home,\nsort_order = 7,\nmenu_file_label_id = 115,\nshow_in_menu = No,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(50, 1, 0, '::1', 'menu_master', 22, 'Delete', '2020-10-19 18:06:50', 'DELETEED data in menu_master', '/structure7/admin/index.php?view=menu_master_list'),
(51, 1, 0, '::1', 'menu_file_label', 133, 'Insert', '2020-10-19 18:11:05', 'INSERTED data in menu_file_label \nfile_name = widgets,\nfile_label = Widgets,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(52, 1, 0, '::1', 'menu_master', 23, 'Insert', '2020-10-19 18:13:03', 'INSERTED data in menu_master \nlabel = Widgets,\nicon_class = fas fa-th,\nfile_name = widgets,\nsort_order = 7,\nshow_in_menu = No,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(53, 1, 0, '::1', 'menu_master', 23, 'Update', '2020-10-19 18:13:10', 'UPDATEED data in menu_master \nsort_order = 3,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(54, 1, 0, '::1', 'menu_master', 23, 'Update', '2020-10-19 18:14:15', 'UPDATEED data in menu_master \nlabel = Widgets,\nicon_class = fas fa-th,\nfile_name = widgets,\nsort_order = 3,\nmenu_file_label_id = 133,\nshow_menu = on,\nshow_in_menu = Yes,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=23&page_no=0'),
(55, 1, 0, '::1', 'menu_master', 23, 'Update', '2020-10-19 18:14:38', 'UPDATEED data in menu_master \nlabel = Widgets,\nicon_class = fas fa-th,\nfile_name = widgets,\nsort_order = 3,\nshow_in_menu = No,', '/structure7/admin/index.php?view=menu_master_addedit&id=23&page_no=0'),
(56, 1, 0, '::1', 'menu_master', 23, 'Update', '2020-10-19 18:43:33', 'UPDATEED data in menu_master \nlabel = Widgets,\nicon_class = fas fa-th,\nfile_name = widgets,\nsort_order = 3,\nmenu_file_label_id = 133,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=23&page_no=0'),
(57, 1, 0, '::1', 'menu_file_label', 134, 'Insert', '2020-10-20 15:34:09', 'INSERTED data in menu_file_label \nfile_name = chartjs,\nfile_label = Chart JS,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(58, 1, 0, '::1', 'menu_file_label', 134, 'Update', '2020-10-20 15:34:15', 'UPDATEED data in menu_file_label \nfile_name = chartjs,\nfile_label = ChartJS,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(59, 1, 0, '::1', 'menu_file_label', 135, 'Insert', '2020-10-20 15:34:16', 'INSERTED data in menu_file_label \nfile_name = chartfloat,\nfile_label = Float,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(60, 1, 0, '::1', 'menu_file_label', 136, 'Insert', '2020-10-20 15:34:19', 'INSERTED data in menu_file_label \nfile_name = chartinline,\nfile_label = Inline,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(61, 1, 0, '::1', 'menu_master', 24, 'Insert', '2020-10-20 15:35:13', 'INSERTED data in menu_master \nlabel = Charts,\nicon_class = fas fa-chart-pie,\nsort_order = 8,\nmenu_file_label_id = 134,\nmenu_file_label_id = 135,\nmenu_file_label_id = 136,\nshow_in_menu = No,\nshow_in_menu = No,\nshow_in_menu = No,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(62, 1, 0, '::1', 'menu_master', 24, 'Update', '2020-10-20 15:35:37', 'UPDATEED data in menu_master \nlabel = Charts,\nicon_class = fas fa-chart-pie,\nsort_order = 8,\nmenu_file_label_id = 134,\nmenu_file_label_id = 135,\nmenu_file_label_id = 136,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=24&page_no=0'),
(63, 1, 0, '::1', 'menu_master', 24, 'Update', '2020-10-20 15:35:53', 'UPDATEED data in menu_master \nsort_order = 4,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(64, 1, 0, '::1', 'menu_file_label', 137, 'Insert', '2020-10-20 16:11:43', 'INSERTED data in menu_file_label \nfile_name = ui_element_buttons,\nfile_label = Buttons,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(65, 1, 0, '::1', 'menu_file_label', 138, 'Insert', '2020-10-20 16:11:46', 'INSERTED data in menu_file_label \nfile_name = ui_element_general,\nfile_label = General,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(66, 1, 0, '::1', 'menu_file_label', 139, 'Insert', '2020-10-20 16:11:48', 'INSERTED data in menu_file_label \nfile_name = ui_element_icons,\nfile_label = Icons,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(67, 1, 0, '::1', 'menu_file_label', 140, 'Insert', '2020-10-20 16:11:54', 'INSERTED data in menu_file_label \nfile_name = ui_element_modals,\nfile_label = Modals ,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(68, 1, 0, '::1', 'menu_file_label', 140, 'Update', '2020-10-20 16:12:00', 'UPDATEED data in menu_file_label \nfile_name = ui_element_modals,\nfile_label = Modals ,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(69, 1, 0, '::1', 'menu_file_label', 141, 'Insert', '2020-10-20 16:12:05', 'INSERTED data in menu_file_label \nfile_name = ui_element_navbar,\nfile_label = Navbar ,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(70, 1, 0, '::1', 'menu_file_label', 142, 'Insert', '2020-10-20 16:12:09', 'INSERTED data in menu_file_label \nfile_name = ui_element_ribbons,\nfile_label = Ribbons,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(71, 1, 0, '::1', 'menu_file_label', 143, 'Insert', '2020-10-20 16:12:12', 'INSERTED data in menu_file_label \nfile_name = ui_element_sliders,\nfile_label = Sliders,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(72, 1, 0, '::1', 'menu_file_label', 144, 'Insert', '2020-10-20 16:12:15', 'INSERTED data in menu_file_label \nfile_name = ui_element_timeline,\nfile_label = Timeline,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(73, 1, 0, '::1', 'menu_master', 25, 'Insert', '2020-10-20 16:14:12', 'INSERTED data in menu_master \nlabel = UI Elements,\nicon_class = fas fa-tree,\nsort_order = 9,\nmenu_file_label_id = 138,\nmenu_file_label_id = 139,\nmenu_file_label_id = 137,\nmenu_file_label_id = 143,\nmenu_file_label_id = 140,\nmenu_file_label_id = 141,\nmenu_file_label_id = 144,\nmenu_file_label_id = 142,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(74, 1, 0, '::1', 'menu_master', 25, 'Update', '2020-10-20 16:14:18', 'UPDATEED data in menu_master \nsort_order = 5,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(75, 1, 0, '::1', 'menu_file_label', 145, 'Insert', '2020-10-21 12:48:11', 'INSERTED data in menu_file_label \nfile_name = forms_general_elemets,\nfile_label = General Elements,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(76, 1, 0, '::1', 'menu_file_label', 146, 'Insert', '2020-10-21 12:48:23', 'INSERTED data in menu_file_label \nfile_name = forms_validations,\nfile_label = Validations,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(77, 1, 0, '::1', 'menu_file_label', 147, 'Insert', '2020-10-21 12:48:31', 'INSERTED data in menu_file_label \nfile_name = forms_editors,\nfile_label = Editors,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(78, 1, 0, '::1', 'menu_file_label', 148, 'Insert', '2020-10-21 12:49:00', 'INSERTED data in menu_file_label \nfile_name = forms_advanced_elemets,\nfile_label = Advanced Elements,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(79, 1, 0, '::1', 'menu_master', 26, 'Insert', '2020-10-21 12:51:52', 'INSERTED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 10,\nmenu_file_label_id = 145,\nmenu_file_label_id = 148,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(80, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 12:52:04', 'UPDATEED data in menu_master \nsort_order = 6,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(81, 1, 0, '::1', 'menu_file_label', 149, 'Insert', '2020-10-21 12:58:32', 'INSERTED data in menu_file_label \nfile_name = forms_general_elements,\nfile_label = General Elements,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(82, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 12:58:43', 'UPDATEED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 6,\nmenu_file_label_id = 145,\nmenu_file_label_id = 148,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=26&page_no=0'),
(83, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 12:59:10', 'UPDATEED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 6,\nmenu_file_label_id = 148,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nmenu_file_label_id = 145,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=26&page_no=0'),
(84, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 12:59:32', 'UPDATEED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 6,\nmenu_file_label_id = 145,\nmenu_file_label_id = 148,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,', '/structure7/admin/index.php?view=menu_master_addedit&id=26&page_no=0'),
(85, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 12:59:49', 'UPDATEED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 6,\nmenu_file_label_id = 149,\nmenu_file_label_id = 148,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=26&page_no=0'),
(86, 1, 0, '::1', 'menu_file_label', 150, 'Insert', '2020-10-21 13:00:35', 'INSERTED data in menu_file_label \nfile_name = forms_advanced_elements,\nfile_label = Advanced Elements,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(87, 1, 0, '::1', 'menu_master', 26, 'Update', '2020-10-21 13:00:52', 'UPDATEED data in menu_master \nlabel = Forms,\nicon_class = fas fa-edit,\nsort_order = 6,\nmenu_file_label_id = 149,\nmenu_file_label_id = 150,\nmenu_file_label_id = 147,\nmenu_file_label_id = 146,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=26&page_no=0'),
(88, 1, 0, '::1', 'menu_file_label', 151, 'Insert', '2020-10-21 14:51:41', 'INSERTED data in menu_file_label \nfile_name = tables_simple_tables,\nfile_label = Simple Tables,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(89, 1, 0, '::1', 'menu_file_label', 152, 'Insert', '2020-10-21 14:51:51', 'INSERTED data in menu_file_label \nfile_name = tables_data_tables,\nfile_label = Data Tables,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(90, 1, 0, '::1', 'menu_file_label', 153, 'Insert', '2020-10-21 14:52:00', 'INSERTED data in menu_file_label \nfile_name = tables_jsgrid,\nfile_label = JsGrid,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(91, 1, 0, '::1', 'menu_master', 27, 'Insert', '2020-10-21 14:52:59', 'INSERTED data in menu_master \nlabel = Tables,\nicon_class = fas fa-table,\nsort_order = 11,\nmenu_file_label_id = 151,\nmenu_file_label_id = 152,\nmenu_file_label_id = 153,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(92, 1, 0, '::1', 'menu_master', 27, 'Update', '2020-10-21 14:53:06', 'UPDATEED data in menu_master \nsort_order = 7,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(93, 1, 0, '::1', 'menu_file_label', 154, 'Insert', '2020-10-21 15:08:27', 'INSERTED data in menu_file_label \nfile_name = gallery,\nfile_label = Gallery,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(94, 1, 0, '::1', 'menu_master', 28, 'Insert', '2020-10-21 15:09:03', 'INSERTED data in menu_master \nlabel = Gallery,\nicon_class = far fa-image,\nsort_order = 12,\nmenu_file_label_id = 154,\nshow_in_menu = No,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(95, 1, 0, '::1', 'menu_master', 28, 'Update', '2020-10-21 15:09:18', 'UPDATEED data in menu_master \nsort_order = 8,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(96, 1, 0, '::1', 'menu_master', 28, 'Update', '2020-10-21 15:09:28', 'UPDATEED data in menu_master \nlabel = Gallery,\nicon_class = far fa-image,\nfile_name = gallery,\nsort_order = 8,\nmenu_file_label_id = 154,\nshow_in_menu = No,\nsave = SAVE,', '/structure7/admin/index.php?view=menu_master_addedit&id=28&page_no=0'),
(97, 1, 0, '::1', 'menu_file_label', 155, 'Insert', '2020-10-21 15:38:45', 'INSERTED data in menu_file_label \nfile_name = calendar,\nfile_label = Calendar,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(98, 1, 0, '::1', 'menu_master', 29, 'Insert', '2020-10-21 15:39:14', 'INSERTED data in menu_master \nlabel = Calendar,\nicon_class = far fa-calendar-alt,\nfile_name = calendar,\nsort_order = 13,\nmenu_file_label_id = 155,\nshow_in_menu = No,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(99, 1, 0, '::1', 'menu_master', 29, 'Update', '2020-10-21 15:39:21', 'UPDATEED data in menu_master \nsort_order = 8,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(100, 1, 0, '::1', 'menu_file_label', 156, 'Insert', '2020-10-21 15:53:03', 'INSERTED data in menu_file_label \nfile_name = mailbox_inbox,\nfile_label = Inbox,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(101, 1, 0, '::1', 'menu_file_label', 157, 'Insert', '2020-10-21 15:53:06', 'INSERTED data in menu_file_label \nfile_name = mailbox_compose,\nfile_label = Compose,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(102, 1, 0, '::1', 'menu_file_label', 158, 'Insert', '2020-10-21 15:53:08', 'INSERTED data in menu_file_label \nfile_name = mailbox_read,\nfile_label = Read,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(103, 1, 0, '::1', 'menu_master', 30, 'Insert', '2020-10-21 15:53:57', 'INSERTED data in menu_master \nlabel = Mailbox,\nicon_class = far fa-envelope,\nsort_order = 14,\nmenu_file_label_id = 156,\nmenu_file_label_id = 157,\nmenu_file_label_id = 158,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(104, 1, 0, '::1', 'menu_master', 30, 'Update', '2020-10-21 15:54:03', 'UPDATEED data in menu_master \nsort_order = 10,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(105, 1, 0, '::1', 'menu_file_label', 159, 'Insert', '2020-10-21 16:40:49', 'INSERTED data in menu_file_label \nfile_name = pages_contacts,\nfile_label = Contacts,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(106, 1, 0, '::1', 'menu_file_label', 160, 'Insert', '2020-10-21 16:40:54', 'INSERTED data in menu_file_label \nfile_name = pages_ecommerce,\nfile_label = Ecommerce,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(107, 1, 0, '::1', 'menu_file_label', 161, 'Insert', '2020-10-21 16:40:57', 'INSERTED data in menu_file_label \nfile_name = pages_invoice,\nfile_label = Invoice,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(108, 1, 0, '::1', 'menu_file_label', 162, 'Insert', '2020-10-21 16:41:02', 'INSERTED data in menu_file_label \nfile_name = pages_profile,\nfile_label = Profile,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(109, 1, 0, '::1', 'menu_file_label', 163, 'Insert', '2020-10-21 16:41:13', 'INSERTED data in menu_file_label \nfile_name = pages_project_add,\nfile_label = Project Add,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(110, 1, 0, '::1', 'menu_file_label', 164, 'Insert', '2020-10-21 16:41:21', 'INSERTED data in menu_file_label \nfile_name = pages_project_detail,\nfile_label = Project Detail,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(111, 1, 0, '::1', 'menu_file_label', 165, 'Insert', '2020-10-21 16:41:29', 'INSERTED data in menu_file_label \nfile_name = pages_project_edit,\nfile_label = Project Edit,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(112, 1, 0, '::1', 'menu_file_label', 166, 'Insert', '2020-10-21 16:41:33', 'INSERTED data in menu_file_label \nfile_name = pages_projects,\nfile_label = Projects,\nadmin_user_id = 1,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_file_label'),
(113, 1, 0, '::1', 'menu_master', 31, 'Insert', '2020-10-21 16:43:48', 'INSERTED data in menu_master \nlabel = Pages,\nicon_class = fas fa-book,\nsort_order = 15,\nmenu_file_label_id = 161,\nmenu_file_label_id = 162,\nmenu_file_label_id = 160,\nmenu_file_label_id = 166,\nmenu_file_label_id = 163,\nmenu_file_label_id = 165,\nmenu_file_label_id = 164,\nmenu_file_label_id = 159,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_menu = on,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nshow_in_menu = Yes,\nsave = SAVE,\nadmin_user_id = 1,', '/structure7/admin/index.php?view=menu_master_addedit'),
(114, 1, 0, '::1', 'menu_master', 31, 'Update', '2020-10-21 16:43:57', 'UPDATEED data in menu_master \nsort_order = 11,', '/structure7/scripts/ajax/index.php<br>http://localhost/structure7/admin/index.php?view=menu_master_list'),
(115, 1, 0, '106.213.212.98', 'branch', 11, 'Insert', '2020-10-23 18:00:31', 'INSERTED data in branch \nname = Ratna World,\naddress = Mumbai,\nperson_name = Vishal Shah,\ncontact_number = 9898989898,\nemail = info@optiinfo.com,\nsave = SAVE,', '/admin/index.php?view=branch_addedit'),
(116, 1, 0, '182.70.121.61', 'branch', 11, 'Update', '2020-10-27 20:13:20', 'UPDATEED data in branch \nname = Ratna World 1,\naddress = Mumbai,\nperson_name = Vishal Shah,\ncontact_number = 9898989898,\nemail = info@optiinfo.com,', '/admin/index.php?view=branch_addedit&id=11&page_no=0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_group`
--
ALTER TABLE `admin_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_detail`
--
ALTER TABLE `menu_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_file_label`
--
ALTER TABLE `menu_file_label`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_master`
--
ALTER TABLE `menu_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_user_access`
--
ALTER TABLE `menu_user_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_log`
--
ALTER TABLE `message_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_template`
--
ALTER TABLE `sms_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admin_user_group`
--
ALTER TABLE `admin_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu_detail`
--
ALTER TABLE `menu_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT for table `menu_file_label`
--
ALTER TABLE `menu_file_label`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `menu_master`
--
ALTER TABLE `menu_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `menu_user_access`
--
ALTER TABLE `menu_user_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `message_log`
--
ALTER TABLE `message_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2925;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sms_template`
--
ALTER TABLE `sms_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
