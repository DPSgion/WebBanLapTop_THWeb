<div class="main-title">
    <h2>Cài Đặt</h2>
</div>

<div class="doi-email">
    <h2 >Đổi Số điện thoại</h2>
    <form action="controller/settingController.php" method="post">
        <div class="form-group">
            <label>Nhập số điện thoại mới:</label>
            <input type="tel" name="newSDT" placeholder="Nhập số điện thoại mới" 
                        pattern="[0-9]{10,11}" title="Sai định dạng số điện thoại" maxlength="11" required>
        </div>

        <div class="form-actions">
            <input type="submit" name="btnCapNhatSDT" value="Lưu lại" class="btn btn-primary">
        </div>
    </form>

</div>

<div class="doi-matkhau">
    <h2 >Đổi Mật Khẩu</h2>
    <form action="controller/settingController.php" method="post">
        
        <div class="form-group">
            <label>Nhập mật khẩu mới:</label>
            <input type="password" name="newPassword" placeholder="Nhập mật khẩu mới"
                    pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                    title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm cả chữ và số" required>
        </div>
        
        <div class="form-group">
            <label>Nhập lại mật khẩu mới:</label>
            <input type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu" required>
            
        </div>

        <div class="form-actions">
            <input type="submit" name="btnCapNhatMK" value="Lưu lại" class="btn btn-primary">
        </div>
    </form>
</div>