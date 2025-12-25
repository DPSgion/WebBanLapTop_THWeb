<?php
include("config/configDB.php");
include("includes/functions.php");
$path = "."; // File này nằm ngang hàng với thư mục assets
include("includes/header.php");

$dsNoiBat = getSanphamNoiBat($pdo);
$dsMoi = getSanphamMoi($pdo);



// 1. Lấy TẤT CẢ tham số từ URL
$tuKhoa = $_GET['tuKhoa'] ?? null;
$hang = $_GET['hang'] ?? null;
$gia = $_GET['gia'] ?? null;
$ram = $_GET['ram'] ?? null;
$ocung = $_GET['ocung'] ?? null; // Mới
$vga = $_GET['vga'] ?? null;   // Mới


// 2. Gọi hàm tìm kiếm với đầy đủ tham số
$dsKetQua = timKiemSanPham($pdo, $tuKhoa, $hang, $gia, $ram, $ocung, $vga);

// 3. Tạo tiêu đề trang động
$tieuDe = "Kết quả tìm kiếm";
if ($hang)
    $tieuDe = "Laptop hãng " . $hang;
if ($gia)
    $tieuDe = "Laptop theo mức giá";
if ($ram)
    $tieuDe = "Laptop RAM " . $ram;
if ($ocung)
    $tieuDe = "Laptop ổ cứng " . $ocung;
if ($vga)
    $tieuDe = "Laptop Card đồ họa " . strtoupper($vga);
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện Laptop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="container">

        <section class="hot-deal-section">
            <h2 class="section-title-hot"> SẢN PHẨM NỔI BẬT </h2>

            <div class="product-grid-5">

                <?php foreach ($dsNoiBat as $sp) {
                    // Hiển thị ảnh, tên ảnh trong folder phải giống url trong DB
                    $imgURL = $path . "/assets/images/" . $sp['urlhinh'];

                    // Để khi bấm vô laptop thì biết laptop nào được chọn
                    $linkSP = "pages/chitietsanpham.php?id=" . $sp['masanpham'];
                    ?>

                    <div class="product-card">
                        <a href="<?php echo $linkSP; ?>">
                            <div class="p-img">
                                <img src="<?php echo $imgURL; ?>" alt="Laptop">
                            </div>
                            <div class="p-specs"><?php echo $sp['cpu'] . " | " . $sp['vga'] ?></div>
                            <div class="p-name"><?php echo $sp['tensanpham'] ?></div>
                            <div class="p-price">
                                <div class="p-price-current"><?php echo formatCurrency($sp['gia_thap_nhat']) ?></div>

                            </div>
                        </a>
                    </div>

                <?php } ?>
            </div>
        </section>

        <!-- Bộ lọc -->
        <section class="filter-section">

            <div class="filter-header">
                <span class="filter-title-text">Bộ lọc tìm kiếm</span>
            </div>

            <div class="filter-list">


                <div class="filter-dropdown">
                    <div class="filter-btn">Giá <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="pages/timkiem.php?gia=duoi-15">Dưới 15 triệu</a>
                        <a href="pages/timkiem.php?gia=15-20">15 - 20 triệu</a>
                        <a href="pages/timkiem.php?gia=tren-20">Trên 20 triệu</a>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn">RAM <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="pages/timkiem.php?ram=8GB">8GB</a>
                        <a href="pages/timkiem.php?ram=16GB">16GB</a>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn">Ổ cứng <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="pages/timkiem.php?ocung=512GB">512GB</a>
                        <a href="pages/timkiem.php?ocung=1TB">1TB</a>
                    </div>
                </div>

                
            </div>

        </section>

        <!-- Bộ lọc -->
        <section class="brands-section">
            <h3>Thương hiệu nổi bật</h3>
            <div class="brand-list">
                <div class="brand-item">
                    <a href="pages/timkiem.php?hang=MacBook"><img src="assets/images/logo_macbook.webp" alt="logo"></a></div>
                <div class="brand-item">
                    <a href="pages/timkiem.php?hang=Acer"><img src="assets/images/logo_acer.png" alt="logo"></a></div>
                <div class="brand-item">
                    <a href="pages/timkiem.php?hang=Lenovo"><img src="assets/images/logo_lenovo.png" alt="logo"></a></div>
            </div>
        </section>

        <section class="category-section">


            <!-- Hiển thị toàn bộ laptop -->

            <div class="cat-body">
                <div class="product-grid-5">

                    <?php foreach ($dsMoi as $sp) {
                        $imgURL = $path . "/assets/images/" . $sp['urlhinh'];
                        $linkSP = "pages/chitietsanpham.php?id=" . $sp['masanpham'];
                        ?>

                        <div class="product-card">
                            <a href="<?php echo $linkSP; ?>">
                                <div class="cat-img-container">
                                    <img src="<?php echo $imgURL ?>" alt="Laptop">
                                </div>

                                <div class="p-name"><?php echo $sp['tensanpham'] . " | " . $sp['cpu'] . $sp['vga'] ?></div>
                                <div class="p-price">
                                    <div class="p-price-current"><?php echo formatCurrency($sp['gia_thap_nhat']) ?></div>

                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
        <!-- Laptop Gaming -->


    </div>
</body>

</html>

<?php
include("includes/footer.php");