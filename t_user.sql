-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2024 at 02:10 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sipeda`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','puskom','prodi','pimpinan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `email`, `prodi`, `password`, `level`) VALUES
(1, 'puskom@unsub.ac.id', NULL, '$2y$10$kV04s.vjwjOLCPtcfmtXKuHucZIA0nKDgjkq9e6.oROoHcWnrFium', 'puskom'),
(2, 'admin@unsub.ac.id', NULL, '$2y$10$iQEXdaRPsCyDWBBTPQ0b6uYvQ5wpFFd7js6esBuwyIuWRRXMHGlf6', 'admin'),
(3, 'pimpinan@unsub.ac.id', NULL, '$2y$10$28bUpJP/eZb71izgYCBr3enAB76QcNafXa9OmL8cXv9rIERlSd5cy', 'pimpinan'),
(6, 'publik@unsub.ac.id', 'Administrasi Publik', '$2y$10$QEAZI99l.QufWEEIvD.ylehQFF4KInPo/Nqg/E4rbGG4lFsUuOPTG', 'prodi'),
(7, 'keuangan@unsub.ac.id', 'Administrasi Keuangan', '$2y$10$N/Eu2HDBodk6q.0GvEkoCui6.dXhcx0DlsMNEIO.nMBVRjKc3UrLy', 'prodi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
