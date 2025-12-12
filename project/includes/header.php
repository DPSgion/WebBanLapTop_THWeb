<?php
// Tự động xác định đường dẫn base dựa trên vị trí file include
$basePath = '';
if (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) {
    // Nếu đang ở trong thư mục pages, cần lên 1 cấp
    $basePath = '../';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
</head>
<body>
    <div class="header">
        <div class="header-container">
            <section class="header-bar">
                <ul>
                    <li><img src="<?php echo $basePath; ?>assets/images/logolaptop.png" alt="logo-header"></li>
                    <li><input type="search" class="header-bar-search" placeholder="Nhập tên điện thoại, máy tính..."></li>
                    <li><img src="<?php echo $basePath; ?>assets/images/user.png" alt="user-header" >Đăng nhập</li>
                    <li><img src="<?php echo $basePath; ?>assets/images/shopping-cart.png" alt="">Giỏ hàng</li>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>