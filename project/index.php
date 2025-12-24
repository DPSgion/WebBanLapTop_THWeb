<?php
include("includes/config.php");
include("includes/functions.php");
$path = "."; // File này nằm ngang hàng với thư mục assets
include("includes/header.php");

$dsNoiBat= getSanphamNoiBat($pdo);
$dsMoi= getSanphamMoi($pdo);
$dsGaming= getSanphamGaming($pdo);
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

                <?php foreach($dsNoiBat as $sp){
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
                    <div class="p-specs"><?php echo $sp['cpu'] ." | " . $sp['vga']  ?></div>
                    <div class="p-name"  ><?php echo $sp['tensanpham']  ?></div>
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
                <div class="filter-btn">Hãng <span class="arrow-down">▼</span></div>
                <div class="filter-btn">Giá <span class="arrow-down">▼</span></div>
                <div class="filter-btn">RAM <span class="arrow-down">▼</span></div>
                <div class="filter-btn">Ổ cứng <span class="arrow-down">▼</span></div>
  
            </div>

            <div class="quick-filter-list">
                <div class="quick-tag">Laptop Gaming</div>
                <div class="quick-tag">Laptop Văn phòng</div>

            </div>
        </section>

             <!-- Bộ lọc -->
        <section class="brands-section">
            <h3>Thương hiệu nổi bật</h3>
            <div class="brand-list">
                <div class="brand-item"><img src="assets/images/logo_macbook.webp" alt="logo"></div>
                <div class="brand-item"><img src="assets/images/logo_acer.png" alt="logo"></div>
                <div class="brand-item"><img src="assets/images/logo_lenovo.png" alt="logo"></div>
            </div>
        </section>

        <section class="category-section">
            <div class="cat-header" style="border-bottom-color: #d70018;">
        
                <div class="cat-title">LAPTOP MỚI</div>
                <div class="cat-nav">
                    <a href="#">LAPTOP ACER MỚI</a>
                    <a href="#">LAPTOP LENOVO MỚI</a>
                    <a href="#">LAPTOP MACBOOK MỚI</a>
                </div>
                <div class="cat-view-all">Xem tất cả ></div>
            </div>

                    <!-- Laptop mới -->

            <div class="cat-body">
                <div class="product-grid-5">
                                
                <?php foreach($dsMoi as $sp){
                    $imgURL = $path . "/assets/images/" . $sp['urlhinh'];
                    $linkSP = "pages/chitietsanpham.php?id=" . $sp['masanpham'];
                 ?>

                    <div class="product-card">
                        <a href="<?php echo $linkSP; ?>">
                            <div class="cat-img-container">
                                <img src="<?php echo $imgURL ?>" alt="Laptop">
                            </div>
                    
                            <div class="p-name"><?php echo $sp['tensanpham']?></div>
                            <div class="p-price">
                                <div class="p-price-current"><?php echo formatCurrency( $sp['gia_thap_nhat'])?></div>
                            
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                
            </div>
        </section>

        <!-- Laptop Gaming -->

        <section class="category-section">
            <div class="cat-header" style="border-bottom-color: #d70018;">
                <div class="cat-title" style="background: #ce0000;">GAMING</div>
                <div class="cat-nav">
                    <a href="#">ACER GAMING</a>
                    <a href="#">LENOVO GAMING</a>
                </div>
                <div class="cat-view-all">Xem tất cả ></div>
            </div>

            <div class="cat-body">
                <div class="product-grid-5">
                      <?php foreach($dsGaming as $sp){
                            $imgURL = $path . "/assets/images/" . $sp['urlhinh'];
                            $linkSP = "pages/chitietsanpham.php?id=" . $sp['masanpham'];
                        ?>
                    <div class="product-card"> 
                        <a href="<?php echo $linkSP ?>">    
 
                            <div class="cat-img-container">
                                <img src="<?php echo $imgURL?>" alt="Laptop">
                            </div>
                            <div class="p-name"><?php echo $sp['tensanpham'] ?></div>
                            <div class="p-price">
                                <div class="p-price-current"><?php echo formatCurrency($sp['gia_thap_nhat']) ?></div>
                            </div>
                        </a>
                    </div>

                    <?php } ?>

                </div>
            </div>
        </section>
    </div>
</body>

</html>

<?php
include("includes/footer.php");