-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 09:46 AM
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
-- Database: `haekal`
--

-- --------------------------------------------------------

--
-- Table structure for table `deteksi_wajah`
--

CREATE TABLE `deteksi_wajah` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bentuk_wajah` varchar(50) DEFAULT NULL,
  `confidence` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kapster`
--

CREATE TABLE `kapster` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nomor_hp` varchar(25) NOT NULL,
  `jabatan` enum('owner','kapster') NOT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kapster`
--

INSERT INTO `kapster` (`id`, `username`, `nama`, `nomor_hp`, `jabatan`, `password`) VALUES
(4, 'cihuyy', NULL, '08080808080', 'kapster', 'cihuyyy'),
(15, 'admin', 'Admin', '0888808000', 'owner', 'admin'),
(19, 'login', 'Login', '45909098408', 'kapster', 'login');

-- --------------------------------------------------------

--
-- Table structure for table `model_rambut`
--

CREATE TABLE `model_rambut` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bentuk_wajah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bentuk_wajah` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hp_pelanggan` varchar(25) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `bentuk_wajah`, `created_at`, `hp_pelanggan`, `foto`) VALUES
(4, 'lah aneh cok', 'commahair', '2025-12-11 03:39:34', '080808080800', 'fotonya nanti aja');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_kapster`
--

CREATE TABLE `riwayat_kapster` (
  `id` int(11) NOT NULL,
  `id_kapster` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_model_rambut`
--

CREATE TABLE `riwayat_model_rambut` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_model_rambut` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `haircut` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deteksi_wajah`
--
ALTER TABLE `deteksi_wajah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `kapster`
--
ALTER TABLE `kapster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_rambut`
--
ALTER TABLE `model_rambut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_kapster`
--
ALTER TABLE `riwayat_kapster`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kapster` (`id_kapster`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `riwayat_model_rambut`
--
ALTER TABLE `riwayat_model_rambut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_model_rambut` (`id_model_rambut`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deteksi_wajah`
--
ALTER TABLE `deteksi_wajah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kapster`
--
ALTER TABLE `kapster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `model_rambut`
--
ALTER TABLE `model_rambut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `riwayat_kapster`
--
ALTER TABLE `riwayat_kapster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_model_rambut`
--
ALTER TABLE `riwayat_model_rambut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deteksi_wajah`
--
ALTER TABLE `deteksi_wajah`
  ADD CONSTRAINT `deteksi_wajah_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `riwayat_kapster`
--
ALTER TABLE `riwayat_kapster`
  ADD CONSTRAINT `riwayat_kapster_ibfk_1` FOREIGN KEY (`id_kapster`) REFERENCES `kapster` (`id`),
  ADD CONSTRAINT `riwayat_kapster_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `riwayat_model_rambut`
--
ALTER TABLE `riwayat_model_rambut`
  ADD CONSTRAINT `riwayat_model_rambut_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`),
  ADD CONSTRAINT `riwayat_model_rambut_ibfk_2` FOREIGN KEY (`id_model_rambut`) REFERENCES `model_rambut` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
