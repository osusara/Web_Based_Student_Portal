-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 19, 2019 at 10:36 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `last_login` varchar(45) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `name`, `phone`, `last_login`, `is_deleted`) VALUES
(4, 'osusarak96@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Osusara Kammalawatta', '0779460818', '2019-08-19 15:47:57', 0),
(5, 'janiduj@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Janidu Jayasanka', '0779456556', '2019-06-25 02:15:50', 0),
(6, 'malshikay@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Yohan Malshika', '0779456556', '2019-06-25 02:16:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`,`student_id`),
  KEY `fk_subject_has_student_student1` (`student_id`),
  KEY `fk_subject_has_student_subject1` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`subject_id`, `student_id`, `result`) VALUES
(1, 1, 98),
(1, 2, 85),
(1, 3, 74);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `last_login` varchar(45) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `email`, `password`, `name`, `phone`, `address`, `last_login`, `is_deleted`) VALUES
(1, 'osusarak@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Osusara Kammalawatta', '0779460818', 'Hanwella', '2019-08-19 15:46:18', 0),
(2, 'srsmsone@gmail.com', '866e37c7dee1e950454674d7e41560374a5caa35', 'Sanduni Senanayaka', '0779456556', 'Raddolugama', '2019-06-26 01:38:36', 0),
(3, 'nandikaj@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Nandika Jeewantha', '0779456556', 'Beliaththa', '2019-06-21 15:06:45', 0),
(4, 'gayans@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Gayan Chanaka', '0779456556', 'Bibile', '2019-06-26 00:48:30', 0),
(5, 'janiduj@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Janidu Jayasanka', '0779456565', 'Pannipitiya', '2019-08-19 15:49:08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `fk_subject_teacher1` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `name`, `teacher_id`, `is_deleted`) VALUES
(1, 'Science', 3, 0),
(2, 'Maths', 4, 0),
(3, 'IT', 4, 0),
(4, 'English', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `last_login` varchar(45) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `email`, `password`, `name`, `phone`, `address`, `last_login`, `is_deleted`) VALUES
(3, 'nimalp@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Nimal Perera', '0779456556', 'Colombo', '2019-08-19 16:03:50', 0),
(4, 'danapalau@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Dhanapala Udawaththa', '0779456556', 'Kaluaggala', '2019-08-19 16:04:37', 0),
(5, 'sachithrad@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Sachithra Dilshan', '0779456556', 'Hikkaduwa', '2019-06-21 15:08:29', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `fk_subject_has_student_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subject_has_student_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `fk_subject_teacher1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
