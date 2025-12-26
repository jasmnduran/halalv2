-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 09:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hdi_certification`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `app_code` varchar(50) NOT NULL,
  `applicant_user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` text DEFAULT NULL,
  `permit_license` varchar(255) DEFAULT NULL,
  `date_issued` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `manufacturing_type` varchar(20) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `submitted_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_documents`
--

CREATE TABLE `application_documents` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `certifier_status` varchar(50) DEFAULT NULL,
  `certifier_remarks` text DEFAULT NULL,
  `inspector_verification` varchar(50) DEFAULT NULL,
  `inspector_notes` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_schedules`
--

CREATE TABLE `inspection_schedules` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `inspector_user_id` int(11) DEFAULT NULL,
  `created_by_user_id` int(11) DEFAULT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_time` time DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `related_app_code` varchar(50) DEFAULT NULL,
  `data` longtext DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `storage_key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `storage_key`, `value`, `updated_at`) VALUES
(2, 'applications', '[]', '2025-12-25 11:48:08'),
(8, 'inspectionSchedules', '[{\"appId\":\"APP2025-127\",\"company\":\"CarloandCarla store\",\"address\":\"Sirawan\",\"date\":\"2026-03-21\",\"time\":\"14:30\",\"inspector\":\"Dr. Maryam A. Salam\",\"notes\":\"check\",\"createdDate\":\"2025-12-19T03:48:42.824Z\",\"createdBy\":\"Dr. Rahim S. Udzaman\",\"status\":\"pending\"}]', '2025-12-19 03:48:42'),
(11, 'applicantNotifications', '[{\"id\":\"notif_1766116087841\",\"type\":\"review_update\",\"appId\":\"APP2025-127\",\"title\":\"Review completed for #APP2025-127\",\"message\":\"12 compliant · 2 pending · 1 non-compliant\",\"summary\":{\"compliant\":12,\"nonCompliant\":1,\"pending\":2},\"notes\":\"check mader\",\"documents\":{\"Business Permit\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"License to Operate\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Mayor\'s Permit\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Barangay Permit\":{\"certifierStatus\":\"pending\",\"conformity\":\"pending\",\"remarks\":\"blurry\",\"verification\":\"pending\"},\"FDA CPR of Products\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"DTI License\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Sanitary Permit\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Fire Clearance Permit\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Environment Certificate (DENR)\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"GMP, HACCP, ISO Certificate (if any)\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Packaging Halal Certificate\":{\"certifierStatus\":\"non-compliant\",\"conformity\":\"non-compliant\",\"remarks\":\"outdated\",\"verification\":\"pending\"},\"Warehouse Halal Certificate\":{\"certifierStatus\":\"pending\",\"conformity\":\"pending\",\"remarks\":\"blurry\",\"verification\":\"pending\"},\"Matrix of Raw Materials\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Halal Certificate of Raw Materials\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"},\"Previous Halal Certificate (HDIP)\":{\"certifierStatus\":\"compliant\",\"conformity\":\"compliant\",\"remarks\":\"\",\"verification\":\"pending\"}},\"createdDate\":\"2025-12-19T03:48:07.841Z\",\"read\":true}]', '2025-12-19 05:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `provider` varchar(50) NOT NULL DEFAULT 'local',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_code` (`app_code`),
  ADD KEY `fk_applications_applicant` (`applicant_user_id`);

--
-- Indexes for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_docs_application` (`application_id`);

--
-- Indexes for table `inspection_schedules`
--
ALTER TABLE `inspection_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sched_application` (`application_id`),
  ADD KEY `fk_sched_inspector` (`inspector_user_id`),
  ADD KEY `fk_sched_creator` (`created_by_user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`user_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `storage_key` (`storage_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_documents`
--
ALTER TABLE `application_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inspection_schedules`
--
ALTER TABLE `inspection_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_applications_applicant` FOREIGN KEY (`applicant_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD CONSTRAINT `fk_app_docs_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inspection_schedules`
--
ALTER TABLE `inspection_schedules`
  ADD CONSTRAINT `fk_sched_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sched_creator` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sched_inspector` FOREIGN KEY (`inspector_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
