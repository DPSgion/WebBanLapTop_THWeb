<?php
// 1. Khởi tạo session & Include
if (session_status() === PHP_SESSION_NONE) {
     session_start(); 
    }
include("../config/configDB.php");
include("../includes/functions.php");
$path = "..";

$isLoggedIn = isset($_SESSION['current_user']) ? 'true' : 'false';


// 2. Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

// 3. LOGIC: THÊM VÀO GIỎ HÀNG (Khi nhận form từ trang chi tiết)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['btn_buy']) || isset($_POST['btn_add']))) {
    
    $p_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    // Sửa: Dùng intval vì mã cấu hình trong DB là số
    $p_config = isset($_POST['macauhinh']) ? intval($_POST['macauhinh']) : 0; 
    $qty = 1;

    if ($p_id > 0 && $p_config > 0) { // Kiểm tra config > 0
        // Gọi hàm từ functions.php để lấy thông tin hiển thị
        $item = getThongTinGioHang($pdo, $p_id, $p_config);

        if ($item) {
            // A. LƯU VÀO SESSION (Để hiển thị ngay lập tức)
            $key = $p_id . '_' . $p_config; 

            if (isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key]['qty'] += $qty; 
            } else {
                $_SESSION['cart'][$key] = [
                    'id'          => $p_id,
                    'macauhinh'   => $p_config,
                    'name'        => $item['tensanpham'],
                    'image'       => $item['urlhinh'],
                    'price'       => $item['giatien'],
                    'config_desc' => $item['ram'] . ' - ' . $item['ocung'],
                    'qty'         => $qty,
                    'selected'    => 1 
                ];
            }

            // B. LƯU VÀO DATABASE (QUAN TRỌNG: Chỉ chạy khi đã đăng nhập)
            // ------------------------------------------------------------------
            if (isset($_SESSION['current_user'])) {
                $user_id = $_SESSION['current_user']['userid'];
                $price   = $item['giatien']; 

                // Kiểm tra xem user này đã có sản phẩm cấu hình này trong DB chưa
                $sql_check = "SELECT * FROM chi_tiet_gio_hang 
                              WHERE userid = :uid AND macauhinh = :mch";
                $stmt_check = $pdo->prepare($sql_check);
                $stmt_check->execute([':uid' => $user_id, ':mch' => $p_config]);

                if ($stmt_check->rowCount() > 0) {
                    // TRƯỜNG HỢP 1: Đã có -> UPDATE cộng dồn số lượng
                    $sql_update = "UPDATE chi_tiet_gio_hang 
                                   SET soluong = soluong + :sl 
                                   WHERE userid = :uid AND macauhinh = :mch";
                    $stmt_update = $pdo->prepare($sql_update);
                    $stmt_update->execute([':sl' => $qty, ':uid' => $user_id, ':mch' => $p_config]);
                } else {
                    // TRƯỜNG HỢP 2: Chưa có -> INSERT mới
                    $sql_insert = "INSERT INTO chi_tiet_gio_hang (userid, macauhinh, soluong, giatien) 
                                   VALUES (:uid, :mch, :sl, :gia)";
                    $stmt_insert = $pdo->prepare($sql_insert);
                    $stmt_insert->execute([
                        ':uid' => $user_id,
                        ':mch' => $p_config,
                        ':sl'  => $qty,
                        ':gia' => $price
                    ]);
                }
            }
            // ------------------------------------------------------------------

            // Chuyển hướng để tránh lỗi F5 resubmit form
            header("Location: giohang.php");
            exit();
        }
    }
}

// 4. INCLUDE HEADER (SAU KHI ĐÃ XỬ LÝ LOGIC XONG)
include("../includes/header.php");

