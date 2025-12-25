<?php
session_start();

// Kiểm tra request POST từ AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $key    = isset($_POST['key']) ? $_POST['key'] : '';

    if (isset($_SESSION['cart'][$key])) {
        
        // 1. Cập nhật số lượng (JS gửi action là 'update_qty')
        if ($action === 'update_qty') {
            $qty = intval($_POST['qty']);
            if ($qty > 0) {
                $_SESSION['cart'][$key]['qty'] = $qty;
            }
        }
        
        // 2. Cập nhật trạng thái Checkbox
        if ($action === 'update_select') {
            $selected = intval($_POST['status']); 
            $_SESSION['cart'][$key]['selected'] = $selected;
        }
    }
    
    echo "ok"; 
    exit;
}

// Xử lý xóa sản phẩm (GET request từ thẻ a href)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $key = $_GET['key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: giohang.php");
    exit();
}
?>