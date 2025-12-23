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

        $pdo->commit();
        echo "<script>
                window.location.href = '../admin.php?page=quanlysanpham';
            </script>";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Lỗi hệ thống: " . $e->getMessage();
    }
}

// Để lấy danh sách sản phẩm, biến thể và hình
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 1. Lấy thông tin chung
        $stmt = $pdo->prepare("SELECT * FROM san_pham WHERE masanpham = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Lấy danh sách cấu hình (biến thể)
        $stmtVar = $pdo->prepare("SELECT * FROM cau_hinh WHERE masanpham = ?");
        $stmtVar->execute([$id]);
        $variants = $stmtVar->fetchAll(PDO::FETCH_ASSOC);

        // 3. Lấy danh sách ảnh
        $stmtImg = $pdo->prepare("SELECT * FROM hinh WHERE masanpham = ?");
        $stmtImg->execute([$id]);
        $images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'product' => $product,
            'variants' => $variants,
            'images' => $images
        ]);
    } catch (Exception $e) {
        // Trả về lỗi JSON
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

// Cập nhật
if (isset($_POST['btn_update_product'])) {
    $maSanPham = $_POST['product_id'];
    
    // Lấy thông tin chung
    $tenSanPham = $_POST['name'];
    $maThuongHieu = $_POST['brand_id'];
    $cpu = $_POST['cpu'];
    $vga = $_POST['vga'];
    $manHinh = $_POST['screen'];
    $pin = $_POST['battery'];

    try {
        $pdo->beginTransaction();

        // CẬP NHẬT BẢNG SẢN PHẨM
        $sqlProd = "UPDATE san_pham SET mathuonghieu=?, tensanpham=?, cpu=?, vga=?, man_hinh=?, pin=? WHERE masanpham=?";
        $stmtProd = $pdo->prepare($sqlProd);
        $stmtProd->execute([$maThuongHieu, $tenSanPham, $cpu, $vga, $manHinh, $pin, $maSanPham]);

        // XỬ LÝ BIẾN THỂ (THÊM - SỬA - XÓA)
        // A. Lấy tất cả ID biến thể ĐANG CÓ trong database của sản phẩm này
        $stmtGetIds = $pdo->prepare("SELECT macauhinh FROM cau_hinh WHERE masanpham = ?");
        $stmtGetIds->execute([$maSanPham]);
        $dbVariantIds = $stmtGetIds->fetchAll(PDO::FETCH_COLUMN);

        // B. Lấy danh sách ID biến thể ĐƯỢC GỬI LÊN từ form
        // (Lọc bỏ các giá trị rỗng - vì rỗng là thêm mới)
        $formVariantIds = isset($_POST['variant_id']) ? array_filter($_POST['variant_id']) : []; 

        // C. Tìm ID cần XÓA: Có trong DB mà không có trong Form -> Xóa
        $idsToDelete = array_diff($dbVariantIds, $formVariantIds);

        if (!empty($idsToDelete)) {
            $idsString = implode(',', $idsToDelete); // Ví dụ: "2,3"
            $pdo->exec("DELETE FROM cau_hinh WHERE macauhinh IN ($idsString)");
        }

        // D. Vòng lặp Insert hoặc Update
        $rams = $_POST['ram'];
        $ssds = $_POST['ssd'];
        $prices = $_POST['price'];
        $quantities = $_POST['quantity'];
        $varIds = $_POST['variant_id'];

        $sqlInsertVar = "INSERT INTO cau_hinh (masanpham, ram, ocung, giatien, soluong) VALUES (?, ?, ?, ?, ?)";
        $sqlUpdateVar = "UPDATE cau_hinh SET ram=?, ocung=?, giatien=?, soluong=? WHERE macauhinh=?";
        
        $stmtInsertVar = $pdo->prepare($sqlInsertVar);
        $stmtUpdateVar = $pdo->prepare($sqlUpdateVar);

        for ($i = 0; $i < count($rams); $i++) {
            if (empty($varIds[$i])) {
                // Nếu ID rỗng -> THÊM MỚI
                $stmtInsertVar->execute([$maSanPham, $rams[$i], $ssds[$i], $prices[$i], $quantities[$i]]);
            } else {
                // Nếu có ID -> CẬP NHẬT
                if (in_array($varIds[$i], $formVariantIds)) {
                    $stmtUpdateVar->execute([$rams[$i], $ssds[$i], $prices[$i], $quantities[$i], $varIds[$i]]);
                }
            }
        }

        if (!empty($_POST['deleted_image_ids'])) {
            $idsToDelete = explode(',', $_POST['deleted_image_ids']);
            
            // Lặp qua từng ID để xóa file trong thư mục upload và xóa đường dẫn trong DB
            foreach ($idsToDelete as $imgId) {
                // Lấy tên file để xóa trong thư mục upload
                $stmtGetImg = $pdo->prepare("SELECT urlhinh FROM hinh WHERE mahinh = ?");
                $stmtGetImg->execute([$imgId]);
                $imgName = $stmtGetImg->fetchColumn();

                if ($imgName) {
                    $filePath = "../../upload/" . $imgName;
                    if (file_exists($filePath)) {
                        unlink($filePath); // Xóa file vật lý
                    }
                }

                // Xóa dòng trong database
                $stmtDelImg = $pdo->prepare("DELETE FROM hinh WHERE mahinh = ?");
                $stmtDelImg->execute([$imgId]);
            }
        }

        // XỬ LÝ ẢNH (CHỈ THÊM ẢNH MỚI, GIỮ ẢNH CŨ)
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $sqlImg = "INSERT INTO hinh (masanpham, urlhinh) VALUES (?, ?)";
            $stmtImg = $pdo->prepare($sqlImg);
            $targetDir = "../../upload/"; 

            for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                $fileName = time() . "_" . basename($_FILES['images']['name'][$i]);
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetDir . $fileName)) {
                    $stmtImg->execute([$maSanPham, $fileName]);
                }
            }
        }

        $pdo->commit();
        echo "<script>alert('Cập nhật thành công!'); window.location.href='../admin.php?page=quanlysanpham';</script>";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Lỗi Cập Nhật: " . $e->getMessage();
    }
}