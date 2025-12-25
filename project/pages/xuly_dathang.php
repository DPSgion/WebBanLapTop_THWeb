<?php
session_start();
include("../config/configDB.php"); 

// 1. KIỂM TRA ĐĂNG NHẬP
if (!isset($_SESSION['current_user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/dangnhap.php");
    exit();
}

$user_id = $_SESSION['current_user']['userid']; 
$diachi_moi = $_POST['diachi'] ?? ''; 

// Validate
if (empty($diachi_moi)) {
    echo "<script>alert('Vui lòng nhập địa chỉ giao hàng!'); window.history.back();</script>";
    exit();
}

// Lấy thông tin giỏ hàng
$cart = $_SESSION['cart'] ?? [];
$items_to_buy = [];
$total_money = 0;

foreach ($cart as $key => $item) {
    // Chỉ lấy sản phẩm được chọn
    if (isset($item['selected']) && $item['selected'] == 1) {
        $items_to_buy[$key] = $item;
        $total_money += $item['price'] * $item['qty'];
    }
}

if (empty($items_to_buy)) {
    echo "<script>alert('Giỏ hàng trống hoặc chưa chọn sản phẩm!'); window.history.back();</script>";
    exit();
}

try {
    $pdo->beginTransaction();

    // BƯỚC 1: CẬP NHẬT ĐỊA CHỈ (Code cũ - Giữ nguyên)
    $stmt_check = $pdo->prepare("SELECT madiachi FROM dia_chi WHERE userid = :uid");
    $stmt_check->execute([':uid' => $user_id]);
    
    if ($stmt_check->rowCount() > 0) {
        $sql_update_addr = "UPDATE dia_chi SET tenduong = :dc WHERE userid = :uid";
        $stmt_addr = $pdo->prepare($sql_update_addr);
        $stmt_addr->execute([':dc' => $diachi_moi, ':uid' => $user_id]);
    } else {
        $sql_insert_addr = "INSERT INTO dia_chi (userid, tenduong, phuong, tinh) VALUES (:uid, :dc, '', '')";
        $stmt_addr = $pdo->prepare($sql_insert_addr);
        $stmt_addr->execute([':uid' => $user_id, ':dc' => $diachi_moi]);
    }

    // BƯỚC 2: TẠO ĐƠN HÀNG (Code cũ - Giữ nguyên)
    $sql_order = "INSERT INTO don_hang (userid, tongtien, trangthai, ngaydathang) 
                  VALUES (:uid, :tt, 0, NOW())";
    $stmt = $pdo->prepare($sql_order);
    $stmt->execute([':uid' => $user_id, ':tt'  => $total_money]);
    $order_id = $pdo->lastInsertId();

    // BƯỚC 3: XỬ LÝ CHI TIẾT & KHO & XÓA GIỎ DB
    $sql_detail = "INSERT INTO chi_tiet_don_hang (madonhang, macauhinh, soluongsanpham, gialucmua) 
                   VALUES (:dh_id, :mch, :sl, :gia)";
    $stmt_detail = $pdo->prepare($sql_detail);

    $sql_stock = "UPDATE cau_hinh SET soluong = soluong - :sl 
                  WHERE macauhinh = :mch AND soluong >= :sl";
    $stmt_stock = $pdo->prepare($sql_stock);

    // --- [MỚI] CHUẨN BỊ CÂU LỆNH XÓA KHỎI GIỎ HÀNG DB ---
    $sql_delete_cart = "DELETE FROM chi_tiet_gio_hang WHERE userid = :uid AND macauhinh = :mch";
    $stmt_delete_cart = $pdo->prepare($sql_delete_cart);
    // ----------------------------------------------------

    foreach ($items_to_buy as $item) {
        // 1. Trừ kho
        $stmt_stock->execute([':sl' => $item['qty'], ':mch' => $item['macauhinh']]);
        if ($stmt_stock->rowCount() == 0) {
            throw new Exception("Sản phẩm " . $item['name'] . " đã hết hàng!");
        }

        // 2. Lưu chi tiết đơn hàng
        $stmt_detail->execute([
            ':dh_id' => $order_id,
            ':mch'   => $item['macauhinh'],
            ':sl'    => $item['qty'],
            ':gia'   => $item['price']
        ]);

        // --- [MỚI] THỰC HIỆN XÓA SẢN PHẨM KHỎI DB ---
        // Chỉ xóa đúng cấu hình vừa mua của user đó
        $stmt_delete_cart->execute([
            ':uid' => $user_id, 
            ':mch' => $item['macauhinh']
        ]);
        // --------------------------------------------
    }

    $pdo->commit();

    // BƯỚC 4: XÓA SESSION (Chỉ xóa trên trình duyệt)
    foreach ($items_to_buy as $key => $val) { 
        unset($_SESSION['cart'][$key]); 
    }

    // BƯỚC 5: THÔNG BÁO VÀ CHUYỂN TRANG
    echo "<script>
            alert('Đặt hàng thành công! Mã đơn: #$order_id');
            window.location.href = '../index.php';
          </script>";
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
}
?>