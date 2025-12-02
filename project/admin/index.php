<?php

// Mặc định là 'dashboard'
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Danh sách các trang được phép load
$pages = [
    'dashboard' => 'dashboard.php'
];

// Kiểm tra nếu trang yêu cầu có trong danh sách thì lấy file đó, không thì về dashboard
$file_to_load = array_key_exists($page, $pages) ? $pages[$page] : 'dashboard.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - <?php echo ucfirst($page); ?></title>
    
    <link rel="stylesheet" href="../assets/css/style_admin.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <img src="../assets/images/logolaptop.png" width="120px">
            <h1 class="header-logo">Admin</h1>
        </div>
        <div class="header-right">
            <p class="admin-name">Admin Name</p>
            <a href="logout.php" class="logout-btn">Đăng xuất</a>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li>
                <a href="index.php?page=dashboard" 
                   class="<?php echo ($page == 'dashboard') ? 'active' : '' ?>">Dashboard</a>
            </li>
            <li>
                <a href="#">Quản lý sản phẩm</a>
            </li>
            <li>
                <a href="#">Quản lý đơn hàng</a>
            </li>
            <li>
                <a href="#">Cài đặt</a>
            </li>
        </ul>
    </div>

    <div class="content" id="content">
        <?php 
            // Kiểm tra file có tồn tại không trước khi include để tránh lỗi fatal error
            if (file_exists($file_to_load)) {
                include $file_to_load;
            } else {
                echo "<p>Lỗi: Không tìm thấy file <strong>$file_to_load</strong></p>";
            }
        ?>
    </div>

    <?php if ($page == 'dashboard') : ?>
        <script src="../assets/js/dashboard.js" defer></script> 
    <?php endif; ?>

    <?php if ($page == 'products') : ?>
        <?php endif; ?>

</body>
</html>