-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 09:59 AM
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
  `id` int(11) NOT NULL,
  `username_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username_admin`, `password_admin`, `email_admin`, `role`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'admin');

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
(1, 'Arayat', 'Pampanga', 'Region 4', '1234', '2024-11-05');

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
(1, 'Street 1', 'Santo Niño Tabuan', 'District 1', 'Arayat', 'Pampanga', 'Region 2', '090061636350', 'abdulpaito4@gmail.com');

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
(1, 'Mental/Intellectual', 'Congenital/Inborn');

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
(1, 'college_graduate_or_higher', 'Family Enterprises', 'Food and Beverage Service NC II', 'TWSP');

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
(1, 'Abdul paito', 'Tabuan arayaat pampanga');

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
(1, 'Yes', 'N/A', 'N/A');

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
(1, 'Abdul Rahman', 'Paito', 'David', 'Filipino', 'Male', 'Single', 'employed', '05', 21, 2003, 21);

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
(1, 'Upload-image/434360384_2401854799997936_6939150835498329161_n.jpg', 'Upload-image/460153094_2528537170663031_2993879615261525079_n.jpg');

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
(1, 'Agree', 'abdul', 'registration', 'abdul', 'abdul', 1);

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
(1, 'abdul', '123', 'abdulpaito21@gmail.com', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
