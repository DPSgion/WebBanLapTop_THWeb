<?php
session_start();
include("../config/configDB.php"); // Đảm bảo đường dẫn đúng

// Kiểm tra user có đăng nhập không để xử lý DB
$is_logged_in = isset($_SESSION['current_user']);
$user_id = $is_logged_in ? $_SESSION['current_user']['userid'] : 0;

// Lấy tham số từ AJAX gửi lên
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$key    = isset($_REQUEST['key']) ? $_REQUEST['key'] : ''; // Dạng: id_macauhinh (VD: 10_2)

// Tách key để lấy mã cấu hình (Phục vụ cho query DB)
$macauhinh = 0;
if (!empty($key) && strpos($key, '_') !== false) {
    $parts = explode('_', $key);
    // $parts[0] là id sản phẩm, $parts[1] là mã cấu hình
    $macauhinh = isset($parts[1]) ? intval($parts[1]) : 0;
}

// =================================================================
// TRƯỜNG HỢP 1: XÓA SẢN PHẨM (DELETE)
// =================================================================
if ($action === 'delete') {
    if (isset($_SESSION['cart'][$key])) {
        // 1. Xóa trong Session
        unset($_SESSION['cart'][$key]);

        // 2. Xóa trong Database (Nếu đã đăng nhập)
        if ($is_logged_in && $macauhinh > 0) {
            $sql = "DELETE FROM chi_tiet_gio_hang 
                    WHERE userid = :uid AND macauhinh = :mch";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':uid' => $user_id, ':mch' => $macauhinh]);
        }
    }
    
    // Quay lại trang giỏ hàng
    header("Location: giohang.php");
    exit();
}

// =================================================================
// TRƯỜNG HỢP 2: CẬP NHẬT SỐ LƯỢNG (UPDATE QUANTITY)
// =================================================================
if ($action === 'update_qty') {
    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;
    if ($qty < 1) $qty = 1;

    if (isset($_SESSION['cart'][$key])) {
        // 1. Cập nhật Session
        $_SESSION['cart'][$key]['qty'] = $qty;

        // 2. Cập nhật Database (Nếu đã đăng nhập)
        if ($is_logged_in && $macauhinh > 0) {
            $sql = "UPDATE chi_tiet_gio_hang SET soluong = :sl 
                    WHERE userid = :uid AND macauhinh = :mch";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':sl' => $qty, ':uid' => $user_id, ':mch' => $macauhinh]);
        }
        echo "Cập nhật thành công";
    }
    exit();
}

// =================================================================
// TRƯỜNG HỢP 3: CẬP NHẬT TRẠNG THÁI CHECKBOX (SELECTED)
// =================================================================
if ($action === 'update_select') {
    $status = isset($_POST['status']) ? intval($_POST['status']) : 1;
    
    if (isset($_SESSION['cart'][$key])) {
        // Chỉ cập nhật Session (Vì bảng DB của bạn không có cột 'selected')
        $_SESSION['cart'][$key]['selected'] = $status;
    }
    exit();
}
?>