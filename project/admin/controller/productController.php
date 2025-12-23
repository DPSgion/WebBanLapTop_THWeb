<?php

include("../../config/configDB.php");

if (isset($_POST['btn_add_product'])){
    $tenSanPham = $_POST['name'];
    $maThuongHieu = $_POST['brand_id'];
    $cpu = $_POST['cpu'];
    $vga = $_POST['vga'];
    $manHinh = $_POST['screen'];
    $pin = $_POST['battery'];

    $rams = $_POST['ram'];         
    $ocungs = $_POST['ssd'];       
    $giatiens = $_POST['price'];
    $soluongs = $_POST['quantity'];

    try {
        $pdo->beginTransaction();

        $sqlProduct = "INSERT INTO san_pham (mathuonghieu, tensanpham, cpu, vga, man_hinh, pin) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sqlProduct);
        $stmt->execute([
            $maThuongHieu,
            $tenSanPham,
            $cpu,
            $vga,
            $manHinh,
            $pin
        ]);

        $maSanPham = $pdo->lastInsertId();

        
        $sqlVariant = "INSERT INTO cau_hinh (masanpham, ram, ocung, giatien, soluong) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmtVar = $pdo->prepare($sqlVariant);

        for ($i = 0; $i < count($rams); $i++) {
            $stmtVar->execute([
                $maSanPham,
                $rams[$i],
                $ocungs[$i],
                $giatiens[$i],
                $soluongs[$i]
            ]);
        }


        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $sqlImg = "INSERT INTO hinh (masanpham, urlhinh) VALUES (?, ?)";
            $stmtImg = $pdo->prepare($sqlImg);

            $totalFiles = count($_FILES['images']['name']);
            $targetDir = "../../upload/";
            
            for ($i = 0; $i < $totalFiles; $i++) {
                $fileName = time() . "_" . basename($_FILES['images']['name'][$i]);
                $targetFilePath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFilePath)) {
                    $stmtImg->execute([
                        $maSanPham,
                        $fileName
                    ]);
                }
            }
        }

        // COMMIT
        $pdo->commit();
        echo "<script>
                window.location.href = '../admin.php?page=quanlysanpham';
            </script>";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Lỗi hệ thống: " . $e->getMessage();
    }
}