// 4. Tính tổng tiền
$total_money = 0;
$total_count = 0;
foreach ($_SESSION['cart'] as $item) {
    // Kiểm tra nếu chưa có key 'selected' thì gán mặc định là 1 (đề phòng giỏ hàng cũ)
    if (!isset($item['selected'])) $item['selected'] = 1;

    // Chỉ cộng tiền nếu sản phẩm được chọn (selected == 1)
    if ($item['selected'] == 1) {
        $total_money += $item['price'] * $item['qty'];
    }
    $total_count += $item['qty'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="cart-page-container">
        <div class="container">
            <div class="cart-header-title">
                <a href="../index.php" class="back-home"> << Về trang chủ</a>
                <h3>Giỏ hàng </h3>
            </div>

            <!-- Tiêu đề -->
            <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-layout">
                <div class="cart-left">
                    <div class="cart-table-header">
                        <div class="ct-checkbox"><input type="checkbox" id="check-all"> Tất cả</div>
                        <div class="ct-info">Sản phẩm</div>
                        <div class="ct-qty">Số lượng</div>
                        <div class="ct-price">Thành tiền</div>
                        <div class="ct-action">Xóa</div>
                    </div>

                    <!-- Các ô checkbox sản phẩm -->
                    <?php foreach ($_SESSION['cart'] as $key => $sp): ?>
                    <div class="cart-item" id="item-<?php echo $key; ?>">
                        <div class="ci-checkbox">
                            <input type="checkbox" class="item-checkbox" 
                                <?php echo (isset($sp['selected']) && $sp['selected'] == 1) ? 'checked' : ''; ?> 
                                data-key="<?php echo $key; ?>" 
                                data-price="<?php echo $sp['price']; ?>">
                        </div>
                        <div class="ci-img">
                            <img src="../upload/<?php echo $sp['image']; ?>" alt="Laptop">
                        </div>
                        <div class="ci-info">
                            <a href="chitietsanpham.php?id=<?php echo $sp['id']; ?>" class="ci-name">
                                <?php echo $sp['name']; ?>
                            </a>
                            <p class="ci-variant">Cấu hình: <?php echo $sp['config_desc']; ?></p>
                            <p class="ci-price-one">Đơn giá: <?php echo formatCurrency($sp['price']); ?></p>
                        </div>

                        <div class="ci-qty">
                            <!-- Số lượng SP -->
                            <div class="qty-control">
                                <button class="btn-decrease" data-key="<?php echo $key; ?>">-</button>

                                <input type="number" class="qty-input" value="<?php echo $sp['qty']; ?>" 
                                       min="1" readonly data-key="<?php echo $key; ?>"
                                       autocomplete="off">

                                <button class="btn-increase" data-key="<?php echo $key; ?>">+</button>
                            </div>
                        </div>
                        <div class="ci-total-price item-total">
                            <?php echo formatCurrency($sp['price'] * $sp['qty']); ?>
                        </div>
                        <div class="ci-action">
                            <a href="xuly_giohang.php?action=delete&key=<?php echo $key; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Bạn muốn xóa sản phẩm này?');">
                                <img src="../assets/images/icons-recycle-bin.png" alt="Xóa">
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-right">
                    <div class="cart-summary-box">
                        <div class="cs-row total">
                            <span>Tổng tiền:</span>
                            <span class="final-price"><?php echo formatCurrency($total_money); ?></span>
                        </div>
                        <button class="btn-checkout" id="btn-open-modal" >TIẾN HÀNH ĐẶT HÀNG</button>
                        <a href="../index.php" class="continue-shopping">Chọn thêm sản phẩm khác</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: white;">
                     <p>Giỏ hàng của bạn đang trống!</p>
                     <a href="../index.php" style="color: #d70018; font-weight: bold;">Mua sắm ngay</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="checkout-modal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h3>THÔNG TIN GIAO HÀNG</h3>
                <p>Vui lòng điền thông tin để hoàn tất đơn hàng</p>
            </div>
            <form action="xuly_dathang.php" method="POST" class="checkout-form">
                <?php 
                    $u_name = isset($_SESSION['current_user']) ? $_SESSION['current_user']['hoten'] : '';
                    $u_phone = isset($_SESSION['current_user']) ? $_SESSION['current_user']['sdt'] : '';
                ?>
                <div class="form-group">
                     <!-- Không cho phép sửa -->
                    <label>Họ và tên người nhận</label>
                    <input type="text" name="hoten" value="<?php echo $u_name; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label> 
                   
                    <input type="tel" name="sdt" value="<?php echo $u_phone; ?>" readonly> 
                </div>
                <div class="form-group">
                    <label>Địa chỉ giao hàng</label>
                    <input type="text" name="diachi" placeholder="Số nhà, tên đường, phường/xã..." required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel">Hủy bỏ</button>
                    <button type="submit" class="btn-confirm">XÁC NHẬN ĐẶT HÀNG</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // 1. TRUYỀN BIẾN PHP SANG JS
    var userDaDangNhap = <?php echo $isLoggedIn; ?>; 
    </script>

    <script src="../assets/js/main.js"></script>
</body>
</html>