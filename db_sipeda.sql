-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2024 at 08:39 PM
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
-- Table structure for table `t_berkas_pdl`
--

CREATE TABLE `t_berkas_pdl` (
  `id_berkas_pdl` int NOT NULL,
  `id_pdl` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_berkas_pdm`
--

CREATE TABLE `t_berkas_pdm` (
  `id_berkas_pdm` int NOT NULL,
  `id_pdm` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_berkas_pdm`
--

INSERT INTO `t_berkas_pdm` (`id_berkas_pdm`, `id_pdm`, `file`, `jenis`) VALUES
(1, 1, 'pdm_uyagvdabhKTP1735108538.pdf', 'KTP'),
(2, 1, 'pdm_uyagvdabhAKTA1735108538.pdf', 'AKTA'),
(3, 1, 'pdm_uyagvdabhKK1735108538.pdf', 'KK'),
(4, 1, 'pdm_uyagvdabhIjazah dan Transkrip1735108538.pdf', 'Ijazah dan Transkrip'),
(5, 1, 'pdm_uyagvdabhKTM1735108538.pdf', 'KTM');

-- --------------------------------------------------------

--
-- Table structure for table `t_jenis_pengajuan_pdl`
--

CREATE TABLE `t_jenis_pengajuan_pdl` (
  `id_jenis_pengajuan_pdl` int NOT NULL,
  `id_pdl` int NOT NULL,
  `jenis_pengajuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_awal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_diusulkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_jenis_pengajuan_pdm`
--

CREATE TABLE `t_jenis_pengajuan_pdm` (
  `id_jenis_pengajuan_pdm` int NOT NULL,
  `id_pdm` int NOT NULL,
  `jenis_pengajuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_awal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_diusulkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pdl`
--

CREATE TABLE `t_pdl` (
  `id_pdl` int NOT NULL,
  `npm` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `angkatan` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `terakhir_update` date NOT NULL,
  `status_pengajuan` enum('Draft','Verifikasi Berkas','Verifikasi Pimpinan','Proses Pengajuan Dikti','Selesai','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pdm`
--

CREATE TABLE `t_pdm` (
  `id_pdm` int NOT NULL,
  `npm` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `terakhir_update` date NOT NULL,
  `status_pengajuan` enum('Draft','Verifikasi Berkas','Verifikasi Pimpinan','Proses Pengajuan Dikti','Selesai','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pdm`
--

INSERT INTO `t_pdm` (`id_pdm`, `npm`, `nama`, `prodi`, `terakhir_update`, `status_pengajuan`, `keterangan`) VALUES
(1, 'uyagvdabh', 'igsuavjbkdas', 'Administrasi Publik', '0000-00-00', 'Draft', '');

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
-- Indexes for table `t_berkas_pdl`
--
ALTER TABLE `t_berkas_pdl`
  ADD PRIMARY KEY (`id_berkas_pdl`);

--
-- Indexes for table `t_berkas_pdm`
--
ALTER TABLE `t_berkas_pdm`
  ADD PRIMARY KEY (`id_berkas_pdm`);

--
-- Indexes for table `t_jenis_pengajuan_pdl`
--
ALTER TABLE `t_jenis_pengajuan_pdl`
  ADD PRIMARY KEY (`id_jenis_pengajuan_pdl`);

--
-- Indexes for table `t_jenis_pengajuan_pdm`
--
ALTER TABLE `t_jenis_pengajuan_pdm`
  ADD PRIMARY KEY (`id_jenis_pengajuan_pdm`);

--
-- Indexes for table `t_pdl`
--
ALTER TABLE `t_pdl`
  ADD PRIMARY KEY (`id_pdl`);

--
-- Indexes for table `t_pdm`
--
ALTER TABLE `t_pdm`
  ADD PRIMARY KEY (`id_pdm`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_berkas_pdl`
--
ALTER TABLE `t_berkas_pdl`
  MODIFY `id_berkas_pdl` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_berkas_pdm`
--
ALTER TABLE `t_berkas_pdm`
  MODIFY `id_berkas_pdm` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_jenis_pengajuan_pdl`
--
ALTER TABLE `t_jenis_pengajuan_pdl`
  MODIFY `id_jenis_pengajuan_pdl` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_jenis_pengajuan_pdm`
--
ALTER TABLE `t_jenis_pengajuan_pdm`
  MODIFY `id_jenis_pengajuan_pdm` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_pdl`
--
ALTER TABLE `t_pdl`
  MODIFY `id_pdl` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_pdm`
--
ALTER TABLE `t_pdm`
  MODIFY `id_pdm` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
