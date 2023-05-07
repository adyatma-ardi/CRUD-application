-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2023 at 06:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$9MCaL.xz6Bu/amLyFFMVpeuYHN.nc22c5LaPiqtmrkOFADP7wJPZO', 'admin@gmail.com'),
(77, 'test', '$2y$10$5e8gdLB9tttvTyEkSSB2sOalufbhP5cTRNHWS7SBbqLhsmbNTNq1G', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nisn` varchar(6) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `foto_siswa` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nisn`, `nama_siswa`, `jenis_kelamin`, `foto_siswa`, `alamat`) VALUES
(2, '721701', 'Achmad Adyatma Ardi (Author)', 'Male', '6451314d67d08.jpg', 'Jl. Taman Ubud Kencana'),
(3, '721702', 'Bachtiar Muklisin', 'Male', '644faa3044964.jpeg', 'Jl. Ahmad Yani'),
(4, '721703', 'Yusuf Mahendra', 'Male', '644ea2481357a.jpg', 'Jl. Patimura'),
(5, '721704', 'Rania Khumaira', 'Female', '644ea25d59651.jpg', 'Jl. Palapa Raya'),
(6, '721705', 'Nia Ramadhani', 'Female', '644ea26f1784c.jpg', 'Jl. Kusuma Bangsa'),
(59, '721706', 'Qonita Dwi Wulandari', 'Female', '645131f5cb5ed.jpeg', 'Jl. Imam Bonjol'),
(63, '721707', 'Luna Chairunnisa', 'Female', '64512f070cd21.jpg', 'Jl. Moh. Supratman'),
(64, '721708', 'Nafisah Khasna', 'Female', '644f98893aa17.jpg', 'Jl. Diponegoro Limanggiau'),
(65, '721709', 'Ismail Dito', 'Male', '644f98e31400b.jpg', 'Jl. Lemangkabau Lima'),
(66, '721710', 'Bejo Marzuki', 'Male', '6451f1d991c91.jpg', 'Jl. Kemerdekaan Jakarta Timur Laut'),
(122, '721711', 'Maimunah Hafna', 'Female', '64513025ddbad.png', 'Jl. Pegangsaan Timur'),
(124, '721712', 'Nafisah Laiba', 'Female', '645141946d692.jpeg', 'Jl. Bukit Hijau Karawaci'),
(127, '721713', 'Egi Santoso', 'Male', '6451463b89bc1.jpg', 'Jl. Sari Bumi Indah'),
(128, '721714', 'Rizka Amalia', 'Female', '6451466b1ae7a.jpeg', 'Jl. Binong Permai'),
(129, '721715', 'Khansa Khamila', 'Female', '645146ac6b999.jpg', 'Jl. Cijengir Raya'),
(134, '721716', 'Naurah Salsabila', 'Female', '6451d1c99dcef.jpeg', 'Jl. Taman Ubud Indah'),
(139, '721701', 'Mamat Hasanudin', 'Male', '64566d566e9b3.jpg', 'Jl. Ryacudu Selatan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
