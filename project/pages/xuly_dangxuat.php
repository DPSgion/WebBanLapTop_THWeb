<?php
session_start(); // 1. Khởi động session để biết đang xóa cái gì

// 2. Kiểm tra nếu đang đăng nhập thì xóa biến session đó đi
if (isset($_SESSION['current_user'])) {
    unset($_SESSION['current_user']); 
}

// 3. Hủy toàn bộ phiên làm việc (Xóa sạch sành sanh cho an toàn)
session_destroy();

// 4. Thông báo và chuyển hướng về trang chủ
echo "<script>
        alert('Đăng xuất thành công! Hẹn gặp lại.');
        window.location.href = '../index.php';
      </script>";
exit();
?>