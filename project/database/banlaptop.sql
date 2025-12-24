-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2025 at 01:54 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banlaptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cau_hinh`
--

DROP TABLE IF EXISTS `cau_hinh`;
CREATE TABLE IF NOT EXISTS `cau_hinh` (
  `macauhinh` int NOT NULL AUTO_INCREMENT,
  `masanpham` int NOT NULL,
  `ram` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ocung` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `giatien` int NOT NULL,
  `soluong` int NOT NULL,
  PRIMARY KEY (`macauhinh`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cau_hinh`
--

INSERT INTO `cau_hinh` (`macauhinh`, `masanpham`, `ram`, `ocung`, `giatien`, `soluong`) VALUES
(7, 8, '16GB', '256GB', 25290000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

DROP TABLE IF EXISTS `chi_tiet_don_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_don_hang` (
  `machitietdonhang` int NOT NULL AUTO_INCREMENT,
  `madonhang` int NOT NULL,
  `macauhinh` int NOT NULL,
  `soluongsanpham` int NOT NULL,
  `gialucmua` int NOT NULL,
  PRIMARY KEY (`machitietdonhang`),
  KEY `madonhang` (`madonhang`),
  KEY `macauhinh` (`macauhinh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_gio_hang`
--

DROP TABLE IF EXISTS `chi_tiet_gio_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_gio_hang` (
  `userid` int NOT NULL,
  `macauhinh` int NOT NULL,
  `soluong` int NOT NULL,
  `giatien` int NOT NULL,
  KEY `macauhinh` (`macauhinh`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dia_chi`
--

DROP TABLE IF EXISTS `dia_chi`;
CREATE TABLE IF NOT EXISTS `dia_chi` (
  `madiachi` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `tenduong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phuong` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tinh` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`madiachi`),
  KEY `user_id` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE IF NOT EXISTS `don_hang` (
  `madonhang` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `tongtien` int NOT NULL,
  `trangthai` int NOT NULL,
  `ngaydathang` date NOT NULL,
  PRIMARY KEY (`madonhang`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinh`
--

DROP TABLE IF EXISTS `hinh`;
CREATE TABLE IF NOT EXISTS `hinh` (
  `mahinh` int NOT NULL AUTO_INCREMENT,
  `masanpham` int NOT NULL,
  `urlhinh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`mahinh`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hinh`
--

INSERT INTO `hinh` (`mahinh`, `masanpham`, `urlhinh`) VALUES
(5, 8, '1766495793_macbook-air-13-inch.jpg'),
(6, 8, '1766495793_macbook-air-13-inch-2.jpg'),
(7, 8, '1766495793_macbook-air-13-inch-3.jpg'),
(8, 8, '1766495793_macbook-air-13-inch-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

DROP TABLE IF EXISTS `san_pham`;
CREATE TABLE IF NOT EXISTS `san_pham` (
  `masanpham` int NOT NULL AUTO_INCREMENT,
  `mathuonghieu` int NOT NULL,
  `tensanpham` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cpu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `vga` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `man_hinh` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`masanpham`),
  KEY `mathuonghieu` (`mathuonghieu`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`masanpham`, `mathuonghieu`, `tensanpham`, `cpu`, `vga`, `man_hinh`, `pin`) VALUES
(8, 8, 'Laptop MacBook Air 13 inch M4', 'Apple M4', 'Card tích hợp - 8 nhân', '13.6\" Liquid Retina (2560 x 1664)', 'Li-Po, 53.8 Wh');

-- --------------------------------------------------------

--
-- Table structure for table `thuong_hieu`
--

DROP TABLE IF EXISTS `thuong_hieu`;
CREATE TABLE IF NOT EXISTS `thuong_hieu` (
  `mathuonghieu` int NOT NULL AUTO_INCREMENT,
  `tenthuonghieu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`mathuonghieu`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thuong_hieu`
--

INSERT INTO `thuong_hieu` (`mathuonghieu`, `tenthuonghieu`) VALUES
(8, 'Macbook'),
(10, 'Lenovo'),
(11, 'aaaa');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `hoten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sdt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `matkhau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` int NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cau_hinh`
--
ALTER TABLE `cau_hinh`
  ADD CONSTRAINT `cau_hinh_ibfk_1` FOREIGN KEY (`masanpham`) REFERENCES `san_pham` (`masanpham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`madonhang`) REFERENCES `don_hang` (`madonhang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`macauhinh`) REFERENCES `cau_hinh` (`macauhinh`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `chi_tiet_gio_hang`
--
ALTER TABLE `chi_tiet_gio_hang`
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_2` FOREIGN KEY (`macauhinh`) REFERENCES `cau_hinh` (`macauhinh`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dia_chi`
--
ALTER TABLE `dia_chi`
  ADD CONSTRAINT `dia_chi_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `hinh`
--
ALTER TABLE `hinh`
  ADD CONSTRAINT `hinh_ibfk_1` FOREIGN KEY (`masanpham`) REFERENCES `san_pham` (`masanpham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`mathuonghieu`) REFERENCES `thuong_hieu` (`mathuonghieu`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
