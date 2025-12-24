<?php
// Kiểm tra xem session đã được bật chưa, nếu chưa thì bật lên
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
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
            
              <img src="<?php echo $path; ?>/assets/images/user.png" alt="">

              <div >
                
                  <?php echo $_SESSION['current_user']['hoten']; ?>
               
                <a href="<?php echo $path; ?>/pages/dangxuat.php" style="font-size: 11px; color: #eee;">Đăng xuất</a>
              </div>
            </div>

          <?php else: ?>
            <a href="<?php echo $path; ?>/pages/dangnhap.php">
              <img src="<?php echo $path; ?>/assets/images/user.png" alt="">
                 Đăng nhập
            </a>
          <?php endif; ?>
        </li>

        <li>
          <a href="<?php echo $path; ?>/pages/giohang.php">
            <img src="<?php echo $path; ?>/assets/images/shopping-cart.png" alt="">
            Giỏ hàng
          </a>
        </li>
      </ul>
    </section>
  </div>
</div>