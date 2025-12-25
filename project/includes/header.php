<?php
// Kiểm tra session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Đảm bảo include function để lấy dữ liệu thông báo
include_once "functions.php"; 
?>

<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/style.css">

<div class="header">
  <div class="header-container">
    <section class="header-bar">
      <ul>
        
        <li>
          <a href="<?php echo $path; ?>/index.php">
            <img src="<?php echo $path; ?>/assets/images/logolaptop.png" alt="logo">
          </a>
        </li>

        <li>
          <form action="<?php echo $path; ?>/pages/timkiem.php" method="GET">
            <input type="search" name="tuKhoa" class="header-bar-search" placeholder="Nhập tên laptop..." required>
          </form>
        </li>

        <li>
          <?php if (isset($_SESSION['current_user'])): ?>
            
            <?php 
                // Lấy dữ liệu thông báo từ DB
                $user_id = $_SESSION['current_user']['userid'];
                $thongbao = getThongBaoDonHang($pdo, $user_id); 
                $so_luong = count($thongbao);
            ?>
            <!-- Form thông báo đơn hàng -->
            <div class="user-dropdown-container">
                
                <div class="user-trigger" onclick="toggleUserDropdown()">
                    <img src="<?php echo $path; ?>/assets/images/user.png" alt="" class="header-icon-user">
                    <span class="user-name">
                        <?php echo $_SESSION['current_user']['hoten']; ?>
                    </span>
                    <?php if($so_luong > 0): ?>
                        <span class="notif-badge"><?php echo $so_luong; ?></span>
                    <?php endif; ?>
                </div>

                <div id="userDropdownContent" class="dropdown-content">
                    <div class="dd-header">
                        <h4>Thông báo đơn hàng</h4>
                    </div>

                    <div class="dd-body">
                        <?php if ($so_luong > 0): ?>
                            <?php foreach ($thongbao as $tb): ?>
                                <a href="<?php echo $path; ?>/pages/chitiet_donhang.php?id=<?php echo $tb['madonhang']; ?>" class="dd-item">
                                    <div class="dd-icon">📦</div>
                                    <div class="dd-info">
                                        <p class="dd-text">
                                            <?php echo getNoiDungThongBao($tb['trangthai'], $tb['madonhang']); ?>
                                        </p>
                                        <span class="dd-time">
                                            <?php echo date("d/m/Y H:i", strtotime($tb['ngaydathang'])); ?>
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 15px; text-align: center; color: #999;">Không có đơn hàng mới</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="dd-footer">
                        <a href="<?php echo $path; ?>/pages/xuly_dangxuat.php" class="btn-logout">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            
            <a href="<?php echo $path; ?>/pages/dangnhap.php" class="user-login-link">
              <img src="<?php echo $path; ?>/assets/images/user.png" alt="" class="header-icon-user">
              <span>Đăng nhập</span>
            </a>

          <?php endif; ?>
        </li>

        <li>
          <a href="<?php echo $path; ?>/pages/giohang.php" class="cart-link">
            <img src="<?php echo $path; ?>/assets/images/shopping-cart.png" alt="" class="header-icon-cart">
            Giỏ hàng
          </a>
        </li>

      </ul>
    </section>
  </div>
</div>

<script>
    // 1. Hàm bật/tắt dropdown khi bấm vào tên user
    function toggleUserDropdown() {
        var dropdown = document.getElementById("userDropdownContent");
        
        // Kiểm tra xem đã lấy được thẻ đó chưa
        if (dropdown) {
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        } else {
            console.error("Không tìm thấy ID userDropdownContent");
        }
    }

    // 2. Hàm tự động đóng khi bấm ra ngoài
    window.onclick = function(event) {
        // Nếu cái được click KHÔNG nằm trong container .user-dropdown-container
        if (!event.target.closest('.user-dropdown-container')) {
            var dropdown = document.getElementById("userDropdownContent");
            if (dropdown && dropdown.style.display === "block") {
                dropdown.style.display = "none";
            }
        }
    }
</script>