<?php
session_start();
include "../includes/config.php"; // Chứa biến kết nối $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Lấy dữ liệu
    $hoten = trim($_POST['hoten']);
    $sdt = trim($_POST['sdt']);
    $matkhau = $_POST['matkhau'];
    $re_matkhau = $_POST['re_matkhau'];

    // 2. Kiểm tra dữ liệu rỗng
    if($sdt == "" || $hoten == "" || $matkhau == ""){
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.history.back();</script>";
        exit();
    }

    // 3. Kiểm tra mật khẩu nhập lại
    if ($matkhau != $re_matkhau) {
        echo "<script>alert('Mật khẩu nhập lại không khớp!'); window.history.back();</script>"; 
        exit();
    }

    // 4. Kiểm tra số điện thoại đã tồn tại chưa (Dùng PDO)
    $sql_check = "SELECT COUNT(*) FROM user WHERE sdt = :sdt";
    $stmt = $pdo->prepare($sql_check);
    $stmt->bindParam(':sdt', $sdt);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Số điện thoại này đã được đăng ký!'); window.history.back();</script>";
        exit();
    }

    // 5. Mã hóa mật khẩu 
    $matkhau_hash = password_hash($matkhau, PASSWORD_DEFAULT);

    // 6. Thêm vào CSDL (Dùng PDO)
    $sql_insert = "INSERT INTO user (hoten, sdt, matkhau, role) VALUES (:hoten, :sdt, :matkhau, 0)";
    $stmt = $pdo->prepare($sql_insert);
    $stmt->bindParam(':hoten', $hoten);
    $stmt->bindParam(':sdt', $sdt);
    $stmt->bindParam(':matkhau', $matkhau_hash);

    if ($stmt->execute()) {
        // 1. Lấy ID vừa được tạo ra (vì id tự tăng)
        $new_id = $pdo->lastInsertId();

        // 2. Lưu thông tin người dùng vào Session (Giống hệt lúc đăng nhập)
        $_SESSION['current_user'] = [
            'userid'  => $new_id,
            'hoten'   => $hoten,
            'sdt'     => $sdt,
            'role'    => 0 // Mặc định là khách hàng
            // Lưu ý: Không lưu mật khẩu vào session cho an toàn
        ];
        echo "<script>
                alert('Đăng ký thành công!');
                window.location.href = '../index.php'; // Chuyển về trang đăng nhập
              </script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.history.back();</script>";
    }
}
?>