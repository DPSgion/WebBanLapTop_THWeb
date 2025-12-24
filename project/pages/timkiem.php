<?php
// 1. Nhúng các file cấu hình và hàm chức năng
// Lưu ý: Dùng ".." để lùi ra khỏi thư mục pages
include("../includes/config.php");
include("../includes/functions.php");
$path = "..";
include("../includes/header.php");

// 2. Nhận dữ liệu từ URL 
// Sử dụng toán tử ?? null để tránh lỗi nếu không có tham số
$tuKhoa = $_GET['tuKhoa'] ?? null;
$hang = $_GET['hang'] ?? null;
$gia = $_GET['gia'] ?? null;
$ram = $_GET['ram'] ?? null;
$ocung = $_GET['ocung'] ?? null;
$vga = $_GET['vga'] ?? null;

// Gọi hàm tìm kiếm lấy danh sách sản phẩm
$dsKetQua = timKiemSanPham($pdo, $tuKhoa, $hang, $gia, $ram, $ocung, $vga);

// Xử lý tiêu đề hiển thị 
$tieuDe = "Toàn bộ sản phẩm"; // Mặc định

// Hiển thị tiêu đề
if ($tuKhoa)
    $tieuDe = "Tìm kiếm: " . htmlspecialchars($tuKhoa);
if ($hang)
    $tieuDe = "Laptop hãng " . htmlspecialchars($hang);
if ($gia) {
    if ($gia == 'duoi-15') {
        $tieuDe = "Mức giá: Dưới 15 triệu";
    } elseif ($gia == 'tren-20') {
        $tieuDe = "Mức giá: Trên 20 triệu";
    } else {
        // Trường hợp 15-20
        $tieuDe = "Mức giá: " . str_replace('-', ' - ', $gia) . " triệu";
    }
}
if ($ram)
    $tieuDe = "Laptop RAM " . htmlspecialchars($ram);
if ($ocung)
    $tieuDe = "Laptop ổ cứng " . htmlspecialchars($ocung);
if ($vga)
    $tieuDe = "Laptop có Card đồ họa " . htmlspecialchars(strtoupper($vga));
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?php echo $tieuDe; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Sử dụng lại index -->
    <div class="container">
        <!-- Bộ lọc -->
        <section class="filter-section">

            <div class="filter-header">
                <span class="filter-title-text">Bộ lọc tìm kiếm</span>
            </div>

            <div class="filter-list">


                <div class="filter-dropdown">
                    <div class="filter-btn">Giá <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="timkiem.php?gia=duoi-15">Dưới 15 triệu</a>
                        <a href="timkiem.php?gia=15-20">15 - 20 triệu</a>
                        <a href="timkiem.php?gia=tren-20">Trên 20 triệu</a>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn">RAM <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="timkiem.php?ram=8GB">8GB</a>
                        <a href="timkiem.php?ram=16GB">16GB</a>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn">Ổ cứng <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="timkiem.php?ocung=512GB">512GB</a>
                        <a href="timkiem.php?ocung=1TB">1TB</a>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <div class="filter-btn">Card đồ hoạ <span class="arrow-down">▼</span></div>
                    <div class="dropdown-content">
                        <a href="timkiem.php?vga=nvdia">NVIDIA</a>
                        <a href="timkiem.php?vga=amd">AMD</a>
                    </div>
                </div>

            </div>



        </section>

        <!-- Bộ lọc -->
        <section class="brands-section">
            <h3>Thương hiệu nổi bật</h3>
            <div class="brand-list">
                <div class="brand-item">
                    <a href="timkiem.php?hang=MacBook"><img src="../assets/images/logo_macbook.webp" alt="logo"></a>
                </div>
                <div class="brand-item">
                    <a href="timkiem.php?hang=Acer"><img src="../assets/images/logo_acer.png" alt="logo"></a>
                </div>
                <div class="brand-item">
                    <a href="timkiem.php?hang=Lenovo"><img src="../assets/images/logo_lenovo.png" alt="logo"></a>
                </div>
            </div>
        </section>

        <section class="category-section">

            <!-- Hiển thị Sản phẩm -->

            <div class="breadcrumb">
                <div class="breadcrumb-trai"> 
                    Đang lọc theo>  <b><?php echo $tieuDe; ?></b>
                </div>
                <div class="breadcrumb-phai">
                    <a href="timkiem.php">Hiển thị tất cả>></a>
                </div>
            </div>

            <div class="cat-view-all">(Tìm thấy <?php echo count($dsKetQua); ?> sản phẩm)</div>

            <section class="category-section">


                <div class="cat-body">

                    <?php if (count($dsKetQua) > 0): ?>
                        <div class="product-grid-5">
                            <?php foreach ($dsKetQua as $sp):
                                // Xử lý đường dẫn ảnh và link chi tiết
                                $imgURL = $path . "/assets/images/" . $sp['urlhinh'];
                                $linkSP = "chitietsanpham.php?id=" . $sp['masanpham'];
                                ?>

                                <div class="product-card">
                                    <a href="<?php echo $linkSP; ?>">
                                        <div class="cat-img-container">
                                            <img src="<?php echo $imgURL ?>" alt="Laptop">
                                        </div>

                                        <div class="p-name">
                                            <?php echo $sp['tensanpham']; ?>
                                        </div>

                                        <div class="p-specs">
                                            <?php echo $sp['cpu'] . " | " . $sp['vga']; ?>
                                        </div>

                                        <div class="p-price">
                                            <div class="p-price-current">
                                                <?php echo formatCurrency($sp['gia_thap_nhat']) ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php else: ?>
                        <div class="not-found-box" >
                            
                            <h3>Rất tiếc, không tìm thấy sản phẩm nào phù hợp!</h3>
                            <p>Vui lòng thử tìm sản phẩm khác hoặc quay lại trang chủ.</p>
                            <br>
                            <a href="../index.php" > << Quay lại trang chủ </a>
                        </div>
                    <?php endif; ?>

                </div>
            </section>

    </div>
</body>

</html>

<?php include("../includes/footer.php"); ?>