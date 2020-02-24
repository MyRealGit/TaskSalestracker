-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Feb 24, 2020 at 10:21 AM
-- Server version: 5.7.28
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2basic`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_User` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `firstname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `surname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `authKey` varchar(70) COLLATE latin1_general_ci DEFAULT NULL,
  `accessToken` varchar(70) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `dateOnCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUpdateEntry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `Id_User` (`id_User`)
) ENGINE=MyISAM AUTO_INCREMENT=198 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_User`, `username`, `firstname`, `surname`, `birthdate`, `email`, `authKey`, `accessToken`, `password`, `dateOnCreate`, `dateUpdateEntry`) VALUES
(1, 'admin', 'admin', 'admin', '2020-01-01', 'ppp@gmail.com', '', '', '21232f297a57a5a743894a0e4a801fc3', '2020-02-17 13:05:18', '2020-02-22 20:48:25'),
(2, 'user', 'firstname', 'surname', '2020-02-02', 'oo@mail.pl', '', '', 'ee11cbb19052e40b07aac0ca060c23ee', '2020-02-17 17:17:04', '2020-02-22 20:48:25'),
(193, 'Runge', 'Runge', 'Kutt', '1992-01-07', 'rung@poczta.pl', NULL, NULL, '4c954081e8dd643a1dfde84e39326d59', '2020-02-22 20:54:46', '2020-02-22 20:54:46'),
(192, 'John', 'John', 'Watson', '1992-01-07', 'ooo@poczta.pl', NULL, NULL, 'e596e58d9efcf490ce8ed3150d2108a4', '2020-02-22 20:54:46', '2020-02-22 20:54:46'),
(191, 'Joe', 'Joe', 'Molly', '1992-01-07', 'pop@poczta.pl', NULL, NULL, 'b59c67bf196a4758191e42f76670ceba', '2020-02-22 20:54:46', '2020-02-23 12:31:07'),
(190, 'Gary', 'Gary', 'Kannengam', '1992-01-07', 'kan@poczta.pl', NULL, NULL, 'b59c67bf196a4758191e42f76670ceba', '2020-02-22 20:54:46', '2020-02-23 12:24:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
