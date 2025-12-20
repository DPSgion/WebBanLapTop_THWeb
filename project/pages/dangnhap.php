<?php 
// Khai báo biến path để tránh lỗi đường dẫn (nếu bạn đã áp dụng cách fix ở câu trước)
$path = ".."; 
include "../includes/header.php"; 
?>

<div class="login-page-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h3>Đăng nhập</h3>
            <p>Vui lòng đăng nhập để mua laptop siu xịn xò</p>
        </div>

        <form action="xuly_dangnhap.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Số điện thoại</label>
                <input type="tel" id="username" name="username" placeholder="Nhập số điện thoại... " 
                     pattern="[0-9]{10,11}" title="Sai định dạng số điện thoại" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
                <a href="#" class="forgot-password">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn-login-submit">ĐĂNG NHẬP</button>
        </form>

  
        <br>
        <div class="register-link">
            Bạn chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a>
        </div>
    </div>
</div>

<?php
include "../includes/footer.php"; 
?>