-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 09:50 PM
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
-- Database: `vaccination`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_requests`
--

CREATE TABLE `booking_requests` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `vaccination_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_requests`
--

INSERT INTO `booking_requests` (`id`, `parent_id`, `child_id`, `hospital_id`, `vaccine_id`, `request_date`, `vaccination_date`, `status`) VALUES
(9, 2, 1, 5, 7, '2023-11-09', '2024-07-13', 'Vaccinated'),
(10, 2, 1, 6, 1, '2023-11-09', '2023-12-13', 'Appointment Done'),
(11, 2, 1, 5, 3, '2023-11-09', '2024-07-13', 'Not Vaccinated');

-- --------------------------------------------------------

--
-- Table structure for table `childs`
--

CREATE TABLE `childs` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `childs`
--

INSERT INTO `childs` (`id`, `parent_id`, `phone`, `name`, `dob`, `gender`, `address`) VALUES
(1, 2, 312531, 'Ubaid', '2022-10-13', 'male', 'pakistan karachi'),
(2, 2, 122544975, 'Akram', '2022-08-10', 'Male', 'Karachi, Pakistan'),
(3, 11, 32133212, 'wahab', '2023-01-25', 'Male', 'sindh, karachi\r\n'),
(4, 13, 3221342, 'samiii', '2022-05-05', 'male', 'karachi'),
(5, 14, 3313572, 'hamza', '2015-12-12', 'Male', 'karachi');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `hospital_id`, `number`, `address`, `description`, `status`) VALUES
(1, 5, 1229312, 'line 0 pakistan chowk korangiii', 'asd ada', 'Approved'),
(2, 6, 1229312, 'line 0 pakistan chowk korangiii', '', 'Approved'),
(3, 7, 1229312, 'line 0 pakistan chowk korangiii', '', 'Reject'),
(4, 8, 1229312, 'line 0 pakistan chowk korangiii', '', 'Approved'),
(5, 9, 1229312, 'line 0 pakistan chowk korangiii', '', 'Approved'),
(6, 10, 1229312, 'line 0 pakistan chowk korangiii', '', 'Pending'),
(7, 12, 31223312, 'phase 1 DHA karachi', 'availability of vaccination for all child  ', 'Pending'),
(8, 15, 1231233, 'karachi cant ', '...', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Parent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', 'Admin'),
(2, 'ali', 'ali@gmail.com', '123', 'Parent'),
(4, 'agha khan', 'agha@gmail.com', '123', 'Hospital'),
(5, 'Liaquat Hospital', 'liaquat@gmail.com', '123', 'Hospital'),
(6, 'Dow Hospital', 'dow@gmail.com', '123', 'Hospital'),
(7, 'Dow Hospital', 'dow@gmail.com', '123', 'Hospital'),
(8, 'Dow Hospital', 'dow@gmail.com', '123', 'Hospital'),
(9, 'Dow Hospital 11', 'dow1@gmail.com', '123', 'Hospital'),
(10, 'Dow Hospital', 'dow@gmail.com', '123', 'Hospital'),
(11, 'waleed', 'waleed@gmail.com', '123', 'Parent'),
(12, 'NMC', 'nmc@gmail.com', '123', 'hospital'),
(13, 'kamran', 'kamran@gmail.com', '123', 'Parent'),
(14, 'haq khan', 'haq@gmail.com', '123', 'Parent'),
(15, 'Jinnah', 'jinna@gmail.com', '123', 'hospital');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_reports`
--

CREATE TABLE `vaccination_reports` (
  `report_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `vaccinated_date` date NOT NULL DEFAULT current_timestamp(),
  `hospital_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccination_reports`
--

INSERT INTO `vaccination_reports` (`report_id`, `vaccine_id`, `child_id`, `parent_id`, `vaccinated_date`, `hospital_id`, `status`) VALUES
(1, 7, 1, 13, '2023-11-09', 5, 'Vaccinated'),
(2, 7, 1, 2, '2023-11-09', 5, 'Vaccinated'),
(3, 3, 1, 2, '2023-11-09', 6, 'Not Vaccinated'),
(4, 7, 1, 2, '2023-11-09', 5, 'Vaccinated'),
(5, 7, 1, 2, '2023-11-09', 5, 'Vaccinated');

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `availability` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `Vaccination_age` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id`, `name`, `hospital_id`, `availability`, `manufacturer`, `Vaccination_age`) VALUES
(1, 'Hepatitis A (HepA) vaccine', 6, 119, 'GlaxoSmithKline', '1 years, 2 months'),
(2, 'Hepatitis B (HepB) vaccine', 5, 7, 'GlaxoSmithKline ', '1 years, 3 months'),
(3, 'hiba khan', 5, 12, 'abc', '1 years, 9 months'),
(4, 'hiba khan', 2, 11, 'abc', '1 years, 9 months'),
(5, 'hiba khan', 5, 1, 'abc', '1 years, 9 months'),
(6, 'hiba khan', 2, 1, 'abc', '1 years, 9 months'),
(7, 'hadad', 5, 0, 'abc', '1 years, 9 months'),
(8, 'sfdasd', 1, 2, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_requests`
--
ALTER TABLE `booking_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `vaccine_id` (`vaccine_id`);

--
-- Indexes for table `childs`
--
ALTER TABLE `childs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `vaccination_reports_ibfk_4` (`vaccine_id`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccines_ibfk_1` (`hospital_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_requests`
--
ALTER TABLE `booking_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `childs`
--
ALTER TABLE `childs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_requests`
--
ALTER TABLE `booking_requests`
  ADD CONSTRAINT `booking_requests_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `childs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_requests_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_requests_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_requests_ibfk_4` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `childs`
--
ALTER TABLE `childs`
  ADD CONSTRAINT `childs_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD CONSTRAINT `hospitals_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccination_reports`
--
ALTER TABLE `vaccination_reports`
  ADD CONSTRAINT `vaccination_reports_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `childs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccination_reports_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccination_reports_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vaccination_reports_ibfk_4` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`);

--
-- Constraints for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD CONSTRAINT `vaccines_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
