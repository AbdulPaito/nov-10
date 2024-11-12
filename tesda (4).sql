-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 10:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tesda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username_admin`, `password_admin`, `email_admin`, `role`) VALUES
(3, 'admin', 'admin', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `birth_information`
--

CREATE TABLE `birth_information` (
  `user_id` int(11) NOT NULL,
  `birthplace_city_municipality` varchar(100) DEFAULT NULL,
  `birthplace_province` varchar(100) DEFAULT NULL,
  `birthplace_region` varchar(100) DEFAULT NULL,
  `uli_number` varchar(255) DEFAULT NULL,
  `entry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `birth_information`
--

INSERT INTO `birth_information` (`user_id`, `birthplace_city_municipality`, `birthplace_province`, `birthplace_region`, `uli_number`, `entry_date`) VALUES
(3, 'Arayat', 'Pampanga', 'Region 4', '1234', '2024-11-05'),
(4, 'Arenas', 'Nueva Ecija', 'Region 2', '1231123', '2024-11-10'),
(5, 'Arayat', 'Pampanga', 'Region 3', '1234', '2024-11-11'),
(6, 'Batasan', 'Pampanga', 'Region 7', '123', '2024-11-11'),
(7, 'Gatiawin', 'Pampanga', 'Region 4', '1234', '2024-11-11'),
(8, 'Baliti', 'Pampanga', 'Region 9', '1231123', '2024-11-11'),
(9, 'Arayat', 'Pampanga', 'Region 9', '1231123', '2024-11-11'),
(11, 'Batasan', 'Pampanga', 'Region 6', '1231123', '2024-11-12');

-- --------------------------------------------------------

--
-- Table structure for table `contact_information`
--

