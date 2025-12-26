-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.infinityfree.com
-- Generation Time: Dec 25, 2025 at 07:59 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40213153_banlaptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cau_hinh`
--

CREATE TABLE `cau_hinh` (
  `macauhinh` int(11) NOT NULL,
  `masanpham` int(11) NOT NULL,
  `ram` varchar(10) NOT NULL,
  `ocung` varchar(10) NOT NULL,
  `giatien` int(11) NOT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cau_hinh`
--

INSERT INTO `cau_hinh` (`macauhinh`, `masanpham`, `ram`, `ocung`, `giatien`, `soluong`) VALUES
(12, 11, '16GB', '256GB', 25790000, 28),
(13, 11, '16GB', '512GB', 30000000, 23),
(14, 12, '8', '512', 1999999, 3),
(15, 13, '16GB', '512GB', 15890000, 40),
(16, 14, '16GB', '512GB', 21190000, 30),
(17, 15, '32GB', '512GB', 23890000, 10),
(18, 16, '16GB', '512GB', 14890000, 23),
(21, 18, '24GB', '512GB', 49990000, 6),
(22, 18, '16GB', '512GB', 45690000, 9),
(23, 18, '16GB', '1TB', 50490000, 3),
(24, 19, '8GB', '256GB', 10690000, 26),
(25, 19, '16GB', '256GB', 12490000, 29);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `machitietdonhang` int(11) NOT NULL,
  `madonhang` int(11) NOT NULL,
  `macauhinh` int(11) NOT NULL,
  `soluongsanpham` int(11) NOT NULL,
  `gialucmua` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`machitietdonhang`, `madonhang`, `macauhinh`, `soluongsanpham`, `gialucmua`) VALUES
