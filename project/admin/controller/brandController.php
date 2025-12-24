<?php

include("../../config/configDB.php");

function baoAlert($message){
    echo    "<script>
                window.location.href = '../admin.php?page=quanlythuonghieu';
                alert('". $message ."');
            </script>";
}

if (!isset($pdo)){
    baoAlert("Không kết nối được database");
    // die("\nKhông kết nối được db");
}

if (isset($_POST['btnThem'])){
    // Kiểm tra trùng
    $sql = "SELECT COUNT(*) FROM `thuong_hieu` WHERE tenthuonghieu=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['thuonghieu']]);
    if ($stmt->fetchColumn() > 0){
        baoAlert("Tên thương hiệu này đã tồn tại!");
        return;
    }


    // Thêm
    $sql = "insert into thuong_hieu (tenthuonghieu) values (?)";
    $stmt = $pdo->prepare($sql);

    try{
        if ($stmt->execute([$_POST['thuonghieu']])){
            header("Location: ../admin.php?page=quanlythuonghieu");
        }
        else{
            baoAlert("Thêm thương hiệu mới thất bại");
        }
    }
    catch (Exception $ex){
        echo "<script>
                console.error('". $ex->getMessage() ."');
            </script>";
    }
    
}

if (isset($_POST['btnCapNhat'])){
    
    if ($_POST['thuonghieu_cu'] != $_POST['thuonghieu']){

        // Kiểm tra trùng
        $sql = "SELECT COUNT(*) FROM `thuong_hieu` WHERE tenthuonghieu=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['thuonghieu']]);
        if ($stmt->fetchColumn() > 0){
            baoAlert("Tên thương hiệu này đã tồn tại!");
            return;
        }

        // Update
        $sql = "UPDATE `thuong_hieu` SET tenthuonghieu=? WHERE mathuonghieu=?";
        $stmt = $pdo->prepare($sql);
        
        try{
            if ($stmt->execute([$_POST['thuonghieu'], $_POST['mathuonghieu']])){
                header("Location: ../admin.php?page=quanlythuonghieu");
            }
            else{
                baoAlert("Cập nhật thương hiệu thất bại");
            }
        }
        catch (Exception $ex){
            echo "<script>
                    console.error('". $ex->getMessage() ."');
                </script>";
        }
    }
    else{
        header("Location: ../admin.php?page=quanlythuonghieu");
    }
}

// Đổi trạng thái
if (isset($_GET['doitrangthai'])){
    try{
        $mathuonghieu = $_GET['id'];
        $trangThaiHienTai = $_GET['trangthaihientai'];
        $trangThaiHienTai = ($trangThaiHienTai == 0) ? 1 : 0;

        $sql = "UPDATE `thuong_hieu` SET trangthai=? WHERE mathuonghieu=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$trangThaiHienTai, $mathuonghieu]);

        header("Location: ../admin.php?page=quanlythuonghieu");
    }
    catch (Exception $ex){
        echo "<script>
                console.error('". $ex->getMessage() ."');
            </script>";
    }
}

// Xóa thương hiệu
if (isset($_GET['xoathuonghieu'])){
    $mathuonghieu = $_GET['id'];
    $sql = "SELECT COUNT(*)
            FROM `san_pham` 
            WHERE mathuonghieu=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mathuonghieu]);

    $count = $stmt->fetchColumn();
    if ($count > 0){
        baoAlert("Không thể xóa! Thương hiệu này đang có $count sản phẩm.");
    }
    else{
        // Nếu bằng 0 thì mới tiến hành xóa
        $sqlDelete = "DELETE FROM thuong_hieu WHERE mathuonghieu=?";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([$mathuonghieu]);
        
        header("Location: ../admin.php?page=quanlythuonghieu");
    }
}