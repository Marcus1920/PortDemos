-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2017 at 02:30 PM
-- Server version: 5.5.57-cll
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ubulwclo_siyaleaders`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_images`
--

DROP TABLE IF EXISTS `document_images`;
CREATE TABLE `document_images` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `group_id` varchar(100) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document_images`
--

INSERT INTO `document_images` (`id`, `name`, `img_url`, `description`, `user_id`, `folder_id`, `group_id`, `notes`, `created_at`, `updated_at`, `status`) VALUES
(1, '1502954982.png', 'document_repository/21-aug-2017/1503318971.png', 'test', 1, 1, '1', 'tets', '2017-08-21 09:06:11', '2017-08-21 14:36:11', 1),
(3, 'mypos.pdf', 'document_repository/21-aug-2017/1503319257.pdf', 'test', 1, 1, '1', 'test', '2017-08-21 09:10:57', '2017-08-21 14:40:57', 1),
(4, 'articals_image8.jpg', 'document_repository/22-aug-17/1503399819.jpg', 'qwqwqwqw', 1, 2, '1', 'qwwqwqw', '2017-08-22 07:33:39', '2017-08-22 13:03:39', 1),
(5, '1502954982 (2).png', 'document_repository/Anand/Anand-sub/1503484171.png', 'test', 1, 8, '1', 'test', '2017-08-23 06:59:31', '2017-08-23 12:29:31', 1),
(6, '1502954982.png', 'document_repository/Anand/Anand-sub/1503484201.png', 'sds', 1, 8, '1', 'sds', '2017-08-23 07:00:01', '2017-08-23 12:30:01', 1),
(7, '2b8717e385f04061c8b6b78cd4c663c7.jpg', 'document_repository/Testing/1503484346.jpg', 'Hide and seek champion', 1, 4, '1', 'There are no notes for this image', '2017-08-23 07:02:26', '2017-08-23 12:32:26', 1),
(8, '1501085459.jpg', 'document_repository/30-aug-2017/sub30aug2017/1503990900.jpg', 'gfdfg', 1, 20, '1,2', 'fds', '2017-08-29 03:45:00', '2017-08-29 09:15:00', 1),
(9, 'bodymsaage.jpg', 'document_repository/Niraj/niraj1/1503992665.jpg', 'dsfds', 1, 22, '1,2', 'sdfds', '2017-08-29 04:14:25', '2017-08-29 09:44:25', 1),
(11, 'Biometrico - 200x200.png', 'document_repository/Test Projects/Timesheet test/1503994683.png', 'Biometrico Logo', 1, 25, '1,2,3', 'Biometrico Logo', '2017-08-29 04:48:03', '2017-08-29 10:18:03', 1),
(12, 'Screenshot from 2017-03-30 15:55:43.png', 'document_repository/Niraj/New Projects/cadcorporation/1503994917.png', 'asasasasas', 1, 26, '1,2,3', 'TEST WITH FEATURES', '2017-08-29 04:51:57', '2017-08-29 10:21:57', 1),
(13, '2b8717e385f04061c8b6b78cd4c663c7.jpg', 'document_repository/Rupert\'s Folder/1504096478.jpg', 'The biggest problem Developers have to deal with', 1, 5, '1', 'The biggest problem Developers have to deal with', '2017-08-30 09:04:38', '2017-08-30 14:34:38', 1),
(15, 'steve.png', 'document_repository/Rupert\'s Folder/Rupert\'s sub-folder/1504509632.png', 'Steve Jobs', 1, 10, '1,2,3', 'A phot of Steve Jobs', '2017-09-04 07:20:32', '2017-09-04 09:20:32', 1),
(16, '1502954982.png', 'document_repository/30-aug-2017/sub30aug2017/sub301sug20147/1504512610.png', 'sdfds', 1, 30, '1', 'dsdf', '2017-09-04 08:10:10', '2017-09-04 10:10:10', 1),
(17, 'bill.png', 'document_repository/Rupert\'s Folder/Test folder 2/1504513687.png', 'Bill Gates', 1, 31, '1,2,3', 'Windoze Boss', '2017-09-04 08:28:07', '2017-09-04 10:28:07', 1),
(18, 'server 2.png', 'document_repository/Testing/Testing sub folder Rupert/1504513814.png', 'Siyaleader Server Farm', 1, 32, '1,2,3', 'Icon for presentations', '2017-09-04 08:30:14', '2017-09-04 10:30:14', 1),
(19, 'drone 2.png', 'document_repository/Projects/BRS (Business Requirement Specifications)/BRS2/1504514852.png', 'ROV', 1, 14, '1,2,3', 'Underwater Drone for Ship Hull Inspections', '2017-09-04 08:47:33', '2017-09-04 10:47:33', 1),
(20, 'KZN Districts & Municipalities.doc', 'document_repository/Rupert\'s Folder/New Test sub-folder/1504515347.doc', 'KZN Districts & Municipalities', 1, 27, '1,2,3', 'KZN Districts & Municipalities', '2017-09-04 08:55:47', '2017-09-04 10:55:47', 1),
(21, 'arguing with stupid people is impossible.jpg', 'document_repository/Rupert\'s Folder/Another Sub-Folder/1504515442.jpg', 'Testing return to folder after file upload', 1, 29, '1,2,3', 'Testing return to folder after file upload', '2017-09-04 08:57:22', '2017-09-04 10:57:22', 1),
(22, 'logo.png', 'document_repository/Rupert\'s Folder/1504516953.png', 'Bear', 1, 5, '1,2,3', 'Bear notes', '2017-09-04 09:22:33', '2017-09-04 11:22:33', 1),
(23, 'IMPORTANT NOTICE.docx', 'document_repository/Rupert\'s Folder/Test folder 2/1504521147.docx', 'Afriguard Notice', 1, 31, '1,2,3', 'Afriguard Notice', '2017-09-04 10:32:27', '2017-09-04 12:32:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `document_logs`
--

DROP TABLE IF EXISTS `document_logs`;
CREATE TABLE `document_logs` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_type` varchar(20) DEFAULT NULL,
  `document_path` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `operation` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document_logs`
--

INSERT INTO `document_logs` (`id`, `document_id`, `user_id`, `document_type`, `document_path`, `created_at`, `updated_at`, `status`, `operation`) VALUES
(1, 1, 1, 'documents', 'document_repository/21-aug-2017/', '2017-08-21 12:36:11', '0000-00-00 00:00:00', 1, 'create'),
(2, 2, 1, 'documents', 'document_repository/21-aug-2017/', '2017-08-21 12:40:12', '0000-00-00 00:00:00', 1, 'create'),
(3, 2, 1, 'documents', NULL, '2017-08-21 12:40:29', '0000-00-00 00:00:00', 1, 'delete'),
(4, 3, 1, 'documents', 'document_repository/21-aug-2017/', '2017-08-21 12:40:57', '0000-00-00 00:00:00', 1, 'create'),
(5, 4, 1, 'documents', 'document_repository/22-aug-17/', '2017-08-22 11:03:40', '0000-00-00 00:00:00', 1, 'create'),
(6, 4, 1, 'documents', NULL, '2017-08-22 11:03:49', '0000-00-00 00:00:00', 1, 'download'),
(7, 4, 1, 'documents', NULL, '2017-08-22 11:03:54', '0000-00-00 00:00:00', 1, 'download'),
(8, 5, 1, 'documents', 'document_repository/Anand/Anand-sub/', '2017-08-23 10:29:31', '0000-00-00 00:00:00', 1, 'create'),
(9, 6, 1, 'documents', 'document_repository/Anand/Anand-sub/', '2017-08-23 10:30:01', '0000-00-00 00:00:00', 1, 'create'),
(10, 7, 1, 'documents', 'document_repository/Testing/', '2017-08-23 10:32:26', '0000-00-00 00:00:00', 1, 'create'),
(11, 8, 1, 'documents', 'document_repository/30-aug-2017/sub30aug2017/', '2017-08-29 07:15:00', '0000-00-00 00:00:00', 1, 'create'),
(12, 9, 1, 'documents', 'document_repository/Niraj/niraj1/', '2017-08-29 07:44:25', '0000-00-00 00:00:00', 1, 'create'),
(13, 10, 1, 'documents', 'document_repository/Rupert\'s Folder/Rupert\'s sub-folder/', '2017-08-29 08:16:16', '0000-00-00 00:00:00', 1, 'create'),
(14, 11, 1, 'documents', 'document_repository/Test Projects/Timesheet test/', '2017-08-29 08:18:03', '0000-00-00 00:00:00', 1, 'create'),
(15, 6, 1, 'documents', NULL, '2017-08-29 08:20:20', '0000-00-00 00:00:00', 1, 'download'),
(16, 12, 1, 'documents', 'document_repository/Niraj/New Projects/cadcorporation/', '2017-08-29 08:21:57', '0000-00-00 00:00:00', 1, 'create'),
(17, 10, 1, 'documents', NULL, '2017-08-30 12:32:59', '0000-00-00 00:00:00', 1, 'download'),
(18, 13, 1, 'documents', 'document_repository/Rupert\'s Folder/', '2017-08-30 12:34:38', '0000-00-00 00:00:00', 1, 'create'),
(19, 13, 1, 'documents', NULL, '2017-08-30 12:52:06', '0000-00-00 00:00:00', 1, 'download'),
(20, 4, 1, 'documents', NULL, '2017-09-02 09:27:34', '0000-00-00 00:00:00', 1, 'download'),
(21, 1, 1, 'documents', NULL, '2017-09-02 09:28:07', '0000-00-00 00:00:00', 1, 'download'),
(22, 3, 1, 'documents', NULL, '2017-09-02 09:28:21', '0000-00-00 00:00:00', 1, 'download'),
(23, 14, 1, 'documents', 'document_repository/Rupert\'s Folder/New Test sub-folder/', '2017-09-02 09:31:22', '0000-00-00 00:00:00', 1, 'create'),
(24, 10, 1, 'documents', NULL, '2017-09-02 09:31:50', '0000-00-00 00:00:00', 1, 'delete'),
(25, 14, 1, 'documents', NULL, '2017-09-02 09:31:58', '0000-00-00 00:00:00', 1, 'delete'),
(26, 15, 1, 'documents', 'document_repository/Rupert\'s Folder/Rupert\'s sub-folder/', '2017-09-04 07:20:32', '0000-00-00 00:00:00', 1, 'create'),
(27, 16, 1, 'documents', 'document_repository/30-aug-2017/sub30aug2017/sub301sug20147/', '2017-09-04 08:10:10', '0000-00-00 00:00:00', 1, 'create'),
(28, 17, 1, 'documents', 'document_repository/Rupert\'s Folder/Test folder 2/', '2017-09-04 08:28:07', '0000-00-00 00:00:00', 1, 'create'),
(29, 18, 1, 'documents', 'document_repository/Testing/Testing sub folder Rupert/', '2017-09-04 08:30:14', '0000-00-00 00:00:00', 1, 'create'),
(30, 18, 1, 'documents', NULL, '2017-09-04 08:32:26', '0000-00-00 00:00:00', 1, 'download'),
(31, 19, 1, 'documents', 'document_repository/Projects/BRS (Business Requirement Specifications)/BRS2/', '2017-09-04 08:47:33', '0000-00-00 00:00:00', 1, 'create'),
(32, 20, 1, 'documents', 'document_repository/Rupert\'s Folder/New Test sub-folder/', '2017-09-04 08:55:47', '0000-00-00 00:00:00', 1, 'create'),
(33, 21, 1, 'documents', 'document_repository/Rupert\'s Folder/Another Sub-Folder/', '2017-09-04 08:57:22', '0000-00-00 00:00:00', 1, 'create'),
(34, 20, 1, 'documents', NULL, '2017-09-04 08:57:35', '0000-00-00 00:00:00', 1, 'download'),
(35, 22, 1, 'documents', 'document_repository/Rupert\'s Folder/', '2017-09-04 09:22:33', '0000-00-00 00:00:00', 1, 'create'),
(36, 23, 1, 'documents', 'document_repository/Rupert\'s Folder/Test folder 2/', '2017-09-04 10:32:27', '0000-00-00 00:00:00', 1, 'create');

-- --------------------------------------------------------

--
-- Table structure for table `document_permissions`
--

DROP TABLE IF EXISTS `document_permissions`;
CREATE TABLE `document_permissions` (
  `id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `is_write` tinyint(4) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document_permissions`
--

INSERT INTO `document_permissions` (`id`, `folder_id`, `role_id`, `is_read`, `is_write`, `create_at`, `updated_at`) VALUES
(0, 1, 1, 1, 1, '2017-08-21 12:35:34', NULL),
(0, 1, 2, 1, 1, '2017-08-21 12:35:34', NULL),
(0, 1, 3, 1, 1, '2017-08-21 12:35:34', NULL),
(0, 2, 1, 1, 1, '2017-08-22 10:51:10', NULL),
(0, 2, 2, 1, 0, '2017-08-22 10:51:10', NULL),
(0, 2, 3, 1, 0, '2017-08-22 10:51:11', NULL),
(0, 3, 1, 1, 0, '2017-08-22 11:02:12', NULL),
(0, 3, 2, 1, 0, '2017-08-22 11:02:12', NULL),
(0, 3, 3, 1, 0, '2017-08-22 11:02:12', NULL),
(0, 4, 1, 1, 1, '2017-08-22 14:02:47', NULL),
(0, 4, 2, 1, 1, '2017-08-22 14:02:47', NULL),
(0, 4, 3, 1, 0, '2017-08-22 14:02:47', NULL),
(0, 6, 1, 1, 0, '2017-08-23 10:22:07', NULL),
(0, 7, 1, 1, 1, '2017-08-23 10:28:37', NULL),
(0, 7, 2, 1, 0, '2017-08-23 10:28:37', NULL),
(0, 7, 3, 1, 0, '2017-08-23 10:28:37', NULL),
(0, 8, 1, 1, 1, '2017-08-23 10:29:45', NULL),
(0, 8, 2, 1, 0, '2017-08-23 10:29:45', NULL),
(0, 8, 3, 1, 0, '2017-08-23 10:29:45', NULL),
(0, 9, 1, 1, 0, '2017-08-23 10:35:57', NULL),
(0, 9, 2, 1, 0, '2017-08-23 10:35:57', NULL),
(0, 9, 3, 1, 0, '2017-08-23 10:35:57', NULL),
(0, 5, 1, 1, 1, '2017-08-23 10:39:28', NULL),
(0, 10, 1, 1, 1, '2017-08-23 10:40:47', NULL),
(0, 10, 2, 1, 0, '2017-08-23 10:40:47', NULL),
(0, 10, 3, 1, 0, '2017-08-23 10:40:47', NULL),
(0, 11, 1, 1, 1, '2017-08-28 12:04:50', NULL),
(0, 11, 2, 1, 1, '2017-08-28 12:04:50', NULL),
(0, 11, 3, 1, 1, '2017-08-28 12:04:50', NULL),
(0, 12, 1, 1, 1, '2017-08-28 12:10:53', NULL),
(0, 12, 2, 1, 1, '2017-08-28 12:10:53', NULL),
(0, 12, 3, 1, 1, '2017-08-28 12:10:53', NULL),
(0, 13, 1, 1, 1, '2017-08-28 12:54:33', NULL),
(0, 13, 2, 0, 0, '2017-08-28 12:54:33', NULL),
(0, 13, 3, 0, 0, '2017-08-28 12:54:33', NULL),
(0, 14, 1, 1, 1, '2017-08-28 12:55:19', NULL),
(0, 14, 2, 1, 1, '2017-08-28 12:55:19', NULL),
(0, 14, 3, 1, 1, '2017-08-28 12:55:19', NULL),
(0, 15, 1, 0, 0, '2017-08-28 13:00:57', NULL),
(0, 15, 2, 0, 0, '2017-08-28 13:00:57', NULL),
(0, 15, 3, 0, 0, '2017-08-28 13:00:57', NULL),
(0, 16, 1, 0, 0, '2017-08-28 13:03:32', NULL),
(0, 16, 2, 0, 0, '2017-08-28 13:03:32', NULL),
(0, 16, 3, 0, 0, '2017-08-28 13:03:32', NULL),
(0, 17, 1, 0, 0, '2017-08-28 13:43:18', NULL),
(0, 17, 2, 0, 0, '2017-08-28 13:43:18', NULL),
(0, 17, 3, 0, 0, '2017-08-28 13:43:18', NULL),
(0, 18, 1, 1, 0, '2017-08-29 07:08:35', NULL),
(0, 18, 2, 1, 0, '2017-08-29 07:08:35', NULL),
(0, 18, 3, 1, 0, '2017-08-29 07:08:35', NULL),
(0, 19, 1, 1, 1, '2017-08-29 07:13:10', NULL),
(0, 19, 2, 1, 1, '2017-08-29 07:13:10', NULL),
(0, 19, 3, 1, 0, '2017-08-29 07:13:10', NULL),
(0, 20, 1, 1, 1, '2017-08-29 07:14:01', NULL),
(0, 20, 2, 1, 1, '2017-08-29 07:14:01', NULL),
(0, 20, 3, 1, 0, '2017-08-29 07:14:01', NULL),
(0, 21, 1, 1, 1, '2017-08-29 07:43:47', NULL),
(0, 21, 2, 1, 0, '2017-08-29 07:43:47', NULL),
(0, 21, 3, 1, 0, '2017-08-29 07:43:47', NULL),
(0, 22, 1, 1, 1, '2017-08-29 07:44:12', NULL),
(0, 22, 2, 1, 0, '2017-08-29 07:44:12', NULL),
(0, 22, 3, 0, 0, '2017-08-29 07:44:12', NULL),
(0, 23, 1, 1, 1, '2017-08-29 08:12:39', NULL),
(0, 23, 2, 1, 1, '2017-08-29 08:12:39', NULL),
(0, 23, 3, 0, 0, '2017-08-29 08:12:39', NULL),
(0, 24, 1, 1, 1, '2017-08-29 08:13:22', NULL),
(0, 24, 2, 1, 1, '2017-08-29 08:13:22', NULL),
(0, 24, 3, 1, 1, '2017-08-29 08:13:22', NULL),
(0, 25, 1, 1, 1, '2017-08-29 08:14:50', NULL),
(0, 25, 2, 1, 1, '2017-08-29 08:14:50', NULL),
(0, 25, 3, 1, 1, '2017-08-29 08:14:50', NULL),
(0, 26, 1, 1, 1, '2017-08-29 08:21:28', NULL),
(0, 26, 2, 1, 1, '2017-08-29 08:21:28', NULL),
(0, 26, 3, 1, 1, '2017-08-29 08:21:28', NULL),
(0, 28, 1, 0, 0, '2017-08-30 12:34:44', NULL),
(0, 28, 2, 0, 0, '2017-08-30 12:34:44', NULL),
(0, 28, 3, 0, 0, '2017-08-30 12:34:44', NULL),
(0, 27, 1, 1, 1, '2017-09-02 09:32:31', NULL),
(0, 29, 1, 1, 1, '2017-09-04 07:17:52', NULL),
(0, 30, 1, 1, 1, '2017-09-04 08:09:23', NULL),
(0, 31, 1, 1, 1, '2017-09-04 08:27:17', NULL),
(0, 31, 2, 1, 0, '2017-09-04 08:27:17', NULL),
(0, 31, 3, 1, 0, '2017-09-04 08:27:17', NULL),
(0, 32, 1, 1, 1, '2017-09-04 08:29:03', NULL),
(0, 32, 2, 1, 0, '2017-09-04 08:29:03', NULL),
(0, 32, 3, 1, 0, '2017-09-04 08:29:03', NULL),
(0, 33, 1, 1, 0, '2017-09-04 09:23:55', NULL),
(0, 33, 2, 1, 0, '2017-09-04 09:23:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `document_repositories`
--

DROP TABLE IF EXISTS `document_repositories`;
CREATE TABLE `document_repositories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `doc_version` decimal(10,0) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `group_id` varchar(100) DEFAULT NULL,
  `pesmission_id` int(11) DEFAULT NULL,
  `lavel` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document_repositories`
--

INSERT INTO `document_repositories` (`id`, `name`, `description`, `doc_version`, `notes`, `user_id`, `parent_id`, `group_id`, `pesmission_id`, `lavel`, `created_at`, `updated_at`, `status`) VALUES
(1, '21-aug-2017', 'test', '1', 'test', 1, 0, '1,2,3', NULL, 0, '2017-08-21 09:05:34', '2017-08-21 14:35:34', 1),
(2, '22-aug-17', 'test', '1', 'test', 1, 0, '1,2,3', NULL, 0, '2017-08-22 07:20:59', '2017-08-22 12:51:10', 1),
(3, 'test1', 'dsfs', '1', 'test', 1, 2, '1,2,3', NULL, 1, '2017-08-22 07:24:01', '2017-08-22 01:02:12', 1),
(4, 'Testing', 'testing', '1', 'dd', 1, 0, '1,2,3', NULL, 0, '2017-08-22 10:32:46', '2017-08-22 16:02:46', 1),
(5, 'Rupert\'s Folder', 'Rupert test folder', '1', 'Rupert test folder notes', 1, 0, '1', NULL, 0, '2017-08-23 06:48:55', '2017-08-23 12:39:28', 1),
(6, 'Testing sub folder', 'Testing sub folder description', '1', 'Testing sub folder notes', 1, 4, '1', NULL, 1, '2017-08-23 06:52:07', '2017-08-23 12:22:07', 1),
(7, 'Anand', 'test', '1', 'test', 1, 0, '1,2,3', NULL, 0, '2017-08-23 06:58:37', '2017-08-23 12:28:37', 1),
(8, 'Anand-sub', 'test', '0', 'test', 1, 7, '1,2,3', NULL, 1, '2017-08-23 06:59:12', '2017-08-23 12:29:45', 1),
(9, 'sub2', 'test', '0', '', 1, 8, '1,2,3', NULL, 2, '2017-08-23 07:05:57', '2017-08-23 12:35:57', 1),
(10, 'Rupert\'s sub-folder', 'Rupert\'s sub-folder description', '1', 'Rupert\'s sub-folder notes', 1, 5, '1,2,3', NULL, 1, '2017-08-23 07:10:46', '2017-08-23 12:40:46', 1),
(11, 'Projects', 'Project Documents', '0', 'All Project Docs', 1, 0, '1,2,3', NULL, 0, '2017-08-28 08:34:49', '2017-08-28 14:04:49', 1),
(12, 'TimeSheets', 'Developer Time-sheets', '1', 'Developer Time-sheets', 1, 11, '1,2,3', NULL, 1, '2017-08-28 08:40:53', '2017-08-28 14:10:53', 1),
(13, 'BRS (Business Requirement Specifications)', 'BRS (Business Requirement Specifications)', '0', 'BRS (Business Requirement Specifications)', 1, 11, '1,2,3', NULL, 1, '2017-08-28 09:22:58', '2017-08-28 02:54:33', 1),
(14, 'BRS2', 'BRS2', '1', 'test', 1, 13, '1,2,3', NULL, 2, '2017-08-28 09:25:19', '2017-08-28 14:55:19', 1),
(15, 'Project Docs', 'Project Docs', '0', 'Project Docs', 1, 11, '1,2,3', NULL, 1, '2017-08-28 09:30:57', '2017-08-28 15:00:57', 1),
(16, 'FRS (Functional Requirement Spec)', 'FRS (Functional Requirement Spec)', '0', 'FRS (Functional Requirement Spec)', 1, 13, '1,2,3', NULL, 2, '2017-08-28 09:33:32', '2017-08-28 15:03:32', 1),
(19, '30-aug-2017', 'test', '0', 'sdfds', 1, 0, '1,2,3', NULL, 0, '2017-08-29 03:43:09', '2017-08-29 09:13:09', 1),
(20, 'sub30aug2017', 'test', '0', 'sdfs', 1, 19, '1,2,3', NULL, 1, '2017-08-29 03:44:01', '2017-08-29 09:14:01', 1),
(25, 'Timesheet test', 'Timesheet test', '0', 'Timesheet test', 1, 24, '1,2,3', NULL, 1, '2017-08-29 04:44:49', '2017-08-29 10:14:49', 1),
(26, 'cadcorporation', 'TEST WITH FEATURES', '0', 'adadadad', 1, 23, '1,2,3', NULL, 2, '2017-08-29 04:51:28', '2017-08-29 10:21:28', 1),
(27, 'New Test sub-folder', 'New Test sub-folder', '1', 'Rupert\'s sub-folder notes', 1, 5, '1', NULL, 1, '2017-08-30 09:02:00', '2017-09-02 11:32:31', 2),
(29, 'Another Sub-Folder', 'Testing return to root fix', '1', 'Notes about this folder', 1, 5, '1', NULL, 1, '2017-09-04 07:17:52', '2017-09-04 09:17:52', 1),
(30, 'sub301sug20147', 'asdas', '1', 'test', 1, 20, '1', NULL, 2, '2017-09-04 08:09:23', '2017-09-04 10:09:23', 1),
(31, 'Test folder 2', 'Testing Ajax folder creation', '1', 'Testing Ajax folder creation', 1, 5, '1,2,3', NULL, 1, '2017-09-04 08:27:17', '2017-09-04 10:27:17', 1),
(32, 'Testing sub folder Rupert', 'What the name says', '1', 'Testing sub folder Rupert', 1, 4, '1,2,3', NULL, 1, '2017-09-04 08:29:03', '2017-09-04 10:29:03', 1),
(33, 'Sub-Sub Folder', 'Sub-Sub Folder', '1', 'Whatever', 1, 31, '1,2', NULL, 2, '2017-09-04 09:23:55', '2017-09-04 11:23:55', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_images`
--
ALTER TABLE `document_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_logs`
--
ALTER TABLE `document_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_repositories`
--
ALTER TABLE `document_repositories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_images`
--
ALTER TABLE `document_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `document_logs`
--
ALTER TABLE `document_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `document_repositories`
--
ALTER TABLE `document_repositories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
