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
          <input type="search" class="header-bar-search" placeholder="Nhập tên laptop...">
        </li>

        <li>
          <?php if (isset($_SESSION['current_user'])): ?>
            <div style="display: flex; align-items: center; gap: 8px;">
              <img src="<?php echo $path; ?>/assets/images/user.png" alt="">

              <div style="display: flex; flex-direction: column;">
                <span style="font-weight: bold; font-size: 13px; color: white;">
                  <?php echo $_SESSION['current_user']['hoten']; ?>
                </span>

              </div>
            </div>

          <?php else: ?>
            <a href="<?php echo $path; ?>/pages/dangnhap.php"
              style="color: white; text-decoration: none; display: flex; align-items: center; gap: 5px;">
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