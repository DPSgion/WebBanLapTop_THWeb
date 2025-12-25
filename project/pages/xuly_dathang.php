<?php
session_start();
include("../includes/config.php"); 

// 1. KIỂM TRA ĐĂNG NHẬP
if (!isset($_SESSION['current_user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /dangnhap.php");
    exit();
}

$user_id = $_SESSION['current_user']['userid']; 
$diachi_moi = $_POST['diachi'] ?? ''; // Địa chỉ khách vừa sửa trong form

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
    if (isset($item['selected']) && $item['selected'] == 1) {
        $items_to_buy[$key] = $item;
        $total_money += $item['price'] * $item['qty'];
    }
}

if (empty($items_to_buy)) {
    echo "<script>alert('Giỏ hàng trống!'); window.history.back();</script>";
    exit();
}

try {
    $pdo->beginTransaction();

    // ---------------------------------------------------------
    // BƯỚC 1: CẬP NHẬT ĐỊA CHỈ MỚI VÀO BẢNG `dia_chi`
    // Vì bảng don_hang không có cột địa chỉ, ta phải lưu vào bảng dia_chi
    // Giả sử ta lưu hết vào cột `tenduong`, các cột phuong/tinh để trống hoặc mặc định
    // ---------------------------------------------------------
    
    // Kiểm tra xem user này đã có dòng nào trong bảng dia_chi chưa
    $stmt_check = $pdo->prepare("SELECT madiachi FROM dia_chi WHERE userid = :uid");
    $stmt_check->execute([':uid' => $user_id]);
    
    if ($stmt_check->rowCount() > 0) {
        // Nếu có rồi -> Update
        $sql_update_addr = "UPDATE dia_chi SET tenduong = :dc WHERE userid = :uid";
        $stmt_addr = $pdo->prepare($sql_update_addr);
        $stmt_addr->execute([':dc' => $diachi_moi, ':uid' => $user_id]);
    } else {
        // Nếu chưa có -> Insert mới
        $sql_insert_addr = "INSERT INTO dia_chi (userid, tenduong, phuong, tinh) VALUES (:uid, :dc, '', '')";
        $stmt_addr = $pdo->prepare($sql_insert_addr);
        $stmt_addr->execute([':uid' => $user_id, ':dc' => $diachi_moi]);
    }

    // ---------------------------------------------------------
    // BƯỚC 2: TẠO ĐƠN HÀNG (Bảng don_hang cũ của bạn)
    // ---------------------------------------------------------
    $sql_order = "INSERT INTO don_hang (userid, tongtien, trangthai, ngaydathang) 
                  VALUES (:uid, :tt, 0, NOW())";
    
    $stmt = $pdo->prepare($sql_order);
    $stmt->execute([
        ':uid' => $user_id,
        ':tt'  => $total_money
    ]);

    $order_id = $pdo->lastInsertId();

    // ---------------------------------------------------------
    // BƯỚC 3: LƯU CHI TIẾT & TRỪ KHO
    // ---------------------------------------------------------
    $sql_detail = "INSERT INTO chi_tiet_don_hang (madonhang, macauhinh, soluongsanpham, gialucmua) 
                   VALUES (:dh_id, :mch, :sl, :gia)";
    $stmt_detail = $pdo->prepare($sql_detail);

    $sql_stock = "UPDATE cau_hinh SET soluong = soluong - :sl 
                  WHERE macauhinh = :mch AND soluong >= :sl";
    $stmt_stock = $pdo->prepare($sql_stock);

    foreach ($items_to_buy as $item) {
        // Trừ kho
        $stmt_stock->execute([':sl' => $item['qty'], ':mch' => $item['macauhinh']]);
        
        if ($stmt_stock->rowCount() == 0) {
            throw new Exception("Sản phẩm " . $item['name'] . " đã hết hàng!");
        }

        // Lưu chi tiết
        $stmt_detail->execute([
            ':dh_id' => $order_id,
            ':mch'   => $item['macauhinh'],
            ':sl'    => $item['qty'],
            ':gia'   => $item['price']
        ]);
    }

    $pdo->commit();

    // Xóa giỏ hàng đã mua
    foreach ($items_to_buy as $key => $val) {
         unset($_SESSION['cart'][$key]); 
        }

    echo "<script>
            alert('Đặt hàng thành công! Mã đơn hàng của bạn là: $order_id');
            window.location.href = '../index.php';
          </script>";
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
}
?>