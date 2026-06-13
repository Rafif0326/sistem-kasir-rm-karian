-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 09:04 AM
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
-- Database: `db_rm_karian`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `nama_menu`, `harga`, `qty`, `subtotal`) VALUES
(1, 11, 'Gurame Asam Manis', 50000, 1, 50000),
(2, 12, 'Ayam Goreng', 20000, 2, 40000),
(3, 12, 'Sop Iga', 35000, 1, 35000),
(4, 12, 'Jus Alpukat', 12000, 1, 12000),
(5, 12, 'Jus Buah Naga', 12000, 2, 24000),
(6, 13, 'Bakso', 15000, 1, 15000),
(7, 13, 'Mie Ayam', 15000, 1, 15000),
(8, 13, 'Jus Jeruk', 12000, 1, 12000),
(9, 14, 'Bakso', 15000, 1, 15000),
(10, 15, 'Bakso', 15000, 1, 15000),
(11, 17, 'Bakso', 15000, 1, 15000),
(12, 0, 'Bakso', 15000, 1, 15000),
(13, 0, 'Gurame Asam Manis', 50000, 1, 50000),
(14, 0, 'Bakso', 15000, 1, 15000),
(15, 20, 'Bakso', 15000, 1, 15000),
(16, 21, 'Pecak Nila', 30000, 1, 30000),
(17, 22, 'Jus Alpukat', 12000, 1, 12000),
(18, 22, 'Jus Buah Naga', 12000, 1, 12000),
(19, 23, 'Bakso', 15000, 1, 15000),
(20, 23, 'Pecak Nila', 30000, 1, 30000),
(21, 23, 'Jus Buah Naga', 12000, 1, 12000),
(22, 24, 'Bakso', 15000, 2, 30000),
(23, 24, 'Es Teh Manis', 8000, 1, 8000),
(24, 25, 'Bakso', 15000, 1, 15000),
(25, 25, 'Gurame Asam Manis', 50000, 1, 50000),
(26, 25, 'Es Teh Manis', 8000, 1, 8000),
(27, 26, 'Bakso', 15000, 1, 15000),
(28, 26, 'Pecak Emas', 30000, 1, 30000),
(29, 26, 'Jus Buah Naga', 12000, 1, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`) VALUES
(2, 'Bakso', 15000),
(3, 'Gurame Asam Manis', 50000),
(4, 'Pecak Nila', 30000),
(5, 'Ayam Goreng', 20000),
(6, 'Pecak Emas', 30000),
(7, 'Sop Iga', 35000),
(8, 'Kerang Miting', 100000),
(9, 'Mie Ayam', 15000),
(10, 'Es Teh Manis', 8000),
(11, 'Jus Jeruk', 12000),
(12, 'Teh Tawar', 5000),
(13, 'Jus Mangga', 12000),
(14, 'Jus Alpukat', 12000),
(15, 'Jus Buah Naga', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `nomor_pesanan` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `status_pesanan` varchar(30) DEFAULT 'Diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nomor_pesanan`, `tanggal`, `total`, `bayar`, `kembalian`, `status_pesanan`) VALUES
(1, 'PSN-001', '2026-04-15 08:40:57', 20000, 22000, 2000, 'Selesai'),
(2, 'PSN-002', '2026-04-15 08:43:54', 240000, 250000, 10000, 'Selesai'),
(3, 'PSN-003', '2026-04-15 08:44:23', 60000, 65000, 5000, 'Selesai'),
(4, 'PSN-004', '2026-04-21 14:37:29', 60000, 70000, 10000, 'Selesai'),
(5, 'PSN-005', '2026-04-21 15:06:35', 103000, 110000, 7000, 'Selesai'),
(6, 'PSN-006', '2026-04-21 15:14:09', 27000, 50000, 23000, 'Selesai'),
(7, 'PSN-007', '2026-04-23 18:24:22', 191000, 200000, 9000, 'Selesai'),
(8, 'PSN-008', '2026-04-29 08:18:32', 76000, 80000, 4000, 'Selesai'),
(9, 'PSN-009', '2026-05-03 12:22:28', 153000, 155000, 2000, 'Selesai'),
(10, 'PSN-010', '2026-05-10 18:26:38', 43000, 100000, 57000, 'Selesai'),
(11, 'PSN-011', '2026-06-09 14:06:43', 50000, 60000, 10000, 'Selesai'),
(12, 'PSN-012', '2026-06-09 14:33:32', 111000, 150000, 39000, 'Selesai'),
(13, 'PSN-013', '2026-06-10 12:56:50', 42000, 100000, 58000, 'Selesai'),
(21, 'PSN-021', '2026-06-10 13:40:16', 30000, 50000, 20000, 'Selesai'),
(22, 'PSN-022', '2026-06-10 14:14:47', 24000, 50000, 26000, 'Selesai'),
(23, 'PSN-023', '2026-06-10 14:17:37', 57000, 100000, 43000, 'Selesai'),
(24, 'PSN-024', '2026-06-12 08:13:36', 38000, 50000, 12000, 'Selesai'),
(25, 'PSN-025', '2026-06-12 08:14:05', 73000, 100000, 27000, 'Selesai'),
(26, 'PSN-026', '2026-06-12 08:14:38', 57000, 100000, 43000, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'kasir', '123', 'kasir'),
(2, 'admin', '123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
