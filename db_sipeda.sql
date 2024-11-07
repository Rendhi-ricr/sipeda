-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.3.0 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_sipeda
CREATE DATABASE IF NOT EXISTS `db_sipeda` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_sipeda`;

-- membuang struktur untuk table db_sipeda.t_berkas_pdl
CREATE TABLE IF NOT EXISTS `t_berkas_pdl` (
  `id_berkas_pdl` int NOT NULL AUTO_INCREMENT,
  `id_pdl` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_berkas_pdl`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_berkas_pdl: ~16 rows (lebih kurang)
DELETE FROM `t_berkas_pdl`;
INSERT INTO `t_berkas_pdl` (`id_berkas_pdl`, `id_pdl`, `file`, `jenis`) VALUES
	(18, 7, 'pdl_A1A220412_Ijazah dan Transkrip_1729510556.pdf', 'Ijazah dan Transkrip'),
	(19, 7, 'pdl_A1A220412_Surat_1729510633.pdf', 'Surat'),
	(22, 9, 'pdl_akstuycjfasIjazah dan Transkrip1729557945.pdf', 'Ijazah dan Transkrip'),
	(23, 9, 'pdl_akstuycjfa_Surat_1729557994.pdf', 'Surat'),
	(24, 10, 'pdl_hs8fadIjazah dan Transkrip1729558085.pdf', 'Ijazah dan Transkrip'),
	(25, 11, 'pdl_sagdyavIjazah dan Transkrip1729558129.pdf', 'Ijazah dan Transkrip'),
	(26, 12, 'pdl_aug8sdsIjazah dan Transkrip1729558228.pdf', 'Ijazah dan Transkrip'),
	(27, 12, 'pdl_aug8sds_Surat_1729566773.pdf', 'Surat'),
	(28, 13, 'pdl_iugiusdfjshIjazah dan Transkrip1729565684.pdf', 'Ijazah dan Transkrip'),
	(29, 13, 'pdl_iugiusdfjs_Surat_1729566898.pdf', 'Surat'),
	(30, 10, 'pdl_hs8fad_Surat_1729567001.pdf', 'Surat'),
	(31, 14, 'pdl_ytvuytvIjazah dan Transkrip1729578848.pdf', 'Ijazah dan Transkrip'),
	(32, 14, 'pdl_ytvuytv_Surat_1729578918.pdf', 'Surat'),
	(33, 11, 'pdl_sagdyav_Surat_1730030768.pdf', 'Surat'),
	(34, 15, 'pdl_D1A220091Ijazah dan Transkrip1730738655.pdf', 'Ijazah dan Transkrip'),
	(35, 15, 'pdl_D1A220091_Surat_1730792982.pdf', 'Surat');

