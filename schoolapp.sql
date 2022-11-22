-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2022 at 11:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `acad_year`
--

CREATE TABLE `acad_year` (
  `acad_year_id` int(11) NOT NULL,
  `acad_year_inputted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `acad_year` datetime NOT NULL,
  `close_acad_year` tinyint(4) DEFAULT 0,
  `closed_by` varchar(10) DEFAULT NULL,
  `re_open_by` varchar(10) DEFAULT NULL,
  `acad_year_inputted_by` varchar(10) NOT NULL,
  `acad_year_closed_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acad_year`
--

INSERT INTO `acad_year` (`acad_year_id`, `acad_year_inputted_at`, `acad_year`, `close_acad_year`, `closed_by`, `re_open_by`, `acad_year_inputted_by`, `acad_year_closed_status`) VALUES
(23, '2022-09-29 08:21:17', '2022-09-08 00:00:00', 0, 'MM2200', 'MM2200', '1', 0),
(25, '2022-10-21 09:47:42', '2021-09-08 00:00:00', 0, NULL, NULL, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `enroll_student`
--

CREATE TABLE `enroll_student` (
  `record_id` int(11) NOT NULL,
  `stud_id` varchar(25) NOT NULL,
  `stud_name` varchar(50) NOT NULL,
  `stud_parent_name` varchar(50) NOT NULL,
  `stud_parent_mobile` varchar(50) NOT NULL,
  `stud_prev_sch` varchar(200) DEFAULT NULL,
  `stud_address` varchar(75) DEFAULT NULL,
  `stud_gender` varchar(50) DEFAULT NULL,
  `stud_place_birth` varchar(100) DEFAULT NULL,
  `stud_date_brith` datetime DEFAULT NULL,
  `health_relate_problem` text DEFAULT NULL,
  `stud_enroll_yr` varchar(50) NOT NULL,
  `enroll_class` varchar(100) DEFAULT NULL,
  `stud_inputted_by` varchar(50) DEFAULT NULL,
  `stud_inputted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `stud_deleted_by` varchar(50) DEFAULT NULL,
  `stud_deleted_at` datetime DEFAULT NULL,
  `stud_prof_photo_url` text DEFAULT NULL,
  `enroll_done` tinyint(4) NOT NULL DEFAULT 0,
  `auth_enroll` tinyint(4) NOT NULL DEFAULT 0,
  `auth_enroll_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enroll_student`
--

INSERT INTO `enroll_student` (`record_id`, `stud_id`, `stud_name`, `stud_parent_name`, `stud_parent_mobile`, `stud_prev_sch`, `stud_address`, `stud_gender`, `stud_place_birth`, `stud_date_brith`, `health_relate_problem`, `stud_enroll_yr`, `enroll_class`, `stud_inputted_by`, `stud_inputted_at`, `stud_deleted_by`, `stud_deleted_at`, `stud_prof_photo_url`, `enroll_done`, `auth_enroll`, `auth_enroll_by`) VALUES
(2, '22001', 'Modou Lamin Marong', 'Daddy', '+2207690103', 'Soma Upper Basic', 'Brikama', '1', 'Manduar', '2022-09-08 00:00:00', 'no comment', '2022-09-08 00:00:00', '3', 'AB2202', '2022-09-29 09:42:15', NULL, NULL, 'photos/22001-afang-photo.PNG', 1, 1, NULL),
(3, '22002', 'Ebrima Dahaba', 'Daddy', '+2202638162', 'Soma Lower Basic', 'Brikama', '1', 'Manduar', '2022-03-30 00:00:00', 'no comment', '2022-09-08 00:00:00', '3', 'AB2202', '2022-09-29 16:15:10', NULL, NULL, 'photos/22002-Capture.PNG', 1, 0, NULL),
(6, '22003', 'test', 'test', '+2205823008', NULL, NULL, NULL, NULL, NULL, NULL, '2022-09-08 00:00:00', NULL, 'MM2200', '2022-10-03 00:17:36', NULL, NULL, NULL, 0, 0, NULL),
(7, '22004', 'student', 'test', '+2202638162', NULL, NULL, NULL, NULL, NULL, NULL, '2022-09-08 00:00:00', NULL, 'MM2200', '2022-10-03 14:27:00', NULL, NULL, NULL, 0, 0, NULL),
(8, '22005', 'Modou Lamin', 'Daddy', '+2202638162', NULL, NULL, NULL, NULL, NULL, NULL, '2022-09-08 00:00:00', NULL, 'MM2200', '2022-10-03 14:27:38', NULL, NULL, NULL, 0, 0, NULL),
(9, '22006', 'test', 'test', '+2205823008', 'school name', 'Manduar', '1', 'Brikama', '2022-09-29 00:00:00', 'good', '2022-09-08 00:00:00', '2', 'AB2202', '2022-10-05 13:48:09', NULL, NULL, 'photos/22006-Capture.PNG', 1, 1, NULL),
(10, '22007', 'name of the student', 'prev school', '+2205823008', 'prev school ', 'Manduar', '1', 'Brikama', '2022-09-28 00:00:00', 'some message', '2022-09-08 00:00:00', '2', 'AB2202', '2022-10-05 16:12:54', NULL, NULL, 'photos/22007-Capture.PNG', 1, 1, NULL),
(11, '22008', 'Kabba Sanneh', 'Bakary Darboe', '+2205823008', 'rev school ', 'adress', '1', 'place of birth', '2022-10-06 00:00:00', 'jhvnjdsvkvb vvbduivbv duvhjvf ', '2022-09-08 00:00:00', '1', 'AB2202', '2022-10-05 16:20:36', NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_class`
--

CREATE TABLE `school_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_name_figure` varchar(50) NOT NULL,
  `class_size` varchar(50) NOT NULL,
  `class_create_by` varchar(50) NOT NULL,
  `class_create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `class_isful` tinyint(4) NOT NULL DEFAULT 0,
  `class_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_class`
--

INSERT INTO `school_class` (`class_id`, `class_name`, `class_name_figure`, `class_size`, `class_create_by`, `class_create_at`, `class_isful`, `class_deleted`) VALUES
(2, 'Seven Circle', '7', '45', 'AM2004', '2022-10-07 15:29:33', 0, 0),
(3, 'Seven Square', '7 ', '40', 'AM2004', '2022-10-07 15:41:17', 0, 0),
(4, 'Eight Circle', '8', '35', 'AM2004', '2022-10-07 15:41:53', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sole_subject_user`
--

CREATE TABLE `sole_subject_user` (
  `record_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `subj_primary` varchar(50) NOT NULL,
  `subj_sec_1` varchar(50) NOT NULL,
  `subj_sec_2` varchar(50) NOT NULL,
  `subj_sec_3` varchar(50) NOT NULL,
  `subj_sec_4` varchar(50) NOT NULL,
  `inputted_by` varchar(50) NOT NULL,
  `inputted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deteted_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sole_subject_user`
--

INSERT INTO `sole_subject_user` (`record_id`, `user_name`, `subj_primary`, `subj_sec_1`, `subj_sec_2`, `subj_sec_3`, `subj_sec_4`, `inputted_by`, `inputted_at`, `deteted_by`, `deleted_at`, `deleted`) VALUES
(6, 'AB2202', 'CSCI07', 'AGS07', '', '', '', 'MM2200', '2022-10-17 15:44:43', NULL, NULL, 0),
(7, 'EB2203', 'MTH09', '', '', '', '', 'MM2200', '2022-10-17 17:21:37', NULL, NULL, 0),
(8, 'TU2206', 'CSCI07', 'LITE08', 'AGS07', '', '', 'MM2200', '2022-10-21 11:12:24', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stud_grades`
--

CREATE TABLE `stud_grades` (
  `record_id` int(11) NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `subj_code` varchar(50) NOT NULL,
  `grade_1` varchar(50) NOT NULL,
  `grade_2` varchar(50) NOT NULL,
  `grade_3` varchar(50) NOT NULL,
  `grade_4` varchar(50) NOT NULL,
  `stud_enroll_class` varchar(50) NOT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stud_grades`
--

INSERT INTO `stud_grades` (`record_id`, `stud_id`, `teacher_id`, `subj_code`, `grade_1`, `grade_2`, `grade_3`, `grade_4`, `stud_enroll_class`, `completed`) VALUES
(7, '22006', 'TU2206', 'CSCI07', '5', '2', '4', '', '2', 0),
(8, '22006', 'TU2206', 'AGS07', '25', '15', '40', '', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subj_id` int(11) NOT NULL,
  `subj_name` varchar(200) NOT NULL,
  `subj_code` varchar(100) NOT NULL,
  `subj_grade_level` tinyint(4) NOT NULL,
  `subj_status` tinyint(4) NOT NULL,
  `subj_period` varchar(50) NOT NULL,
  `inputted_by` varchar(100) NOT NULL,
  `inputted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subj_id`, `subj_name`, `subj_code`, `subj_grade_level`, `subj_status`, `subj_period`, `inputted_by`, `inputted_at`, `updated_by`, `updated_at`) VALUES
(4, 'Core Science', 'CSCI07', 7, 1, '10', 'MM2200', '2022-10-12 17:01:13', 'AB2202', '2022-10-28 19:57:36'),
(5, 'Literature in English', 'LITE08', 8, 1, '6', 'MM2200', '2022-10-13 11:17:00', 'AB2202', '2022-10-28 19:57:43'),
(6, 'Mathematics', 'MTH09', 9, 1, '8', 'MM2200', '2022-10-13 14:25:57', 'AB2202', '2022-10-28 19:57:47'),
(7, 'Agricultural Science', 'AGS07', 7, 1, '4', 'MM2200', '2022-10-14 13:09:16', 'AB2202', '2022-10-28 19:57:35'),
(8, 'Art and Craft', 'ATC07', 7, 1, '4', 'MM2200', '2022-10-14 13:36:19', 'AB2202', '2022-10-28 19:57:36'),
(9, 'Metal Work', 'MET07', 7, 1, '6', 'AB2202', '2022-10-28 17:57:21', 'AB2202', '2022-10-28 19:57:37'),
(10, 'Social Studies', 'SES07', 7, 1, '9', 'AB2202', '2022-10-31 13:22:15', '', NULL),
(11, 'Mathematics', 'MTH07', 7, 1, '6', 'AB2202', '2022-10-31 14:16:14', 'AB2202', '2022-10-31 15:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_name` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_role` varchar(75) DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT 2,
  `gender` varchar(10) DEFAULT NULL,
  `tele` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `address` varchar(15) DEFAULT NULL,
  `join_date` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `change_password` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `permission` tinyint(4) NOT NULL DEFAULT 1,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `user_name`, `password`, `user_role`, `user_type`, `gender`, `tele`, `mobile`, `address`, `join_date`, `last_login`, `change_password`, `status`, `permission`, `deleted`) VALUES
(1, 'Modou Lamin Marong', 'ml@gmail.com', 'MM2200', '$2y$10$eHwzhVzrHT8W0.nVx9B.3.WOt69Q.6TM0.CszH76YzhwSNPCAOeAu', '1', 1, '', NULL, NULL, NULL, '2022-09-27 12:23:32', '2022-10-31 09:54:53', 1, 0, 1, 0),
(2, 'Modou', NULL, 'MM2201', '$2y$10$ehDX50bBnINRdhAw9beF6OxwoVcWw9laj3WDFVbPhlmRAzJWLo2je', '1', 1, NULL, NULL, NULL, NULL, '2022-10-04 17:36:02', '2022-10-04 20:17:28', 1, 0, 1, 0),
(3, 'Amadou Bah', NULL, 'AB2202', '$2y$10$eNyqJx5hb./4E32INNo8t.Kj.CIMpyv0obe34aie8HrwE1uaeHvUy', '2', 2, NULL, NULL, NULL, NULL, '2022-10-05 09:13:01', '2022-11-22 10:19:35', 1, 0, 1, 0),
(4, 'Ebrima Dahaba', NULL, 'EB2203', '$2y$10$F0ygrH/BTsdjDr3Yt4dGx.xZCssRngarOSUQOzG5me2lAd1WExunG', '3', 2, NULL, NULL, NULL, NULL, '2022-10-05 09:14:23', '2022-10-24 10:17:38', 1, 0, 1, 0),
(5, 'admin', NULL, 'AM2204', '$2y$10$PXIj9MzR6y8n4YnoVHBGnO7Nv.RkA6qLE7y1QErgSvPCrmZcy8SHO', '1', 1, NULL, NULL, NULL, NULL, '2022-10-06 18:21:33', '2022-10-07 13:19:39', 1, 0, 1, 0),
(7, 'Financial user', NULL, 'FU2205', '$2y$10$RDde8RugQwWIjdRL7b0RDetk4F7jEIEbtDs6V1ER1bzfSotolIxaK', '4', 2, NULL, NULL, NULL, NULL, '2022-10-18 08:05:02', '2022-10-20 09:58:59', 1, 0, 1, 0),
(8, 'Teacher User', NULL, 'TU2206', '$2y$10$2oUkWThCHDOkLHYvc3QY5ehfE5pUvasztY.2gnZsxsm6ZWWgIbDjC', '5', 2, NULL, NULL, NULL, NULL, '2022-10-18 08:06:44', '2022-11-16 15:58:01', 1, 0, 1, 0),
(9, 'Principal User', NULL, 'PU2207', '$2y$10$wvn/5X691S5Msar3KUgimepCZjkgcma6f.hH18dpw36D5bsvt/Ohi', '3', 2, NULL, NULL, NULL, NULL, '2022-10-20 08:03:39', '2022-11-22 10:18:47', 1, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acad_year`
--
ALTER TABLE `acad_year`
  ADD PRIMARY KEY (`acad_year_id`);

--
-- Indexes for table `enroll_student`
--
ALTER TABLE `enroll_student`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `school_class`
--
ALTER TABLE `school_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `sole_subject_user`
--
ALTER TABLE `sole_subject_user`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `stud_grades`
--
ALTER TABLE `stud_grades`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subj_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acad_year`
--
ALTER TABLE `acad_year`
  MODIFY `acad_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `enroll_student`
--
ALTER TABLE `enroll_student`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `school_class`
--
ALTER TABLE `school_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sole_subject_user`
--
ALTER TABLE `sole_subject_user`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stud_grades`
--
ALTER TABLE `stud_grades`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
