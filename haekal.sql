-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 10:14 AM
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

--
-- Dumping data for table `model_rambut`
--

INSERT INTO `model_rambut` (`id`, `nama`, `deskripsi`, `bentuk_wajah`) VALUES
(3, 'Caesar Cut', 'Model rambut pendek dengan poni lurus ke depan serta sisi dan belakang dipotong rapi, memberikan tampilan sederhana, tegas, dan mudah dirawat.', 'Ovale'),
(4, 'Classic Undercut', 'Model rambut dengan bagian atas dibiarkan lebih panjang, sementara sisi dan belakang dipotong sangat pendek atau tipis tanpa gradasi, menciptakan kontras yang rapi dan klasik.', 'Ovale'),
(5, 'Curtain Bangs', 'Model rambut dengan poni belah tengah atau sedikit menyamping yang jatuh seperti tirai di kedua sisi wajah, memberi kesan lembut dan natural.', 'Ovale'),
(6, 'Faux Hawk', 'Model rambut dengan bagian tengah lebih panjang dan ditata ke atas, sementara sisi kiri dan kanan lebih pendek, menciptakan tampilan mohawk yang lebih halus dan fleksibel.', 'Ovale'),
(7, 'Side Part', 'Model rambut dengan belahan samping yang jelas, bagian atas lebih panjang dan sisi lebih rapi, memberikan kesan klasik, rapi, dan profesional.', 'Ovale'),
(8, 'Buzz Cut', 'Model rambut sangat pendek dan rata di seluruh kepala, memberikan tampilan simpel, bersih, dan minim perawatan.', 'Round'),
(9, 'Comb Over', 'Model rambut dengan bagian atas disisir menyamping menutupi satu sisi, sementara sisi dan belakang dipotong lebih pendek, memberi kesan rapi dan klasik.', 'Round'),
(10, 'Pompadour', 'Model rambut dengan bagian depan dan atas bervolume tinggi yang disisir ke belakang, sementara sisi dan belakang lebih pendek, memberikan kesan elegan dan berkelas.', 'Round'),
(11, 'Quiff', 'Model rambut dengan bagian depan diangkat dan bervolume, bagian atas tetap panjang, serta sisi dan belakang lebih pendek, memberi kesan modern dan dinamis.', 'Round'),
(13, 'Spike', 'Model rambut dengan ujung rambut ditata runcing ke atas menggunakan produk styling, memberikan tampilan tegas, edgy, dan energik.', 'Round'),
(14, 'Buzz Cut', 'Model rambut sangat pendek dan rata di seluruh kepala, memberikan tampilan simpel, bersih, dan minim perawatan.', 'Square'),
(15, 'Crew Cut', 'Model rambut pendek dengan bagian atas sedikit lebih panjang dibanding sisi dan belakang yang dipotong rapi, memberikan kesan bersih, maskulin, dan praktis.', 'Square'),
(16, 'Medium Shag', 'Model rambut panjang sedang dengan potongan bertingkat acak, memberi kesan santai, bertekstur, dan sedikit berantakan secara natural.', 'Square'),
(17, 'Messy Fringe', 'Model rambut dengan poni depan dibiarkan bertekstur dan sedikit berantakan, memberikan kesan santai, kasual, dan modern.', 'Square'),
(18, 'Undercut', 'Model rambut dengan bagian atas lebih panjang, sementara sisi dan belakang dipotong sangat pendek atau tipis, menciptakan kontras yang tegas dan modern.', 'Square'),
(19, 'Classic Crew Cut', 'Model rambut pendek klasik dengan bagian atas dipotong rata dan sedikit lebih panjang, sementara sisi dan belakang lebih pendek, memberi kesan rapi, bersih, dan maskulin.', 'Triangle'),
(20, 'Modern Pompadour', 'Model rambut dengan volume tinggi di bagian depan dan atas yang ditata ke belakang, dipadukan dengan sisi dan belakang lebih pendek atau fade, memberikan tampilan modern dan stylish.', 'Triangle'),
(21, 'Textured Crop', 'Model rambut pendek dengan potongan bertekstur di bagian atas dan sisi yang rapi, memberikan tampilan modern, kasual, dan mudah ditata.', 'Triangle'),
(22, 'Textured Fringe', 'Model rambut dengan poni depan bertekstur dan bagian atas dibuat lebih berlapis, sementara sisi lebih rapi, memberi kesan modern dan dinamis.', 'Triangle'),
(23, 'Undercut Fade', 'Model rambut dengan bagian atas lebih panjang, sementara sisi dan belakang dipotong gradasi (fade) hingga sangat tipis, menciptakan tampilan bersih, modern, dan kontras.', 'Triangle');

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
(5, 'aimar', 'triangle', '2025-12-24 03:53:18', '08088848484', NULL),
(6, 'login', 'triangle', '2025-12-24 04:07:25', '0804854654654', 'capture_1766549217.jpg'),
(7, 'popopo', 'triangle', '2025-12-24 04:12:41', '0800080845', 'capture_1766549555.jpg'),
(8, 'lagi lagi', 'triangle', '2025-12-24 04:16:56', '087484508787', 'capture_1766549807.jpg'),
(9, 'afif', 'round', '2025-12-24 04:25:16', '08708908454658', 'capture_1766550312.jpg'),
(10, 'aqil', 'triangle', '2025-12-24 10:42:47', '089526322418', 'capture_1766572940.jpg');

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

--
-- Dumping data for table `riwayat_kapster`
--

INSERT INTO `riwayat_kapster` (`id`, `id_kapster`, `id_pelanggan`, `created_at`) VALUES
(1, 15, 9, '2025-12-26 08:33:07'),
(2, 19, 10, '2025-12-26 08:34:02'),
(3, 15, 10, '2025-12-26 08:51:22');

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
-- Dumping data for table `riwayat_model_rambut`
--

INSERT INTO `riwayat_model_rambut` (`id`, `id_pelanggan`, `id_model_rambut`, `created_at`, `haircut`, `tanggal`, `waktu`) VALUES
(1, 9, 10, '2025-12-26 08:26:44', 'Pompadour', '2025-12-26', '09:26:44'),
(2, 9, 8, '2025-12-26 08:33:07', 'Buzz Cut', '2025-12-26', '09:33:07'),
(3, 9, 8, '2025-12-26 08:33:07', 'Buzz Cut', '2025-12-26', '09:33:07'),
(4, 10, 21, '2025-12-26 08:34:02', 'Textured Crop', '2025-12-26', '09:34:02'),
(5, 10, 21, '2025-12-26 08:34:02', 'Textured Crop', '2025-12-26', '09:34:02'),
(6, 10, 20, '2025-12-26 08:51:22', 'Modern Pompadour', '2025-12-26', '09:51:22'),
(7, 10, 20, '2025-12-26 08:51:22', 'Modern Pompadour', '2025-12-26', '09:51:22');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `riwayat_kapster`
--
ALTER TABLE `riwayat_kapster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `riwayat_model_rambut`
--
ALTER TABLE `riwayat_model_rambut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
