<?php 
// LƯU Ý: Nếu file này nằm trong thư mục 'pages' thì để $path = ".."; 
// Nếu nằm ngay thư mục gốc (ngang hàng index.php) thì để $path = ".";
$path = ".."; 
include "../includes/header.php"; 
?>

<div class="login-page-wrapper">
    <div class="login-card" style="max-width: 500px;"> <div class="login-header">
            <h3>Đăng ký tài khoản</h3>
            <p>Tạo tài khoản ngay để nhận ưu đãi và theo dõi đơn hàng dễ dàng.</p>
        </div>

        <form action="xuly_dangky.php" method="POST" class="login-form">
            
            <div class="form-group">
                <label for="hoten">Họ và tên</label>
                <input type="text" id="hoten" name="hoten" placeholder="Nhập họ tên của bạn..." required>
            </div>

            <div class="form-group">
                <label for="sdt">Số điện thoại</label>
                <input type="tel" id="sdt" name="sdt" placeholder="Nhập số điện thoại..." 
                        pattern="[0-9]{10,11}" title="Sai định dạng số điện thoại" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="matkhau" placeholder="Nhập mật khẩu..."
                    pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                    title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm cả chữ và số" required>
            </div>

            <div class="form-group">
                <label for="re-password">Nhập lại mật khẩu</label>
                <input type="password" id="re-password" name="re_matkhau" placeholder="Nhập lại mật khẩu..." required>
            </div>

            <div class="form-options" style="justify-content: flex-start; gap: 10px;">
                <input type="checkbox" required>
                <span>Tôi đồng ý với các điều khoản bảo mật cá nhân.</span>
            </div>

            <button type="submit" class="btn-login-submit">ĐĂNG KÝ NGAY</button>
        </form>
        <br>

        <div class="register-link">
               Bạn đã có tài khoản? <a href="dangky.php">Quay lại Đăng nhập</a>
                
            </a>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>