-- membuang struktur untuk table db_sipeda.t_berkas_pdm
CREATE TABLE IF NOT EXISTS `t_berkas_pdm` (
  `id_berkas_pdm` int NOT NULL AUTO_INCREMENT,
  `id_pdm` int NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_berkas_pdm`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_berkas_pdm: ~40 rows (lebih kurang)
DELETE FROM `t_berkas_pdm`;
INSERT INTO `t_berkas_pdm` (`id_berkas_pdm`, `id_pdm`, `file`, `jenis`) VALUES
	(1, 1, 'pdm_A1A220412KTP1729930683.pdf', 'KTP'),
	(2, 1, 'pdm_A1A220412AKTA1729930683.pdf', 'AKTA'),
	(3, 1, 'pdm_A1A220412KK1729930683.pdf', 'KK'),
	(4, 1, 'pdm_A1A220412Ijazah dan Transkrip1729930683.pdf', 'Ijazah dan Transkrip'),
	(5, 1, 'pdm_A1A220412KTM1729930683.pdf', 'KTM'),
	(6, 1, 'pdm_A1A220412_Surat_1729930731.pdf', 'Surat'),
	(7, 2, 'pdm_A0A190065KTP1730030134.pdf', 'KTP'),
	(8, 2, 'pdm_A0A190065AKTA1730030134.pdf', 'AKTA'),
	(9, 2, 'pdm_A0A190065KK1730030134.pdf', 'KK'),
	(10, 2, 'pdm_A0A190065Ijazah dan Transkrip1730030134.pdf', 'Ijazah dan Transkrip'),
	(11, 2, 'pdm_A0A190065KTM1730030134.pdf', 'KTM'),
	(12, 2, 'pdm_A0A190065_Surat_1730030574.pdf', 'Surat'),
	(13, 3, 'pdm_asdsauKTP1730355573.pdf', 'KTP'),
	(14, 3, 'pdm_asdsauAKTA1730355573.pdf', 'AKTA'),
	(15, 3, 'pdm_asdsauKK1730355573.pdf', 'KK'),
	(16, 3, 'pdm_asdsauIjazah dan Transkrip1730355573.pdf', 'Ijazah dan Transkrip'),
	(17, 3, 'pdm_asdsauKTM1730355574.pdf', 'KTM'),
	(18, 3, 'pdm_asdsau_Surat_1730355590.pdf', 'Surat'),
	(19, 4, 'pdm_iuhsdiufKTP1730355742.pdf', 'KTP'),
	(20, 4, 'pdm_iuhsdiufAKTA1730355742.pdf', 'AKTA'),
	(21, 4, 'pdm_iuhsdiufKK1730355742.pdf', 'KK'),
	(22, 4, 'pdm_iuhsdiufIjazah dan Transkrip1730355742.pdf', 'Ijazah dan Transkrip'),
	(23, 4, 'pdm_iuhsdiufKTM1730355742.pdf', 'KTM'),
	(24, 4, 'pdm_iuhsdiuf_Surat_1730355752.pdf', 'Surat'),
	(25, 5, 'pdm_asyudvbKTP1730357761.pdf', 'KTP'),
	(26, 5, 'pdm_asyudvbAKTA1730357761.pdf', 'AKTA'),
	(27, 5, 'pdm_asyudvbKK1730357761.pdf', 'KK'),
	(28, 5, 'pdm_asyudvbIjazah dan Transkrip1730357761.pdf', 'Ijazah dan Transkrip'),
	(29, 5, 'pdm_asyudvbKTM1730357761.pdf', 'KTM'),
	(30, 6, 'pdm_asvdjsahvdKTP1730357921.pdf', 'KTP'),
	(31, 6, 'pdm_asvdjsahvdAKTA1730357921.pdf', 'AKTA'),
	(32, 6, 'pdm_asvdjsahvdKK1730357921.pdf', 'KK'),
	(33, 6, 'pdm_asvdjsahvdIjazah dan Transkrip1730357921.pdf', 'Ijazah dan Transkrip'),
	(34, 6, 'pdm_asvdjsahvdKTM1730357921.pdf', 'KTM'),
	(35, 7, 'pdm_dlsakjdKTP1730724827.pdf', 'KTP'),
	(36, 7, 'pdm_dlsakjdAKTA1730724827.pdf', 'AKTA'),
	(37, 7, 'pdm_dlsakjdKK1730724827.pdf', 'KK'),
	(38, 7, 'pdm_dlsakjdIjazah dan Transkrip1730724827.pdf', 'Ijazah dan Transkrip'),
	(39, 7, 'pdm_dlsakjdKTM1730724827.pdf', 'KTM'),
	(40, 7, 'pdm_dlsakjd_Surat_1730725040.pdf', 'Surat'),
	(41, 8, 'pdm_D1A220091KTP1730728276.pdf', 'KTP'),
	(42, 8, 'pdm_D1A220091AKTA1730728276.pdf', 'AKTA'),
	(43, 8, 'pdm_D1A220091KK1730728276.pdf', 'KK'),
	(44, 8, 'pdm_D1A220091Ijazah dan Transkrip1730728276.pdf', 'Ijazah dan Transkrip'),
	(45, 8, 'pdm_D1A220091KTM1730728276.pdf', 'KTM'),
	(46, 8, 'pdm_D1A220091_Surat_1730777258.pdf', 'Surat'),
	(47, 9, 'pdm_D1A220094KTP1730774432.pdf', 'KTP'),
	(48, 9, 'pdm_D1A220094AKTA1730774432.pdf', 'AKTA'),
	(49, 9, 'pdm_D1A220094KK1730774432.pdf', 'KK'),
	(50, 9, 'pdm_D1A220094Ijazah dan Transkrip1730774432.pdf', 'Ijazah dan Transkrip'),
	(51, 9, 'pdm_D1A220094KTM1730774432.pdf', 'KTM'),
	(52, 9, 'pdm_D1A220094_Surat_1730777286.pdf', 'Surat'),
	(53, 10, 'pdm_D1A220092KTP1730775394.pdf', 'KTP'),
	(54, 10, 'pdm_D1A220092AKTA1730775394.pdf', 'AKTA'),
	(55, 10, 'pdm_D1A220092KK1730775394.pdf', 'KK'),
	(56, 10, 'pdm_D1A220092Ijazah dan Transkrip1730775394.pdf', 'Ijazah dan Transkrip'),
	(57, 10, 'pdm_D1A220092KTM1730775394.pdf', 'KTM');

-- membuang struktur untuk table db_sipeda.t_jenis_pengajuan_pdl
CREATE TABLE IF NOT EXISTS `t_jenis_pengajuan_pdl` (
  `id_jenis_pengajuan_pdl` int NOT NULL AUTO_INCREMENT,
  `id_pdl` int NOT NULL,
  `jenis_pengajuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_awal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_diusulkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis_pengajuan_pdl`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_jenis_pengajuan_pdl: ~8 rows (lebih kurang)
DELETE FROM `t_jenis_pengajuan_pdl`;
INSERT INTO `t_jenis_pengajuan_pdl` (`id_jenis_pengajuan_pdl`, `id_pdl`, `jenis_pengajuan`, `data_awal`, `data_diusulkan`) VALUES
	(7, 7, 'Tanggal SK', '20 Oktober 2024', '10 Oktober 2023'),
	(9, 9, 'IPK', '123', '321'),
	(10, 10, 'No Ijazah Atau No Sertifikat Profesi', '12376', '97321'),
	(11, 11, 'No Ijazah Atau No Sertifikat Profesi', '12313', '71523'),
	(12, 12, 'No Ijazah Atau No Sertifikat Profesi', '123', '4321'),
	(13, 13, 'IPK', 'isaugdsaoug', 'iugahdgsajd'),
	(14, 14, 'Periode Keluar', 'gyuvyg', 'ygvy'),
	(15, 15, 'Tanggal SK', 'AA', 'BB');

-- membuang struktur untuk table db_sipeda.t_jenis_pengajuan_pdm
CREATE TABLE IF NOT EXISTS `t_jenis_pengajuan_pdm` (
  `id_jenis_pengajuan_pdm` int NOT NULL AUTO_INCREMENT,
  `id_pdm` int NOT NULL,
  `jenis_pengajuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_awal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_diusulkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis_pengajuan_pdm`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_jenis_pengajuan_pdm: ~8 rows (lebih kurang)
DELETE FROM `t_jenis_pengajuan_pdm`;
INSERT INTO `t_jenis_pengajuan_pdm` (`id_jenis_pengajuan_pdm`, `id_pdm`, `jenis_pengajuan`, `data_awal`, `data_diusulkan`) VALUES
	(1, 1, 'NIK', '123', '321'),
	(2, 2, 'Nama', 'Asep', 'Pesa'),
	(3, 2, 'NIK', '123', '123'),
	(4, 3, 'Nama', 'asd', 'asjdasbd'),
	(5, 4, 'NIK', 'ada', '1123'),
	(6, 5, 'Tanggal Lahir', 'adsad', 'asdsad'),
	(7, 6, 'NIK', '45654', '1213'),
	(8, 7, 'NIK', '123', '321'),
	(11, 8, 'Nama', 'AA', 'BB'),
	(12, 8, 'Jenis Kelamin', 'L', 'P'),
	(13, 9, 'NIK', '4312', '4213'),
	(14, 10, 'NIK', '47657', '2325');

-- membuang struktur untuk table db_sipeda.t_pdl
CREATE TABLE IF NOT EXISTS `t_pdl` (
  `id_pdl` int NOT NULL AUTO_INCREMENT,
  `npm` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `terakhir_update` date NOT NULL,
  `status_pengajuan` enum('Draft','Verifikasi Berkas','Verifikasi Pimpinan','Proses Pengajuan Dikti','Selesai','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pdl`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_pdl: ~8 rows (lebih kurang)
DELETE FROM `t_pdl`;
INSERT INTO `t_pdl` (`id_pdl`, `npm`, `nama`, `prodi`, `terakhir_update`, `status_pengajuan`, `keterangan`) VALUES
	(7, 'A1A220412', 'Amel', 'Administrasi Publik', '2024-10-22', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(9, 'akstuycjfa', 'giysukvag', 'Administrasi Keuangan', '2024-10-22', 'Ditolak', 'tafdtyasfdsayfdhsagf'),
	(10, 'hs8fad', '8a7dy', 'Administrasi Publik', '2024-10-22', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(11, 'sagdyav', 'ligyskavgd', 'Administrasi Publik', '2024-10-27', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(12, 'aug8sds', 'ailsyvd', 'Administrasi Keuangan', '2024-10-22', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(13, 'iugiusdfjs', 'kjhabkdhas', 'Administrasi Keuangan', '2024-10-22', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(14, 'ytvuytv', 'ytvyv', 'Administrasi Publik', '2024-10-22', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(15, 'D1A220091', 'Yayan', 'Administrasi Publik', '2024-11-05', 'Verifikasi Pimpinan', 'Pengajuan Telah Di Acc Oleh Puskom');

-- membuang struktur untuk table db_sipeda.t_pdm
CREATE TABLE IF NOT EXISTS `t_pdm` (
  `id_pdm` int NOT NULL AUTO_INCREMENT,
  `npm` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `terakhir_update` date NOT NULL,
  `status_pengajuan` enum('Draft','Verifikasi Berkas','Verifikasi Pimpinan','Proses Pengajuan Dikti','Selesai','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pdm`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Membuang data untuk tabel db_sipeda.t_pdm: ~0 rows (lebih kurang)
DELETE FROM `t_pdm`;
INSERT INTO `t_pdm` (`id_pdm`, `npm`, `nama`, `prodi`, `terakhir_update`, `status_pengajuan`, `keterangan`) VALUES
	(1, 'A1A220412', 'Amell', 'Administrasi Publik', '2024-10-26', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(2, 'A0A190065', 'Asep', 'Administrasi Keuangan', '2024-10-27', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(3, 'asdsau', 'gauygdsuy', 'Administrasi Publik', '2024-10-31', 'Verifikasi Berkas', 'Belum Ada Keterangan'),
	(4, 'iuhsdiuf', 'iauhsdajid', 'Administrasi Publik', '2024-10-31', 'Verifikasi Berkas', 'Belum Ada Keterangan'),
	(5, 'asyudvb', 'aidbsaib', 'Administrasi Publik', '2024-11-05', 'Verifikasi Pimpinan', 'Pengajuan Telah Di Acc Oleh Puskom'),
	(6, 'asvdjsahvd', 'ksjhabdajhsb', 'Administrasi Publik', '2024-10-31', 'Verifikasi Berkas', 'Belum Ada Keterangan'),
	(7, 'dlsakjd', 'akjd', 'Administrasi Publik', '2024-11-04', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(8, 'D1A220091', 'Asep Sukma', 'Administrasi Publik', '2024-11-05', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(9, 'D1A220094', 'Knjut', 'Administrasi Publik', '2024-11-05', 'Proses Pengajuan Dikti', 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'),
	(10, 'D1A220092', 'DADAN', 'Administrasi Publik', '2024-11-05', 'Verifikasi Berkas', 'Belum Ada Keterangan');

-- membuang struktur untuk table db_sipeda.t_user
CREATE TABLE IF NOT EXISTS `t_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('admin','puskom','prodi','pimpinan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel db_sipeda.t_user: ~0 rows (lebih kurang)
DELETE FROM `t_user`;
INSERT INTO `t_user` (`id_user`, `email`, `prodi`, `password`, `level`) VALUES
	(1, 'puskom@unsub.ac.id', NULL, '$2y$10$kV04s.vjwjOLCPtcfmtXKuHucZIA0nKDgjkq9e6.oROoHcWnrFium', 'puskom'),
	(2, 'admin@unsub.ac.id', NULL, '$2y$10$iQEXdaRPsCyDWBBTPQ0b6uYvQ5wpFFd7js6esBuwyIuWRRXMHGlf6', 'admin'),
	(3, 'pimpinan@unsub.ac.id', NULL, '$2y$10$28bUpJP/eZb71izgYCBr3enAB76QcNafXa9OmL8cXv9rIERlSd5cy', 'pimpinan'),
	(6, 'publik@unsub.ac.id', 'Administrasi Publik', '$2y$10$QEAZI99l.QufWEEIvD.ylehQFF4KInPo/Nqg/E4rbGG4lFsUuOPTG', 'prodi'),
	(7, 'keuangan@unsub.ac.id', 'Administrasi Keuangan', '$2y$10$N/Eu2HDBodk6q.0GvEkoCui6.dXhcx0DlsMNEIO.nMBVRjKc3UrLy', 'prodi');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
