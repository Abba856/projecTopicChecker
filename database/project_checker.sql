-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2025 at 08:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_checker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$iId9Jw7r9jDlhSYKyEP86OOD/X6kzXRNPUc8JDdag7RzKcjf0oe/O');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `c_id` int(11) NOT NULL,
  `c_nm` varchar(100) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_msg` text NOT NULL,
  `c_time` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `r_id` int(11) NOT NULL,
  `r_fnm` varchar(100) NOT NULL,
  `r_unm` varchar(50) NOT NULL,
  `r_pwd` varchar(255) NOT NULL,
  `r_cno` varchar(15) DEFAULT NULL,
  `r_email` varchar(100) DEFAULT NULL,
  `r_question` varchar(255) DEFAULT NULL,
  `r_answer` varchar(255) DEFAULT NULL,
  `r_time` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`r_id`, `r_fnm`, `r_unm`, `r_pwd`, `r_cno`, `r_email`, `r_question`, `r_answer`, `r_time`, `created_at`) VALUES
(1, 'ISAH ABDULLAHI ISAH', 'abba856', '12345678', '08167928397', 'eesabba856@gmail.com', 'Which is your Favourite Movie ?', 'ironman', 1757256166, '2025-09-07 14:42:46');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic_title` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL,
  `project_abstract` text DEFAULT NULL,
  `status` enum('available','taken','completed') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topic_title`, `comment`, `project_abstract`, `status`, `created_at`) VALUES
(251, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:14:12'),
(252, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:14:12'),
(253, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:14:12'),
(254, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:14:12'),
(255, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:14:12'),
(256, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:14:12'),
(257, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:14:12'),
(258, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:14:12'),
(259, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:14:12'),
(260, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:14:12'),
(261, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:14:12'),
(262, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:14:12'),
(263, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:14:12'),
(264, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:14:12'),
(265, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:14:12'),
(266, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:14:12'),
(267, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:14:12'),
(268, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:14:12'),
(269, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:14:12'),
(270, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:14:12'),
(271, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:14:12'),
(272, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:14:12'),
(273, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:14:12'),
(274, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:14:12'),
(275, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:14:12'),
(276, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:14:12'),
(277, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:14:12'),
(278, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:14:12'),
(279, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:14:12'),
(280, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:14:12'),
(281, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:14:12'),
(282, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:14:12'),
(283, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:14:12'),
(284, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:14:12'),
(285, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:14:12'),
(286, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:14:12'),
(287, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:14:12'),
(288, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:14:12'),
(289, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:14:12'),
(290, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:14:12'),
(291, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:14:12'),
(292, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:14:12'),
(293, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:14:12'),
(294, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:14:12'),
(295, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:14:12'),
(296, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:14:12'),
(297, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:14:12'),
(298, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:14:12'),
(299, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:14:12'),
(300, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:14:12'),
(301, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:18:57'),
(302, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:18:57'),
(303, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:18:57'),
(304, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:18:57'),
(305, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:18:57'),
(306, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:18:57'),
(307, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:18:57'),
(308, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:18:57'),
(309, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:18:57'),
(310, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:18:57'),
(311, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:18:57'),
(312, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:18:57'),
(313, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:18:57'),
(314, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:18:57'),
(315, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:18:57'),
(316, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:18:57'),
(317, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:18:57'),
(318, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:18:57'),
(319, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:18:57'),
(320, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:18:57'),
(321, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:18:57'),
(322, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:18:57'),
(323, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:18:57'),
(324, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:18:57'),
(325, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:18:57'),
(326, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:18:57'),
(327, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:18:57'),
(328, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:18:57'),
(329, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:18:57'),
(330, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:18:57'),
(331, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:18:57'),
(332, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:18:57'),
(333, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:18:57'),
(334, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:18:57'),
(335, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:18:57'),
(336, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:18:57'),
(337, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:18:57'),
(338, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:18:57'),
(339, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:18:57'),
(340, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:18:57'),
(341, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:18:57'),
(342, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:18:57'),
(343, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:18:57'),
(344, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:18:57'),
(345, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:18:57'),
(346, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:18:57'),
(347, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:18:57'),
(348, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:18:57'),
(349, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:18:57'),
(350, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:18:57'),
(351, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:23:00'),
(352, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:23:00'),
(353, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:23:00'),
(354, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:23:00'),
(355, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:23:00'),
(356, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:23:00'),
(357, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:23:00'),
(358, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:23:00'),
(359, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:23:00'),
(360, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:23:00'),
(361, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:23:00'),
(362, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:23:00'),
(363, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:23:00'),
(364, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:23:00'),
(365, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:23:00'),
(366, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:23:00'),
(367, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:23:00'),
(368, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:23:00'),
(369, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:23:00'),
(370, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:23:00'),
(371, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:23:00'),
(372, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:23:00'),
(373, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:23:00'),
(374, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:23:00'),
(375, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:23:00'),
(376, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:23:00'),
(377, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:23:00'),
(378, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:23:00'),
(379, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:23:00'),
(380, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:23:00'),
(381, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:23:00'),
(382, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:23:00'),
(383, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:23:00'),
(384, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:23:00'),
(385, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:23:00'),
(386, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:23:00'),
(387, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:23:00'),
(388, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:23:00'),
(389, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:23:00'),
(390, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:23:00'),
(391, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:23:00'),
(392, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:23:00'),
(393, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:23:00'),
(394, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:23:00'),
(395, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:23:00'),
(396, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:23:00'),
(397, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:23:00'),
(398, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:23:00'),
(399, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:23:00'),
(400, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:23:00'),
(401, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:31:16'),
(402, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:31:16'),
(403, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:31:16'),
(404, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:31:16'),
(405, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:31:16'),
(406, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:31:16'),
(407, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:31:16'),
(408, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:31:16'),
(409, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:31:16'),
(410, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:31:16'),
(411, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:31:16'),
(412, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:31:16'),
(413, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:31:16'),
(414, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:31:16'),
(415, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:31:16'),
(416, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:31:16'),
(417, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:31:16'),
(418, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:31:16'),
(419, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:31:16'),
(420, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:31:16'),
(421, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:31:16'),
(422, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:31:16'),
(423, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:31:16'),
(424, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:31:16'),
(425, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:31:16'),
(426, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:31:16'),
(427, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:31:16'),
(428, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:31:16'),
(429, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:31:16'),
(430, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:31:16'),
(431, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:31:16'),
(432, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:31:16'),
(433, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:31:16'),
(434, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:31:16'),
(435, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:31:16'),
(436, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:31:16'),
(437, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:31:16'),
(438, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:31:16'),
(439, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:31:16'),
(440, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:31:16'),
(441, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:31:16'),
(442, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:31:16'),
(443, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:31:16'),
(444, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:31:16'),
(445, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:31:16'),
(446, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:31:16'),
(447, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:31:16'),
(448, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:31:16'),
(449, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:31:16'),
(450, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:31:16'),
(451, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:40:23'),
(452, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:40:23'),
(453, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:40:23'),
(454, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:40:23'),
(455, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:40:23'),
(456, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:40:23'),
(457, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:40:23'),
(458, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:40:23'),
(459, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:40:23'),
(460, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:40:23'),
(461, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:40:23'),
(462, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:40:23'),
(463, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:40:23'),
(464, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:40:23'),
(465, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:40:23'),
(466, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:40:23'),
(467, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:40:23'),
(468, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:40:23'),
(469, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:40:23'),
(470, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:40:23'),
(471, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:40:23'),
(472, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:40:23'),
(473, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:40:23'),
(474, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:40:23'),
(475, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:40:23'),
(476, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:40:23'),
(477, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:40:23'),
(478, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:40:23'),
(479, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:40:23'),
(480, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:40:23'),
(481, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:40:23'),
(482, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:40:23'),
(483, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:40:23'),
(484, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:40:23'),
(485, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:40:23'),
(486, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:40:23'),
(487, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:40:23'),
(488, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:40:23'),
(489, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:40:23'),
(490, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:40:23'),
(491, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:40:23'),
(492, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:40:23'),
(493, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:40:23'),
(494, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:40:23'),
(495, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:40:23'),
(496, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:40:23'),
(497, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:40:23'),
(498, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:40:23'),
(499, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:40:23'),
(500, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:40:23'),
(501, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:44:57'),
(502, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:44:57'),
(503, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:44:57'),
(504, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:44:57'),
(505, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:44:57'),
(506, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:44:57'),
(507, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:44:57'),
(508, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:44:57'),
(509, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:44:57'),
(510, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:44:57'),
(511, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:44:57'),
(512, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:44:57'),
(513, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:44:57'),
(514, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:44:57'),
(515, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:44:57'),
(516, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:44:57'),
(517, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:44:57'),
(518, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:44:57'),
(519, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:44:57'),
(520, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:44:57'),
(521, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:44:57'),
(522, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:44:57'),
(523, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:44:57'),
(524, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:44:57'),
(525, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:44:57'),
(526, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:44:57'),
(527, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:44:57'),
(528, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:44:57'),
(529, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:44:57'),
(530, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:44:57'),
(531, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:44:57'),
(532, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:44:57'),
(533, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:44:57'),
(534, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:44:57'),
(535, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:44:57'),
(536, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:44:57'),
(537, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:44:57'),
(538, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:44:57'),
(539, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:44:57'),
(540, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:44:57'),
(541, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:44:57'),
(542, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:44:57'),
(543, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:44:57'),
(544, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:44:57'),
(545, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:44:57'),
(546, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:44:57'),
(547, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:44:57'),
(548, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:44:57'),
(549, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:44:57'),
(550, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:44:57'),
(551, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:51:35'),
(552, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:51:35'),
(553, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:51:35'),
(554, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:51:35'),
(555, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:51:35'),
(556, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:51:35'),
(557, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:51:35'),
(558, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:51:35'),
(559, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:51:35'),
(560, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:51:35'),
(561, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:51:35'),
(562, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:51:35'),
(563, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:51:35'),
(564, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:51:35'),
(565, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:51:35'),
(566, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:51:35'),
(567, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:51:35'),
(568, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:51:35'),
(569, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:51:35'),
(570, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:51:35'),
(571, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:51:35'),
(572, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:51:35'),
(573, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:51:35'),
(574, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:51:35'),
(575, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:51:35'),
(576, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:51:35'),
(577, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:51:35'),
(578, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:51:35'),
(579, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:51:35'),
(580, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:51:35'),
(581, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:51:35'),
(582, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:51:35');
INSERT INTO `topics` (`id`, `topic_title`, `comment`, `project_abstract`, `status`, `created_at`) VALUES
(583, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:51:35'),
(584, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:51:35'),
(585, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:51:35'),
(586, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:51:35'),
(587, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:51:35'),
(588, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:51:35'),
(589, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:51:35'),
(590, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:51:35'),
(591, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:51:35'),
(592, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:51:35'),
(593, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:51:35'),
(594, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:51:35'),
(595, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:51:35'),
(596, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:51:35'),
(597, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:51:35'),
(598, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:51:35'),
(599, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:51:35'),
(600, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:51:35'),
(601, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 16:55:35'),
(602, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 16:55:35'),
(603, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 16:55:35'),
(604, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 16:55:35'),
(605, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 16:55:35'),
(606, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 16:55:35'),
(607, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 16:55:35'),
(608, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 16:55:35'),
(609, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 16:55:35'),
(610, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 16:55:35'),
(611, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 16:55:35'),
(612, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 16:55:35'),
(613, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 16:55:35'),
(614, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 16:55:35'),
(615, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 16:55:35'),
(616, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 16:55:35'),
(617, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 16:55:35'),
(618, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 16:55:35'),
(619, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 16:55:35'),
(620, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 16:55:35'),
(621, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 16:55:35'),
(622, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 16:55:35'),
(623, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 16:55:35'),
(624, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 16:55:35'),
(625, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 16:55:35'),
(626, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 16:55:35'),
(627, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 16:55:35'),
(628, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 16:55:35'),
(629, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 16:55:35'),
(630, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 16:55:35'),
(631, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 16:55:35'),
(632, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 16:55:35'),
(633, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 16:55:35'),
(634, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 16:55:35'),
(635, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 16:55:35'),
(636, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 16:55:35'),
(637, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 16:55:35'),
(638, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 16:55:35'),
(639, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 16:55:35'),
(640, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 16:55:35'),
(641, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 16:55:35'),
(642, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 16:55:35'),
(643, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 16:55:35'),
(644, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 16:55:35'),
(645, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 16:55:35'),
(646, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 16:55:35'),
(647, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 16:55:35'),
(648, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 16:55:35'),
(649, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 16:55:35'),
(650, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available', '2025-09-07 16:55:35'),
(651, 'Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available', '2025-09-07 17:09:24'),
(652, 'School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available', '2025-09-07 17:09:24'),
(653, 'Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available', '2025-09-07 17:09:24'),
(654, 'Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available', '2025-09-07 17:09:24'),
(655, 'Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available', '2025-09-07 17:09:24'),
(656, 'Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available', '2025-09-07 17:09:24'),
(657, 'Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available', '2025-09-07 17:09:24'),
(658, 'Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available', '2025-09-07 17:09:24'),
(659, 'Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available', '2025-09-07 17:09:24'),
(660, 'Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available', '2025-09-07 17:09:24'),
(661, 'Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available', '2025-09-07 17:09:24'),
(662, 'Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available', '2025-09-07 17:09:24'),
(663, 'Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available', '2025-09-07 17:09:24'),
(664, 'Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available', '2025-09-07 17:09:24'),
(665, 'Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available', '2025-09-07 17:09:24'),
(666, 'Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available', '2025-09-07 17:09:24'),
(667, 'Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available', '2025-09-07 17:09:24'),
(668, 'Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available', '2025-09-07 17:09:24'),
(669, 'Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available', '2025-09-07 17:09:24'),
(670, 'Image Editor', 'Image Editor', 'An online image editing platform.', 'available', '2025-09-07 17:09:24'),
(671, 'Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available', '2025-09-07 17:09:24'),
(672, 'College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available', '2025-09-07 17:09:24'),
(673, 'PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available', '2025-09-07 17:09:24'),
(674, 'Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available', '2025-09-07 17:09:24'),
(675, 'Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available', '2025-09-07 17:09:24'),
(676, 'Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available', '2025-09-07 17:09:24'),
(677, 'Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available', '2025-09-07 17:09:24'),
(678, 'Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available', '2025-09-07 17:09:24'),
(679, 'Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available', '2025-09-07 17:09:24'),
(680, 'Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available', '2025-09-07 17:09:24'),
(681, 'Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available', '2025-09-07 17:09:24'),
(682, 'Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available', '2025-09-07 17:09:24'),
(683, 'Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available', '2025-09-07 17:09:24'),
(684, 'Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available', '2025-09-07 17:09:24'),
(685, 'PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available', '2025-09-07 17:09:24'),
(686, 'Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available', '2025-09-07 17:09:24'),
(687, 'Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available', '2025-09-07 17:09:24'),
(688, 'Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available', '2025-09-07 17:09:24'),
(689, 'Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available', '2025-09-07 17:09:24'),
(690, 'Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available', '2025-09-07 17:09:24'),
(691, 'Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available', '2025-09-07 17:09:24'),
(692, 'Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available', '2025-09-07 17:09:24'),
(693, 'Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available', '2025-09-07 17:09:24'),
(694, 'E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available', '2025-09-07 17:09:24'),
(695, 'Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available', '2025-09-07 17:09:24'),
(696, 'Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available', '2025-09-07 17:09:24'),
(697, 'Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available', '2025-09-07 17:09:24'),
(698, 'Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available', '2025-09-07 17:09:24'),
(699, 'University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available', '2025-09-07 17:09:24'),
(700, 'Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'completed', '2025-09-07 17:09:24'),
(701, 'isah sajsd jajasj jdasjajk jaj', 'this has not duplicat', 'adjdj jkadjak jdjks adasj jakldhajhk jkdlajkakl jajhkdjhajkd jkajlkdsajkd jkadjkjksajk jkaljdkaj jhajhdhjah jajhdhjlajdh hjdajhdh hdajhjhdshd', 'available', '2025-09-07 18:38:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `a_unm` (`username`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`r_id`),
  ADD UNIQUE KEY `r_unm` (`r_unm`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=702;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
