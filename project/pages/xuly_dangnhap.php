<?php
session_start();
include "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $sdt = trim($_POST['username']);
    $matkhau = $_POST['password'];

    // 1. Tìm user theo số điện thoại
    $sql = "SELECT * FROM user WHERE sdt = '$sdt'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy dữ liệu user ra
        $row = $result->fetch_assoc();
        
        // 2. Kiểm tra mật khẩu (So sánh mật khẩu nhập vào với mật khẩu mã hóa trong DB)
        if (password_verify($matkhau, $row['matkhau'])) {
            
            // 3. Đăng nhập thành công -> Lưu vào SESSION
            $_SESSION['current_user'] = $row; 
            // Lưu mảng chứa: userid, hoten, sdt, role...

            // Kiểm tra role để chuyển hướng 
            if ($row['role'] == 1) {
                // header("Location: admin/index.php"); 
                header("Location: ../admin/admin.php"); 
            } else {
                 echo "<script>alert('Đăng nhập thành công!);
                        window.location.href = '../index.php';</script>";
                
                header("Location: ../index.php");
            }
            
        } else {
            echo "<script>alert('Mật khẩu không đúng!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Số điện thoại này chưa được đăng ký!'); window.history.back();</script>";
    }
    
    $conn->close();
}
?>