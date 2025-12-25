<?php
session_start();
include "../includes/config.php"; // Chứa biến kết nối $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $sdt = trim($_POST['username']); // Input name bên form đăng nhập là username
    $matkhau = $_POST['password'];   // Input name bên form đăng nhập là password

    // 1. Tìm user theo số điện thoại (Dùng PDO)
    $sql = "SELECT * FROM user WHERE sdt = :sdt";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sdt', $sdt);
    $stmt->execute();
    
    // Lấy dòng dữ liệu
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Kiểm tra xem có tìm thấy user không
    if ($user) {
        
        // 3. Kiểm tra mật khẩu (So sánh hash)
        if (password_verify($matkhau, $user['matkhau'])) {
            
            // Đăng nhập thành công -> Lưu Session
            $_SESSION['current_user'] = $user; 
            
            // Kiểm tra Role để chuyển hướng
            if ($user['role'] == 1) {
                // Là Admin
                echo "<script>
                        alert('Xin chào Admin: " . $user['hoten'] . "');
                        window.location.href = '../admin/admin.php';
                      </script>";
            } else {
                // Là Khách hàng
                echo "<script>
                        alert('Đăng nhập thành công! Xin chào: " . $user['hoten'] . "');
                        window.location.href = '../index.php';
                      </script>";
            }
            exit();

        } else {
            // Sai mật khẩu
            echo "<script>alert('Mật khẩu không đúng!'); window.history.back();</script>";
            exit();
        }
    } else {
        // Không tìm thấy SĐT
        echo "<script>alert('Số điện thoại này chưa được đăng ký!'); window.history.back();</script>";
        exit();
    }
}
?>