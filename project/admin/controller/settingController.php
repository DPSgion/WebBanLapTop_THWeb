<?php

include("../../config/configDB.php");

function baoAlert($message){
    echo    "<script>
                window.location.href = '../admin.php?page=caidat';
                alert('". $message ."');
            </script>";
}

session_start();

if (isset($_POST['btnCapNhatSDT'])){
    if (isset($_SESSION['current_user'])) {
        
        $newSDT = $_POST['newSDT'];
        //Lấy User ID từ Session
        $userid = $_SESSION['current_user']['userid']; 

        $sqlSdtTonTai = "SELECT userid FROM user WHERE sdt = ? AND userid != ?";
        $stmtSdtTonTai = $pdo->prepare($sqlSdtTonTai);
        $stmtSdtTonTai->execute([$newSDT, $userid]);

        if ($stmtSdtTonTai->rowCount() > 0){
            baoAlert("SĐT bị trùng ! Hãy chọn SĐT khác");
            exit();
        }
        
        $sqlCapNhatSDT = "UPDATE user SET sdt=? WHERE userid=?";
        $stmtCapNhatSDT = $pdo->prepare($sqlCapNhatSDT);
        
        if($stmtCapNhatSDT->execute([$newSDT, $userid])) {
            // Cập nhật lại số điện thoại trong Session luôn
            // Nếu không làm bước này, người dùng phải đăng nhập lại mới thấy số mới
            $_SESSION['current_user']['sdt'] = $newSDT;

            echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href = '../admin.php?page=caidat';
                </script>";
        } else {
            echo "  <script>
                        alert('Lỗi cập nhật!');
                    </script>";
        }

    } else {
        echo "  <script>
                    alert('Vui lòng đăng nhập!'); 
                    window.location.href = '../pages/dangnhap.php';
                </script>";
    }
}