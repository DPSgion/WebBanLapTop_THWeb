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