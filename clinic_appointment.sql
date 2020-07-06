-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2020 at 11:11 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_token` varchar(255) NOT NULL,
  `admin_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_pass`, `admin_email`, `admin_token`, `admin_registered`) VALUES
(1, 'Admin', '3cVaxePSLtU0JOrUNCgvbxFaSMgH9+lJSOZCR1DHfnSMUo4LNff3bMwLqCg5PS4j', 'admin@admin.com', '1488714734152752384749', '2020-01-15 03:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `ann_id` int(11) NOT NULL,
  `ann_title` varchar(255) NOT NULL,
  `ann_content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `app_id` int(11) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` varchar(255) NOT NULL,
  `treatment_type` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1: Confirm, 0: Not Confirm',
  `consult_status` int(11) NOT NULL COMMENT '1: Visited 0: None',
  `arrive_status` int(11) NOT NULL COMMENT '1: Arrived 0: None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `business_hour`
--

CREATE TABLE `business_hour` (
  `businesshour_id` int(11) NOT NULL,
  `open_week` varchar(255) NOT NULL,
  `close_week` varchar(255) NOT NULL,
  `open_sat` varchar(255) NOT NULL,
  `close_sat` varchar(255) NOT NULL,
  `open_sun` varchar(255) NOT NULL,
  `close_sun` varchar(255) NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `clinic_id` int(11) NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `clinic_email` varchar(255) NOT NULL,
  `clinic_url` varchar(255) NOT NULL,
  `clinic_contact` varchar(15) NOT NULL,
  `clinic_address` varchar(255) NOT NULL,
  `clinic_city` varchar(255) NOT NULL,
  `clinic_state` varchar(255) NOT NULL,
  `clinic_zipcode` varchar(10) NOT NULL,
  `clinic_status` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_images`
--

CREATE TABLE `clinic_images` (
  `clinicimg_id` int(11) NOT NULL,
  `clinicimg_filename` varchar(255) NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_manager`
--

CREATE TABLE `clinic_manager` (
  `clinicadmin_id` int(11) NOT NULL,
  `clinicadmin_name` varchar(255) NOT NULL,
  `clinicadmin_password` varchar(255) NOT NULL,
  `clinicadmin_token` varchar(255) NOT NULL,
  `clinicadmin_email` varchar(255) NOT NULL,
  `clinicadmin_contact` varchar(15) NOT NULL,
  `date_created` datetime NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_reset`
--

CREATE TABLE `clinic_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) NOT NULL,
  `reset_selector` text NOT NULL,
  `reset_token` longtext NOT NULL,
  `reset_expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_avatar` varchar(255) NOT NULL,
  `doctor_firstname` varchar(255) NOT NULL,
  `doctor_lastname` varchar(255) NOT NULL,
  `doctor_speciality` varchar(255) NOT NULL,
  `doctor_experience` varchar(10) NOT NULL,
  `doctor_desc` text NOT NULL,
  `doctor_password` varchar(255) NOT NULL,
  `doctor_token` varchar(255) NOT NULL,
  `doctor_spoke` varchar(255) NOT NULL,
  `doctor_gender` varchar(10) NOT NULL,
  `doctor_dob` date NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `doctor_contact` varchar(15) NOT NULL,
  `consult_fee` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reset`
--

CREATE TABLE `doctor_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) NOT NULL,
  `reset_selector` text NOT NULL,
  `reset_token` longtext NOT NULL,
  `reset_expires` text NOT NULL,
  `activate_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record`
--

CREATE TABLE `medical_record` (
  `med_id` int(11) NOT NULL,
  `med_sympton` text NOT NULL,
  `med_diagnosis` text NOT NULL,
  `med_date` datetime NOT NULL,
  `med_advice` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `patient_avatar` varchar(255) NOT NULL,
  `patient_firstname` varchar(255) NOT NULL,
  `patient_lastname` varchar(255) NOT NULL,
  `patient_email` varchar(255) NOT NULL,
  `patient_password` varchar(255) NOT NULL,
  `patient_token` varchar(255) NOT NULL,
  `patient_identity` varchar(255) NOT NULL,
  `patient_nationality` varchar(255) NOT NULL,
  `patient_gender` varchar(255) NOT NULL,
  `patient_maritalstatus` varchar(255) NOT NULL,
  `patient_dob` date NOT NULL,
  `patient_age` varchar(11) NOT NULL,
  `patient_contact` varchar(255) NOT NULL,
  `patient_address` varchar(255) NOT NULL,
  `patient_city` varchar(255) NOT NULL,
  `patient_state` varchar(255) NOT NULL,
  `patient_zipcode` varchar(255) NOT NULL,
  `patient_country` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patient_reset`
--

CREATE TABLE `patient_reset` (
  `reset_id` int(11) NOT NULL,
  `reset_email` varchar(255) NOT NULL,
  `reset_selector` text NOT NULL,
  `reset_token` longtext NOT NULL,
  `reset_expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `date` date NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `schedule_week` varchar(255) NOT NULL,
  `status` int(5) NOT NULL COMMENT '1=Active | 0= Inactive',
  `doctor_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_detail`
--

CREATE TABLE `schedule_detail` (
  `schdetail_id` int(11) NOT NULL,
  `time_slot` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1= Active 0 = Inactive',
  `schedule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `speciality_id` int(11) NOT NULL,
  `speciality_name` varchar(255) NOT NULL,
  `speciality_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`speciality_id`, `speciality_name`, `speciality_icon`) VALUES
(1, 'GP/Family', 'family.png'),
(2, 'Dentist', 'dentist.png'),
(3, 'Acupuncturist', 'acupuncture.png'),
(4, 'Audiologist', 'hearing.png'),
(5, 'Anaesthetist', 'anaesthetist.png'),
(6, 'Optometrist', 'optometrist.png');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_type`
--

CREATE TABLE `treatment_type` (
  `treatment_id` int(11) NOT NULL,
  `treatment_name` varchar(255) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`ann_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `business_hour`
--
ALTER TABLE `business_hour`
  ADD PRIMARY KEY (`businesshour_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `clinic_images`
--
ALTER TABLE `clinic_images`
  ADD PRIMARY KEY (`clinicimg_id`);

--
-- Indexes for table `clinic_manager`
--
ALTER TABLE `clinic_manager`
  ADD PRIMARY KEY (`clinicadmin_id`);

--
-- Indexes for table `clinic_reset`
--
ALTER TABLE `clinic_reset`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `doctor_reset`
--
ALTER TABLE `doctor_reset`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `schedule_detail`
--
ALTER TABLE `schedule_detail`
  ADD PRIMARY KEY (`schdetail_id`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`speciality_id`);

--
-- Indexes for table `treatment_type`
--
ALTER TABLE `treatment_type`
  ADD PRIMARY KEY (`treatment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `ann_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `business_hour`
--
ALTER TABLE `business_hour`
  MODIFY `businesshour_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clinic_images`
--
ALTER TABLE `clinic_images`
  MODIFY `clinicimg_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clinic_manager`
--
ALTER TABLE `clinic_manager`
  MODIFY `clinicadmin_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `doctor_reset`
--
ALTER TABLE `doctor_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medical_record`
--
ALTER TABLE `medical_record`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule_detail`
--
ALTER TABLE `schedule_detail`
  MODIFY `schdetail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `speciality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `treatment_type`
--
ALTER TABLE `treatment_type`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`clinic_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