(1, 1, 12, 1, 25790000),
(4, 14, 13, 1, 30000000),
(5, 14, 12, 1, 25790000),
(6, 15, 13, 4, 30000000),
(7, 17, 14, 2, 1999999);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_gio_hang`
--

CREATE TABLE `chi_tiet_gio_hang` (
  `userid` int(11) NOT NULL,
  `macauhinh` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `giatien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dia_chi`
--

CREATE TABLE `dia_chi` (
  `madiachi` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `tenduong` varchar(100) NOT NULL,
  `phuong` varchar(50) NOT NULL,
  `tinh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dia_chi`
--

INSERT INTO `dia_chi` (`madiachi`, `userid`, `tenduong`, `phuong`, `tinh`) VALUES
(1, 2, '123 Quận 8', '', ''),
(6, 1, '123', '', ''),
(7, 3, '123 concu', '', ''),
(9, 4, '123 ABC', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `madonhang` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `tongtien` int(11) NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ngaydathang` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`madonhang`, `userid`, `tongtien`, `trangthai`, `ngaydathang`) VALUES
(1, 2, 25790000, 1, '2025-12-25'),
(14, 1, 55790000, 2, '2025-12-25'),
(15, 3, 120000000, 2, '2025-12-25'),
(17, 4, 3999998, 1, '2025-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `hinh`
--

CREATE TABLE `hinh` (
  `mahinh` int(11) NOT NULL,
  `masanpham` int(11) NOT NULL,
  `urlhinh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hinh`
--

INSERT INTO `hinh` (`mahinh`, `masanpham`, `urlhinh`) VALUES
(15, 11, '1766592895_macbook-air-13-inch.jpg'),
(16, 11, '1766592895_macbook-air-13-inch-2.jpg'),
(17, 11, '1766592895_macbook-air-13-inch-3.jpg'),
(18, 11, '1766592895_macbook-air-13-inch-4.jpg'),
(19, 12, '1766655739_macbook-pro-14-inch-m2-pro.jpg'),
(20, 13, '1766682702_lenovo_slim_3_1.jpg'),
(21, 13, '1766682702_lenovo_slim_3_2.jpg'),
(22, 13, '1766682702_lenovo_slim_3_3.jpg'),
(23, 15, '1766682967_lenovo-ideapad-slim-5-oled-1.jpg'),
(24, 15, '1766682967_lenovo-ideapad-slim-5-oled-2.jpg'),
(25, 15, '1766682967_lenovo-ideapad-slim-5-oled-3.jpg'),
(26, 14, '1766683030_lenovo-loq-1.jpg'),
(27, 14, '1766683030_lenovo-loq-2.jpg'),
(28, 14, '1766683030_lenovo-loq-3.jpg'),
(29, 16, '1766683149_acer-aspire-lite-15-1.jpg'),
(30, 16, '1766683149_acer-aspire-lite-15-2.jpg'),
(31, 16, '1766683149_acer-aspire-lite-15-3.jpg'),
(32, 18, '1766683419_macbook-pro-1.jpg'),
(33, 18, '1766683419_macbook-pro-2.jpg'),
(34, 19, '1766683713_acer-aspire-go-1.jpg'),
(35, 19, '1766683713_acer-aspire-go-2.jpg'),
(36, 19, '1766683713_acer-aspire-go-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `masanpham` int(11) NOT NULL,
  `mathuonghieu` int(11) NOT NULL,
  `tensanpham` varchar(150) NOT NULL,
  `cpu` varchar(50) NOT NULL,
  `vga` varchar(50) NOT NULL,
  `man_hinh` varchar(50) NOT NULL,
  `pin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`masanpham`, `mathuonghieu`, `tensanpham`, `cpu`, `vga`, `man_hinh`, `pin`) VALUES
(11, 8, 'MacBook Air 13 inch M4', 'Apple M4', ' Card tích hợp - 8 nhân GPU', '13.6\" Liquid Retina (2560 x 1664)', 'LiPo, 53.8 Wh'),
(12, 8, 'Mạc bục', 'Core i5', 'intel', '14 inch', '100wh'),
(13, 10, 'Lenovo IdeaPad Slim 3 15IRH10 ', 'Core i5 13420H', 'Intel UHD Graphics', '15.3\"  WUXGA (1920 x 1200)', '60 Wh'),
(14, 10, 'Lenovo Gaming LOQ 15IAX9E', 'Core i5 12450HX', 'RTX 3050 6GB', '15.6\" Full HD (1920 x 1080)', '57Wh'),
(15, 10, 'Lenovo IdeaPad Slim 5 OLED', 'Ryzen AI 5 - 340', 'AMD Radeon 840M', '14\" WUXGA (1920 x 1200) - OLED', '60 Wh'),
(16, 12, 'Acer Aspire Lite 15', 'Core i5 12450H', 'Intel UHD Graphics', '15.6\"  Full HD (1920 x 1080)', '3-cell Li-ion, 58 Wh'),
(18, 8, 'MacBook Pro 14 inch', 'Apple M4 Pro', 'Card tích hợp - 16 nhân GPU', '14.2\" Liquid Retina XDR display (3024 x 1964)', 'Li-Po, 72.4 Wh'),
(19, 12, 'Acer Aspire Go AG15', 'Core i3 N305', 'Intel UHD Graphics', '15.6\" Full HD (1920 x 1080)', ' 3-cell, 50Wh');

-- --------------------------------------------------------

--
-- Table structure for table `thuong_hieu`
--

CREATE TABLE `thuong_hieu` (
  `mathuonghieu` int(11) NOT NULL,
  `tenthuonghieu` varchar(50) NOT NULL,
  `trangthai` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thuong_hieu`
--

INSERT INTO `thuong_hieu` (`mathuonghieu`, `tenthuonghieu`, `trangthai`) VALUES
(8, 'Macbook', 1),
(10, 'Lenovo', 1),
(12, 'Acer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `sdt` varchar(10) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `hoten`, `sdt`, `matkhau`, `role`) VALUES
(1, 'Nguyễn Đình Phương', '0123456789', '$2y$12$vgIR/YidKmHKgmrHOzIdtuuUFZqw8XN58j.3DXvz2JK.Q/wrCbL2m', 1),
(2, 'Đại Ca', '0123456781', '$2y$12$snsSmY.7EkQtCPAbF/YdmecZKCoCt0hUusRfgWC6LJ/bs.XOELEOG', 0),
(3, 'Hắc cơ mũ zàng', '0123456789', '$2y$10$36bqDu87jH6JmCH/cBvosunW.mTOPB5bLqoPW8Rz4hoMbpEGQ/hwO', 0),
(4, 'Nguyen Van Cu', '0123456780', '$2y$10$E93fKXNfor6Qtsr2cQla5e7ibeb20dS/8Ajwg3o2ARH.TXjqVp6xK', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cau_hinh`
--
ALTER TABLE `cau_hinh`
  ADD PRIMARY KEY (`macauhinh`),
  ADD KEY `masanpham` (`masanpham`);

--
-- Indexes for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`machitietdonhang`),
  ADD KEY `madonhang` (`madonhang`),
  ADD KEY `macauhinh` (`macauhinh`);

--
-- Indexes for table `chi_tiet_gio_hang`
--
ALTER TABLE `chi_tiet_gio_hang`
  ADD KEY `macauhinh` (`macauhinh`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `dia_chi`
--
ALTER TABLE `dia_chi`
  ADD PRIMARY KEY (`madiachi`),
  ADD KEY `user_id` (`userid`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`madonhang`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `hinh`
--
ALTER TABLE `hinh`
  ADD PRIMARY KEY (`mahinh`),
  ADD KEY `masanpham` (`masanpham`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`masanpham`),
  ADD KEY `mathuonghieu` (`mathuonghieu`);

--
-- Indexes for table `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  ADD PRIMARY KEY (`mathuonghieu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cau_hinh`
--
ALTER TABLE `cau_hinh`
  MODIFY `macauhinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `machitietdonhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dia_chi`
--
ALTER TABLE `dia_chi`
  MODIFY `madiachi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `madonhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `hinh`
--
ALTER TABLE `hinh`
  MODIFY `mahinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `masanpham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  MODIFY `mathuonghieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`macauhinh`) REFERENCES `cau_hinh` (`macauhinh`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`mathuonghieu`) REFERENCES `thuong_hieu` (`mathuonghieu`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
