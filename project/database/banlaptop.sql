-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 05, 2025 lúc 01:31 AM
-- Phiên bản máy phục vụ: 8.3.0
-- Phiên bản PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `banlaptop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
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
-- Cấu trúc bảng cho bảng `chi_tiet_gio_hang`
--

DROP TABLE IF EXISTS `chi_tiet_gio_hang`;
CREATE TABLE IF NOT EXISTS `chi_tiet_gio_hang` (
  `machitietgiohang` int NOT NULL AUTO_INCREMENT,
  `magiohang` int NOT NULL,
  `macauhinh` int NOT NULL,
  `soluong` int NOT NULL,
  `giatien` int NOT NULL,
  PRIMARY KEY (`machitietgiohang`),
  KEY `magiohang` (`magiohang`),
  KEY `macauhinh` (`macauhinh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dia_chi`
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
-- Cấu trúc bảng cho bảng `don_hang`
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
-- Cấu trúc bảng cho bảng `gio_hang`
--

DROP TABLE IF EXISTS `gio_hang`;
CREATE TABLE IF NOT EXISTS `gio_hang` (
  `magiohang` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `tongtien` int NOT NULL,
  PRIMARY KEY (`magiohang`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lua_chon_cau_hinh`
--

DROP TABLE IF EXISTS `lua_chon_cau_hinh`;
CREATE TABLE IF NOT EXISTS `lua_chon_cau_hinh` (
  `macauhinh` int NOT NULL AUTO_INCREMENT,
  `masanpham` int NOT NULL,
  `ram` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `ocung` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `giatien` int NOT NULL,
  PRIMARY KEY (`macauhinh`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

DROP TABLE IF EXISTS `san_pham`;
CREATE TABLE IF NOT EXISTS `san_pham` (
  `masanpham` int NOT NULL AUTO_INCREMENT,
  `mathuonghieu` int NOT NULL,
  `tensanpham` int NOT NULL,
  `cpu` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `vga` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `man_hinh` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `pin` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`masanpham`),
  KEY `mathuonghieu` (`mathuonghieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuong_hieu`
--

DROP TABLE IF EXISTS `thuong_hieu`;
CREATE TABLE IF NOT EXISTS `thuong_hieu` (
  `mathuonghieu` int NOT NULL AUTO_INCREMENT,
  `tenthuonghieu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`mathuonghieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `hoten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sdt` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `matkhau` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `role` int NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`madonhang`) REFERENCES `don_hang` (`madonhang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`macauhinh`) REFERENCES `lua_chon_cau_hinh` (`macauhinh`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_gio_hang`
--
ALTER TABLE `chi_tiet_gio_hang`
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_1` FOREIGN KEY (`magiohang`) REFERENCES `gio_hang` (`magiohang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_gio_hang_ibfk_2` FOREIGN KEY (`macauhinh`) REFERENCES `lua_chon_cau_hinh` (`macauhinh`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dia_chi`
--
ALTER TABLE `dia_chi`
  ADD CONSTRAINT `dia_chi_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lua_chon_cau_hinh`
--
ALTER TABLE `lua_chon_cau_hinh`
  ADD CONSTRAINT `lua_chon_cau_hinh_ibfk_1` FOREIGN KEY (`masanpham`) REFERENCES `san_pham` (`masanpham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`mathuonghieu`) REFERENCES `thuong_hieu` (`mathuonghieu`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
