<?php
// Thông tin kết nối
$servername = "localhost";
$username = "root";
$password = ""; // Mặc định XAMPP là rỗng
$dbname = "banlaptop"; // Tên database của bạn
$port=3307;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập bảng mã UTF-8 để không bị lỗi font tiếng Việt
$conn->set_charset("utf8");
?>