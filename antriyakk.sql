-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2023 at 11:23 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `max_day`
--

CREATE TABLE `max_day` (
  `id` int(1) NOT NULL,
  `tanggal` date NOT NULL,
  `countmax` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `max_day`
--

INSERT INTO `max_day` (`id`, `tanggal`, `countmax`) VALUES
(0, '2023-05-04', 2);

-- --------------------------------------------------------

--
-- Table structure for table `max_registrasi`
--

CREATE TABLE `max_registrasi` (
  `id` int(20) NOT NULL,
  `maxreg` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `max_registrasi`
--

INSERT INTO `max_registrasi` (`id`, `maxreg`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_antri`
--

CREATE TABLE `user_antri` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nik` int(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` varchar(5) NOT NULL,
  `file_ktp` varchar(20) DEFAULT NULL,
  `tgl_periksa` date NOT NULL,
  `no_antrian` int(50) NOT NULL,
  `jenisperiksa` int(50) NOT NULL,
  `pembayaran` int(50) NOT NULL,
  `pemblain` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `max_registrasi`
--
ALTER TABLE `max_registrasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_antri`
--
ALTER TABLE `user_antri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `max_registrasi`
--
ALTER TABLE `max_registrasi`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_antri`
--
ALTER TABLE `user_antri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