CREATE TABLE `contact_information` (
  `user_id` int(11) NOT NULL,
  `address_number_street` varchar(100) DEFAULT NULL,
  `address_barangay` varchar(100) DEFAULT NULL,
  `address_district` varchar(100) DEFAULT NULL,
  `address_city_municipality` varchar(100) DEFAULT NULL,
  `address_province` varchar(100) DEFAULT NULL,
  `address_region` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email_facebook` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_information`
--

INSERT INTO `contact_information` (`user_id`, `address_number_street`, `address_barangay`, `address_district`, `address_city_municipality`, `address_province`, `address_region`, `contact_no`, `email_facebook`) VALUES
(3, 'Street 2', 'Baliti', 'District 3', 'Arayat', 'Pampanga', 'Region 2', '090061636350', 'abdulpaito4@gmail.com'),
(4, 'Street 2', 'Ayala', 'District 3', 'Magalang', 'Pampanga', 'Region 2', '0909124214', 'abdulpaito@gmail.com'),
(5, 'Street 2', 'Arenas', 'District 3', 'Arayat', 'Pampanga', 'Region 5', '0909124214', 'abdulpaito@gmail.com'),
(6, 'Street 2', 'Arenas', 'District 2', 'Arayat', 'Pampanga', 'Region 2', '0909124214', 'abdulpaito@gmail.com'),
(7, 'Street 4', 'Bunga', 'District 6', 'San Vicente', 'Nueva Ecija', 'Region 6', '0909124214', 'abdulpaito@gmail.com'),
(8, 'Street 7', 'Dalan Bago', 'District 6', 'San Vicente', 'Nueva Ecija', 'Region 8', '0909124214', 'abdulpaito@gmail.com'),
(9, 'Street 3', 'Santo Niño Tabuan', 'District 11', 'Arayat', 'Pampanga', 'Region 13', '09090834235', 'ABULPAITO2@GMAIL.COM'),
(11, 'Street 8', 'Buensuceso', 'District 3', 'Arayat', 'Pampanga', 'Region 7', '090061636350', 'abdulpaito1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `disability_information`
--

CREATE TABLE `disability_information` (
  `user_id` int(11) NOT NULL,
  `disability` varchar(100) DEFAULT NULL,
  `cause_of_disability` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disability_information`
--

INSERT INTO `disability_information` (`user_id`, `disability`, `cause_of_disability`) VALUES
(3, 'Mental/Intellectual', 'Congenital/Inborn'),
(4, 'Mental/Intellectual', 'Congenital/Inborn'),
(5, 'Mental/Intellectual', 'Congenital/Inborn'),
(6, 'Mental/Intellectual', 'Congenital/Inborn'),
(7, 'Orthopedic (Musculoskeletal) Disability', 'Illness'),
(8, 'Mental/Intellectual', 'Congenital/Inborn'),
(9, 'N/A', 'N/A'),
(11, 'Orthopedic (Musculoskeletal) Disability', 'Injury');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `user_id` int(11) NOT NULL,
  `educational_attainment` varchar(100) DEFAULT NULL,
  `classification` varchar(100) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `scholarship` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`user_id`, `educational_attainment`, `classification`, `qualification`, `scholarship`) VALUES
(3, 'college_graduate_or_higher', 'Family Enterprises', 'Food and Beverage Service NC II', 'TWSP'),
(4, 'pre_school', 'Students', 'Food and Beverage Service NC II', 'PESFA'),
(5, 'college_graduate_or_higher', 'Students', 'Food and Beverage Service NC II', 'PESFA'),
(6, 'post_secondary_undergraduate', 'Students', 'Food and Beverage Service NC II', 'PESFA'),
(7, 'pre_school', 'Students', 'Food and Beverage Service NC II', 'PESFA'),
(8, 'elementary_graduate', 'Displaced Workers', 'SMAW NC I and SMAW NC II', 'PESFA'),
(9, 'college_graduate_or_higher', 'Students', 'Housekeeping NC II', 'PESFA'),
(11, 'post_secondary_undergraduate', 'Displaced Workers', 'Cookery NC II', 'PESFA');

-- --------------------------------------------------------

--
-- Table structure for table `guardian_information`
--

CREATE TABLE `guardian_information` (
  `user_id` int(11) NOT NULL,
  `parent_guardian_name` varchar(100) DEFAULT NULL,
  `parent_guardian_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardian_information`
--

INSERT INTO `guardian_information` (`user_id`, `parent_guardian_name`, `parent_guardian_address`) VALUES
(3, 'Abdul paito', 'Tabuan arayaat pampanga'),
(4, 'Abdul paito', 'abdulpaito@gmail.com'),
(5, 'Abdul paito', 'abdulpaito@gmail.com'),
(6, 'Abdul paito', 'abdulpaito@gmail.com'),
(7, 'Abdul paito', 'abdulpaito@gmail.com'),
(8, 'Abdul paito', 'abdulpaito@gmail.com'),
(9, 'ABDUL PAITO', 'TABUAN ARAYAT PAMPANGA'),
(11, 'Abdul paito', 'abdulpaito@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ncae_information`
--

CREATE TABLE `ncae_information` (
  `user_id` int(11) NOT NULL,
  `taken_ncae` varchar(10) DEFAULT NULL,
  `where_ncae` varchar(100) DEFAULT NULL,
  `when_ncae` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ncae_information`
--

INSERT INTO `ncae_information` (`user_id`, `taken_ncae`, `where_ncae`, `when_ncae`) VALUES
(3, 'Yes', 'N/A', 'N/A'),
(4, 'No', '', ''),
(5, 'No', 'N/A', 'N/A'),
(6, 'No', 'n/a', 'n/a'),
(7, 'No', 'N/A', 'N/A'),
(8, 'No', 'N/A', 'N/A'),
(9, 'No', 'N/A', 'N/A'),
(11, 'No', 'n/a', 'n/a');

-- --------------------------------------------------------

--
-- Table structure for table `personal_information`
--

CREATE TABLE `personal_information` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `sex` enum('Male','Female','Other') DEFAULT NULL,
  `civil_status` enum('Single','Married','Divorced','Widowed') DEFAULT NULL,
  `employment_status` varchar(100) DEFAULT NULL,
  `month_of_birth` varchar(20) DEFAULT NULL,
  `day_of_birth` tinyint(4) DEFAULT NULL,
  `year_of_birth` smallint(6) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_information`
--

INSERT INTO `personal_information` (`user_id`, `first_name`, `last_name`, `middle_name`, `nationality`, `sex`, `civil_status`, `employment_status`, `month_of_birth`, `day_of_birth`, `year_of_birth`, `age`) VALUES
(3, 'Abdul Rahman', 'Paito', 'David', 'Filipino', 'Male', 'Single', 'employed', '05', 21, 2003, 21),
(4, 'Abdul Rahman', 'Paito', 'David', 'Japanese', 'Male', 'Single', 'employed', '01', 2, 1925, 99),
(5, 'Abdul Rahman', 'Paito', 'David', 'Filipino', 'Male', 'Single', 'employed', '05', 21, 2003, 21),
(6, 'Abdul Rahman', 'Paito', 'David', 'Filipino', 'Male', 'Single', 'employed', '01', 9, 1927, 97),
(7, 'Abdul Rahman', 'Paito', 'David', 'British', 'Male', 'Single', 'employed', '04', 4, 1927, 97),
(8, 'ABDUL', 'DAVID', 'PAITO', 'Filipino', 'Male', 'Single', 'employed', '02', 4, 1939, 85),
(9, 'ABDUL DAVID ', 'PAITO', 'DAVID', 'Korean', 'Male', 'Single', 'employed', '07', 5, 1987, 37),
(11, 'paito', 'DAVID', 'abdul', 'Australian', 'Male', 'Single', 'employed', '07', 3, 1979, 45);

-- --------------------------------------------------------

--
-- Table structure for table `profile_images`
--

CREATE TABLE `profile_images` (
  `user_id` int(11) NOT NULL,
  `imageUpload` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_images`
--

INSERT INTO `profile_images` (`user_id`, `imageUpload`, `profile_image`) VALUES
(3, 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg', 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg'),
(4, 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg', 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg'),
(5, 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg', 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg'),
(6, 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg', 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg'),
(7, 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg', 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg'),
(8, 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg', 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg'),
(9, 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg', 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg'),
(11, 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg', 'Upload-image/PICTURE.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration_details`
--

CREATE TABLE `registration_details` (
  `user_id` int(11) NOT NULL,
  `privacy_disclaimer` text DEFAULT NULL,
  `applicant_signature` varchar(255) DEFAULT NULL,
  `registrar_signature` varchar(255) DEFAULT NULL,
  `date_accomplished` varchar(20) DEFAULT NULL,
  `date_received` varchar(20) DEFAULT NULL,
  `registration_complete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_details`
--

INSERT INTO `registration_details` (`user_id`, `privacy_disclaimer`, `applicant_signature`, `registrar_signature`, `date_accomplished`, `date_received`, `registration_complete`) VALUES
(3, 'Agree', 'abdul', 'registration', 'abdul', 'abdul', 1),
(4, 'Agree', 'abdul', 'registration', 'abdul', 'abdul', 1),
(5, 'Agree', 'abdul', 'registration', '07-17-2024', '07-17-2024', 1),
(6, 'Agree', 'abdul', 'registration', 'abdul', '07-17-2024', 1),
(7, 'Agree', 'abdul', 'registration', '07-17-2024', '07-17-2024', 1),
(8, 'Agree', 'abdul', 'registration', '07-17-2024', '07-17-2024', 1),
(9, 'Agree', 'ABDUL PAITO', 'ABDUL', '07-17-2024', '07-17-2024', 1),
(11, 'Agree', 'abdul', 'Registrar', '07-17-2024', '07-17-2024', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('Enroll','Graduate','Drop','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `status`) VALUES
(3, 'abdul', '12', 'abdulpaito21@gmail.com', 'Enroll'),
(4, 'abdul2', 'abdul', 'abdulpaito221@gmail.com', 'Graduate'),
(5, 'abdul1', '123', 'abdulpaito2@gmail.com', 'Enroll'),
(6, 'abdul4', '123', 'abdulpaito212@gmail.com', 'Graduate'),
(7, 'Abdul123', 'abdul', 'abdulpaito123@gmail.com', 'Enroll'),
(8, 'abdul44', '123', 'abdulpaito214@gmail.com', 'Enroll'),
(9, 'abdul7', '123', 'abdulpaito7@gmail.com', 'Graduate'),
(11, 'abdul213', 'abdul', 'abdulpaito421@gmail.com', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username_admin` (`username_admin`);

--
-- Indexes for table `birth_information`
--
ALTER TABLE `birth_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `contact_information`
--
ALTER TABLE `contact_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `disability_information`
--
ALTER TABLE `disability_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `guardian_information`
--
ALTER TABLE `guardian_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ncae_information`
--
ALTER TABLE `ncae_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `profile_images`
--
ALTER TABLE `profile_images`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `registration_details`
--
ALTER TABLE `registration_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `birth_information`
--
ALTER TABLE `birth_information`
  ADD CONSTRAINT `birth_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_information`
--
ALTER TABLE `contact_information`
  ADD CONSTRAINT `contact_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `disability_information`
--
ALTER TABLE `disability_information`
  ADD CONSTRAINT `disability_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `guardian_information`
--
ALTER TABLE `guardian_information`
  ADD CONSTRAINT `guardian_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `ncae_information`
--
ALTER TABLE `ncae_information`
  ADD CONSTRAINT `ncae_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD CONSTRAINT `personal_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `profile_images`
--
ALTER TABLE `profile_images`
  ADD CONSTRAINT `profile_images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `registration_details`
--
ALTER TABLE `registration_details`
  ADD CONSTRAINT `registration_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
