<?php
session_start();
include "../includes/config.php"; // Gọi file kết nối

// Kiểm tra khig nhấn nút Đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Lấy dữ liệu từ form
    $hoten = trim($_POST['hoten']);
    $sdt = trim($_POST['sdt']);
    $matkhau = $_POST['matkhau'];
    $re_matkhau = $_POST['re_matkhau'];

    // 2. Kiểm tra logic cơ bản
    if ($matkhau != $re_matkhau) {
        // hiện popup báo lỗi và khi nhấn nút back sẽ quay lại trang đăng ký
        echo "<script>alert('Mật khẩu nhập lại không khớp!'); window.history.back();</script>"; 
        exit();
    }

    if($sdt == "" || $hoten == "" || $matkhau == ""){
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.history.back();</script>";
        exit();
    }

    // 3. Kiểm tra số điện thoại đã tồn tại chưa
    $sql_check = "SELECT * FROM user WHERE sdt = '$sdt'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Số điện thoại này đã được đăng ký!'); window.history.back();</script>";
        exit();
    }

    // 4. Mã hóa mật khẩu 
    $matkhau_hash = password_hash($matkhau, PASSWORD_DEFAULT);

    // 5. Thêm vào CSDL
    $sql_insert = "INSERT INTO user (hoten, sdt, matkhau, role) VALUES ('$hoten', '$sdt', '$matkhau_hash', 0)";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>
                alert('Đăng ký thành công!);
                window.location.href = '../index.php';
              </script>";
    } else {
        echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
    }

    $conn->close();
}
?>