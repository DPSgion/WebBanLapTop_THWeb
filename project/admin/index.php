<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style_admin.css">
    <title>Admin Page</title>
    
    <link rel="stylesheet" href="../assets/css/style_admin.css">
</head>

<body>
    <div class="header">
        <a class="header-left" href="admin.php">
            <img src="../assets/images/logolaptop.png" width="120px">
            <h1 class="header-logo">Admin</h1>
            
        </a>
        <div class="header-right">
            <p class="admin-name">Admin Name</p>
            <a href="logout.php" class="logout-btn">Đăng xuất</a>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="admin.php?page=quanlydanhmuc">Quản lý danh mục</a></li>
            <li><a href="">Quản lý sản phẩm</a></li>
            <li><a href="">Quản lý đơn hàng</a></li>
            <li><a href="">Cài đặt</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 'quanlydanhmuc';
        }

        switch ($page) {
            case 'quanlydanhmuc':
                include 'quanlydanhmuc.php';
                break;
            
            default:
                include 'quanlydanhmuc.php';
                break;
        }
        ?>
    </div>

</body>
</html>