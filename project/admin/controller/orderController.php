<?php
include("../../config/configDB.php");

function baoAlert($message){
    echo "<script>
            alert('". $message ."');
            window.location.href = '../admin.php?page=quanlydonhang';
          </script>";
}

if (!isset($pdo)){
    baoAlert("Không kết nối được database");
    exit();
}

// CẬP NHẬT TRẠNG THÁI
if (isset($_POST['btnCapNhatTrangThai'])){
    try {
        $madonhang = $_POST['madonhang'];
        $trangthai_moi = $_POST['trangthai'];

        // Hủy hàng
        if ($trangthai_moi == 4) {
            
            // Lấy danh sách sản phẩm trong đơn hàng này
            $sqlGetItems = "SELECT macauhinh, soluongsanpham FROM chi_tiet_don_hang WHERE madonhang = ?";
            $stmtGetItems = $pdo->prepare($sqlGetItems);
            $stmtGetItems->execute([$madonhang]);
            $dsSanPham = $stmtGetItems->fetchAll(PDO::FETCH_ASSOC);

            // Duyệt từng sản phẩm và cộng lại số lượng vào kho
            foreach ($dsSanPham as $sp) {
                $maCH = $sp['macauhinh'];
                $slTraVe = $sp['soluongsanpham'];

                $sqlUpdateKho = "UPDATE cau_hinh SET soluong = soluong + ? WHERE macauhinh = ?";
                $stmtUpdateKho = $pdo->prepare($sqlUpdateKho);
                $stmtUpdateKho->execute([$slTraVe, $maCH]);
            }
        }

        $sql = "UPDATE don_hang SET trangthai = ? WHERE madonhang = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$trangthai_moi, $madonhang])) {
            header("Location: ../admin.php?page=quanlydonhang");
            exit();
        } else {
            baoAlert("Cập nhật trạng thái thất bại!");
        }

    } catch (Exception $ex) {
        baoAlert("Lỗi hệ thống: " . $ex->getMessage());
    }
}