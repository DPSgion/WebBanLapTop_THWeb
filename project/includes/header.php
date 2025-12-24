<?php
// Kiểm tra session
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
            
            <div class="user-logged-in">
              <img src="<?php echo $path; ?>/assets/images/user.png" alt="" class="header-icon-user">
              
              <div class="user-info-box">
                <span class="user-name">
                  <?php echo $_SESSION['current_user']['hoten']; ?>
                </span>
                <a href="<?php echo $path; ?>/pages/xuly_dangxuat.php" class="logout-link">(Đăng xuất)</a>
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